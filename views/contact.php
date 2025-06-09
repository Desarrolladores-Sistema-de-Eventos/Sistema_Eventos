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
<div class="container-fluid page-header">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">Contacto</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Contacto</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

    <!-- Contacto/Soporte Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Soporte y Ayuda</h6>
            <h1 class="mb-4">¿Necesitas ayuda? Contáctanos</h1>
            <p class="lead">Nuestro equipo de soporte está disponible para resolver tus dudas, ayudarte con el sistema y brindarte la mejor atención.</p>
        </div>
        <div class="row mb-5">
            <div class="col-md-4 text-center mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <i class="fa fa-3x fa-envelope text-primary mb-3"></i>
                        <h5 class="card-title">Correo de Soporte</h5>
                        <p class="card-text mb-0">soporte@uta.edu.ec</p>
                        <small class="text-muted">Respuesta en menos de 24h</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <i class="fa fa-3x fa-phone-alt text-primary mb-3"></i>
                        <h5 class="card-title">Llámanos</h5>
                        <p class="card-text mb-0">+593 3 299-8000</p>
                        <small class="text-muted">Lunes a Viernes, 8:00 - 17:00</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <i class="fa fa-3x fa-map-marker-alt text-primary mb-3"></i>
                        <h5 class="card-title">Oficina de Soporte</h5>
                        <p class="card-text mb-0">Av. Los Chasquis y Río Guayllabamba, Ambato, Ecuador</p>
                        <small class="text-muted">Edificio Central, Planta Baja</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form bg-white shadow-sm rounded p-4">
                    <div id="success"></div>
                    <h4 class="mb-4 text-primary"><i class="fa fa-headset"></i> Envíanos tu consulta</h4>
                    <form id="contactForm" method="POST">
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
        <button class="btn btn-primary py-3 px-4" type="submit" id="sendMessageButton">
            <i class="fa fa-paper-plane"></i> Enviar Mensaje
        </button>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contacto/Soporte End -->


   <!-- Footer Start -->
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

    <!-- Contact Javascript File -->
    <script src="../public/mail/jqBootstrapValidation.min.js"></script>
    <script src="../public/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../public/js/main.js"></script>
    <script>
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