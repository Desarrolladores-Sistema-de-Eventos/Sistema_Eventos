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
    /* Estilos para el carrusel de eventos destacados */
    .eventos-carousel {
        position: relative;
        padding: 0 20px;
        margin: 0 auto;
    }
    
    .eventos-carousel .owl-stage-outer {
        overflow: hidden;
    }
    
    .evento-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 15px;
        height: 400px;
        display: flex;
        flex-direction: column;
    }
    
    .evento-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .evento-imagen {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    
    .evento-imagen img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .evento-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .evento-imagen:hover .evento-overlay {
        opacity: 1;
    }
    
    .evento-imagen:hover img {
        transform: scale(1.1);
    }
    
    .btn-ver-mas {
        background: #dc3545;
        color: white;
        padding: 12px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
        border: 2px solid #dc3545;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .btn-ver-mas:hover {
        background: white;
        color: #dc3545;
        text-decoration: none;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }
    
    .evento-contenido {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .evento-tipo {
        background: #dc3545;
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        align-self: flex-start;
        margin-bottom: 10px;
    }
    
    .evento-titulo {
        color: #333;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        line-height: 1.3;
    }
    
    .evento-descripcion {
        color: #666;
        font-size: 14px;
        line-height: 1.5;
        flex: 1;
        margin-bottom: 15px;
    }
    
    .evento-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-top: 1px solid #eee;
        padding-top: 15px;
    }
    
    .evento-info small {
        color: #999;
        display: block;
        margin-bottom: 2px;
    }
    
    .evento-precio {
        color: #dc3545;
        font-weight: bold;
        font-size: 16px;
    }
    
    /* Puntos indicadores */
    .eventos-carousel .owl-dots {
        text-align: center;
        margin-top: 30px;
    }
    
    .eventos-carousel .owl-dots .owl-dot {
        display: inline-block;
        margin: 0 5px;
    }
    
    .eventos-carousel .owl-dots .owl-dot span {
        width: 12px;
        height: 12px;
        background: #ddd;
        border-radius: 50%;
        display: block;
        transition: all 0.3s ease;
    }
    
    .eventos-carousel .owl-dots .owl-dot.active span,
    .eventos-carousel .owl-dots .owl-dot:hover span {
        background: #dc3545;
        transform: scale(1.3);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .evento-card {
            height: auto;
            margin: 10px 5px;
        }
        
        .eventos-carousel {
            padding: 0 15px;
        }
    }
    
    @media (max-width: 480px) {
        .eventos-carousel {
            padding: 0 10px;
        }
    }
    </style>
</head>

<body>
<?php include('partials/header.php'); ?>
<!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="img/carrusel.jpg" alt="Image" style="height: 500px; object-fit: cover;">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase mb-md-3">EVENTOS ACADÉMICOS DE TODO TIPO</h4>
                            <h1 class="display-3 text-white mb-md-4">Disponibilidad para todas las personas que deseen expandir sus conocimientos</h1>
                            <a href="" class="btn btn-primary py-md-3 px-md-5 mt-2">Ver más</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="img/carrusel4.jpg" alt="Image" style="height: 500px; object-fit: cover;">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase mb-md-3">CURSOS BÁSICOS Y AVANZADOS</h4>
                            <h1 class="display-3 text-white mb-md-4">Enseñanza y aprendizaje óptimo de programación con cursos escalables</h1>
                            <a href="" class="btn btn-primary py-md-3 px-md-5 mt-2">Ver más</a>
                        </div>
                    </div>
                </div>
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
    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5">
            <div class="row">
                <div class="col-lg-6" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-75 h-50" src="img/promocion.png" style="object-fit: contain;">
                    </div>
                </div>
                <div class="col-lg-6 pt-5 pb-lg-5">
                    <div class="about-text bg-white p-4 p-lg-5 my-lg-5">
                        <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">SOBRE NOSOTROS</h6>
                        <h1 class="mb-3">El inicio de una nueva forma de aprendizaje</h1>
                        <p style="text-align: justify;">El 20 de octubre de 2002 se crea el Centro de Transferencia y Desarrollo de Tecnologías mediante resoluión 1452-2002-CU-P en las áreas de Ingenierías en Sistemas, Electrónica e Industrial de la
                            Universidad Técnica de Ambato, para proveer servicios a la comunidad mediante la realización de trabajos y proyectos especificos, asesorias, estudios, investigaciones, cursos de entrenamiento, seminarios y otras actividades de servicios
                         a los sectores sociales y productivos en las áreas de ingeniería en Sistemas computacionales e informáticos, ingeniería Electrónica y Comunícaciones e Ingeniería Industrial en Procesos de automatización.</p>
                        </p>
                        <a href="../views/about.php" class="btn btn-primary mt-1">Ver más</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Eventos Destacados Start -->
    <div class="container-fluid py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">DESTACADOS</h6>
                <h1>Eventos Más Populares</h1>
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

    <!-- Feature Start -->
 <div class="container-fluid pb-5">
    <div class="container pb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="d-flex mb-4 mb-lg-0">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3" style="height: 100px; width: 100px;">
                        <i class="fa fa-2x fa-money-check-alt text-white"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <h5>Pagos Seguros</h5>
                        <p class="m-0">Tus transacciones están protegidas con los más altos estándares de seguridad.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex mb-4 mb-lg-0">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3" style="height: 100px; width: 100px;">
                        <i class="fa fa-2x fa-award text-white"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <h5>Atención Personalizada</h5>
                        <p class="m-0">Nuestro equipo está disponible para ayudarte en cada paso del proceso.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex mb-4 mb-lg-0">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3" style="height: 100px; width: 100px;">
                        <i class="fa fa-2x fa-globe text-white"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <h5>Cobertura Nacional</h5>
                        <p class="m-0">Ofrecemos servicios en todo el país para tu comodidad y confianza.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Feature End -->
    <!-- Team Start -->

     <?php include('partials/footer.php'); ?>
   
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

    <!-- Contact Javascript File -->
    <script src="../public/mail/jqBootstrapValidation.min.js"></script>
    <script src="../public/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../public/js/main.js"></script>
    
    <!-- Eventos Destacados Javascript -->
    <script src="../public/js/eventos-destacados.js"></script>
</body>

</html>