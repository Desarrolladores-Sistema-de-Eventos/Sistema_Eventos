<?php
require_once '../config/conexion.php';

class Inscripcion {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    public function obtenerInscripciones($idEvento) {
        $sql = "{CALL ObtenerInscripcionesPorEvento(?)}";
        $params = array($idEvento);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // 1. Obtener Total de Inscritos (primer resultado)
        $totalInscritos = 0;
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $totalInscritos = $row['TotalInscritos'];
        }

        sqlsrv_next_result($stmt);

    
        $inscritos = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $inscritos[] = $row;
        }

        return [
            'total' => $totalInscritos,
            'datos' => $inscritos
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

    public function obtenerTituloEvento($idEvento) {
    $sql = "SELECT TITULO FROM EVENTO WHERE SECUENCIAL = ?";
    $params = [$idEvento];
    $stmt = sqlsrv_query($this->conn, $sql, $params);

    if ($stmt && ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))) {
        return $row['TITULO'];
    }

    return "Evento no encontrado";
}

}
