<?php
include("../conexion.php");// Cambiar la URL de conexión del proyecto

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar físico (puedes cambiar a UPDATE si prefieres borrado lógico)
    $sql = "DELETE FROM EVENTO WHERE SECUENCIAL = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: config_eventos.php?deleted=1");
    } else {
        echo "Error al eliminar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID no recibido.";
}
