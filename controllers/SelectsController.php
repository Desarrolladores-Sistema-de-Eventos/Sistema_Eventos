<?php
require_once '../core/Conexion.php';
header('Content-Type: application/json');

$db = Conexion::getConexion();

function cargarTipos() {
    global $db;
    $stmt = $db->query("SELECT CODIGO, NOMBRE, REQUIERENOTA, REQUIEREASISTENCIA FROM tipo_evento");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cargar($tabla, $valueField, $textField) {
    global $db;
    $stmt = $db->query("SELECT $valueField AS value, $textField AS text FROM $tabla");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cargarRequisitosGlobales() {
    global $db;
    $stmt = $db->query("SELECT SECUENCIAL AS value, DESCRIPCION AS text FROM requisito_evento WHERE SECUENCIALEVENTO IS NULL");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode([
    'modalidades' => cargar('modalidad_evento', 'CODIGO', 'NOMBRE'),
    'tipos'       => cargarTipos(),
    'carreras'    => cargar('carrera', 'SECUENCIAL', 'NOMBRE_CARRERA'),
    'categorias'  => cargar('categoria_evento', 'SECUENCIAL', 'NOMBRE'),
    'estados' => [
        ['value' => 'DISPONIBLE', 'text' => 'Disponible'],
        ['value' => 'EN CURSO', 'text' => 'En curso'],
        ['value' => 'FINALIZADO', 'text' => 'Finalizado'],
        ['value' => 'CERRADO', 'text' => 'Cerrado'],
        ['value' => 'CANCELADO', 'text' => 'Cancelado']
    ],
    'requisitos'  => cargarRequisitosGlobales()
]);




