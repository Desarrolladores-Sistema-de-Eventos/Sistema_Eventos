<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Inicio</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="../public/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../public/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../public/css/style.css" rel="stylesheet">
    
<style>

    :root {
    --uta-rojo: #b10024;
    --uta-negro: #1a1a1a;
    --uta-gris: #f8f9fa;
    --uta-blanco: #ffffff;
    --uta-hover: #90001d;
}
/* ======================
   Tarjetas de Eventos
   ====================== */
.evento-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.evento-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15);
}

/* Imagen */
.evento-imagen {
  position: relative;
  height: 180px;
  overflow: hidden;
}

.evento-imagen img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease-in-out;
}

.evento-card:hover .evento-imagen img {
  transform: scale(1.1);
}

/* Overlay con botón */
.evento-overlay {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background: rgba(0,0,0,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: 0.3s ease-in-out;
}

.evento-card:hover .evento-overlay {
  opacity: 1;
}

.btn-ver-mas {
  background: var(--uta-rojo);
  color: #fff;
  padding: 6px 18px;
  border-radius: 20px;
  font-weight: 600;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border: none;
}

.btn-ver-mas:hover {
  background: var(--uta-hover);
}

/* Contenido */
.evento-contenido {
  padding: 18px 16px;
  flex-grow: 1;
}

.evento-tipo {
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--uta-negro);
  text-transform: uppercase;
  margin-bottom: 4px;
  display: inline-block;
}

.evento-titulo {
  font-size: 1.1rem;
  font-weight: 700;
  color: var(--uta-rojo);
  margin-bottom: 10px;
}



/* Footer */


.evento-info i {
  color: var(--uta-rojo);
  margin-right: 4px;
}

.evento-precio {
  font-weight: bold;
  color: var(--uta-rojo);
  font-size: 1rem;
}


</style>

    
</head>

<body style="background: #fdfce9 !important; min-height: 100vh;">
<?php
require_once '../models/CarruselModelo.php';
$modeloCarrusel = new CarruselModelo();
$imagenesCarrusel = $modeloCarrusel->obtenerCarruselPublico(); 
?>
<?php include('partials/header.php'); ?>
        <!-- Carousel Start -->
        <div class="container-fluid p-0">
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($imagenesCarrusel as $i => $img): ?>
                    <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                        <img class="w-100" src="../<?= $img['URL_IMAGEN'] ?>" alt="Carrusel <?= $i ?>" style="height: 500px; object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 900px;">
                                <h4 class="text-white text-uppercase mb-md-3 fw-bold" style="letter-spacing:2px; text-shadow:2px 2px 8px #000,0 1px 10px #b10024; font-size:2.5rem;">
                                    <?= htmlspecialchars($img['TITULO']) ?>
                                </h4>
                                <h1 class="display-3 text-white mb-md-4 fw-bold" style="text-shadow:2px 2px 8px #000,0 1px 10px #b10024; font-size:3.5rem; letter-spacing:1.5px;">
                                    <?= htmlspecialchars($img['DESCRIPCION']) ?>
                                </h1>
                                <a href="../views/Eventos_Publico.php" class="btn btn-primary py-md-3 px-md-5 mt-2">Ver más</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n2"></span>
                    </div>
                </a>
                <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n2"></span>
                    </div>
                </a>
            </div>
        </div>
        <!-- Carousel End -->
     
<!-- Sobre Nosotros Start-->
 <div data-aos="fade-up" data-aos-delay="100">
<section class="py-4" style="background-color: #fafafa;">

  <div class="container">
    <div class="row align-items-center">
      <!-- Imagen -->
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="../public/img/uta/promocion.png" class="img-fluid rounded shadow" alt="Promoción UTA">
      </div>

      <!-- Texto -->
      <div class="col-md-6">
        <div class="p-4 bg-white rounded shadow-sm border-start border-4 border-danger">
          <h6 class="text-danger text-uppercase fw-bold mb-2" style="letter-spacing: 2px;">Sobre Nosotros</h6>
          <h2 class="fw-bold mb-3">El inicio de una nueva forma de aprendizaje</h2>
          <p id="facultad-about" class="text-muted" style="text-align: justify;">
            [Cargando descripción de la facultad...]
          </p>
          <a href="../views/about.php" class="btn btn-danger mt-3 px-4 py-2 shadow-sm">
            <i class="fas fa-info-circle me-2"></i> Ver más
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Sobre Nosotros End-->


    <!-- Eventos Destacados Start -->
     <div data-aos="fade-up" data-aos-delay="100">
         <div class="container-fluid py-4" style="background-color: #fafafa;">

              <div class="container">
                <div class="text-center mb-5">
                    <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">DESTACADOS</h6>

                    <h2 class="fw-bold text-dark">Eventos Académicos Recientes</h2>

                </div>
            
            <?php
            require_once '../controllers/EventosDestacadosController.php';
            
            $controller = new EventosDestacadosController();
            $eventos = $controller->obtenerEventosDestacados();
            
            
            if (count($eventos) > 0) {
            ?>
            <div class="owl-carousel owl-theme eventos-carousel">
                <?php foreach ($eventos as $evento) {
                    $fecha = date('d/m/Y', strtotime($evento['FECHAINICIO']));
                    $precio = $evento['COSTO'] > 0 ? '$' . number_format($evento['COSTO'], 2) : 'GRATIS';
                    // Limpiar etiquetas HTML para el resumen, pero mostrar formato en el detalle
                    $descripcionPlano = strip_tags($evento['DESCRIPCION']);
                    $descripcion = strlen($descripcionPlano) > 100 ? 
                                  substr($descripcionPlano, 0, 100) . '...' : 
                                  $descripcionPlano;
                ?>
                <div class="item">
                    <div class="evento-card">
                        <?php if ($evento['PORTADA']) { ?>
                        <div class="evento-imagen">
                            <img src="../public/img/eventos/portadas/<?= $evento['PORTADA'] ?>" alt="<?= htmlspecialchars($evento['TITULO']) ?>">
                            <div class="evento-overlay">
                                <a href="../public/index.php?view=login" class="btn-ver-mas">Ver más</a>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <div class="evento-contenido">
                            <span class="evento-tipo"><?= htmlspecialchars($evento['TIPO_EVENTO']) ?></span>
                            <h3 class="evento-titulo"><?= htmlspecialchars($evento['TITULO']) ?></h3>
                            <p class="evento-descripcion"><?= htmlspecialchars($descripcion) ?></p>
                            <div class="evento-footer">
                                <div class="evento-info">
                                    <small><i class="fa fa-calendar"></i> <?= $fecha ?></small><br>
                                    <small><i class="fa fa-clock"></i> <?= $evento['HORAS'] ?> horas</small>
                                </div>
                                <div class="evento-precio"><?= $precio ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } else { ?>
            <div class="text-center">
                <p class="text-muted">No hay eventos destacados disponibles.</p>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- Eventos Destacados End -->

    <!-- Footer Start -->
     <div data-aos="fade-up" data-aos-delay="100">
     <?php include('partials/footer.php'); ?>
    <!-- Footer End -->

   
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../public/lib/easing/easing.min.js"></script>
    <script src="../public/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../public/lib/tempusdominus/js/moment.min.js"></script>
    <script src="../public/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../public/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Animate On Scroll -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
    AOS.init();
    </script>


    <!-- Contact Javascript File -->
    <script src="../public/mail/jqBootstrapValidation.min.js"></script>
    <script src="../public/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../public/js/main.js"></script>
    <script src="../public/js/fisei.js"></script>


    <!-- Eventos Destacados Javascript -->
    <script src="../public/js/eventos-destacados.js"></script>
</body>

</html>