<?php
require_once '../core/Conexion.php'; // Asegúrate de que la ruta sea correcta para Conexion.php

class EventoCategoria {
    private $conn;
    private $table_categoria = "categoria_evento";
    private $table_evento = "evento";
    private $table_carrera = "carrera";
    private $table_inscripcion = "inscripcion";
    private $table_organizador = "organizador_evento";
    private $table_usuario = "usuario";

    public function __construct() {
        // Usamos tu clase Conexion para obtener la conexión
        $this->conn = Conexion::getConexion();
    }

    public function obtenerCategorias() {
        $query = "SELECT SECUENCIAL, NOMBRE FROM " . $this->table_categoria . " ORDER BY NOMBRE ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEventosPorCategoria($idCategoria) {
        $query = "
            SELECT
                e.TITULO AS EVENTO,
                c.NOMBRE_CARRERA AS CARRERA,
                e.FECHAINICIO,
                e.FECHAFIN,
                e.ESTADO,
                CASE WHEN e.ES_PAGADO = 1 THEN 'Sí' ELSE 'No' END AS PAGADO,
                (SELECT COUNT(*) FROM " . $this->table_inscripcion . " WHERE SECUENCIALEVENTO = e.SECUENCIAL AND CODIGOESTADOINSCRIPCION = 'ACE') AS INSCRITOS,
                'N/A' AS CAPACIDAD, -- La capacidad no está definida en el esquema de la tabla 'evento'
                GROUP_CONCAT(DISTINCT CONCAT(u.NOMBRES, ' ', u.APELLIDOS) SEPARATOR ', ') AS ORGANIZADORES
            FROM
                " . $this->table_evento . " e
            LEFT JOIN
                " . $this->table_carrera . " c ON e.SECUENCIALCARRERA = c.SECUENCIAL
            LEFT JOIN
                " . $this->table_organizador . " oe ON e.SECUENCIAL = oe.SECUENCIALEVENTO
            LEFT JOIN
                " . $this->table_usuario . " u ON oe.SECUENCIALUSUARIO = u.SECUENCIAL
            WHERE
                e.SECUENCIALCATEGORIA = :idCategoria
            GROUP BY
                e.SECUENCIAL, e.TITULO, c.NOMBRE_CARRERA, e.FECHAINICIO, e.FECHAFIN, e.ESTADO, e.ES_PAGADO
            ORDER BY
                e.FECHAINICIO DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
        $stmt->execute();

        $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convertir fechas a objetos DateTime si es necesario para el formato en la vista
        foreach ($eventos as &$evento) {
            if (isset($evento['FECHAINICIO'])) {
                try {
                    $evento['FECHAINICIO'] = new DateTime($evento['FECHAINICIO']);
                } catch (Exception $e) {
                    $evento['FECHAINICIO'] = null; // O manejar el error como prefieras
                }
            }
            if (isset($evento['FECHAFIN'])) {
                try {
                    $evento['FECHAFIN'] = new DateTime($evento['FECHAFIN']);
                } catch (Exception $e) {
                    $evento['FECHAFIN'] = null; // O manejar el error como prefieras
                }
            }
        }
        return $eventos;
    }
}
?>