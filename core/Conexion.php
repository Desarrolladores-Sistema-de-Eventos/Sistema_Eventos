<?php
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
            die(" Error al conectar a la base de datos: " . $e->getMessage());
        }

    }
}
?>