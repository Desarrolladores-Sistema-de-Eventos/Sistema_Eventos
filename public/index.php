<?php
session_start(); 
if (!isset($_SESSION['usuario'])) {
    $vista = $_GET['view'] ?? 'home';
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

// Mostrar el dashboard correspondiente
if ($esResponsable) {
    include '../views/dashboard_Pri_Res.php'; // Vista para responsables de evento
} else {
    switch ($rol) {
        case 'ADMIN':
            include '../views/dashboard_Pri_Adm.php';
            break;
        case 'ESTUDIANTE':
        case 'DOCENTE':
        case 'INVITADO':
            include '../views/dashboard_Pri_Usu.php';
            break;
        default:
            echo "<h1>Acceso denegado</h1>";
            break;
    }
}
