<?php
require_once '../core/Conexion.php';

class Reportes
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getConexion();
    }

    /**
     * 1. Listado de eventos a cargo del responsable
     */
    public function eventosPorResponsable($idUsuario)
    {
        $sql = "SELECT 
                    e.SECUENCIAL,
                    e.TITULO,
                    e.FECHAINICIO,
                    e.FECHAFIN,
                    e.HORAS,
                    e.ESTADO,
                    te.NOMBRE AS TIPO,
                    (SELECT COUNT(*) FROM inscripcion i WHERE i.SECUENCIALEVENTO = e.SECUENCIAL) AS TOTAL_INSCRITOS
                FROM evento e
                INNER JOIN organizador_evento oe ON e.SECUENCIAL = oe.SECUENCIALEVENTO
                LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
                WHERE oe.SECUENCIALUSUARIO = ? AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
                ORDER BY e.FECHAINICIO DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 2. Listado de inscritos por evento
     */
    public function inscritosPorEvento($idEvento)
    {
        $sql = "SELECT 
                    i.SECUENCIAL AS INSCRIPCION_ID,
                    CONCAT(u.NOMBRES, ' ', u.APELLIDOS) AS NOMBRE,
                    u.CORREO,
                    u.CARRERA,
                    i.CODIGOESTADOINSCRIPCION AS ESTADO_INSCRIPCION,
                    i.FECHAINSCRIPCION
                FROM inscripcion i
                INNER JOIN usuario u ON i.SECUENCIALUSUARIO = u.SECUENCIAL
                WHERE i.SECUENCIALEVENTO = ?
                ORDER BY u.NOMBRES";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 3. Reporte de asistencia y notas por evento
     */
    public function asistenciaNotasPorEvento($idEvento)
    {
        $sql = "SELECT 
                    i.SECUENCIAL AS INSCRIPCION_ID,
                    CONCAT(u.NOMBRES, ' ', u.APELLIDOS) AS NOMBRE,
                    an.ASISTIO AS ASISTENCIA,
                    an.NOTAFINAL AS NOTA_FINAL
                FROM inscripcion i
                INNER JOIN usuario u ON i.SECUENCIALUSUARIO = u.SECUENCIAL
                LEFT JOIN asistencia_nota an 
                    ON an.SECUENCIALEVENTO = i.SECUENCIALEVENTO 
                    AND an.SECUENCIALUSUARIO = i.SECUENCIALUSUARIO
                WHERE i.SECUENCIALEVENTO = ?
                ORDER BY u.NOMBRES";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 4. Reporte de certificados emitidos por evento
     */
    public function certificadosPorEvento($idEvento)
    {
        $sql = "SELECT 
                    c.SECUENCIAL AS CERTIFICADO_ID,
                    CONCAT(u.NOMBRES, ' ', u.APELLIDOS) AS NOMBRE,
                    c.URL_CERTIFICADO,
                    c.FECHA_EMISION
                FROM certificado c
                INNER JOIN inscripcion i ON c.SECUENCIALINSCRIPCION = i.SECUENCIAL
                INNER JOIN usuario u ON i.SECUENCIALUSUARIO = u.SECUENCIAL
                WHERE i.SECUENCIALEVENTO = ?
                ORDER BY u.NOMBRES";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 5. Estadísticas generales del evento
     */
    public function estadisticasEvento($idEvento)
    {
        $sql = "SELECT
                    (SELECT COUNT(*) FROM inscripcion WHERE SECUENCIALEVENTO = ?) AS TOTAL_INSCRITOS,
                    (SELECT COUNT(*) FROM asistencia_nota WHERE SECUENCIALEVENTO = ? AND ASISTIO = 1) AS TOTAL_ASISTENTES,
                    (SELECT COUNT(*) FROM asistencia_nota WHERE SECUENCIALEVENTO = ? AND NOTAFINAL >= 7) AS TOTAL_APROBADOS,
                    (SELECT COUNT(*) FROM certificado c INNER JOIN inscripcion i ON c.SECUENCIALINSCRIPCION = i.SECUENCIAL WHERE i.SECUENCIALEVENTO = ?) AS TOTAL_CERTIFICADOS
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento, $idEvento, $idEvento, $idEvento]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Puedes agregar más métodos para otros reportes según necesidad
}
?>