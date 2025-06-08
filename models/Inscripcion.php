
<?php
require_once '../core/Conexion.php'; // Incluir la clase de conexión


    class Inscripcion {
        private $conn;

    public function __construct() {
        // Usar la clase Conexion para obtener la conexión a la base de datos
        $this->conn = Conexion::getConexion();
    }

    public function obtenerEventos() {
        // Simplemente obtiene la lista de eventos, similar al modelo anterior
        $stmt = $this->conn->prepare("SELECT SECUENCIAL, TITULO FROM evento ORDER BY TITULO ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerInscripciones($idEvento) {
        $reporte = [
            'total' => 0,
            'datos' => []
        ];

        // Consulta para obtener los datos de los inscritos
        $stmt = $this->conn->prepare("
            SELECT
                u.NOMBRES,
                u.APELLIDOS,
                u.CORREO,
                c.NOMBRE_CARRERA AS CARRERA,
                f.NOMBRE AS FACULTAD
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
            WHERE
                i.SECUENCIALEVENTO = :idEvento
            ORDER BY
                u.APELLIDOS, u.NOMBRES
        ");
        $stmt->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        $stmt->execute();
        $datos = $stmt->fetchAll();

        foreach ($datos as $d) {
            $d['NOMBRE COMPLETO'] = $d['NOMBRES'] . ' ' . $d['APELLIDOS'];
            unset($d['NOMBRES'], $d['APELLIDOS']); // Limpiar campos que ya no son necesarios
            $reporte['datos'][] = $d;
        }

        $reporte['total'] = count($reporte['datos']); // Contar el total de inscripciones

        return $reporte;
    }

    public function obtenerTituloEvento($idEvento) {
        $stmt = $this->conn->prepare("SELECT TITULO FROM evento WHERE SECUENCIAL = :idEvento");
        $stmt->bindParam(':idEvento', $idEvento, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['TITULO'] : null;
    }
}

