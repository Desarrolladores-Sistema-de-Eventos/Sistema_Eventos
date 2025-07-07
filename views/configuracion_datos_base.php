<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>


<style>
  .titulo-catalogo {
  position: relative;
    font-size: 24px;
    color: rgb(23, 23, 23);
    font-weight: bold;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
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
    color:rgb(0, 0, 0);
    font-weight: 500;
  }
     .catalogo-item i {
      font-size: 5rem !important;
      color: #111 !important;
      transition: color 0.2s;
    }
    .catalogo-item:hover i {
      color: #8B0000 !important; /* rojo oscuro UTA */
    }

    /* Línea roja UTA debajo del título del catálogo */
.linea-roja-uta {
  position: absolute;
  left: 0;
  bottom: -8px;
  width: 100%;
  height: 8px;
  background: #ae0c22;
  border-radius: 3px;
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



<div id="page-wrapper">
  <div id="page-inner">
  <div class="titulo-catalogo">
    <i class="fa fa-cog"></i> Configuración del Sistema
    <div class="linea-roja-uta"></div>
  </div>
  <p class="subtitulo-catalogo">
    Administra los datos base que alimentan la creación de eventos.
  </p>
  <div class="catalogo-grid mt-5">
    <div class="catalogo-item">
      <i class="fa fa-tag" style="font-size:6rem;"></i>
      <a href="config_tipo_evento.php">Tipos de Evento</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-sitemap" style="font-size:6rem;"></i>
      <a href="config_modalidades.php">Modalidades</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-folder-open" style="font-size:6rem;"></i>
      <a href="config_categorias.php">Categorías</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-university" style="font-size:6rem;"></i>
      <a href="config_facultades.php">Facultades</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-graduation-cap" style="font-size:6rem;"></i>
      <a href="config_carreras.php">Carreras</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-list-alt" style="font-size:6rem;"></i>
      <a href="config_requisitos.php">Requisitos</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-credit-card" style="font-size:6rem;"></i>
      <a href="config_formas_pago.php">Formas de Pago</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-user" style="font-size:6rem;"></i>
      <a href="config_usuarios_roles.php">Roles</a>
    </div>
    <div class="catalogo-item">
      <i class="fa fa-image" style="font-size:6rem;"></i>
      <a href="config_carrusel.php">Carrusel Institucional</a>
  </div>
  <div class="catalogo-item">
      <i class="fa fa-users" style="font-size:6rem;"></i>
      <a href="config_autoridades.php">Autoridades</a>
  </div>

</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php include("partials/footer_Admin.php"); ?>
