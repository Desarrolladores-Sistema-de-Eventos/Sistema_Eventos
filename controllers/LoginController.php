<?php
session_start();
require_once '../models/Usuarios.php';
require_once '../models/Eventos.php';

header('Content-Type: application/json');

class LoginController
{
    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $this->json(['error' => 'Método no permitido']);
            return;
        }

        $input = json_decode(file_get_contents("php://input"), true);
        $correo = trim($input['correo'] ?? '');
        $contrasena = trim($input['contrasena'] ?? '');

        if (empty($correo) || empty($contrasena)) {
            http_response_code(400);
            $this->json(['error' => 'Correo y contraseña requeridos']);
            return;
        }

        $usuario = Usuario::login($correo, $contrasena);

        if (!$usuario) {
            http_response_code(401);
            $this->json(['error' => 'Credenciales incorrectas']);
            return;
        }

        $idUsuario = $usuario['SECUENCIAL'];
        $rol = strtoupper($usuario['ROL']);
        $esResponsable = Evento::esResponsable($idUsuario);

        $usuario['ES_RESPONSABLE'] = $esResponsable;

        if ($esResponsable || in_array($rol, ['ADMIN', 'ESTUDIANTE', 'DOCENTE', 'INVITADO'])) {
            $_SESSION['usuario'] = $usuario;
            $this->json([
                'ok' => true,
                'usuario' => [
                    'NOMBRES' => $usuario['NOMBRES'],
                    'ROL' => $rol,
                    'SECUENCIAL' => $idUsuario
                ]
            ]);
        } else {
            http_response_code(403);
            $this->json(['error' => 'No tienes permiso para acceder']);
        }
    }

    private function json($data)
    {
        echo json_encode($data);
    }
}

// Ejecutar el controlador
$controller = new LoginController();
$controller->handleRequest();
