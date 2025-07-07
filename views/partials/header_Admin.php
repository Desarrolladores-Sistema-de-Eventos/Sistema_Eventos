<?php
require_once '../core/roles.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rol = strtoupper($_SESSION['usuario']['ROL'] ?? '');
$esResponsable = !empty($_SESSION['usuario']['ES_RESPONSABLE']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menú Administrativo</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='black' d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/></svg>"

  <!-- Estilos -->
  <link href="../public/assets/css/bootstrap.css" rel="stylesheet" />
  <link href="../public/assets/css/font-awesome.css" rel="stylesheet" />
  <link href="../public/assets/css/custom.css" rel="stylesheet" />
  <link href="../public/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />

  <!-- Scripts: ORDEN IMPORTANTE -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* Definición de colores principales */
    :root {
        --uta-rojo: #b10024; /* Rojo principal de UTA */
        --uta-rojo-oscuro: #92001c; /* Tono más oscuro de rojo */
        --uta-negro: #000000;
        --uta-blanco: #ffffff;
    }

    /* SOLO CAMBIOS DE COLOR. NO SE ALTERAN TAMAÑOS NI POSICIONAMIENTOS. */

    /* Barra de navegación superior */
    .navbar-cls-top {
        background-color: var(--uta-negro) !important; /* Fondo negro */
        color: var(--uta-blanco); /* Color de texto blanco */
    }
    .navbar-brand {
        color: var(--uta-blanco) !important; /* Color de texto blanco */
    }

    /* Barra de navegación lateral */
    .navbar-default.navbar-side {
        background-color: var(--uta-negro); /* Fondo negro */
        color: var(--uta-blanco); /* Color de texto blanco */
    }
    .navbar-side .nav > li > a {
        color: var(--uta-blanco); /* Color de texto blanco para los enlaces del menú */
        border-bottom: 1px solid var(--uta-negro); /* Borde negro para separación */
    }
    .navbar-side .nav > li > a:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al pasar el ratón */
        color: var(--uta-blanco); /* Color de texto blanco al pasar el ratón */
    }

    /* Botón Cerrar Sesión */
    .square-btn-adjust {
        background-color: var(--uta-rojo) !important; /* Rojo principal de UTA */
        color: var(--uta-blanco) !important; /* Texto blanco en el botón */
    }
    .square-btn-adjust:hover {
        background-color: var(--uta-rojo-oscuro) !important; /* Rojo oscuro al pasar el ratón */
        color: var(--uta-blanco) !important; /* Texto blanco al pasar el ratón */
    }

    /* Asegurar que el texto de "Regresar a Home" sea blanco */
    a[href="../views/Eventos_Views.php"] {
        color: var(--uta-blanco) !important;
    }
    /* Asegurar que el texto de la hora sea blanco */
    #hora {
        color: var(--uta-blanco) !important;
    }

    /* No se modifican otras propiedades de layout como width, height, padding, margin, etc. */
    /* Se asume que custom.css y bootstrap.css manejan el layout general. */

  </style>
</head>
<body>
<div id="wrapper">
  <nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" style="padding: 0; display: flex; align-items: center; height: 60px;">
        <img src="../public/img/logo_UTA.png" alt="UTA Logo" style="height: 100%; width: 100%; object-fit: contain; padding: 0 8px;">
      </a>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 50px 5px 50px;">
      <?php if (!$esResponsable && in_array($rol, ['DOCENTE', 'ESTUDIANTE', 'INVITADO'])): ?>
        <a href="../views/Eventos_Views.php" style="color: white; text-decoration: none; font-size: 16px;">
          <i class="fa fa-arrow-left"></i> Regresar a Home
        </a>
      <?php else: ?>
        <div></div>
      <?php endif; ?>

      <div style="display: flex; align-items: center; gap: 10px;">
        <span id="hora" style="color: white; font-size: 16px;"></span>
        <a href="../controllers/logout.php" class="btn btn-danger square-btn-adjust">Cerrar Sesión</a>
      </div>
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
