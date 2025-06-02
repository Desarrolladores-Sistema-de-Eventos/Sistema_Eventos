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
    // Siempre responde con JSON
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
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
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
        } else {
            echo json_encode(['success' => false, 'error' => 'ID requerido']);
        }
        break;
case 'DELETE':
    try {
        parse_str(file_get_contents("php://input"), $data);
        $id = $data['id'] ?? null;
        
        if (!$id) {
            throw new Exception('ID no proporcionado');
        }

        // Verificar relaciones
        $tieneRelaciones = $usuarioModel->tieneRelaciones($id);
        
        if ($tieneRelaciones) {
            // Eliminación lógica (desactivar)
            $result = $usuarioModel->eliminarLogico($id);
            echo json_encode([
                'success' => $result['success'] ?? false,
                'mensaje' => $result['message'] ?? 'Error al desactivar usuario',
                'tipo' => 'logico'
            ]);
        } else {
            // Eliminación física
            $result = $usuarioModel->eliminarFisico($id);
            echo json_encode([
                'success' => $result['success'] ?? false,
                'mensaje' => $result['message'] ?? 'Error al eliminar usuario',
                'tipo' => 'fisico'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'mensaje' => 'Error: ' . $e->getMessage()
        ]);
    }
    break;

}
?>