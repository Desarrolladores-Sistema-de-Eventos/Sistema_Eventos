<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>

<!--  CSS -->


<style>
  :root {
    --uta-rojo: #8B0000; 
    --uta-rojo-hover:rgb(6, 5, 6);
    --uta-dorado: #DAA520;
    --uta-gris-claro:rgb(85, 35, 35);
    --uta-texto: #333;
  }

  .catalogo-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 3rem 1rem;
  }

  .catalogo-header {
    text-align: center;
    margin-bottom: 3rem;
  }

  .catalogo-header h2 {
    font-weight: bold;
    color: var(--uta-rojo);
    font-size: 2.6rem;
  }

  h2 {
  color: #000 !important;
}

  .catalogo-header p {
    color: var(--uta-texto);
    font-size: 1.2rem;
  }

  .catalogo-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
  }

  .catalogo-card {
    background: white;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    text-align: center;
    padding: 2.5rem 1.5rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-top: 5px solid transparent;
  }

  .catalogo-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 14px 34px rgba(0, 0, 0, 0.1);
    border-top-color: var(--uta-rojo);
  }

  .catalogo-card i {
    font-size: 3.5rem;
    margin-bottom: 1.2rem;
    color: var(--uta-dorado);
  }

  .catalogo-card a {
    display: block;
    color: var(--uta-texto);
    font-weight: 700;
    font-size: 1.3rem;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .catalogo-card a:hover {
    color: var(--uta-rojo);
  }

  @media (max-width: 576px) {
    .catalogo-card {
      padding: 1.5rem;
    }

    .catalogo-card i {
      font-size: 2.5rem;
    }

    .catalogo-card a {
      font-size: 1.1rem;
    }
  }
</style>



<div id="page-wrapper">
  <div id="page-inner">
    <div class="catalogo-container">
      <div class="catalogo-header">
        <h2><i class="fa fa-database me-2"></i> Gestión de Catálogos</h2>
        <h2 class="catalogo-descripcion">Administra los datos base que alimentan la creación de eventos académicos y su configuración institucional.</h2>
      </div>

      <div class="catalogo-grid">
        <div class="catalogo-card">
          <i class="fa fa-tag"></i>
          <a href="config_tipo_evento.php">Tipos de Evento</a>
        </div>
        <div class="catalogo-card">
          <i class="fa fa-sitemap"></i>
          <a href="config_modalidades.php">Modalidades</a>
        </div>
        <div class="catalogo-card">
          <i class="fa fa-folder-open"></i>
          <a href="config_categorias.php">Categorías</a>
        </div>
        <div class="catalogo-card">
          <i class="fa fa-university"></i>
          <a href="config_facultades.php">Facultades</a>
        </div>
        <div class="catalogo-card">
          <i class="fa fa-graduation-cap"></i>
          <a href="config_carreras.php">Carreras</a>
        </div>
        <div class="catalogo-card">
          <i class="fa fa-list-alt"></i>
          <a href="config_requisitos.php">Requisitos</a>
        </div>
        <div class="catalogo-card">
          <i class="fa fa-credit-card"></i>
          <a href="config_formas_pago.php">Formas de Pago</a>
        </div>
        <div class="catalogo-card">
          <i class="fa fa-user"></i>
          <a href="config_usuarios_roles.php">Roles de Usuario</a>
        </div>
        <div class="catalogo-card">
          <i class="fa fa-image"></i>
          <a href="config_carrusel.php">Carrusel</a>
        </div>
        <div class="catalogo-card">
          <i class="fa fa-tag"></i>
          <a href="config_autoridades.php">Autoridades</a>
        </div>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php include("partials/footer_Admin.php"); ?>
