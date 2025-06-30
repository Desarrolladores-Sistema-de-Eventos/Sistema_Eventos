<?php
require_once '../core/Conexion.php';

class Certificado {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    // Listar certificados por evento (para responsable)
    public function getCertificadosPorEvento($idEvento) {
        $sql = "
            SELECT 
                c.SECUENCIAL,
                e.TITULO AS EVENTO,
                u.NOMBRES,
                u.APELLIDOS,
                u.CORREO,
                c.URL_CERTIFICADO,
                c.FECHA_EMISION
            FROM certificado c
            INNER JOIN evento e ON c.SECUENCIALEVENTO = e.SECUENCIAL
            INNER JOIN usuario u ON c.SECUENCIALUSUARIO = u.SECUENCIAL
            WHERE c.SECUENCIALEVENTO = ?
            ORDER BY c.FECHA_EMISION DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar certificados por usuario (para usuario)
   public function getCertificadosPorUsuario($idUsuario) {
    $sql = "
        SELECT 
            c.SECUENCIAL,
            e.TITULO AS EVENTO,
            u.CORREO,
            c.URL_CERTIFICADO,
            c.FECHA_EMISION,
            c.TIPO_CERTIFICADO
        FROM certificado c
        INNER JOIN evento e ON c.SECUENCIALEVENTO = e.SECUENCIAL
        INNER JOIN usuario u ON c.SECUENCIALUSUARIO = u.SECUENCIAL
        WHERE c.SECUENCIALUSUARIO = ?
        ORDER BY c.FECHA_EMISION DESC
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Crear certificado
    public function crearCertificado($idUsuario, $idEvento, $urlCertificado = null) {
        // Verificar si ya existe un certificado para este usuario y evento
        $existingCert = $this->buscarCertificadoPorUsuarioEvento($idUsuario, $idEvento);
        if ($existingCert) {
            return ['success' => false, 'mensaje' => 'Ya existe un certificado para este usuario y evento.'];
        } else {
            $sql = "INSERT INTO certificado (SECUENCIALUSUARIO, SECUENCIALEVENTO, URL_CERTIFICADO, FECHA_EMISION)
                    VALUES (?, ?, ?, NOW())";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([$idUsuario, $idEvento, $urlCertificado]);
            return [
                'success' => $ok,
                'mensaje' => $ok ? 'Certificado creado correctamente.' : 'Error al crear el certificado.'
            ];
        }
    }

    // Editar certificado
    public function editarCertificado($idCertificado, $urlCertificado) {
        $sql = "UPDATE certificado SET URL_CERTIFICADO = ?, FECHA_EMISION = NOW() WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute([$urlCertificado, $idCertificado]);
        return [
            'success' => $ok,
            'mensaje' => $ok ? 'Certificado actualizado correctamente.' : 'Error al actualizar el certificado.'
        ];
    }

    // Obtener un certificado específico
    public function getCertificado($idCertificado) {
        $sql = "SELECT 
                    c.*, 
                    u.NOMBRES, 
                    u.APELLIDOS, 
                    e.TITULO AS EVENTO
                FROM certificado c
                INNER JOIN usuario u ON c.SECUENCIALUSUARIO = u.SECUENCIAL
                INNER JOIN evento e ON c.SECUENCIALEVENTO = e.SECUENCIAL
                WHERE c.SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idCertificado]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarCertificadoPorUsuarioEvento($idUsuario, $idEvento) {
        $sql = "SELECT * FROM certificado WHERE SECUENCIALUSUARIO = ? AND SECUENCIALEVENTO = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUsuario, $idEvento]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public function generarSiCorresponde($idInscripcion) {
    // 1. Obtener datos de inscripción y evento
    $sql = "
        SELECT 
            i.SECUENCIAL AS INSCRIPCION_ID,
            i.CODIGOESTADOINSCRIPCION,
            i.SECUENCIALUSUARIO,
            i.SECUENCIALEVENTO,
            e.NOTAAPROBACION,
            e.ES_PAGADO,
            e.ESTADO,
            e.CODIGOTIPOEVENTO
        FROM inscripcion i
        INNER JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
        WHERE i.SECUENCIAL = ?
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idInscripcion]);
    $insc = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$insc) {
        return ['success' => false, 'mensaje' => 'Inscripción no encontrada'];
    }

    if ($insc['ESTADO'] !== 'FINALIZADO') {
        return ['success' => false, 'mensaje' => 'El evento aún no ha sido finalizado'];
    }

    if (!in_array($insc['CODIGOESTADOINSCRIPCION'], ['ACE', 'COM'])) {
        return ['success' => false, 'mensaje' => 'La inscripción no está aceptada ni completada'];
    }

    // 2. Verificar pago si es evento pagado
    if ($insc['ES_PAGADO']) {
        $stmtPago = $this->pdo->prepare("
            SELECT CODIGOESTADOPAGO
            FROM pago
            WHERE SECUENCIALINSCRIPCION = ?
            ORDER BY FECHA_PAGO DESC
            LIMIT 1
        ");
        $stmtPago->execute([$idInscripcion]);
        $pago = $stmtPago->fetch(PDO::FETCH_ASSOC);
        if (!$pago || $pago['CODIGOESTADOPAGO'] !== 'VAL') {
            return ['success' => false, 'mensaje' => 'El pago no ha sido validado'];
        }
    }

    // 3. Obtener datos de asistencia y nota
    $stmtAsist = $this->pdo->prepare("
        SELECT ASISTIO, NOTAFINAL, PORCENTAJE_ASISTENCIA
        FROM asistencia_nota
        WHERE SECUENCIALEVENTO = ? AND SECUENCIALUSUARIO = ?
        LIMIT 1
    ");
    $stmtAsist->execute([$insc['SECUENCIALEVENTO'], $insc['SECUENCIALUSUARIO']]);
    $asist = $stmtAsist->fetch(PDO::FETCH_ASSOC);

    if (!$asist || $asist['ASISTIO'] != 1) {
        return ['success' => false, 'mensaje' => 'El participante no asistió al evento'];
    }

    if ($asist['PORCENTAJE_ASISTENCIA'] === null || $asist['PORCENTAJE_ASISTENCIA'] < 70) {
        return ['success' => false, 'mensaje' => 'El porcentaje de asistencia es insuficiente'];
    }

    if ($insc['CODIGOTIPOEVENTO'] === 'CUR') {
        if ($asist['NOTAFINAL'] === null || floatval($asist['NOTAFINAL']) < floatval($insc['NOTAAPROBACION'])) {
            return ['success' => false, 'mensaje' => 'La nota final es insuficiente para aprobar'];
        }
    }

    // 4. Verificar si ya existe certificado
    $stmtCert = $this->pdo->prepare("
        SELECT 1 FROM certificado 
        WHERE SECUENCIALUSUARIO = ? AND SECUENCIALEVENTO = ?
        LIMIT 1
    ");
    $stmtCert->execute([$insc['SECUENCIALUSUARIO'], $insc['SECUENCIALEVENTO']]);
    if ($stmtCert->fetch()) {
        return ['success' => false, 'mensaje' => 'Ya existe un certificado para esta inscripción'];
    }

    // 5. Determinar tipo de certificado
    $tipoCertificado = ($insc['CODIGOTIPOEVENTO'] === 'CUR') ? 'Aprobación' : 'Participación';

    // 6. Insertar certificado
    $stmtInsert = $this->pdo->prepare("
        INSERT INTO certificado (SECUENCIALUSUARIO, SECUENCIALEVENTO, TIPO_CERTIFICADO, FECHA_EMISION)
        VALUES (?, ?, ?, NOW())
    ");
    $ok = $stmtInsert->execute([
        $insc['SECUENCIALUSUARIO'],
        $insc['SECUENCIALEVENTO'],
        $tipoCertificado
    ]);

    return $ok
        ? ['success' => true, 'mensaje' => 'Certificado generado correctamente']
        : ['success' => false, 'mensaje' => 'Error al generar el certificado'];
}

public function getCertificadosEmitidos($idEvento) {
    $sql = "
        SELECT 
            u.SECUENCIAL AS ID_USUARIO, 
            u.CEDULA,
            u.NOMBRES,
            u.APELLIDOS,
            u.CORREO,
            c.URL_CERTIFICADO
        FROM certificado c
        INNER JOIN usuario u ON u.SECUENCIAL = c.SECUENCIALUSUARIO
        WHERE c.SECUENCIALEVENTO = ?
        ORDER BY u.APELLIDOS, u.NOMBRES
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idEvento]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Obtener conexión PDO para consultas externas (como en el controlador)
public function getPDO() {
    return $this->pdo;
}

// Buscar certificado por cédula y evento (opcional)
public function buscarPorCedulaYEvento($cedula, $idEvento) {
    $sql = "
        SELECT c.* 
        FROM certificado c
        INNER JOIN usuario u ON c.SECUENCIALUSUARIO = u.SECUENCIAL
        WHERE u.CEDULA = ? AND c.SECUENCIALEVENTO = ?
        LIMIT 1
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$cedula, $idEvento]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function usuarioYEventoExisten($idUsuario, $idEvento) {
    $sql = "SELECT 
                (SELECT COUNT(*) FROM usuario WHERE SECUENCIAL = ?) AS usuario_existe,
                (SELECT COUNT(*) FROM evento WHERE SECUENCIAL = ?) AS evento_existe";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idUsuario, $idEvento]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res['usuario_existe'] > 0 && $res['evento_existe'] > 0;
}
  
   

}
?>