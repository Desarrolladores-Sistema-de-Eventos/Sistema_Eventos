<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Contáctanos</title>
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
<div class="container-fluid page-header" style="background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('../public/img/uta/about.png') center 20%/cover no-repeat; min-height: 420px; display: flex; align-items: center;">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center w-100" style="min-height: 485px;">
            <h3 class="display-4 text-white text-uppercase text-shadow" style="text-shadow: 2px 2px 8px #000, 0 1px 10px #b10024;">Contacto</h3>
            <div class="d-inline-flex text-white mt-2" style="background: rgba(0,0,0,0.25); border-radius: 8px; padding: 6px 18px;">
                <p class="m-0 text-uppercase"><a class="text-white" href="#">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Contacto</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

    <!-- Contacto/Soporte Start -->
<div class="container-fluid py-5 position-relative" style="z-index:2;">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Soporte y Ayuda</h6>
            <h1 class="mb-4">¿Necesitas ayuda? Contáctanos</h1>
            <p class="lead">Nuestro equipo de soporte está disponible para resolver tus dudas, ayudarte con el sistema y brindarte la mejor atención.</p>
        </div>
        <div class="row mb-5">
            <div class="col-md-4 text-center mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                    <div class="overlay-facultad position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(120deg, rgba(161,26,31,0.07) 0%, rgba(255,255,255,0.0) 100%); pointer-events:none; border-radius:inherit;"></div>
                    <div class="card-body position-relative">
                        <i class="fa fa-3x fa-envelope text-primary mb-3"></i>
                        <h5 class="card-title">Correo de Soporte</h5>
                        <p class="card-text mb-0">soporte@uta.edu.ec</p>
                        <small class="text-muted">Respuesta en menos de 24h</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                    <div class="overlay-facultad position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(120deg, rgba(161,26,31,0.07) 0%, rgba(255,255,255,0.0) 100%); pointer-events:none; border-radius:inherit;"></div>
                    <div class="card-body position-relative">
                        <i class="fa fa-3x fa-phone-alt text-primary mb-3"></i>
                        <h5 class="card-title">Llámanos</h5>
                        <p class="card-text mb-0">+593 3 299-8000</p>
                        <small class="text-muted">Lunes a Viernes, 8:00 - 17:00</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                    <div class="overlay-facultad position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(120deg, rgba(161,26,31,0.07) 0%, rgba(255,255,255,0.0) 100%); pointer-events:none; border-radius:inherit;"></div>
                    <div class="card-body position-relative">
                        <i class="fa fa-3x fa-map-marker-alt text-primary mb-3"></i>
                        <h5 class="card-title">Oficina de Soporte</h5>
                        <p class="card-text mb-0">Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador</p>
                        <small class="text-muted">Edificio Central, Planta Baja</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="500">
                <div class="contact-form bg-white shadow-sm rounded p-4 position-relative" style="box-shadow: 0 8px 32px 0 rgba(160,26,31,0.10), 0 1.5px 8px 0 rgba(0,0,0,0.08); background: #fff !important;">
                    <div id="success" class="position-relative"></div>
                    <h4 class="mb-4 position-relative" style="color:#a01a1f;"><i class="fa fa-headset"></i> Envíanos tu consulta</h4>
                    <form id="contactForm" method="POST" class="position-relative">
                        <div class="form-row">
                            <div class="control-group col-sm-6">
                                <input type="text" class="form-control p-4" name="name" id="name" placeholder="Tu nombre" required>
                            </div>
                            <div class="control-group col-sm-6">
                                <input type="email" class="form-control p-4" name="email" id="email" placeholder="Tu correo" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control p-4" name="subject" id="subject" placeholder="Asunto" required>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control py-3 px-4" name="message" rows="5" id="message" placeholder="¿En qué podemos ayudarte?" required></textarea>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary py-3 px-4" type="submit" id="sendMessageButton" style="background:#a01a1f; border:none;">
                                <i class="fa fa-paper-plane"></i> Enviar Mensaje
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAPA DE UBICACIÓN Y REDES SOCIALES -->
<h1 class="text-center">Ubicación</h1>
<div class="container mb-5" data-aos="fade-up" data-aos-delay="600">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="bg-white rounded shadow-sm p-0 mb-4" style="overflow:hidden;">
        <div class="ratio ratio-16x9 rounded" style="min-height:320px;">
          <iframe src="https://www.google.com/maps?q=Universidad+T%C3%A9cnica+de+Ambato&output=embed" frameborder="0" allowfullscreen style="border:0; width:100%; height:100%; min-height:320px; border-radius: 0.7rem;"></iframe>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="bg-white rounded shadow-sm py-3 px-4 mb-2 text-center" style="border: 1.5px solid #f3f3f3;">
        <p class="mb-2 fw-semibold fs-5" style="color:#222;">Síguenos en redes sociales:</p>
        <div class="d-flex justify-content-center align-items-center gap-3 fs-4">
          <a href="https://www.facebook.com/search/top?q=universidad%20t%C3%A9cnica%20de%20ambato%20-%20oficial" target="_blank" class="social-link" style="color:#a01a1f;"><i class="fab fa-facebook"></i></a>
          <a href="https://x.com/UTecnicaAmbato?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor" target="_blank" class="social-link" style="color:#a01a1f;"><i class="fab fa-twitter"></i></a>
          <a href="https://www.instagram.com/utecnicaambato/?hl=es" target="_blank" class="social-link" style="color:#a01a1f;"><i class="fab fa-instagram"></i></a>
          <a href="https://www.youtube.com/@utecnicaambato" target="_blank" class="social-link" style="color:#a01a1f;"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
.social-link {
  transition: transform 0.2s, color 0.2s;
  margin: 0 8px;
  font-size: 1.5rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.social-link:hover {
  color: #b10024 !important;
  transform: scale(1.18) translateY(-2px);
  text-shadow: 0 2px 8px rgba(160,26,31,0.10);
}
.bg-white.rounded.shadow-sm {
  background: #fffbe9 !important;
}
</style>
<!-- Contacto/Soporte End -->


   <!-- Footer Start -->
    <?php include('partials/footer.php'); ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- AOS Animate On Scroll CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
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
    <!-- AOS Animate On Scroll JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
      AOS.init({
        once: true,
        duration: 700,
        offset: 60
      });
      document.getElementById('contactForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        await fetch('../controllers/ContactoController.php', {
            method: 'POST',
            body: formData
        });
        this.reset(); 
      });
    </script>

</body>

</html>