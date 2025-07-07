<?php
session_start(); 

// Función para generar el encabezado HTML con favicon
function getHeader($title = 'Inicio') {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>$title</title>
        <!-- Favicon de casa (SVG inline) -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512'><path fill='%23000' d='M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z'/></svg>">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    HTML;
}

if (!isset($_SESSION['usuario'])) {
    $vista = $_GET['view'] ?? 'home';
    
    // Mostrar header antes de incluir la vista
    getHeader(ucfirst($vista));
    
    switch ($vista) {
        case 'login':
            include '../views/login.php';
            break;
        case 'home':
        default:
            include '../views/home.php';
            break;
    }
    exit;
}

// Usuario autenticado
$usuario = $_SESSION['usuario'];
$rol = strtoupper($usuario['ROL'] ?? '');
$esResponsable = !empty($usuario['ES_RESPONSABLE']);

// Mostrar header para usuarios logueados
getHeader('Dashboard');

// Mostrar el dashboard correspondiente
if ($esResponsable) {
    include '../views/dashboard_Pri_Res.php';
} else {
    switch ($rol) {
        case 'ADMIN':
            include '../views/dashboard_Pri_Adm.php';
            break;
        case 'ESTUDIANTE':
        case 'DOCENTE':
        case 'INVITADO':
            include '../views/Eventos_Views.php';
            break;
        default:
            echo "<h1>Acceso denegado</h1>";
            break;
    }
}

// Cerrar HTML
echo '</body></html>';
?>