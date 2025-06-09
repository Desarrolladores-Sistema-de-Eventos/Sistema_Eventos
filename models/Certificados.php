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
            c.FECHA_EMISION
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
        $sql = "INSERT INTO certificado (SECUENCIALUSUARIO, SECUENCIALEVENTO, URL_CERTIFICADO, FECHA_EMISION)
                VALUES (?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$idUsuario, $idEvento, $urlCertificado]);
    }

    // Editar certificado
    public function editarCertificado($idCertificado, $urlCertificado) {
        $sql = "UPDATE certificado SET URL_CERTIFICADO = ?, FECHA_EMISION = NOW() WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$urlCertificado, $idCertificado]);
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
                e.ES_PAGADO
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

        // 2. Estado de inscripción
        if (!in_array($insc['CODIGOESTADOINSCRIPCION'], ['ACE', 'COM'])) {
            return ['success' => false, 'mensaje' => 'La inscripción no está aceptada ni completada'];
        }

        // 3. Si el evento es pagado, verificar pago validado
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

        // 4. Asistencia y nota
        $stmtAsist = $this->pdo->prepare("
            SELECT ASISTIO, NOTAFINAL
            FROM asistencia_nota
            WHERE SECUENCIALEVENTO = ? AND SECUENCIALUSUARIO = ?
            LIMIT 1
        ");
        $stmtAsist->execute([$insc['SECUENCIALEVENTO'], $insc['SECUENCIALUSUARIO']]);
        $asist = $stmtAsist->fetch(PDO::FETCH_ASSOC);

        if (!$asist || $asist['ASISTIO'] != 1) {
            return ['success' => false, 'mensaje' => 'El participante no asistió al evento'];
        }
        if ($asist['NOTAFINAL'] < $insc['NOTAAPROBACION']) {
            return ['success' => false, 'mensaje' => 'La nota final es insuficiente para aprobar'];
        }

        // 5. Ya existe certificado?
        $stmtCert = $this->pdo->prepare("
            SELECT 1 FROM certificado 
            WHERE SECUENCIALUSUARIO = ? AND SECUENCIALEVENTO = ?
            LIMIT 1
        ");
        $stmtCert->execute([$insc['SECUENCIALUSUARIO'], $insc['SECUENCIALEVENTO']]);
        if ($stmtCert->fetch()) {
            return ['success' => false, 'mensaje' => 'Ya existe un certificado para esta inscripción'];
        }

        // 6. Insertar certificado (sin URL, solo registro inicial)
        $stmtInsert = $this->pdo->prepare("
            INSERT INTO certificado (SECUENCIALUSUARIO, SECUENCIALEVENTO, FECHA_EMISION)
            VALUES (?, ?, NOW())
        ");
        $ok = $stmtInsert->execute([
            $insc['SECUENCIALUSUARIO'],
            $insc['SECUENCIALEVENTO']
        ]);

        if ($ok) {
            return ['success' => true, 'mensaje' => 'Certificado generado correctamente'];
        } else {
            return ['success' => false, 'mensaje' => 'Error al generar el certificado'];
        }
    }
}
?>