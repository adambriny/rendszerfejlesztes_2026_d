<?php
    session_start();
    require_once("dbconnect.php");

    // Ha már be van jelentkezve, irányítsuk a megfelelő dashboardra
    if (isset($_SESSION["user"])){
        if ($_SESSION["user"]["role"] === "teacher") {
            header("location: teacher_dashboard.php");
        } else {
            header("location: student_dashboard.php");
        }
        exit();
    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üdvözöljük</title>
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
            background-blend-mode: luminosity; /* Desaturates the image */
            background-size: cover;
            color: #312e41;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Extra washed-out mist overlay layer */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(22, 48, 88, 0.25); /* Opacity overlay */
            backdrop-filter: grayscale(60%) contrast(85%); /* Desaturation */
            pointer-events: none; /* Allows clicking through it */
            z-index: -1;
        }
        header {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(11, 28, 44, 0.8);
            backdrop-filter: blur(10px);
        }
        .logo-area {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #ffb703;
        }
        .main-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
            text-align: center;
            flex: 1;
        }
        h1 {
            font-size: 38px;
            margin-bottom: 10px;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        p.subtitle {
            font-size: 16px;
            color: #cbd5e1;
            margin-bottom: 40px;
        }
        /* Grid a két felső kártyához */
        .cards-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        /* Kártya stílusok (Brackets) */
        .portal-card {
            background: rgba(18, 30, 49, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 35px 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            transition: transform 0.3s ease, border-color 0.3s ease;
            text-align: left;
        }
        .portal-card:hover {
            transform: translateY(-5px);
            border-color: #ffb703;
        }
        .portal-card h2 {
            font-size: 22px;
            color: #ffb703;
            margin-bottom: 12px;
        }
        .portal-card p {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        /* Teljes szélességű alsó kártya a regisztrációhoz */
        .reg-card {
            background: rgba(18, 30, 49, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 25px 20px; /* Reduced inner padding slightly */
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            text-align: center;
            transition: transform 0.3s ease, border-color 0.3s ease;
            max-width: 700px; /* Controls how wide the card can get */
            margin: 0 auto;    /* Centers the card horizontally */
        }
        .reg-card:hover {
            transform: translateY(-3px);
            border-color: #38bdf8;
        }
        .reg-card h2 {
            font-size: 20px;
            color: #38bdf8;
            margin-bottom: 8px;
        }
        .reg-card p {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 20px;
        }
        /* Gombok */
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #ffb703;
            color: #0b1c2c;
            text-decoration: none;
            font-weight: bold;
            border-radius: 6px;
            transition: background-color 0.2s, box-shadow 0.2s;
            text-align: center;
            width: 100%;
        }
        .btn:hover {
            background-color: #ffca28;
            box-shadow: 0 0 15px rgba(255, 183, 3, 0.4);
        }
        .btn-reg {
            background-color: #38bdf8;
            color: #0b1c2c;
            width: auto;
            padding: 10px 40px;
        }
        .btn-reg:hover {
            background-color: #7dd3fc;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.4);
        }
        footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #64748b;
            background: rgba(11, 28, 44, 0.9);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        @media (max-width: 768px) {
            .cards-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-area">Magántanár kereső.hu</div>
        <div style="font-size: 14px; color: #cbd5e1;">Oktatási Portál</div>
    </header>

    <div class="main-container">
        <h1>Üdvözöljük a rendszerben!</h1>
        <p class="subtitle">Kérjük, válassza ki a bejelentkezési típust, vagy regisztráljon új fiókot.</p>

        <!-- Két felső kártya (Diák és Tanár bejelentkezés külön fájlokra irányítva) -->
        <div class="cards-grid">
            <!-- Diák Bejelentkezés kártya -->
            <div class="portal-card">
                <h2>Hallgatói / Diák Bejelentkezés</h2>
                <p>Belépés a hallgatói fiókba kurzusok, anyagok és feladatok eléréséhez.</p>
                <a href="login_student.php" class="btn">Diák Belépés</a>
            </div>

            <!-- Tanár Bejelentkezés kártya -->
            <div class="portal-card">
                <h2>Oktatói / Tanár Bejelentkezés</h2>
                <p>Belépés az oktatói adminisztrációs felületre és kezelőfelületre.</p>
                <a href="login_teacher.php" class="btn">Tanár Belépés</a>
            </div>
        </div>

        <!-- Alsó kártya a regisztrációhoz -->
        <div class="reg-card">
            <h2>Még nincs fiókja?</h2>
            <p>Hozzon létre új diák vagy tanár fiókot néhány egyszerű lépésben.</p>
            <a href="reg.php" class="btn btn-reg">Regisztráció</a>
        </div>
    </div>

    <footer>
        &copy; 2026 Minden jog fenntartva. | Adatbázis alapú rendszer
    </footer>

</body>
</html>