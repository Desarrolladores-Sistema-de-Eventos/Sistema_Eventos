<?php
require_once '../core/Conexion.php';

class Usuario {
    public static function login($correo, $contrasena) {
    $db = Conexion::getConexion();

    $stmt = $db->prepare("
        SELECT u.*, r.NOMBRE AS ROL
        FROM USUARIO u
        JOIN ROL_USUARIO r ON u.CODIGOROL = r.CODIGO
        WHERE u.CORREO = ?
    ");

    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && $contrasena === $usuario['CONTRASENA']) {
        unset($usuario['CONTRASENA']);
        return $usuario;
    }

    return null;
}

}
