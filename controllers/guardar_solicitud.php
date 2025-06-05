<?php
require_once("../core/Conexion.php"); // Ajusta la ruta si es necesario

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión PDO
$conn = Conexion::getConexion();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Simulación de usuario (ajusta cuando conectes con login)
  $SECUENCIAL_USUARIO = 11;

  // Datos del formulario
  $MODULO_AFECTADO   = $_POST['MODULO_AFECTADO'] ?? '';
  $TIPO_SOLICITUD    = $_POST['TIPO_SOLICITUD'] ?? '';
  $DESCRIPCION       = $_POST['DESCRIPCION'] ?? '';
  $JUSTIFICACION     = $_POST['JUSTIFICACION'] ?? '';
  $URGENCIA          = $_POST['URGENCIA'] ?? '';
  $ARCHIVO_EVIDENCIA = null;

  // Validación mínima
  if (
    empty($MODULO_AFECTADO) || empty($TIPO_SOLICITUD) || empty($DESCRIPCION) ||
    empty($JUSTIFICACION) || empty($URGENCIA)
  ) {
    http_response_code(400);
    echo "Faltan campos obligatorios.";
    exit;
  }

  // Procesar archivo (opcional)
  if (
    isset($_FILES['ARCHIVO_EVIDENCIA']) &&
    $_FILES['ARCHIVO_EVIDENCIA']['error'] === 0
  ) {
    $archivo = $_FILES['ARCHIVO_EVIDENCIA'];
    $permitidos = ['image/jpeg', 'image/png', 'application/pdf'];
    $maxSize = 2 * 1024 * 1024;

    if (!in_array($archivo['type'], $permitidos)) {
      http_response_code(415);
      echo "Tipo de archivo no permitido.";
      exit;
    }

    if ($archivo['size'] > $maxSize) {
      http_response_code(413);
      echo "Archivo muy grande (máx 2MB).";
      exit;
    }

    $nombreUnico = time() . "_" . basename($archivo['name']);
    $destino = "../uploads/" . $nombreUnico;

    if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
      http_response_code(500);
      echo "Error al guardar el archivo.";
      exit;
    }

    $ARCHIVO_EVIDENCIA = $destino;
  }

  // Insertar en la base
  try {
    $sql = "INSERT INTO solicitud_cambio (
      SECUENCIAL_USUARIO,
      MODULO_AFECTADO,
      TIPO_SOLICITUD,
      DESCRIPCION,
      JUSTIFICACION,
      URGENCIA,
      ARCHIVO_EVIDENCIA
    ) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
      $SECUENCIAL_USUARIO,
      $MODULO_AFECTADO,
      $TIPO_SOLICITUD,
      $DESCRIPCION,
      $JUSTIFICACION,
      $URGENCIA,
      $ARCHIVO_EVIDENCIA
    ]);

    http_response_code(200);
    echo "✅ Solicitud guardada correctamente.";
  } catch (PDOException $e) {
    http_response_code(500);
    echo "❌ Error al guardar: " . $e->getMessage();
  }
} else {
  http_response_code(405);
  echo "Método no permitido.";
}
