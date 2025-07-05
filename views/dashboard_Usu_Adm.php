<?php include("partials/header_Admin.php");?>
<?php 
$rolRequerido = 'ADMIN';
include("../core/auth.php")?>
<style>
  /* Encabezados principales */
  h2, #modalUsuarioLabel {
    color: #8B0000;
    font-weight: 600;
  }

  .panel-heading {
    background-color: #8B0000;
    color: #fff;
    font-weight: bold;
  }

  /* Botones */
  .btn-primary {
    background-color: #006699;
    border: none;
  }

  .btn-primary:hover {
    background-color: #004466;
  }

  .btn-success {
    background-color: #2e7d32;
    border: none;
  }

  .btn-success:hover {
    background-color: #1b5e20;
  }

  .btn-danger {
    background-color: #c62828;
    border: none;
  }

  .btn-danger:hover {
    background-color: #8e0000;
  }

  .btn-secondary {
    background-color: #6c757d;
    color: white;
    border: none;
  }

  .btn-secondary:hover {
    background-color: #565e64;
  }

  /* Tabla */
  #tabla-usuarios {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  }

  #tabla-usuarios thead {
    background-color: #8B0000;
    color: white;
  }

  #tabla-usuarios tbody tr:hover {
    background-color: #f9f5ef;
  }

  /* Formularios */
  label {
    font-weight: 600;
    color: #333;
  }

  .form-control {
    border-radius: 5px;
  }

  .form-group {
    margin-bottom: 1rem;
  }

  .modal-content {
    border: 2px solid #DAA520;
    border-radius: 12px;
  }

  .modal-header {
    background-color: #8B0000;
    color: white;
    border-bottom: 2px solid #DAA520;
  }

  .modal-footer {
    border-top: 1px solid #ccc;
  }

  .form-check-label {
    font-size: 14px;
    color: #555;
  }

  .form-check-input {
    transform: scale(1.2);
    margin-right: 5px;
  }

  .form-text.text-muted {
    font-size: 12px;
    color: #777;
  }
</style>

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
        <BR></BR>
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
                <th>CÉDULA</th>
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
                                  <div class="form-group">
                                <label for="fecha_nacimiento">🎂 Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required max="<?php echo date('Y-m-d'); ?>">
                            </div>
                                <label for="es_interno">🏢 Es Interno:</label>
                                <select class="form-control" id="es_interno" name="es_interno" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cedula">🆔 Cédula:</label>
                                <input type="text" class="form-control" id="cedula" name="cedula" required pattern="^\d{10}$" maxlength="10" title="Ingrese 10 dígitos numéricos">
                            </div>
                          
                            <div class="form-group">
                                <label for="cedula_pdf">📄 Cédula (PDF):</label>
                                <input type="file" class="form-control-file" id="cedula_pdf" name="cedula_pdf" accept="application/pdf">
                                <small class="form-text text-muted">Solo PDF. Opcional en edición si ya existe.</small>
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
<script>
document.getElementById('cedula_pdf')?.addEventListener('change', function() {
    if (this.files.length > 0) {
        const file = this.files[0];
        if (file.type !== 'application/pdf') {
            Swal.fire('Archivo inválido', 'Solo se permite subir archivos PDF para la cédula.', 'warning');
            this.value = '';
        }
    }
});
</script>
<?php include("partials/footer_Admin.php"); ?>