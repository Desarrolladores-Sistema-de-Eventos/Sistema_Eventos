<?php
require_once '../core/Conexion.php'; // Incluir la clase de conexión

class Certificado {
    private $conn;

    public function __construct() {
        // Usar la clase Conexion para obtener la conexión a la base de datos
        $this->conn = Conexion::getConexion();
    }

    public function obtenerEventos() {
        // Obtiene la lista de eventos disponibles para seleccionar
        $stmt = $this->conn->prepare("SELECT SECUENCIAL, TITULO FROM evento ORDER BY TITULO ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerCertificadosPorEvento($idEvento) {
        $stmt = $this->conn->prepare("
            SELECT
                e.TITULO AS NOMBRE_EVENTO,
                u.NOMBRES,
                u.APELLIDOS,
                u.CORREO,
                c.TIPO_CERTIFICADO,
                c.URL_CERTIFICADO,
                c.FECHA_EMISION
            FROM
                certificado c
            JOIN
                evento e ON c.SECUENCIALEVENTO = e.SECUENCIAL
            JOIN
                usuario u ON c.SECUENCIALUSUARIO = u.SECUENCIAL
            WHERE
                e.SECUENCIAL = :idEvento
            ORDER BY
                u.APELLIDOS, u.NOMBRES
        ");
        $stmt->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        $stmt->execute();
        $certificados = $stmt->fetchAll();

        // Formatear el nombre completo del usuario para cada certificado
        foreach ($certificados as &$cert) { // Usar & para modificar el array directamente
            $cert['NOMBRE_COMPLETO'] = $cert['NOMBRES'] . ' ' . $cert['APELLIDOS'];
            unset($cert['NOMBRES'], $cert['APELLIDOS']); // Eliminar las columnas individuales si ya no son necesarias
        }

        return $certificados;
    }
}