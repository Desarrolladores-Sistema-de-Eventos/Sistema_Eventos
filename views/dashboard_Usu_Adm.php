<?php include("partials/header_Admin.php");?>
<?php 
$rolRequerido = 'ADMIN';
include("../core/auth.php")?>


<style>
  /* Ajuste para evitar desbordamiento del modal y de los campos PDF */
  @media (max-width: 991px) {
    .modal-lg {
      max-width: 98vw !important;
    }
    .form-group[style*="display:flex"] {
      flex-direction: column !important;
      gap: 8px !important;
    }
    .form-group[style*="display:flex"] > div {
      min-width: 0 !important;
      width: 100% !important;
    }
  }
  @media (max-width: 600px) {
    .modal-content {
      padding: 0 2px !important;
    }
    .modal-lg {
      max-width: 100vw !important;
      margin: 0 !important;
    }
  }
  .table thead {
    background-color: #ae0c22;
    color: white;
  }
  .modal-header {
    background-color: #ae0c22;
    color: white;
  }
  body {
    background-color: #fff;
    color: #000;
    font-family: Arial, sans-serif;
  }
  label,p{
    color: #000;
    font-family: Arial, sans-serif;
    font-size: 14px;
  }
  h2 {
    font-size: 24px;
    color: rgb(23, 23, 23);
    font-weight: bold;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  th {
    padding: 12px;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #ddd;
    background-color: rgb(180, 34, 34); 
    font-size: 14px;
    font-weight: normal;
  }
  td {
    padding: 12px;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #ddd;
    font-size: 14px;
  }
  table#tabla-autoridades tbody tr:hover {
    background-color: #f2f2f2 !important;
    transition: background 0.2s;
  }

  div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a:focus,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a:hover {
    color: #111 !important;
    background: #fff !important;
    border: 1px solid #ddd !important;
    box-shadow: none !important;
    outline: none !important;
  }
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
    background-color: #9b2e2e !important;
    border-color: #9b2e2e !important;
    color: #fff !important;
    box-shadow: none !important;
    outline: none !important;
  }
  /* Tabs UTA institucional */
.nav-tabs > li > a {
  color: #222 !important; /* Negro para inactivos */
}
.nav-tabs > li > a:hover {
  background: #c0392b !important;
  color: #fff !important;
}
.linea-roja-uta {
  position: absolute;
  left: 0;
  bottom: -8px;
  width: 100%;
  height: 8px;
  background: #ae0c22;
  border-radius: 3px;
}
label{
  font-weight: normal;
  font-size: 14px;
}
</style>

<div id="page-wrapper">
  <div id="page-inner">
        <div style="position:relative;">
          <h2 style="position:relative;z-index:2;"><i class="fa fa-users"></i> Gestión de Usuarios</h2>
          <div class="linea-roja-uta" style="position:absolute;left:0;right:0;bottom:-12px;z-index:1;"></div>
        </div>
        <div class="mb-3 d-flex" style="margin-bottom:28px !important; margin-top:18px !important;">
          <div style="display:flex;justify-content:flex-end;width:auto;align-items:flex-end;">
            <button class="btn btn-carrusel-upload mb-3" id="btn-nuevo-usuario" data-toggle="modal" data-target="#modalUsuario" style="margin-top:18px;">
              <i class="fa fa-user-plus"></i> Nuevo Usuario
            </button>
          </div>
        <!-- Nav tabs por Rol -->
        <ul class="nav nav-tabs mb-3" id="navTabsRoles" role="tablist" style="margin-bottom: 15px;">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-estudiante" href="javascript:void(0);" role="tab" aria-selected="true" data-rol="EST"><i class="fa fa-graduation-cap"></i> Estudiantes</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-docente" href="javascript:void(0);" role="tab" aria-selected="false" data-rol="DOC"><i class="fa fa-chalkboard"></i> Docentes</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-invitado" href="javascript:void(0);" role="tab" aria-selected="false" data-rol="INV"><i class="fa fa-user-o"></i> Invitados</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-otro" href="javascript:void(0);" role="tab" aria-selected="false" data-rol="OTRO"><i class="fa fa-users"></i> Otros</a>
          </li>
        </ul>
        <div class="table-responsive">
          <table class="table table-dark table-bordered table-hover" id="tabla-usuarios">
            <thead>
              <tr>
                <th>Foto</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cédula</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Correo</th>
                <th>Rol</th>
                <th style="width: 120px;">Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <!-- Modal para Añadir/Editar Usuario -->
        <div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUsuarioLabel">
                            <i class="fa fa-user"></i> Registro / edición de Usuarios
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formUsuario" enctype="multipart/form-data">
                            <input type="hidden" id="idUsuario" name="id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombres"><i class="fa fa-user"></i> Nombres:</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellidos"><i class="fa fa-user"></i> Apellidos:</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo"><i class="fa fa-envelope"></i> Correo:</label>
                                        <input type="email" class="form-control" id="correo" name="correo" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contrasena"><i class="fa fa-lock"></i> Contraseña:</label>
                                        <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="new-password">
                                        <small id="contrasenaHelp" class="form-text text-muted">Dejar vacío para no cambiar (solo en edición).</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigorol"><i class="fa fa-users"></i> Rol:</label>
                                        <select class="form-control" id="codigorol" name="codigorol" required>
                                            <option value="">Seleccione</option>
                                            <option value="EST">Estudiante</option>
                                            <option value="DOC">Docente</option>
                                            <option value="INV">Invitado</option>
                                            <option value="OTRO">Otro</option>
                                        </select>
                                        <input type="hidden" id="codigorol_hidden" name="codigorol_hidden">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono"><i class="fa fa-phone"></i> Teléfono:</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion"><i class="fa fa-map-marker"></i> Dirección:</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_nacimiento"><i class="fa fa-calendar"></i> Fecha de Nacimiento:</label>
                                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required max="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="es_interno"><i class="fa fa-building"></i> Es Interno:</label>
                                        <select class="form-control" id="es_interno" name="es_interno" required>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cedula"><i class="fa fa-id-card"></i> Cédula:</label>
                                        <input type="text" class="form-control" id="cedula" name="cedula" required pattern="^\d{10}$" maxlength="10" title="Ingrese 10 dígitos numéricos">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="background:#f8f8f8;padding:12px 10px 6px 10px;border-radius:7px;border:1px solid #e0e0e0;">
                                        <div class="row">
                                            <div class="col-md-6" style="margin-bottom:8px;">
                                                <label for="cedula_pdf"><i class="fa fa-file-pdf-o"></i> Cédula (PDF):</label>
                                                <input type="file" class="form-control-file" id="cedula_pdf" name="cedula_pdf" accept="application/pdf">
                                                <input type="hidden" id="cedula_pdf_actual" name="cedula_pdf_actual">
                                                <div id="cedula_pdf_label" class="mt-1"></div>
                                                <small class="form-text text-muted">Solo PDF. Opcional en edición si ya existe.</small>
                                            </div>
                                            <div class="col-md-6" style="margin-bottom:8px;">
                                                <label for="matricula_pdf"><i class="fa fa-file-pdf-o"></i> Matrícula (PDF):</label>
                                                <input type="file" class="form-control-file" id="matricula_pdf" name="matricula_pdf" accept="application/pdf">
                                                <input type="hidden" id="matricula_pdf_actual" name="matricula_pdf_actual">
                                                <div id="matricula_pdf_label" class="mt-1"></div>
                                                <small class="form-text text-muted">Solo PDF. Opcional en edición si ya existe.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto_perfil"><i class="fa fa-image"></i> Foto de Perfil:</label>
                                        <input type="file" class="form-control-file" id="foto_perfil" name="foto_perfil">
                                        <input type="hidden" id="foto_perfil_actual" name="foto_perfil_actual">
                                        <div id="foto_perfil_preview" class="mt-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado"><i class="fa fa-toggle-on"></i> Estado:</label>
                                        <select class="form-control" id="estado" name="estado" required>
                                            <option value="ACTIVO">Activo</option>
                                            <option value="INACTIVO">Inactivo</option>
                                            <option value="BLOQUEADO">Bloqueado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center justify-content-end" style="gap:10px;">
                                    <button type="submit" class="btn btn-secondary" id="btn-save-usuario"><i class="fa fa-user"></i> Guardar usuario</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                                </div>
                            </div>
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
                    <div class="modal-body">
                        ¿Está seguro que desea eliminar a <strong id="userNameToDelete"></strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" style="background-color:#e0e0e0;color:#111;border:none;" data-dismiss="modal">
                            <i class="fa fa-times"></i> Cancelar
                        </button>
                        <button type="button" class="btn" style="background-color:#e0e0e0;color:#111;border:none;" id="confirmDeleteButton">
                            <i class="fa fa-trash"></i> Eliminar
                        </button>
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