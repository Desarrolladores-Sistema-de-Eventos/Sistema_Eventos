<?php
// Activar errores solo en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
require_once '../models/CarruselModelo.php';

$carrusel = new CarruselModelo();
$accion = $_GET['accion'] ?? '';

switch ($accion) {
    case 'listar':
        echo json_encode($carrusel->obtenerCarrusel());
        break;

    case 'crear':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $urlImagen = '';

            if (!$titulo || empty($_FILES['imagen'])) {
                echo json_encode(['success' => false, 'mensaje' => 'Título e imagen son obligatorios']);
                exit;
            }

            if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreTmp = $_FILES['imagen']['tmp_name'];
                $nombreFinal = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $rutaDestino = '../uploads/carrusel/' . $nombreFinal;

                if (move_uploaded_file($nombreTmp, $rutaDestino)) {
                    $urlImagen = 'uploads/carrusel/' . $nombreFinal;
                } else {
                    echo json_encode(['success' => false, 'mensaje' => 'No se pudo mover el archivo']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al subir imagen']);
                exit;
            }

            $id = $carrusel->crearCarrusel($titulo, $descripcion, $urlImagen);
            echo json_encode(['success' => true, 'id' => $id]);
        }
        break;

    case 'eliminar':
        $id = $_POST['id'] ?? 0;
        if (!$id) {
            echo json_encode(['success' => false, 'mensaje' => 'ID inválido']);
            exit;
        }
        $res = $carrusel->eliminarCarrusel($id);
        echo json_encode(['success' => $res]);
        break;

    default:
        echo json_encode(['success' => false, 'mensaje' => 'Acción no válida']);
        break;

    case 'editar':
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    
    $rutaImagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $nombre = uniqid() . "_" . basename($_FILES['imagen']['name']);
        $ruta = "../uploads/carrusel/" . $nombre;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
        $rutaImagen = "uploads/carrusel/" . $nombre;
    }

    $modelo = new CarruselModelo();
    $ok = $modelo->actualizarCarrusel($id, $titulo, $descripcion, $rutaImagen);
    echo json_encode(['success' => $ok]);
    break;

}
