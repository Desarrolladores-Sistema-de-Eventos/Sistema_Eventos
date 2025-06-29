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
    <?php include 'partials/header.php'; ?>

    <!-- Header Start -->
    <div class="container-fluid page-header">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
                <h3 class="display-4 text-white text-uppercase" id="tipoEvento"></h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="#">Eventos Académicos</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Blog Start -->
     <div class="container-fluid py-5" style="background-color: #fcfbe7;">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <div class="mb-4">
                            <img class="img-fluid rounded w-100" id="galeriaEvento" alt="Imagen del evento">
                        </div>

                        <h2 class="mb-3 text-dark font-weight-bold" id="tituloEvento"></h2>
                        <p id="descripcionEvento" class="mb-4 text-muted"></p>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6><i class="fas fa-calendar-alt text-danger"></i> Fecha de Inicio:</h6>
                                <p id="fechaInicio"></p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-calendar-check text-danger"></i> Fecha de Finalización:</h6>
                                <p id="fechaFin"></p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6><i class="fas fa-clock text-danger"></i> Horas:</h6>
                                <p id="horasEvento"></p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-graduation-cap text-danger"></i> Carrera:</h6>
                                <p id="carrera"></p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6><i class="fas fa-laptop text-danger"></i> Modalidad:</h6>
                                <p id="modalidad"></p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-dollar-sign text-danger"></i> Costo:</h6>
                                <p id="costoEvento"></p>
                            </div>
                        </div>

                        <h6><i class="fas fa-check-circle text-danger"></i> Nota de Aprobación:</h6>
                        <p id="notaAprobacion"></p>

                        <h6><i class="fas fa-users text-danger"></i> Tipo de Público:</h6>
                        <p id="publicoObjetivo"></p>

                        <div class="text-center mt-4">
                            <button id="btnInscribirse" class="btn btn-danger btn-lg">Inscribirse</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="card text-center shadow-sm mb-4">
                        <div class="card-body">
                            <img id="fotoOrganizador" src="" class="img-fluid rounded-circle mb-3" style="width: 100px;">
                            <h5 class="text-danger font-weight-bold">Organizador</h5>
                            <p id="nombreOrganizador" class="mb-1"></p>
                            <p id="correoOrganizador" class="text-muted small"></p>
                            <div class="d-flex justify-content-center mt-2">
                                <a class="text-danger px-2" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="text-danger px-2" href="#"><i class="fab fa-instagram"></i></a>
                                <a class="text-danger px-2" href="#"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0">Requisitos</h6>
                        </div>
                        <div class="card-body">
                            <div id="requisitosEvento"></div>
                        </div>
                    </div>
                    <!-- Contenido del Evento -->
                     <div class="card shadow-sm mt-4">
                        <div class="card-header text-white">
                            <h6 class="mb-0">Contenido</h6>
                        </div>
                    <div class="card-body">
                        <div id="contenidoEvento" class="text-justify"></div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Blog End -->

    <?php include 'partials/footer.php'; ?>

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
