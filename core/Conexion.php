<?php
<<<<<<< HEAD
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
=======
require_once '../config/config.php';

class Conexion {
    public static function getConexion() {
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

            return $pdo;
        } catch (PDOException $e) {
            // Mensaje útil durante desarrollo (puedes ocultarlo en producción)
            die("❌ Error al conectar a la base de datos: " . $e->getMessage());
        }
>>>>>>> feature/Modulo-Eventos-Sesiones
    }
}
?>