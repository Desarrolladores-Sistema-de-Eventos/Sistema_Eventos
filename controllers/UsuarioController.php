<?php
session_start();
require_once '../models/Usuarios.php';

header('Content-Type: application/json');

class UsuarioController {
    private $usuarioModelo;
    private $idUsuario;
    private $rol;

    public function __construct() {
        $this->usuarioModelo = new Usuario();
        $this->idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;
        $this->rol = $_SESSION['usuario']['CODIGOROL'] ?? null;
    }

    public function handleRequest() {
        $option = $_GET['option'] ?? '';
        switch ($option) {
            case 'insertar':
                $this->guardar();
                break;
            case 'editar':
                $this->actualizar();
                break;
            case 'eliminar':
                $this->eliminar();
                break;
            case 'inactivar':
                $this->inactivar();
                break;
            case 'get':
                $this->get();
                break;
            case 'listar':
                $this->listar();
                break;
            case 'registrarUsuario':
                $this->registrarUsuario();
                break;
            case 'actualizarPerfilUsuario':
                $this->actualizarPerfilUsuario();
                break; 
            case 'perfilUsuario':
                $this->perfilUsuario();
                break;
            case 'listarCarrera':
                $this->listarCarreras();
                break;
            default:
                $this->json(['success' => false, 'mensaje' => 'Acción no válida']);
        }
    }

    // Guardar (insertar) usuario
    private function guardar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $required = ['nombres', 'apellidos', 'telefono', 'correo', 'contrasena', 'codigorol'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['success' => false, 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $foto_perfil = $this->procesarFotoPerfil();
            $resp = $this->usuarioModelo->insertar(
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['telefono'],
                $_POST['direccion'] ?? '',
                $_POST['correo'],
                $_POST['contrasena'],
                $_POST['codigorol'],
                $_POST['es_interno'] ?? 1,
                $foto_perfil
            );
            $this->json($resp);
        } catch (Exception $e) {
            $this->json([
                'success' => false,
                'mensaje' => 'Error al crear usuario',
                'debug' => $e->getMessage()
            ]);
        }
    }

    // Actualizar (editar) usuario
    private function actualizar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $required = ['id', 'nombres', 'apellidos', 'telefono', 'correo', 'codigorol', 'estado'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['success' => false, 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $foto_perfil = $this->procesarFotoPerfil();
            if (!$foto_perfil && isset($_POST['foto_perfil_actual'])) {
                $foto_perfil = $_POST['foto_perfil_actual'];
            }
            $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
            $resp = $this->usuarioModelo->editar(
                $_POST['id'],
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['telefono'],
                $_POST['direccion'] ?? '',
                $_POST['correo'],
                $_POST['codigorol'],
                $_POST['estado'],
                $_POST['es_interno'] ?? 1,
                $contrasena,
                $foto_perfil
            );
            $this->json($resp);
        } catch (Exception $e) {
            $this->json([
                'success' => false,
                'mensaje' => 'Error al actualizar usuario',
                'debug' => $e->getMessage()
            ]);
        }
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
        $resp = $this->usuarioModelo->eliminar($id);
        $this->json($resp);
    }

    private function inactivar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->json(['success' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $resp = $this->usuarioModelo->ponerEstadoInactivo($id);
        $this->json($resp);
    }

    private function get() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->json(['success' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $usuario = $this->usuarioModelo->getById($id);
        $this->json($usuario);
    }

    private function listar() {
        if ($this->rol !== 'ADM') {
            $this->json(['success' => false, 'mensaje' => 'No autorizado']);
            return;
        }
        $usuarios = $this->usuarioModelo->listar();
        $this->json($usuarios);
    }

    // Registro público (sin sesión)
    private function registrarUsuario() {
        $required = ['nombres', 'apellidos', 'telefono', 'direccion', 'correo', 'contrasena', 'codigorol'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['success' => false, 'mensaje' => "El campo $campo es obligatorio"]);
                return;
            }
        }
        try {
            $foto_perfil = $this->procesarFotoPerfil();
            $resp = $this->usuarioModelo->insertar(
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['telefono'],
                $_POST['direccion'],
                $_POST['correo'],
                $_POST['contrasena'],
                $_POST['codigorol'],
                $_POST['es_interno'] ?? 1,
                $foto_perfil
            );
            $this->json($resp);
        } catch (Exception $e) {
            $this->json([
                'success' => false,
                'mensaje' => 'Error al registrar usuario',
                'debug' => $e->getMessage()
            ]);
        }
    }

    // Procesa la subida de la foto de perfil y retorna el nombre del archivo o null
    private function procesarFotoPerfil() {
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = uniqid('perfil_') . '_' . basename($_FILES['foto_perfil']['name']);
            $rutaDestino = __DIR__ . '/../public/img/' . $nombreArchivo;
            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                return $nombreArchivo;
            }
        }
        return null;
    }
    private function procesarCedulaPDF() {
    if (isset($_FILES['cedula_pdf']) && $_FILES['cedula_pdf']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid('cedula_') . '_' . basename($_FILES['cedula_pdf']['name']);
        $rutaDestino = __DIR__ . '/../public/img/' . $nombreArchivo;
        if (move_uploaded_file($_FILES['cedula_pdf']['tmp_name'], $rutaDestino)) {
            return $nombreArchivo;
        }
    }
    return null;
}


    private function json($data) {
        echo json_encode($data);
    }

private function actualizarPerfilUsuario() {
    if (!$this->idUsuario) {
        $this->json(['success' => false, 'mensaje' => 'No autenticado']);
        return;
    }

    $required = ['identificacion', 'nombres', 'apellidos'];
    foreach ($required as $campo) {
        if (empty($_POST[$campo])) {
            $this->json(['success' => false, 'mensaje' => "Falta el campo: $campo"]);
            return;
        }
    }
    // Validar teléfono: solo números y 10 dígitos
if (!preg_match('/^\d{10}$/', $_POST['telefono'])) {
    $this->json(['success' => false, 'mensaje' => 'El teléfono debe tener 10 dígitos numéricos.']);
    return;
}

// Validar cédula: solo números y 10 dígitos (puedes personalizar si usas otro formato)
if (!preg_match('/^\d{10}$/', $_POST['identificacion'])) {
    $this->json(['success' => false, 'mensaje' => 'La cédula debe tener 10 dígitos numéricos.']);
    return;
}

// Validar edad mínima: 18 años
if (!empty($_POST['fecha_nacimiento'])) {
    $fechaNacimiento = new DateTime($_POST['fecha_nacimiento']);
    $hoy = new DateTime();
    $edad = $hoy->diff($fechaNacimiento)->y;

    if ($edad < 18) {
        $this->json(['success' => false, 'mensaje' => 'Debes tener al menos 18 años.']);
        return;
    }
}

    try {
        $fotoNombre = null;
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) throw new Exception('Formato de imagen inválido');
            $fotoNombre = 'perfil_' . uniqid() . '.' . $ext;
            $rutaDestino = dirname(__DIR__) . '/public/img/' . $fotoNombre;
            move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino);
        }

        $cedulaNombre = null;
        if (isset($_FILES['cedula_pdf']) && $_FILES['cedula_pdf']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['cedula_pdf']['name'], PATHINFO_EXTENSION));
            if ($ext !== 'pdf') throw new Exception('El archivo de cédula debe ser PDF');
            $cedulaNombre = 'cedula_' . uniqid() . '.' . $ext;
            $rutaDestino = dirname(__DIR__) . '/public/img/' . $cedulaNombre;
            move_uploaded_file($_FILES['cedula_pdf']['tmp_name'], $rutaDestino);
        }

        $carreraId = $_POST['carrera'] ?? null;

        $resp = $this->usuarioModelo->actualizarDatosPerfil(
            $this->idUsuario,
            $_POST['nombres'],
            $_POST['apellidos'],
            $_POST['identificacion'],
            $_POST['fecha_nacimiento'] ?? '',
            $_POST['telefono'] ?? '',
            $_POST['direccion'] ?? '',
            $fotoNombre,
            $cedulaNombre,
            $carreraId
        );

        $this->json($resp);
    } catch (Exception $e) {
        $this->json([
            'success' => false,
            'mensaje' => 'Error al actualizar perfil',
            'debug' => $e->getMessage()
        ]);
    }
}


private function perfilUsuario() {
    if (!$this->idUsuario) {
        $this->json(['success' => false, 'mensaje' => 'Sesión no válida']);
        return;
    }

    $usuario = $this->usuarioModelo->getById($this->idUsuario);

    if (!$usuario) {
        $this->json(['success' => false, 'mensaje' => 'Usuario no encontrado']);
        return;
    }

    // Preparar URLs
    $usuario['FOTO_PERFIL_URL'] = !empty($usuario['FOTO_PERFIL']) ? '../public/img/' . $usuario['FOTO_PERFIL'] : '';
    $usuario['CEDULA_PDF_URL'] = !empty($usuario['URL_CEDULA']) ? '../public/img/' . $usuario['URL_CEDULA'] : '';

    // Enviar al frontend todo lo necesario
    $this->json([
        'success' => true,
        'usuario' => $usuario
    ]);
}
private function listarCarreras() {
    try {
        $carreras = $this->usuarioModelo->obtenerCarreras(); // o como se llame en tu modelo
        $this->json(['success' => true, 'carreras' => $carreras]);
    } catch (Exception $e) {
        $this->json(['success' => false, 'mensaje' => 'Error cargando carreras', 'debug' => $e->getMessage()]);
    }
}




}

$controller = new UsuarioController();
$controller->handleRequest();
