<?php
session_start();
require_once '../models/Inscripciones.php';
header('Content-Type: application/json');

class RequisitosController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Inscripciones(); // o un modelo dedicado si prefieres
    }

    public function handleRequest() {
        $option = $_GET['option'] ?? '';

        switch ($option) {
            case 'subirArchivo':
                $this->subirArchivo(); break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Opción inválida']);
        }
    }

    private function subirArchivo() {
        if (!isset($_FILES['archivo']) || !isset($_POST['idArchivo'])) {
            return $this->json(['tipo' => 'error', 'mensaje' => 'Datos incompletos']);
        }

        $archivo = $_FILES['archivo'];
        $idArchivo = $_POST['idArchivo'];

        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return $this->json(['tipo' => 'error', 'mensaje' => 'Error al subir archivo']);
        }

        $permitidos = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($archivo['type'], $permitidos)) {
            return $this->json(['tipo' => 'error', 'mensaje' => 'Formato no permitido']);
        }

        $ext = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('requisito_') . "." . $ext;
        $ruta = "../documents/requisitos/" . $nombreArchivo;

        if (!move_uploaded_file($archivo['tmp_name'], $ruta)) {
            return $this->json(['tipo' => 'error', 'mensaje' => 'No se pudo guardar archivo']);
        }

        $ok = $this->modelo->actualizarArchivoRequisito($idArchivo, $nombreArchivo);

        return $this->json([
            'tipo' => $ok ? 'success' : 'error',
            'mensaje' => $ok ? 'Archivo actualizado' : 'No se guardó en BD',
            'nombreArchivo' => $ok ? $nombreArchivo : null
        ]);
    }

    private function json($data) {
        echo json_encode($data);
    }
}

// Ejecutar el controlador
$controller = new RequisitosController();
$controller->handleRequest();
?>