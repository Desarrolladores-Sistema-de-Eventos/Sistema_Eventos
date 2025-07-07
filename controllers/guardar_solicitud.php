<?php

require '../core/Conexion.php';

// Permitir acceso sin sesión iniciada
$usuario_id = $_SESSION['usuario']['SECUENCIAL_USUARIO'] ?? null;

// Captura de datos del formulario
$modulo = trim($_POST['MODULO_AFECTADO']);
$tipo = $_POST['TIPO_SOLICITUD'];
$descripcion = trim($_POST['DESCRIPCION']);
$justificacion = trim($_POST['JUSTIFICACION']);
$urgencia = $_POST['URGENCIA'];
$archivoNombre = null;

// Procesar archivo si se adjunta
if (isset($_FILES['ARCHIVO_EVIDENCIA']) && $_FILES['ARCHIVO_EVIDENCIA']['error'] === UPLOAD_ERR_OK) {
    $carpetaDestino = "../documents/evidencias/";
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    $extension = pathinfo($_FILES['ARCHIVO_EVIDENCIA']['name'], PATHINFO_EXTENSION);
    $archivoNombre = "evidencia_" . uniqid() . "." . $extension;
    $rutaArchivo = $carpetaDestino . $archivoNombre;

    if (!move_uploaded_file($_FILES['ARCHIVO_EVIDENCIA']['tmp_name'], $rutaArchivo)) {
        http_response_code(500);
        echo json_encode(['error' => 'No se pudo guardar el archivo.']);
        exit;
    }
}

try {
    $conexion = Conexion::getConexion();

    $sql = "
        INSERT INTO solicitud_cambio 
        (SECUENCIAL_USUARIO, MODULO_AFECTADO, TIPO_SOLICITUD, DESCRIPCION, JUSTIFICACION, URGENCIA, ARCHIVO_EVIDENCIA)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        $usuario_id,
        $modulo,
        $tipo,
        $descripcion,
        $justificacion,
        $urgencia,
        $archivoNombre
    ]);

    echo json_encode(['success' => true]);
} catch (Throwable $e) {
    http_response_code(500);
    echo "<pre><strong>Error interno:</strong>\n" . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
}
?>
