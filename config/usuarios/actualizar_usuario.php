<?php
include("../conexion.php"); // Cambiar la URL de conexión del proyecto

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['SECUENCIAL'];
    $nuevoRol = $_POST['CODIGOROL'];

    if (!empty($id) && !empty($nuevoRol)) {
        $sql = "UPDATE USUARIO SET CODIGOROL = ? WHERE SECUENCIAL = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $nuevoRol, $id);

        if ($stmt->execute()) {
            header("Location: config_Usuarios.php?rol_actualizado=1");
            exit();
        } else {
            echo "Error al actualizar el rol: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Datos incompletos.";
    }

    $conn->close();
} else {
    echo "Acceso denegado.";
}
