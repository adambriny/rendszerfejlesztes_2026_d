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
        header("location: login_student.php");
        exit();
    }
// Ellenőrzés: csak bejelentkezett tanár érheti el ezt az oldalt
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "teacher") {
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oktatói Vezérlőpult - Oktatási Portál</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            background: linear-gradient(135deg, rgba(15, 14, 15, 0.7) 0%, rgba(121, 13, 112, 0.7) 100%), 
                        url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-blend-mode: luminosity;
            background-size: cover;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(200, 200, 200, 0.25);
            backdrop-filter: grayscale(60%) contrast(85%);
            pointer-events: none;
            z-index: -1;
        }
        header {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(11, 28, 44, 0.85);
            backdrop-filter: blur(10px);
        }
        .logo-area {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #ffb703;
        }
        .user-info {
            font-size: 14px;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logout-btn {
            background-color: #dc2626;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .logout-btn:hover {
            background-color: #b91c1c;
        }
        .main-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
            flex: 1;
            width: 100%;
        }
        h1 {
            font-size: 32px;
            margin-bottom: 8px;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        p.subtitle {
            font-size: 15px;
            color: #cbd5e1;
            margin-bottom: 30px;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }
        .card {
            background: rgba(18, 30, 49, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            border-color: #ffb703;
        }
        .card h3 {
            font-size: 20px;
            color: #ffb703;
            margin-bottom: 10px;
        }
        .card p {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .card-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ffb703;
            color: #0b1c2c;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            border-radius: 6px;
            transition: background-color 0.2s;
        }
        .card-btn:hover {
            background-color: #ffca28;
        }
        footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #64748b;
            background: rgba(11, 28, 44, 0.9);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-area">Oktatói Vezérlőpult</div>
        <div class="user-info">
            <span>Üdvözöljük, <strong><?php echo htmlspecialchars($_SESSION["user"]["display_name"]); ?></strong>!</span>
            <a href="login_teacher.php?logout=true" class="logout-btn">Kijelentkezés</a>
        </div>
    </header>

    <div class="main-container">
        <h1>Oktatói Adminisztráció</h1>
        <p class="subtitle">Itt kezelheti a kurzusait, hallgatóit és a tananyagokat.</p>

        <div class="dashboard-grid">
            <!-- 1. Kártya -->
            <div class="card">
                <h3>Kurzusok Kezelése</h3>
                <p>Hozzon létre új kurzusokat, szerkessze a meglévő tantárgyakat és segédanyagokat.</p>
                <a href="#" class="card-btn">Kurzusok megtekintése</a>
            </div>

            <!-- 2. Kártya -->
            <div class="card">
                <h3>Hallgatók Listája</h3>
                <p>Tekintse meg a kurzusaira jelentkezett diákokat és ellenőrizze a haladásukat.</p>
                <a href="#" class="card-btn">Hallgatók listája</a>
            </div>

            <!-- 3. Kártya -->
            <div class="card">
                <h3>Feladatok & Értékelés</h3>
                <p>Adjon fel új házi feladatokat, projekteket és értékelje a beadott munkákat.</p>
                <a href="#" class="card-btn">Feladatok kezelése</a>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2026 Minden jog fenntartva. | Oktatási Portál
    </footer>

</body>
</html>