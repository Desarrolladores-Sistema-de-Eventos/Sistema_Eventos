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
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>

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
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f9;
    color: #2c2c2c;
  }

  h2 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #8b0000;
  }

  .panel {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.06);
    border-radius: 10px;
    background: #fff;
  }

  .panel-heading {
    background-color: #b10024;
    color: white;
    padding: 12px 20px;
    font-weight: 600;
    font-size: 15px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .form-group label {
    font-weight: 600;
  }

  select.form-control {
    border-radius: 6px;
    border: 1px solid #ccc;
    padding: 8px;
  }

  .btn-primary {
    background-color: #b10024;
    border: none;
    border-radius: 5px;
    font-weight: 600;
  }

  .btn-primary:hover {
    background-color: #92001c;
  }

  .btn-default {
    background-color: #f0f0f0;
    border: none;
    font-weight: 600;
    color: #333;
    border-radius: 4px;
  }

  .btn-default:hover {
    background-color: #dcdcdc;
  }

  .table {
    background: white;
    border-radius: 6px;
    overflow: hidden;
  }

  .table thead {
    background-color: #b10024;
    color: white;
  }

  .table th, .table td {
    text-align: center;
    vertical-align: middle;
    font-size: 14px;
  }
  .table tbody tr:hover {
    background-color: #fceeee;
  }

  .modal-header {
    background-color: #b10024;
    color: white;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .modal-footer {
    border-top: 1px solid #ddd;
  }

  .form-check-input {
    transform: scale(1.1);
    margin-right: 8px;
  }

  #evento {
    max-width: 350px;
  }

  .select2-container--default .select2-selection--single {
    border-radius: 6px;
    height: 38px;
    border-color: #b10024;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
  }

  hr {
    border-top: 2px solid #92001c;
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
