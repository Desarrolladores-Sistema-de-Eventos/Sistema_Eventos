<?php 
include("partials/header_Admin.php");
$requiereResponsable = true;
include("../core/auth.php")
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
      <div class="panel-heading"> Reportes</div>
      <div class="panel-body">
        <form id="formReporte">
          <div class="row align-items-end g-2">
            <div class="col-md-5">
              <label for="tipoReporte" class="form-label">Tipo de Reporte:</label>
              <select id="tipoReporte" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="inscritos">Reporte de Inscritos</option>
                <option value="certificados">Reporte de Certificados</option>
                <option value="financiero">Reporte Financiero</option>
                <option value="asistencia">Reporte de Asistencia y Nota</option>
                <option value="general">Reporte General del Evento</option>
              </select>
            </div>

            <div class="col-md-5">
              <label for="eventoSeleccionado" class="form-label">Seleccione el Evento:</label>
              <select id="eventoSeleccionado" class="form-control" required>
                <option value="">Cargando eventos...</option>
              </select>
            </div>

            <div class="col-md-2 d-flex flex-column gap-2">
              <button type="submit" class="btn btn-primary mb-2">
                <i class="fa fa-cogs"></i> Generar
              </button>
              <button type="button" class="btn-primary" onclick="exportarPDF()">
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

<style>

  h2 {
    font-size: 24px;
    color: rgb(23, 23, 23);
    font-weight: bold;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .panel-default {
    border: 1.5px solidrgb(4, 4, 4);
    border-radius: 10px;
    background: #9b2e2e;
    box-shadow: 0 2px 12px #0001;
  }
  
  .panel-heading {
    background: rgb(33, 32, 32) !important;
    color: #fff !important;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    border-bottom: 2px solidrgb(16, 16, 16);
    font-weight: normal;
    font-size: 14px;

  }
  .panel-body {
    padding: 24px 18px 18px 18px;
  }
  label.form-label {
    color:rgb(28, 27, 27);
  }
  select.form-control {
    border: 1.5px solid #9b2e2e;
    border-radius: 6px;
    font-size: 15px;
    background: #f9fafb;
    color: #222;
    transition: border-color 0.2s;
  }
  
  .btn-primary {
    background:  rgb(185, 51, 51);
    border: none;
    font-weight: 600;
    border-radius: 6px;
    transition: background 0.2s;
    font-weight: normal;
    font-size: 14px;
  }
  .btn-primary:hover {
    background: #7b2020;
  
  }
  
  hr {
    border-top: 2px solid #9b2e2e;
    opacity: 1;
  }
  label{
  font-weight: normal;
  font-size: 15px;
}
thead {
  background-color: rgb(180, 34, 34);
  color: white;
  font-size: 14px;
  font-weight: normal;
}
 th {
    padding: 12px;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #ddd;
    background-color: rgb(180, 34, 34); 
    font-size: 14px;
    font-weight: normal;
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
    border-color: #9b2e2e !important;
    color: #fff !important;
    box-shadow: none !important;
    outline: none !important;
  }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
  background-color:rgb(184, 46, 46) !important; /* Rojo institucional */
  color: #fff !important;
}


.dataTables_length label,
.dataTables_length select {
  font-size: 14px !important;
}
  /* Responsive */
  @media (max-width: 700px) {
    .panel-body {
      padding: 12px 5px 10px 5px;
    }
    .row.align-items-end.g-2 {
      flex-direction: column;
      gap: 10px;
    }
  }
</style>

<!-- JS & Plugins -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<!-- Tu JS con fetch -->
<script src="../public/js/reportes_responsable.js"></script>

<?php include("partials/footer_Admin.php"); ?>