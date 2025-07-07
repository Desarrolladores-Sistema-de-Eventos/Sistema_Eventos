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
                ce.NOMBRE AS CATEGORIA,
                (SELECT GROUP_CONCAT(c.NOMBRE_CARRERA SEPARATOR ', ')
                 FROM evento_carrera ec
                 JOIN carrera c ON ec.SECUENCIALCARRERA = c.SECUENCIAL
                 WHERE ec.SECUENCIALEVENTO = e.SECUENCIAL) AS CARRERAS
            FROM evento e
            INNER JOIN organizador_evento oe ON e.SECUENCIAL = oe.SECUENCIALEVENTO
            LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
            LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
            LEFT JOIN categoria_evento ce ON e.SECUENCIALCATEGORIA = ce.SECUENCIAL
            WHERE oe.SECUENCIALUSUARIO = ?
              AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'
              AND e.ESTADO IN ('DISPONIBLE', 'EN CURSO', 'FINALIZADO', 'CANCELADO')
            ORDER BY e.FECHAINICIO DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventosPublicos($filtros = []) {
        $sql = "SELECT DISTINCT
                    e.SECUENCIAL,
                    e.TITULO,
                    e.DESCRIPCION,
                    e.FECHAINICIO,
                    e.FECHAFIN,
                    e.HORAS,
                    e.COSTO,
                    e.ESTADO,
                    e.CAPACIDAD,
                    me.NOMBRE AS MODALIDAD,
                    te.NOMBRE AS TIPO,
                    ce.NOMBRE AS CATEGORIA,
                    (SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA' LIMIT 1) AS PORTADA,
                    (SELECT GROUP_CONCAT(c.NOMBRE_CARRERA SEPARATOR ', ')
                     FROM evento_carrera ec_inner
                     JOIN carrera c ON ec_inner.SECUENCIALCARRERA = c.SECUENCIAL
                     WHERE ec_inner.SECUENCIALEVENTO = e.SECUENCIAL) AS CARRERAS
                FROM evento e
                LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
                LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
                LEFT JOIN categoria_evento ce ON e.SECUENCIALCATEGORIA = ce.SECUENCIAL
                ";
    
        $params = [];
        $where = ["e.ESTADO = 'DISPONIBLE'"];
    
        if (!empty($filtros['carrera'])) {
            $sql .= " JOIN evento_carrera ec ON e.SECUENCIAL = ec.SECUENCIALEVENTO ";
            $where[] = "ec.SECUENCIALCARRERA = ?";
            $params[] = $filtros['carrera'];
        }
        if (!empty($filtros['tipo'])) {
            $where[] = "e.CODIGOTIPOEVENTO = ?";
            $params[] = $filtros['tipo'];
        }
        if (!empty($filtros['categoria'])) {
            $where[] = "e.SECUENCIALCATEGORIA = ?";
            $params[] = $filtros['categoria'];
        }
        if (!empty($filtros['modalidad'])) {
            $where[] = "e.CODIGOMODALIDAD = ?";
            $params[] = $filtros['modalidad'];
        }
        if (!empty($filtros['fecha'])) {
            $where[] = "e.FECHAINICIO >= ?";
            $params[] = $filtros['fecha'];
        }
        if (!empty($filtros['busqueda'])) {
            $where[] = "(e.TITULO LIKE ? OR e.DESCRIPCION LIKE ?)";
            $params[] = '%' . $filtros['busqueda'] . '%';
            $params[] = '%' . $filtros['busqueda'] . '%';
        }
    
        if (count($where) > 0) {
            $sql .= " WHERE " . implode(' AND ', $where);
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

    public function getEvento($idEvento, $idUsuarioResponsable = null){
        if ($idUsuarioResponsable) {
            // Verificar que el usuario sea responsable de este evento
            $stmt = $this->pdo->prepare("SELECT * FROM EVENTO e INNER JOIN organizador_evento oe ON e.SECUENCIAL = oe.SECUENCIALEVENTO WHERE e.SECUENCIAL = ? AND oe.SECUENCIALUSUARIO = ? AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'");
            $stmt->execute([$idEvento, $idUsuarioResponsable]);
            $evento = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM EVENTO WHERE SECUENCIAL = ?");
            $stmt->execute([$idEvento]);
            $evento = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        if (!$evento) return false;
        // Obtener requisitos asociados
        $stmtReq = $this->pdo->prepare("SELECT SECUENCIAL FROM REQUISITO_EVENTO WHERE SECUENCIALEVENTO = ?");
        $stmtReq->execute([$idEvento]);
        $requisitos = $stmtReq->fetchAll(PDO::FETCH_COLUMN); // devuelve array de SECUENCIAL
        $evento['REQUISITOS'] = $requisitos;
        // Obtener carreras asociadas (como array de IDs)
        $stmtCarreras = $this->pdo->prepare("SELECT SECUENCIALCARRERA FROM EVENTO_CARRERA WHERE SECUENCIALEVENTO = ?");
        $stmtCarreras->execute([$idEvento]);
        $evento['carreras'] = $stmtCarreras->fetchAll(PDO::FETCH_COLUMN);
        // Público destino (ES_SOLO_INTERNOS)
        $evento['publicoDestino'] = $evento['ES_SOLO_INTERNOS'] ?? null;
        return $evento;
    }

public function crearEvento($titulo, $descripcion, $horas, $fechaInicio, $fechaFin, $modalidad,
                            $notaAprobacion, $costo, $publicoDestino, $esPagado,
                            $categoria, $tipo, $carreras, $estado, $idUsuario,
                            $urlPortada, $urlGaleria, $capacidad)
{
    $sql = "INSERT INTO evento (
        TITULO, DESCRIPCION, HORAS, FECHAINICIO, FECHAFIN, 
        CODIGOMODALIDAD, NOTAAPROBACION, COSTO, ES_SOLO_INTERNOS, 
        ES_PAGADO, SECUENCIALCATEGORIA, CODIGOTIPOEVENTO, 
        ESTADO, CAPACIDAD
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        $titulo, $descripcion, $horas, $fechaInicio, $fechaFin, 
        $modalidad, $notaAprobacion, $costo, $publicoDestino, 
        $esPagado, $categoria, $tipo, $estado, $capacidad
    ]);

    $idEvento = $this->pdo->lastInsertId();

    // Guardar carreras en la tabla intermedia
    if (!empty($carreras) && is_array($carreras)) {
        // Si se selecciona 'Todas las carreras' (ID 0), solo guardar esa opción
        if (in_array('0', $carreras) || in_array(0, $carreras)) {
            $stmtCarrera = $this->pdo->prepare("INSERT INTO evento_carrera (SECUENCIALEVENTO, SECUENCIALCARRERA) VALUES (?, ?)");
            $stmtCarrera->execute([$idEvento, 0]);
        } else {
            // Si no, guardar solo las carreras seleccionadas (sin 0)
            foreach ($carreras as $idCarrera) {
                if ($idCarrera !== '0' && $idCarrera !== 0) {
                    $stmtCarrera = $this->pdo->prepare("INSERT INTO evento_carrera (SECUENCIALEVENTO, SECUENCIALCARRERA) VALUES (?, ?)");
                    $stmtCarrera->execute([$idEvento, $idCarrera]);
                }
            }
        }
    }

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

    // Insertar imagen de galería si existe
    if ($urlGaleria) {
        $imgStmt = $this->pdo->prepare("INSERT INTO imagen_evento (SECUENCIALEVENTO, URL_IMAGEN, TIPO_IMAGEN) VALUES (?, ?, 'GALERIA')");
        $imgStmt->execute([$idEvento, $urlGaleria]);
    }

    return $idEvento;
}

public function actualizarEvento($titulo, $descripcion, $horas, $fechaInicio, $fechaFin, $modalidad,
                                 $notaAprobacion, $costo, $publicoDestino, $esPagado,
                                 $categoria, $tipo, $carreras, $estado, $idEvento, $idUsuario,
                                 $urlPortada, $urlGaleria, $capacidad)
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
                ESTADO = ?, 
                CAPACIDAD = ?
            WHERE SECUENCIAL = ?";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        $titulo, $descripcion, $horas, $fechaInicio, $fechaFin,
        $modalidad, $notaAprobacion, $costo, $publicoDestino,
        $esPagado, $categoria, $tipo, $estado, $capacidad, $idEvento
    ]);

    // Actualizar carreras en la tabla intermedia
    $this->pdo->prepare("DELETE FROM evento_carrera WHERE SECUENCIALEVENTO = ?")->execute([$idEvento]);
    if (!empty($carreras) && is_array($carreras)) {
        // Si se selecciona 'Todas las carreras' (valor 0), solo guardar esa opción
        if (in_array('0', $carreras) || in_array(0, $carreras)) {
            $stmtCarrera = $this->pdo->prepare("INSERT INTO evento_carrera (SECUENCIALEVENTO, SECUENCIALCARRERA) VALUES (?, ?)");
            $stmtCarrera->execute([$idEvento, 0]);
        } else {
            // Si no, guardar solo las carreras seleccionadas (sin 0)
            foreach ($carreras as $idCarrera) {
                if ($idCarrera !== '0' && $idCarrera !== 0) {
                    $stmtCarrera = $this->pdo->prepare("INSERT INTO evento_carrera (SECUENCIALEVENTO, SECUENCIALCARRERA) VALUES (?, ?)");
                    $stmtCarrera->execute([$idEvento, $idCarrera]);
                }
            }
        }
    }

    // Actualizar imagen de portada si se recibe una nueva
    if ($urlPortada) {
        $delStmt = $this->pdo->prepare("DELETE FROM imagen_evento WHERE SECUENCIALEVENTO = ? AND TIPO_IMAGEN = 'PORTADA'");
        $delStmt->execute([$idEvento]);
        $imgStmt = $this->pdo->prepare("INSERT INTO imagen_evento (SECUENCIALEVENTO, URL_IMAGEN, TIPO_IMAGEN) VALUES (?, ?, 'PORTADA')");
        $imgStmt->execute([$idEvento, $urlPortada]);
    }

    // Actualizar imagen de galería si se recibe una nueva
    if ($urlGaleria) {
        $delStmt = $this->pdo->prepare("DELETE FROM imagen_evento WHERE SECUENCIALEVENTO = ? AND TIPO_IMAGEN = 'GALERIA'");
        $delStmt->execute([$idEvento]);
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

    // Eliminar el evento (ON DELETE CASCADE se encargará de evento_carrera)
    $stmt2 = $this->pdo->prepare("DELETE FROM evento WHERE SECUENCIAL = ?");
    return $stmt2->execute([$idEvento]);
}

public function cancelarEvento($idEvento) {
    $sql = "UPDATE evento SET ESTADO = 'CANCELADO' WHERE SECUENCIAL = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$idEvento]);
}

public function getEventoDetallePublico($idEvento) {
    $sql = "SELECT e.*, 
                   me.NOMBRE AS MODALIDAD,
                   te.NOMBRE AS TIPO,
                   ce.NOMBRE AS CATEGORIA,
                   (SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA' LIMIT 1) AS PORTADA
            FROM evento e
            LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
            LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
            LEFT JOIN categoria_evento ce ON e.SECUENCIALCATEGORIA = ce.SECUENCIAL
            WHERE e.SECUENCIAL = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idEvento]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$evento) {
        return null;
    }

    // Carreras
    $stmtCarreras = $this->pdo->prepare("
        SELECT c.NOMBRE_CARRERA
        FROM carrera c
        JOIN evento_carrera ec ON c.SECUENCIAL = ec.SECUENCIALCARRERA
        WHERE ec.SECUENCIALEVENTO = ?
    ");
    $stmtCarreras->execute([$idEvento]);
    $evento['CARRERAS'] = $stmtCarreras->fetchAll(PDO::FETCH_COLUMN);

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
            e.CONTENIDO,
            t.NOMBRE AS TIPO_EVENTO,
            (
                SELECT URL_IMAGEN 
                FROM imagen_evento 
                WHERE SECUENCIALEVENTO = e.SECUENCIAL 
                  AND TIPO_IMAGEN = 'PORTADA' 
                LIMIT 1
            ) AS PORTADA
        FROM evento e
        INNER JOIN inscripcion i ON e.SECUENCIAL = i.SECUENCIALEVENTO
        INNER JOIN tipo_evento t ON e.CODIGOTIPOEVENTO = t.CODIGO
        WHERE i.SECUENCIALUSUARIO = ?
          AND i.CODIGOESTADOINSCRIPCION = 'ACE'
          AND e.ESTADO IN ('DISPONIBLE', 'EN CURSO', 'FINALIZADO')
        ORDER BY e.FECHAINICIO DESC
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function validarDisponibilidadInscripcion($idEvento, $idUsuario) {
    $stmt = $this->pdo->prepare("SELECT FECHAFIN, CAPACIDAD FROM evento WHERE SECUENCIAL = ?");
    $stmt->execute([$idEvento]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$evento) {
        return ['disponible' => false, 'mensaje' => 'Evento no encontrado.'];
    }

    $fechaActual = new DateTime();
    $fechaFin = new DateTime($evento['FECHAFIN']);

    if ($fechaActual > $fechaFin) {
        return ['disponible' => false, 'mensaje' => 'El evento ya ha finalizado.'];
    }

    if (!is_null($evento['CAPACIDAD'])) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM inscripcion WHERE SECUENCIALEVENTO = ?");
        $stmt->execute([$idEvento]);
        $inscritos = $stmt->fetchColumn();

        if ($inscritos >= $evento['CAPACIDAD']) {
            return ['disponible' => false, 'mensaje' => 'Cupos agotados.'];
        }
    }

    // NUEVA VALIDACIÓN: Verificar si ya está inscrito
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM inscripcion WHERE SECUENCIALEVENTO = ? AND SECUENCIALUSUARIO = ?");
    $stmt->execute([$idEvento, $idUsuario]);
    $yaInscrito = $stmt->fetchColumn() > 0;

    if ($yaInscrito) {
        return ['disponible' => false, 'mensaje' => 'Ya estás inscrito en este evento.'];
    }

    return ['disponible' => true, 'mensaje' => 'Inscripción permitida.'];
}

 

public function registrarInscripcion($idUsuario, $idEvento, $monto, $formaPago, $esPagado, $archivosRequisitos, $archivoPago)
{
    try {
        $this->pdo->beginTransaction();

        // 1. Insertar en inscripcion (CODIGOESTADOINSCRIPCION = 'PEN', FACTURA_URL = comprobante si aplica)
        $stmt = $this->pdo->prepare("
            INSERT INTO inscripcion (
                SECUENCIALUSUARIO, 
                SECUENCIALEVENTO, 
                FECHAINSCRIPCION, 
                FACTURA_URL, 
                CODIGOESTADOINSCRIPCION
            ) VALUES (?, ?, NOW(), ?, 'PEN')
        ");
        $stmt->execute([$idUsuario, $idEvento, $archivoPago]);
        $idInscripcion = $this->pdo->lastInsertId();

        // 2. Insertar archivos en archivo_requisito (CODIGOESTADOVALIDACION = 'PEN')
        foreach ($archivosRequisitos as $idRequisito => $rutaArchivo) {
            $stmt = $this->pdo->prepare("
                INSERT INTO archivo_requisito (
                    SECUENCIALINSCRIPCION, 
                    SECUENCIALREQUISITO, 
                    URLARCHIVO, 
                    CODIGOESTADOVALIDACION
                ) VALUES (?, ?, ?, 'PEN')
            ");
            $stmt->execute([$idInscripcion, $idRequisito, $rutaArchivo]);
        }

        // 3. Insertar pago si corresponde (CODIGOESTADOPAGO = 'PEN')
        if ($esPagado && $archivoPago) {
            $stmt = $this->pdo->prepare("
                INSERT INTO pago (
                    SECUENCIALINSCRIPCION, 
                    CODIGOFORMADEPAGO, 
                    COMPROBANTE_URL, 
                    CODIGOESTADOPAGO, 
                    FECHA_PAGO,
                    MONTO
                ) VALUES (?, ?, ?, 'PEN', NOW(), ?)
            ");
            $stmt->execute([$idInscripcion, $formaPago, $archivoPago, $monto]);
        }

        $this->pdo->commit();
        return true;
    } catch (Exception $e) {
        $this->pdo->rollBack();
        echo json_encode([
        'tipo' => 'error',
        'mensaje' => $e->getMessage() ,
        'debug' => $e->getMessage() // 👈 esto mostrará el error en el frontend (¡solo mientras pruebas!)
    ]);
    exit; 
    }
}

public function registrarInscripcionBasica($idUsuario, $idEvento)
{
    // 1. Insertar inscripción
    $stmt = $this->pdo->prepare("
        INSERT INTO inscripcion (SECUENCIALUSUARIO, SECUENCIALEVENTO, FECHAINSCRIPCION, CODIGOESTADOINSCRIPCION)
        VALUES (?, ?, NOW(), 'PEN')
    ");
    $stmt->execute([$idUsuario, $idEvento]);

    // 2. Obtener ID de la inscripción recién creada
    $idInscripcion = $this->pdo->lastInsertId();

    // ✅ 3. Obtener requisitos del evento (sin JOIN)
    $stmt = $this->pdo->prepare("
        SELECT SECUENCIAL, DESCRIPCION 
        FROM requisito_evento 
        WHERE SECUENCIALEVENTO = ?
    ");
    $stmt->execute([$idEvento]);
    $requisitosEvento = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. Obtener los documentos del usuario
    require_once '../models/Usuarios.php';
    $usuarioModel = new Usuario();
    $usuario = $usuarioModel->getById2($idUsuario); // debe contener URL_CEDULA y URL_MATRICULA

    // 5. Registrar archivos ya existentes en la tabla archivo_requisito
    foreach ($requisitosEvento as $req) {
        $descripcion = strtolower($req['DESCRIPCION']);
        $idRequisito = $req['SECUENCIAL'];

        $archivoExistente = null;

        if (str_contains($descripcion, 'cédula') && !empty($usuario['URL_CEDULA'])) {
            $archivoExistente = $usuario['URL_CEDULA'];
        } elseif (str_contains($descripcion, 'matrícula') && !empty($usuario['URL_MATRICULA'])) {
            $archivoExistente = $usuario['URL_MATRICULA'];
        }

        if ($archivoExistente) {
            $stmtArchivo = $this->pdo->prepare("
                INSERT INTO archivo_requisito (
                    SECUENCIALINSCRIPCION, 
                    SECUENCIALREQUISITO, 
                    URLARCHIVO, 
                    CODIGOESTADOVALIDACION
                ) VALUES (?, ?, ?, 'PEN')
            ");
            $stmtArchivo->execute([$idInscripcion, $idRequisito, $archivoExistente]);
        }
    }

    return true;
}

public function actualizarArchivosInscripcion($idInscripcion, $archivosRequisitos, $esPagado, $formaPago, $monto, $comprobanteNombre)
{
    try {
        $this->pdo->beginTransaction();

        // Guardar o actualizar archivos de requisitos
        foreach ($archivosRequisitos as $idRequisito => $archivoNombre) {
            // Verificar si ya existe
            $stmtCheck = $this->pdo->prepare("
                SELECT COUNT(*) AS total 
                FROM archivo_requisito 
                WHERE SECUENCIALINSCRIPCION = ? AND SECUENCIALREQUISITO = ?
            ");
            $stmtCheck->execute([$idInscripcion, $idRequisito]);
            $existe = $stmtCheck->fetchColumn();

            if ($existe > 0) {
                // Actualizar
                $stmtUpdate = $this->pdo->prepare("
                    UPDATE archivo_requisito 
                    SET URLARCHIVO = ?, CODIGOESTADOVALIDACION = 'PEN' 
                    WHERE SECUENCIALINSCRIPCION = ? AND SECUENCIALREQUISITO = ?
                ");
                $stmtUpdate->execute([$archivoNombre, $idInscripcion, $idRequisito]);
            } else {
                // Insertar
                $stmtInsert = $this->pdo->prepare("
                    INSERT INTO archivo_requisito 
                    (SECUENCIALINSCRIPCION, SECUENCIALREQUISITO, URLARCHIVO, CODIGOESTADOVALIDACION) 
                    VALUES (?, ?, ?, 'PEN')
                ");
                $stmtInsert->execute([$idInscripcion, $idRequisito, $archivoNombre]);
            }
        }

        // Procesar comprobante de pago
        if ($esPagado && $comprobanteNombre) {
            // Verificar si ya existe pago
            $stmtCheckPago = $this->pdo->prepare("
                SELECT COUNT(*) AS total FROM pago WHERE SECUENCIALINSCRIPCION = ?
            ");
            $stmtCheckPago->execute([$idInscripcion]);
            $existePago = $stmtCheckPago->fetchColumn();

            if ($existePago > 0) {
                // Update pago
                $stmtPago = $this->pdo->prepare("
                    UPDATE pago 
                    SET CODIGOFORMADEPAGO = ?, COMPROBANTE_URL = ?, MONTO = ?, FECHA_PAGO = NOW(), CODIGOESTADOPAGO = 'PEN' 
                    WHERE SECUENCIALINSCRIPCION = ?
                ");
                $stmtPago->execute([$formaPago, $comprobanteNombre, $monto, $idInscripcion]);
            } else {
                // Insert pago
                $stmtPago = $this->pdo->prepare("
                    INSERT INTO pago 
                    (SECUENCIALINSCRIPCION, CODIGOFORMADEPAGO, COMPROBANTE_URL, MONTO, FECHA_PAGO, CODIGOESTADOPAGO) 
                    VALUES (?, ?, ?, ?, NOW(), 'PEN')
                ");
                $stmtPago->execute([$idInscripcion, $formaPago, $comprobanteNombre, $monto]);
            }
        }

        $this->pdo->commit();
        return true;

    } catch (Exception $e) {
    $this->pdo->rollBack();
    $this->ultimoError = $e->getMessage(); // ← Captura el mensaje
    error_log("Error actualizando inscripción: " . $e->getMessage());
    return false;
}
}

public function getRequisitosPorEvento($idEvento)
{
    $stmt = $this->pdo->prepare("SELECT r.SECUENCIAL, r.DESCRIPCION FROM requisito_evento re
                                 INNER JOIN requisito r ON re.SECUENCIALREQUISITO = r.SECUENCIAL
                                 WHERE re.SECUENCIALEVENTO = ?");
    $stmt->execute([$idEvento]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getRequisitosEventoDetallado($idEvento)
{
    $sql = "SELECT SECUENCIAL, DESCRIPCION 
            FROM requisito_evento 
            WHERE SECUENCIALEVENTO = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idEvento]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getArchivoRequisito($idUsuario, $idRequisito, $idEvento)
{
    $sql = "SELECT ar.URLARCHIVO 
            FROM archivo_requisito ar
            JOIN inscripcion i ON i.SECUENCIAL = ar.SECUENCIALINSCRIPCION
            WHERE ar.SECUENCIALREQUISITO = ?
              AND i.SECUENCIALUSUARIO = ?
              AND i.SECUENCIALEVENTO = ?
            LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idRequisito, $idUsuario, $idEvento]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function getComprobantePago($idInscripcion)
{
    $stmt = $this->pdo->prepare("SELECT COMPROBANTE_URL FROM pago WHERE SECUENCIALINSCRIPCION = ?");
    $stmt->execute([$idInscripcion]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getEventosPorCarrera($idCarrera) {
    $sql = "SELECT 
                e.SECUENCIAL,
                e.TITULO,
                e.FECHAINICIO,
                e.FECHAFIN,
                e.HORAS,
                e.COSTO,
                e.ESTADO,
                me.NOMBRE AS MODALIDAD,
                te.NOMBRE AS TIPO,
                ce.NOMBRE AS CATEGORIA
            FROM evento e
            LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
            LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
            LEFT JOIN categoria_evento ce ON e.SECUENCIALCATEGORIA = ce.SECUENCIAL
            JOIN evento_carrera ec ON e.SECUENCIAL = ec.SECUENCIALEVENTO
            WHERE ec.SECUENCIALCARRERA = ?
            ORDER BY e.FECHAINICIO DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idCarrera]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getEventosPorCategoriaYCarrera($idCategoria, $idCarrera) {
    $sql = "SELECT 
                e.SECUENCIAL,
                e.TITULO,
                e.FECHAINICIO,
                e.FECHAFIN,
                e.HORAS,
                e.COSTO,
                e.ESTADO,
                me.NOMBRE AS MODALIDAD,
                te.NOMBRE AS TIPO
            FROM evento e
            LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
            LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
            JOIN evento_carrera ec ON e.SECUENCIAL = ec.SECUENCIALEVENTO
            WHERE e.SECUENCIALCATEGORIA = ?
              AND ec.SECUENCIALCARRERA = ?
            ORDER BY e.FECHAINICIO DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idCategoria, $idCarrera]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
