<?php
require_once '../core/roles.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rol = strtoupper($_SESSION['usuario']['ROL'] ?? '');
$esResponsable = !empty($_SESSION['usuario']['ES_RESPONSABLE']);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menú Administrativo</title>
  <link href="../public/assets/css/bootstrap.css" rel="stylesheet" />
  <link href="../public/assets/css/font-awesome.css" rel="stylesheet" />
  <link href="../public/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
  <link href="../public/assets/css/custom.css" rel="stylesheet" />
  <link href="../public/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div id="wrapper">
  <nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Dashboard</a>
    </div>
    <div style="float: right; padding: 15px 50px 5px 50px;">
    <span id="hora" style="color: white; font-size: 16px;"></span>
    &nbsp;
    <a href="../controllers/logout.php" class="btn btn-danger square-btn-adjust">Cerrar Sesión</a>
   </div>
  </nav>

  <nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav" id="main-menu">

          <?php if ($esResponsable): ?> 
          <li><a href="../views/dashboard_Pri_Res.php"><i class="fa fa-dashboard fa-3x"></i> Panel Principal</a></li>
          <li><a href="../views/dashboard_Eve_Res.php"><i class="fa fa-calendar fa-3x"></i> Mis Eventos</a></li>
          <li><a href="../views/dashboard_Ins_Res.php"><i class="fa fa-edit fa-3x"></i> Inscripciones</a></li>
          <li><a href="../views/dashboard_NotasAsistencia_Res.php"><i class="fa fa-check-square-o fa-3x"></i> Notas/Asistencia</a></li>
          <li><a href="../views/dashboard_Cer_Res.php"><i class="fa fa-certificate fa-3x"></i> Certificados</a></li>
          <li><a href="../views/dashboard_Rep_Res.php"><i class="fa fa-file-text fa-3x"></i> Reportes</a></li>
          <?php endif; ?>

      
        <?php if ($rol === 'ADMIN'): ?>
          <li><a href="../views/dashboard_Pri_Adm.php"><i class="fa fa-dashboard fa-3x"></i> Panel Principal</a></li>
          <li><a href="../views/dashboard_Eve_Adm.php"><i class="fa fa-calendar fa-3x"></i>Eventos</a></li>
          <li><a href="../views/dashboard_Usu_Adm.php"><i class="fa fa-users fa-3x"></i> Usuarios</a></li>
          <li><a href="../views/dashboard_Rep_Adm.php"><i class="fa fa-file-text fa-3x"></i> Reportes</a></li>
          <li><a href="../views/configuracion_datos_base.php"><i class="fa fa-gear fa-3x"></i> Configuraciones</a></li>
          <li><a href="../views/evaluacion_tecnica.php"><i class="fas fa-clipboard-check fa-3x"></i> Evaluación Técnica</a></li>
        <?php endif; ?>

        
        <?php if (!$esResponsable && in_array($rol, ['DOCENTE', 'ESTUDIANTE', 'INVITADO'])): ?>
          <li><a href="../views/dashboard_Pri_Usu.php"><i class="fa fa-user fa-3x"></i> Perfil</a></li>
          <li><a href="../views/dashboard_Eve_Usu.php"><i class="fa fa-calendar fa-3x"></i> Mis Eventos</a></li>
          <li><a href="../views/dashboard_Cer_Usu.php"><i class="fa fa-certificate fa-3x"></i> Mis Certificados</a></li>
          <li><a href="../views/dashboard_Fac_Usu.php"><i class="fa fa-file-text-o fa-3x"></i> Mis Facturas</a></li>

        <?php endif; ?>

      </ul>
    </div>
  </nav>
</div>
<script>
        function actualizarHora() {
            const opciones = {
                timeZone: "America/Guayaquil",
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            };
            const ahora = new Date().toLocaleString("es-EC", opciones);
            document.getElementById("hora").textContent = ahora;
        }
        setInterval(actualizarHora, 1000);
        actualizarHora(); 
</script>

</body>
</html>
