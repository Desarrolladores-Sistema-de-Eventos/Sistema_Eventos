<?php
include("../conexion.php");// Cambiar la URL de conexión del proyecto

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $estadoActual = $_GET['estado'];

    // Cambiar estado: si está activo (1) → desactivar (0), y viceversa
    $nuevoEstado = $estadoActual == 1 ? 0 : 1;

    $sql = "UPDATE USUARIO SET CODIGOESTADO = ? WHERE SECUENCIAL = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $nuevoEstado, $id);

    if ($stmt->execute()) {
        header("Location: config_Usuarios.php?estado_actualizado=1");
        exit();
    } else {
        echo "Error al actualizar estado: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Parámetros incompletos.";
}
