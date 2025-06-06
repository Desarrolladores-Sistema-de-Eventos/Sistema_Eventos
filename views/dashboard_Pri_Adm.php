<?php include("partials/header_Admin.php"); ?>
<?php 
$rolRequerido = 'ADMIN';
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

    <!-- Estadísticas rápidas -->
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

    <!-- Gráficos principales: Barra y Donut lado a lado -->
    <div class="row">
      <!-- Inscripciones por Evento (Barra) -->
      <div class="col-md-8 col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Inscripciones por Evento
          </div>
          <div class="panel-body">
            <canvas id="eventos-bar-horizontal" style="width:100%; height:250px; max-height:250px;"></canvas>
          </div> 
        </div>
      </div>
      <!-- Tipo de Usuarios (Donut) -->
      <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Tipo de Usuarios
          </div>
          <div class="panel-body text-center">
            <div id="usuarios-donut-chart" style="height: 200px; margin: auto;"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- ...tu HTML hasta aquí... -->
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="../public/js/estadisticas.js"></script>

    <!-- Tus scripts personalizados -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Chart.js eliminado porque usas Morris.js -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<?php include("partials/footer_Admin.php"); ?>