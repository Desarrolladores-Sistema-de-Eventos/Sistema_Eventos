<?php

require_once '../core/Conexion.php'; 

class EventoPublico {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    public function obtenerEventosDisponibles($page = 1, $limit = 6) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT 
                    e.SECUENCIAL,
                    e.TITULO,
                    e.COSTO,
                    e.CAPACIDAD,
                    t.NOMBRE AS TIPO_EVENTO,
                    e.HORAS,
                    e.ESTADO,
                    (SELECT COUNT(*) FROM inscripcion i WHERE i.SECUENCIALEVENTO = e.SECUENCIAL) AS INSCRITOS,
                    (e.CAPACIDAD - (SELECT COUNT(*) FROM inscripcion i WHERE i.SECUENCIALEVENTO = e.SECUENCIAL)) AS DISPONIBLES,
                    (SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA' LIMIT 1) AS PORTADA
                FROM evento e
                INNER JOIN tipo_evento t ON e.CODIGOTIPOEVENTO = t.CODIGO
                WHERE e.ESTADO = 'DISPONIBLE'
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarEventosDisponibles() {
        $sql = "SELECT COUNT(*) as total FROM evento WHERE ESTADO = 'DISPONIBLE'";
        $result = $this->pdo->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getEventoDetallePublico($idEvento) {
        $sql = "SELECT 
                    e.SECUENCIAL,
                    e.TITULO,
                    e.DESCRIPCION,
                    e.FECHAINICIO,
                    e.FECHAFIN,
                    e.HORAS,
                    e.NOTAAPROBACION,
                    e.COSTO,
                    e.ESTADO,
                    e.CAPACIDAD,
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

        if (!$evento) return null;

        $stmtCarr = $this->pdo->prepare("SELECT c.NOMBRE_CARRERA FROM evento_carrera ec JOIN carrera c ON ec.secuencial_carrera = c.SECUENCIAL WHERE ec.SECUENCIALEVENTO = ?");
        $stmtCarr->execute([$idEvento]);
        $evento['CARRERAS'] = $stmtCarr->fetchAll(PDO::FETCH_COLUMN);

        $sqlReq = "SELECT r.DESCRIPCION FROM requisito_evento re
                   INNER JOIN requisito r ON re.SECUENCIALREQUISITO = r.SECUENCIAL
                   WHERE re.SECUENCIALEVENTO = ?";
        $stmtReq = $this->pdo->prepare($sqlReq);
        $stmtReq->execute([$idEvento]);
        $evento['REQUISITOS'] = $stmtReq->fetchAll(PDO::FETCH_COLUMN);

        $sqlOrg = "SELECT u.NOMBRES, u.APELLIDOS, u.CORREO 
                   FROM organizador_evento oe
                   INNER JOIN usuario u ON oe.SECUENCIALUSUARIO = u.SECUENCIAL
                   WHERE oe.SECUENCIALEVENTO = ? AND oe.ROL_ORGANIZADOR = 'RESPONSABLE'";
        $stmtOrg = $this->pdo->prepare($sqlOrg);
        $stmtOrg->execute([$idEvento]);
        $evento['ORGANIZADORES'] = $stmtOrg->fetchAll(PDO::FETCH_ASSOC);

        return $evento;
    }

    public function listarCategorias2() {
        $sql = "SELECT ce.SECUENCIAL, ce.NOMBRE, COUNT(e.SECUENCIAL) AS TOTAL
                FROM categoria_evento ce
                LEFT JOIN evento e ON ce.SECUENCIAL = e.SECUENCIALCATEGORIA
                GROUP BY ce.SECUENCIAL, ce.NOMBRE";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarEventos($keyword) {
        $sql = "SELECT 
                    e.SECUENCIAL,
                    e.TITULO,
                    e.COSTO,
                    e.CAPACIDAD,
                    t.NOMBRE AS TIPO_EVENTO,
                    e.HORAS,
                    e.ESTADO,
                    (SELECT COUNT(*) FROM inscripcion i WHERE i.SECUENCIALEVENTO = e.SECUENCIAL) AS INSCRITOS,
                    (e.CAPACIDAD - (SELECT COUNT(*) FROM inscripcion i WHERE i.SECUENCIALEVENTO = e.SECUENCIAL)) AS DISPONIBLES,
                    (SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA' LIMIT 1) AS PORTADA
                FROM evento e
                INNER JOIN tipo_evento t ON e.CODIGOTIPOEVENTO = t.CODIGO
                WHERE e.ESTADO = 'DISPONIBLE' AND (e.TITULO LIKE ? OR e.DESCRIPCION LIKE ?)";
        
        $stmt = $this->pdo->prepare($sql);
        $like = "%$keyword%";
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eventosRecientes($limite = 3) {
        $sql = "SELECT 
                    e.SECUENCIAL,
                    e.TITULO,
                    e.FECHAINICIO,
                    (SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA' LIMIT 1) AS PORTADA
                FROM evento e
                WHERE e.ESTADO = 'DISPONIBLE'
                ORDER BY e.FECHAINICIO DESC
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filtrarEventos($filtros = [], $page = 1, $limit = 6) {
        $offset = ($page - 1) * $limit;
        $params = [];
        $baseSql = "FROM evento e 
                     INNER JOIN tipo_evento t ON e.CODIGOTIPOEVENTO = t.CODIGO";
        $where = ["e.ESTADO = 'DISPONIBLE'"];

        if (!empty($filtros['carrera'])) {
            $baseSql .= " JOIN evento_carrera ec ON e.SECUENCIAL = ec.SECUENCIALEVENTO";
            $where[] = 'ec.SECUENCIALEVENTO = ?';
            $params[] = $filtros['carrera'];
        }

        if (!empty($filtros['tipo'])) {
            $where[] = 'e.CODIGOTIPOEVENTO = ?';
            $params[] = $filtros['tipo'];
        }
        if (!empty($filtros['categoria'])) {
            $where[] = 'e.SECUENCIALCATEGORIA = ?';
            $params[] = $filtros['categoria'];
        }
        if (!empty($filtros['modalidad'])) {
            $where[] = 'e.CODIGOMODALIDAD = ?';
            $params[] = $filtros['modalidad'];
        }
        if (!empty($filtros['fecha'])) {
            $where[] = 'e.FECHAINICIO >= ?';
            $params[] = $filtros['fecha'];
        }
        if (!empty($filtros['busqueda'])) {
            $where[] = 'e.TITULO LIKE ?';
            $params[] = '%' . $filtros['busqueda'] . '%';
        }

        $sql = "SELECT DISTINCT e.SECUENCIAL, e.TITULO, e.COSTO, e.CAPACIDAD, t.NOMBRE AS TIPO_EVENTO, e.HORAS, e.ESTADO,
                       (SELECT COUNT(*) FROM inscripcion i WHERE i.SECUENCIALEVENTO = e.SECUENCIAL) AS INSCRITOS,
                       (e.CAPACIDAD - (SELECT COUNT(*) FROM inscripcion i WHERE i.SECUENCIALEVENTO = e.SECUENCIAL)) AS DISPONIBLES,
                       (SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA' LIMIT 1) AS PORTADA
                $baseSql 
                WHERE " . implode(' AND ', $where) . "
                LIMIT $limit OFFSET $offset";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarEventosFiltrados($filtros = []) {
        $params = [];
        $baseSql = "FROM evento e";
        $where = ["e.ESTADO = 'DISPONIBLE'"];

        if (!empty($filtros['carrera'])) {
            $baseSql .= " JOIN evento_carrera ec ON e.SECUENCIAL = ec.SECUENCIALEVENTO";
            $where[] = 'ec.SECUENCIALEVENTO = ?';
            $params[] = $filtros['carrera'];
        }

        if (!empty($filtros['tipo'])) {
            $where[] = 'e.CODIGOTIPOEVENTO = ?';
            $params[] = $filtros['tipo'];
        }
        if (!empty($filtros['categoria'])) {
            $where[] = 'e.SECUENCIALCATEGORIA = ?';
            $params[] = $filtros['categoria'];
        }
        if (!empty($filtros['modalidad'])) {
            $where[] = 'e.CODIGOMODALIDAD = ?';
            $params[] = $filtros['modalidad'];
        }
        if (!empty($filtros['fecha'])) {
            $where[] = 'e.FECHAINICIO >= ?';
            $params[] = $filtros['fecha'];
        }
        if (!empty($filtros['busqueda'])) {
            $where[] = 'e.TITULO LIKE ?';
            $params[] = '%' . $filtros['busqueda'] . '%';
        }

        $sql = "SELECT COUNT(DISTINCT e.SECUENCIAL) as total $baseSql WHERE " . implode(' AND ', $where);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function listarTipos() {
        $sql = "SELECT CODIGO, NOMBRE FROM tipo_evento";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listarCategorias() {
        $sql = "SELECT SECUENCIAL, NOMBRE FROM categoria_evento";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listarModalidades() {
        $sql = "SELECT CODIGO, NOMBRE FROM modalidad_evento";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarCarreras() {
        $sql = "SELECT SECUENCIAL, NOMBRE_CARRERA AS NOMBRE FROM carrera";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventoDetalleCompleto($idEvento) {
        $sql = "SELECT 
                    e.*,
                    t.NOMBRE AS TIPO_EVENTO,
                    m.NOMBRE AS MODALIDAD,
                    c.NOMBRE AS CATEGORIA
                FROM evento e
                LEFT JOIN tipo_evento t ON e.CODIGOTIPOEVENTO = t.CODIGO
                LEFT JOIN modalidad_evento m ON e.CODIGOMODALIDAD = m.CODIGO
                LEFT JOIN categoria_evento c ON e.SECUENCIALCATEGORIA = c.SECUENCIAL
                WHERE e.SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idEvento]);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$evento) return null;

        $sqlGaleria = "SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = ? AND TIPO_IMAGEN = 'GALERIA'";
        $stmtGaleria = $this->pdo->prepare($sqlGaleria);
        $stmtGaleria->execute([$idEvento]);
        $evento['GALERIA'] = $stmtGaleria->fetchAll(PDO::FETCH_COLUMN);

        $sqlReq = "SELECT DESCRIPCION FROM requisito_evento WHERE SECUENCIALEVENTO = ?";
        $stmtReq = $this->pdo->prepare($sqlReq);
        $stmtReq->execute([$idEvento]);
        $evento['REQUISITOS'] = $stmtReq->fetchAll(PDO::FETCH_COLUMN);

        $sqlOrg = "SELECT u.NOMBRES, u.APELLIDOS, u.CORREO, u.FOTO_PERFIL, o.ROL_ORGANIZADOR
                   FROM organizador_evento o
                   JOIN usuario u ON o.SECUENCIALUSUARIO = u.SECUENCIAL
                   WHERE o.SECUENCIALEVENTO = ? AND o.ROL_ORGANIZADOR = 'ORGANIZADOR' LIMIT 1";
        $stmtOrg = $this->pdo->prepare($sqlOrg);
        $stmtOrg->execute([$idEvento]);
        $evento['ORGANIZADOR'] = $stmtOrg->fetch(PDO::FETCH_ASSOC);

        return $evento;
    }

    public function obtenerEventosDestacados($limit = 10) {
        $sql = "SELECT DISTINCT e.SECUENCIAL, e.TITULO, e.DESCRIPCION, e.FECHAINICIO, e.COSTO, e.HORAS,
                       t.NOMBRE AS TIPO_EVENTO,
                       (SELECT URL_IMAGEN FROM imagen_evento WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA' LIMIT 1) AS PORTADA
                FROM evento e
                LEFT JOIN tipo_evento t ON e.CODIGOTIPOEVENTO = t.CODIGO
                WHERE e.ESTADO = 'DISPONIBLE' 
                AND e.ES_DESTACADO = 1
                AND EXISTS (SELECT 1 FROM imagen_evento WHERE SECUENCIALEVENTO = e.SECUENCIAL AND TIPO_IMAGEN = 'PORTADA')
                GROUP BY e.SECUENCIAL
                ORDER BY e.FECHAINICIO ASC
                LIMIT :limit";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                INNER JOIN evento_carrera ec ON e.SECUENCIAL = ec.SECUENCIALEVENTO
                WHERE ec.SECUENCIALEVENTO = ?
                ORDER BY e.FECHAINICIO DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idCarrera]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}