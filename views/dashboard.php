<?php

include_once 'partials/head_Admin.php'; 
// Incluir el archivo de conexión a la base de datos
include_once '../ruta/a/tu/conexion.php'; // **Cambiar ruta a archivo de conexion**

// Función para limpiar y sanitizar datos de entrada (seguridad básica)
function sanitizar_entrada($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Lógica para Crear/Editar Usuario
$accion = 'crear'; // Por defecto, se asume que se va a crear un usuario
$id_usuario = '';
$nombre = '';
$email = '';
$rol_seleccionado = ''; // Para almacenar el rol del usuario a editar

if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $accion = 'editar';
    $id_usuario = sanitizar_entrada($_GET['id']);

    // Obtener datos del usuario para editar
    $stmt = $pdo->prepare("SELECT id, nombre, email, id_rol FROM usuarios WHERE id = ?");
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $nombre = $usuario['nombre'];
        $email = $usuario['email'];
        $rol_seleccionado = $usuario['id_rol'];
    } else {
        // Usuario no encontrado, redirigir o mostrar error
        echo "<p class='alert alert-danger'>Usuario no encontrado.</p>";
        $accion = 'crear'; // Volver a modo crear si no se encuentra
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['guardar_usuario'])) {
        $nombre = sanitizar_entrada($_POST['nombre']);
        $email = sanitizar_entrada($_POST['email']);
        $password = sanitizar_entrada($_POST['password']);
        $id_rol = sanitizar_entrada($_POST['rol']); // Asumiendo un select para roles

        if ($accion == 'crear') {
            // Validaciones básicas (puedes añadir más)
            if (empty($nombre) || empty($email) || empty($password) || empty($id_rol)) {
                $mensaje_error = "Todos los campos son obligatorios.";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mensaje_error = "Formato de email inválido.";
            } else {
                // Hashing de contraseña (¡CRÍTICO!)
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insertar nuevo usuario
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, id_rol) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$nombre, $email, $hashed_password, $id_rol])) {
                    $mensaje_exito = "Usuario creado exitosamente.";
                    // Limpiar campos del formulario
                    $nombre = $email = $password = $id_rol = '';
                } else {
                    $mensaje_error = "Error al crear el usuario.";
                }
            }
        } elseif ($accion == 'editar') {
            // Validaciones básicas (puedes añadir más)
            if (empty($nombre) || empty($email) || empty($id_rol)) { // Contraseña es opcional en edición
                $mensaje_error = "Nombre, email y rol son obligatorios.";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mensaje_error = "Formato de email inválido.";
            } else {
                // Actualizar usuario
                if (!empty($password)) { // Si se proporciona una nueva contraseña
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, password = ?, id_rol = ? WHERE id = ?");
                    $ejecutado = $stmt->execute([$nombre, $email, $hashed_password, $id_rol, $id_usuario]);
                } else { // Si la contraseña no se cambia
                    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, id_rol = ? WHERE id = ?");
                    $ejecutado = $stmt->execute([$nombre, $email, $id_rol, $id_usuario]);
                }

                if ($ejecutado) {
                    $mensaje_exito = "Usuario actualizado exitosamente.";
                    // Recargar datos para mostrar los cambios si se queda en la misma página
                    $stmt = $pdo->prepare("SELECT id, nombre, email, id_rol FROM usuarios WHERE id = ?");
                    $stmt->execute([$id_usuario]);
                    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($usuario) {
                        $nombre = $usuario['nombre'];
                        $email = $usuario['email'];
                        $rol_seleccionado = $usuario['id_rol'];
                    }
                } else {
                    $mensaje_error = "Error al actualizar el usuario.";
                }
            }
        }
    } elseif (isset($_POST['eliminar_usuario'])) {
        $id_usuario_eliminar = sanitizar_entrada($_POST['id_usuario_eliminar']);
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        if ($stmt->execute([$id_usuario_eliminar])) {
            $mensaje_exito = "Usuario eliminado exitosamente.";
        } else {
            $mensaje_error = "Error al eliminar el usuario.";
        }
    }
}
?>

<div id="page-wrapper">
    <div id="page-inner">
        <h2 style="color: red;"><?php echo ($accion == 'crear') ? 'Crear Nuevo Usuario' : 'Editar Usuario'; ?></h2>
        <hr />

        <?php
        // Mostrar mensajes de éxito o error
        if (isset($mensaje_exito)) {
            echo "<div class='alert alert-success'>" . $mensaje_exito . "</div>";
        }
        if (isset($mensaje_error)) {
            echo "<div class='alert alert-danger'>" . $mensaje_error . "</div>";
        }
        ?>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo ($accion == 'crear') ? 'Formulario de Nuevo Usuario' : 'Formulario de Edición de Usuario'; ?>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="">
                            <?php if ($accion == 'editar'): ?>
                                <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><?php echo ($accion == 'crear') ? 'Contraseña:' : 'Nueva Contraseña (dejar en blanco para no cambiar):'; ?></label>
                                <input type="password" class="form-control" id="password" name="password" <?php echo ($accion == 'crear') ? 'required' : ''; ?>>
                            </div>
                            <div class="form-group">
                                <label for="rol">Rol:</label>
                                <select class="form-control" id="rol" name="rol" required>
                                    <option value="">Seleccione un rol</option>
                                    <?php
                                    // Obtener roles de la base de datos
                                    $stmt_roles = $pdo->query("SELECT id_rol, nombre_rol FROM roles ORDER BY nombre_rol");
                                    while ($rol = $stmt_roles->fetch(PDO::FETCH_ASSOC)) {
                                        $selected = ($rol['id_rol'] == $rol_seleccionado) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($rol['id_rol']) . "' " . $selected . ">" . htmlspecialchars($rol['nombre_rol']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="guardar_usuario" class="btn btn-primary">
                                <i class="fa fa-save"></i> <?php echo ($accion == 'crear') ? 'Guardar Usuario' : 'Actualizar Usuario'; ?>
                            </button>
                            <?php if ($accion == 'editar'): ?>
                                <a href="dashboard_User.php" class="btn btn-default"><i class="fa fa-plus"></i> Crear Nuevo</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h2 style="color: red;">Listado de Usuarios</h2>
        <hr />

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Usuarios Registrados
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Lógica de Paginación (ejemplo básico)
                                    $registros_por_pagina = 10;
                                    $pagina_actual = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                                    $offset = ($pagina_actual - 1) * $registros_por_pagina;

                                    // Contar total de usuarios para la paginación
                                    $total_usuarios_stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
                                    $total_usuarios = $total_usuarios_stmt->fetchColumn();
                                    $total_paginas = ceil($total_usuarios / $registros_por_pagina);

                                    // Obtener usuarios con su rol
                                    $stmt = $pdo->prepare("SELECT u.id, u.nombre, u.email, r.nombre_rol 
                                                          FROM usuarios u
                                                          LEFT JOIN roles r ON u.id_rol = r.id_rol
                                                          ORDER BY u.nombre
                                                          LIMIT ?, ?");
                                    $stmt->bindParam(1, $offset, PDO::PARAM_INT);
                                    $stmt->bindParam(2, $registros_por_pagina, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($usuarios) > 0) {
                                        foreach ($usuarios as $usuario) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($usuario['id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($usuario['nombre']) . "</td>";
                                            echo "<td>" . htmlspecialchars($usuario['email']) . "</td>";
                                            echo "<td>" . htmlspecialchars($usuario['nombre_rol']) . "</td>";
                                            echo "<td>";
                                            echo "<a href='dashboard_User.php?action=edit&id=" . htmlspecialchars($usuario['id']) . "' class='btn btn-info btn-xs'><i class='fa fa-edit'></i> Editar</a> ";
                                            echo "<form method='POST' action='' style='display:inline-block;'>";
                                            echo "<input type='hidden' name='id_usuario_eliminar' value='" . htmlspecialchars($usuario['id']) . "'>";
                                            echo "<button type='submit' name='eliminar_usuario' class='btn btn-danger btn-xs' onclick=\"return confirm('¿Estás seguro de que quieres eliminar a este usuario?');\"><i class='fa fa-trash-o'></i> Eliminar</button>";
                                            echo "</form>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                    <li class="<?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                                        <a href="dashboard_User.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include_once 'partials/footer_Admin.php'; // Tu archivo footer_Admin.php
?>