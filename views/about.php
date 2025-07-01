<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Nosotros</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <style>
    /* Colores UTA */
:root {
    --uta-rojo: #ae0c22;
    --uta-negro: #1a1a1a;
    --uta-gris: #f5f5f5;
    --uta-blanco: #ffffff;
}

/* Página Nosotros */
.page-header {
    background-color: var(--uta-rojo);
    color: var(--uta-blanco);
}

.page-header .display-4 {
    font-weight: 700;
    text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
}

.page-header a {
    color: var(--uta-blanco);
    text-decoration: underline;
}

.about-text {
    background-color: var(--uta-blanco);
    border-left: 6px solid var(--uta-rojo);
    border-radius: 10px;
}

.card {
    border: none;
    border-left: 4px solid var(--uta-rojo);
    background-color: var(--uta-gris);
}

.card h5 {
    font-weight: 600;
    color: var(--uta-rojo);
}

.card i {
    margin-right: 8px;
    color: var(--uta-rojo);
}

/* FISEI Title Section */
.text-primary {
    color: var(--uta-rojo) !important;
}

.back-to-top {
    background-color: var(--uta-rojo);
    border: none;
}

.back-to-top:hover {
    background-color: #8e0b1c;
}
    </style>
    
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
                <h3 class="display-4 text-white text-uppercase">Nosotros</h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Nosotros</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

   <!-- About Start -->
<div class="container-fluid py-5">
    <div class="container pt-5">
        <div class="row">
            <div class="col-lg-6" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <img class="position-absolute w-100 h-100" src="../public/img/about.png" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 pt-5 pb-lg-5">
                <div class="about-text bg-white p-4 p-lg-5 my-lg-5">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h2 id="facultad-nombre" class="mb-3 text-primary"></h2>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="text-primary"><i class="fa fa-bullseye"></i> Misión</h5>
                            <p id="facultad-mision" class="mb-0"></p>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="text-primary"><i class="fa fa-eye"></i> Visión</h5>
                            <p id="facultad-vision" class="mb-0"></p>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="text-primary"><i class="fa fa-map-marker-alt"></i> Ubicación</h5>
                            <p id="facultad-ubicacion" class="mb-0"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">UTA</h6>
                <h1>Facultad de Ingeniería en Sistemas, Electrónica e Industrial</h1>
            </div>
            <div class="row"  id="autoridades-row" >
                
            </div>
        </div>
    </div>
    <!-- Team End -->
    <script src="../public/js/autoridades.js"></script>

    <!-- Footer Start -->
     <script src="../public/js/fisei.js"></script>
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

</body>

</html>

