<?php
require_once '../core/Conexion.php';

class Facultad {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    public function getFacultad($id = 1) {
        $stmt = $this->pdo->prepare("SELECT NOMBRE, MISION, VISION, UBICACION FROM facultad WHERE SECUENCIAL = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}