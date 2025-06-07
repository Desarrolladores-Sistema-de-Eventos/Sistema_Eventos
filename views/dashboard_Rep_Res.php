<?php include("partials/header_Admin.php"); ?>
<?php 
$requiereResponsable = true;
include("../core/auth.php");
?>

<div id="page-wrapper">
  <div id="page-inner">

    <div class="row">
      <div class="col-md-12">
        <h2><i class="fa fa-file"></i> Generación de Reportes</h2>
        <hr />
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-file"></i> Reportería</div>
      <div class="panel-body">
        <form id="formReporte">
          <div class="row align-items-end g-2">
            <div class="col-md-5">
              <label for="tipoReporte" class="form-label">Tipo de Reporte</label>
              <select id="tipoReporte" class="form-control" required>
                <option value="">Seleccione un tipo de reporte</option>
                <option value="inscritos">Reporte de Inscritos</option>
                <option value="certificados">Reporte de Certificados</option>
                <option value="financiero">Reporte Financiero</option>
                <option value="asistencia">Reporte de Asistencia y Nota</option>
                <option value="general">Reporte General del Evento</option>
              </select>
            </div>

            <div class="col-md-5">
              <label for="eventoSeleccionado" class="form-label">Seleccione el Evento</label>
              <select id="eventoSeleccionado" class="form-control" required>
                <option value="">Cargando eventos...</option>
              </select>
            </div>

            <div class="col-md-2 d-flex flex-column gap-2">
              <button type="submit" class="btn btn-primary mb-2">
                <i class="fa fa-cogs"></i> Generar
              </button>
              <button type="button" class="btn btn-danger" onclick="exportarPDF()">
                <i class="fa fa-print"></i>
              </button>
            </div>
          </div>
        </form>

        <hr />
        <div id="resultado" class="mt-4"></div>
      </div>
    </div>

  </div>
</div>

<!-- JS & Plugins -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

<!-- Tu JS con fetch -->
<script src="../public/js/reportes_responsable.js"></script>

<?php include("partials/footer_Admin.php"); ?>
