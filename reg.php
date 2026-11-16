<?php
    $error = "";
    $msg = "";
    require_once("dbconnect.php");  
    class UserException extends Exception {};

    if (!empty($dbConn) && $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submitReg"])){
        try {
            $username = htmlspecialchars(trim($_POST["username"]));
            $displayName = htmlspecialchars(trim($_POST["displayName"]));
            $email = htmlspecialchars(trim($_POST["email"]));
            $pw = trim($_POST["password"]);
            $pw2 = trim($_POST["password2"]);
            $role = $_POST["role"] ?? "student";

            if (empty($username) || empty($displayName) || empty($email) || empty($pw) || empty($pw2)){
                throw new UserException("Minden adatot kötelező megadni!");
            }
            if ($pw !== $pw2){
                throw new UserException("A két jelszó nem egyezik!");
            }
            $allowed_roles = ['student', 'teacher'];
            if (!in_array($role, $allowed_roles)){
                throw new UserException("Érvénytelen szerepkör!");
            }

            $sqlReg = "INSERT INTO users (username, display_name, email, password, role) VALUES (:username, :display_name, :email, :password, :role)";
            $queryReg = $dbConn->prepare($sqlReg);
            $queryReg->bindValue("username", $username, PDO::PARAM_STR);
            $queryReg->bindValue("display_name", $displayName, PDO::PARAM_STR);
            $queryReg->bindValue("email", $email, PDO::PARAM_STR);
            
            $pwhash = password_hash($pw, PASSWORD_DEFAULT);     
            $queryReg->bindValue("password", $pwhash, PDO::PARAM_STR);
            
            $queryReg->bindValue("role", $role, PDO::PARAM_STR);
            $queryReg->execute();

            $msg = "Sikeres regisztráció! Most már <a href='login_student.php' style='color:#38bdf8;'>bejelentkezhetsz</a>.";
        } 
        catch (UserException $e){
            $error = "Regisztrációs hiba: {$e->getMessage()}";
        }
        catch (PDOException $e){
            if ($e->errorInfo[1] == 1062) {
                $error = "Adatbázis hiba: A felhasználónév vagy az e-mail cím már foglalt.";
            } else {
                $error = "Adatbázis mentési hiba: {$e->getMessage()}";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 320px;
        }
        label, input[type=submit] {
            display: block;
            margin-top: 10px;
            width: 100%;
        }
        input[type=text], input[type=password], input[type=email] {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error, .msg {
            margin-bottom: 15px;
            border-radius: 6px;
            padding: 12px;
            width: 340px;
            text-align: center;
            box-sizing: border-box;
        }
        .error {
            background-color: #ffe6e6;
            color: #cc0000;
            border: 1px solid #ff9999;
        }
        .msg {
            background-color: #e6ffed;
            color: #006622;
            border: 1px solid #99ffbb;
        }
        .radio-group {
            display: flex;
            gap: 15px;
            margin-top: 8px;
        }
        .radio-group label {
            display: inline;
            width: auto;
            font-weight: normal;
        }
        .link-text {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <?= !empty($error) ? "<p class=\"error\">$error</p>\n" : ""; ?>
    <?= !empty($msg) ? "<p class=\"msg\">$msg</p>\n" : ""; ?>

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <fieldset>
            <legend>Regisztráció</legend>
            
            <label for="usernameReg">Felhasználónév</label>
            <input type="text" name="username" id="usernameReg" required>

            <label for="displayNameReg">Megjelenítendő név</label>
            <input type="text" name="displayName" id="displayNameReg" required>

            <label for="emailReg">E-mail cím</label>
            <input type="email" name="email" id="emailReg" required>

            <label for="passwordReg">Jelszó</label>
            <input type="password" name="password" id="passwordReg" required>

            <label for="password2Reg">Jelszó újra</label>
            <input type="password" name="password2" id="password2Reg" required>

            <label>Regisztráció mint:</label>
            <div class="radio-group">
                <label><input type="radio" name="role" value="student" checked> Diák</label>
                <label><input type="radio" name="role" value="teacher"> Tanár</label>
            </div>

            <input type="submit" value="Regisztráció" name="submitReg">
        </fieldset>
        <div class="link-text">
            Már van fiókod? <a href="login.php">Bejelentkezés</a>
        </div>
    </form>
</body>
</html>