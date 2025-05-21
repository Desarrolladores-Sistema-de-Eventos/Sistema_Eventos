<?php include("../partials/head_Admin.php"); ?>
<?php include("../conexion.php"); ?> // Cambiar la URL de conexión del proyecto

<?php
if (!isset($_GET['id'])) {
    echo "ID de usuario no especificado.";
    exit;
}

$id = $_GET['id'];

// Obtener datos del usuario
$sql = "SELECT * FROM USUARIO WHERE SECUENCIAL = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}
?>

<div id="page-wrapper">
    <div id="page-inner">
        <h2 style="color: red;">Editar Rol del Usuario</h2>
        <hr />

        <form method="POST" action="actualizar_usuario.php">
            <input type="hidden" name="SECUENCIAL" value="<?= $usuario['SECUENCIAL'] ?>">

            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" class="form-control" value="<?= $usuario['NOMBRE_COMPLETO'] ?>" disabled>
            </div>

            <div class="form-group">
                <label>Correo:</label>
                <input type="text" class="form-control" value="<?= $usuario['CORREO'] ?>" disabled>
            </div>

            <div class="form-group">
                <label>Rol:</label>
                <select name="CODIGOROL" class="form-control">
                    <?php
                    $roles = $conn->query("SELECT * FROM ROL_USUARIO");
                    while ($rol = $roles->fetch_assoc()) {
                        $selected = ($rol['CODIGO'] == $usuario['CODIGOROL']) ? 'selected' : '';
                        echo "<option value='{$rol['CODIGO']}' $selected>{$rol['NOMBRE']}</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Guardar Cambios
            </button>
            <a href="config_Usuarios.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../partials/footer_Admin.php"); ?>
