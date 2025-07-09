<?php 
include("partials/header_Admin.php");
$requiereResponsable = true;
include("../core/auth.php")
?>

<div id="page-wrapper">
  <div id="page-inner" class="uta-panel">
    <!-- ENCABEZADO -->
    <div class="uta-header">
      <div>
        <h2><i class="fa fa-dashboard"></i>Bienvenido <?php echo $_SESSION['usuario']['NOMBRES'] . ' ' . $_SESSION['usuario']['APELLIDOS']; ?></h2>
      </div>
    </div>
    <div class="titulo-linea"></div>

    <!-- MÉTRICAS -->
    <div class="uta-metricas">
      <div class="uta-metrica">
        <div class="uta-metrica-icon bg-negro"><i class="fa fa-edit"></i></div>
        <div>
          <div class="uta-metrica-num" id="total-inscritos">0</div>
          <div class="uta-metrica-label">Inscritos</div>
        </div>
      </div>
      <div class="uta-metrica">
        <div class="uta-metrica-icon bg-negro"><i class="fa fa-calendar"></i></div>
        <div>
          <div class="uta-metrica-num" id="total-eventos">0</div>
          <div class="uta-metrica-label">Eventos</div>
        </div>
      </div>
      <div class="uta-metrica">
        <div class="uta-metrica-icon bg-rojo"><i class="fa fa-users"></i></div>
        <div>
          <div class="uta-metrica-num" id="total-pendientes">0</div>
          <div class="uta-metrica-label">Pendientes</div>
        </div>
      </div>
    </div>

    <!-- INSCRIPCIONES PENDIENTES + DONUT -->
    <div class="uta-row">
      <div class="uta-col-2-3">
        <div class="uta-card">
          <div class="uta-card-header">Inscripciones Pendientes</div>
          <div class="uta-card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="tabla-pendientes">
                <thead>
                  <tr>
                    <th>Participante</th>
                    <th>Evento</th>
                    <th>Estado</th>
                    <th>Requisitos</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="uta-col-1-3">
        <div class="uta-card">
          <div class="uta-card-header">Estado de Inscripciones</div>
          <div class="uta-card-body text-center">
            <canvas id="graficoEstados" width="200" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- GRÁFICOS ADICIONALES -->
    <div class="uta-row">
      <div class="uta-col-1-2">
        <div class="uta-card">
          <div class="uta-card-header">Inscripciones por Evento</div>
          <div class="uta-card-body"><canvas id="graficoEventos"></canvas></div>
        </div>
      </div>
      <div class="uta-col-1-2">
        <div class="uta-card">
          <div class="uta-card-header">Certificados Emitidos por Evento</div>
          <div class="uta-card-body"><canvas id="graficoCertificados"></canvas></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DETALLE INSCRIPCIÓN -->
<div class="modal fade" id="modalDetalleInscripcion" tabindex="-1" role="dialog" aria-labelledby="detalleInscripcionLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formDetalleInscripcion">
        <div class="modal-header">
          <h4 class="modal-title" id="detalleInscripcionLabel">Detalle de Inscripción</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group" style="display: flex; align-items: center; gap: 12px;">
            <label style="margin-bottom: 0; font-weight: bold;">Participante:</label>
            <span id="detalleNombre" class="form-control-static font-weight-normal"></span>
          </div>
          <div class="form-group" style="display: flex; align-items: center; gap: 12px;">
            <label style="margin-bottom: 0; font-weight: bold;">Evento:</label>
            <span id="detalleEvento" class="form-control-static"></span>
          </div>
          <div class="form-group">
            <label>Requisitos Subidos:</label>
            <div class="table-responsive">
              <table class="table table-bordered" id="tabla-requisitos-detalle">
                <thead>
                  <tr>
                    <th>Requisito</th>
                    <th>Archivo</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
                     <!-- Motivación de la inscripción -->
                <div id="detalleMotivacion" style="margin-bottom: 18px;">
                  <hr>
                  <h5><i class="fa fa-comment"></i> Motivación del Participante</h5>
                  <textarea id="motivacionParticipanteModal" class="form-control" style="font-size:15px; min-height:60px; background-color: #f2f3f5; color: #222; border: 1.5px solid #d3d6db; border-radius: 8px; resize: none; box-shadow: 0 2px 8px #0001; padding: 12px 14px; font-weight: 500;" readonly></textarea>
                </div>

          </div>
          <div class="form-group" id="grupo-pagos-registrados">
            <label id="label-pagos-registrados">Pagos Registrados:</label>
            <div class="table-responsive">
              <table class="table table-bordered" id="tabla-pagos-detalle">
                <thead>
                  <tr>
                    <th>Archivo</th>
                    <th>Forma de Pago</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="detalleIdInscripcion">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ESTILOS UTA -->
<style>

body {
  background-color: #fff;
  color: #000;

}
.titulo-linea {
    border-bottom: 2px solid rgb(185, 51, 51);
    margin-top: 6px;
    margin-bottom: 20px;
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

  .uta-metricas {
    display: flex;
    gap: 18px;
    margin: 30px 0 24px 0;
    flex-wrap: wrap;
    justify-content: space-between;
  }
  .uta-metrica {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px #0001;
    border: 1.5px solid #9b2e2e;
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 18px 22px;
    min-width: 220px;
    flex: 1 1 220px;
    max-width: 270px;
  }
  .uta-metrica-icon {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #fff;
    background: #9b2e2e;
  }
  .bg-rojo { background: rgb(180, 34, 34) !important; }
  .bg-negro { background: #222 !important; }
  .uta-metrica-num {
    font-size: 2.1em;
    font-weight: bold;
    color: rgb(180, 34, 34);
    margin-bottom: 0;
  }
  .uta-metrica-label {
    color: #222;
    font-size: 1em;
    font-weight: 500;
  }
  .uta-row {
    display: flex;
    gap: 18px;
    margin-bottom: 24px;
    flex-wrap: wrap;
  }
  .uta-col-2-3 {
    flex: 2 1 0;
    min-width: 350px;
  }
  .uta-col-1-3 {
    flex: 1 1 0;
    min-width: 250px;
  }
  .uta-col-1-2 {
    flex: 1 1 0;
    min-width: 320px;
  }
  .uta-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px #0001;
    border: 1.5px solid rgb(48, 47, 47);
    margin-bottom: 0;
    display: flex;
    flex-direction: column;
    min-height: 220px;
    font-weight: normal;
     font-size: 14px;
  }
  .uta-card-header {
    background: rgb(33, 31, 31)  ;
    color: #fff;
    border-radius: 12px 12px 0 0;
    padding: 12px 18px;
    font-weight: normal;
    font-size: 14px;
    text-align: center;
  }
  .uta-card-body {
    padding: 18px 18px 18px 18px;
    flex: 1 1 auto;
    font-weight: normal;
     font-size: 14px;
  }
  .table > thead > tr > th {
    background: rgb(180, 34, 34) !important;
    color: #fff !important;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #ddd !important;
    font-weight: normal;
    font-size: 14px;
  }
  h4{
      font-weight: normal;
     font-size: 14px;
  }
  .table > tbody > tr > td {
    text-align: center;
    vertical-align: middle;
    border: none;
  }
  .table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f9f6f2;
  }
  .btn-primary {
    background: #9b2e2e;
    border: none;
    font-weight: 600;
    border-radius: 6px;
    transition: background 0.2s;
    font-weight: normal;
     font-size: 14px;
  }
  .btn-primary:hover {
    background: rgb(180, 34, 34);
  }
  .btn-secondary {
    background: #222;
    color: #fff;
    border: none;
    font-weight: 600;
    border-radius: 6px;
    transition: background 0.2s;
    font-weight: normal;
     font-size: 14px;
  }
  .btn-secondary:hover {
    background:rgb(180, 34, 34);
    color: #fff;
  }
  hr {
    border-top: 2px solid rgb(180, 34, 34);
    opacity: 1;
  }
  /* Modal */
  .modal-header {
    background: rgb(180, 34, 34);
    color: #fff;
    border-radius: 8px 8px 0 0;
    border-bottom: 2px solid #222;
    font-weight: normal;
     font-size: 14px;
  }
  .modal-footer {
    background: #f8f8f8;
    border-top: 1.5px solid #222;
    border-radius: 0 0 8px 8px;
    font-weight: normal;
     font-size: 14px;
  }
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: rgb(180, 34, 34) !important;
  border-color: #9b2e2e !important;
  color: white !important;
  box-shadow: none !important;
  outline: none !important;
}
  /* Responsive */
  @media (max-width: 1100px) {
    .uta-panel { max-width: 98vw; }
    .uta-metricas, .uta-row { flex-direction: column; gap: 18px; }
    .uta-col-2-3, .uta-col-1-3, .uta-col-1-2 { min-width: 0; }
  }
</style>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="../public/js/ins_Das_Res.js"></script>

<?php include("partials/footer_Admin.php"); ?>