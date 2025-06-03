<?php
session_start();
require_once '../models/Reportes.php';

header('Content-Type: application/json');

class ReportesController
{
    private $modelo;
    private $idUsuario;

    public function __construct()
    {
        $this->modelo = new Reportes();
        $this->idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;

        if (!$this->idUsuario) {
            $this->json(['success' => false, 'mensaje' => 'Sesión expirada']);
            exit;
        }
    }

    public function handleRequest()
    {
        $option = $_GET['option'] ?? '';
        switch ($option) {
            case 'eventosResponsable':
                $this->eventosResponsable();
                break;
            case 'inscritosPorEvento':
                $this->inscritosPorEvento();
                break;
            case 'asistenciaNotasPorEvento':
                $this->asistenciaNotasPorEvento();
                break;
            case 'certificadosPorEvento':
                $this->certificadosPorEvento();
                break;
            case 'estadisticasEvento':
                $this->estadisticasEvento();
                break;
            // Aquí puedes agregar endpoints para descarga (CSV, Excel, PDF) si lo necesitas
            default:
                $this->json(['success' => false, 'mensaje' => 'Opción no válida']);
        }
    }

    private function eventosResponsable()
    {
        $data = $this->modelo->eventosPorResponsable($this->idUsuario);
        $this->json($data);
    }

    private function inscritosPorEvento()
    {
        $idEvento = $_GET['idEvento'] ?? null;
        if (!$idEvento) {
            $this->json([]);
            return;
        }
        $data = $this->modelo->inscritosPorEvento($idEvento);
        $this->json($data);
    }

    private function asistenciaNotasPorEvento()
    {
        $idEvento = $_GET['idEvento'] ?? null;
        if (!$idEvento) {
            $this->json([]);
            return;
        }
        $data = $this->modelo->asistenciaNotasPorEvento($idEvento);
        $this->json($data);
    }

    private function certificadosPorEvento()
    {
        $idEvento = $_GET['idEvento'] ?? null;
        if (!$idEvento) {
            $this->json([]);
            return;
        }
        $data = $this->modelo->certificadosPorEvento($idEvento);
        $this->json($data);
    }

    private function estadisticasEvento()
    {
        $idEvento = $_GET['idEvento'] ?? null;
        if (!$idEvento) {
            $this->json([]);
            return;
        }
        $data = $this->modelo->estadisticasEvento($idEvento);
        $this->json($data);
    }

    private function json($data)
    {
        echo json_encode($data);
        exit;
    }
}

$controller = new ReportesController();
$controller->handleRequest();
?>