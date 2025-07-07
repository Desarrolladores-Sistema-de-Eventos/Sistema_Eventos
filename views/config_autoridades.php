<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
  .uta-title {
    font-weight: bold;
    color: #b10024;
  }

  .uta-subtitle {
    color: #555;
    font-size: 1rem;
    margin-bottom: 2rem;
  }

  .table thead {
    background-color: #b10024;
    color: #fff;
  }

  .btn-success {
    background-color: #198754;
    border-color: #198754;
  }

  .btn-success:hover {
    background-color: #157347;
    border-color: #146c43;
  }

  .modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
  }

  .modal-title {
    font-weight: 600;
    color: #b10024;
  }

  .form-control:focus {
    border-color: #b10024;
    box-shadow: 0 0 0 0.2rem rgba(177, 0, 36, 0.25);
  }

  .btn-primary {
    background-color: #b10024;
    border-color: #b10024;
  }

  .btn-primary:hover {
    background-color: #a00020;
    border-color: #90001c;
  }

  .descripcion-seccion {
    color: #6c757d;
    margin-bottom: 20px;
  }
</style>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="mb-4">
      <h3 class="uta-title"><i class="fa fa-users me-2"></i>Gestión de Autoridades</h3>
      <p class="descripcion-seccion">Administra las autoridades visibles en el portal.</p>
    </div>

    <div class="mb-4">
      <button class="btn btn-success shadow-sm" id="btnAgregarAutoridad">
        <i class="fa fa-plus me-1"></i> Agregar Autoridad
      </button>
    </div>
    <br>

    <div class="table-responsive">
      <table class="table table-bordered table-hover shadow-sm" id="tablaAutoridades">
        <thead class="text-center">
          <tr>
            <th>Nombre</th>
            <th>Cargo</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Carga dinámica desde autoridades.js -->
        </tbody>
      </table>
    </div>

    <div>
      <a href="configuracion_datos_base.php" class="btn btn-secondary mt-3">
        <i class="fa fa-arrow-left"></i> Volver a configuración
      </a>
    </div>
  </div>
</div>

<!-- Modal Autoridad -->
<div class="modal fade" id="modalAutoridad" tabindex="-1" role="dialog" aria-labelledby="modalAutoridadLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content shadow">
      <form id="formAutoridad" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAutoridadLabel">Agregar Autoridad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="SECUENCIAL" id="SECUENCIAL">
          <div class="mb-3">
            <label for="NOMBRE" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" name="NOMBRE" id="NOMBRE" required>
          </div>
          <div class="mb-3">
            <label for="CARGO" class="form-label">Cargo</label>
            <input type="text" class="form-control" name="CARGO" id="CARGO" required>
          </div>
          <div class="mb-3">
            <label for="CORREO" class="form-label">Correo</label>
            <input type="email" class="form-control" name="CORREO" id="CORREO" required>
          </div>
          <div class="mb-3">
            <label for="TELEFONO" class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="TELEFONO" id="TELEFONO">
          </div>
          <div class="mb-3">
            <label for="FOTO_URL" class="form-label">Foto (nombre del archivo)</label>
            <input type="file" class="form-control" name="FOTO_URL" id="FOTO_URL" accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
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
<script src="../public/js/autoridades.js"></script>

<?php include("partials/footer_Admin.php"); ?>
