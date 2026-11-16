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

// Ellenőrzés: csak bejelentkezett diák érheti el ezt az oldalt
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "student") {
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hallgatói Vezérlőpult - Oktatási Portál</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0b1c2c 0%, #132f4c 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        header {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(18, 30, 49, 0.85);
            backdrop-filter: blur(10px);
        }
        .logo-area {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #38bdf8;
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
            border-color: #38bdf8;
        }
        .card h3 {
            font-size: 20px;
            color: #38bdf8;
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
            background-color: #38bdf8;
            color: #0b1c2c;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            border-radius: 6px;
            transition: background-color 0.2s;
        }
        .card-btn:hover {
            background-color: #7dd3fc;
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
        <div class="logo-area">Hallgatói Vezérlőpult</div>
        <div class="user-info">
            <span>Üdvözöljük, <strong><?php echo htmlspecialchars($_SESSION["user"]["display_name"]); ?></strong>!</span>
            <a href="login_student.php?logout=true" class="logout-btn">Kijelentkezés</a>
        </div>
    </header>

    <div class="main-container">
        <h1>Diák Főoldal</h1>
        <p class="subtitle">Tekintsd meg a feladataidat, kurzusaidat és a tananyagokat.</p>

        <div class="dashboard-grid">
            <!-- 1. Kártya -->
            <div class="card">
                <h3>Kurzusaim</h3>
                <p>Itt érheted el az általad felvett tantárgyakat és a kapcsolódó anyagokat.</p>
                <a href="#" class="card-btn">Kurzusok megtekintése</a>
            </div>

            <!-- 2. Kártya -->
            <div class="card">
                <h3>Házi Feladatok</h3>
                <p>Ellenőrizd a határidőket, és add le az elkészült feladataidat.</p>
                <a href="#" class="card-btn">Feladatok listája</a>
            </div>

            <!-- 3. Kártya -->
            <div class="card">
                <h3>Eredmények & Jegyek</h3>
                <p>Kövesd nyomon a tanulmányi előmeneteledet és az érdemjegyeidet.</p>
                <a href="#" class="card-btn">Jegyek megtekintése</a>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2026 Minden jog fenntartva. | Oktatási Portál
    </footer>

</body>
</html>