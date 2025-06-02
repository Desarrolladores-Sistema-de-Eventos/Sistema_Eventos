<?php
require_once '../core/Conexion.php';

class Usuario {
    private $conn;
    
    // Constants for better maintenance
    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_INACTIVO = 'INACTIVO';
    const TABLAS_RELACIONES = ['evento', 'inscripcion', 'asistencia'];

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerUsuarios() {
        try {
            $sql = "SELECT * FROM usuario 
                    WHERE CODIGOESTADO = :estado 
                    ORDER BY SECUENCIAL DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':estado' => self::ESTADO_ACTIVO]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerUsuarios: " . $e->getMessage());
            return [];
        }
    }

public function tieneRelaciones($id) {
    try {
        $relaciones = [
            'inscripcion' => 'SECUENCIALUSUARIO',
            'asistencia_nota' => 'SECUENCIALUSUARIO',
            'organizador_evento' => 'SECUENCIALUSUARIO'
            // Agrega aquí otras tablas relacionadas si las tienes
        ];
        foreach ($relaciones as $tabla => $campo) {
            $checkTable = $this->conn->query("SHOW TABLES LIKE '$tabla'");
            if ($checkTable && $checkTable->rowCount() > 0) {
                $stmt = $this->conn->prepare("SELECT 1 FROM $tabla WHERE $campo = :id LIMIT 1");
                $stmt->execute([':id' => $id]);
                if ($stmt->fetch()) {
                    return true;
                }
            }
        }
        return false;
    } catch (PDOException $e) {
        error_log("Error en tieneRelaciones: " . $e->getMessage());
        return false;
    }

}
    public function obtenerUsuarioPorId($id) {
        try {
            $sql = "SELECT * FROM usuario WHERE SECUENCIAL = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerUsuarioPorId: " . $e->getMessage());
            return null;
        }
    }
public function insertarUsuario($data) {
    try {
        // Verificar si el correo ya existe
        $sqlCheck = "SELECT COUNT(*) FROM usuario WHERE CORREO = :correo";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->execute([':correo' => $data['correo']]);
        if ($stmtCheck->fetchColumn() > 0) {
            return [
                'success' => false,
                'message' => 'El correo electrónico ya está registrado'
            ];
        }

        $sql = "INSERT INTO usuario (
                    NOMBRES, APELLIDOS, FECHA_NACIMIENTO, TELEFONO, 
                    DIRECCION, CORREO, CONTRASENA, CODIGOROL, 
                    CODIGOESTADO, ES_INTERNO
                ) VALUES (
                    :nombres, :apellidos, :fecha_nacimiento, :telefono,
                    :direccion, :correo, :contrasena, :codigorol,
                    :estado, :es_interno
                )";
        
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            ':nombres' => $data['nombre'],
            ':apellidos' => $data['apellido'],
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':telefono' => $data['telefono'],
            ':direccion' => $data['direccion'],
            ':correo' => $data['correo'],
            ':contrasena' => password_hash($data['contrasena'], PASSWORD_DEFAULT),
            ':codigorol' => $data['rol'],
            ':estado' => self::ESTADO_ACTIVO,
            ':es_interno' => 1
        ]);
    
     return [
            'success' => $result,
            'message' => $result ? 'Usuario creado correctamente' : 'No se pudo crear el usuario'
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Error al crear usuario: ' . $e->getMessage()
        ];
    }
}
  
public function editarUsuario($id, $data) {
    try {
        // Validar correo único (excepto el usuario actual)
        $sqlCheck = "SELECT COUNT(*) FROM usuario WHERE CORREO = :correo AND SECUENCIAL != :id";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->execute([':correo' => $data['correo'], ':id' => $id]);
        if ($stmtCheck->fetchColumn() > 0) {
            return [
                'success' => false,
                'message' => 'El correo electrónico ya está registrado'
            ];
        }

        $this->conn->beginTransaction();

        $sql = "UPDATE usuario SET 
                NOMBRES = :nombres,
                APELLIDOS = :apellidos,
                FECHA_NACIMIENTO = :fecha_nacimiento,
                TELEFONO = :telefono,
                DIRECCION = :direccion,
                CORREO = :correo,
                CODIGOROL = :codigorol
                WHERE SECUENCIAL = :id";

        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            ':nombres' => $data['nombre'],
            ':apellidos' => $data['apellido'],
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':telefono' => $data['telefono'],
            ':direccion' => $data['direccion'],
            ':correo' => $data['correo'],
            ':codigorol' => $data['rol'],
            ':id' => $id
        ]);

        $this->conn->commit();
        return [
            'success' => $result,
            'message' => $result ? 'Usuario actualizado correctamente' : 'No se pudo actualizar el usuario'
        ];
    } catch (PDOException $e) {
        $this->conn->rollBack();
        return [
            'success' => false,
            'message' => 'Error al editar usuario: ' . $e->getMessage()
        ];
    }
}
public function eliminarFisico($id) {
    try {
        $this->conn->beginTransaction();
        
        // Verificar si el usuario existe antes de eliminar
        $checkSql = "SELECT COUNT(*) FROM usuario WHERE SECUENCIAL = :id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->execute([':id' => $id]);
        
        if ($checkStmt->fetchColumn() == 0) {
            throw new PDOException("Usuario no encontrado");
        }
        
        $sql = "DELETE FROM usuario WHERE SECUENCIAL = :id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([':id' => $id]);
        
        if (!$result) {
            throw new PDOException("Error al eliminar el usuario");
        }
        
        $this->conn->commit();
        return [
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ];
    } catch (PDOException $e) {
        $this->conn->rollBack();
        error_log("Error en eliminarFisico: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Error al eliminar el usuario: ' . $e->getMessage()
        ];
    }
}
public function eliminarLogico($id) {
    try {
        $this->conn->beginTransaction();
        
        // Verificar si el usuario existe
        $checkSql = "SELECT COUNT(*) FROM usuario WHERE SECUENCIAL = :id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->execute([':id' => $id]);
        
        if ($checkStmt->fetchColumn() == 0) {
            throw new PDOException("Usuario no encontrado");
        }
        
        $sql = "UPDATE usuario SET CODIGOESTADO = :estado 
                WHERE SECUENCIAL = :id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            ':estado' => self::ESTADO_INACTIVO,
            ':id' => $id
        ]);
        
        if (!$result) {
            throw new PDOException("Error al desactivar el usuario");
        }
        
        $this->conn->commit();
        return [
            'success' => true,
            'message' => 'Usuario desactivado correctamente'
        ];
    } catch (PDOException $e) {
        $this->conn->rollBack();
        error_log("Error en eliminarLogico: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Error al desactivar el usuario: ' . $e->getMessage()
        ];
    }
}
}