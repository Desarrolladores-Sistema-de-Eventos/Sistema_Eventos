<?php
require_once '../core/Conexion.php';

class CarreraModelo {

    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getConexion(); 
    }

    public function crearCarrera($nombre, $idFacultad, $imagen) {
        $sql = "INSERT INTO carrera (NOMBRE_CARRERA, SECUENCIALFACULTAD, IMAGEN) VALUES (:nombre, :facultad, :imagen)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':facultad', $idFacultad, PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->execute();
        return $this->conexion->lastInsertId();
    }

    public function getCarreras() {
        $sql = "SELECT carrera.SECUENCIAL, carrera.NOMBRE_CARRERA, carrera.IMAGEN, carrera.SECUENCIALFACULTAD, facultad.NOMBRE
                FROM carrera
                INNER JOIN facultad ON carrera.SECUENCIALFACULTAD = facultad.SECUENCIAL
                ORDER BY carrera.SECUENCIAL DESC";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarCarrera($id, $nombre, $idFacultad, $imagen = null) {
        if ($imagen) {
            $sql = "UPDATE carrera SET NOMBRE_CARRERA = :nombre, SECUENCIALFACULTAD = :facultad, IMAGEN = :imagen WHERE SECUENCIAL = :id";
        } else {
            $sql = "UPDATE carrera SET NOMBRE_CARRERA = :nombre, SECUENCIALFACULTAD = :facultad WHERE SECUENCIAL = :id";
        }

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':facultad', $idFacultad, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($imagen) {
            $stmt->bindParam(':imagen', $imagen);
        }

        return $stmt->execute();
    }

    public function eliminarCarrera($id) {
        $sql = "DELETE FROM carrera WHERE SECUENCIAL = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
