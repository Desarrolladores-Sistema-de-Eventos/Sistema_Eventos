<?php
include __DIR__ . '/partials/header_Admin.php';
?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2><i class="fa fa-users"></i> Gestión de Usuarios</h2>
            </div>
        </div>
        <hr />
        <!-- Lista de Usuarios -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Listado de Usuarios</h4>
            <div class="card-body">
                <div class="form-row align-items-center mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="🔍 Buscar por nombre / correo / rol">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control">
                            <option value="">⏹️ Filtro por estado</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">➕ REGISTRO NUEVO USUARIO</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre completo</th>
                                <th>Correo institucional</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>001</td>
                                <td>Juan Pérez García</td>
                                <td>juan.perez@uta.edu.ec</td>
                                <td>Estudiante</td>
                                <td>Activo</td>
                                <td class="action-buttons">
                                    <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>002</td>
                                <td>Ana López Torres</td>
                                <td>ana.lopez@uta.edu.ec</td>
                                <td>Promotor</td>
                                <td>Activo</td>
                                <td class="action-buttons">
                                    <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>003</td>
                                <td>David Ramos</td>
                                <td>dramos@uta.edu.ec</td>
                                <td>Administrador</td>
                                <td>Inactivo</td>
                                <td class="action-buttons">
                                    <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </td>
                            </tr>
                            <!-- More user rows can be added here -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Paginación de usuarios">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link" href="#">&larr; Anterior</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Siguiente &rarr;</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Modal para Añadir Usuario -->
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">➕ REGISTRO NUEVO USUARIO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="add_nombre_completo">📛 Nombre completo:</label>
                                <input type="text" class="form-control" id="add_nombre_completo" name="nombre_completo" required>
                            </div>
                            <div class="form-group">
                                <label for="add_correo_institucional">📧 Correo institucional:</label>
                                <input type="email" class="form-control" id="add_correo_institucional" name="correo_institucional" required>
                            </div>
                            <div class="form-group">
                                <label for="add_contrasena">🔒 Contraseña:</label>
                                <input type="password" class="form-control" id="add_contrasena" name="contrasena" required>
                            </div>
                            <div class="form-group">
                                <label for="add_rol">🧑‍🏫 Rol:</label>
                                <select class="form-control" id="add_rol" name="rol" required>
                                    <option value="estudiante">Estudiante</option>
                                    <option value="promotor">Promotor</option>
                                    <option value="administrador">Administrador</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add_telefono">📱 Teléfono (opcional):</label>
                                <input type="text" class="form-control" id="add_telefono" name="telefono">
                            </div>
                            <div class="form-group">
                                <label for="add_carrera">🏫 Carrera (si aplica):</label>
                                <input type="text" class="form-control" id="add_carrera" name="carrera">
                            </div>
                            <div class="form-group">
                                <label for="add_estado">🟢 Estado:</label>
                                <select class="form-control" id="add_estado" name="estado" required>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">💾 Guardar usuario</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">❌ Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Editar Usuario -->
        <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">✏️ EDITAR USUARIO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="edit_nombre_completo">📛 Nombre completo:</label>
                                <input type="text" class="form-control" id="edit_nombre_completo" name="nombre_completo" value="Juan Pérez García" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_correo_institucional">📧 Correo institucional:</label>
                                <input type="email" class="form-control" id="edit_correo_institucional" name="correo_institucional" value="juan.perez@uta.edu.ec" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_contrasena">🔒 Cambiar contraseña (opcional):</label>
                                <input type="password" class="form-control" id="edit_contrasena" name="nueva_contrasena">
                            </div>
                            <div class="form-group">
                                <label for="edit_rol">🧑‍🏫 Rol:</label>
                                <select class="form-control" id="edit_rol" name="rol" required>
                                    <option value="estudiante">Estudiante</option>
                                    <option value="promotor">Promotor</option>
                                    <option value="administrador">Administrador</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_estado">🟢 Estado:</label>
                                <select class="form-control" id="edit_estado" name="estado" required>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">💾 Actualizar datos</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">🔙 Volver</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">¿Está seguro que desea eliminar a <strong id="userNameToDelete"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
        $(document).ready(function() {
            // Manejar clic en el botón Editar
            // La lógica para el botón "Editar" se mantiene
 $(document).on('click', '.btn-warning', function() {
                // Datos de marcador de posición - En una aplicación real, obtendrías estos datos
                // de tu backend basado en el ID de usuario asociado a la fila.
                var userName = $(this).closest('tr').find('td:nth-child(2)').text();
                var userEmail = $(this).closest('tr').find('td:nth-child(3)').text();
                var userRole = $(this).closest('tr').find('td:nth-child(4)').text();
                var userStatus = $(this).closest('tr').find('td:nth-child(5)').text();
 var userId = $(this).closest('tr').find('td:nth-child(1)').text(); // Asumiendo que la primera columna es el ID

                $('#edit_nombre_completo').val(userName);
                $('#edit_correo_institucional').val(userEmail);
                $('#edit_rol').val(userRole.toLowerCase()); // Set dropdown value
                $('#edit_estado').val(userStatus.toLowerCase()); // Set dropdown value

                // Limpiar el campo de contraseña al abrir el modal de edición
                $('#edit_contrasena').val('');
            });

            // Manejar clic en el botón Ver
            $(document).on('click', '.btn-info', function() {
                // Obtener datos de la fila del usuario
                var userId = $(this).closest('tr').find('td:nth-child(1)').text();
                var userName = $(this).closest('tr').find('td:nth-child(2)').text();
                var userEmail = $(this).closest('tr').find('td:nth-child(3)').text();
                var userRole = $(this).closest('tr').find('td:nth-child(4)').text();
                var userStatus = $(this).closest('tr').find('td:nth-child(5)').text();

                // Mostrar la información en una alerta
                alert('Detalles del Usuario:\n' +
                      'ID: ' + userId + '\n' +
                      'Nombre: ' + userName + '\n' +
                      'Correo: ' + userEmail + '\n' +
                      'Rol: ' + userRole + '\n' + // Corregido para usar userRole
                      'Estado: ' + userStatus);
            });

            // Manejar clic en el botón Eliminar
            $('.btn-danger').click(function() {
                // Obtener datos de la fila del usuario
                var userId = $(this).closest('tr').find('td:nth-child(1)').text(); // Asumiendo que la primera columna es el ID
                var userName = $(this).closest('tr').find('td:nth-child(2)').text();

                // Actualizar el modal con el nombre del usuario
                $('#userNameToDelete').text(userName);

                // Almacenar el ID del usuario en un atributo de datos del botón de confirmación
                $('#confirmDeleteButton').data('userId', userId);

                // Mostrar el modal de confirmación
                $('#deleteConfirmModal').modal('show');
            });

            // Manejar clic en el botón Eliminar dentro del modal de confirmación
            $('#confirmDeleteButton').click(function() {
                var userId = $(this).data('userId'); // Obtener el ID del usuario almacenado
                console.log('Se intentaría eliminar al usuario con ID: ' + userId);
                $('#deleteConfirmModal').modal('hide'); // Cerrar el modal
            });

            // Opcional: Limpiar el formulario de añadir usuario cuando se cierra el modal
            $('#addUserModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

            // Optional: Clear edit user form password field when the modal is closed
             $('#editUserModal').on('hidden.bs.modal', function () {
                $('#edit_contrasena').val('');
            });
        }); // Cierre de $(document).ready
</script>
<?php
include __DIR__ . '/partials/footer_Admin.php';
?>
