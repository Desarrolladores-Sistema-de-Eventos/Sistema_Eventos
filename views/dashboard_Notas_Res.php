<?php include("partials/header_Admin.php"); ?>
<?php 
$requiereResponsable = true;
include("../core/auth.php");
?>

<div id="page-wrapper">
  <div id="page-inner">

    <!-- ENCABEZADO CON BOTÓN FINALIZAR Y LÍNEA INFERIOR -->
    <div class="d-flex justify-content-between align-items-center mb-1">
      <h2 class="titulo-notas mb-0">
        <i class="fa fa-graduation-cap"></i> Registro de Calificaciones
      </h2>
      <button id="btn-finalizar-evento" class="btn btn-black-red btn-sm" style="display: none;" onclick="finalizarEvento()">
        <i class="fa fa-flag-checkered"></i> Finalizar Evento
      </button>
    </div>
    <div class="titulo-linea"></div> <!-- Línea roja debajo -->

    <!-- INFORMACIÓN DEL EVENTO -->
    <div class="row mb-3 align-items-center mt-2">
      <div class="col-md-3"><strong>Evento:</strong> <span id="titulo-evento"></span></div>
      <div class="col-md-3"><strong>🗓 Fecha:</strong> <span id="fecha-evento"></span></div>
      <div class="col-md-3"><strong>Tipo:</strong> <span id="tipo-evento"></span></div>
      <div class="col-md-3 text-end">
        <strong> Total Inscritos:</strong> <span id="total-inscritos"></span>
      </div>
    </div>

        <div class="titulo-linea"></div> <!-- Línea roja debajo -->
        <hr/>


    <!-- TABLA DE CALIFICACIONES -->
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center" id="tablas-notas">
        <thead class="table-header text-center">
          <tr>
            <th>#</th>
            <th>Nombre y Apellido</th>
            <th>Asistió</th>
            <th>Nota Final</th>
            <th>% Asistencia</th>
            <th>Observación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se llenarán las filas con JavaScript -->
        </tbody>
      </table>
    </div>

    <!-- BOTÓN VOLVER -->
    <div class="text-start mt-4">
      <a href="dashboard_NotasAsistencia_Res.php" class="btn btn-black-red">
        <i class="fa fa-arrow-left"></i> Volver a eventos
      </a>
    </div>

  </div>
</div>

<style>
body {
  background-color: #fff;
  color: #000;
  font-family: Arial, sans-serif;
}
strong{

  font-size: 14px;
  font-weight: bold;

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


.titulo-linea {
  border-bottom: 2px solid rgb(185, 51, 51);
  margin-top: 6px;
  margin-bottom: 20px;
}

.table-header {
  background-color: rgb(185, 51, 51);
  color: white;
  font-weight: normal;
  font-size: 14px;
}

.table-header th {
  text-align: center;
  vertical-align: middle;
   font-weight: normal;
  font-size: 14px;

}

#tablas-notas input,
#tablas-notas select {
  width: 100%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.table td, .table th {
  vertical-align: middle;
  text-align: center;
}

.btn-black-red {
  background-color: rgb(185, 51, 51);;
  color: white;
  border: 2px solid #000;
  border-radius: 4px;
  padding: 6px 10px;
  transition: 0.2s ease;
}

.btn-black-red:hover {
  background-color: rgb(104, 53, 53);
  color: white;
  border-color: black;
}

.btn-detallar {
  background-color: #fff;
  color: #0073aa;
  border: 1px solid #0073aa;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.3s ease;

}

.btn-detallar:hover {
  background-color: #0073aa;
  color: white;
}

.d-flex {
  display: flex;
}
.justify-content-between {
  justify-content: space-between;
}
.align-items-center {
  align-items: center;
}
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: rgb(185, 51, 51); !important;
  border-color: rgb(185, 51, 51); !important;
  color: white !important;
  box-shadow: none !important;
  outline: none !important;
}

.form-control-sm {
  border: 2px solid #ccc;
  border-radius: 6px;
  padding: 6px 10px;
  font-size: 14px;
  transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  background-color: #fff;
}

.form-control-sm:focus {
  border-color: ;
  box-shadow: 0 0 0 3px rgba(155, 46, 46, 0.2);
  outline: none;
}

input::placeholder {
  color: #999;
  opacity: 1;
  font-style: italic;
}

input[type="number"] {
  appearance: textfield;
  -moz-appearance: textfield;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  margin: 0;
  -webkit-appearance: none;
}

select.form-control-sm {
  background-color: #fff;
  color: #333;
  font-weight: 500;
  appearance: none;
  background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath fill='%239B2E2E' d='M0 0l5 6 5-6z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 10px center;
  background-size: 10px 6px;
  padding-right: 30px;
}

select {
  white-space: nowrap;
}
#tablas-notas td input.form-control-sm,
#tablas-notas td select.form-control-sm {
  max-width: 60px; /* o ajusta a 100px, 90px, etc. según lo que desees */
  margin: 0 auto;
  display: block;
  padding: 4px 8px;
  font-size: 14px;
}

@media (max-width: 768px) {
  .row.align-items-center > div {
    white-space: normal;
  }
}
</style>

<!-- LIBRERÍAS JS Y CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/asi_Not_Res.js"></script>

<?php include("partials/footer_Admin.php"); ?>
