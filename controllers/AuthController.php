<?php
session_start();
header('Content-Type: application/json');

class AuthController {
    public static function checkAuth() {
        if (isset($_SESSION['usuario'])) {
            echo json_encode(['authenticated' => true]);
        } else {
            echo json_encode(['authenticated' => false]);
        }
        exit;
    }
}

$option = isset($_GET['option']) ? $_GET['option'] : '';

switch ($option) {
    case 'checkAuth':
        AuthController::checkAuth();
        break;
    default:
        echo json_encode(['error' => 'Opción no válida']);
        exit;
}