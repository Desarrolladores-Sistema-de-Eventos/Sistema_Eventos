<?php
require_once '../config/conexion.php';

class EventoCategoria {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    public function obtenerCategorias() {
        $stmt = sqlsrv_query($this->conn, "SELECT SECUENCIAL, NOMBRE FROM CATEGORIA_EVENTO ORDER BY NOMBRE ASC");
        $categorias = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $categorias[] = $row;
        }
        return $categorias;
    }

    public function obtenerEventosPorCategoria($idCategoria) {
        $sql = "{CALL ObtenerEventosPorCategoria(?)}";
        $stmt = sqlsrv_query($this->conn, $sql, [$idCategoria]);

        $resultados = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $resultados[] = $row;
        }
        return $resultados;
    }
}
