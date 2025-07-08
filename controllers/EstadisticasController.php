<?php
session_start();
require_once '../models/Estadisticas.php';
header('Content-Type: application/json');

class EstadisticasController {
    private $modelo;
    private $idUsuario;

    public function __construct() {
        $this->modelo = new Estadisticas();
        $this->idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;

        // Si quieres que el dashboard sea público, puedes quitar este check.
        if (!$this->idUsuario) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Sesión expirada']);
            exit;
        }
    }

    public function handleRequest() {
        $option = $_GET['option'] ?? '';
        switch ($option) {
            case 'totalUsuariosActivos':
                $this->totalUsuariosActivos(); break;
            case 'totalEventosDisponibles':
                $this->totalEventosDisponibles(); break;
            case 'usuariosInactivos':
                $this->usuariosInactivos(); break;
            case 'eventosCanceladosCerrados':
                $this->eventosCanceladosCerrados(); break;
            case 'totalEventos':
                $this->totalEventos(); break;
            case 'usuariosPorTipo':
                $this->usuariosPorTipo(); break;
            case 'inscripcionesActivasCompletadasPorEvento':
                $this->inscripcionesActivasCompletadasPorEvento(); break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Opción inválida']);
        }
    }
    private function totalEventos() {
        $total = $this->modelo->totalEventos();
        $this->json(['total' => $total]);
    }

    private function totalUsuariosActivos() {
        $total = $this->modelo->totalUsuariosActivos();
        $this->json(['total' => $total]);
    }

    private function totalEventosDisponibles() {
        $total = $this->modelo->totalEventosDisponibles();
        $this->json(['total' => $total]);
    }

    private function usuariosInactivos() {
        $total = $this->modelo->totalUsuariosInactivos();
        $this->json(['total' => $total]);
    }

    private function eventosCanceladosCerrados() {
        $total = $this->modelo->totalEventosCanceladosCerrados();
        $this->json(['total' => $total]);
    }

    private function usuariosPorTipo() {
        $data = $this->modelo->totalUsuariosPorTipo();
        $this->json($data);
    }

    private function inscripcionesActivasCompletadasPorEvento() {
        $data = $this->modelo->inscripcionesActivasCompletadasPorEvento();
        $this->json($data);
    }

    private function json($data) {
        echo json_encode($data);
    }
}

$controller = new EstadisticasController();
$controller->handleRequest();