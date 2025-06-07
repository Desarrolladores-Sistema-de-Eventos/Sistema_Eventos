<?php
require_once '../core/Conexion.php';

class ReporteEvento {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }
    /**
     * Obtiene los eventos donde el usuario es responsable
     */
    public function getEventosPorResponsable($idUsuario)
{
    $sql = "SELECT 
                e.SECUENCIAL,
                e.TITULO,
                e.FECHAINICIO,
                e.FECHAFIN
            FROM evento e
            INNER JOIN organizador_evento oe 
                ON e.SECUENCIAL = oe.SECUENCIALEVENTO
            WHERE oe.SECUENCIALUSUARIO = ?
              AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
            ORDER BY e.FECHAINICIO DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getEventoBasico($idEvento) {
    $sql = "SELECT 
                e.TITULO,
                e.FECHAINICIO,
                te.NOMBRE AS TIPO_EVENTO
            FROM evento e
            LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
            WHERE e.SECUENCIAL = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idEvento]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}




    /**
     * Reporte de inscritos ACEPTADOS por evento del responsable
     */
    public function getInscritosAceptadosPorEvento($idUsuario, $idEvento) {
        $sql = "
            SELECT  u.CEDULA, u.NOMBRES, u.APELLIDOS, u.CORREO, i.FECHAINSCRIPCION
            FROM inscripcion i
            INNER JOIN usuario u ON u.SECUENCIAL = i.SECUENCIALUSUARIO
            INNER JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = i.SECUENCIALEVENTO
            WHERE i.CODIGOESTADOINSCRIPCION = 'ACE'
              AND i.SECUENCIALEVENTO = ?
              AND oe.SECUENCIALUSUARIO = ?
              AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
            ORDER BY i.FECHAINSCRIPCION DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento, $idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Reporte de asistencia y nota final por evento
     */
    public function getAsistenciaYNotasPorEvento($idUsuario, $idEvento) {
        $sql = "
            SELECT u.CEDULA, u.NOMBRES, u.APELLIDOS, 
            u.CORREO, 
            CASE WHEN an.ASISTIO = 1 THEN 'Sí' ELSE 'No' END AS ASISTIO,
            an.NOTAFINAL
            FROM asistencia_nota an
            INNER JOIN usuario u ON u.SECUENCIAL = an.SECUENCIALUSUARIO
            INNER JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = an.SECUENCIALEVENTO
            WHERE an.SECUENCIALEVENTO = ?
              AND oe.SECUENCIALUSUARIO = ?
              AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
            ORDER BY u.APELLIDOS, u.NOMBRES
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento, $idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Reporte financiero por evento (pagos validados)
     */
public function getReporteFinancieroPorEvento($idUsuario, $idEvento) {
    $sql = "
        SELECT 
            u.CEDULA,
            u.CORREO,
            p.FECHA_PAGO,
            p.MONTO AS MONTO_PAGADO, 
            f.NOMBRE AS METODO_PAGO
        FROM pago p
        INNER JOIN inscripcion i ON i.SECUENCIAL = p.SECUENCIALINSCRIPCION
        INNER JOIN usuario u ON u.SECUENCIAL = i.SECUENCIALUSUARIO
        INNER JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
        INNER JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = e.SECUENCIAL
        INNER JOIN forma_pago f ON f.CODIGO = p.CODIGOFORMADEPAGO
        WHERE i.SECUENCIALEVENTO = ?
          AND p.CODIGOESTADOPAGO = 'VAL'
          AND oe.SECUENCIALUSUARIO = ?
          AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
        ORDER BY p.FECHA_PAGO DESC
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idEvento, $idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getTotalRecaudadoPorEvento($idUsuario, $idEvento) {
    $sql = "
        SELECT 
            SUM(p.MONTO) AS TOTAL_RECAUDADO
        FROM pago p
        INNER JOIN inscripcion i ON i.SECUENCIAL = p.SECUENCIALINSCRIPCION
        INNER JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
        INNER JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = e.SECUENCIAL
        WHERE i.SECUENCIALEVENTO = ?
          AND p.CODIGOESTADOPAGO = 'VAL'
          AND oe.SECUENCIALUSUARIO = ?
          AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idEvento, $idUsuario]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['TOTAL_RECAUDADO'] ?? 0;
}
public function getCertificadosPorEvento($idUsuario, $idEvento) {
    $sql = "
        SELECT 
            u.CEDULA,
            u.CORREO,
            c.FECHA_EMISION,
            CASE WHEN c.URL_CERTIFICADO IS NOT NULL THEN 'Sí' ELSE 'No' END AS CERTIFICADO
        FROM certificado c
        INNER JOIN usuario u ON u.SECUENCIAL = c.SECUENCIALUSUARIO
        INNER JOIN evento e ON e.SECUENCIAL = c.SECUENCIALEVENTO
        INNER JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = e.SECUENCIAL
        WHERE c.SECUENCIALEVENTO = ?
          AND oe.SECUENCIALUSUARIO = ?
          AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
        ORDER BY c.FECHA_EMISION DESC
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idEvento, $idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getReporteGeneralPorEvento($idUsuario, $idEvento) {
    $sql = "
        SELECT 
            u.CEDULA,
            u.CORREO,
            i.FECHAINSCRIPCION,
            CASE WHEN an.ASISTIO = 1 THEN 'Sí' ELSE 'No' END AS ASISTIO,
            an.NOTAFINAL,
            CASE WHEN c.URL_CERTIFICADO IS NOT NULL THEN 'Sí' ELSE 'No' END AS CERTIFICADO,
            p.MONTO AS MONTO_PAGADO
        FROM inscripcion i
        INNER JOIN usuario u ON u.SECUENCIAL = i.SECUENCIALUSUARIO
        INNER JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = i.SECUENCIALEVENTO
        LEFT JOIN asistencia_nota an ON an.SECUENCIALUSUARIO = i.SECUENCIALUSUARIO AND an.SECUENCIALEVENTO = i.SECUENCIALEVENTO
        LEFT JOIN certificado c ON c.SECUENCIALUSUARIO = i.SECUENCIALUSUARIO AND c.SECUENCIALEVENTO = i.SECUENCIALEVENTO
        LEFT JOIN pago p ON p.SECUENCIALINSCRIPCION = i.SECUENCIAL AND p.CODIGOESTADOPAGO = 'VAL'
        WHERE i.SECUENCIALEVENTO = ?
          AND oe.SECUENCIALUSUARIO = ?
          AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
        ORDER BY i.FECHAINSCRIPCION DESC
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idEvento, $idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
