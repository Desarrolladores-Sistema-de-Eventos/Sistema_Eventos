<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!--  CSS -->


<style>
  .uta-title {
    font-weight: bold;
    color: #b10024;
  }

  .uta-subtitle {
    color: #555;
    font-size: 1rem;
    margin-bottom: 1.5rem;
  }

  .table-responsive {
    background: #fff;
    padding: 1rem;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
  }

  #tablaRolesUsuario thead th {
    background-color: #b10024;
    color: white;
    text-align: center;
  }

  #tablaRolesUsuario tbody td {
    background-color: #fff;
    font-size: 14px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
  }

  #tablaRolesUsuario tbody tr:hover {
    background-color: #fef6f6;
    cursor: pointer;
  }

  .btn-primary {
    background-color: #b10024;
    border-color: #b10024;
  }

  .btn-primary:hover {
    background-color: #8c001d;
  }

  .btn-success {
    background-color: #198754;
  }

  .modal-title {
    font-weight: bold;
    color: #b10024;
  }

  .form-control:focus {
    border-color: #b10024;
    box-shadow: 0 0 0 0.2rem rgba(177, 0, 36, 0.2);
  }
  .descripcion-seccion {
    color: #6c757d;
    margin-bottom: 20px;
  }
</style>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="mb-4">
      <h3 class="uta-title"><i class="fa fa-users me-2"></i> Gestión de Roles de Usuario</h3>
      <p class="descripcion-seccion">Administra los roles de usuario disponibles en el sistema.</p>

    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-success shadow-sm" id="btnAgregarRolUsuario">
        <i class="fa fa-plus me-1"></i> Agregar Rol de Usuario
      </button>
      <a href="configuracion_datos_base.php" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver a configuración
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="tablaRolesUsuario">
        <thead>
          <tr>
            <th class="text-center">Código</th>
            <th class="text-center">Nombre</th>
            <th class="text-center" style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Contenido dinámico -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Rol Usuario -->
<div class="modal fade" id="modalRolUsuario" tabindex="-1" aria-labelledby="modalRolUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-sm">
      <form id="formRolUsuario">
        <div class="modal-header">
          <h5 class="modal-title" id="modalRolUsuarioLabel">Agregar Rol de Usuario</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="codigoRolUsuario" class="form-label">Código</label>
            <input type="text" class="form-control" id="codigoRolUsuario" name="codigo" maxlength="20" required>
          </div>
          <div class="mb-3">
            <label for="nombreRolUsuario" class="form-label">Nombre</label>
            <select class="form-control" id="nombreRolUsuario" name="nombre" required>
              <option value="">Seleccione...</option>
              <option value="ADMIN">ADMIN</option>
              <option value="DOCENTE">DOCENTE</option>
              <option value="ESTUDIANTE">ESTUDIANTE</option>
              <option value="INVITADO">INVITADO</option>
              <option value="AUTORIDAD">AUTORIDAD</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnGuardarRolUsuario">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/rol_usuario.js"></script>

<?php include("partials/footer_Admin.php"); ?>
