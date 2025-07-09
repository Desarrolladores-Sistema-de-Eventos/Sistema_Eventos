<?php include("partials/header_Admin.php"); ?>
<?php 
$rolRequerido = 'ADMIN';
include("../core/auth.php"); 
?>

<div id="page-wrapper">
  <div id="page-inner" class="container py-4">

    <div class="row mb-4">
      <div class="col text-center">
        <h2><i class="fa fa-file" style="color: #000;"></i> Generación de Reportes</h2>
        <div class="linea-roja-uta"></div>
      </div>
    </div>

    <div class="row g-4">

     <!-- Panel 1 -->
     <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-certificate me-2" style="color: #fff;"></i>Certificados Emitidos</h5>
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
            <h5 class="mb-0"><i class="fa fa-user-check me-2" style="color: #fff;"></i>Inscripciones por Evento</h5>
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
            <h5 class="mb-0"><i class="fa fa-money" style="color: #fff;"></i> Reporte Financiero</h5>
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
            <h5 class="mb-0"><i class="fa fa-users me-2" style="color: #fff;"></i> Evento y Asistentes</h5>
          </div>
          <div class="panel-body p-3">
            <p>Listado de asistentes y organizadores con detalles por evento.</p>
            <a href="informeAsistentesView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  body {
    background-color: #fff;
    color: #000;
    font-family: Arial, sans-serif;
  }
  .alert-info {
  background-color: #ffd6d6 !important; /* Rojo claro */
  color: #222 !important;               /* Letra negra */
  border-color: #ffb3b3 !important;     /* Borde rojo suave */
}
a{
  color: #ae0c22; /* Rojo institucional */
  text-decoration: none;
}


.linea-roja-uta {
  width: 100%;
  height: 8px;
  background: #ae0c22;
  border-radius: 3px;
  margin-top: 0px;
  margin-bottom: 18px;
}
  .panel-heading {
    background: rgb(27, 26, 26) !important;
    color: #fff !important;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    border-bottom: 2px solid #7b2020;
    font-weight: normal;
    font-size: 14px;
    padding-top: 8px !important;
    padding-bottom: 8px !important;
    min-height: unset;
  }

   h2 {
    font-size: 24px;
    color: rgb(23, 23, 23);
    font-weight: bold;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  

  .panel-heading {
    background:rgb(185, 51, 51);
    color: #fff;
    
  }
 select.form-control {
    border: 1.5px solid #9b2e2e;
    border-radius: 6px;
    font-size: 14px;
    background: #f9fafb;
    color: #222;
    transition: border-color 0.2s;
  }
   th.nombre-columna, td.nombre-columna {
  max-width: 100px;
  width: 100px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
 div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a:focus,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a:hover {
    color: #111 !important;
    background: #fff !important;
    border: 1px solid #ddd !important;
    box-shadow: none !important;
    outline: none !important;
  }
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
    background-color: #9b2e2e !important;
    border-color: #9b2e2e!important;
    color: #fff !important;
    box-shadow: none !important;
    outline: none !important;
  }
thead {
  background-color: rgb(180, 34, 34);
  color: white;
  font-size: 14px;
  font-weight: normal;
}
.table {
  width: 100% !important;
  max-width: 90vw !important;
  margin: 0 auto;
}
.table th, .table td {
  padding: 12px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ddd;
  font-size: 14px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.table th {
  background-color: rgb(180, 34, 34);
  color: #fff;
  font-weight: normal;
}
h4 {
  font-size: 14px;
  
}
label{
  font-weight: normal;
  font-size: 14px;
}
p{
  font-size: 14px;
  font-weight: normal;
}
hr{
  border-top: 2px solid #9b2e2e;
  opacity: 1;
}
.dataTables_length label,
.dataTables_length select {
  font-size: 14px !important;
}
 .titulo-linea {
    border-bottom: 2px solid rgb(185, 51, 51);
    margin-top: 6px;
    margin-bottom: 20px;
  }

/* Tabs UTA institucional */
.nav-tabs > li > a {
  color: #222 !important; /* Negro para inactivos */
}
.nav-tabs > li > a:hover {
  background: #c0392b !important;
  color: #fff !important;
}
ul.nav.nav-tabs {
  margin-top: -8px !important;
  margin-bottom: 15px;
}

.linea-roja-uta {
  width: 100%;
  height: 8px;
  background: #ae0c22;
  border-radius: 3px;
  margin-top: 0px;
  margin-bottom: 18px;
}
  /* Alto máximo y scroll para el cuerpo del modal de eventos */
  .modal-body {
    overflow-y: auto;
  }
/* Estilo para checkboxes verticales */
.custom-checkbox-vertical {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  min-height: 54px;
}
.label-checkbox-vertical {
  font-size: 14px;
  margin-bottom: 4px;
  font-weight: normal;
}
.custom-checkbox-vertical input[type="checkbox"] {
  margin: 10px auto 0 auto; /* Baja el checkbox y lo centra */
  width: 15px;
  height: 15px;
  accent-color: #ae0c22; /* Rojo institucional */
}
  .select2-container--default .select2-results__option--highlighted[aria-selected] {
  background-color:rgb(184, 46, 46) !important; /* Rojo institucional */
  color: #fff !important;
}
</style>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include("partials/footer_Admin.php"); ?>