<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>


<div id="page-wrapper">
  <div id="page-inner">
    <h3 class="text-danger"><i class="fa fa-university"></i> Gestión de Facultades</h3>
    <p class="text-muted">Administra las facultades disponibles en el sistema.</p>

    <div class="mb-3">
      <button class="btn btn-success" id="btnAgregarFacultad"><i class="fa fa-plus"></i> Agregar Facultad</button>
    </div>
    <br>
    <div class="table-responsive">
      <table class="table table-dark table-bordered table-hover" id="tablaFacultades">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Misión</th>
            <th>Visión</th>
            <th>Ubicación</th>
            <th style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se cargan las facultades dinámicamente -->
        </tbody>
      </table>
    </div>
    <div>
      <a href="configuracion_datos_base.php" class="btn btn-secondary mt-2"><i class="fa fa-arrow-left"></i> Volver a configuración</a>
    </div>
  </div>
</div>

<!-- Modal Facultad -->
<div class="modal fade" id="modalFacultad" tabindex="-1" role="dialog" aria-labelledby="modalFacultadLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formFacultad">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFacultadLabel">Agregar Facultad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="facultadId" name="id">
          <div class="form-group">
            <label for="nombreFacultad">Nombre</label>
            <input type="text" class="form-control" id="nombreFacultad" name="nombre" maxlength="100" required>
          </div>
          <div class="form-group">
            <label for="misionFacultad">Misión</label>
            <textarea class="form-control" id="misionFacultad" name="mision" maxlength="500" required></textarea>
          </div>
          <div class="form-group">
            <label for="visionFacultad">Visión</label>
            <textarea class="form-control" id="visionFacultad" name="vision" maxlength="500" required></textarea>
          </div>
          <div class="form-group">
            <label for="ubicacionFacultad">Ubicación</label>
            <input type="text" class="form-control" id="ubicacionFacultad" name="ubicacion" maxlength="255" required>
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


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/facultades.js"></script>
<?php include("partials/footer_Admin.php"); ?>