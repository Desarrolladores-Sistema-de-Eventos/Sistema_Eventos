<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>

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

  #tablaRequisitos thead th {
    background-color: #b10024;
    color: white;
    text-align: center;
  }

  #tablaRequisitos tbody td {
    background-color: #fff;
    font-size: 14px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
  }

  #tablaRequisitos tbody tr:hover {
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
      <h3 class="uta-title"><i class="fa fa-file-text me-2"></i> Gestión de Requisitos de Evento</h3>
      <p class="descripcion-seccion">Administra los requisitos disponibles para los eventos.</p>

    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-success shadow-sm" id="btnAgregarRequisito">
        <i class="fa fa-plus me-1"></i> Agregar Requisito
      </button>
      <a href="configuracion_datos_base.php" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver a configuración
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="tablaRequisitos">
        <thead>
          <tr>
            <th class="text-center">Descripción</th>
            <th class="text-center" style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Requisitos dinámicos -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Requisito -->
<div class="modal fade" id="modalRequisito" tabindex="-1" role="dialog" aria-labelledby="modalRequisitoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content shadow-sm">
      <form id="formRequisito">
        <div class="modal-header">
          <h5 class="modal-title" id="modalRequisitoLabel">Agregar Requisito</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="requisitoId" name="id">
          <div class="mb-3">
            <label for="descripcionRequisito" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcionRequisito" name="descripcion" maxlength="255" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnGuardarRequisito">Guardar</button>
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
<script src="../public/js/requisitos.js"></script>

<?php include("partials/footer_Admin.php"); ?>
