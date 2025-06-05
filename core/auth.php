<?php

if (!isset($_SESSION['usuario'])) {
    // Detecta si es petición AJAX o JSON
    $esJson = strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false;

    if ($esJson) {
        http_response_code(401);
        echo json_encode(['error' => 'No autorizado']);
    } else {
        header("Location: ../views/login.php");
    }
    exit;
}
?>
