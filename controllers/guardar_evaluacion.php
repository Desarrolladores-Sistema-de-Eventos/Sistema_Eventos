<?php
require_once("../core/Conexion.php"); // Ruta de tu clase de conexión

ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = Conexion::getConexion();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Obtener los datos del formulario
  $SECUENCIAL_CAMBIO    = $_POST["SECUENCIAL_CAMBIO"] ?? null;
  $TIPO_ITIL            = $_POST["TIPO_ITIL"] ?? '';
  $PRIORIDAD            = $_POST["PRIORIDAD"] ?? '';
  $CATEGORIA_TECNICA    = $_POST["CATEGORIA_TECNICA"] ?? '';
  $EVALUACION           = $_POST["EVALUACION"] ?? '';
  $BENEFICIOS           = $_POST["BENEFICIOS"] ?? '';
  $IMPACTO_NEGATIVO     = $_POST["IMPACTO_NEGATIVO"] ?? '';
  $ACCIONES             = $_POST["ACCIONES"] ?? '';
  $DECISION             = $_POST["DECISION"] ?? '';
  $OBSERVACIONES        = $_POST["OBSERVACIONES"] ?? '';
  $RESPONSABLE_TECNICO  = $_POST["RESPONSABLE_TECNICO"] ?? '';
  $FECHA_DECISION       = $_POST["FECHA_DECISION"] ?? '';

  // Validación básica
  if (
    empty($SECUENCIAL_CAMBIO) || empty($TIPO_ITIL) || empty($PRIORIDAD) ||
    empty($CATEGORIA_TECNICA) || empty($EVALUACION) || empty($BENEFICIOS) ||
    empty($DECISION) || empty($RESPONSABLE_TECNICO) || empty($FECHA_DECISION)
  ) {
    http_response_code(400);
    echo "Faltan campos requeridos.";
    exit;
  }

  try {
    // Insertar la evaluación técnica
    $sql = "INSERT INTO recepcion_cambio (
      SECUENCIAL_CAMBIO,
      TIPO_ITIL,
      PRIORIDAD,
      CATEGORIA_TECNICA,
      EVALUACION,
      BENEFICIOS,
      IMPACTO_NEGATIVO,
      ACCIONES,
      DECISION,
      OBSERVACIONES,
      RESPONSABLE_TECNICO,
      FECHA_DECISION
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
      $SECUENCIAL_CAMBIO,
      $TIPO_ITIL,
      $PRIORIDAD,
      $CATEGORIA_TECNICA,
      $EVALUACION,
      $BENEFICIOS,
      $IMPACTO_NEGATIVO,
      $ACCIONES,
      $DECISION,
      $OBSERVACIONES,
      $RESPONSABLE_TECNICO,
      $FECHA_DECISION
    ]);

    // Actualizar el estado en la tabla solicitud_cambio
    $update = $conn->prepare("UPDATE solicitud_cambio SET ESTADO = ? WHERE SECUENCIAL = ?");
    $update->execute([$DECISION, $SECUENCIAL_CAMBIO]);

    http_response_code(200);
    echo " Evaluación técnica registrada correctamente.";
  } catch (PDOException $e) {
    http_response_code(500);
    echo " Error al guardar la evaluación: " . $e->getMessage();
  }
} else {
  http_response_code(405);
  echo "Método no permitido.";
}
