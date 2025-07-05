<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>


<div id="page-wrapper">
  <div id="page-inner">
    <h3 class="text-danger"><i class="fa fa-tags"></i> Gestión de Tipos de Evento</h3>
    <p class="text-muted">Administra los tipos de evento disponibles en el sistema.</p>

    <div class="mb-3">
      <button class="btn btn-success" id="btnAgregarTipoEvento"><i class="fa fa-plus"></i> Agregar Tipo de Evento</button>
    </div>
    <br>
    <div class="table-responsive">
      <table class="table table-dark table-bordered table-hover" id="tablaTiposEvento">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se cargan los tipos de evento dinámicamente -->
        </tbody>
      </table>
    </div>
    <div>
      <a href="configuracion_datos_base.php" class="btn btn-secondary mt-2"><i class="fa fa-arrow-left"></i> Volver a configuración</a>
    </div>
  </div>
</div>

<!-- Modal Tipo de Evento -->
<div class="modal fade" id="modalTipoEvento" tabindex="-1" role="dialog" aria-labelledby="modalTipoEventoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formTipoEvento">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTipoEventoLabel">Agregar Tipo de Evento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="codigoTipoEvento">Código</label>
            <input type="text" class="form-control" id="codigoTipoEvento" name="codigo" maxlength="20" required>
          </div>
          <div class="form-group">
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
          <button type="submit" class="btn btn-primary" id="btnGuardarTipoEvento">Guardar</button>
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
<script src="../public/js/tipoevento.js"></script>
<?php include("partials/footer_Admin.php"); ?>