<?php
require_once '../models/Autoridades.php';

header('Content-Type: application/json');

class AutoridadesController
{
    private $autoridadesModelo;

    public function __construct()
    {
        $this->autoridadesModelo = new Autoridades();
    }

    public function handleRequest()
    {
        $option = $_GET['option'] ?? '';

        switch ($option) {
            case 'listar':
                $this->listar();
                break;
            case 'crear':
                $this->crear();
                break;
            case 'editar':
                $this->editar();
                break;
            case 'eliminar':
                $this->eliminar();
                break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
        }
    }

    // Crear autoridad
    private function crear()
    {
        $nombre = trim($_POST['nombre'] ?? '');
        $cargo = trim($_POST['cargo'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $facultad_secuencial = $_POST['facultad_secuencial'] ?? null;
        $telefono = trim($_POST['telefono'] ?? '');
        $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 1;
        $foto_url = null;

        // Manejo de archivo de foto
        if (isset($_FILES['foto_url']) && $_FILES['foto_url']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['foto_url']['tmp_name'];
            $filename = 'perfil_' . uniqid() . '_' . basename($_FILES['foto_url']['name']);
            $destino = __DIR__ . '/../public/img/autoridades/' . $filename;
            if (move_uploaded_file($tmp_name, $destino)) {
                $foto_url = $filename;
            }
        }

        if (!$nombre || !$cargo || !$correo) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Nombre, cargo y correo son obligatorios']);
            return;
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Correo inválido']);
            return;
        }

        $ok = $this->autoridadesModelo->crearAutoridad($nombre, $cargo, $correo, $foto_url, $facultad_secuencial, $telefono, $estado);
        if ($ok) {
            $this->json(['tipo' => 'success', 'mensaje' => 'Autoridad creada correctamente']);
        } else {
            $this->json(['tipo' => 'error', 'mensaje' => 'No se pudo crear la autoridad']);
        }
    }

    // Editar autoridad
    private function editar()
    {
        $id = $_POST['id'] ?? '';
        $nombre = trim($_POST['nombre'] ?? '');
        $cargo = trim($_POST['cargo'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $facultad_secuencial = $_POST['facultad_secuencial'] ?? null;
        $telefono = trim($_POST['telefono'] ?? '');
        $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 1;
        $foto_url = $_POST['foto_url_actual'] ?? null;

        // Manejo de archivo de foto (si se sube una nueva)
        if (isset($_FILES['foto_url']) && $_FILES['foto_url']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['foto_url']['tmp_name'];
            $filename = 'perfil_' . uniqid() . '_' . basename($_FILES['foto_url']['name']);
            $destino = __DIR__ . '/../public/img/autoridades/' . $filename;
            if (move_uploaded_file($tmp_name, $destino)) {
                $foto_url = $filename;
            }
        }

        if (!$id || !$nombre || !$cargo || !$correo) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID, nombre, cargo y correo son obligatorios']);
            return;
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Correo inválido']);
            return;
        }

        $ok = $this->autoridadesModelo->editarAutoridad($id, $nombre, $cargo, $correo, $foto_url, $facultad_secuencial, $telefono, $estado);
        if ($ok) {
            $this->json(['tipo' => 'success', 'mensaje' => 'Autoridad editada correctamente']);
        } else {
            $this->json(['tipo' => 'error', 'mensaje' => 'No se pudo editar la autoridad']);
        }
    }

    // Eliminar autoridad
    private function eliminar()
    {
        $id = $_POST['id'] ?? '';
        if (!$id) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido']);
            return;
        }
        $ok = $this->autoridadesModelo->eliminarAutoridad($id);
        if ($ok) {
            $this->json(['tipo' => 'success', 'mensaje' => 'Autoridad eliminada correctamente']);
        } else {
            $this->json(['tipo' => 'error', 'mensaje' => 'No se pudo eliminar la autoridad']);
        }
    }

    private function listar()
    {
        $data = $this->autoridadesModelo->getAutoridades();
        $this->json($data);
    }

    private function json($data)
    {
        echo json_encode($data);
    }
}

// Instancia y ejecución
$controller = new AutoridadesController();
$controller->handleRequest();