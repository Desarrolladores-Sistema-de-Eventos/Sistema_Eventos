<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Descripcion del Evento</title>
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
    <!-- Topbar -->
<div class="container-fluid bg-white py-2 border-bottom">
    <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center">
        <div class="d-flex align-items-center mb-2 mb-lg-0">
            <img src="../public/img/sello_UTA.jpg" alt="Logo Facultad" style="height: 60px; margin-right: 10px;">
            <div>
                <h6 class="mb-0 text-uppercase font-weight-bold" style="color: #660000;">FACULTAD DE INGENIERÍA EN</h6>
                <h5 class="mb-0 font-weight-bold" style="color: #660000;">SISTEMAS, ELECTRÓNICA E INDUSTRIAL</h5>
                <span class="badge badge-danger">CTT - TALLERES TECNOLÓGICOS</span>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <div class="text-center d-flex flex-column flex-md-row align-items-center mx-3">
    <i class="fas fa-user-circle text-danger fa-2x mb-2 mb-md-0 mr-md-2"></i>
    <div class="d-flex flex-column flex-md-row gap-2">
        <a href="../views/dashboard_Pri_Usu.php" class="btn btn-outline-dark btn-sm mx-1">Dashboard</a>
        <a href="../controllers/logout.php" class="btn btn-outline-danger btn-sm mx-1">Cerrar Sesión</a>
    </div>
</div>
        </div>
    </div>
</div>
  
    <!-- Blog Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Blog Detail Start -->
                    <div class="pb-3">
                        <div class="blog-item">
                            <div class="position-relative">
                                <img class="img-fluid w-100"  alt="">
                            </div>
                        </div>
                        <div class="bg-white mb-3" style="padding: 30px;">
                            <div class="d-flex mb-3">
                                <span>Fecha Inicio : </span>
                                <a class="text-primary text-uppercase text-decoration-none" id="fechaInicio"> </a>
                                <span class="px-2"> | </span>
                                <span>Fecha Fin : </span>
                                <a class="text-primary text-uppercase text-decoration-none" id="fechaFin"></a>
                            </div>
                            <h2 class="mb-3" id="tituloEvento"></h2>
                            <img class="img-fluid w-50 float-left mr-4 mb-2" id="galeriaEvento" src="">
                            <h4 class="mb-3">Descripción: </h4>
                            <p id="descripcionEvento"></p>
                            <h4 class="mb-3">Tipo de público: </h4>
                            <p id="publicoObjetivo"></p>
                            <h5 class="mb-3">Horas del Curso: </h5>
                            <p id="horasEvento"></p>
                            <h5 class="mb-3">Carrera: </h5>
                            <p id="carrera"></p>
                            <h5 class="mb-3">Modalidad: </h5>
                            <p id="modalidad"></p>
                            <h5 class="mb-3">Costo: $</h5>
                            <p id="costoEvento"></p>
                            <h5 class="mb-3">Nota de Aprobacion</h5>
                            <p id="notaAprobacion"></p>
                        </div>
                        <div class="text-center mt-4">
                            <button id="btnInscribirse" class="btn btn-primary btn-lg">Inscribirse</button>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-4 mt-5 mt-lg-0">
                    <!-- ORGANIZADOR-->
                    <div class="d-flex flex-column text-center bg-white mb-5 py-5 px-4">
                        <img id="fotoOrganizador" src="" class="img-fluid mx-auto mb-3" style="width: 100px;">
                        <h3 class="text-primary mb-3">Organizador</h3>
                        <p id="nombreOrganizador"></p>
                        <p id="correoOrganizador"></p>
                        <div class="d-flex justify-content-center">
                            <a class="text-primary px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-primary px-2" href="">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a class="text-primary px-2" href="">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>

                    <!-- DETALLES-->
                    <div class="mb-5">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Requisitos</h4>
                        <div class="bg-white" style="padding: 30px;">
                             <p class="mb-3" id="requisitosEvento"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog End -->

   <!-- Footer Start -->
   <?php include 'partials/footer.php'; ?>
    <!-- Footer End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
    <script src="../public/js/detalle.js"></script>

</body>

</html>