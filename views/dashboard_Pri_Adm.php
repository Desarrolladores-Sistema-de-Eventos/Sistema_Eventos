<?php include("partials/header_Admin.php"); ?>
<?php 
$rolRequerido = 'ADMIN';
include("../core/auth.php")?>

<!-- ESTILOS UTA -->
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

/* Encabezados de paneles principales */
.panel-heading {
  background: #111 !important;
  color: #fff !important;
  border-radius: 12px 12px 0 0;
  font-family: inherit;
  font-weight: normal;
  font-size: 14px;
  text-align: center;
  letter-spacing: 0.5px;
  border-bottom: 3px solid #8B0000;
}
.panel-heading i, .panel-heading .fa {
  color: #8B0000 !important;
  margin-right: 6px;
  vertical-align: middle;
}
/* Iconos de métricas y paneles */
/* Iconos de métricas y paneles */
.icon-box {
  background: #8B0000 !important;
  color: #fff !important;
  border: none !important;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.18s cubic-bezier(.4,1.3,.6,1), box-shadow 0.18s;
  box-shadow: 0 2px 8px #0002;
  cursor: pointer;
}
.icon-box:hover {
  transform: scale(1.13) rotate(-7deg);
  box-shadow: 0 6px 18px #8B000044;
  background: #600000 !important;
}
.icon-box.bg-color-red { background: #8B0000 !important; }
.icon-box.bg-color-green { background: #111 !important; }
.icon-box.bg-color-blue { background: #222 !important; }
.icon-box.bg-color-brown { background: #600000 !important; }
.icon-box i, .icon-box .fa {
  color: #fff !important;
  font-size: 32px;
  vertical-align: middle;
}
.uta-metrica-icon {
  background: #8B0000 !important;
  color: #fff !important;
  border: none !important;
  display: flex;
  align-items: center;
  justify-content: center;
}
.uta-metrica-icon i, .uta-metrica-icon .fa {
  color: #fff !important;
  font-size: 28px;
  vertical-align: middle;
}
.linea-roja-uta {
  width: 100%;
  height: 8px;
  background: #ae0c22;
  border-radius: 3px;
  margin-top: 0px;
  margin-bottom: 18px;
}
h2 {
  margin-bottom: 0px;
}
</style>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h2><i class="fa fa-dashboard fa"></i>Bienvenido <?php echo $_SESSION['usuario']['NOMBRES'] . ' ' . $_SESSION['usuario']['APELLIDOS']; ?></h2>
        <div class="linea-roja-uta"></div>
      </div>
    </div>


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