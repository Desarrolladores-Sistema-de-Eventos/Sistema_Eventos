<?php
// controllers/RecuperaContrasenaController.php
require_once '../models/Usuarios.php';
header('Content-Type: application/json');

// Leer y decodificar entrada JSON
$input = json_decode(file_get_contents('php://input'), true);
$token = trim($input['token'] ?? '');
$nueva_contrasena = trim($input['nueva_contrasena'] ?? '');

// Validar datos requeridos
if (!$token || !$nueva_contrasena) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos.']);
    exit;
}

// Buscar al usuario con ese token y verificar expiración
$usuario = Usuario::buscarPorTokenRecuperacion($token);
if (!$usuario) {
    http_response_code(400);
    echo json_encode(['error' => 'Token inválido o expirado.']);
    exit;
}

// Validar que el token no haya expirado
if (strtotime($usuario['token_expiracion']) < time()) {
    http_response_code(400);
    echo json_encode(['error' => 'El enlace ha expirado. Solicita uno nuevo.']);
    exit;
}

// Actualizar la contraseña (sin encriptarla aquí)
$ok = Usuario::actualizarContrasenaYLimpiarToken($usuario['SECUENCIAL'], $nueva_contrasena);

// Verificar resultado
if (!$ok) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo actualizar la contraseña.']);
    exit;
}

// Todo correcto
echo json_encode(['ok' => true]);
