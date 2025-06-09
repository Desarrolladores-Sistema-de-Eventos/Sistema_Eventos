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
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
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