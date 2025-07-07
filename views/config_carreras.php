<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>


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
      <h3 class="uta-title"><i class="fa fa-graduation-cap me-2"></i>Gestión de Carreras de Nuestra Facultad</h3>
          <p class="descripcion-seccion">Administra las carreras disponibles en cada facultad.</p>

    </div>

    <div class="mb-4">
      <button class="btn btn-success shadow-sm" id="btnAgregarCarrera">
        <i class="fa fa-plus me-1"></i> Agregar Carrera
      </button>
    </div>
    <br>

    <div class="table-responsive">
      <table class="table table-bordered table-hover shadow-sm" id="tablaCarreras">
        <thead class="text-center">
          <tr>
            <th>Nombre de Carrera</th>
            <th>Facultad</th>
            <th style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Carga dinámica -->
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

<!-- Modal Carrera -->
<div class="modal fade" id="modalCarrera" tabindex="-1" role="dialog" aria-labelledby="modalCarreraLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content shadow">
      <form id="formCarrera" enctype="multipart/form-data" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCarreraLabel">Agregar Carrera</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="carreraId" name="id">
          <div class="mb-3">
            <label for="nombreCarrera" class="form-label">Nombre de Carrera</label>
            <input type="text" class="form-control" id="nombreCarrera" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="facultadCarrera" class="form-label">Facultad</label>
            <select class="form-control" id="facultadCarrera" name="facultad" required>
              <option value="">Seleccione...</option>
              <!-- Opciones dinámicas -->
            </select>
          </div>
          <div class="mb-3">
            <label for="imagenCarrera" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagenCarrera" name="imagen" accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnGuardarCarrera">Guardar</button>
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
<script src="../public/js/carreras.js"></script>

<?php include("partials/footer_Admin.php"); ?>
