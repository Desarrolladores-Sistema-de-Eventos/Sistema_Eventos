<?php
// Mostrar errores en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
require_once '../models/CarreraModelo.php';

$modelo = new CarreraModelo();
$accion = $_GET['accion'] ?? '';

switch ($accion) {
    case 'listar':
        echo json_encode($modelo->getCarreras());
        break;

    case 'crear':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $facultad = $_POST['facultad'] ?? '';
            $rutaImagen = '';

            if (!$nombre || !$facultad) {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'Todos los campos son obligatorios']);
                exit;
            }

            // Validar imagen
            if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'Imagen no válida']);
                exit;
            }

            $nombreFinal = uniqid() . '_' . basename($_FILES['imagen']['name']);
            $rutaDestino = '../public/img/carreras/' . $nombreFinal;

            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'No se pudo mover la imagen']);
                exit;
            }

            $rutaImagen = 'public/img/carreras/' . $nombreFinal;

            $id = $modelo->crearCarrera($nombre, $facultad, $rutaImagen);

            echo json_encode([
                'tipo' => $id ? 'success' : 'error',
                'mensaje' => $id ? 'Carrera guardada correctamente' : 'Error al guardar carrera',
                'id' => $id
            ]);
        }
        break;

    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nombre = trim($_POST['nombre'] ?? '');
            $facultad = $_POST['facultad'] ?? '';

            if (!$id || !$nombre || !$facultad) {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'Todos los campos son obligatorios']);
                exit;
            }

            $rutaImagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreFinal = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $rutaDestino = '../public/img/carreras/' . $nombreFinal;

                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    echo json_encode(['tipo' => 'error', 'mensaje' => 'Error al guardar la nueva imagen']);
                    exit;
                }

                $rutaImagen = 'public/img/carreras/' . $nombreFinal;
            }

            $res = $modelo->actualizarCarrera($id, $nombre, $facultad, $rutaImagen);

            echo json_encode([
                'tipo' => $res ? 'success' : 'error',
                'mensaje' => $res ? 'Carrera actualizada correctamente' : 'Error al actualizar'
            ]);
        }
        break;

    case 'eliminar':
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['tipo' => 'error', 'mensaje' => 'ID no proporcionado']);
            exit;
        }

        $res = $modelo->eliminarCarrera($id);
        echo json_encode(['tipo' => $res ? 'success' : 'error', 'mensaje' => $res ? 'Carrera eliminada' : 'Error al eliminar']);
        break;

    default:
        echo json_encode(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
        break;
}
