<?php
require_once '../core/Conexion.php';
require_once __DIR__ . '/../core/correo_usuario.php'; // Al inicio del archivo


class Inscripciones {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    public function crearInscripcion($idEvento, $idUsuario, $facturaUrl) {
    $stmt = $this->pdo->prepare("
        INSERT INTO INSCRIPCION 
        (SECUENCIALEVENTO, SECUENCIALUSUARIO, FECHAINSCRIPCION, FACTURA_URL, CODIGOESTADOINSCRIPCION) 
        VALUES (?, ?, NOW(), ?, 'PEN')
    ");
    return $stmt->execute([$idEvento, $idUsuario, $facturaUrl]);
}


public function listarInscripcionesPorEvento($idEvento, $idResponsable) {
    // Verificar que el usuario es responsable del evento
    $verif = $this->pdo->prepare("
        SELECT 1 
        FROM ORGANIZADOR_EVENTO 
        WHERE SECUENCIALEVENTO = ? 
          AND SECUENCIALUSUARIO = ? 
          AND ROL_ORGANIZADOR = 'RESPONSABLE'
    ");
    $verif->execute([$idEvento, $idResponsable]);
    if (!$verif->fetch()) return [];

    // Consulta de inscripciones + pagos + comprobante
    $stmt = $this->pdo->prepare("
        SELECT 
            i.SECUENCIAL AS INSCRIPCION_ID,
            u.NOMBRES,
            u.APELLIDOS,
            i.FECHAINSCRIPCION,
            i.CODIGOESTADOINSCRIPCION,
            i.FACTURA_URL AS FACTURA,        
            p.SECUENCIAL AS PAGO_ID,
            p.CODIGOESTADOPAGO,
            p.COMPROBANTE_URL,
            p.FECHA_PAGO
        FROM INSCRIPCION i
        INNER JOIN USUARIO u ON u.SECUENCIAL = i.SECUENCIALUSUARIO
        LEFT JOIN PAGO p ON p.SECUENCIALINSCRIPCION = i.SECUENCIAL
        WHERE i.SECUENCIALEVENTO = ?
    ");
    $stmt->execute([$idEvento]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function actualizarEstadoInscripcion($id, $estado) {
        $validos = ['PEN', 'ACE', 'REC', 'ANU', 'COM'];
        if (!in_array($estado, $validos)) return false;

        $stmt = $this->pdo->prepare("UPDATE INSCRIPCION SET CODIGOESTADOINSCRIPCION = ? WHERE SECUENCIAL = ?");
        return $stmt->execute([$estado, $id]);
    }

public function actualizarEstadoPago($idPago, $estado, $aprobador) {
    $validos = ['PEN', 'VAL', 'RECH', 'INV']; // Cambia 'APR' por 'VAL'
    if (!in_array($estado, $validos)) return false;

    $stmt = $this->pdo->prepare("
        UPDATE PAGO 
        SET CODIGOESTADOPAGO = ?, SECUENCIAL_USUARIO_APROBADOR = ?, FECHA_APROBACION = NOW()
        WHERE SECUENCIAL = ?
    ");
    return $stmt->execute([$estado, $aprobador, $idPago]);
}


    public function validarRequisito($idArchivo, $estado) {
        $validos = ['PEN', 'VAL', 'REC', 'INV']; // Corregir: usar REC en lugar de RECH para requisitos
        if (!in_array($estado, $validos)) return false;

        $stmt = $this->pdo->prepare("UPDATE ARCHIVO_REQUISITO SET CODIGOESTADOVALIDACION = ? WHERE SECUENCIAL = ?");
        return $stmt->execute([$estado, $idArchivo]);
    }
    public function listarArchivosRequisitosPorEvento($idEvento) {
    $sql = "
        SELECT 
            u.NOMBRES, 
            u.APELLIDOS,
            re.DESCRIPCION AS REQUISITO,
            ar.URLARCHIVO AS ARCHIVO,
            ar.SECUENCIAL AS ARCHIVO_ID
        FROM archivo_requisito ar
        INNER JOIN inscripcion i ON ar.SECUENCIALINSCRIPCION = i.SECUENCIAL
        INNER JOIN usuario u ON i.SECUENCIALUSUARIO = u.SECUENCIAL
        INNER JOIN requisito_evento re ON ar.SECUENCIALREQUISITO = re.SECUENCIAL
        WHERE i.SECUENCIALEVENTO = ?
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idEvento]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function actualizarEstadoArchivoRequisito($idArchivo, $estado)
{
    $stmt = $this->pdo->prepare("UPDATE ARCHIVO_REQUISITO SET CODIGOESTADOVALIDACION = ? WHERE SECUENCIAL = ?");
    return $stmt->execute([$estado, $idArchivo]);
}
public function listarInscripcionesPendientesDelResponsable($idResponsable) {
    $sql = "
        SELECT 
            i.SECUENCIAL AS INSCRIPCION_ID,
            CONCAT(u.NOMBRES, ' ', u.APELLIDOS) AS NOMBRE_COMPLETO,
            e.TITULO AS EVENTO,
            i.CODIGOESTADOINSCRIPCION,
            i.FACTURA_URL AS FACTURA
        FROM inscripcion i
        INNER JOIN usuario u ON u.SECUENCIAL = i.SECUENCIALUSUARIO
        INNER JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
        INNER JOIN organizador_evento oe 
            ON oe.SECUENCIALEVENTO = e.SECUENCIAL AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
        WHERE oe.SECUENCIALUSUARIO = ? 
          AND i.CODIGOESTADOINSCRIPCION IN ('PEN', 'REC')
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idResponsable]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function resumenEstadosInscripcion($idResponsable) {
    $sql = "
        SELECT i.CODIGOESTADOINSCRIPCION, COUNT(*) as total
        FROM inscripcion i
        JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
        JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = e.SECUENCIAL
        WHERE oe.SECUENCIALUSUARIO = ? AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
        GROUP BY i.CODIGOESTADOINSCRIPCION
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idResponsable]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function inscripcionesPorEvento($idResponsable) {
    $sql = "
        SELECT e.TITULO, COUNT(*) as total
        FROM inscripcion i
        JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
        JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = e.SECUENCIAL
        WHERE oe.SECUENCIALUSUARIO = ? AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
        GROUP BY e.TITULO
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idResponsable]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function certificadosPorEvento($idResponsable) {
    $sql = "
        SELECT e.TITULO, COUNT(c.SECUENCIAL) as total
        FROM certificado c
        JOIN evento e ON e.SECUENCIAL = c.SECUENCIALEVENTO
        JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = e.SECUENCIAL
        WHERE oe.SECUENCIALUSUARIO = ? AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
        GROUP BY e.TITULO
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idResponsable]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function totalEventosDelResponsable($idResponsable) {
    $sql = "
        SELECT COUNT(DISTINCT e.SECUENCIAL) as total
        FROM evento e
        INNER JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = e.SECUENCIAL
        WHERE oe.SECUENCIALUSUARIO = ? AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idResponsable]);
    return $stmt->fetchColumn();
}

public function detalleInscripcion($idInscripcion, $idResponsable) {
    $sql = "
        SELECT 
            i.SECUENCIAL AS INSCRIPCION_ID,
            CONCAT(u.NOMBRES, ' ', u.APELLIDOS) AS NOMBRE_COMPLETO,
            e.TITULO AS EVENTO,
            i.FECHAINSCRIPCION,
            i.CODIGOESTADOINSCRIPCION,
            i.FACTURA_URL AS FACTURA,
            e.ES_PAGADO
        FROM inscripcion i
        JOIN usuario u ON u.SECUENCIAL = i.SECUENCIALUSUARIO
        JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
        JOIN organizador_evento oe ON oe.SECUENCIALEVENTO = e.SECUENCIAL
        WHERE i.SECUENCIAL = ?
          AND oe.SECUENCIALUSUARIO = ?
          AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idInscripcion, $idResponsable]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function listarArchivosRequisitosPorInscripcion($idInscripcion) {
    $sql = "
        SELECT 
            re.DESCRIPCION AS REQUISITO,
            ar.URLARCHIVO AS ARCHIVO,
            ar.CODIGOESTADOVALIDACION AS ESTADO,
            ar.SECUENCIAL AS ARCHIVO_ID
        FROM archivo_requisito ar
        JOIN requisito_evento re ON re.SECUENCIAL = ar.SECUENCIALREQUISITO
        WHERE ar.SECUENCIALINSCRIPCION = ?
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idInscripcion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function requisitosPorInscripcion($idInscripcion) {
    $sql = "
        SELECT 
            re.DESCRIPCION AS REQUISITO,
            ar.URLARCHIVO AS ARCHIVO,
            ar.CODIGOESTADOVALIDACION AS ESTADO,
            ar.SECUENCIAL AS ARCHIVO_ID
        FROM archivo_requisito ar
        JOIN requisito_evento re ON ar.SECUENCIALREQUISITO = re.SECUENCIAL
        WHERE ar.SECUENCIALINSCRIPCION = ?
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idInscripcion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function pagosPorInscripcion($idInscripcion) {
    $sql = "
        SELECT 
            p.SECUENCIAL AS PAGO_ID,
            p.COMPROBANTE_URL,
            p.CODIGOESTADOPAGO,
            p.FECHA_PAGO,
            f.NOMBRE AS FORMA_PAGO
        FROM PAGO p
        LEFT JOIN FORMA_PAGO f ON p.CODIGOFORMADEPAGO = f.CODIGO
        WHERE p.SECUENCIALINSCRIPCION = ?
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idInscripcion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function actualizarComprobanteFactura($idInscripcion, $nombreArchivo) {
    $stmt = $this->pdo->prepare("UPDATE INSCRIPCION SET FACTURA_URL = ? WHERE SECUENCIAL = ?");
    return $stmt->execute([$nombreArchivo, $idInscripcion]);
}

public function contarInscritos() {
    $sql = "SELECT COUNT(*) as total FROM inscripcion WHERE CODIGOESTADOINSCRIPCION = 'ACE'";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function obtenerInscripcionesAceptadasPorEvento($idResponsable) {
    $sql = "
        SELECT 
            e.TITULO,
            COUNT(i.SECUENCIAL) AS total
        FROM evento e
        LEFT JOIN inscripcion i 
            ON i.SECUENCIALEVENTO = e.SECUENCIAL 
            AND i.CODIGOESTADOINSCRIPCION = 'ACE'
        INNER JOIN organizador_evento oe 
            ON oe.SECUENCIALEVENTO = e.SECUENCIAL AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
        WHERE oe.SECUENCIALUSUARIO = ?
        GROUP BY e.TITULO
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idResponsable]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function actualizarArchivoRequisito($idArchivo, $nombreArchivo) {
    $stmt = $this->pdo->prepare("UPDATE archivo_requisito SET URLARCHIVO = ?, CODIGOESTADOVALIDACION = 'PEN' WHERE SECUENCIAL = ?");
    return $stmt->execute([$nombreArchivo, $idArchivo]);
}

public function actualizarComprobantePago($idPago, $nombreArchivo) {
    // 1. Obtener el costo del evento desde el pago
    $sql = "
        SELECT e.COSTO
        FROM pago p
        INNER JOIN inscripcion i ON i.SECUENCIAL = p.SECUENCIALINSCRIPCION
        INNER JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
        WHERE p.SECUENCIAL = ?
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idPago]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$evento) return false;

    $monto = $evento['COSTO'];

    // 2. Actualizar el pago con estado, comprobante y monto
    $sqlUpdate = "
        UPDATE pago
        SET 
            CODIGOESTADOPAGO = 'VAL',
            COMPROBANTE_URL = ?,
            MONTO = ?
        WHERE SECUENCIAL = ?
    ";
    $stmtUpdate = $this->pdo->prepare($sqlUpdate);
    return $stmtUpdate->execute([$nombreArchivo, $monto, $idPago]);
}
public function getInscripcionesPorUsuario($idUsuario) {
    $sql = "
        SELECT 
            i.SECUENCIAL,
            i.SECUENCIALEVENTO,
            e.TITULO AS EVENTO,
            i.FACTURA_URL,
            i.CODIGOESTADOINSCRIPCION,
            i.FECHAINSCRIPCION,
            e.ES_PAGADO
        FROM inscripcion i
        INNER JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
        WHERE i.SECUENCIALUSUARIO = ?
        ORDER BY i.FECHAINSCRIPCION DESC
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function estaInscrito($idUsuario, $idEvento) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM inscripcion WHERE SECUENCIALUSUARIO = ? AND SECUENCIALEVENTO = ? AND CODIGOESTADOINSCRIPCION != 'CANCELADO'");
        $stmt->execute([$idUsuario, $idEvento]);
        return $stmt->fetchColumn() > 0; // fetchColumn(0) obtiene el valor de la primera columna
    }
public function validarYActualizarEstadoInscripcion($idInscripcion) {
    // Verificar que todos los requisitos estén validados
    $sqlReq = "SELECT COUNT(*) FROM archivo_requisito WHERE SECUENCIALINSCRIPCION = ? AND CODIGOESTADOVALIDACION != 'VAL'";
    $stmtReq = $this->pdo->prepare($sqlReq);
    $stmtReq->execute([$idInscripcion]);
    $faltanReq = $stmtReq->fetchColumn();

    // Consultar si el evento es pagado
    $sqlEsPagado = "SELECT e.ES_PAGADO
                    FROM inscripcion i
                    INNER JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
                    WHERE i.SECUENCIAL = ?";
    $stmtEsPagado = $this->pdo->prepare($sqlEsPagado);
    $stmtEsPagado->execute([$idInscripcion]);
    $esPagado = $stmtEsPagado->fetchColumn();

    $faltanPagos = 0;
    if ($esPagado == 1) {
        // Si es pagado, verificar que todos los pagos estén validados
        $sqlPago = "SELECT COUNT(*) FROM pago WHERE SECUENCIALINSCRIPCION = ? AND CODIGOESTADOPAGO != 'VAL'";
        $stmtPago = $this->pdo->prepare($sqlPago);
        $stmtPago->execute([$idInscripcion]);
        $faltanPagos = $stmtPago->fetchColumn();
    }

    if ($faltanReq == 0 && ($esPagado == 0 || $faltanPagos == 0)) {
        // Actualizar estado de inscripción a ACE
        $sqlUpd = "UPDATE inscripcion SET CODIGOESTADOINSCRIPCION = 'ACE' WHERE SECUENCIAL = ?";
        $stmtUpd = $this->pdo->prepare($sqlUpd);
        $stmtUpd->execute([$idInscripcion]);

        // Si es un evento pagado, actualizar el MONTO en la tabla PAGO con el COSTO del evento
        if ($esPagado == 1) {
            $sqlActualizarMonto = "
                UPDATE pago p
                INNER JOIN inscripcion i ON i.SECUENCIAL = p.SECUENCIALINSCRIPCION
                INNER JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
                SET p.MONTO = e.COSTO
                WHERE p.SECUENCIALINSCRIPCION = ?
            ";
            $stmtActualizarMonto = $this->pdo->prepare($sqlActualizarMonto);
            $stmtActualizarMonto->execute([$idInscripcion]);
        }

        // Obtener datos del usuario y evento
        $sqlUser = "SELECT u.CORREO, CONCAT(u.NOMBRES, ' ', u.APELLIDOS) AS NOMBRE, e.TITULO AS EVENTO
                    FROM inscripcion i
                    JOIN usuario u ON u.SECUENCIAL = i.SECUENCIALUSUARIO
                    JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
                    WHERE i.SECUENCIAL = ?";
        $stmtUser = $this->pdo->prepare($sqlUser);
        $stmtUser->execute([$idInscripcion]);
        $info = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($info) {
            enviarCorreoInscripcionAceptada($info['CORREO'], $info['NOMBRE'], $info['EVENTO']);
        }
        return true;
    } else {
        // Si algún requisito o pago fue rechazado, puedes actualizar a REC y notificar
        $sqlCheckRec = "SELECT COUNT(*) FROM archivo_requisito WHERE SECUENCIALINSCRIPCION = ? AND CODIGOESTADOVALIDACION = 'REC'";
        $stmtCheckRec = $this->pdo->prepare($sqlCheckRec);
        $stmtCheckRec->execute([$idInscripcion]);
        $hayRec = $stmtCheckRec->fetchColumn();

        // Validar si algún pago fue rechazado
        $sqlCheckPagoRech = "SELECT COUNT(*) FROM pago WHERE SECUENCIALINSCRIPCION = ? AND CODIGOESTADOPAGO = 'RECH'";
        $stmtCheckPagoRech = $this->pdo->prepare($sqlCheckPagoRech);
        $stmtCheckPagoRech->execute([$idInscripcion]);
        $hayPagoRech = $stmtCheckPagoRech->fetchColumn();

        if ($hayRec > 0 || $hayPagoRech > 0) {
            $sqlUpd = "UPDATE inscripcion SET CODIGOESTADOINSCRIPCION = 'REC' WHERE SECUENCIAL = ?";
            $stmtUpd = $this->pdo->prepare($sqlUpd);
            $stmtUpd->execute([$idInscripcion]);

            // Obtener datos del usuario y evento
            $sqlUser = "SELECT u.CORREO, CONCAT(u.NOMBRES, ' ', u.APELLIDOS) AS NOMBRE, e.TITULO AS EVENTO
                        FROM inscripcion i
                        JOIN usuario u ON u.SECUENCIAL = i.SECUENCIALUSUARIO
                        JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
                        WHERE i.SECUENCIAL = ?";
            $stmtUser = $this->pdo->prepare($sqlUser);
            $stmtUser->execute([$idInscripcion]);
            $info = $stmtUser->fetch(PDO::FETCH_ASSOC);

            if ($info) {
                enviarCorreoInscripcionRechazada($info['CORREO'], $info['NOMBRE'], $info['EVENTO']);
            }
        }
    }
    return false;
}
public function obtenerIdInscripcionPorArchivo($idArchivo) {
    $stmt = $this->pdo->prepare("SELECT SECUENCIALINSCRIPCION FROM archivo_requisito WHERE SECUENCIAL = ?");
    $stmt->execute([$idArchivo]);
    return $stmt->fetchColumn();
}

public function obtenerIdInscripcionPorPago($idPago) {
    $stmt = $this->pdo->prepare("SELECT SECUENCIALINSCRIPCION FROM pago WHERE SECUENCIAL = ?");
    $stmt->execute([$idPago]);
    return $stmt->fetchColumn();
}
public function esEventoPagadoPorInscripcion($idInscripcion) {
    $stmt = $this->pdo->prepare("SELECT e.ES_PAGADO FROM inscripcion i INNER JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO WHERE i.SECUENCIAL = ?");
    $stmt->execute([$idInscripcion]);
    return $stmt->fetchColumn();
}
}
