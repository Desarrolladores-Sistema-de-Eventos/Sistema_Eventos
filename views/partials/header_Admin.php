<?php
require_once '../core/roles.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rol = strtoupper($_SESSION['usuario']['ROL'] ?? '');
$esResponsable = !empty($_SESSION['usuario']['ES_RESPONSABLE']);

// Foto de perfil robusta
$fotoPerfil = '../public/img/perfiles/default.png';
if (!empty($_SESSION['usuario']['FOTO_PERFIL'])) {
    $foto = $_SESSION['usuario']['FOTO_PERFIL'];
    if (file_exists("../public/img/perfiles/$foto") && !is_dir("../public/img/perfiles/$foto")) {
        $fotoPerfil = "../public/img/perfiles/$foto";
    }
}

// Notificaciones robustas
$notificacionesHabilitadas = false;
if ($esResponsable || in_array($rol, ['DOCENTE', 'ESTUDIANTE', 'INVITADO'])) {
    $notificacionesHabilitadas = true;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menú Administrativo</title>
  <link href="../public/img/uta/logo1.png" rel="icon">

  <link href="../public/assets/css/bootstrap.css" rel="stylesheet" />
  <link href="../public/assets/css/font-awesome.css" rel="stylesheet" />
  <link href="../public/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
  <link href="../public/assets/css/custom.css" rel="stylesheet" />
  <link href="../public/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <?php if ($notificacionesHabilitadas): ?>
    <?php if ($esResponsable): ?>
      <script src="../public/js/notificaciones_responsable.js"></script>
    <?php else: ?>
      <script src="../public/js/notificaciones_aprobacion_usuario.js"></script>
    <?php endif; ?>
  <?php endif; ?>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div id="wrapper">
  <nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
   <div class="navbar-header">
  <a class="navbar-brand" href="#" style="padding: 0; display: flex; align-items: center; height: 60px;">
    <img src="../public/img/uta/logo_UTA.png" alt="UTA Logo" style="height: 100%; width: 100%; object-fit: contain; padding: 0 8px;">
  </a>
</div>
    
 <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 50px 5px 50px;">
  <!-- Izquierda: botón de regresar solo para ciertos roles -->
  <?php if (!$esResponsable && in_array($rol, ['DOCENTE', 'ESTUDIANTE', 'INVITADO'])): ?>
    <a href="../views/Eventos_Publico.php" style="color: white; text-decoration: none; font-size: 14px;">
      <i class="fa fa-arrow-left"></i> Regresar a Home
    </a>
  <?php else: ?>
    <div></div> <!-- Espacio vacío para mantener el layout -->
  <?php endif; ?>

  <!-- Derecha: foto de perfil, notificación y botón de cerrar sesión para responsables y usuarios normales -->
  <?php if ($esResponsable): ?>
    <div style="display: flex; align-items: center; gap: 18px;">
      <div id="notificacionInscripciones" style="position: relative;">
        <i class="fa fa-bell" style="font-size: 22px; color: #fff; cursor: pointer; position: relative; z-index: 10001;"></i>
        <span id="badgeNotificacion" style="display:none; position: absolute; top: -7px; right: -7px; background: #e74c3c; color: #fff; border-radius: 50%; padding: 2px 7px; font-size: 12px; font-weight: bold; min-width: 22px; text-align: center; z-index: 10002;"></span>
        <div id="panelNotificaciones" style="display:none; position: fixed; right: 32px; top: 68px; width: 340px; background: #fff; color: #222; border-radius: 10px; box-shadow: 0 8px 32px #0003; z-index: 20000; border: 1.5px solid #d3d6db;">
          <div style="padding: 12px 16px; border-bottom: 1px solid #eee; font-weight: bold; font-size: 15px; display: flex; align-items: center; justify-content: space-between;">
            <span>Notificaciones</span>
            <i class="fa fa-check" style="color: #2ecc71;"></i>
          </div>
          <div id="listaNotificaciones" style="max-height: 320px; overflow-y: auto;"></div>
        </div>
      </div>
      <img id="fotoPerfilHeader" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de perfil" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 8px #0002;">
      <a href="../controllers/logout.php" class="btn btn-danger square-btn-adjust">Cerrar Sesión</a>
    </div>
  <?php elseif (in_array($rol, ['DOCENTE', 'ESTUDIANTE', 'INVITADO'])): ?>
    <div style="display: flex; align-items: center; gap: 18px;">
      <a href="../controllers/logout.php" class="btn btn-danger square-btn-adjust">Cerrar Sesión</a>
    </div>
  <?php else: ?>
    <div style="display: flex; align-items: center; gap: 10px;">
      <span id="hora" style="color: white; font-size: 16px;"></span>
      <a href="../controllers/logout.php" class="btn btn-danger square-btn-adjust">Cerrar Sesión</a>
    </div>
  <?php endif; ?>
</div>


  </nav>

  <nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav" id="main-menu">

          <?php if ($esResponsable): ?> 
          <li><a href="../views/dashboard_Pri_Res.php"><i class="fa fa-dashboard fa-3x"></i> Panel Principal</a></li>
          <li><a href="../views/dashboard_Eve_Res.php"><i class="fa fa-calendar fa-3x"></i> Gestión Eventos</a></li>
          <li><a href="../views/dashboard_Ins_Res.php"><i class="fa fa-users fa-3x"></i> Inscripciones</a></li>
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
          <li><a href="../views/evaluacion_tecnica.php"><i class="fa fa-check fa-3x"></i> Evaluación Técnica</a></li>
        <?php endif; ?>

        
        <?php if (!$esResponsable && in_array($rol, ['DOCENTE', 'ESTUDIANTE', 'INVITADO'])): ?>
          <li><a href="../views/dashboard_Pri_Usu.php"><i class="fa fa-user fa-3x"></i> Perfil</a></li>
          <li><a href="../views/dashboard_Fac_Usu.php"><i class="fa fa-file-text-o fa-3x"></i> Mis Inscripciones</a></li>
          <li><a href="../views/dashboard_Eve_Usu.php"><i class="fa fa-calendar fa-3x"></i> Mis Eventos</a></li>
          <li><a href="../views/dashboard_Cer_Usu.php"><i class="fa fa-certificate fa-3x"></i> Mis Certificados</a></li>
        <?php endif; ?>

      </ul>
    </div>
  </nav>
</div>

</body>
</html>
