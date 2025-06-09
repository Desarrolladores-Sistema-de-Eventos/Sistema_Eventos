<?php
require_once '../core/Conexion.php'; // Incluir la clase de conexión

class EventoAsistencia {
    private $conn;

    public function __construct() {
        // Usar la clase Conexion para obtener la conexión a la base de datos
        $this->conn = Conexion::getConexion();
    }

    public function obtenerEventos() {
        $stmt = $this->conn->prepare("SELECT SECUENCIAL, TITULO FROM evento ORDER BY TITULO ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerReporte($idEvento) {
        $reporte = [
            'responsables' => [],
            'asistentes' => []
        ];

        // Obtener detalles del evento y responsables
        // Nota: Asegúrate de que los alias de las columnas (como FECHAINICIO, FECHAFIN) coincidan con lo que espera tu vista.
        $stmt = $this->conn->prepare("
            SELECT
                e.TITULO AS EVENTO,
                e.FECHAINICIO,
                e.FECHAFIN,
                u.NOMBRES,
                u.APELLIDOS,
                u.CORREO,
                oe.ROL_ORGANIZADOR AS CARGO
            FROM
                evento e
            JOIN
                organizador_evento oe ON e.SECUENCIAL = oe.SECUENCIALEVENTO
            JOIN
                usuario u ON oe.SECUENCIALUSUARIO = u.SECUENCIAL
            WHERE
                e.SECUENCIAL = :idEvento
            ORDER BY
                u.APELLIDOS, u.NOMBRES
        ");
        $stmt->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        $stmt->execute();
        $responsables = $stmt->fetchAll();

        foreach ($responsables as $r) {
            // Convertir las fechas a objetos DateTime para que puedan ser formateadas en la vista
            $r['FECHAINICIO'] = new DateTime($r['FECHAINICIO']);
            $r['FECHAFIN'] = new DateTime($r['FECHAFIN']);
            $r['RESPONSABLE'] = $r['NOMBRES'] . ' ' . $r['APELLIDOS'];
            unset($r['NOMBRES'], $r['APELLIDOS']); // Limpiar campos que ya no son necesarios
            $reporte['responsables'][] = $r;
        }

        // Obtener asistentes
        // Se unen las tablas para obtener la información completa del asistente,
        // incluyendo facultad, carrera, estado de inscripción y ponderación (nota final).
        $stmt = $this->conn->prepare("
            SELECT
                u.NOMBRES,
                u.APELLIDOS,
                u.CORREO,
                f.NOMBRE AS FACULTAD,
                c.NOMBRE_CARRERA AS CARRERA,
                ei.NOMBRE AS ESTADO_PARTICIPACION,
                an.NOTAFINAL AS PONDERACION
            FROM
                inscripcion i
            JOIN
                usuario u ON i.SECUENCIALUSUARIO = u.SECUENCIAL
            LEFT JOIN
                usuario_carrera uc ON u.SECUENCIAL = uc.SECUENCIALUSUARIO
            LEFT JOIN
                carrera c ON uc.SECUENCIALCARRERA = c.SECUENCIAL
            LEFT JOIN
                facultad f ON c.SECUENCIALFACULTAD = f.SECUENCIAL
            JOIN
                estado_inscripcion ei ON i.CODIGOESTADOINSCRIPCION = ei.CODIGO
            LEFT JOIN
                asistencia_nota an ON i.SECUENCIALEVENTO = an.SECUENCIALEVENTO AND i.SECUENCIALUSUARIO = an.SECUENCIALUSUARIO
            WHERE
                i.SECUENCIALEVENTO = :idEvento
            ORDER BY
                u.APELLIDOS, u.NOMBRES
        ");
        $stmt->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        $stmt->execute();
        $asistentes = $stmt->fetchAll();

        foreach ($asistentes as $a) {
            $a['NOMBRE_COMPLETO'] = $a['NOMBRES'] . ' ' . $a['APELLIDOS'];
            unset($a['NOMBRES'], $a['APELLIDOS']); // Limpiar campos que ya no son necesarios
            $reporte['asistentes'][] = $a;
        }

        return $reporte;
    }
}