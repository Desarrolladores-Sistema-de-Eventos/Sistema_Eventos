<?php
require_once '../core/Conexion.php';
header('Content-Type: application/json');

$db = Conexion::getConexion();


function cargar($tabla, $valueField, $textField) {
    global $db;
    $stmt = $db->query("SELECT $valueField AS value, $textField AS text FROM $tabla");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cargarRequisitosGenerales() {
    global $db;
    // Solo los requisitos generales (no asociados a ningún evento)
    $stmt = $db->query("SELECT SECUENCIAL as value, DESCRIPCION as text FROM requisito_evento WHERE SECUENCIALEVENTO IS NULL OR SECUENCIALEVENTO = 0");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode([
    'modalidades' => cargar('modalidad_evento', 'CODIGO', 'NOMBRE'),
    'tipos'       => cargar('tipo_evento', 'CODIGO', 'NOMBRE'),
    'carreras'    => cargar('carrera', 'SECUENCIAL', 'NOMBRE_CARRERA'),
    'categorias'  => cargar('categoria_evento', 'SECUENCIAL', 'NOMBRE'),
    'estados' => [
    ['value' => 'DISPONIBLE', 'text' => 'Disponible'],
    ['value' => 'EN CURSO', 'text' => 'En curso'],
    ['value' => 'FINALIZADO', 'text' => 'Finalizado'],
    ['value' => 'CERRADO', 'text' => 'Cerrado'],
    ['value' => 'CANCELADO', 'text' => 'Cancelado'],
    ['value' => 'CREADO', 'text' => 'Creado']

    ],
    'requisitos'  => cargarRequisitosGenerales()
]);




