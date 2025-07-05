<?php include("partials/header_Admin.php"); ?>
<?php 
$requiereResponsable = true;
include("../core/auth.php"); ?>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h2><i class="fa fa-users"></i> Gestión de Inscripciones</h2>
        <hr />
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-calendar"></i> Eventos</div>
      <div class="panel-body">
        <div style="display: flex; justify-content: center;">
  <div class="form-group" style="max-width: 500px; margin: 0 auto;">
  <div class="d-flex align-items-center" style="gap: 10px;">
    <label for="evento" class="font-weight-bold mb-0" style="font-size: 1.1rem;">
      <i class="fa fa-search"></i> Evento:
    </label>
    <select class="form-control border border-danger" id="evento" name="evento" style="max-width: 250px;"></select>
  </div>
</div>
        </div>
        <hr />

        <!-- Tabla de Inscripciones -->
        <h4><i class="fa fa-users"></i> Lista de Inscripciones</h4>
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
        <br>
        <br/>


        <!-- MODAL: Ver requisitos y pagos -->
        <div class="modal fade" id="modalRequisitosPagos" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header" style="background: #222; color:rgb(40, 40, 40); border-top-left-radius: 6px; border-top-right-radius: 6px;">
                <h4 class="modal-title" style="color: #fff;">Detalles de Inscripción</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color: #fff; opacity: 1;">
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

                <div id="seccionPagosModal">
                  <hr>
                  <h5><i class="fa fa-money"></i> Pagos</h5>
                  <table class="table table-bordered table-sm">
                    <thead>
                      <tr>
                        <th>Comprobante</th>
                        <th>Forma de Pago</th>
                        <th>Estado</th>
                        <th>Fecha de Pago</th>
                      </tr>
                    </thead>
                    <tbody id="tablaPagosModal"></tbody>
                  </table>
                </div>
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
<style>
  body {
    background-color: #fff;
    color: #000;
    font-family: Arial, sans-serif;
  }

  .panel-heading {
    background: rgb(27, 26, 26) !important;
    color: #fff !important;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    border-bottom: 2px solid #7b2020;
     font-weight: normal;
     font-size: 14px;

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
   
  .btn-primary {
    background: #9b2e2e;
    border: none;
    font-weight: 600;
    border-radius: 6px;
    transition: background 0.2s;
  }
  .btn-primary:hover {
    background: #7b2020;
  }
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: #c0392b !important;
  border-color: #c0392b !important;
  color: white !important;
  box-shadow: none !important;
  outline: none !important;
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
td {
  padding: 12px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ddd;
  background-color::rgb(180, 34, 34); 
  font-size: 14px;
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
/* Asegura que el select y el dropdown de Choices.js sean más anchos */
.choices__inner, .choices[data-type*=select-one] .choices__list--dropdown {
    min-width: 250px;
    max-width: 350px;
    width: 100%;
    font-size: 1rem;
    white-space: normal;
    word-break: break-word;
}
.choices__list--dropdown {
    min-width: 250px !important;
    max-width: 350px !important;
    width: 100% !important;
}
.choices__list--dropdown, .choices__list[aria-expanded] {
    border: 2px solid #a00 !important;
    box-shadow: 0 2px 8px rgba(160,0,0,0.08);
}
</style>

<!-- Librerías -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="../public/js/ins_Res.js"></script>
<!-- Choices.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<!-- Choices.js JS -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('../controllers/EventosController.php?option=listarResponsable')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('evento');
                select.innerHTML = '';
                data.forEach(evento => {
                    const option = document.createElement('option');
                    option.value = evento.SECUENCIAL;
                    option.textContent = evento.TITULO;
                    select.appendChild(option);
                });
                new Choices(select, {
                    searchEnabled: true,
                    itemSelectText: '',
                    shouldSort: false,
                    placeholder: true,
                    placeholderValue: 'Buscar evento...',
                    searchPlaceholderValue: 'Buscar evento...'
                });
            });
    });
</script>
<?php include("partials/footer_Admin.php"); ?>
