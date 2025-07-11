<?php
require_once '../core/Conexion.php';

class Evento {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    public function listar() {
        $sql = "SELECT e.*, 
                       me.NOMBRE AS MODALIDAD,
                       te.NOMBRE AS TIPO,
                       ce.NOMBRE AS CATEGORIA
                FROM evento e
                LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
                LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
                LEFT JOIN categoria_evento ce ON e.SECUENCIALCATEGORIA = ce.SECUENCIAL
                ORDER BY e.FECHAINICIO DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM evento WHERE SECUENCIAL = ?");
        $stmt->execute([$id]);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($evento) {
            $evento['carreras'] = $this->getCarrerasPorEvento($id);
            // Obtener responsable y organizador
            $stmtOrg = $this->pdo->prepare("SELECT SECUENCIALUSUARIO, ROL_ORGANIZADOR FROM organizador_evento WHERE SECUENCIALEVENTO = ?");
            $stmtOrg->execute([$id]);
            $orgs = $stmtOrg->fetchAll(PDO::FETCH_ASSOC);
            $evento['responsable'] = '';
            $evento['organizador'] = '';
            foreach ($orgs as $org) {
                if ($org['ROL_ORGANIZADOR'] === 'RESPONSABLE') {
                    $evento['responsable'] = $org['SECUENCIALUSUARIO'];
                } else if ($org['ROL_ORGANIZADOR'] === 'ORGANIZADOR') {
                    $evento['organizador'] = $org['SECUENCIALUSUARIO'];
                }
            }
        }
        return $evento;
    }

 public function crear($data) {
    $sql = "INSERT INTO evento (TITULO, DESCRIPCION, HORAS, FECHAINICIO, FECHAFIN, CODIGOMODALIDAD, NOTAAPROBACION, COSTO, ES_SOLO_INTERNOS, ES_PAGADO, SECUENCIALCATEGORIA, CODIGOTIPOEVENTO, ESTADO, CAPACIDAD, ES_DESTACADO, ASISTENCIAMINIMA)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->pdo->prepare($sql);
    $ok = $stmt->execute([
        $data['titulo'], $data['descripcion'], $data['horas'], $data['fechaInicio'], $data['fechaFin'],
        $data['modalidad'], $data['notaAprobacion'], $data['costo'], $data['esSoloInternos'], $data['esPagado'],
        $data['categoria'], $data['tipoEvento'], $data['estado'], $data['capacidad'], $data['esDestacado'] ?? 0, $data['asistenciaMinima'] ?? null
    ]);

    if (!$ok) return false;

    $idEvento = $this->pdo->lastInsertId();

    // Guardar carreras en la tabla intermedia
    if (!empty($data['carreras']) && is_array($data['carreras'])) {
        foreach ($data['carreras'] as $idCarrera) {
            $stmtCarrera = $this->pdo->prepare("INSERT INTO EVENTO_CARRERA (SECUENCIALEVENTO, SECUENCIALCARRERA) VALUES (?, ?)");
            $stmtCarrera->execute([$idEvento, $idCarrera]);
        }
    }

    $this->asignarOrganizador($idEvento, $data['responsable'], 'RESPONSABLE');
    $this->asignarOrganizador($idEvento, $data['organizador'], 'ORGANIZADOR');

    // ✅ Definir variables
    $urlPortada = $data['urlPortada'] ?? null;
    $urlGaleria = $data['urlGaleria'] ?? null;

    if ($urlPortada) {
        $imgStmt = $this->pdo->prepare("INSERT INTO imagen_evento (SECUENCIALEVENTO, URL_IMAGEN, TIPO_IMAGEN) VALUES (?, ?, 'PORTADA')");
        $imgStmt->execute([$idEvento, $urlPortada]);
    }

    if ($urlGaleria) {
        $imgStmt = $this->pdo->prepare("INSERT INTO imagen_evento (SECUENCIALEVENTO, URL_IMAGEN, TIPO_IMAGEN) VALUES (?, ?, 'GALERIA')");
        $imgStmt->execute([$idEvento, $urlGaleria]);
    }

    return $idEvento;
}

public function editar($id, $data) {
    $sql = "UPDATE evento SET TITULO=?, DESCRIPCION=?, HORAS=?, FECHAINICIO=?, FECHAFIN=?, CODIGOMODALIDAD=?, NOTAAPROBACION=?, COSTO=?, ES_SOLO_INTERNOS=?, ES_PAGADO=?, SECUENCIALCATEGORIA=?, CODIGOTIPOEVENTO=?, ESTADO=?, ES_DESTACADO=?, ASISTENCIAMINIMA=? WHERE SECUENCIAL=?";
    $stmt = $this->pdo->prepare($sql);
    $ok = $stmt->execute([
        $data['titulo'], $data['descripcion'], $data['horas'], $data['fechaInicio'], $data['fechaFin'],
        $data['modalidad'], $data['notaAprobacion'], $data['costo'], $data['esSoloInternos'], $data['esPagado'],
        $data['categoria'], $data['tipoEvento'], $data['estado'], $data['esDestacado'] ?? 0, $data['asistenciaMinima'] ?? null, $id
    ]);

    if (!$ok) return false;

    // Actualizar carreras en la tabla intermedia
    $this->pdo->prepare("DELETE FROM EVENTO_CARRERA WHERE SECUENCIALEVENTO = ?")->execute([$id]);
    if (!empty($data['carreras']) && is_array($data['carreras'])) {
        foreach ($data['carreras'] as $idCarrera) {
            $stmtCarrera = $this->pdo->prepare("INSERT INTO EVENTO_CARRERA (SECUENCIALEVENTO, SECUENCIALCARRERA) VALUES (?, ?)");
            $stmtCarrera->execute([$id, $idCarrera]);
        }
    }

    $this->actualizarOrganizador($id, $data['responsable'], 'RESPONSABLE');
    $this->actualizarOrganizador($id, $data['organizador'], 'ORGANIZADOR');

    // ✅ Definir variables
    $urlPortada = $data['urlPortada'] ?? null;
    $urlGaleria = $data['urlGaleria'] ?? null;

    if ($urlPortada) {
        $this->pdo->prepare("DELETE FROM imagen_evento WHERE SECUENCIALEVENTO = ? AND TIPO_IMAGEN = 'PORTADA'")
                  ->execute([$id]);

        $this->pdo->prepare("INSERT INTO imagen_evento (SECUENCIALEVENTO, URL_IMAGEN, TIPO_IMAGEN) VALUES (?, ?, 'PORTADA')")
                  ->execute([$id, $urlPortada]);
    }

    if ($urlGaleria) {
        $this->pdo->prepare("DELETE FROM imagen_evento WHERE SECUENCIALEVENTO = ? AND TIPO_IMAGEN = 'GALERIA'")
                  ->execute([$id]);

        $this->pdo->prepare("INSERT INTO imagen_evento (SECUENCIALEVENTO, URL_IMAGEN, TIPO_IMAGEN) VALUES (?, ?, 'GALERIA')")
                  ->execute([$id, $urlGaleria]);
    }

    return true;
}

   
  public function eliminar($id) {
    try {
        // 1. Eliminar archivo_requisito relacionados a inscripciones de este evento
        $stmt = $this->pdo->prepare("SELECT SECUENCIAL FROM inscripcion WHERE SECUENCIALEVENTO=?");
        $stmt->execute([$id]);
        $inscripciones = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($inscripciones) {
            // Eliminar archivos de requisito de todas las inscripciones de este evento
            $in = implode(',', array_fill(0, count($inscripciones), '?'));
            $delArchivos = $this->pdo->prepare("DELETE FROM archivo_requisito WHERE SECUENCIALINSCRIPCION IN ($in)");
            $delArchivos->execute($inscripciones);
        }

        // 2. Eliminar pagos relacionados a inscripciones de este evento
        if ($inscripciones) {
            $in = implode(',', array_fill(0, count($inscripciones), '?'));
            $delPagos = $this->pdo->prepare("DELETE FROM pago WHERE SECUENCIALINSCRIPCION IN ($in)");
            $delPagos->execute($inscripciones);
        }

        // 3. Eliminar inscripciones del evento
        $delInscripciones = $this->pdo->prepare("DELETE FROM inscripcion WHERE SECUENCIALEVENTO=?");
        $delInscripciones->execute([$id]);

        // 4. Eliminar asistencia_nota relacionadas al evento
        $stmtAsist = $this->pdo->prepare("DELETE FROM asistencia_nota WHERE SECUENCIALEVENTO=?");
        $stmtAsist->execute([$id]);

        // 5. Eliminar imágenes asociadas al evento
        $stmtImg = $this->pdo->prepare("DELETE FROM imagen_evento WHERE SECUENCIALEVENTO=?");
        $stmtImg->execute([$id]);

        // 6. Eliminar requisitos asociados al evento
        $stmtReq = $this->pdo->prepare("DELETE FROM requisito_evento WHERE SECUENCIALEVENTO=?");
        $stmtReq->execute([$id]);

        // 7. Eliminar organizadores asociados
        $stmtOrg = $this->pdo->prepare("SELECT SECUENCIAL FROM organizador_evento WHERE SECUENCIALEVENTO=?");
        $stmtOrg->execute([$id]);
        $organizadores = $stmtOrg->fetchAll(PDO::FETCH_COLUMN);

        // 7.1 Eliminar imagen_organizador_evento asociadas a organizadores de este evento
        // Comentado porque la tabla no existe en la base de datos
        // if ($organizadores) {
        //     $in = implode(',', array_fill(0, count($organizadores), '?'));
        //     $delImgOrg = $this->pdo->prepare("DELETE FROM imagen_organizador_evento WHERE SECUENCIALEVENTO IN ($in)");
        //     $delImgOrg->execute($organizadores);
        // }

        // 7.2 Eliminar organizador_evento
        $stmtOrgDel = $this->pdo->prepare("DELETE FROM organizador_evento WHERE SECUENCIALEVENTO=?");
        $stmtOrgDel->execute([$id]);

        // 8. Eliminar certificados asociados al evento
        $stmtCert = $this->pdo->prepare("DELETE FROM certificado WHERE SECUENCIALEVENTO=?");
        $stmtCert->execute([$id]);

        // 9. Finalmente elimina el evento
        $stmtEvt = $this->pdo->prepare("DELETE FROM evento WHERE SECUENCIAL=?");
        $ok = $stmtEvt->execute([$id]);

        return $ok;
    } catch (PDOException $e) {
        throw new Exception("No se pudo eliminar el evento: " . $e->getMessage());
    }
}

    public function cancelar($id) {
        $stmt = $this->pdo->prepare("UPDATE evento SET ESTADO='CANCELADO' WHERE SECUENCIAL=?");
        return $stmt->execute([$id]);
    }

    private function asignarOrganizador($idEvento, $idUsuario, $rol) {
        if (!$idUsuario) return;
        $stmt = $this->pdo->prepare("INSERT INTO organizador_evento (SECUENCIALEVENTO, SECUENCIALUSUARIO, ROL_ORGANIZADOR) VALUES (?, ?, ?)");
        $stmt->execute([$idEvento, $idUsuario, $rol]);
    }

    private function actualizarOrganizador($idEvento, $idUsuario, $rol) {
        // Elimina el anterior y pone el nuevo
        $stmt = $this->pdo->prepare("DELETE FROM organizador_evento WHERE SECUENCIALEVENTO=? AND ROL_ORGANIZADOR=?");
        $stmt->execute([$idEvento, $rol]);
        $this->asignarOrganizador($idEvento, $idUsuario, $rol);
    }

    public function getOrganizadores() {
        // Devuelve lista de usuarios para select
        $stmt = $this->pdo->query("SELECT SECUENCIAL, CONCAT(NOMBRES, ' ', APELLIDOS) AS NOMBRE FROM usuario WHERE CODIGOESTADO='ACTIVO'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCarreras() {
    $stmt = $this->pdo->query("SELECT SECUENCIAL, NOMBRE_CARRERA FROM carrera");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getTiposEvento() {
    $stmt = $this->pdo->query("SELECT CODIGO, NOMBRE, REQUIERENOTA, REQUIEREASISTENCIA FROM tipo_evento");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getModalidades() {
    $stmt = $this->pdo->query("SELECT CODIGO, NOMBRE FROM modalidad_evento");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getCategorias() {
    $stmt = $this->pdo->query("SELECT SECUENCIAL, NOMBRE FROM categoria_evento");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getEstados() {
    return [
        ['value' => 'DISPONIBLE', 'text' => 'Disponible'],
        ['value' => 'CERRADO', 'text' => 'Cerrado'],
        ['value' => 'CANCELADO', 'text' => 'Cancelado']
    ];
}

public function getCarrerasPorEvento($idEvento) {
    $stmt = $this->pdo->prepare("SELECT SECUENCIALCARRERA FROM EVENTO_CARRERA WHERE SECUENCIALEVENTO = ?");
    $stmt->execute([$idEvento]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

}
?>
