<?php
session_start();
require_once '../models/Usuarios.php';

header('Content-Type: application/json');

class UsuarioController {
    private $usuarioModelo;
    private $idUsuario;
    private $rol;

    public function __construct() {
        $this->usuarioModelo = new Usuario();
        $this->idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;
        $this->rol = $_SESSION['usuario']['CODIGOROL'] ?? null;
    }

    public function handleRequest() {
        $option = $_GET['option'] ?? '';
        switch ($option) {
            case 'insertar':
                $this->insertar();
                break;
            case 'editar':
                $this->editar();
                break;
            case 'eliminar':
                $this->eliminar();
                break;
            case 'inactivar':
                $this->inactivar();
                break;
            case 'get':
                $this->get();
                break;
            case 'listar':
                $this->listar();
                break;
            case 'registrarUsuario':
                $this->registrarUsuario();
                break;
            default:
                $this->json(['success' => false, 'mensaje' => 'Acción no válida']);
        }
    }

    // Solo para administrador
    private function insertar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $data = $_POST;
        $resp = $this->usuarioModelo->insertar(
            $data['nombres'], $data['apellidos'], $data['telefono'], $data['direccion'],
            $data['correo'], $data['contrasena'], $data['codigorol'], $data['es_interno'] ?? 1
        );
        $this->json($resp);
    }

    private function editar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $data = $_POST;
        // Añadimos la contraseña como parámetro opcional
        $contrasena = isset($data['contrasena']) ? $data['contrasena'] : '';
        $resp = $this->usuarioModelo->editar(
            $data['id'],
            $data['nombres'],
            $data['apellidos'],
            $data['telefono'],
            $data['direccion'],
            $data['correo'],
            $data['codigorol'],
            $data['estado'],
            $data['es_interno'] ?? 1,
            $contrasena // Nuevo parámetro
        );
        $this->json($resp);
    }

    private function eliminar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->json(['success' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $resp = $this->usuarioModelo->eliminar($id);
        $this->json($resp);
    }

    private function inactivar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->json(['success' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $resp = $this->usuarioModelo->ponerEstadoInactivo($id);
        $this->json($resp);
    }

    private function get() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->json(['success' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $usuario = $this->usuarioModelo->getById($id);
        $this->json($usuario);
    }

    private function listar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $usuarios = $this->usuarioModelo->listar();
        $this->json($usuarios);
    }

    // Registro público (sin sesión)
    private function registrarUsuario() {
        $data = $_POST;
        $required = ['nombres', 'apellidos', 'telefono', 'direccion', 'correo', 'contrasena', 'codigorol'];
        foreach ($required as $campo) {
            if (empty($data[$campo])) {
                $this->json(['success' => false, 'mensaje' => "El campo $campo es obligatorio"]);
                return;
            }
        }
        $resp = $this->usuarioModelo->insertar(
            $data['nombres'], $data['apellidos'], $data['telefono'], $data['direccion'],
            $data['correo'], $data['contrasena'], $data['codigorol'], $data['es_interno'] ?? 1
        );
        $this->json($resp);
    }

    private function json($data) {
        echo json_encode($data);
    }
}

$controller = new UsuarioController();
$controller->handleRequest();
?>