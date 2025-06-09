<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>


<div id="page-wrapper">
  <div id="page-inner">
    <h3 class="text-danger"><i class="fa fa-credit-card"></i> Gestión de Formas de Pago</h3>
    <p class="text-muted">Administra las formas de pago disponibles en el sistema.</p>

    <div class="mb-3">
      <button class="btn btn-success" id="btnAgregarFormaPago"><i class="fa fa-plus"></i> Agregar Forma de Pago</button>
    </div>
    <br>
    <div class="table-responsive">
      <table class="table table-dark table-bordered table-hover" id="tablaFormasPago">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se cargan las formas de pago dinámicamente -->
        </tbody>
      </table>
    </div>
    <div>
      <a href="configuracion_datos_base.php" class="btn btn-secondary mt-2"><i class="fa fa-arrow-left"></i> Volver a configuración</a>
    </div>
  </div>
</div>

<!-- Modal Forma de Pago -->
<div class="modal fade" id="modalFormaPago" tabindex="-1" role="dialog" aria-labelledby="modalFormaPagoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formFormaPago">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFormaPagoLabel">Agregar Forma de Pago</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="codigoFormaPago">Código</label>
            <input type="text" class="form-control" id="codigoFormaPago" name="codigo" maxlength="20" required>
          </div>
          <div class="form-group">
            <label for="nombreFormaPago">Nombre</label>
            <input type="text" class="form-control" id="nombreFormaPago" name="nombre" maxlength="100" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnGuardarFormaPago">Guardar</button>
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
<script src="../public/js/formapago.js"></script>
<?php include("partials/footer_Admin.php"); ?>