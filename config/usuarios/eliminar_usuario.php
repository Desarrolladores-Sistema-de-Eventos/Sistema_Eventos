<?php
include("../conexion.php"); // Cambiar la URL de conexión del proyecto

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cambiar el estado a INACTIVO (borrado lógico)
    $sql = "UPDATE USUARIO SET CODIGOESTADO = 'INACTIVO' WHERE SECUENCIAL = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: config_Usuarios.php?eliminado=1");
        exit();
    } else {
        echo "Error al inactivar usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID de usuario no recibido.";
}
