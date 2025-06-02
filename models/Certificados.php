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
                c.URL_CERTIFICADO,
                c.FECHA_EMISION,
                i.ESTADO_INSCRIPCION,
                an.ASISTENCIA,
                an.NOTA
            FROM certificado c
            INNER JOIN evento e ON c.SECUENCIALEVENTO = e.SECUENCIAL
            INNER JOIN inscripcion i ON i.SECUENCIALUSUARIO = c.SECUENCIALUSUARIO AND i.SECUENCIALEVENTO = c.SECUENCIALEVENTO
            INNER JOIN asistencia_nota an ON an.INSCRIPCION_ID = i.SECUENCIAL
            WHERE c.SECUENCIALUSUARIO = ?
            ORDER BY c.FECHA_EMISION DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear certificado
    public function crearCertificado($idUsuario, $idEvento, $urlCertificado) {
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
}