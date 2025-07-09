<?php include("partials/header_Admin.php"); ?>
<?php 
$rolRequerido = 'ADMIN';
include("../core/auth.php"); 
?>

<div id="page-wrapper">
  <div id="page-inner" class="container py-4">

    <div class="row mb-4">
      <div class="col text-center">
        <h2><i class="fa fa-file"></i> Generación de Reportes</h2>
        <hr>
      </div>
    </div>

    <div class="row g-4">

      <!-- Panel 1 -->
      <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-certificate text-success me-2"></i>Certificados Emitidos</h5>
          </div>
          <div class="panel-body p-3">
            <p>Consulta y descarga los certificados emitidos por evento.</p>
            <a href="informeCertificadosView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>

      <!-- Panel 2 -->
      <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-user-check text-info me-2"></i>Inscripciones por Evento</h5>
          </div>
          <div class="panel-body p-3">
            <p>Revisa cuántos estudiantes se han inscrito por evento.</p>
            <a href="informeInscripcionesView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>

      <!-- Panel 3 -->
      <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-money-bill-wave text-warning me-2"></i>Reporte Financiero</h5>
          </div>
          <div class="panel-body p-3">
            <p>Pagos realizados, pendientes y comprobantes por evento.</p>
            <a href="informeFinancieroView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>

      <!-- Panel 4 -->
      <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-users text-secondary me-2"></i>Evento y Asistentes</h5>
          </div>
          <div class="panel-body p-3">
            <p>Listado de asistentes con detalles por evento.</p>
            <a href="informeAsistentesView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>

      <!-- Panel 5 -->
      <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-tags text-danger me-2"></i>Eventos por Categoría</h5>
          </div>
          <div class="panel-body p-3">
            <p>Listado y estado de eventos por categoría.</p>
            <a href="informeEventosCategoriaView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include("partials/footer_Admin.php"); ?>