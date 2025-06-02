<?php
class Database {
    private static $host = "localhost:3306";
    private static $db_name = "evento";
    private static $username = "root";
    private static $password = "";
    private static $conn;

    public static function getConnection() {
        if (self::$conn == null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4",
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $exception) {
                die("Error de conexión: " . $exception->getMessage());
            }
        }
        return self::$conn;
    }
}
?>