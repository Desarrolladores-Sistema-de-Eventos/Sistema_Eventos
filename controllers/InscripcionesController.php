<?php
session_start();
require_once '../models/Inscripciones.php';
header('Content-Type: application/json');

class InscripcionesController {
    // Notificaciones de inscripciones aprobadas para usuario (estudiante, docente, invitado)
    public function notificacionesAprobadasUsuario() {
        $idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;
        if (!$idUsuario) {
            echo json_encode([]);
            return;
        }
        $data = $this->modelo->listarInscripcionesAprobadasUsuario($idUsuario);
        echo json_encode($data);
    }
    // Notificaciones de certificados generados para usuario (estudiante, docente, invitado)
    public function notificacionesCertificadosUsuario() {
        $idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;
        if (!$idUsuario) {
            echo json_encode([]);
            return;
        }
        $data = $this->modelo->listarCertificadosGeneradosUsuario($idUsuario);
        echo json_encode($data);
    }
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
            case 'notificacionesCertificadosUsuario':
                $this->notificacionesCertificadosUsuario(); break;
            case 'inscribirse':
                $this->inscribirse(); break;
            case 'listarPorEvento':
                $this->listarPorEvento(); break;
            case 'listarPorUsuario':
                $this->listarPorUsuario(); break;
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
            case 'contarPendientesResponsable':
                $this->contarPendientesPendienteResponsable(); break;
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
            case 'verComprobante':
                $this->verComprobante();
                break;

            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Opción inválida']);
        }
    }
      // Nueva función para contar inscripciones pendientes del responsable
    public function contarPendientesPendienteResponsable() {
        $total = 0;
        if (!isset($_SESSION['usuario']['SECUENCIAL'])) {
            echo json_encode(['total' => 0]);
            return;
        }
        $idResponsable = $_SESSION['usuario']['SECUENCIAL'];
        $data = $this->modelo->listarInscripcionesPendientesDelResponsable($idResponsable);
        if (is_array($data)) {
            $total = count($data);
        }
        echo json_encode(['total' => $total]);
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
    private function verComprobante()
{
    $id = $_GET['idInscripcion'] ?? null;
    if (!$id) {
        echo json_encode([]);
        return;
    }

    $stmt = $this->eventoModelo->pdo->prepare("SELECT COMPROBANTE_URL FROM pago WHERE SECUENCIALINSCRIPCION = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['archivo' => $row['COMPROBANTE_URL'] ?? null]);
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
    $validos = ['PEN', 'VAL', 'REC', 'INV']; // Cambiar RECH por REC para requisitos

    if (!$idArchivo || !in_array($estado, $validos)) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Datos inválidos']);
        return;
    }

    $ok = $this->modelo->actualizarEstadoArchivoRequisito($idArchivo, $estado);

    // Usar el modelo para obtener el id de inscripción
    $idInscripcion = $this->modelo->obtenerIdInscripcionPorArchivo($idArchivo);

    if ($idInscripcion) {
        $this->modelo->validarYActualizarEstadoInscripcion($idInscripcion);
    }

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
    $esPagado = $this->modelo->esEventoPagadoPorInscripcion($id); // Debes crear este método en el modelo
    $this->json([
        'requisitos' => $data,
        'esPagado' => $esPagado
    ]);
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
    $rutaDestino = "../documents/facturas/" . $nombreArchivo;

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
    $aprobador = $this->idUsuario;

    if (!$id || !$estado || !$aprobador) {
        return $this->json([
            'tipo' => 'error',
            'mensaje' => 'Datos incompletos'
        ]);
    }
    $ok = $this->modelo->actualizarEstadoPago($id, $estado, $aprobador);

    // Usar el modelo para obtener el id de inscripción
    $idInscripcion = $this->modelo->obtenerIdInscripcionPorPago($id);

    if ($idInscripcion) {
        $this->modelo->validarYActualizarEstadoInscripcion($idInscripcion);
    }

    return $this->json([
        'tipo' => $ok ? 'success' : 'error',
        'mensaje' => $ok ? 'Estado actualizado' : 'No se pudo actualizar'
    ]);
}

 private function listarPorUsuario() {
        try {
            $data = $this->modelo->getInscripcionesPorUsuario($this->idUsuario);
            $this->json($data);
        } catch (Exception $e) {
            $this->json([
                'tipo' => 'error',
                'mensaje' => 'Error al obtener inscripciones',
                'debug' => $e->getMessage()
            ]);
        }
    }

}

$controller = new InscripcionesController();
$controller->handleRequest();
