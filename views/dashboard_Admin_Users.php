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
                                <th>SECUENCIAL</th>
                                <th>NOMBRE_COMPLETO</th>
                                <th>CORREO</th>
                                <th>CODIGOROL</th>
                                <th>CODIGOESTADO</th>
                                <th>ES_INTERNO</th>
                                <th>FOTO_PERFIL</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>001</td>
                                <td>Juan Pérez García</td>
                                <td>juan@ejemplo.com</td>
                                <td>ESTUDIANTE</td>
                                <td>ACTIVO</td>
                                <td>1</td>
                                <td>foto_juan.jpg</td>
                                <td class="action-buttons">
                                    <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>002</td>
                                <td>Ana López Torres</td>
                                <td>ana@ejemplo.com</td>
                                <td>ADMIN</td>
                                <td>ACTIVO</td>
                                <td>1</td>
                                <td>foto_ana.jpg</td>
                                <td class="action-buttons">
                                    <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>003</td>
                                <td>David Ramos</td>
                                <td>carlos@ejemplo.com</td>
                                <td>Administrador</td>
                                <td>Inactivo</td>
                                <td>1</td>
                                <td>foto_david.jpg</td>
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
                                <label for="NOMBRE_COMPLETO">📛 Nombre completo:</label>
                                <input type="text" class="form-control" id="NOMBRE_COMPLETO" name="NOMBRE_COMPLETO" required>
                            </div>
                            <div class="form-group">
                                <label for="CORREO">📧 Correo institucional:</label>
                                <input type="email" class="form-control" id="CORREO" name="CORREO" required>
                            </div>
                            <div class="form-group">
                                <label for="CONTRASENA">🔒 Contraseña:</label>
                                <input type="password" class="form-control" id="CONTRASENA" name="CONTRASENA" required>
                            </div>
                            <div class="form-group">
                                <label for="CODIGOROL">🧑‍🏫 Rol:</label>
                                <select class="form-control" id="CODIGOROL" name="CODIGOROL" required>
                                    <option value="ESTUDIANTE">Estudiante</option>
                                    <option value="DOCENTE">Docente</option>
                                    <option value="ADMIN">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="TELEFONO">📱 Teléfono:</label>
                                <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" required>
                            </div>
                            <div class="form-group">
                                <label for="DIRECCION">🏠 Dirección:</label>
                                <input type="text" class="form-control" id="DIRECCION" name="DIRECCION">
                            </div>
                            <div class="form-group">
                                <label for="ES_INTERNO">🏢 Es Interno:</label>
                                <select class="form-control" id="ES_INTERNO" name="ES_INTERNO" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                             <div class="form-group">
                                <label for="FOTO_PERFIL">🖼️ Foto de Perfil:</label>
                                <input type="file" class="form-control-file" id="FOTO_PERFIL" name="FOTO_PERFIL">

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
                                <label for="edit_NOMBRE_COMPLETO">📛 Nombre completo:</label>
                                <input type="text" class="form-control" id="edit_NOMBRE_COMPLETO" name="NOMBRE_COMPLETO" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_CORREO">📧 Correo institucional:</label>
                                <input type="email" class="form-control" id="edit_CORREO" name="CORREO" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_CONTRASENA">🔒 Cambiar contraseña (opcional):</label>
                                <input type="password" class="form-control" id="edit_CONTRASENA" name="CONTRASENA">
                            </div>
                            <div class="form-group">
                                <label for="edit_CODIGOROL">🧑‍🏫 Rol:</label>
                                <select class="form-control" id="edit_CODIGOROL" name="CODIGOROL" required>
                                     <option value="ESTUDIANTE">Estudiante</option>
                                    <option value="DOCENTE">Docente</option>
                                    <option value="ADMIN">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_estado">🟢 Estado:</label>
                                <select class="form-control" id="edit_estado" name="estado" required>
                                    <option value="ACTIVO">Activo</option>
                                    <option value="INACTIVO">Inactivo</option>
                                    <option value="BLOQUEADO">Bloqueado</option>
                                </select>
                            </div>
                             <div class="form-group">
                                <label for="edit_TELEFONO">📱 Teléfono:</label>
                                <input type="text" class="form-control" id="edit_TELEFONO" name="TELEFONO" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_DIRECCION">🏠 Dirección:</label>
                                <input type="text" class="form-control" id="edit_DIRECCION" name="DIRECCION">
                            </div>
                            <div class="form-group">
                                <label for="edit_ES_INTERNO">🏢 Es Interno:</label>
                                <select class="form-control" id="edit_ES_INTERNO" name="ES_INTERNO" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
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
                var userId = $(this).closest('tr').find('td:nth-child(1)').text();
                var userNombreCompleto = $(this).closest('tr').find('td:nth-child(2)').text();
                var userCorreo = $(this).closest('tr').find('td:nth-child(3)').text();
                var userRole = $(this).closest('tr').find('td:nth-child(4)').text();
                var userStatus = $(this).closest('tr').find('td:nth-child(5)').text();
                var userTelefono = $(this).closest('tr').find('td:nth-child(6)').text();
                var userDireccion = $(this).closest('tr').find('td:nth-child(7)').text();
                var userEsInterno = $(this).closest('tr').find('td:nth-child(8)').text();


                $('#edit_NOMBRE_COMPLETO').val(userNombreCompleto);
                $('#edit_CORREO').val(userCorreo);
                $('#edit_CODIGOROL').val(userRole); // Set dropdown value
                $('#edit_estado').val(userStatus); // Set dropdown value
                $('#edit_TELEFONO').val(userTelefono);
                $('#edit_DIRECCION').val(userDireccion);
                $('#edit_ES_INTERNO').val(userEsInterno);
                // Limpiar el campo de contraseña al abrir el modal de edición
                $('#edit_contrasena').val('');
            });

            // Manejar clic en el botón Ver
            $(document).on('click', '.btn-info', function() {
                // Obtener datos de la fila del usuario
                var userId = $(this).closest('tr').find('td:nth-child(1)').text();
                var userNombreCompleto = $(this).closest('tr').find('td:nth-child(2)').text();
                var userCorreo = $(this).closest('tr').find('td:nth-child(3)').text();
                var userRole = $(this).closest('tr').find('td:nth-child(4)').text();
                var userStatus = $(this).closest('tr').find('td:nth-child(5)').text();
                var userTelefono = $(this).closest('tr').find('td:nth-child(6)').text();
                var userDireccion = $(this).closest('tr').find('td:nth-child(7)').text();
                var userEsInterno = $(this).closest('tr').find('td:nth-child(8)').text();
                var userFotoPerfil = $(this).closest('tr').find('td:nth-child(9)').text();

                // Mostrar la información en una alerta
                alert('Detalles del Usuario:\n' +
                      'ID: ' + userId + '\n' +
                      'Nombre Completo: ' + userNombreCompleto + '\n' +
                      'Correo: ' + userCorreo + '\n' +
                      'Rol: ' + userRole + '\n' +
                      'Estado: ' + userStatus + '\n' +
                      'Telefono: ' + userTelefono + '\n' +
                      'Es Interno: ' + userEsInterno);
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
                console.log('Attempting to delete user with ID: ' + userId);
                $('#deleteConfirmModal').modal('hide'); // Cerrar el modal
            });

            // Opcional: Limpiar el formulario de añadir usuario cuando se cierra el modal
            $('#addUserModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

            // Optional: Clear edit user form password field when the modal is closed
             $('#editUserModal').on('hidden.bs.modal', function () {
                $('#edit_CONTRASENA').val('');
            });
        }); // Cierre de $(document).ready
</script>
<?php
include __DIR__ . '/partials/footer_Admin.php';
?>
