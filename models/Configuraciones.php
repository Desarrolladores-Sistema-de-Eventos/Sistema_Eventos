<?php
require_once '../core/Conexion.php';

class Configuraciones {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    // ================= FACULTAD =================
    public function crearFacultad($nombre, $mision, $vision, $ubicacion) {
        $sql = "INSERT INTO facultad (NOMBRE, MISION, VISION, UBICACION) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nombre, $mision, $vision, $ubicacion]);
        return $this->pdo->lastInsertId();
    }
    public function obtenerFacultades() {
        $sql = "SELECT * FROM facultad";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizarFacultad($id, $nombre, $mision, $vision, $ubicacion) {
        $sql = "UPDATE facultad SET NOMBRE = ?, MISION = ?, VISION = ?, UBICACION = ? WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nombre, $mision, $vision, $ubicacion, $id]);
    }
    public function eliminarFacultad($id) {
        $sql = "DELETE FROM facultad WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // ================= CARRERA =================
    public function crearCarrera($nombre, $idFacultad) {
        $sql = "INSERT INTO carrera (NOMBRE_CARRERA, SECUENCIALFACULTAD) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nombre, $idFacultad]);
        return $this->pdo->lastInsertId();
    }
    public function obtenerCarreras() {
        $sql = "SELECT * FROM carrera";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizarCarrera($id, $nombre, $idFacultad) {
        $sql = "UPDATE carrera SET NOMBRE_CARRERA = ?, SECUENCIALFACULTAD = ? WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nombre, $idFacultad, $id]);
    }
    public function eliminarCarrera($id) {
        $sql = "DELETE FROM carrera WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // ================= TIPO EVENTO =================
    public function crearTipoEvento($codigo, $nombre, $descripcion) {
        $sql = "INSERT INTO tipo_evento (CODIGO, NOMBRE, DESCRIPCION) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codigo, $nombre, $descripcion]);
        return $codigo;
    }
    public function obtenerTiposEvento() {
        $sql = "SELECT * FROM tipo_evento";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizarTipoEvento($codigo, $nombre, $descripcion) {
        $sql = "UPDATE tipo_evento SET NOMBRE = ?, DESCRIPCION = ? WHERE CODIGO = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $codigo]);
    }
    public function eliminarTipoEvento($codigo) {
        $sql = "DELETE FROM tipo_evento WHERE CODIGO = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$codigo]);
    }

    // ================= CATEGORIA EVENTO =================
    public function crearCategoriaEvento($nombre, $descripcion) {
        $sql = "INSERT INTO categoria_evento (NOMBRE, DESCRIPCION) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nombre, $descripcion]);
        return $this->pdo->lastInsertId();
    }
    public function obtenerCategoriasEvento() {
        $sql = "SELECT * FROM categoria_evento";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizarCategoriaEvento($id, $nombre, $descripcion) {
        $sql = "UPDATE categoria_evento SET NOMBRE = ?, DESCRIPCION = ? WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $id]);
    }
    public function eliminarCategoriaEvento($id) {
        $sql = "DELETE FROM categoria_evento WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // ================= MODALIDAD EVENTO =================
    public function crearModalidadEvento($codigo, $nombre) {
        $sql = "INSERT INTO modalidad_evento (CODIGO, NOMBRE) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codigo, $nombre]);
        return $codigo;
    }
    public function obtenerModalidadesEvento() {
        $sql = "SELECT * FROM modalidad_evento";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizarModalidadEvento($codigo, $nombre) {
        $sql = "UPDATE modalidad_evento SET NOMBRE = ? WHERE CODIGO = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nombre, $codigo]);
    }
    public function eliminarModalidadEvento($codigo) {
        $sql = "DELETE FROM modalidad_evento WHERE CODIGO = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$codigo]);
    }

    // ================= REQUISITO EVENTO =================
    public function crearRequisitoEvento($descripcion, $idEvento = null, $esObligatorio = null) {
        // Solo permite insertar si $idEvento es null (requisito general)
        if ($idEvento !== null) {
            return false; // No inserta si se intenta asociar a un evento específico
        }
        $sql = "INSERT INTO requisito_evento (DESCRIPCION, SECUENCIALEVENTO, ES_OBLIGATORIO) VALUES (?, NULL, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$descripcion, $esObligatorio]);
        return $this->pdo->lastInsertId();
    }
    public function obtenerRequisitosEvento() {
        $sql = "SELECT * FROM requisito_evento WHERE SECUENCIALEVENTO IS NULL";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizarRequisitoEvento($id, $descripcion, $idEvento = null, $esObligatorio = null) {
        $sql = "UPDATE requisito_evento SET DESCRIPCION = ?, SECUENCIALEVENTO = ?, ES_OBLIGATORIO = ? WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$descripcion, $idEvento, $esObligatorio, $id]);
    }
    public function eliminarRequisitoEvento($id) {
        $sql = "DELETE FROM requisito_evento WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // ================= FORMA DE PAGO =================
    public function crearFormaPago($codigo, $nombre) {
        $sql = "INSERT INTO forma_pago (CODIGO, NOMBRE) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codigo, $nombre]);
        return $codigo;
    }
    public function obtenerFormasPago() {
        $sql = "SELECT * FROM forma_pago";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizarFormaPago($codigo, $nombre) {
        $sql = "UPDATE forma_pago SET NOMBRE = ? WHERE CODIGO = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nombre, $codigo]);
    }
    public function eliminarFormaPago($codigo) {
        $sql = "DELETE FROM forma_pago WHERE CODIGO = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$codigo]);
    }

    // ================= ROL USUARIO =================
    public function crearRolUsuario($codigo, $nombre) {
        $sql = "INSERT INTO rol_usuario (CODIGO, NOMBRE) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codigo, $nombre]);
        return $codigo;
    }
    public function obtenerRolesUsuario() {
        $sql = "SELECT * FROM rol_usuario";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizarRolUsuario($codigo, $nombre) {
        $sql = "UPDATE rol_usuario SET NOMBRE = ? WHERE CODIGO = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nombre, $codigo]);
    }
    public function eliminarRolUsuario($codigo) {
        $sql = "DELETE FROM rol_usuario WHERE CODIGO = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$codigo]);
    }
}
