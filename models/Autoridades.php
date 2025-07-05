<?php
require_once '../core/Conexion.php';

class Autoridades {
      private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    // Crear autoridad en la tabla autoridades
    public function crearAutoridad($nombre, $cargo, $correo, $foto_url = null, $facultad_secuencial = null, $telefono = null, $estado = 1) {
        $sql = "INSERT INTO autoridades (FACULTAD_SECUENCIAL, NOMBRE, CARGO, FOTO_URL, CORREO, TELEFONO, ESTADO) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$facultad_secuencial, $nombre, $cargo, $foto_url, $correo, $telefono, $estado]);
    }

    // Editar autoridad existente
    public function editarAutoridad($id, $nombre, $cargo, $correo, $foto_url = null, $facultad_secuencial = null, $telefono = null, $estado = 1) {
        $sql = "UPDATE autoridades SET FACULTAD_SECUENCIAL = ?, NOMBRE = ?, CARGO = ?, FOTO_URL = ?, CORREO = ?, TELEFONO = ?, ESTADO = ? WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$facultad_secuencial, $nombre, $cargo, $foto_url, $correo, $telefono, $estado, $id]);
    }

    // Eliminar autoridad
    public function eliminarAutoridad($id) {
        $sql = "DELETE FROM autoridades WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Obtener autoridades
    public function getAutoridades() {
        $sql = "SELECT SECUENCIAL AS identificador, FACULTAD_SECUENCIAL, NOMBRE, CARGO, FOTO_URL, CORREO, TELEFONO, ESTADO FROM autoridades WHERE ESTADO = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
