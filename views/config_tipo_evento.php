<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php") ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
  .section-title {
    color: #b10024;
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
  }

  .section-desc {
    color: #444;
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
  }

  .btn-uta {
    background-color: #28a745;
    color: #fff;
    border: none;
    transition: all 0.3s ease-in-out;
    font-weight: 500;
  }

  .btn-uta:hover {
    background-color: #92001c;
  }

  .table thead {
    background-color: #b10024;
    color: #fff;
  }

  .table th, .table td {
    vertical-align: middle;
    text-align: center;
  }

  .modal-header {
    background-color: #b10024;
    color: white;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
  }

  .modal-title {
    font-weight: bold;
  }

  .modal-footer .btn-primary {
    background-color: #b10024;
    border: none;
  }

  .modal-footer .btn-primary:hover {
    background-color: #92001c;
  }

  .modal-content {
    border-radius: 0.5rem;
  }

  .form-control:focus {
    border-color: #b10024;
    box-shadow: 0 0 0 0.2rem rgba(177, 0, 36, 0.25);
  }

  .shadow-box {
    background-color: #fff;
    padding: 1rem;
    border-radius: 0.5rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  }

.descripcion-seccion {
    color: #6c757d;
    margin-bottom: 20px;
  }

</style>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="mb-4">
      <h3 class="section-title"><i class="fa fa-tags me-2"></i> Gestión de Tipos de Evento</h3>
      <p class="descripcion-seccion">Administra los tipos de evento disponibles en el sistema.</p>


      <button class="btn btn-uta shadow-sm mb-3" id="btnAgregarTipoEvento">
        <i class="fa fa-plus me-2"></i> Agregar Tipo de Evento
      </button>
    </div>

    <div class="table-responsive shadow-box">
      <table class="table table-bordered table-hover" id="tablaTiposEvento">
        <thead>
          <tr>
            <th style="width: 15%;">Código</th>
            <th style="width: 25%;">Nombre</th>
            <th>Descripción</th>
            <th style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Se cargan dinámicamente -->
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      <a href="configuracion_datos_base.php" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left me-1"></i> Volver a configuración
      </a>
    </div>
  </div>
</div>

<!-- Modal Tipo de Evento -->
<div class="modal fade" id="modalTipoEvento" tabindex="-1" role="dialog" aria-labelledby="modalTipoEventoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formTipoEvento">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTipoEventoLabel">
            <i class="fa fa-edit me-2"></i> Formulario de Tipo de Evento
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="codigoTipoEvento">Código</label>
            <input type="text" class="form-control" id="codigoTipoEvento" name="codigo" maxlength="20" required>
          </div>
          <div class="form-group mb-3">
            <label for="nombreTipoEvento">Nombre</label>
            <input type="text" class="form-control" id="nombreTipoEvento" name="nombre" maxlength="100" required>
          </div>
          <div class="form-group">
            <label for="descripcionTipoEvento">Descripción</label>
            <textarea class="form-control" id="descripcionTipoEvento" name="descripcion" maxlength="500"></textarea>
          </div>
          <!-- INICIO: Campos agregados para requerir nota/asistencia -->
          <div class="form-group">
            <label for="controlesTipoEvento">Requerimientos de control</label><br>
            <div class="checkbox-inline">
              <label><input type="checkbox" id="REQUIERENOTA" name="REQUIERENOTA"> Requiere Nota</label>
            </div>
            <div class="checkbox-inline">
              <label><input type="checkbox" id="REQUIEREASISTENCIA" name="REQUIEREASISTENCIA"> Requiere Asistencia</label>
            </div>
          </div>
          <!-- FIN: Campos agregados para requerir nota/asistencia -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts necesarios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="../public/js/tipoevento.js"></script>

<?php include("partials/footer_Admin.php"); ?>
