<?php
session_start();
require_once '../models/Factura.php';

header('Content-Type: application/json');

class FacturaController
{
    private $facturaModelo;
    private $idUsuario;

    public function __construct()
    {
        $this->facturaModelo = new Factura();
        $this->idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;

        if (!$this->idUsuario) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Sesión expirada']);
            exit;
        }
    }

    public function handleRequest()
    {
        $option = $_GET['option'] ?? '';

        switch ($option) {
            case 'verFactura':
                $this->verFactura();
                break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
        }
    }

    private function verFactura()
    {
        $idInscripcion = $_GET['idInscripcion'] ?? null;
        if (!$idInscripcion) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID de inscripción requerido']);
            return;
        }
        $datosFactura = $this->facturaModelo->getFacturaCompleta($idInscripcion);
        if (!$datosFactura) {
            $this->json([
                'tipo' => 'error',
                'mensaje' => 'No se puede generar la factura. La inscripción no está aceptada o no existe.'
            ]);
            return;
        }
        $this->json(['tipo' => 'success', 'factura' => $datosFactura]);
    }

    private function json($data)
    {
        echo json_encode($data);
    }
}

// Instancia y ejecución
$controller = new FacturaController();
$controller->handleRequest();