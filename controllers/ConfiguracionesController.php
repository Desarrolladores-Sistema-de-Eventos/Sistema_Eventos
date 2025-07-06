<?php
session_start();
require_once '../models/Configuraciones.php';

header('Content-Type: application/json');

class ConfiguracionesController
{
    private $configuracionesModelo;
    private $idUsuario;
    

public function __construct()
{
    $this->pdo = Conexion::getConexion();
    $this->configuracionesModelo = new Configuraciones();

    // Acciones públicas permitidas sin sesión
    $opcion = $_GET['option'] ?? '';
    $accionesPublicas = ['carrera_fisei'];

    // Verificamos sesión solo si NO es una acción pública
    if (!in_array($opcion, $accionesPublicas)) {
        $this->idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;

        if (!$this->idUsuario) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Sesión expirada']);
            exit;
        }
    }
}

    public function handleRequest()
    {
        $option = $_GET['option'] ?? '';

        switch ($option) {
            // FACULTAD
            case 'facultad_listar': $this->listarFacultades(); break;
            case 'facultad_guardar': $this->guardarFacultad(); break;
            case 'facultad_actualizar': $this->actualizarFacultad(); break;
            case 'facultad_eliminar': $this->eliminarFacultad(); break;
            //CARRERAS DE LA FISEI
            case 'carrera_fisei':$this->listarCarrerasFISEI(); break;
            // AUTORIDADES PÚBLICAS
            case 'autoridades_publicas': $this->listarAutoridadesPublic(); break;
            // CARRERA
            case 'carrera_listar': $this->listarCarreras(); break;
            case 'carrera_guardar': $this->guardarCarrera(); break;
            case 'carrera_actualizar': $this->actualizarCarrera(); break;
            case 'carrera_eliminar': $this->eliminarCarrera(); break;
            // TIPO EVENTO
            case 'tipo_evento_listar': $this->listarTiposEvento(); break;
            case 'tipo_evento_guardar': $this->guardarTipoEvento(); break;
            case 'tipo_evento_actualizar': $this->actualizarTipoEvento(); break;
            case 'tipo_evento_eliminar': $this->eliminarTipoEvento(); break;
            // CATEGORIA EVENTO
            case 'categoria_evento_listar': $this->listarCategoriasEvento(); break;
            case 'categoria_evento_guardar': $this->guardarCategoriaEvento(); break;
            case 'categoria_evento_actualizar': $this->actualizarCategoriaEvento(); break;
            case 'categoria_evento_eliminar': $this->eliminarCategoriaEvento(); break;
            // MODALIDAD EVENTO
            case 'modalidad_evento_listar': $this->listarModalidadesEvento(); break;
            case 'modalidad_evento_guardar': $this->guardarModalidadEvento(); break;
            case 'modalidad_evento_actualizar': $this->actualizarModalidadEvento(); break;
            case 'modalidad_evento_eliminar': $this->eliminarModalidadEvento(); break;
            // REQUISITO EVENTO
            case 'requisito_evento_listar': $this->listarRequisitosEvento(); break;
            case 'requisito_evento_guardar': $this->guardarRequisitoEvento(); break;
            case 'requisito_evento_actualizar': $this->actualizarRequisitoEvento(); break;
            case 'requisito_evento_eliminar': $this->eliminarRequisitoEvento(); break;
            // FORMA DE PAGO
            case 'forma_pago_listar': $this->listarFormasPago(); break;
            case 'forma_pago_guardar': $this->guardarFormaPago(); break;
            case 'forma_pago_actualizar': $this->actualizarFormaPago(); break;
            case 'forma_pago_eliminar': $this->eliminarFormaPago(); break;
            // ROL USUARIO
            case 'rol_usuario_listar': $this->listarRolesUsuario(); break;
            case 'rol_usuario_guardar': $this->guardarRolUsuario(); break;
            case 'rol_usuario_actualizar': $this->actualizarRolUsuario(); break;
            case 'rol_usuario_eliminar': $this->eliminarRolUsuario(); break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
        }
    }
//===================== CARRERAS DE LA FISEI =================
private function listarCarrerasFISEI() {
    try {
        $stmt = $this->pdo->prepare("
            SELECT carrera.SECUENCIAL, carrera.NOMBRE_CARRERA, carrera.IMAGEN, facultad.NOMBRE
            FROM carrera
            INNER JOIN facultad ON carrera.SECUENCIALFACULTAD = facultad.SECUENCIAL
            WHERE facultad.SECUENCIAL = 9
            ORDER BY carrera.SECUENCIAL DESC
        ");
        $stmt->execute();
        $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($carreras);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener carreras FISEI']);
    }
}

//===================== AUTORIDADES DE LA FISEI =================
private function listarAutoridadesPublic() {
    try {
        $stmt = $this->pdo->prepare("
            SELECT 
                SECUENCIAL AS identificador,
                NOMBRE AS nombre,
                CARGO AS cargo,
                CORREO AS correo,
                TELEFONO AS telefono,
                FOTO_URL AS imagen
            FROM autoridades
            ORDER BY SECUENCIAL DESC
        ");
        $stmt->execute();
        $autoridades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($autoridades);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener autoridades públicas']);
    }
}


// ================= FACULTAD =================
private function listarFacultades() {
    $data = $this->configuracionesModelo->obtenerFacultades();
    $this->json($data);
}

private function guardarFacultad() {
    $required = ['nombre', 'mision', 'vision', 'ubicacion'];
    foreach ($required as $campo) {
        if (empty($_POST[$campo])) {
            $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
            return;
        }
    }

    $sigla = $_POST['sigla'] ?? null;
    $about = $_POST['about'] ?? null;
    $urlLogo = $_FILES['urlLogo'] ?? null;
    $urlPortada = $_FILES['urlPortada'] ?? null;

    $rutaLogo = $urlLogo && $urlLogo['tmp_name'] ? $this->guardarArchivo($urlLogo) : null;
    $rutaPortada = $urlPortada && $urlPortada['tmp_name'] ? $this->guardarArchivo($urlPortada) : null;

    try {
        $id = $this->configuracionesModelo->crearFacultad(
            $_POST['nombre'], $_POST['mision'], $_POST['vision'], $_POST['ubicacion'],
            $sigla, $about, $rutaLogo, $rutaPortada
        );
        $this->json(['tipo' => 'success', 'mensaje' => 'Facultad creada', 'id' => $id]);
    } catch (Exception $e) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear facultad', 'debug' => $e->getMessage()]);
    }
}

private function actualizarFacultad() {
    $id = $_POST['id'] ?? null;
    if (!$id) {
        $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']);
        return;
    }

    $sigla = $_POST['sigla'] ?? null;
    $about = $_POST['about'] ?? null;
    $rutaLogo = $_POST['urlLogo'] ?? null;    
    $rutaPortada = $_POST['urlPortada'] ?? null;

    try {
        $ok = $this->configuracionesModelo->actualizarFacultad(
            $id, $_POST['nombre'], $_POST['mision'], $_POST['vision'], $_POST['ubicacion'],
            $sigla, $about, $rutaLogo, $rutaPortada
        );
        $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Facultad actualizada' : 'No se pudo actualizar']);
    } catch (Exception $e) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar facultad', 'debug' => $e->getMessage()]);
    }
}

private function eliminarFacultad() {
    $id = $_POST['id'] ?? null;
    if (!$id) {
        $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']);
        return;
    }

    try {
        $ok = $this->configuracionesModelo->eliminarFacultad($id);
        $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Facultad eliminada' : 'No se pudo eliminar']);
    } catch (Exception $e) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar facultad', 'debug' => $e->getMessage()]);
    }
}

private function guardarArchivo($archivo) {
    $directorio = '../uploads/';
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $nombreArchivo = uniqid() . '_' . basename($archivo['name']);
    $rutaDestino = $directorio . $nombreArchivo;

    if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        return $rutaDestino;
    }

    return null;
}

// ================= CARRERA =================
private function guardarCarrera() {
    $required = ['nombre', 'facultad'];
    file_put_contents('debug_carrera.txt', print_r($_POST, true) . "\n" . print_r($_FILES, true));
    foreach ($required as $campo) {
        if (empty($_POST[$campo])) {
            $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
            return;
        }
    }

    // Validar imagen
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        $this->json(['tipo' => 'error', 'mensaje' => 'La imagen es obligatoria o no se pudo subir.']);
        return;
    }

    // Procesar imagen
    $imgDir = '../public/img/carreras/';
    if (!is_dir($imgDir)) {
        mkdir($imgDir, 0777, true);
    }

    $nombreArchivo = basename($_FILES['imagen']['name']);
    $rutaRelativa = 'public/img/carreras/' . $nombreArchivo;
    $rutaAbsoluta = $imgDir . $nombreArchivo;

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaAbsoluta)) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Error al guardar la imagen.']);
        return;
    }

    try {
        $id = $this->configuracionesModelo->crearCarrera(
            $_POST['nombre'],
            $_POST['facultad'],
            $rutaRelativa
        );
        $this->json(['tipo' => 'success', 'mensaje' => 'Carrera creada', 'id' => $id]);
    } catch (Exception $e) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear carrera', 'debug' => $e->getMessage()]);
    }
}

private function listarCarreras() {
    require_once '../models/CarreraModelo.php';
    $modelo = new CarreraModelo();
    $carreras = $modelo->getCarreras();
    echo json_encode($carreras);
}

private function actualizarCarrera() {
    $required = ['id', 'nombre', 'facultad'];
    foreach ($required as $campo) {
        if (empty($_POST[$campo])) {
            $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
            return;
        }
    }

    $imagenRuta = null;

    // Si se sube nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imgDir = '../public/img/carreras/';
        if (!is_dir($imgDir)) {
            mkdir($imgDir, 0777, true);
        }

        $nombreArchivo = basename($_FILES['imagen']['name']);
        $rutaRelativa = 'public/img/carreras/' . $nombreArchivo;
        $rutaAbsoluta = $imgDir . $nombreArchivo;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaAbsoluta)) {
            $imagenRuta = $rutaRelativa;
        }
    }

    try {
        $this->configuracionesModelo->actualizarCarrera(
            $_POST['id'],
            $_POST['nombre'],
            $_POST['facultad'],
            $imagenRuta
        );
        $this->json(['tipo' => 'success', 'mensaje' => 'Carrera actualizada']);
    } catch (Exception $e) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar carrera', 'debug' => $e->getMessage()]);
    }
}

private function eliminarCarrera() {
    if (empty($_POST['id'])) {
        $this->json(['tipo' => 'error', 'mensaje' => 'ID no proporcionado']);
        return;
    }

    try {
        $this->configuracionesModelo->eliminarCarrera($_POST['id']);
        $this->json(['tipo' => 'success', 'mensaje' => 'Carrera eliminada']);
    } catch (Exception $e) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar carrera', 'debug' => $e->getMessage()]);
    }
}




    // ================= TIPO EVENTO =================
    private function listarTiposEvento() {
        $data = $this->configuracionesModelo->obtenerTiposEvento();
        $this->json($data);
    }
    private function guardarTipoEvento() {
        $required = ['codigo', 'nombre', 'descripcion'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $codigo = $this->configuracionesModelo->crearTipoEvento(
                $_POST['codigo'], $_POST['nombre'], $_POST['descripcion'],
                $_POST['REQUIERENOTA'] ?? 0, $_POST['REQUIEREASISTENCIA'] ?? 0
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Tipo de evento creado', 'codigo' => $codigo]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear tipo de evento', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarTipoEvento() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarTipoEvento(
                $codigo, $_POST['nombre'], $_POST['descripcion'],
                $_POST['REQUIERENOTA'] ?? 0, $_POST['REQUIEREASISTENCIA'] ?? 0
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Tipo de evento actualizado' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar tipo de evento', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarTipoEvento() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarTipoEvento($codigo);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Tipo de evento eliminado' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar tipo de evento', 'debug' => $e->getMessage()]);
        }
    }

    // ================= CATEGORIA EVENTO =================
    private function listarCategoriasEvento() {
        $data = $this->configuracionesModelo->obtenerCategoriasEvento();
        $this->json($data);
    }
    private function guardarCategoriaEvento() {
        $required = ['nombre', 'descripcion'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $id = $this->configuracionesModelo->crearCategoriaEvento(
                $_POST['nombre'], $_POST['descripcion']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Categoría creada', 'id' => $id]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear categoría', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarCategoriaEvento() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarCategoriaEvento(
                $id, $_POST['nombre'], $_POST['descripcion']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Categoría actualizada' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar categoría', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarCategoriaEvento() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarCategoriaEvento($id);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Categoría eliminada' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar categoría', 'debug' => $e->getMessage()]);
        }
    }

    // ================= MODALIDAD EVENTO =================
    private function listarModalidadesEvento() {
        $data = $this->configuracionesModelo->obtenerModalidadesEvento();
        $this->json($data);
    }
    private function guardarModalidadEvento() {
        $required = ['codigo', 'nombre'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $codigo = $this->configuracionesModelo->crearModalidadEvento(
                $_POST['codigo'], $_POST['nombre']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Modalidad creada', 'codigo' => $codigo]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear modalidad', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarModalidadEvento() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarModalidadEvento(
                $codigo, $_POST['nombre']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Modalidad actualizada' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar modalidad', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarModalidadEvento() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarModalidadEvento($codigo);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Modalidad eliminada' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar modalidad', 'debug' => $e->getMessage()]);
        }
    }

    // ================= REQUISITO EVENTO =================
    private function listarRequisitosEvento() {
        $data = $this->configuracionesModelo->obtenerRequisitosEvento();
        $this->json($data);
    }
    private function guardarRequisitoEvento() {
        $descripcion = $_POST['descripcion'] ?? null;
        if (!$descripcion) {
            $this->json(['tipo' => 'error', 'mensaje' => 'El campo "descripcion" es obligatorio.']);
            return;
        }
        // Solo permite guardar requisitos generales (idEvento debe ser null)
        $idEvento = $_POST['idEvento'] ?? null;
        if ($idEvento !== null && $idEvento !== '' && strtolower($idEvento) !== 'null') {
            $this->json(['tipo' => 'error', 'mensaje' => 'Solo se pueden crear requisitos generales (sin evento asociado).']);
            return;
        }
        $esObligatorio = $_POST['esObligatorio'] ?? null;
        try {
            $id = $this->configuracionesModelo->crearRequisitoEvento($descripcion, null, $esObligatorio);
            if ($id === false) {
                $this->json(['tipo' => 'error', 'mensaje' => 'No se pudo crear el requisito.']);
            } else {
                $this->json(['tipo' => 'success', 'mensaje' => 'Requisito creado', 'id' => $id]);
            }
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear requisito', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarRequisitoEvento() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        $descripcion = $_POST['descripcion'] ?? null;
        $idEvento = $_POST['idEvento'] ?? null;
        $esObligatorio = $_POST['esObligatorio'] ?? null;
        try {
            $ok = $this->configuracionesModelo->actualizarRequisitoEvento($id, $descripcion, $idEvento, $esObligatorio);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Requisito actualizado' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar requisito', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarRequisitoEvento() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarRequisitoEvento($id);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Requisito eliminado' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar requisito', 'debug' => $e->getMessage()]);
        }
    }

    // ================= FORMA DE PAGO =================
    private function listarFormasPago() {
        $data = $this->configuracionesModelo->obtenerFormasPago();
        $this->json($data);
    }
    private function guardarFormaPago() {
        $required = ['codigo', 'nombre'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $codigo = $this->configuracionesModelo->crearFormaPago(
                $_POST['codigo'], $_POST['nombre']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Forma de pago creada', 'codigo' => $codigo]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear forma de pago', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarFormaPago() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarFormaPago(
                $codigo, $_POST['nombre']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Forma de pago actualizada' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar forma de pago', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarFormaPago() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarFormaPago($codigo);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Forma de pago eliminada' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar forma de pago', 'debug' => $e->getMessage()]);
        }
    }
    
    // ========== CARRUSEL ==========
    private function listarCarrusel() {
        $data = $this->configuracionesModelo->obtenerCarrusel();
        $this->json($data);
    }

    private function guardarCarrusel() {
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $file = $_FILES['imagen'] ?? null;

        if (!$titulo || !$file) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Título e imagen son obligatorios.']);
            return;
        }

        $nombreImagen = 'carrusel_' . uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $ruta = '../uploads/' . $nombreImagen;
        move_uploaded_file($file['tmp_name'], $ruta);

        try {
            $id = $this->configuracionesModelo->crearCarrusel($titulo, $descripcion, $nombreImagen);
            $this->json(['tipo' => 'success', 'mensaje' => 'Imagen guardada', 'id' => $id]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al guardar imagen']);
        }
    }

    private function eliminarCarrusel() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido']);
            return;
        }

        $ok = $this->configuracionesModelo->eliminarCarrusel($id);
        $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Imagen eliminada' : 'No se pudo eliminar']);
    }

    // ================= ROL USUARIO =================
    private function listarRolesUsuario() {
        $data = $this->configuracionesModelo->obtenerRolesUsuario();
        $this->json($data);
    }
    private function guardarRolUsuario() {
        $required = ['codigo', 'nombre'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $codigo = $this->configuracionesModelo->crearRolUsuario(
                $_POST['codigo'], $_POST['nombre']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Rol creado', 'codigo' => $codigo]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear rol', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarRolUsuario() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarRolUsuario(
                $codigo, $_POST['nombre']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Rol actualizado' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar rol', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarRolUsuario() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarRolUsuario($codigo);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Rol eliminado' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar rol', 'debug' => $e->getMessage()]);
        }
    }

    private function json($data)
    {
        echo json_encode($data);
    }
}

$controller = new ConfiguracionesController();
$controller->handleRequest();
