<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">


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

  .table-responsive {
    background: white;
    padding: 1rem;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    max-height: 600px;
    overflow-y: auto;
  }
.descripcion-seccion {
    color: #6c757d;
    margin-bottom: 20px;
  }
  #tablaFacultades thead th {
    background-color: #b10024;
    color: white;
    font-weight: bold;
    text-align: center;
  }

  #tablaFacultades tbody td {
    vertical-align: middle;
    background-color: #fff;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14px;
  }

  #tablaFacultades tbody tr:hover {
    background-color: #fff9f0;
    cursor: pointer;
  }

  .btn-success {
    background-color: #198754;
    border-color: #198754;
  }

  .btn-success:hover {
    background-color: #146c43;
  }

  .btn-primary {
    background-color: #b10024;
    border-color: #b10024;
  }

  .btn-primary:hover {
    background-color: #a00020;
  }

  .modal-title {
    font-weight: 600;
    color: #b10024;
  }

  .form-control:focus {
    border-color: #b10024;
    box-shadow: 0 0 0 0.2rem rgba(177, 0, 36, 0.2);
  }
</style>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="mb-4">
      <h3 class="uta-title"><i class="fa fa-university me-2"></i> Gestión de Facultades</h3>
          <p class="descripcion-seccion">Administra las facultades disponibles en el sistema.</p>

    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-success shadow-sm" id="btnAgregarFacultad">
        <i class="fa fa-plus me-1"></i> Agregar Facultad
      </button>
      <a href="configuracion_datos_base.php" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver a configuración
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="tablaFacultades">
        <thead class="text-center">
          <tr>
            <th>Nombre</th>
            <th>Misión</th>
            <th>Visión</th>
            <th>Ubicación</th>
            <th style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Contenido dinámico -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal para agregar/editar facultad -->
<div class="modal fade" id="modalFacultad" tabindex="-1" role="dialog" aria-labelledby="modalFacultadLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content shadow-sm">
      <form id="formFacultad" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFacultadLabel">Agregar Facultad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="facultadId" name="id">

          <div class="mb-3">
            <label for="nombreFacultad" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombreFacultad" name="nombre" maxlength="100" required>
          </div>

          <div class="mb-3">
            <label for="misionFacultad" class="form-label">Misión</label>
            <textarea class="form-control" id="misionFacultad" name="mision" maxlength="500" required></textarea>
          </div>

          <div class="mb-3">
            <label for="visionFacultad" class="form-label">Visión</label>
            <textarea class="form-control" id="visionFacultad" name="vision" maxlength="500" required></textarea>
          </div>

          <div class="mb-3">
            <label for="ubicacionFacultad" class="form-label">Ubicación</label>
            <input type="text" class="form-control" id="ubicacionFacultad" name="ubicacion" maxlength="255" required>
          </div>

          <div class="mb-3">
            <label for="siglaFacultad" class="form-label">Sigla</label>
            <input type="text" class="form-control" id="siglaFacultad" name="sigla" maxlength="20">
          </div>

          <div class="mb-3">
            <label for="aboutFacultad" class="form-label">Acerca de (Descripción)</label>
            <textarea class="form-control" id="aboutFacultad" name="about" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label for="urlLogoFacultad" class="form-label">Logo (imagen)</label>
            <input type="file" class="form-control" id="urlLogoFacultad" name="urlLogo" accept="image/*">
          </div>

          <div class="mb-3">
            <label for="urlPortadaFacultad" class="form-label">Portada (imagen)</label>
            <input type="file" class="form-control" id="urlPortadaFacultad" name="urlPortada" accept="image/*">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnGuardarFacultad">Guardar</button>
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
<script src="../public/js/facultades.js"></script>

<?php include("partials/footer_Admin.php"); ?>
