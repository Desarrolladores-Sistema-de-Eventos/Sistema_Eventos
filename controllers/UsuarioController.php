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
                $this->guardar();
                break;
            case 'editar':
                $this->actualizar();
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

    // Guardar (insertar) usuario
    private function guardar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $required = ['nombres', 'apellidos', 'telefono', 'correo', 'contrasena', 'codigorol'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['success' => false, 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $foto_perfil = $this->procesarFotoPerfil();
            $resp = $this->usuarioModelo->insertar(
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['telefono'],
                $_POST['direccion'] ?? '',
                $_POST['correo'],
                $_POST['contrasena'],
                $_POST['codigorol'],
                $_POST['es_interno'] ?? 1,
                $foto_perfil
            );
            $this->json($resp);
        } catch (Exception $e) {
            $this->json([
                'success' => false,
                'mensaje' => 'Error al crear usuario',
                'debug' => $e->getMessage()
            ]);
        }
    }

    // Actualizar (editar) usuario
    private function actualizar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $required = ['id', 'nombres', 'apellidos', 'telefono', 'correo', 'codigorol', 'estado'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['success' => false, 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $foto_perfil = $this->procesarFotoPerfil();
            if (!$foto_perfil && isset($_POST['foto_perfil_actual'])) {
                $foto_perfil = $_POST['foto_perfil_actual'];
            }
            $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
            $resp = $this->usuarioModelo->editar(
                $_POST['id'],
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['telefono'],
                $_POST['direccion'] ?? '',
                $_POST['correo'],
                $_POST['codigorol'],
                $_POST['estado'],
                $_POST['es_interno'] ?? 1,
                $contrasena,
                $foto_perfil
            );
            $this->json($resp);
        } catch (Exception $e) {
            $this->json([
                'success' => false,
                'mensaje' => 'Error al actualizar usuario',
                'debug' => $e->getMessage()
            ]);
        }
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
        $required = ['nombres', 'apellidos', 'telefono', 'direccion', 'correo', 'contrasena', 'codigorol'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['success' => false, 'mensaje' => "El campo $campo es obligatorio"]);
                return;
            }
        }
        try {
            $foto_perfil = $this->procesarFotoPerfil();
            $resp = $this->usuarioModelo->insertar(
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['telefono'],
                $_POST['direccion'],
                $_POST['correo'],
                $_POST['contrasena'],
                $_POST['codigorol'],
                $_POST['es_interno'] ?? 1,
                $foto_perfil
            );
            $this->json($resp);
        } catch (Exception $e) {
            $this->json([
                'success' => false,
                'mensaje' => 'Error al registrar usuario',
                'debug' => $e->getMessage()
            ]);
        }
    }

    // Procesa la subida de la foto de perfil y retorna el nombre del archivo o null
    private function procesarFotoPerfil() {
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = uniqid('perfil_') . '_' . basename($_FILES['foto_perfil']['name']);
            $rutaDestino = __DIR__ . '/../public/img/' . $nombreArchivo;
            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                return $nombreArchivo;
            }
        }
        return null;
    }

    private function json($data) {
        echo json_encode($data);
    }
}

$controller = new UsuarioController();
$controller->handleRequest();
