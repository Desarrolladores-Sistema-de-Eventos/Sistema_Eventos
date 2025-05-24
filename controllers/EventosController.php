<?php
require_once '../core/auth.php';         // ← 👈 Validación central aquí
require_once '../models/Evento.php';

$cedula = $_SESSION['usuario']['CEDULA'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'actualizar') {
    $data = json_decode(file_get_contents('php://input'), true);
    $idEvento = $data['ID_EVENTO'] ?? null;

    if (!Evento::esResponsableDelEvento($cedula, $idEvento)) {
        http_response_code(403);
        echo json_encode(['error' => 'No autorizado']);
        exit;
    }

    if (Evento::actualizar($idEvento, $data)) {
        echo json_encode(['ok' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al actualizar']);
    }
}
