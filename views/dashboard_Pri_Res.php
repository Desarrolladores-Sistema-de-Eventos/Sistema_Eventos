<?php include("partials/header_Admin.php"); ?>
<?php 
$requiereResponsable = true;
include("../core/auth.php")?>


<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h2><i class="fa fa-dashboard fa"></i> Panel Principal</h2>
        <h5>Bienvenido <?php echo $_SESSION['usuario']['NOMBRES'] . ' ' . $_SESSION['usuario']['APELLIDOS']; ?></h5>
      </div>
    </div>
    <hr />

    <!-- MÉTRICAS -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-6">           
        <div class="panel panel-back noti-box">
          <span class="icon-box bg-color-red set-icon"><i class="fa fa-edit"></i></span>
          <div class="text-box"><p class="main-text" id="total-inscritos">0</p><p class="text-muted">Inscritos</p></div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-6">           
        <div class="panel panel-back noti-box">
          <span class="icon-box bg-color-green set-icon"><i class="fa fa-calendar"></i></span>
          <div class="text-box"><p class="main-text" id="total-eventos">0</p><p class="text-muted">Eventos</p></div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-6">           
        <div class="panel panel-back noti-box">
          <span class="icon-box bg-color-blue set-icon"><i class="fa fa-user"></i></span>
          <div class="text-box"><p class="main-text" id="total-pendientes">0</p><p class="text-muted">Pendientes</p></div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-6">           
        <div class="panel panel-back noti-box">
          <span class="icon-box bg-color-brown set-icon"><i class="fa fa-bar-chart-o"></i></span>
          <div class="text-box"><p class="main-text" id="total-reportes">0</p><p class="text-muted">Reportes</p></div>
        </div>
      </div>
    </div>
    <hr />

    <!-- INSCRIPCIONES PENDIENTES + DONUT -->
    <div class="row">
      <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">Inscripciones Pendientes</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="tabla-pendientes">
                <thead>
                  <tr>
                    <th>Participante</th>
                    <th>Evento</th>
                    <th>Estado</th>
                    <th>Factura</th>
                    <th>Detalles</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Gráfico Donut -->
      <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">Estado de Inscripciones</div>
          <div class="panel-body text-center">
            <canvas id="graficoEstados" width="200" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>

    <hr />

    <!-- GRÁFICOS ADICIONALES -->
    <div class="row"> 
      <div class="col-md-6 col-sm-12 col-xs-12">                     
        <div class="panel panel-default">
          <div class="panel-heading">Inscripciones por Evento</div>
          <div class="panel-body"><canvas id="graficoEventos"></canvas></div>
        </div>            
      </div> 

      <div class="col-md-6 col-sm-12 col-xs-12">                     
        <div class="panel panel-default">
          <div class="panel-heading">Certificados Emitidos por Evento</div>
          <div class="panel-body"><canvas id="graficoCertificados"></canvas></div>
        </div>            
      </div> 
    </div>
  </div>
</div>

<!-- ... lo anterior se mantiene igual ... -->

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
          <div class="form-group">
            <label>Nombre del Participante:</label>
            <p id="detalleNombre" class="form-control-static font-weight-bold"></p>
          </div>
          <div class="form-group">
            <label>Evento Inscrito:</label>
            <p id="detalleEvento" class="form-control-static"></p>
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
          </div>

          <!-- NUEVA SECCIÓN: Pagos -->
          <div class="form-group">
            <label>Pagos Registrados:</label>
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

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="../public/js/ins_Das_Res.js"></script>
<?php include("partials/footer_Admin.php"); ?>
