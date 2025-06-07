<?php include("partials/header_Admin.php");?>
<?php 
$rolRequerido = 'ADMIN';
include("../core/auth.php")?>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
        <div class="col-md-12">
        <h2><i class="fa fa-users"></i> Gestión de Usuarios</h2>
        </div>
    </div> 
    <hr /> 
    <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-list"></i> Lista de Usuarios</div>
      <div class="panel-body">
        <button class="btn btn-primary mb-3" id="btn-nuevo-usuario" data-toggle="modal" data-target="#modalUsuario">
          <i class="fa fa-user-plus"></i> Nuevo Usuario
        </button>
        <div class="form-check mb-2">
          <label class="form-check-label">
            <input type="checkbox" id="mostrarInactivos" class="form-check-input"> Mostrar usuarios inactivos
          </label>
        </div>
        <br><br>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tabla-usuarios">
            <thead class="thead-dark">
              <tr>
                <th>NOMBRES</th>
                <th>APELLIDOS</th>
                <th>TELÉFONO</th>
                <th>DIRECCIÓN</th>
                <th>CORREO</th>
                <th>ROL</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <!-- Modal para Añadir/Editar Usuario -->
        <div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUsuarioLabel">➕ REGISTRO / EDICIÓN DE USUARIO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formUsuario" enctype="multipart/form-data">
                            <input type="hidden" id="idUsuario" name="id">
                            <div class="form-group">
                                <label for="nombres">📛 Nombres:</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" required>
                            </div>
                            <div class="form-group">
                                <label for="apellidos">📛 Apellidos:</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                            </div>
                            <div class="form-group">
                                <label for="correo">📧 Correo:</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="form-group">
                                <label for="contrasena">🔒 Contraseña:</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="new-password">
                                <small id="contrasenaHelp" class="form-text text-muted">Dejar vacío para no cambiar (solo en edición).</small>
                            </div>
                            <div class="form-group">
                                <label for="codigorol">🧑‍🏫 Rol:</label>
                                <select class="form-control" id="codigorol" name="codigorol"required >
                                    <option value="">Seleccione</option>
                                    <option value="EST">Estudiante</option>
                                    <option value="DOC">Docente</option>
                                    <option value="INV">Invitado</option>
                                    <option value="ADM">Administrador</option>
                                </select>
                                    <input type="hidden" id="codigorol_hidden" name="codigorol_hidden">

                            </div>
                            <div class="form-group">
                                <label for="telefono">📱 Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="form-group">
                                <label for="direccion">🏠 Dirección:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            <div class="form-group">
                                <label for="es_interno">🏢 Es Interno:</label>
                                <select class="form-control" id="es_interno" name="es_interno" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="foto_perfil">🖼️ Foto de Perfil:</label>
                                <input type="file" class="form-control-file" id="foto_perfil" name="foto_perfil">
                            </div>
                            <div class="form-group">
                                <label for="estado">🟢 Estado:</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="ACTIVO">Activo</option>
                                    <option value="INACTIVO">Inactivo</option>
                                    <option value="BLOQUEADO">Bloqueado</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" id="btn-save-usuario">💾 Guardar usuario</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">❌ Cancelar</button>
                        </form>
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
</div>
     <!-- Scripts necesarios -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/usuario.js"></script>
<?php include("partials/footer_Admin.php"); ?>