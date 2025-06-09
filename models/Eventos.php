<?php
require_once '../core/Conexion.php';

class Evento {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    public static function esResponsable($idUsuario) {
        $db = Conexion::getConexion();
        $stmt = $db->prepare("SELECT COUNT(*) FROM organizador_evento WHERE SECUENCIALUSUARIO = ? AND ROL_ORGANIZADOR = 'RESPONSABLE'");
        $stmt->execute([$idUsuario]);
        return $stmt->fetchColumn() > 0;
    }

    public function getEventosPorResponsable($idUsuario) {
        $sql = "
            SELECT 
                e.SECUENCIAL,
                e.TITULO,
                e.FECHAINICIO,
                e.FECHAFIN,
                e.HORAS,
                e.COSTO,
                e.ESTADO,
                me.NOMBRE AS MODALIDAD,
                te.NOMBRE AS TIPO,
                ca.NOMBRE_CARRERA AS CARRERA,
                ce.NOMBRE AS CATEGORIA
            FROM evento e
            INNER JOIN organizador_evento oe ON e.SECUENCIAL = oe.SECUENCIALEVENTO
            LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
            LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
            LEFT JOIN carrera ca ON e.SECUENCIALCARRERA = ca.SECUENCIAL
            LEFT JOIN categoria_evento ce ON e.SECUENCIALCATEGORIA = ce.SECUENCIAL
            WHERE oe.SECUENCIALUSUARIO = ?
              AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
            ORDER BY e.FECHAINICIO DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function getEventosPublicos($filtros = []) {
    $sql = "SELECT 
                e.SECUENCIAL,
                e.TITULO,
                e.DESCRIPCION,
                e.FECHAINICIO,
                e.FECHAFIN,
                e.HORAS,
                e.COSTO,
                e.ESTADO,
                me.NOMBRE AS MODALIDAD,
                te.NOMBRE AS TIPO,
                ca.NOMBRE_CARRERA AS CARRERA,
                ce.NOMBRE AS CATEGORIA,
                (SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA' LIMIT 1) AS PORTADA
            FROM evento e
            LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
            LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
            LEFT JOIN carrera ca ON e.SECUENCIALCARRERA = ca.SECUENCIAL
            LEFT JOIN categoria_evento ce ON e.SECUENCIALCATEGORIA = ce.SECUENCIAL
            WHERE e.ESTADO = 'DISPONIBLE'";

    $params = [];

    // Filtros dinámicos
    if (!empty($filtros['tipo'])) {
        $sql .= " AND e.CODIGOTIPOEVENTO = ?";
        $params[] = $filtros['tipo'];
    }
    if (!empty($filtros['categoria'])) {
        $sql .= " AND e.SECUENCIALCATEGORIA = ?";
        $params[] = $filtros['categoria'];
    }
    if (!empty($filtros['modalidad'])) {
        $sql .= " AND e.CODIGOMODALIDAD = ?";
        $params[] = $filtros['modalidad'];
    }
    if (!empty($filtros['carrera'])) {
        $sql .= " AND e.SECUENCIALCARRERA = ?";
        $params[] = $filtros['carrera'];
    }
    if (!empty($filtros['fecha'])) {
        $sql .= " AND e.FECHAINICIO >= ?";
        $params[] = $filtros['fecha'];
    }
    if (!empty($filtros['busqueda'])) {
        $sql .= " AND (e.TITULO LIKE ? OR e.DESCRIPCION LIKE ?)";
        $params[] = '%' . $filtros['busqueda'] . '%';
        $params[] = '%' . $filtros['busqueda'] . '%';
    }

    $sql .= " ORDER BY e.FECHAINICIO DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    
public function getEventosConPortadaPorResponsable($idUsuario) {
    $sql = "
        SELECT 
            e.SECUENCIAL,
            e.TITULO,
            e.FECHAINICIO,
            e.FECHAFIN,
            e.HORAS,
            e.COSTO,
            e.ESTADO,
            (SELECT URL_IMAGEN FROM imagen_evento 
                WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA' LIMIT 1
            ) AS PORTADA
        FROM evento e
        INNER JOIN organizador_evento oe ON e.SECUENCIAL = oe.SECUENCIALEVENTO
        WHERE oe.SECUENCIALUSUARIO = ?
          AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
        ORDER BY e.FECHAINICIO DESC
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getEvento($idEvento){
        
    $stmt = $this->pdo->prepare("SELECT * FROM EVENTO WHERE SECUENCIAL = ?");
    $stmt->execute([$idEvento]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener requisitos asociados
    $stmtReq = $this->pdo->prepare("SELECT SECUENCIAL FROM REQUISITO_EVENTO WHERE SECUENCIALEVENTO = ?");
    $stmtReq->execute([$idEvento]);
    $requisitos = $stmtReq->fetchAll(PDO::FETCH_COLUMN); // devuelve array de SECUENCIAL

    $evento['REQUISITOS'] = $requisitos;

    return $evento;
}

public function crearEvento($titulo, $descripcion, $horas, $fechaInicio, $fechaFin, $modalidad,
                            $notaAprobacion, $costo, $publicoDestino, $esPagado,
                            $categoria, $tipo, $carrera, $estado, $idUsuario,
                            $urlPortada, $urlGaleria, $capacidad) // galería es solo una imagen
{
    $sql = "INSERT INTO evento (
        TITULO, DESCRIPCION, HORAS, FECHAINICIO, FECHAFIN, 
        CODIGOMODALIDAD, NOTAAPROBACION, COSTO, ES_SOLO_INTERNOS, 
        ES_PAGADO, SECUENCIALCATEGORIA, CODIGOTIPOEVENTO, 
        SECUENCIALCARRERA, ESTADO, CAPACIDAD
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        $titulo, $descripcion, $horas, $fechaInicio, $fechaFin, 
        $modalidad, $notaAprobacion, $costo, $publicoDestino, 
        $esPagado, $categoria, $tipo, $carrera, $estado, $capacidad
    ]);

    $idEvento = $this->pdo->lastInsertId();

    // Asociar al usuario como RESPONSABLE
    $orgStmt = $this->pdo->prepare("INSERT INTO organizador_evento 
        (SECUENCIALUSUARIO, SECUENCIALEVENTO, ROL_ORGANIZADOR)
        VALUES (?, ?, 'RESPONSABLE')");
    $orgStmt->execute([$idUsuario, $idEvento]);

    // Insertar imagen de portada si existe
    if ($urlPortada) {
        $imgStmt = $this->pdo->prepare("INSERT INTO imagen_evento (SECUENCIALEVENTO, URL_IMAGEN, TIPO_IMAGEN) VALUES (?, ?, 'PORTADA')");
        $imgStmt->execute([$idEvento, $urlPortada]);
    }

    // Insertar imagen de galería si existe (igual que portada)
    if ($urlGaleria) {
        $imgStmt = $this->pdo->prepare("INSERT INTO imagen_evento (SECUENCIALEVENTO, URL_IMAGEN, TIPO_IMAGEN) VALUES (?, ?, 'GALERIA')");
        $imgStmt->execute([$idEvento, $urlGaleria]);
    }

    return $idEvento;
}

public function actualizarEvento($titulo, $descripcion, $horas, $fechaInicio, $fechaFin, $modalidad,
                                 $notaAprobacion, $costo, $publicoDestino, $esPagado,
                                 $categoria, $tipo, $carrera, $estado, $idEvento, $idUsuario,
                                 $urlPortada, $urlGaleria, $capacidad) // galería es solo una imagen
{
    // Verificar si el usuario es responsable del evento
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM organizador_evento 
                                 WHERE SECUENCIALEVENTO = ? AND SECUENCIALUSUARIO = ? 
                                 AND ROL_ORGANIZADOR = 'RESPONSABLE'");
    $stmt->execute([$idEvento, $idUsuario]);
    if ($stmt->fetchColumn() == 0) {
        return false; // No tiene permisos
    }

    // Actualizar datos del evento
    $sql = "UPDATE evento SET 
                TITULO = ?, 
                DESCRIPCION = ?, 
                HORAS = ?, 
                FECHAINICIO = ?, 
                FECHAFIN = ?, 
                CODIGOMODALIDAD = ?, 
                NOTAAPROBACION = ?, 
                COSTO = ?, 
                ES_SOLO_INTERNOS = ?, 
                ES_PAGADO = ?, 
                SECUENCIALCATEGORIA = ?, 
                CODIGOTIPOEVENTO = ?, 
                SECUENCIALCARRERA = ?, 
                ESTADO = ?, 
                CAPACIDAD = ?
            WHERE SECUENCIAL = ?";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        $titulo, $descripcion, $horas, $fechaInicio, $fechaFin,
        $modalidad, $notaAprobacion, $costo, $publicoDestino,
        $esPagado, $categoria, $tipo, $carrera,
        $estado, $capacidad, $idEvento
    ]);

    // Actualizar imagen de portada si se recibe una nueva
    if ($urlPortada) {
        // Elimina la portada anterior
        $delStmt = $this->pdo->prepare("DELETE FROM imagen_evento WHERE SECUENCIALEVENTO = ? AND TIPO_IMAGEN = 'PORTADA'");
        $delStmt->execute([$idEvento]);
        // Inserta la nueva portada
        $imgStmt = $this->pdo->prepare("INSERT INTO imagen_evento (SECUENCIALEVENTO, URL_IMAGEN, TIPO_IMAGEN) VALUES (?, ?, 'PORTADA')");
        $imgStmt->execute([$idEvento, $urlPortada]);
    }

    // Actualizar imagen de galería si se recibe una nueva
    if ($urlGaleria) {
        // Elimina la galería anterior
        $delStmt = $this->pdo->prepare("DELETE FROM imagen_evento WHERE SECUENCIALEVENTO = ? AND TIPO_IMAGEN = 'GALERIA'");
        $delStmt->execute([$idEvento]);
        // Inserta la nueva galería
        $imgStmt = $this->pdo->prepare("INSERT INTO imagen_evento (SECUENCIALEVENTO, URL_IMAGEN, TIPO_IMAGEN) VALUES (?, ?, 'GALERIA')");
        $imgStmt->execute([$idEvento, $urlGaleria]);
    }

    return true;
}

public function eliminarEvento($idEvento, $idUsuario) {
    // Eliminar imágenes asociadas al evento
    $stmtImg = $this->pdo->prepare("DELETE FROM imagen_evento WHERE SECUENCIALEVENTO = ?");
    $stmtImg->execute([$idEvento]);

    // Eliminar relación organizador-evento
    $stmt1 = $this->pdo->prepare("DELETE FROM organizador_evento 
                                  WHERE SECUENCIALEVENTO = ? AND SECUENCIALUSUARIO = ? 
                                  AND ROL_ORGANIZADOR = 'RESPONSABLE'");
    $stmt1->execute([$idEvento, $idUsuario]);

    // Eliminar el evento
    $stmt2 = $this->pdo->prepare("DELETE FROM evento WHERE SECUENCIAL = ?");
    return $stmt2->execute([$idEvento]);
}

public function cancelarEvento($idEvento, $idUsuario) {
    $sql = "UPDATE evento e
            JOIN organizador_evento oe ON e.SECUENCIAL = oe.SECUENCIALEVENTO
            SET e.ESTADO = 'CANCELADO'
            WHERE e.SECUENCIAL = ? AND oe.SECUENCIALUSUARIO = ? AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'";

    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$idEvento, $idUsuario]);
}

public function getEventoDetallePublico($idEvento) {
    $sql = "SELECT e.*, 
                   me.NOMBRE AS MODALIDAD,
                   te.NOMBRE AS TIPO,
                   ca.NOMBRE_CARRERA AS CARRERA,
                   ce.NOMBRE AS CATEGORIA,
                   (SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA' LIMIT 1) AS PORTADA
            FROM evento e
            LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
            LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
            LEFT JOIN carrera ca ON e.SECUENCIALCARRERA = ca.SECUENCIAL
            LEFT JOIN categoria_evento ce ON e.SECUENCIALCATEGORIA = ce.SECUENCIAL
            WHERE e.SECUENCIAL = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idEvento]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    // Organizadores
    $stmtOrg = $this->pdo->prepare("SELECT u.NOMBRES, u.APELLIDOS FROM usuario u
                                    INNER JOIN organizador_evento oe ON u.SECUENCIAL = oe.SECUENCIALUSUARIO
                                    WHERE oe.SECUENCIALEVENTO = ?");
    $stmtOrg->execute([$idEvento]);
    $evento['ORGANIZADORES'] = $stmtOrg->fetchAll(PDO::FETCH_ASSOC);

    // Requisitos
    $stmtReq = $this->pdo->prepare("SELECT r.NOMBRE FROM requisito r
                                    INNER JOIN requisito_evento re ON r.SECUENCIAL = re.SECUENCIALREQUISITO
                                    WHERE re.SECUENCIALEVENTO = ?");
    $stmtReq->execute([$idEvento]);
    $evento['REQUISITOS'] = $stmtReq->fetchAll(PDO::FETCH_COLUMN);

    return $evento;
}
public function getEventosEnCursoInscrito($idUsuario) {
    $sql = "
        SELECT 
            e.SECUENCIAL,
            e.TITULO,
            e.FECHAINICIO,
            e.FECHAFIN,
            e.ESTADO,
            (SELECT URL_IMAGEN 
             FROM imagen_evento 
             WHERE SECUENCIALEVENTO = e.SECUENCIAL 
               AND TIPO_IMAGEN = 'PORTADA' 
             LIMIT 1) AS PORTADA
        FROM evento e
        INNER JOIN inscripcion i ON e.SECUENCIAL = i.SECUENCIALEVENTO
        WHERE i.SECUENCIALUSUARIO = ?
          AND CURDATE() BETWEEN e.FECHAINICIO AND e.FECHAFIN
          AND e.ESTADO = 'DISPONIBLE'
        ORDER BY e.FECHAINICIO DESC
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




}
