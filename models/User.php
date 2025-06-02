<?php
require_once '../core/Conexion.php';

class User {
    public static function registrar($data) {
        $db = Conexion::getConexion();

        $stmt = $db->prepare("SELECT 1 FROM USUARIO WHERE CORREO = ?");
        $stmt->execute([$data['correo']]);
        if ($stmt->fetch()) {
            return ['error' => "El correo ya está registrado."];
        }

        $stmt = $db->prepare("
            INSERT INTO USUARIO (NOMBRES, APELLIDOS, TELEFONO, DIRECCION, CORREO, CONTRASENA, CODIGOROL)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $ok = $stmt->execute([
            $data['nombres'],
            $data['apellidos'],
            $data['telefono'],
            $data['direccion'],
            $data['correo'],
            password_hash($data['contrasena'], PASSWORD_DEFAULT),
            $data['rol']
        ]);

        if ($ok) {
            return ['success' => true];
        } else {
            return ['error' => "Error al registrar usuario."];
        }
    }
}