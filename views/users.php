<?php
// users.php (o dashboard_User.php) - Versión solo Front-end

include_once 'partials/head_Admin.php';

// Variables para simular datos de formulario o mensajes (solo para visualización)
$accion = 'crear'; // Puede ser 'crear' o 'editar'
$nombre_ejemplo = '';
$email_ejemplo = '';
$rol_seleccionado_ejemplo = '';
$mensaje_ejemplo = '';

// Simulación de envío de formulario para cambiar entre vistas de "crear" y "editar"
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $accion = 'editar';
    // Simular carga de datos para editar (estático)
    $id_usuario_ejemplo = htmlspecialchars($_GET['id']);
    $nombre_ejemplo = "Usuario Editado " . $id_usuario_ejemplo;
    $email_ejemplo = "usuario" . $id_usuario_ejemplo . "@ejemplo.com";
    $rol_seleccionado_ejemplo = 2; // Simular rol "Editor"
    $mensaje_ejemplo = "<div class='alert alert-info'>Modo edición: Editando usuario con ID: " . $id_usuario_ejemplo . ".</div>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['guardar_usuario'])) {
        // Simular que se han guardado los datos
        $nombre_ejemplo = htmlspecialchars($_POST['nombre'] ?? '');
        $email_ejemplo = htmlspecialchars($_POST['email'] ?? '');
        $rol_seleccionado_ejemplo = htmlspecialchars($_POST['rol'] ?? '');

        if ($accion == 'crear') {
            $mensaje_ejemplo = "<div class='alert alert-success'>Simulación: Usuario '" . $nombre_ejemplo . "' creado visualmente.</div>";
            // Limpiar campos para simular nuevo formulario
            $nombre_ejemplo = $email_ejemplo = $rol_seleccionado_ejemplo = '';
        } elseif ($accion == 'editar') {
            $id_usuario_ejemplo = htmlspecialchars($_POST['id_usuario'] ?? 'N/A');
            $mensaje_ejemplo = "<div class='alert alert-success'>Simulación: Usuario con ID " . $id_usuario_ejemplo . " actualizado visualmente.</div>";
            // No limpiar campos en edición para mostrar lo que se 'actualizó'
        }
        $accion = 'crear'; // Volver a modo crear después de 'guardar'
    } elseif (isset($_POST['eliminar_usuario'])) {
        $id_usuario_eliminar_ejemplo = htmlspecialchars($_POST['id_usuario_eliminar'] ?? 'N/A');
        $mensaje_ejemplo = "<div class='alert alert-warning'>Simulación: Usuario con ID " . $id_usuario_eliminar_ejemplo . " eliminado visualmente.</div>";
    }
}

// Estilos para el scrollbar en el contenido principal y sidebar fijo
?>
<style>
    body {
        overflow-y: hidden; /* Evita el scrollbar global si el sidebar es parte de body */
    }

    #wrapper {
        display: flex; /* Para que el sidebar y page-wrapper estén uno al lado del otro */
        height: 100vh; /* Altura total de la ventana */
    }

    /* Asumiendo que tu sidebar tiene un ID o clase que lo hace fijo */
    /* Ejemplo si tu sidebar es directamente parte de #wrapper y tiene ID #side-menu */
    #side-menu { /* O la clase de tu sidebar */
        position: fixed; /* Fija el sidebar */
        top: 0; /* Lo alinea arriba */
        left: 0; /* Lo alinea a la izquierda */
        bottom: 0; /* Ocupa toda la altura */
        /* width: 250px;  Ajusta el ancho de tu sidebar según tu diseño */
        overflow-y: auto; /* Agrega scrollbar si el contenido del sidebar es largo */
        z-index: 1000; /* Asegura que esté por encima de otros elementos si es necesario */
        /* background-color: #222;  Color de fondo de tu sidebar */
        /* padding-top: 50px;  Ajusta si tienes una barra superior */
    }

    #page-wrapper {
        margin-left: 250px; /* Ajusta este margen para que el contenido no quede debajo del sidebar */
        flex-grow: 1; /* Permite que ocupe el espacio restante */
        overflow-y: auto; /* Agrega scrollbar al contenido principal */
        height: 100vh; /* Asegura que el page-wrapper tenga la altura completa para el scroll */
        padding-top: 15px; /* Pequeño padding superior para el contenido */
        padding-bottom: 15px; /* Pequeño padding inferior para el contenido */
    }

    /* Si tu head_Admin.php ya crea la estructura básica como wrapper,
       puede que necesites ajustar los selectores CSS */
</style>

<div id="wrapper">
    <?php
    // Incluir el sidebar, si está en un archivo separado
    // Si tu sidebar está directamente en head_Admin.php, no necesitas esto.
    // include_once 'partials/sidebar_Admin.php';
    ?>

    <div id="page-wrapper">
        <div id="page-inner">
            <h2 style="color: red;"><?php echo ($accion == 'crear') ? 'Gestión de Usuarios - Crear Nuevo' : 'Gestión de Usuarios - Editar'; ?></h2>
            <hr />

            <?php
            // Mostrar mensajes de simulación
            if (!empty($mensaje_ejemplo)) {
                echo $mensaje_ejemplo;
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
                                    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario_ejemplo); ?>">
                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre_ejemplo); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email_ejemplo); ?>" required>
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
                                        // Roles de ejemplo (estáticos)
                                        $roles_ejemplo = [
                                            1 => 'Administrador',
                                            2 => 'Editor',
                                            3 => 'Usuario'
                                        ];
                                        foreach ($roles_ejemplo as $id_rol => $nombre_rol) {
                                            $selected = ($id_rol == $rol_seleccionado_ejemplo) ? 'selected' : '';
                                            echo "<option value='" . htmlspecialchars($id_rol) . "' " . $selected . ">" . htmlspecialchars($nombre_rol) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="guardar_usuario" class="btn btn-primary">
                                    <i class="fa fa-save"></i> <?php echo ($accion == 'crear') ? 'Guardar Usuario' : 'Actualizar Usuario'; ?> (Simulado)
                                </button>
                                <?php if ($accion == 'editar'): ?>
                                    <a href="users.php" class="btn btn-default"><i class="fa fa-plus"></i> Crear Nuevo (Volver)</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <h2 style="color: red;">Listado de Usuarios (Simulado)</h2>
            <hr />

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Usuarios Registrados (Datos de Ejemplo)
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
                                        // Datos de usuarios de ejemplo (estáticos)
                                        $usuarios_ejemplo = [
                                            ['id' => 1, 'nombre' => 'Juan Pérez', 'email' => 'juan.perez@example.com', 'rol' => 'Administrador'],
                                            ['id' => 2, 'nombre' => 'María García', 'email' => 'maria.garcia@example.com', 'rol' => 'Editor'],
                                            ['id' => 3, 'nombre' => 'Carlos López', 'email' => 'carlos.lopez@example.com', 'rol' => 'Usuario'],
                                            ['id' => 4, 'nombre' => 'Ana Martínez', 'email' => 'ana.martinez@example.com', 'rol' => 'Usuario'],
                                            ['id' => 5, 'nombre' => 'Pedro Sánchez', 'email' => 'pedro.sanchez@example.com', 'rol' => 'Editor'],
                                            ['id' => 6, 'nombre' => 'Laura Rodríguez', 'email' => 'laura.rodriguez@example.com', 'rol' => 'Usuario'],
                                            ['id' => 7, 'nombre' => 'Manuel Díaz', 'email' => 'manuel.diaz@example.com', 'rol' => 'Administrador'],
                                            ['id' => 8, 'nombre' => 'Sofía Fernández', 'email' => 'sofia.fernandez@example.com', 'rol' => 'Usuario'],
                                            ['id' => 9, 'nombre' => 'Jorge González', 'email' => 'jorge.gonzalez@example.com', 'rol' => 'Editor'],
                                            ['id' => 10, 'nombre' => 'Isabel Ruíz', 'email' => 'isabel.ruiz@example.com', 'rol' => 'Usuario'],
                                            ['id' => 11, 'nombre' => 'Ricardo Pérez', 'email' => 'ricardo.perez@example.com', 'rol' => 'Usuario'],
                                            ['id' => 12, 'nombre' => 'Elena Soto', 'email' => 'elena.soto@example.com', 'rol' => 'Usuario'],
                                            ['id' => 13, 'nombre' => 'Andrés Gómez', 'email' => 'andres.gomez@example.com', 'rol' => 'Editor'],
                                            ['id' => 14, 'nombre' => 'Carmen Herrera', 'email' => 'carmen.herrera@example.com', 'rol' => 'Administrador'],
                                            ['id' => 15, 'nombre' => 'Miguel Torres', 'email' => 'miguel.torres@example.com', 'rol' => 'Usuario'],
                                        ];

                                        // Simulación de paginación
                                        $registros_por_pagina_sim = 10;
                                        $pagina_actual_sim = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $offset_sim = ($pagina_actual_sim - 1) * $registros_por_pagina_sim;
                                        $total_usuarios_sim = count($usuarios_ejemplo);
                                        $total_paginas_sim = ceil($total_usuarios_sim / $registros_por_pagina_sim);

                                        $usuarios_mostrados = array_slice($usuarios_ejemplo, $offset_sim, $registros_por_pagina_sim);

                                        if (count($usuarios_mostrados) > 0) {
                                            foreach ($usuarios_mostrados as $usuario) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($usuario['id']) . "</td>";
                                                echo "<td>" . htmlspecialchars($usuario['nombre']) . "</td>";
                                                echo "<td>" . htmlspecialchars($usuario['email']) . "</td>";
                                                echo "<td>" . htmlspecialchars($usuario['rol']) . "</td>";
                                                echo "<td>";
                                                echo "<a href='users.php?action=edit&id=" . htmlspecialchars($usuario['id']) . "' class='btn btn-info btn-xs'><i class='fa fa-edit'></i> Editar (Simulado)</a> ";
                                                echo "<form method='POST' action='' style='display:inline-block;'>";
                                                echo "<input type='hidden' name='id_usuario_eliminar' value='" . htmlspecialchars($usuario['id']) . "'>";
                                                echo "<button type='submit' name='eliminar_usuario' class='btn btn-danger btn-xs' onclick=\"return confirm('¿Estás seguro de que quieres eliminar a este usuario? (Simulado)');\"><i class='fa fa-trash-o'></i> Eliminar (Simulado)</button>";
                                                echo "</form>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>No hay usuarios registrados (ejemplo).</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $total_paginas_sim; $i++): ?>
                                        <li class="<?php echo ($i == $pagina_actual_sim) ? 'active' : ''; ?>">
                                            <a href="users.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
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
</div>

<?php
include_once 'partials/footer_Admin.php'; // Tu archivo footer_Admin.php
?>