<?php
require_once '../core/Conexion.php';
$db = Database::getConnection();
class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerUsuarios() {
        $sql = "SELECT * FROM usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertarUsuario($data) {
        $sql = "INSERT INTO usuario (NOMBRES, APELLIDOS, FECHA_NACIMIENTO, TELEFONO, DIRECCION, CORREO, CONTRASENA, CODIGOROL, CODIGOESTADO, ES_INTERNO)
                VALUES (:nombres, :apellidos, :fecha_nacimiento, :telefono, :direccion, :correo, :contrasena, :codigorol, 'ACTIVO', 1)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombres' => $data['nombre'],
            ':apellidos' => $data['apellido'],
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':telefono' => $data['telefono'],
            ':direccion' => $data['direccion'],
            ':correo' => $data['correo'],
            ':contrasena' => $data['contrasena'],
            ':codigorol' => $data['rol'],
        ]);
    }

    public function editarUsuario($id, $data) {
        $sql = "UPDATE usuario SET NOMBRES=:nombres, APELLIDOS=:apellidos, FECHA_NACIMIENTO=:fecha_nacimiento, TELEFONO=:telefono, DIRECCION=:direccion, CORREO=:correo, CODIGOROL=:codigorol WHERE SECUENCIAL=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombres' => $data['nombre'],
            ':apellidos' => $data['apellido'],
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':telefono' => $data['telefono'],
            ':direccion' => $data['direccion'],
            ':correo' => $data['correo'],
            ':codigorol' => $data['rol'],
            ':id' => $id
        ]);
    }

    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuario WHERE SECUENCIAL=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT * FROM usuario WHERE SECUENCIAL=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>