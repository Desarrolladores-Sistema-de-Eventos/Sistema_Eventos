<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../models/User.php';

class RegisterController
{
    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->registrar();
        } else {
            $this->json(['errores' => ['Método no permitido.']]);
        }
    }

    private function registrar()
    {
        $data = [
            'nombres'    => trim($_POST['nombres'] ?? ''),
            'apellidos'  => trim($_POST['apellidos'] ?? ''),
            'telefono'   => trim($_POST['telefono'] ?? ''),
            'direccion'  => trim($_POST['direccion'] ?? ''),
            'correo'     => trim($_POST['correo'] ?? ''),
            'contrasena' => $_POST['contrasena'] ?? '',
            'rol'        => $_POST['rol'] ?? ''
        ];

        $errores = [];

        if ($data['rol'] === 'INV' && !preg_match('/@gmail\.com$/', $data['correo'])) {
            $errores[] = "El correo para Invitado debe ser @gmail.com";
        }
        if (($data['rol'] === 'EST' || $data['rol'] === 'DOC') && !preg_match('/@uta\.edu\.ec$/', $data['correo'])) {
            $errores[] = "El correo para Estudiante o Docente debe ser @uta.edu.ec";
        }

        foreach (['nombres','apellidos','telefono','correo','contrasena','rol'] as $campo) {
            if (empty($data[$campo])) {
                $errores[] = "El campo $campo es obligatorio.";
            }
        }

        if (count($errores) > 0) {
            $this->json(['errores' => $errores]);
            return;
        }

        $resultado = User::registrar($data);

        if (isset($resultado['error'])) {
            $this->json(['errores' => [$resultado['error']]]);
        } else {
            $this->json(['success' => "Usuario registrado correctamente."]);
        }
    }

    private function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

$controller = new RegisterController();
$controller->handleRequest();