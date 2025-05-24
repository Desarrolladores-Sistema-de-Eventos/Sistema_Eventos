<?php include("../partials/head_Admin.php"); ?>
<?php include("../conexion.php"); ?>

<div id="page-wrapper">
    <div id="page-inner">
        <h2 style="color: red;">Configuración de Usuarios</h2>
        <h5>Administrar roles y estado de usuarios registrados</h5>
        <hr />

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT u.SECUENCIAL, u.NOMBRE_COMPLETO, u.CORREO, u.CODIGOESTADO,
                               r.NOMBRE AS ROL
                        FROM USUARIO u
                        JOIN ROL_USUARIO r ON u.CODIGOROL = r.CODIGO";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $estado = $row['CODIGOESTADO'] == 1 ? 'Activo' : 'Inactivo';
                    $btnColor = $row['CODIGOESTADO'] == 1 ? 'btn-danger' : 'btn-success';
                    $accionTexto = $row['CODIGOESTADO'] == 1 ? 'Desactivar' : 'Activar';

                    echo "<tr>
                        <td>{$row['NOMBRE_COMPLETO']}</td>
                        <td>{$row['CORREO']}</td>
                        <td>{$row['ROL']}</td>
                        <td>{$estado}</td>
                        <td>
                            <a href='editar_usuario.php?id={$row['SECUENCIAL']}' class='btn btn-warning btn-sm'>Editar Rol</a>
                            <a href='cambiar_estado.php?id={$row['SECUENCIAL']}&estado={$row['CODIGOESTADO']}' class='btn $btnColor btn-sm'>
                                {$accionTexto}
                            </a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("../partials/footer_Admin.php"); ?>
