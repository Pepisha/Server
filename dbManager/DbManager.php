<?php
class DbManager {

    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "petrus";
    const DB_NAME = "find-yours-pets";

    public static function getPDO() {
        try {
            $pdo = new PDO('mysql:host='. DB_SERVER .';dbname='. DB_NAME, DB_USER, DB_PASSWORD, array(PDO::ATTR_PERSISTENT=>true));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        return $pdo;
    }
}
?>
