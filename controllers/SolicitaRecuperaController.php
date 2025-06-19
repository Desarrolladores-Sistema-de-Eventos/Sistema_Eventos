<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../models/Usuarios.php';
require_once __DIR__ . '/../vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$correo = trim($input['correo'] ?? '');

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Correo electrónico no válido']);
    exit;
}

$usuario = Usuario::buscarPorCorreo($correo);
if (!$usuario) {
    http_response_code(404);
    echo json_encode(['error' => 'Correo no registrado']);
    exit;
}

$token = bin2hex(random_bytes(32));
$expiracion = date('Y-m-d H:i:s', strtotime('+2 minutes'));

$ok = Usuario::guardarTokenRecuperacion($usuario['SECUENCIAL'], $token, $expiracion);
if (!$ok) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo generar el enlace.']);
    exit;
}

$enlace = 'http://' . $_SERVER['HTTP_HOST'] . '/Sistema_Eventos/views/restablacer_contrasena.php?token=' . $token;
$asunto = 'Recuperación de contraseña - ' . date('d/m/Y H:i');
$mensaje = "Hola " . $usuario['NOMBRES'] . ",\n\n" .
    "Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en el Sistema de Eventos.\n" .
    "Si no realizaste esta solicitud, puedes ignorar este mensaje.\n\n" .
    "Para restablecer tu contraseña, haz clic en el siguiente enlace o pégalo en tu navegador:\n$enlace\n\n" .
    "Este enlace expirará en 2 minutos por seguridad.\n\n" .
    "Si tienes problemas, contacta a soporte@uta.edu.ec.\n\n" .
    "Saludos,\nEquipo de Soporte - Sistema de Eventos UTA";

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'andrealdj289@gmail.com';
    $mail->Password = 'byipwjuhbqtoiiqv'; // Contraseña de aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('andrealdj289@gmail.com', 'Sistema de Eventos');
    $mail->addAddress($correo);
    $mail->isHTML(false);
    $mail->Subject = $asunto;
    $mail->Body    = $mensaje;

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->send();
    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'No se pudo enviar el correo: ' . $mail->ErrorInfo . ' | Exception: ' . $e->getMessage()
    ]);
}
