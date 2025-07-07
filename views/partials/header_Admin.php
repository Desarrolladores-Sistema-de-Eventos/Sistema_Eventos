<?php include("partials/header_Admin.php"); ?>
<?php 
$rolRequerido = 'ADMIN';
include("../core/auth.php")?>

<style>
  :root {
    --uta-rojo: #b10024;
    --uta-rojo-oscuro: #92001c;
    --uta-gris: #f5f5f5;
    --uta-negro: #000000;
    --uta-blanco: #ffffff;
  }

  .panel {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    border: none;
  }

  .panel .panel-heading {
    background-color: var(--uta-rojo);
    color: white;
    font-weight: bold;
    padding: 12px 15px;
    font-size: 1.1rem;
  }

  .panel .panel-body {
    background-color: white;
    padding: 20px;
  }

  .panel-default {
    border: 1px solid #e0e0e0;
  }

  ::-webkit-scrollbar {
    width: 8px;
    height: 8px;
  }
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }
  ::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
  }
  ::-webkit-scrollbar-thumb:hover {
    background: #555;
  }

  .panel-back.noti-box {
    background-color: var(--uta-blanco);
    border-left: 5px solid var(--uta-rojo);
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.06);
    transition: transform 0.2s ease;
  }

  .panel-back.noti-box:hover {
    transform: translateY(-5px);
  }

  .icon-box {
    width: 60px;
    height: 60px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.8rem;
    color: white;
    margin-bottom: 10px;
  }

  .bg-color-red {
    background-color: var(--uta-rojo);
  }
  .bg-color-green {
    background-color: var(--uta-rojo-oscuro);
  }
  .bg-color-blue {
    background-color: var(--uta-rojo);
  }
  .bg-color-brown {
    background-color: var(--uta-rojo-oscuro);
  }

  .text-box .main-text {
    font-size: 1.8rem;
    font-weight: bold;
    color: var(--uta-rojo);
  }

  .text-muted {
    color: var(--uta-negro) !important;
  }

  h2 i {
    color: var(--uta-rojo);
  }

  .hr {
    border-top: 2px solid var(--uta-rojo);
  }

  .table-responsive {
    max-height: 550px;
    overflow-y: auto;
    background-color: white;
    border-radius: 10px;
    padding: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  }

  .welcome-text {
    font-weight: bold;
    font-size: 1.4em; /* 40% más grande */
    margin-top: 10px;
  }

  .grafico-container {
    margin-bottom: 30px;
  }
</style>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h2><i class="fa fa-dashboard fa"></i> Panel Principal</h2>
        <h5 class="welcome-text">Bienvenido <?php echo $_SESSION['usuario']['NOMBRES'] . ' ' . $_SESSION['usuario']['APELLIDOS']; ?></h5>
      </div>
    </div>
    <hr />

    <!-- Estadísticas -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="panel panel-back noti-box">
          <span class="icon-box bg-color-red set-icon">
            <i class="fa fa-users"></i>
          </span>
          <div class="text-box">
            <p class="main-text"><span id="iconoTotalUsuarios">0</span></p>
            <p class="text-muted">Usuarios Activos</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="panel panel-back noti-box">
          <span class="icon-box bg-color-green set-icon">
            <i class="fa fa-calendar"></i>
          </span>
          <div class="text-box">
            <p class="main-text"><span id="iconoTotalEventos">0</span></p>
            <p class="text-muted">Eventos Disponibles</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="panel panel-back noti-box">
          <span class="icon-box bg-color-blue set-icon">
            <i class="fa fa-users"></i>
          </span>
          <div class="text-box">
            <p class="main-text"><span id="iconoUsuariosInactivos">0</span></p>
            <p class="text-muted">Usuarios Inactivos</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="panel panel-back noti-box">
          <span class="icon-box bg-color-brown set-icon">
            <i class="fa fa-calendar"></i>
          </span>
          <div class="text-box">
            <p class="main-text"><span id="iconoEventosCanceladosCerrados">0</span></p>
            <p class="text-muted">Eventos Cancelados/Cerrados</p>
          </div>
        </div>
      </div>
    </div>
    <hr />

    <!-- Gráficos uno debajo del otro -->
    <div class="grafico-container">
      <div class="panel panel-default">
        <div class="panel-heading">Inscripciones por Evento</div>
        <div class="panel-body">
          <canvas id="eventos-bar-horizontal" style="width:100%; height:250px; max-height:250px;"></canvas>
        </div>
      </div>
    </div>

    <div class="grafico-container">
      <div class="panel panel-default">
        <div class="panel-heading">Tipo de Usuarios</div>
        <div class="panel-body text-center">
          <div id="usuarios-donut-chart" style="height: 200px; margin: auto;"></div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="../public/js/estadisticas.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
