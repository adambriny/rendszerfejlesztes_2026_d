<?php
    $error = "";
    require_once("dbconnect.php");  
    class UserException extends Exception {};

    session_start();    
    
    // Kijelentkezés kezelése
    if ($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["logout"])){   
        unset($_SESSION["user"]);   
        unset($_COOKIE["userId"]);  
        setcookie("userId","",time()-1);    
    }

    // Automatikus bejelentkeztetés Cookie alapján (csak diákoknak)
    if (!empty($dbConn) && !empty($_COOKIE["userId"])){     
        try {
            $sqlCookie = "SELECT id, username, display_name, role FROM users WHERE id=:userId AND role='student'";
            $queryCookie = $dbConn->prepare($sqlCookie);
            $queryCookie->bindValue("userId", $_COOKIE["userId"], PDO::PARAM_INT);
            $queryCookie->execute();
            if ($queryCookie->rowCount() == 1){
                $user = $queryCookie->fetch(PDO::FETCH_ASSOC);
                $_SESSION["user"] = [
                    "id" => $user["id"], 
                    "username" => $user["username"], 
                    "display_name" => $user["display_name"],
                    "role" => $user["role"]
                ];
                header("location: student_dashboard.php");
                exit();
            }
        } catch (PDOException $e) {
            // Nem kritikus hiba cookie ellenőrzéskor
        }
    }

    if (isset($_SESSION["user"])){  
        if ($_SESSION["user"]["role"] === "student") {
            header("location: student_dashboard.php");
            exit();
        }
    }

    // BEJELENTKEZÉS FELDOLGOZÁSA
    if (!empty($dbConn) && $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submitLogin"])){
        try {
            $username = htmlspecialchars(trim($_POST["username"]));
            $password = trim($_POST["password"]);

            if (empty($username) || empty($password)){
               throw new UserException("Minden adat megadása kötelező!");
            }
            
            $sqlUser = "SELECT id, username, display_name, email, password, role FROM users WHERE username=:username";
            $queryUser = $dbConn->prepare($sqlUser);
            $queryUser->bindValue("username", $username, PDO::PARAM_STR);
            $queryUser->execute();
            
            if ($queryUser->rowCount() != 1){
                throw new UserException("Hibás felhasználónév!");
            }
            
            $user = $queryUser->fetch(PDO::FETCH_ASSOC);
            
            if (!password_verify($password, $user["password"])){    
                throw new UserException("Hibás jelszó!");
            }

            // SZIGORÚ ELLENŐRZÉS: Csak diák léphet be itt
            if ($user["role"] !== "student") {
                throw new UserException("Ez a felület csak hallgatók számára érhető el. Kérjük, használd a tanári bejelentkezést!");
            }

            session_regenerate_id(true);    
            $_SESSION["user"] = [
                "id" => $user["id"], 
                "username" => $user["username"], 
                "display_name" => $user["display_name"],
                "role" => $user["role"]
            ];    

            if (isset($_POST["rememberMe"])){   
                setcookie("userId", $user["id"], time() + (86400 * 30)); 
            }

            header("location: student_dashboard.php");
            exit();
        }
        catch (UserException $e){
            $error = "Bejelentkezési hiba: {$e->getMessage()}";
        }
        catch (PDOException $e){
            $error = "Adatbázis lekérdezési hiba: {$e->getMessage()}";
        }
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hallgatói Bejelentkezés - Oktatási Portál</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0b1c2c 0%, #132f4c 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .form-card {
            background: rgba(18, 30, 49, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            width: 100%;
            max-width: 380px;
        }
        fieldset { border: none; }
        legend {
            font-size: 22px;
            font-weight: bold;
            color: #38bdf8;
            margin-bottom: 20px;
            text-align: center;
            width: 100%;
        }
        label {
            display: block;
            margin-top: 12px;
            font-size: 14px;
            color: #cbd5e1;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            color: #fff;
            box-sizing: border-box;
            font-size: 14px;
        }
        input[type=text]:focus, input[type=password]:focus {
            outline: none;
            border-color: #38bdf8;
        }
        input[type=submit] {
            display: block;
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #38bdf8;
            color: #0b1c2c;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        input[type=submit]:hover { background-color: #7dd3fc; }
        .error {
            margin-bottom: 20px;
            border-radius: 6px;
            padding: 12px;
            width: 100%;
            max-width: 380px;
            text-align: center;
            background-color: rgba(220, 38, 38, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(248, 113, 113, 0.4);
            font-size: 14px;
        }
        .link-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #94a3b8;
        }
        .link-text a { color: #38bdf8; text-decoration: none; }
        .link-text a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <?= !empty($error) ? "<div class=\"error\">$error</div>\n" : ""; ?>

    <div class="form-card">
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <fieldset>
                <legend>Hallgatói Bejelentkezés</legend>
                
                <label for="usernameLogin">Felhasználónév</label>
                <input type="text" name="username" id="usernameLogin" required>

                <label for="passwordLogin">Jelszó</label>
                <input type="password" name="password" id="passwordLogin" required>

                <label style="display: flex; align-items: center; gap: 8px; margin-top: 15px; color: #cbd5e1; cursor: pointer;">
                    <input type="checkbox" name="rememberMe" id="rem" style="width: auto; margin: 0;"> Emlékezz rám
                </label>

                <input type="submit" value="Bejelentkezés" name="submitLogin">
            </fieldset>
        </form>
        <div class="link-text">
            Még nincs fiókod? <a href="reg.php">Regisztráció</a>
        </div>
        <div class="link-text" style="margin-top: 10px;">
            <a href="index.php">&larr; Vissza a főoldalra</a>
        </div>
    </div>
</body>
</html>
