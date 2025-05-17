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
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div id="wrapper">
  <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand" href="dashboard.php">Administrador</a> 
    </div>
    <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">
      Last access : 30 May 2014 &nbsp;
      <a href="#" class="btn btn-danger square-btn-adjust">Logout</a>
    </div>
  </nav>
  <nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav" id="main-menu">
        <li class="text-center">
          <img src="../public/assets/img/find_user.png" class="user-image img-responsive" />
        </li>
        <li><a href="dashboard_page.php"><i class="fa fa-dashboard fa-3x"></i> Panel Principal</a></li>
        <li><a href="eventos_page.php"><i class="fa fa-calendar fa-3x"></i> Eventos</a></li>
        <li><a href="#"><i class="fa fa-users fa-3x"></i> Usuarios</a></li>
        <li><a href="#"><i class="fa fa-edit fa-3x"></i> Inscripciones</a></li>
        <li><a href="#"><i class="fa fa-file-text fa-3x"></i> Reportes</a></li>
        <li>
          <a href="#"><i class="fa fa-gear fa-3x"></i> Configuraciones del sistema <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li>
              <a href="#">Configurar Eventos <span class="fa arrow"></span></a>
              <ul class="nav nav-third-level">
                <li><a href="#">Tipos de Evento</a></li>
                <li><a href="#">Modalidades</a></li>
                <li><a href="#">Categorías</a></li>
                <li><a href="#">Requisitos</a></li>
                <li><a href="#">Organizadores</a></li>
              </ul>
            </li>
            <li>
              <a href="#">Configurar Usuarios <span class="fa arrow"></span></a>
              <ul class="nav nav-third-level">
                <li><a href="#">Roles</a></li>
                <li><a href="#">Facultades</a></li>
                <li><a href="#">Carreras</a></li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
