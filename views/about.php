<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Nosotros</title>
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
</head>

<body>
    <?php include('partials/header.php'); ?>


    <!-- Header Start -->
    <div class="container-fluid page-header" style="background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('../public/img/uta/facultad1.png') center 25%/cover no-repeat; min-height: 420px; display: flex; align-items: center;">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center w-100" style="min-height: 485px;">
                <h3 class="display-4 text-white text-uppercase text-shadow" style="text-shadow: 2px 2px 8px #000, 0 1px 10px #b10024;">Nosotros</h3>
                <div class="d-inline-flex text-white mt-2" style="background: rgba(0,0,0,0.25); border-radius: 8px; padding: 6px 18px;">
                    <p class="m-0 text-uppercase"><a class="text-white" href="#">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Nosotros</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

<div class="container my-3 py-2 position-relative" data-aos="fade-up" data-aos-delay="100" style="z-index:2;">
    <div class="text-center mb-3">
        <h2 class="section-title">UNIVERSIDAD TÉCNICA DE AMBATO</h2>
    </div>
    <div class="row g-4 align-items-center">
        <div class="col-lg-6">
            <div class="ratio ratio-4x3 rounded shadow-sm overflow-hidden">
                <img src="../public/img/uta/about.png" alt="Imagen Facultad" class="w-100 h-100 object-fit-cover">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="bg-white rounded shadow p-4 position-relative" style="box-shadow: 0 8px 32px 0 rgba(160,26,31,0.10), 0 1.5px 8px 0 rgba(0,0,0,0.08);">
                <div class="overlay-facultad position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, rgba(161,26,31,0.07) 0%, rgba(255,255,255,0.0) 100%); pointer-events:none; border-radius:inherit;"></div>
                <div class="mb-4 position-relative">
                    <h2 id="facultad-nombre" class="text-uppercase fw-bold" style="color: var(--uta-rojo);"></h2>
                </div>

                <div class="card mb-3 border-0 shadow-sm position-relative">
                    <div class="card-body">
                        <h5 class="fw-bold text-uppercase" style="color: var(--uta-rojo);"><i class="fas fa-bullseye me-2"></i>Misión</h5>
                        <p id="facultad-mision" class="mb-0 text-muted"></p>
                    </div>
                </div>

                <div class="card mb-3 border-0 shadow-sm position-relative">
                    <div class="card-body">
                        <h5 class="fw-bold text-uppercase" style="color: var(--uta-rojo);"><i class="fas fa-eye me-2"></i>Visión</h5>
                        <p id="facultad-vision" class="mb-0 text-muted"></p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm position-relative">
                    <div class="card-body">
                        <h5 class="fw-bold text-uppercase" style="color: var(--uta-rojo);"><i class="fas fa-map-marker-alt me-2"></i>Ubicación</h5>
                        <p id="facultad-ubicacion" class="mb-0 text-muted"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<main class="container position-relative z-1">
    <div class="section-title" data-aos="fade-up" data-aos-delay="100" style="margin-bottom: 2.5rem;">
        <h2 class="text-center">AUTORIDADES</h2>
    </div>
    <div class="row" id="autoridades-row" data-aos="fade-up" data-aos-delay="200" style="margin-bottom: 3.5rem;">
        <!-- Autoridades se cargan dinámicamente -->
    </div>

    <div class="section-title mt-5" data-aos="fade-up" data-aos-delay="300" style="margin-bottom: 2.5rem;">
        <h2 class="text-center">CARRERAS</h2>
    </div>
    <div class="position-relative" data-aos="fade-up" data-aos-delay="400" style="margin-bottom: 2.5rem;">
        <div class="owl-carousel owl-theme" id="carreras-carousel">
            <!-- Carreras se cargan dinámicamente como slides -->
        </div>
    </div>
</main>
</style>
    <!-- AOS Animate On Scroll CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- AOS Animate On Scroll JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
      AOS.init({
        once: true,
        duration: 700,
        offset: 60
      });
    </script>


    <script src="../public/js/fisei.js"></script>
    <script src="../public/js/autoridades.js"></script>
    <script>
    // Renderizar carreras en formato de "slider tipo carrusel" con OwlCarousel
    document.addEventListener('DOMContentLoaded', function() {
        fetch('../controllers/ConfiguracionesController.php?option=carrera_fisei')
            .then(response => response.json())
            .then(data => {
                const carousel = document.getElementById('carreras-carousel');
                carousel.innerHTML = '';
                if (!Array.isArray(data)) return;
                const carrerasConImagen = data.filter(c => c.IMAGEN && c.IMAGEN.trim() !== '');
                if (carrerasConImagen.length === 0) {
                    carousel.innerHTML = "<div class='text-center w-100'>No hay carreras disponibles.</div>";
                    return;
                }
                carrerasConImagen.forEach(carrera => {
                    carousel.innerHTML += `
                        <div class="item px-2">
                            <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                                <div class="ratio ratio-4x3 bg-light">
                                    <img class="w-100 h-100 object-fit-cover" style="object-fit:cover; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;" src="../${carrera.IMAGEN}" alt="${carrera.NOMBRE_CARRERA}">
                                </div>
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                                    <i class="fa fa-graduation-cap fa-2x mb-2 text-primary"></i>
                                    <h5 class="card-title text-center mb-1" style="font-size:1.08rem; font-weight:600;">${carrera.NOMBRE_CARRERA}</h5>
                                </div>
                            </div>
                        </div>
                    `;
                });
                // Inicializar OwlCarousel
                $(carousel).owlCarousel({
                    loop: true,
                    margin: 16,
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 2000,
                    autoplayHoverPause: true,
                    smartSpeed: 500,
                    dotClass: 'owl-dot custom-dot',
                    dotsClass: 'owl-dots custom-dots',
                    responsive: {
                        0: { items: 1 },
                        576: { items: 2 },
                        992: { items: 3 },
                        1200: { items: 4 }
                    }
                });
                // Personalizar los dots con CSS institucional
                const style = document.createElement('style');
                style.innerHTML = `
                .custom-dots {
                    text-align: center;
                    margin-top: 18px;
                }
                .custom-dot {
                    display: inline-block;
                    width: 24px;
                    height: 24px;
                    margin: 0 6px;
                    border-radius: 50%;
                    border: 3px solid #a01a1f;
                    background: transparent;
                    transition: background 0.3s, border 0.3s;
                    box-sizing: border-box;
                }
                .custom-dot.active, .custom-dot:hover {
                    background: #a01a1f;
                    border-color: #a01a1f;
                }
                `;
                document.head.appendChild(style);
                // Botones personalizados
                document.querySelector('.owl-prev-custom').onclick = function() {
                    $(carousel).trigger('prev.owl.carousel');
                };
                document.querySelector('.owl-next-custom').onclick = function() {
                    $(carousel).trigger('next.owl.carousel');
                };
            });
    });
    </script>

    <!-- Footer End -->
    <!-- Footer Start -->
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

</body>

</html>