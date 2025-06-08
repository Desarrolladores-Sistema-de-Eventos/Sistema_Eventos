<?php
// controllers/RecuperaContrasenaController.php
require_once '../models/Usuarios.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$token = trim($input['token'] ?? '');
$nueva_contrasena = $input['nueva_contrasena'] ?? '';

if (!$token || !$nueva_contrasena) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos.']);
    exit;
}

$usuario = Usuario::buscarPorTokenRecuperacion($token);
if (!$usuario) {
    http_response_code(400);
    echo json_encode(['error' => 'Token inválido.']);
    exit;
}

// Validar expiración del token
if (strtotime($usuario['token_expiracion']) < time()) {
    http_response_code(400);
    echo json_encode(['error' => 'El enlace ha expirado. Solicita uno nuevo.']);
    exit;
}

// Actualizar contraseña (cifrada)
$hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
$ok = Usuario::actualizarContrasenaYLimpiarToken($usuario['SECUENCIAL'], $hash);
if (!$ok) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo actualizar la contraseña.']);
    exit;
}

echo json_encode(['ok' => true]);
