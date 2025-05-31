<?php
header('Content-Type: application/json');
require_once '../core/Conexion.php';
require_once '../models/Usuario.php';

$db = Database::getConnection();
$usuarioModel = new Usuario($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $usuario = $usuarioModel->obtenerUsuarioPorId($_GET['id']);
            echo json_encode($usuario);
        } else {
            $usuarios = $usuarioModel->obtenerUsuarios();
            echo json_encode($usuarios);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $usuarioModel->insertarUsuario($data);
        echo json_encode(['success' => $result]);
        break;
    case 'PUT':
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        if (strpos($contentType, 'application/json') !== false) {
            $data = json_decode(file_get_contents("php://input"), true);
        } else {
            parse_str(file_get_contents("php://input"), $data);
        }
        $id = $data['id'] ?? null;
        if ($id) {
            $result = $usuarioModel->editarUsuario($id, $data);
            echo json_encode(['success' => $result]);
        } else {
            echo json_encode(['success' => false, 'error' => 'ID requerido']);
        }
        break;
    case 'DELETE':
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        if (strpos($contentType, 'application/json') !== false) {
            $data = json_decode(file_get_contents("php://input"), true);
        } else {
            parse_str(file_get_contents("php://input"), $data);
        }
        $id = $data['id'] ?? null;
        if ($id) {
            $result = $usuarioModel->eliminarUsuario($id);
            echo json_encode(['success' => $result]);
        } else {
            echo json_encode(['success' => false, 'error' => 'ID requerido']);
        }
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Método no soportado']);
        break;
}
?>