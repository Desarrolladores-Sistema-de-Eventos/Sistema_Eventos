<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h2><i class="fa fa-edit"></i> Gestión de  Inscripciones</h2>
      </div>
    </div>
    <hr />

    <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-users"></i>Inscripciones y Requisitos</div>
      <div class="panel-body">
        <div class="form-group">
          <label for="eventoSeleccionado">Seleccione el Evento:</label>
          <select  id="eventoSeleccionado" class="form-control select2" style="width: 100%"></select>
        </div>
        <hr />

        <!-- Tabla de Inscripciones -->
        <h4><i class="fa fa-list-alt"></i> Lista de Inscritos</h4>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tabla-inscripciones">
            <thead>
              <tr>
                <th>Nombres y Apellidos</th>
                <th>Fecha de Inscripción</th>
                <th>Estado Inscripción</th>
                <th>Factura</th>
                <th>Requisitos</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <hr />

        <!-- MODAL: Ver requisitos y pagos -->
        <div class="modal fade" id="modalRequisitosPagos" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Detalles de Inscripción</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p><strong>Participante:</strong> <span id="nombreParticipanteModal"></span></p>

                <h5><i class="fa fa-check-square"></i> Requisitos</h5>
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th>Requisito</th>
                      <th>Archivo</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody id="tablaRequisitosModal"></tbody>
                </table>

                <hr>
                <h5><i class="fa fa-money"></i> Pagos</h5>
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th>Comprobante</th>
                      <th>Forma de Pago</th>
                      <th>Estado</th>
                      <th>Fecha</th>
                    </tr>
                  </thead>
                  <tbody id="tablaPagosModal"></tbody>
                </table>
              </div>
              <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
        <!-- Fin modal -->
  </div>
</div>
    <hr />
    
  </div>
</div>

<!-- Librerías -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="../public/js/ins_Res.js"></script>
<?php include("partials/footer_Admin.php"); ?>
