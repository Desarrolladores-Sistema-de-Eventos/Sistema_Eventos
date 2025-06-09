<?php
require_once '../core/Conexion.php';

class Asistencia_Nota {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }
    
 public function eventosPorResponsable($idUsuario) {
    $stmt = $this->pdo->prepare("
        SELECT 
            e.SECUENCIAL,
            e.TITULO,
            e.FECHAINICIO,
            e.FECHAFIN,
            e.HORAS,
            e.ESTADO,
            te.NOMBRE AS TIPO_EVENTO,
            (SELECT ie.URL_IMAGEN FROM imagen_evento ie WHERE ie.SECUENCIALEVENTO = e.SECUENCIAL AND ie.TIPO_IMAGEN = 'PORTADA' LIMIT 1) AS IMAGEN
        FROM evento e
        INNER JOIN organizador_evento oe ON e.SECUENCIAL = oe.SECUENCIALEVENTO
        LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
        WHERE oe.SECUENCIALUSUARIO = ? AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
        ORDER BY e.FECHAINICIO DESC
    ");
    $stmt->execute([$idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // 2. Listar inscritos aprobados de un evento
    public function getInscritosAceptadosEvento($idEvento) {
        $sql = "SELECT 
                    i.SECUENCIAL AS INSCRIPCION_ID,
                    CONCAT(u.NOMBRES, ' ', u.APELLIDOS) AS NOMBRE,
                    an.ASISTIO AS ASISTENCIA,
                    an.NOTAFINAL AS NOTA,
                    te.NOMBRE AS TIPO_EVENTO
                FROM inscripcion i
                INNER JOIN usuario u ON i.SECUENCIALUSUARIO = u.SECUENCIAL
                LEFT JOIN asistencia_nota an 
                    ON an.SECUENCIALEVENTO = i.SECUENCIALEVENTO 
                    AND an.SECUENCIALUSUARIO = i.SECUENCIALUSUARIO
                INNER JOIN evento e ON i.SECUENCIALEVENTO = e.SECUENCIAL
                LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
                WHERE i.SECUENCIALEVENTO = ?
                  AND i.CODIGOESTADOINSCRIPCION = 'ACE'
                ORDER BY u.NOMBRES";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
    // 3. Guardar asistencia y nota de un inscrito, e intentar generar certificado
    public function guardarAsistenciaNota($idInscripcion, $asistencia, $nota) {
        // Obtener datos de inscripción
        $stmt = $this->pdo->prepare("SELECT SECUENCIALEVENTO, SECUENCIALUSUARIO FROM inscripcion WHERE SECUENCIAL = ?");
        $stmt->execute([$idInscripcion]);
        $insc = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$insc) return ['success' => false, 'mensaje' => 'Inscripción no encontrada'];

        // Verificar si ya existe
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM asistencia_nota WHERE SECUENCIALEVENTO = ? AND SECUENCIALUSUARIO = ?");
        $stmt->execute([$insc['SECUENCIALEVENTO'], $insc['SECUENCIALUSUARIO']]);
        if ($stmt->fetchColumn() > 0) {
            // UPDATE
            $sql = "UPDATE asistencia_nota SET ASISTIO = ?, NOTAFINAL = ? WHERE SECUENCIALEVENTO = ? AND SECUENCIALUSUARIO = ?";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([$asistencia, $nota, $insc['SECUENCIALEVENTO'], $insc['SECUENCIALUSUARIO']]);
        } else {
            // INSERT
            $sql = "INSERT INTO asistencia_nota (SECUENCIALEVENTO, SECUENCIALUSUARIO, ASISTIO, NOTAFINAL) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([$insc['SECUENCIALEVENTO'], $insc['SECUENCIALUSUARIO'], $asistencia, $nota]);
        }

        // Intentar generar certificado si corresponde
        require_once  '../models/Certificados.php';
        $certificadoModel = new Certificado();
        $certificado = $certificadoModel->generarSiCorresponde($idInscripcion);

        return [
            'success' => $ok,
            'mensaje' => $ok ? 'Registro actualizado correctamente.' : 'No se pudo guardar.',
            'certificado' => $certificado['success'],
            'mensaje_certificado' => $certificado['mensaje']
        ];
    }
}