<?php
require_once '../core/Conexion.php';

class Evento {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    public function listar() {
        $sql = "SELECT e.*, 
                       e.CONTENIDO AS CONTENIDO, 
                       e.DESCRIPCION AS DESCRIPCION, 
                       me.NOMBRE AS MODALIDAD,
                       te.NOMBRE AS TIPO,
                       ce.NOMBRE AS CATEGORIA,
                       (
                         SELECT URL_IMAGEN 
                         FROM imagen_evento ie 
                         WHERE ie.SECUENCIALEVENTO = e.SECUENCIAL AND ie.TIPO_IMAGEN = 'PORTADA' 
                         ORDER BY ie.SECUENCIAL DESC LIMIT 1
                       ) AS URLPORTADA
                FROM evento e
                LEFT JOIN modalidad_evento me ON e.CODIGOMODALIDAD = me.CODIGO
                LEFT JOIN tipo_evento te ON e.CODIGOTIPOEVENTO = te.CODIGO
                LEFT JOIN categoria_evento ce ON e.SECUENCIALCATEGORIA = ce.SECUENCIAL
                ORDER BY e.FECHAINICIO DESC";
        $stmt = $this->pdo->query($sql);
        $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Agregar carreras asociadas a cada evento
        foreach ($eventos as &$evento) {
            $evento['CARRERAS'] = $this->getCarrerasEvento($evento['SECUENCIAL']);
            // Ajustar la URL de la portada si existe
            if (!empty($evento['URLPORTADA'])) {
                if (strpos($evento['URLPORTADA'], '../public/img/eventos/portadas/') === false) {
                    $evento['URLPORTADA'] = '../public/img/eventos/portadas/' . ltrim($evento['URLPORTADA'], '/');
                }
            } else {
                $evento['URLPORTADA'] = null;
            }
            // Garantizar que los nuevos campos estén presentes
            if (!isset($evento['CONTENIDO'])) $evento['CONTENIDO'] = '';
            if (!isset($evento['ASISTENCIAMINIMA'])) $evento['ASISTENCIAMINIMA'] = '';
        }
        return $eventos;
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM evento WHERE SECUENCIAL = ?");
        $stmt->execute([$id]);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);
        // Obtener carreras asociadas
        $evento['CARRERAS'] = $this->getCarrerasEvento($id);
        // Obtener responsable y organizador (nombre y apellido)
        $orgStmt = $this->pdo->prepare("SELECT SECUENCIALUSUARIO, ROL_ORGANIZADOR FROM organizador_evento WHERE SECUENCIALEVENTO = ?");
        $orgStmt->execute([$id]);
        $orgs = $orgStmt->fetchAll(PDO::FETCH_ASSOC);
        $evento['RESPONSABLE'] = '';
        $evento['RESPONSABLE_NOMBRE'] = '';
        $evento['ORGANIZADOR'] = '';
        $evento['ORGANIZADOR_NOMBRE'] = '';
        foreach ($orgs as $org) {
            $userStmt = $this->pdo->prepare("SELECT SECUENCIAL, NOMBRES, APELLIDOS FROM usuario WHERE SECUENCIAL = ?");
            $userStmt->execute([$org['SECUENCIALUSUARIO']]);
            $user = $userStmt->fetch(PDO::FETCH_ASSOC);
            if ($org['ROL_ORGANIZADOR'] === 'RESPONSABLE') {
                $evento['RESPONSABLE'] = $user['SECUENCIAL'];
                $evento['RESPONSABLE_NOMBRE'] = $user['NOMBRES'] . ' ' . $user['APELLIDOS'];
            } elseif ($org['ROL_ORGANIZADOR'] === 'ORGANIZADOR') {
                $evento['ORGANIZADOR'] = $user['SECUENCIAL'];
                $evento['ORGANIZADOR_NOMBRE'] = $user['NOMBRES'] . ' ' . $user['APELLIDOS'];
            }
        }
        // Obtener nombre de la imagen de portada (última subida)
        $imgPortadaStmt = $this->pdo->prepare("SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = ? AND TIPO_IMAGEN = 'PORTADA' ORDER BY SECUENCIAL DESC LIMIT 1");
        $imgPortadaStmt->execute([$id]);
        $urlPortada = $imgPortadaStmt->fetchColumn();
        $evento['NOMBRE_PORTADA'] = $urlPortada ? basename($urlPortada) : '';
        // Obtener nombre de la imagen de galería (última subida)
        $imgGaleriaStmt = $this->pdo->prepare("SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = ? AND TIPO_IMAGEN = 'GALERIA' ORDER BY SECUENCIAL DESC LIMIT 1");
        $imgGaleriaStmt->execute([$id]);
        $urlGaleria = $imgGaleriaStmt->fetchColumn();
        $evento['NOMBRE_GALERIA'] = $urlGaleria ? basename($urlGaleria) : '';
        // Garantizar que los nuevos campos estén presentes
        if (!isset($evento['CONTENIDO'])) $evento['CONTENIDO'] = '';
        if (!isset($evento['ASISTENCIAMINIMA'])) $evento['ASISTENCIAMINIMA'] = '';
        return $evento;
    }

    // Devuelve array de IDs de carreras asociadas a un evento
    private function getCarrerasEvento($idEvento) {
        $stmt = $this->pdo->prepare("SELECT SECUENCIALCARRERA FROM evento_carrera WHERE SECUENCIALEVENTO = ?");
        $stmt->execute([$idEvento]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

 public function crear($data) {
    $sql = "INSERT INTO evento (TITULO, CONTENIDO, DESCRIPCION, HORAS, FECHAINICIO, FECHAFIN, CODIGOMODALIDAD, NOTAAPROBACION, COSTO, ES_SOLO_INTERNOS, ES_PAGADO, SECUENCIALCATEGORIA, CODIGOTIPOEVENTO, ESTADO, CAPACIDAD, ES_DESTACADO, ASISTENCIAMINIMA)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->pdo->prepare($sql);
    $ok = $stmt->execute([
        $data['titulo'],
        isset($data['contenido']) ? $data['contenido'] : '',
        isset($data['descripcion']) ? $data['descripcion'] : '',
        $data['horas'],
        $data['fechaInicio'],
        $data['fechaFin'],
        $data['modalidad'],
        $data['notaAprobacion'],
        $data['costo'],
        $data['esSoloInternos'],
        $data['esPagado'],
        $data['categoria'],
        $data['tipoEvento'],
        $data['estado'],
        $data['capacidad'],
        isset($data['esDestacado']) ? $data['esDestacado'] : 0,
        isset($data['asistenciaMinima']) ? $data['asistenciaMinima'] : null
    ]);

    if (!$ok) return false;

    $idEvento = $this->pdo->lastInsertId();

    if (!empty($data['carrera']) && is_array($data['carrera'])) {
        $carrerasUnicas = array_unique(array_filter($data['carrera'], function($v) { return $v !== '' && $v !== null; }));
        foreach ($carrerasUnicas as $idCarrera) {
            $stmtCarrera = $this->pdo->prepare("INSERT INTO evento_carrera (SECUENCIALEVENTO, SECUENCIALCARRERA) VALUES (?, ?)");
            $stmtCarrera->execute([$idEvento, $idCarrera]);
        }
    }

    $this->asignarOrganizador($idEvento, $data['responsable'], 'RESPONSABLE');
    $this->asignarOrganizador($idEvento, $data['organizador'], 'ORGANIZADOR');

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
    $sql = "UPDATE evento SET TITULO=?, CONTENIDO=?, DESCRIPCION=?, HORAS=?, FECHAINICIO=?, FECHAFIN=?, CODIGOMODALIDAD=?, NOTAAPROBACION=?, COSTO=?, ES_SOLO_INTERNOS=?, ES_PAGADO=?, SECUENCIALCATEGORIA=?, CODIGOTIPOEVENTO=?, ESTADO=?, ES_DESTACADO=?, ASISTENCIAMINIMA=?
            WHERE SECUENCIAL=?";
    $stmt = $this->pdo->prepare($sql);
    $ok = $stmt->execute([
        $data['titulo'],
        isset($data['contenido']) ? $data['contenido'] : '',
        isset($data['descripcion']) ? $data['descripcion'] : '',
        $data['horas'],
        $data['fechaInicio'],
        $data['fechaFin'],
        $data['modalidad'],
        $data['notaAprobacion'],
        $data['costo'],
        $data['esSoloInternos'],
        $data['esPagado'],
        $data['categoria'],
        $data['tipoEvento'],
        $data['estado'],
        isset($data['esDestacado']) ? $data['esDestacado'] : 0,
        isset($data['asistenciaMinima']) ? $data['asistenciaMinima'] : null,
        $id
    ]);

    if (!$ok) return false;

    // Actualizar carreras asociadas
    $this->pdo->prepare("DELETE FROM evento_carrera WHERE SECUENCIALEVENTO = ?")->execute([$id]);
    if (!empty($data['carrera']) && is_array($data['carrera'])) {
        $carrerasUnicas = array_unique(array_filter($data['carrera'], function($v) { return $v !== '' && $v !== null; }));
        foreach ($carrerasUnicas as $idCarrera) {
            $stmtCarrera = $this->pdo->prepare("INSERT INTO evento_carrera (SECUENCIALEVENTO, SECUENCIALCARRERA) VALUES (?, ?)");
            $stmtCarrera->execute([$id, $idCarrera]);
        }
    }

    // Si responsable/organizador viene vacío, conservar el anterior
    $getOrg = function($idEvento, $rol) {
        $stmt = $this->pdo->prepare("SELECT SECUENCIALUSUARIO FROM organizador_evento WHERE SECUENCIALEVENTO=? AND ROL_ORGANIZADOR=? LIMIT 1");
        $stmt->execute([$idEvento, $rol]);
        return $stmt->fetchColumn();
    };
    $responsable = isset($data['responsable']) && $data['responsable'] !== '' ? $data['responsable'] : $getOrg($id, 'RESPONSABLE');
    $organizador = isset($data['organizador']) && $data['organizador'] !== '' ? $data['organizador'] : $getOrg($id, 'ORGANIZADOR');
    $this->actualizarOrganizador($id, $responsable, 'RESPONSABLE');
    $this->actualizarOrganizador($id, $organizador, 'ORGANIZADOR');

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

        // 7.1 Eliminar imagen_organizador_evento asociadas a organizadores de este evento (solo si la tabla existe)
        /*
        if ($organizadores) {
            $in = implode(',', array_fill(0, count($organizadores), '?'));
            $delImgOrg = $this->pdo->prepare("DELETE FROM imagen_organizador_evento WHERE SECUENCIAL_ORGANIZADOR_EVENTO IN ($in)");
            $delImgOrg->execute($organizadores);
        }
        */

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
    $stmt = $this->pdo->query("SELECT CODIGO, NOMBRE FROM tipo_evento");
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

}
?>
