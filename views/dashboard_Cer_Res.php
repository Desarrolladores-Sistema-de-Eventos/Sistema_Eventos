<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>
<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h2><i class="fa fa-certificate"></i> Gestión de Certificados</h2>
      </div>
    </div>
    <hr />

    <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-users"></i>Generación de Certificados</div>
      <div class="panel-body">
        <div class="form-group">
          <label for="selectEvento">Seleccione el Evento:</label>
          <select  id="selectEvento" class="selectEvento" style="width: 100%"></select>
        </div>
        <hr />
   
    <div class="table-responsive">
        <table id="tabla-certificados" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Evento</th>
                    <th>Estudiante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- JS llena aquí -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para editar la URL del certificado -->
<div class="modal fade" id="modalEditarCertificado" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarLabel">Editar URL del Certificado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editIdCertificado">
        <input type="text" class="form-control" id="editUrlCertificado" placeholder="Nueva URL del certificado">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="guardarEdicionCertificado()">Guardar</button>
      </div>
    </div>
  </div>
</div>
 </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="../public/js/certificado.js"></script>

<?php include("partials/footer_Admin.php"); ?>