<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!--  CSS -->

<style>
  .titulo-seccion {
    color: #b10024;
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 10px;
  }

  .descripcion-seccion {
    color: #6c757d;
    margin-bottom: 20px;
  }

  .btn-uta {
    background-color: #28a745;
    color: white;
    border: none;
  }

  .btn-uta:hover {
    background-color: #92001c;
    color: white;
  }

  .table > thead {
    background-color: #b10024;
    color: white;
  }

  .modal-header {
    background-color: #b10024;
    color: white;
    border-bottom: none;
  }

  .modal-title {
    font-weight: 600;
  }

  .form-control:focus {
    border-color: #b10024;
    box-shadow: none;
  }
</style>

<div id="page-wrapper">
  <div id="page-inner">
    <h3 class="titulo-seccion"><i class="fa fa-random"></i> Gestión de Modalidades de Evento</h3>
    <p class="descripcion-seccion">Administra las modalidades de evento disponibles en el sistema.</p>

    <div class="mb-3">
      <button class="btn btn-uta" id="btnAgregarModalidad"><i class="fa fa-plus"></i> Agregar Modalidad</button>
    </div>
    <br>


    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="tablaModalidades">
        <thead>
          <tr>
            <th style="width: 25%;">Código</th>
            <th>Nombre</th>
            <th style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Se cargan dinámicamente -->
        </tbody>
      </table>
    </div>

    <div>
      <a href="configuracion_datos_base.php" class="btn btn-default mt-3">
        <i class="fa fa-arrow-left"></i> Volver a configuración
      </a>
    </div>
  </div>
</div>

<!-- Modal Modalidad -->
<div class="modal fade" id="modalModalidad" tabindex="-1" role="dialog" aria-labelledby="modalModalidadLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formModalidad">
        <div class="modal-header">
          <h4 class="modal-title" id="modalModalidadLabel"><i class="fa fa-plus-circle"></i> Registrar Modalidad</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white; font-size: 24px;">
            &times;
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="codigoModalidad">Código</label>
            <input type="text" class="form-control" id="codigoModalidad" name="codigo" maxlength="20" required>
          </div>
          <div class="form-group">
            <label for="nombreModalidad">Nombre</label>
            <input type="text" class="form-control" id="nombreModalidad" name="nombre" maxlength="50" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-uta">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="../public/js/modalidades.js"></script>

<?php include("partials/footer_Admin.php"); ?>
