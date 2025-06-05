<?php
require_once '../config/conexion.php';

class Certificado {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    public function obtenerEventos() {
        $sql = "SELECT SECUENCIAL, TITULO FROM EVENTO ORDER BY TITULO ASC";
        $stmt = sqlsrv_query($this->conn, $sql);

        $eventos = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $eventos[] = $row;
        }
        return $eventos;
    }

    public function obtenerCertificadosPorEvento($idEvento) {
        $sql = "{CALL ObtenerCertificadosEmitidos(?)}";
        $params = array($idEvento);

        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $certificados = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if (isset($row['FECHA_EMISION']) && $row['FECHA_EMISION'] instanceof DateTime) {
                $row['FECHA_EMISION'] = $row['FECHA_EMISION']->format('Y-m-d');
            }
            $certificados[] = $row;
        }

        return $certificados;
    }
}
