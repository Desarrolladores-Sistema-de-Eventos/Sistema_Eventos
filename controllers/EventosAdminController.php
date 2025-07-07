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
                $data['estado'] = 'DISPONIBLE'; 
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

    // Validar responsable obligatorio
    if (empty($data['responsable'])) {
        $this->json(['success' => false, 'mensaje' => 'Debe seleccionar un responsable para el evento.']);
        return;
    }

    // Procesar carreras múltiples (aceptar tanto 'carreras' como 'carrera')
    if (isset($_POST['carreras'])) {
        $carreras = (array)$_POST['carreras'];
    } else if (isset($_POST['carrera'])) {
        $carreras = (array)$_POST['carrera'];
    } else {
        $carreras = [];
    }
    if (in_array('TODAS', $carreras)) {
        // Obtener todas las carreras de la BD
        $todas = $this->eventoModelo->getCarreras();
        $carreras = array_column($todas, 'SECUENCIAL');
    }
    $data['carreras'] = $carreras;

    // Público destino: 1 = Internos, 0 = Externos (asegurar valor permitido)
    if (isset($_POST['esSoloInternos'])) {
        $esSoloInternos = $_POST['esSoloInternos'];
        if ($esSoloInternos === 'Todos' || $esSoloInternos == 2) {
            $esSoloInternos = 0; // Valor por defecto permitido
        }
        $data['esSoloInternos'] = (int)$esSoloInternos;
    } else {
        $data['esSoloInternos'] = 0;
    }

    // Procesar campos condicionales
    $tipoEvento = $_POST['tipoEvento'] ?? null;
    $tipos = $this->eventoModelo->getTiposEvento();
    $tipo = null;
    foreach ($tipos as $t) {
        if ($t['CODIGO'] == $tipoEvento) {
            $tipo = $t;
            break;
        }
    }
    if ($tipo) {
        if ($tipo['REQUIERENOTA'] != 1) {
            $data['notaAprobacion'] = null;
        }
        if ($tipo['REQUIEREASISTENCIA'] != 1) {
            $data['asistenciaMinima'] = null;
        }
    }
    // Solo guardar costo si es pagado
    $data['costo'] = (!empty($_POST['esPagado']) && $_POST['esPagado']) ? $_POST['costo'] : 0;

    // Procesar imagen de portada
    $data['urlPortada'] = null;
    if (isset($_FILES['urlPortada']) && $_FILES['urlPortada']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid('portada_') . '_' . basename($_FILES['urlPortada']['name']);
        $rutaDestino = '../public/img/' . $nombreArchivo;
        if (move_uploaded_file($_FILES['urlPortada']['tmp_name'], $rutaDestino)) {
            $data['urlPortada'] = 'public/img/' . $nombreArchivo;
        }
    }
    // Procesar imagen de galería
    $data['urlGaleria'] = null;
    if (isset($_FILES['urlGaleria']) && $_FILES['urlGaleria']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid('galeria_') . '_' . basename($_FILES['urlGaleria']['name']);
        $rutaDestino = '../public/img/' . $nombreArchivo;
        if (move_uploaded_file($_FILES['urlGaleria']['tmp_name'], $rutaDestino)) {
            $data['urlGaleria'] = 'public/img/' . $nombreArchivo;
        }
    }
    $data['estado'] = 'DISPONIBLE';

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

    // Validar responsable obligatorio
    if (empty($data['responsable'])) {
        $this->json(['success' => false, 'mensaje' => 'Debe seleccionar un responsable para el evento.']);
        return;
    }

    // Procesar carreras múltiples (aceptar tanto 'carreras' como 'carrera')
    if (isset($_POST['carreras'])) {
        $carreras = (array)$_POST['carreras'];
    } else if (isset($_POST['carrera'])) {
        $carreras = (array)$_POST['carrera'];
    } else {
        $carreras = [];
    }
    if (in_array('TODAS', $carreras)) {
        $todas = $this->eventoModelo->getCarreras();
        $carreras = array_column($todas, 'SECUENCIAL');
    }
    $data['carreras'] = $carreras;

    // Procesar campos condicionales
    $tipoEvento = $_POST['tipoEvento'] ?? null;
    $tipos = $this->eventoModelo->getTiposEvento();
    $tipo = null;
    foreach ($tipos as $t) {
        if ($t['CODIGO'] == $tipoEvento) {
            $tipo = $t;
            break;
        }
    }
    if ($tipo) {
        if ($tipo['REQUIERENOTA'] != 1) {
            $data['notaAprobacion'] = null;
        }
        if ($tipo['REQUIEREASISTENCIA'] != 1) {
            $data['asistenciaMinima'] = null;
        }
    }
    // Solo guardar costo si es pagado
    $data['costo'] = (!empty($_POST['esPagado']) && $_POST['esPagado']) ? $_POST['costo'] : 0;

    // Procesar imagen de portada
    $data['urlPortada'] = null;
    if (isset($_FILES['urlPortada']) && $_FILES['urlPortada']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid('portada_') . '_' . basename($_FILES['urlPortada']['name']);
        $rutaDestino = '../public/img/' . $nombreArchivo;
        if (move_uploaded_file($_FILES['urlPortada']['tmp_name'], $rutaDestino)) {
            $data['urlPortada'] = 'public/img/' . $nombreArchivo;
        }
    }

    // Procesar imagen de galería
    $data['urlGaleria'] = null;
    if (isset($_FILES['urlGaleria']) && $_FILES['urlGaleria']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid('galeria_') . '_' . basename($_FILES['urlGaleria']['name']);
        $rutaDestino = '../public/img/' . $nombreArchivo;
        if (move_uploaded_file($_FILES['urlGaleria']['tmp_name'], $rutaDestino)) {
            $data['urlGaleria'] = 'public/img/' . $nombreArchivo;
        }
    }

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
        $this->json($ok ? ['success' => true, 'mensaje' => 'Evento cancelado'] : ['success' => false, 'mensaje' => 'No se pudo cancelar el evento']);
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