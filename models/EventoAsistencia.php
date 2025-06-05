<?php
require_once '../config/conexion.php';

class EventoAsistencia {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    public function obtenerReporte($idEvento) {
        $sql = "{CALL ObtenerReporteEventoConAsistentes(?)}";
        $stmt = sqlsrv_query($this->conn, $sql, [$idEvento]);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Obtener todos los responsables
        $responsables = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $responsables[] = $row;
        }

        // Pasar al siguiente conjunto de resultados: asistentes
        sqlsrv_next_result($stmt);
        $asistentes = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $asistentes[] = $row;
        }

        return [
            'responsables' => $responsables,
            'asistentes' => $asistentes
        ];
    }

    public function obtenerEventos() {
        $stmt = sqlsrv_query($this->conn, "SELECT SECUENCIAL, TITULO FROM EVENTO ORDER BY TITULO ASC");
        $eventos = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $eventos[] = $row;
        }
        return $eventos;
    }
}
