<?php
require_once '../models/EventoPublico.php';

header('Content-Type: application/json');

class EventosPublicosController
{
    private $eventoModelo;

    public function __construct()
    {
        $this->eventoModelo = new EventoPublico();
    }

    public function handleRequest()
    {
        $option = $_GET['option'] ?? '';

        switch ($option) {
            case 'listarPublicos':
                $this->listarPublicos();
                break;
            case 'detalleEvento':
                $this->detalleEvento();
                break;
            case 'listarCategorias':
                $this->listarCategorias();
                break;
            case 'buscarEventos':
                $this->buscarEventos();
                break;
            case 'eventosRecientes':
                $this->eventosRecientes();
                break;
            case 'filtrarEventos':
                $this->filtrarEventos();
                break;
            case 'listarFiltro':
                $this->listarFiltro();
                break;
             case 'detalleCompleto':
                $this->detalleCompleto();
                break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
        }
    }

    private function listarPublicos()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 6;
        $eventos = $this->eventoModelo->obtenerEventosDisponibles($page, $limit);
        $total = $this->eventoModelo->contarEventosDisponibles();
        $this->json([
            'eventos' => $eventos,
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ]);
    }

    private function detalleEvento()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido']);
            return;
        }
        $evento = $this->eventoModelo->getEventoDetallePublico($id);
        $this->json($evento);
    }

    private function json($data)
    {
        echo json_encode($data);
    }
    
    private function listarCategorias()
    {
        $categorias = $this->eventoModelo->listarCategorias2();
        $this->json($categorias);
    }

    private function buscarEventos()
    {
        $keyword = $_GET['keyword'] ?? '';
        $eventos = $this->eventoModelo->buscarEventos($keyword);
        $this->json($eventos);
    }

    private function eventosRecientes()
    {
        $limite = isset($_GET['limite']) ? intval($_GET['limite']) : 3;
        $eventos = $this->eventoModelo->eventosRecientes($limite);
        $this->json($eventos);
    }

    private function filtrarEventos()
    {
        $filtros = [
            'tipo' => $_GET['tipo'] ?? '',
            'categoria' => $_GET['categoria'] ?? '',
            'modalidad' => $_GET['modalidad'] ?? '',
            'carrera' => $_GET['carrera'] ?? '',
            'fecha' => $_GET['fecha'] ?? '',
            'busqueda' => $_GET['busqueda'] ?? ''
        ];
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 6;
        $eventos = $this->eventoModelo->filtrarEventos($filtros, $page, $limit);
        $total = $this->eventoModelo->contarEventosFiltrados($filtros);
        $this->json([
            'eventos' => $eventos,
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ]);
    }
    
    private function listarFiltro()
    {
        $filtro = $_GET['filtro'] ?? '';
        switch ($filtro) {
            case 'tipo':
                $data = $this->eventoModelo->listarTipos();
                break;
            case 'categoria':
                $data = $this->eventoModelo->listarCategorias();
                break;
            case 'modalidad':
                $data = $this->eventoModelo->listarModalidades();
                break;
            case 'carrera':
                $data = $this->eventoModelo->listarCarreras();
                break;
            default:
                $data = [];
        }
        $this->json($data);
    }
    private function detalleCompleto()
{
    $id = $_GET['id'] ?? null;
    if (!$id) {
        $this->json(['error' => 'ID requerido']);
        return;
    }
    $evento = $this->eventoModelo->getEventoDetalleCompleto($id);
    $this->json($evento);
}
}

$controller = new EventosPublicosController();
$controller->handleRequest();