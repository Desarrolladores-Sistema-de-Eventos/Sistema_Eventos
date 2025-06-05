<?php
require_once '../config/conexion.php';

class Financiero {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    public function obtenerReporteFinanciero($idEvento) {
        $sql = "{CALL ObtenerReporteFinancieroPorEvento(?)}";
        $stmt = sqlsrv_query($this->conn, $sql, [$idEvento]);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // 1. Monto total por forma de pago
        $montos = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $montos[] = $row;
        }

        // 2. Siguiente resultado: pagos pendientes
        sqlsrv_next_result($stmt);
        $pendientes = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $pendientes[] = $row;
        }

        // 3. Siguiente resultado: comprobantes subidos
        sqlsrv_next_result($stmt);
        $comprobantes = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $comprobantes[] = $row;
        }

        return [
            'montos' => $montos,
            'pendientes' => $pendientes,
            'comprobantes' => $comprobantes
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
        $stmt = sqlsrv_query($this->conn, "SELECT TITULO FROM EVENTO WHERE SECUENCIAL = ?", [$idEvento]);
        if ($stmt && ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))) {
            return $row['TITULO'];
        }
        return "Evento no encontrado";
    }
}
