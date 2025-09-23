<?php
// src/Config/Database.php
class Database {
    private static $host = 'localhost';
    private static $db   = 'vehiculos_db';
    private static $user = 'admin';
    private static $pass = 'admin';
    private static $charset = 'utf8mb4';
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            try {
                self::$pdo = new PDO($dsn, self::$user, self::$pass, $options);
            } catch (PDOException $e) {
                throw new Exception("DB connection error: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
