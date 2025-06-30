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
            te.CODIGO AS TIPO_EVENTO_CODIGO,
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
public function finalizarEvento($idEvento) {
    $stmt = $this->pdo->prepare("UPDATE evento SET ESTADO = 'FINALIZADO' WHERE SECUENCIAL = ?");
    return $stmt->execute([$idEvento]);
}
public function puedeFinalizarEvento($idEvento) {
    // Obtener tipo del evento y nota mínima de aprobación
    $stmt = $this->pdo->prepare("SELECT CODIGOTIPOEVENTO, NOTAAPROBACION FROM evento WHERE SECUENCIAL = ?");
    $stmt->execute([$idEvento]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$evento) return false;

    $tipo = $evento['CODIGOTIPOEVENTO'];
    $notaMinima = floatval($evento['NOTAAPROBACION']);

    if ($tipo === 'CUR') {
        // Validar: nota, porcentaje y observación si nota < mínima
        $sql = "SELECT COUNT(*) FROM inscripcion i
                LEFT JOIN asistencia_nota an 
                    ON an.SECUENCIALEVENTO = i.SECUENCIALEVENTO 
                    AND an.SECUENCIALUSUARIO = i.SECUENCIALUSUARIO
                WHERE i.SECUENCIALEVENTO = ?
                  AND i.CODIGOESTADOINSCRIPCION = 'ACE'
                  AND (
                      an.NOTAFINAL IS NULL OR
                      an.PORCENTAJE_ASISTENCIA IS NULL OR
                      (an.NOTAFINAL < ? AND (an.OBSERVACION IS NULL OR TRIM(an.OBSERVACION) = ''))
                  )";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento, $notaMinima]);
    } else {
        // Solo validar porcentaje en eventos no-CUR
        $sql = "SELECT COUNT(*) FROM inscripcion i
                LEFT JOIN asistencia_nota an 
                    ON an.SECUENCIALEVENTO = i.SECUENCIALEVENTO 
                    AND an.SECUENCIALUSUARIO = i.SECUENCIALUSUARIO
                WHERE i.SECUENCIALEVENTO = ?
                  AND i.CODIGOESTADOINSCRIPCION = 'ACE'
                  AND an.PORCENTAJE_ASISTENCIA IS NULL";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento]);
    }

    $faltantes = $stmt->fetchColumn();
    return $faltantes == 0;
}

    // 2. Listar inscritos aprobados de un evento
    public function getInscritosAceptadosEvento($idEvento) {
        $sql = "SELECT 
                    i.SECUENCIAL AS INSCRIPCION_ID,
                    CONCAT(u.NOMBRES, ' ', u.APELLIDOS) AS NOMBRE,
                    an.ASISTIO AS ASISTENCIA,
                    an.NOTAFINAL AS NOTA,
                    an.PORCENTAJE_ASISTENCIA,
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
    public function guardarAsistenciaNota($idInscripcion, $asistencia, $nota, $porcentajeAsistencia = null, $observacion = null) {
    try {
        // Obtener datos de inscripción + tipo de evento
        $stmt = $this->pdo->prepare("
            SELECT i.SECUENCIALEVENTO, i.SECUENCIALUSUARIO, e.CODIGOTIPOEVENTO
            FROM inscripcion i
            INNER JOIN evento e ON e.SECUENCIAL = i.SECUENCIALEVENTO
            WHERE i.SECUENCIAL = ?
        ");
        $stmt->execute([$idInscripcion]);
        $insc = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$insc) {
            return ['success' => false, 'mensaje' => 'Inscripción no encontrada'];
        }

        // Verificar si ya existe
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM asistencia_nota WHERE SECUENCIALEVENTO = ? AND SECUENCIALUSUARIO = ?");
        $stmt->execute([$insc['SECUENCIALEVENTO'], $insc['SECUENCIALUSUARIO']]);
        $existe = $stmt->fetchColumn() > 0;

        if ($existe) {
            $sql = "UPDATE asistencia_nota 
                    SET ASISTIO = ?, NOTAFINAL = ?, PORCENTAJE_ASISTENCIA = ?, OBSERVACION = ?
                    WHERE SECUENCIALEVENTO = ? AND SECUENCIALUSUARIO = ?";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                $asistencia,
                $nota,
                $porcentajeAsistencia,
                $observacion,
                $insc['SECUENCIALEVENTO'],
                $insc['SECUENCIALUSUARIO']
            ]);
        } else {
            $sql = "INSERT INTO asistencia_nota 
                    (SECUENCIALEVENTO, SECUENCIALUSUARIO, ASISTIO, NOTAFINAL, PORCENTAJE_ASISTENCIA, OBSERVACION)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                $insc['SECUENCIALEVENTO'],
                $insc['SECUENCIALUSUARIO'],
                $asistencia,
                $nota,
                $porcentajeAsistencia,
                $observacion
            ]);
        }

        if (!$ok) {
            $errorInfo = $stmt->errorInfo();
            return ['success' => false, 'mensaje' => 'Error al guardar: ' . $errorInfo[2]];
        }

        return [
            'success' => true,
            'mensaje' => 'Registro actualizado correctamente.'
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'mensaje' => 'Excepción SQL: ' . $e->getMessage()
        ];
    }
}



public function guardarNotasYFinalizarEvento($idEvento, $datos) {
    $okGlobal = true;

    // 1. Guardar todas las asistencias y notas
    foreach ($datos as $fila) {
        $idInscripcion = $fila['idInscripcion'];
        $asistencia = $fila['asistencia'];
        $nota = $fila['nota'] ?? null;
        $porcentaje = $fila['porcentaje'] ?? null;
        $observacion = $fila['observacion'] ?? null;

        $resultado = $this->guardarAsistenciaNota($idInscripcion, $asistencia, $nota, $porcentaje, $observacion);
        if (!$resultado['success']) {
            $okGlobal = false;
        }
    }

    if ($okGlobal) {
        // 2. Finalizar el evento
        $this->finalizarEvento($idEvento);

        // 3. Generar certificados una vez que el evento ya esté finalizado
        require_once '../models/Certificados.php';
        $certificadoModel = new Certificado();

        foreach ($datos as $fila) {
            $idInscripcion = $fila['idInscripcion'];
            $certificado = $certificadoModel->generarSiCorresponde($idInscripcion);

        }
    }

    return [
        'success' => $okGlobal,
        'mensaje' => $okGlobal ? 'Notas guardadas, evento finalizado y certificados generados.' : 'Ocurrieron errores al guardar algunas notas.'
    ];
}



}