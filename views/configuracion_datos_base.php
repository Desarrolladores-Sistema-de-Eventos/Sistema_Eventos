<?php include("partials/header_Admin.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
  .titulo-catalogo {
    text-align: center;
    color: #c9302c;
    font-size: 36px;
    font-weight: bold;
    margin-top: 30px;
  }

  .subtitulo-catalogo {
    text-align: center;
    color: #777;
    font-size: 16px;
    margin-bottom: 40px;
  }

  .catalogo-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
    max-width: 900px;
    margin: 0 auto;
  }

  .catalogo-item {
    text-align: center;
    transition: transform 0.2s ease;
  }

  .catalogo-item:hover {
    transform: translateY(-6px);
  }

  .catalogo-item i {
    font-size: 4rem;
    margin-bottom: 12px;
  }

  .catalogo-item a {
    display: block;
    text-decoration: none;
    color: #337ab7;
    font-weight: 500;
  }

  @media (max-width: 991px) {
    .catalogo-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 576px) {
    .catalogo-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<div id="page-wrapper" style="margin-left: 260px; padding: 30px;">
  <div class="titulo-catalogo">
    <i class="fa fa-database"></i> Gestión de Catálogos
  </div>
  <p class="subtitulo-catalogo">
    Administra los datos base que alimentan la creación de eventos.
  </p>

  <div class="catalogo-grid mt-5">
    <div class="catalogo-item">
      <i class="fa fa-tag text-primary"></i>
      <a href="config_tipo_evento.php">Tipos de Evento</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-sitemap text-success"></i>
      <a href="config_modalidades.php">Modalidades</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-folder-open text-warning"></i>
      <a href="config_categorias.php">Categorías</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-university text-info"></i>
      <a href="config_facultades.php">Facultades</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-graduation-cap text-secondary"></i>
      <a href="config_carreras.php">Carreras</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-list-alt text-danger"></i>
      <a href="config_requisitos.php">Requisitos</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-credit-card text-primary"></i>
      <a href="config_formas_pago.php">Formas de Pago</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-user-shield text-info"></i>
      <a href="config_usuarios_roles.php">Roles de Usuario</a>
    </div>
  </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
