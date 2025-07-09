<?php
session_start();
require_once '../models/EventosAdmin.php';
header('Content-Type: application/json');

class EventoController {
    // --- NUEVO: obtener requisitos generales ---
    public function requisitosGenerales() {
        require_once '../models/Requisitos.php';
        $reqModel = new Requisitos();
        $requisitos = $reqModel->getRequisitosGenerales();
        $this->json($requisitos);
    }
    private $eventoModelo;
    private $rol;

    public function __construct() {
        $this->eventoModelo = new Evento();
        $this->rol = $_SESSION['usuario']['CODIGOROL'] ?? null;
    }

    public function handleRequest() {
        $option = $_GET['option'] ?? '';
        switch ($option) {
            case 'requisitos_generales':
                $this->requisitosGenerales();
                break;
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

        // --- NUEVO: cargar requisitos asociados al evento ---
        require_once '../models/Requisitos.php';
        $reqModel = new Requisitos();
        $requisitosAsociados = $reqModel->getRequisitosPorEvento($id);
        if (is_array($requisitosAsociados) && count($requisitosAsociados) > 0) {
            $evento['requisitos'] = array_map(function($r) {
                return isset($r['SECUENCIAL']) ? $r['SECUENCIAL'] : null;
            }, $requisitosAsociados);
            $evento['requisitos_detalle'] = $requisitosAsociados; // [{SECUENCIAL, DESCRIPCION}]
        } else {
            $evento['requisitos'] = [];
            $evento['requisitos_detalle'] = [];
        }

        $this->json($evento);
    }

    private function crear() {
    if ($this->rol !== 'ADM') {
        $this->json(['success' => false, 'mensaje' => 'No autorizado']);
        return;
    }

    $data = $_POST;
    // Asegura que $data['carrera'] siempre sea array
    if (isset($data['carrera']) && !is_array($data['carrera'])) {
        $data['carrera'] = [$data['carrera']];
    }

    // Normalizar campos nuevos
    $data['contenido'] = isset($data['contenido']) ? $data['contenido'] : '';
    $data['asistenciaMinima'] = isset($data['asistenciaMinima']) && $data['asistenciaMinima'] !== '' ? $data['asistenciaMinima'] : null;

    // Validar campos requeridos
    $required = ['titulo', 'descripcion', 'horas', 'fechaInicio', 'fechaFin', 'modalidad', 'esSoloInternos', 'esPagado', 'categoria', 'tipoEvento', 'carrera', 'capacidad', 'responsable', 'organizador'];
    // Solo exigir notaAprobacion si el tipo de evento es curso
    $tipoCurso = null;
    $tipos = $this->eventoModelo->getTiposEvento();
    foreach ($tipos as $t) {
        if (strtolower($t['NOMBRE']) === 'curso') {
            $tipoCurso = $t['CODIGO'];
            break;
        }
    }
    if (isset($data['tipoEvento']) && $data['tipoEvento'] == $tipoCurso) {
        $required[] = 'notaAprobacion';
    }
    // Asegurar que notaAprobacion exista aunque sea null
    if (!isset($data['notaAprobacion'])) {
        $data['notaAprobacion'] = null;
    }
    foreach ($required as $campo) {
        if (!isset($data[$campo]) || $data[$campo] === '') {
            $this->json(['success' => false, 'mensaje' => "El campo $campo es obligatorio"]);
            return;
        }
    }

    // Procesar imagen de portada (siempre en la carpeta correcta)
    $data['urlPortada'] = null;
    if (isset($_FILES['urlPortada']) && $_FILES['urlPortada']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['urlPortada']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('portada_') . '.' . $extension;
        $rutaDestino = '../public/img/eventos/portadas/' . $nombreArchivo;
        // Crear carpeta si no existe
        if (!is_dir('../public/img/eventos/portadas/')) {
            mkdir('../public/img/eventos/portadas/', 0777, true);
        }
        if (move_uploaded_file($_FILES['urlPortada']['tmp_name'], $rutaDestino)) {
            $data['urlPortada'] = $nombreArchivo;
        }
    }

    // Procesar imagen de galería (siempre en la carpeta correcta)
    $data['urlGaleria'] = null;
    if (isset($_FILES['urlGaleria']) && $_FILES['urlGaleria']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['urlGaleria']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('galeria_') . '.' . $extension;
        $rutaDestino = '../public/img/eventos/galerias/' . $nombreArchivo;
        // Crear carpeta si no existe
        if (!is_dir('../public/img/eventos/galerias/')) {
            mkdir('../public/img/eventos/galerias/', 0777, true);
        }
        if (move_uploaded_file($_FILES['urlGaleria']['tmp_name'], $rutaDestino)) {
            $data['urlGaleria'] = $nombreArchivo;
        }
    }

    // Tomar el estado del POST si viene, si no, por defecto 'CREADO'
    $data['estado'] = isset($data['estado']) && $data['estado'] !== '' ? $data['estado'] : 'CREADO';

    $idEvento = $this->eventoModelo->crear($data);
    // Guardar requisitos asociados si se creó el evento
    if ($idEvento && isset($_POST['requisitos']) && is_array($_POST['requisitos'])) {
        require_once '../models/Requisitos.php';
        $reqModel = new Requisitos();
        $reqModel->eliminarPorEvento($idEvento); // Por si acaso
        $reqModel->asociarAEvento($idEvento, $_POST['requisitos']);
    }
    $this->json($idEvento ? ['success' => true, 'id' => $idEvento] : ['success' => false, 'mensaje' => 'No se pudo crear el evento']);
}

    private function editar() {
    // Tomar el estado del POST si viene, si no, por defecto 'CREADO'
    $data['estado'] = isset($data['estado']) && $data['estado'] !== '' ? $data['estado'] : 'CREADO';
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
    // Refuerzo: siempre inicializar carreras como array aunque no llegue del frontend
    if (!isset($data['carrera'])) {
        $data['carrera'] = [];
    } elseif (!is_array($data['carrera'])) {
        $data['carrera'] = [$data['carrera']];
    }

    // Normalizar campos nuevos
    $data['contenido'] = isset($data['contenido']) ? $data['contenido'] : '';
    $data['asistenciaMinima'] = isset($data['asistenciaMinima']) && $data['asistenciaMinima'] !== '' ? $data['asistenciaMinima'] : null;

    // Validar campos requeridos (igual que en crear)
    $required = ['titulo', 'descripcion', 'horas', 'fechaInicio', 'fechaFin', 'modalidad', 'esSoloInternos', 'esPagado', 'categoria', 'tipoEvento', 'carrera', 'capacidad', 'responsable', 'organizador'];
    $tipoCurso = null;
    $tipos = $this->eventoModelo->getTiposEvento();
    foreach ($tipos as $t) {
        if (strtolower($t['NOMBRE']) === 'curso') {
            $tipoCurso = $t['CODIGO'];
            break;
        }
    }
    if (isset($data['tipoEvento']) && $data['tipoEvento'] == $tipoCurso) {
        $required[] = 'notaAprobacion';
    }
    // Asegurar que notaAprobacion exista aunque sea null
    if (!isset($data['notaAprobacion'])) {
        $data['notaAprobacion'] = null;
    }
    foreach ($required as $campo) {
        if (!isset($data[$campo]) || $data[$campo] === '') {
            $this->json(['success' => false, 'mensaje' => "El campo $campo es obligatorio"]);
            return;
        }
    }

    // Procesar imagen de portada
    $data['urlPortada'] = null;
    if (isset($_FILES['urlPortada']) && $_FILES['urlPortada']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['urlPortada']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('portada_') . '.' . $extension;
        $rutaDestino = '../public/img/eventos/portadas/' . $nombreArchivo;
        if (move_uploaded_file($_FILES['urlPortada']['tmp_name'], $rutaDestino)) {
            $data['urlPortada'] = $nombreArchivo;
        }
    }

    // Procesar imagen de galería
    $data['urlGaleria'] = null;
    if (isset($_FILES['urlGaleria']) && $_FILES['urlGaleria']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['urlGaleria']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('galeria_') . '.' . $extension;
        $rutaDestino = '../public/img/eventos/galerias/' . $nombreArchivo;
        if (move_uploaded_file($_FILES['urlGaleria']['tmp_name'], $rutaDestino)) {
            $data['urlGaleria'] = $nombreArchivo;
        }
    }

    $ok = $this->eventoModelo->editar($id, $data);
    // Actualizar requisitos asociados (siempre eliminar y asociar los que vengan, aunque ninguno)
    if ($ok) {
        require_once '../models/Requisitos.php';
        $reqModel = new Requisitos();
        $reqModel->eliminarPorEvento($id);
        if (isset($_POST['requisitos']) && is_array($_POST['requisitos']) && count($_POST['requisitos']) > 0) {
            $reqModel->asociarAEvento($id, $_POST['requisitos']);
        }
    }
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