<?php
// kiemeljük az adatbázis kapcsolatot külön állományba
require_once("config.php"); // beemeli a paramétereket

try {
    $dbConn = new PDO(DBTYPE . ":host=" . DBHOST . ";dbname=" . DBNAME . ";charset=" . DBCHARSET, DBUSER, DBPASSWORD);
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $msg = "Sikeres kapcsolat";
} catch (PDOException $e) {
    $error = "Sikertelen adatbázis kapcsolódás: " . $e->getMessage();
    // Vagy hibajelzés kiírása teszteléshez:
    // die($error);
}
?>