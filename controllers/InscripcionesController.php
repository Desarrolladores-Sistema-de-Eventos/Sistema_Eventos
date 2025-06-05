<?php
session_start();
require_once '../models/Inscripciones.php';
header('Content-Type: application/json');

class InscripcionesController {
    private $modelo;
    private $idUsuario;

    public function __construct() {
        $this->modelo = new Inscripciones();
        $this->idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;

        if (!$this->idUsuario) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Sesión expirada']);
            exit;
        }
    }

    public function handleRequest() {
        $option = $_GET['option'] ?? '';
        switch ($option) {
            case 'inscribirse':
                $this->inscribirse(); break;
            case 'listarPorEvento':
                $this->listarPorEvento(); break;
            case 'estadoInscripcion':
                $this->estadoInscripcion(); break;
            case 'estadoPago':
                $this->estadoPago(); break;
            case 'requisitosPorEvento':
                $this->requisitosPorEvento(); break;
            case 'estadoRequisito':
                $this->estadoRequisito(); break;
            case 'listarPendientesResponsable':
                $this->listarPendientesResponsable(); break;
            case 'graficoEstados':
                $this->graficoEstados(); break;
            case 'graficoPorEvento':
                $this->graficoPorEvento(); break;
            case 'graficoCertificados':
                $this->graficoCertificados(); break;
            case 'contarEventos':
                $this->contarEventos(); break;
            case 'contarInscritos':
                $this->contarInscritos(); break;
            case 'detalleInscripcion':
                $this->detalleInscripcion(); break;
            case 'requisitosPorInscripcion':
                $this->requisitosPorInscripcion();break;
            case 'pagosPorInscripcion':
                $this->pagosPorInscripcion();break;
            case 'subirFactura':
                $this->subirFactura(); break;
            case 'subirComprobantePago':
                $this->subirComprobantePago(); break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Opción inválida']);
        }
    }

    private function inscribirse() {
        $idEvento = $_POST['idEvento'] ?? null;
        if (!$idEvento) {
            return $this->json(['tipo' => 'error', 'mensaje' => 'Evento requerido']);
        }

        $ok = $this->modelo->crearInscripcion($idEvento, $this->idUsuario);
        $this->json([
            'tipo' => $ok ? 'success' : 'error',
            'mensaje' => $ok ? 'Inscripción exitosa' : 'Error'
        ]);
    }


    private function listarPorEvento() {
        $idEvento = $_GET['idEvento'] ?? null;

        if (!$idEvento || !$this->idUsuario) {
            $this->json([]);
            return;
        }

        $data = $this->modelo->listarInscripcionesPorEvento($idEvento, $this->idUsuario);
        $this->json($data);
    }

    private function listarPendientesResponsable() {
    $data = $this->modelo->listarInscripcionesPendientesDelResponsable($this->idUsuario);
    $this->json($data);
    }


    private function estadoInscripcion() {
    $id = $_POST['id'] ?? null;
    $estado = $_POST['estado'] ?? null;
    $ok = $this->modelo->actualizarEstadoInscripcion($id, $estado);
    $this->json(['tipo' => $ok ? 'success' : 'error']);
}

    private function requisitosPorEvento() {
        $idEvento = $_GET['idEvento'] ?? null;
        if (!$idEvento) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Evento no especificado']);
            return;
        }

        $data = $this->modelo->listarArchivosRequisitosPorEvento($idEvento);
        $this->json($data);
    }

    private function estadoRequisito() {
        $idArchivo = $_POST['id'] ?? null;
        $estado = $_POST['estado'] ?? null;
        $validos = ['PEN', 'VAL', 'RECH', 'INV'];

        if (!$idArchivo || !in_array($estado, $validos)) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Datos inválidos']);
            return;
        }

        $ok = $this->modelo->actualizarEstadoArchivoRequisito($idArchivo, $estado);
        $this->json(['tipo' => $ok ? 'success' : 'error']);
    }
    
    private function json($data) {
        echo json_encode($data);
    }

    private function graficoEstados() {
    $data = $this->modelo->resumenEstadosInscripcion($this->idUsuario);
    $this->json($data);
    }
    private function graficoCertificados() {
    $data = $this->modelo->certificadosPorEvento($this->idUsuario);
    $this->json($data);
    }
    private function contarEventos() {
    $total = $this->modelo->totalEventosDelResponsable($this->idUsuario);
    $this->json(['total' => $total]);
    }
    private function graficoPorEvento() {
    $data = $this->modelo->obtenerInscripcionesAceptadasPorEvento($this->idUsuario);
    $this->json($data);}

    private function detalleInscripcion() {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido']);
        return;
    }

    $stmt = $this->modelo->detalleInscripcion($id, $this->idUsuario);
    $requisitos = $this->modelo->listarArchivosRequisitosPorInscripcion($id);

    $this->json([
        'inscripcion' => $stmt,
        'requisitos' => $requisitos
    ]);
}
private function requisitosPorInscripcion() {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        return $this->json([]);
    }
    $data = $this->modelo->requisitosPorInscripcion($id);
    $this->json($data);
}
private function contarInscritos() {
    $data = $this->modelo->contarInscritos();
    $this->json($data);
}


private function pagosPorInscripcion() {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        return $this->json([]);
    }
    $data = $this->modelo->pagosPorInscripcion($id);
    $this->json($data);
}
private function subirFactura() {
    if (!isset($_FILES['factura']) || !isset($_POST['id'])) {
        return $this->json([
            'tipo' => 'error',
            'mensaje' => 'Datos incompletos'
        ]);
    }

    $archivo = $_FILES['factura'];
    $idInscripcion = $_POST['id'];

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return $this->json([
            'tipo' => 'error',
            'mensaje' => 'Error al subir el archivo'
        ]);
    }

    $permitidos = ['application/pdf', 'image/jpeg', 'image/png'];
    if (!in_array($archivo['type'], $permitidos)) {
        return $this->json([
            'tipo' => 'error',
            'mensaje' => 'Formato no permitido'
        ]);
    }

    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombreArchivo = uniqid('factura_') . "." . $extension;
    $rutaDestino = "../facturas_Comprobantes/" . $nombreArchivo;

    if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        return $this->json([
            'tipo' => 'error',
            'mensaje' => 'Error al guardar archivo'
        ]);
    }

    $ok = $this->modelo->actualizarComprobanteFactura($idInscripcion, $nombreArchivo);

    return $this->json([
        'tipo' => $ok ? 'success' : 'error',
        'mensaje' => $ok ? 'Factura guardada correctamente' : 'No se pudo guardar en base de datos',
        'nombreArchivo' => $ok ? $nombreArchivo : null
    ]);
}
private function subirComprobantePago() {
    if (!isset($_FILES['comprobante']) || !isset($_POST['id'])) {
        return $this->json([
            'tipo' => 'error',
            'mensaje' => 'Datos incompletos'
        ]);
    }

    $archivo = $_FILES['comprobante'];
    $idPago = $_POST['id'];

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return $this->json([
            'tipo' => 'error',
            'mensaje' => 'Error al subir el archivo'
        ]);
    }

    $permitidos = ['application/pdf', 'image/jpeg', 'image/png'];
    if (!in_array($archivo['type'], $permitidos)) {
        return $this->json([
            'tipo' => 'error',
            'mensaje' => 'Formato no permitido'
        ]);
    }

    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombreArchivo = uniqid('comprobante_') . "." . $extension;
    $rutaDestino = "../facturas_Comprobantes/" . $nombreArchivo;

    if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        return $this->json([
            'tipo' => 'error',
            'mensaje' => 'Error al guardar archivo'
        ]);
    }

    $ok = $this->modelo->actualizarComprobantePago($idPago, $nombreArchivo);

    return $this->json([
        'tipo' => $ok ? 'success' : 'error',
        'mensaje' => $ok ? 'Comprobante guardado correctamente' : 'No se pudo guardar en base de datos',
        'nombreArchivo' => $ok ? $nombreArchivo : null
    ]);
}

private function estadoPago() {
    $id = $_POST['id'] ?? null;
    $estado = $_POST['estado'] ?? null;
    $aprobador = $this->idUsuario; // Usa el idUsuario del constructor

    if (!$id || !$estado || !$aprobador) {
        return $this->json([
            'tipo' => 'error',
            'mensaje' => 'Datos incompletos'
        ]);
    }
    $ok = $this->modelo->actualizarEstadoPago($id, $estado, $aprobador);
    return $this->json([
        'tipo' => $ok ? 'success' : 'error',
        'mensaje' => $ok ? 'Estado actualizado' : 'No se pudo actualizar'
    ]);
}

}

$controller = new InscripcionesController();
$controller->handleRequest();
