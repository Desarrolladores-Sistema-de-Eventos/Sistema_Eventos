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

// Si se requiere un rol específico
if (isset($rolRequerido) && !esRol($rolRequerido)) {
   header("Location: ../views/404.php");
    exit;
}

// Si se requieren varios roles permitidos
if (isset($rolesPermitidos) && !esUnoDe($rolesPermitidos)) {
    header("Location: ../views/404.php");
    exit;
}

// Validación especial de responsable
if (isset($requiereResponsable) && $requiereResponsable && !esResponsable()) {
    header("Location: ../views/404.php");
    exit;
}
?>
