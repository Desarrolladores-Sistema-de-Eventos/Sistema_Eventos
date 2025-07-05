<?php
require_once '../core/Conexion.php';

class CarruselModelo {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    // ========== CRUD Carrusel ==========
    public function obtenerCarrusel() {
        $sql = "SELECT * FROM carrusel WHERE ACTIVO = 1 ORDER BY FECHACREACION DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearCarrusel($titulo, $descripcion, $urlImagen) {
        $sql = "INSERT INTO carrusel (TITULO, DESCRIPCION, URL_IMAGEN) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$titulo, $descripcion, $urlImagen]);
        return $this->pdo->lastInsertId();
    }

    public function eliminarCarrusel($id) {
        $sql = "UPDATE carrusel SET ACTIVO = 0 WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerCarruselPublico() {
    $sql = "SELECT TITULO, DESCRIPCION, URL_IMAGEN 
            FROM carrusel 
            WHERE ACTIVO = 1 
            ORDER BY FECHACREACION DESC 
            LIMIT 10";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function actualizarCarrusel($id, $titulo, $descripcion, $urlImagen = null) {
    if ($urlImagen) {
        $sql = "UPDATE carrusel SET TITULO = ?, DESCRIPCION = ?, URL_IMAGEN = ? WHERE SECUENCIAL = ?";
        $params = [$titulo, $descripcion, $urlImagen, $id];
    } else {
        $sql = "UPDATE carrusel SET TITULO = ?, DESCRIPCION = ? WHERE SECUENCIAL = ?";
        $params = [$titulo, $descripcion, $id];
    }

    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute($params);
}

}
