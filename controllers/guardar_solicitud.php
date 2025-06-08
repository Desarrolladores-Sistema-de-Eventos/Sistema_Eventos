<?php
session_start();
require '../core/Conexion.php';

// Verifica que la sesión esté activa y definida
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => '⚠ Sesión no iniciada. Usuario no autenticado.']);
    exit;
}

// ID del usuario logeado
$usuario_id = $_SESSION['usuario_id'];

// Captura de datos del formulario
$modulo = trim($_POST['MODULO_AFECTADO']);
$tipo = $_POST['TIPO_SOLICITUD'];
$descripcion = trim($_POST['DESCRIPCION']);
$justificacion = trim($_POST['JUSTIFICACION']);
$urgencia = $_POST['URGENCIA'];
$archivoNombre = null;

// Procesar archivo si se adjunta
if (isset($_FILES['ARCHIVO_EVIDENCIA']) && $_FILES['ARCHIVO_EVIDENCIA']['error'] === UPLOAD_ERR_OK) {
    $carpetaDestino = "../evidencias/";
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
