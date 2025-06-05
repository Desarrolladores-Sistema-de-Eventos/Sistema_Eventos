<?php
session_start();
require_once '../models/EventosAdmin.php';

header('Content-Type: application/json');

class EventoController {
    private $eventoModelo;
    private $rol;

    public function __construct() {
        $this->eventoModelo = new Evento();
        $this->rol = $_SESSION['usuario']['CODIGOROL'] ?? null;
    }

    public function handleRequest() {
        $option = $_GET['option'] ?? '';
        switch ($option) {
            case 'listar':
                $this->listar();
                break;
            case 'get':
                $this->get();
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
            case 'cancelar':
                $this->cancelar();
                break;
            case 'organizadores':
                $this->organizadores();
                break;
            case 'catalogos':
                $this->catalogos();
                break;
            default:
                $this->json(['success' => false, 'mensaje' => 'Acción no válida']);
        }
    }

    private function listar() {
        $eventos = $this->eventoModelo->listar();
        $this->json($eventos);
    }

    private function get() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->json(['success' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $evento = $this->eventoModelo->getById($id);
        $this->json($evento);
    }

    private function crear() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $data = $_POST;
        $required = ['titulo', 'descripcion', 'horas', 'fechaInicio', 'fechaFin', 'modalidad', 'notaAprobacion', 'costo', 'esSoloInternos', 'esPagado', 'categoria', 'tipoEvento', 'carrera', 'estado', 'responsable', 'organizador'];
        foreach ($required as $campo) {
            if (empty($data[$campo])) {
                $this->json(['success' => false, 'mensaje' => "El campo $campo es obligatorio"]);
                return;
            }
        }
        $idEvento = $this->eventoModelo->crear($data);
        $this->json($idEvento ? ['success' => true, 'id' => $idEvento] : ['success' => false, 'mensaje' => 'No se pudo crear el evento']);
    }

    private function editar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->json(['success' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $data = $_POST;
        $ok = $this->eventoModelo->editar($id, $data);
        $this->json($ok ? ['success' => true] : ['success' => false, 'mensaje' => 'No se pudo actualizar el evento']);
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
    try {
        $ok = $this->eventoModelo->eliminar($id);
        if ($ok) {
            $this->json(['success' => true, 'mensaje' => 'Evento y registros relacionados eliminados correctamente.']);
        } else {
            $this->json(['success' => false, 'mensaje' => 'No se pudo eliminar el evento.']);
        }
    } catch (Exception $e) {
        $this->json(['success' => false, 'mensaje' => $e->getMessage()]);
    }
}

    private function cancelar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->json(['success' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $ok = $this->eventoModelo->cancelar($id);
        $this->json($ok ? ['success' => true] : ['success' => false, 'mensaje' => 'No se pudo cancelar el evento']);
    }

    private function organizadores() {
        $usuarios = $this->eventoModelo->getOrganizadores();
        $this->json($usuarios);
    }

    private function json($data) {
        echo json_encode($data);
    }
    private function catalogos() {
    $data = [
        'carreras' => $this->eventoModelo->getCarreras(),
        'tipos' => $this->eventoModelo->getTiposEvento(),
        'modalidades' => $this->eventoModelo->getModalidades(),
        'categorias' => $this->eventoModelo->getCategorias(),
        'estados' => $this->eventoModelo->getEstados()
    ];
    $this->json($data);
}
}

$controller = new EventoController();
$controller->handleRequest();
?>