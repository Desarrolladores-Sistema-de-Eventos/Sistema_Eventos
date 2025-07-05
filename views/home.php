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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    
<style>
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

.evento-descripcion {
  font-size: 0.9rem;
  color: #333;
  margin-bottom: 12px;
}

/* Footer */
.evento-footer {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  font-size: 0.85rem;
  margin-top: auto;
  border-top: 1px solid #eee;
  padding-top: 12px;
}

.evento-info i {
  color: var(--uta-rojo);
  margin-right: 4px;
}

.evento-precio {
  font-weight: bold;
  color: var(--uta-rojo);
  font-size: 1rem;
}


/* ============================
   UNIVERSIDAD TÉCNICA DE AMBATO
   Estilo Institucional Global
   ============================ */

:root {
    --uta-rojo: #b10024;
    --uta-negro: #1a1a1a;
    --uta-gris: #f8f9fa;
    --uta-blanco: #ffffff;
    --uta-hover: #90001d;
}

* {
    box-sizing: border-box;
    scroll-behavior: smooth;
}

body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background-color: var(--uta-blanco);
    color: var(--uta-negro);
}

h1, h2, h3, h4, h5, h6 {
    font-weight: 700;
    color: var(--uta-rojo);
    margin-bottom: 1rem;
}

a {
    text-decoration: none;
    color: var(--uta-rojo);
    transition: 0.3s;
}

a:hover {
    color: var(--uta-hover);
}

/* ====================
   Botón Institucional
   ==================== */
.btn-uta {
    background-color: var(--uta-rojo);
    color: white;
    font-weight: 600;
    padding: 10px 25px;
    border-radius: 30px;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9rem;
}

.btn-uta:hover {
    background-color: var(--uta-hover);
    color: white;
    transform: translateY(-2px);
}

/* ====================
   Secciones Generales
   ==================== */
section {
    padding: 60px 0;
}

.bg-light-uta {
    background-color: var(--uta-gris);
}

.shadow-sm {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04) !important;
}

/* ==========================
   Títulos de Sección
   ========================== */
.section-title {
    text-align: center;
    margin-bottom: 3rem;
}

.section-title h2 {
    font-size: 2rem;
    text-transform: uppercase;
    position: relative;
    display: inline-block;
    color: var(--uta-negro);
}

.section-title h2::after {
    content: '';
    width: 60px;
    height: 4px;
    background-color: var(--uta-rojo);
    display: block;
    margin: 8px auto 0;
}

/* ====================
   Imagenes
   ==================== */
.img-fluid {
    max-width: 100%;
    height: auto;
}

.object-fit-cover {
    object-fit: cover;
}

.rounded {
    border-radius: 10px !important;
}

.shadow {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08) !important;
}

/* ====================
   Footer
   ==================== */
footer {
    background-color: var(--uta-negro);
    color: var(--uta-blanco);
    padding-top: 40px;
    padding-bottom: 20px;
}

footer a {
    color: var(--uta-blanco);
}

footer a:hover {
    color: var(--uta-rojo);
}

footer .text-uta {
    color: var(--uta-rojo);
}

footer hr {
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

footer i {
    margin-right: 6px;
    color: #ffdddd;
}

/* ====================
   Back to Top Button
   ==================== */
.back-to-top {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 99;
    background-color: var(--uta-rojo);
    color: white;
    border: none;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.back-to-top:hover {
    background-color: var(--uta-hover);
}

/* ====================
   Carrusel general
   ==================== */
.carousel-caption h4,
.carousel-caption h1 {
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7);
}

/* ====================
   Responsive
   ==================== */
@media (max-width: 768px) {
    h1, h2 {
        font-size: 1.5rem;
    }

    .btn-uta {
        font-size: 0.85rem;
        padding: 8px 20px;
    }

    .section-title h2::after {
        width: 40px;
    }
}

</style>

    
</head>

<body>
<?php include('partials/header.php'); ?>
    <!-- Carousel Start -->
    <?php
require_once '../models/CarruselModelo.php';
$modeloCarrusel = new CarruselModelo();
$imagenesCarrusel = $modeloCarrusel->obtenerCarruselPublico(); 
?>

        <!-- Carousel Start -->
            <div class="container-fluid p-0 mb-4">
            <?php if (!empty($imagenesCarrusel)) : ?>
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <!-- Indicadores -->
                <ol class="carousel-indicators">
                    <?php foreach ($imagenesCarrusel as $i => $img): ?>
                        <li data-target="#header-carousel" data-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>"></li>
                    <?php endforeach; ?>
                </ol>

                <!-- Slides -->
                <div class="carousel-inner">
                    <?php foreach ($imagenesCarrusel as $i => $img): ?>
                    <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                        <img class="w-100 rounded-3" src="../<?= $img['URL_IMAGEN'] ?>" alt="Carrusel <?= $i ?>" style="height: 500px; object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-4" style="max-width: 800px; background: rgba(0, 0, 0, 0.0);">
                                <h4 class="text-warning text-uppercase mb-2"><?= htmlspecialchars($img['TITULO']) ?></h4>
                                <h1 class="text-white mb-3 display-5"><?= htmlspecialchars($img['DESCRIPCION']) ?></h1>
                                <a href="../views/Eventos_Publico.php" class="btn-uta">Ver más</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Controles -->
                <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                    <div class="btn btn-dark d-flex align-items-center justify-content-center rounded-circle" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n1"></span>
                    </div>
                </a>
                <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                    <div class="btn btn-dark d-flex align-items-center justify-content-center rounded-circle" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n1"></span>
                    </div>
                </a>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <h4 class="text-muted">No hay imágenes en el carrusel.</h4>
            </div>
            <?php endif; ?>
        </div>
        <!-- Carousel End -->
     
<!-- Sobre Nosotros Start-->
 <div data-aos="fade-up" data-aos-delay="100">
<section class="py-4" style="background-color: #fafafa;">

  <div class="container">
    <div class="row align-items-center">
      <!-- Imagen -->
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="img/promocion.png" class="img-fluid rounded shadow" alt="Promoción UTA">
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
                    $descripcion = strlen($evento['DESCRIPCION']) > 100 ? 
                                  substr($evento['DESCRIPCION'], 0, 100) . '...' : 
                                  $evento['DESCRIPCION'];
                ?>
                <div class="item">
                    <div class="evento-card">
                        <?php if ($evento['PORTADA']) { ?>
                        <div class="evento-imagen">
                            <img src="../documents/<?= $evento['PORTADA'] ?>" alt="<?= htmlspecialchars($evento['TITULO']) ?>">
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