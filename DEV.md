# Fejlesztői útmutató (Developer Guide)

## 1. A projekt áttekintése

A projekt egy PHP-alapú webalkalmazás, amely egy magántanár-kereső és oktatási felület alapjait valósítja meg. A rendszer külön bejelentkezési felületet biztosít a diákoknak és a tanároknak, lehetővé teszi a regisztrációt, és szerepkörönként eltérő vezérlőpultot jelenít meg.

A felhasznált technológiák:

- **PHP:** szerveroldali feldolgozás és bejelentkezési logika.
- **MySQL:** felhasználói adatok tárolása.
- **PDO:** PHP és az adatbázis közötti kapcsolat.
- **HTML és CSS:** a felhasználói felület megjelenítése.
- **XAMPP:** a webalkalmazás helyi futtatása.

## 2. Előfeltételek

A projekt helyi futtatásához a következők szükségesek:

- **XAMPP:** https://www.apachefriends.org/
- Egy webböngésző.
- Egy kódszerkesztő, például **Visual Studio Code** (fejlesztéshez).

A XAMPP tartalmazza az **Apache** webszervert, a **MySQL/MariaDB** adatbázis-szolgáltatást és a **phpMyAdmin** adatbázis-kezelő felületet.

## 3. Helyi környezet beállítása

### 3.1. XAMPP telepítése és indítása

1. Töltsük le és telepítsük a XAMPP alkalmazást a hivatalos weboldalról.
2. Nyissuk meg a **XAMPP Control Panel** alkalmazást.
3. Az **Apache** sorában kattintsunk a **Start** gombra.
4. A **MySQL** sorában is kattintsunk a **Start** gombra.

A webalkalmazás használata közben mindkét szolgáltatásnak futnia kell:

- Az **Apache** futtatja és kiszolgálja a PHP-weboldalt.
- A **MySQL** biztosítja az adatbázis működését.

### 3.2. A projekt elhelyezése

1. Keressük meg a XAMPP telepítési könyvtárát.
2. Nyissuk meg a `htdocs` mappát, amely Windows rendszeren alapértelmezetten a `C:\xampp\htdocs` útvonalon található.
3. Másoljuk vagy klónozzuk a projektet ebbe a mappába, pl.:  `C:\xampp\htdocs\Website`


A PHP-fájlok relatív elérési útjait meg kell őrizni, vagy mappák átrendezése esetén frissíteni kell a hivatkozásokat és a `require_once()` utasításokat.

### 3.3. Az adatbázis létrehozása a phpMyAdmin felületén

1. Ellenőrizzük, hogy az Apache és a MySQL fut-e a XAMPP-ban.
2. Böngészőben nyissuk meg a következő címet: `http://localhost/phpmyadmin`

3. Hozzunk létre egy `adatbazis` nevű adatbázist.
4. Amennyiben rendelkezésre áll a projekt SQL-exportfájlja, válasszuk ki az adatbázist, majd az **Importálás (Import)** menüponttal töltsük be.

A jelenlegi PHP-kód a `users` táblát használja, többek között az alábbi mezőkkel: `id`, `username`, `display_name`, `email`, `password`, `role`.

> **Fontos:**  Maga az adatbázis a MySQL-szolgáltatásban fut. Az SQL-exportfájl pontos neve és az adatbázis teljes sémája még dokumentálandó.

## 4. Adatbázis-kapcsolat beállítása

Az adatbázis-kapcsolat paramétereit a `config.php` fájl határozza meg. A helyi XAMPP-fejlesztői környezethez tartozó *példaértékek*:

```php
define("DBTYPE", "mysql");
define("DBHOST", "localhost");
define("DBNAME", "adatbazis");
define("DBCHARSET", "utf8");
define("DBUSER", "root");
define("DBPASSWORD", "");
```

A `dbconnect.php` betölti a konfigurációt, majd PDO-kapcsolatot létesít az adatbázissal. Az adatbázishibák kezeléséhez kivételkezelést használ.

Ha a helyi adatbázis neve, felhasználóneve vagy jelszava eltér, a helyi konfigurációt ennek megfelelően kell módosítani.

**Biztonság:** valódi adatbázis-jelszavakat, API-kulcsok nyilvánosságra hozatala tilos.

## 5. A webalkalmazás helyi futtatása

1. Indítsuk el az **Apache** és **MySQL** szolgáltatásokat a XAMPP Control Panelben.
2. Ellenőrizzük a `http://localhost/phpmyadmin/` oldalon, hogy létezik-e az `adatbazis` nevű adatbázis és rendelkezik-e a szükséges táblákkal.
3. Nyissuk meg a böngészőben a projekt címét: `http://localhost/Website/`

A kezdőoldal az `index.php`, amelyről a diákbejelentkezés, a tanári bejelentkezés és a regisztráció érhető el.

## 6. A projekt főbb fájljai

| Fájl | Feladat |
|---|---|
| `index.php` | A webalkalmazás kezdőoldala, ahonnan elérhető a diák- és tanári bejelentkezés, valamint a regisztráció. |
| `login_student.php` | Diákok bejelentkezésének kezelése, a megadott adatok ellenőrzése, a jelszó hitelesítése és a diák szerepkör ellenőrzése. Sikeres bejelentkezés után a diák vezérlőpultjára irányít. |
| `login_teacher.php` | Tanárok bejelentkezésének kezelése, a megadott adatok ellenőrzése, a jelszó hitelesítése és a tanári szerepkör ellenőrzése. Sikeres bejelentkezés után a tanári vezérlőpultra irányít. |
| `reg.php` | Regisztráció és a jelszó hash-elt formában történő mentése. |
| `student_dashboard.php` | Bejelentkezett diákok vezérlőpultja. |
| `teacher_dashboard.php` | Bejelentkezett tanárok vezérlőpultja. |
| `config.php` | Adatbázis-kapcsolati paraméterek. |
| `dbconnect.php` | PDO-alapú adatbázis-kapcsolat létrehozása. |



## 8. Fejlesztési és biztonsági tudnivalók

- Az adatbázis-lekérdezésekhez használjunk előkészített PDO-utasításokat.
- A bejelentkezési rendszer munkameneteket (session) és cookie-kat használ. Az „Emlékezz rám” funkció lehetővé teszi a felhasználó automatikus bejelentkezését a következő látogatáskor.
- A HTML-ben megjelenített felhasználói adatokat megfelelően kezeljük, például `htmlspecialchars()` használatával.
- Új fájlok hozzáadásakor vagy áthelyezésekor ellenőrizzük a relatív útvonalakat.
- Az adatbázis szerkezetének változtatásakor frissítsük az SQL-exportot és a dokumentációt.
- A diák- és tanárbejelentkezést külön teszteljük, hibás jelszóval és eltérő szerepkörrel is.
- **GitHubra feltöltés előtt mindig ellenőrizzük**, hogy nem kerül-e fel jelszó, titkos token, privát kulcs vagy érzékeny konfiguráció.


