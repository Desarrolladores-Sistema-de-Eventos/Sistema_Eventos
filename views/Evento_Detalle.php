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
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<style>
    /* Colores personalizados UTA */
    :root {
        --uta-rojo: #b10024;
        --uta-rojo-oscuro: #92001c;
        --uta-dorado: #DAA520;
        --uta-gris-suave: #f8f9fa;
        --uta-gris-texto: #6c757d;
    }

    .text-primary-custom {
        color: var(--uta-rojo);
    }

    .highlight {
        color: var(--uta-dorado);
    }

    .section-title {
        color: var(--uta-rojo);
        font-weight: bold;
    }

    .btn-custom {
        background-color: var(--uta-rojo);
        color: #fff;
        border: none;
    }

    .btn-custom:hover {
        background-color: var(--uta-rojo-oscuro);
    }

    .card-header-custom {
        background-color: var(--uta-rojo);
        color: white;
    }

    .rounded-circle {
        border: 2px solid var(--uta-dorado);
    }

    .text-muted-custom {
        color: var(--uta-gris-texto);
    }

    .bg-light-custom {
        background-color: var(--uta-gris-suave);
    }

    /* Botón secundario */
    .btn-outline-custom {
        border: 1px solid var(--uta-rojo);
        color: var(--uta-rojo);
        background-color: transparent;
    }

    .btn-outline-custom:hover {
        background-color: var(--uta-rojo);
        color: white;
    }

    /* Bordes suaves */
    .shadow-uta {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }

    /* Títulos secundarios */
    h6.text-uta-sub {
        color: var(--uta-dorado);
        font-weight: 600;
    }
</style>

</head>

<body>
<?php include 'partials/header.php'; ?>



<!-- Blog Start -->
<div class="container-fluid py-5 bg-light-custom">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="bg-white p-4 rounded shadow-sm">
                    <div class="mb-4">
                        <img class="img-fluid rounded w-100" id="galeriaEvento" alt="Imagen del evento">
                    </div>

                    <h2 class="mb-3 section-title" id="tituloEvento"></h2>
                    <p id="descripcionEvento" class="mb-4 text-muted-custom"></p>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6><i class="fas fa-calendar-alt highlight"></i> Fecha de Inicio:</h6>
                            <p id="fechaInicio"></p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-calendar-check highlight"></i> Fecha de Finalización:</h6>
                            <p id="fechaFin"></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6><i class="fas fa-clock highlight"></i> Horas:</h6>
                            <p id="horasEvento"></p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-graduation-cap highlight"></i> Carrera:</h6>
                            <p id="carrera"></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6><i class="fas fa-laptop highlight"></i> Modalidad:</h6>
                            <p id="modalidad"></p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-dollar-sign highlight"></i> Costo:</h6>
                            <p id="costoEvento"></p>
                        </div>
                    </div>

                    <h6><i class="fas fa-check-circle highlight"></i> Nota de Aprobación:</h6>
                    <p id="notaAprobacion"></p>

                    <h6><i class="fas fa-users highlight"></i> Tipo de Público:</h6>
                    <p id="publicoObjetivo"></p>

                    <div class="text-center mt-4">
                        <button id="btnInscribirse" class="btn btn-custom btn-lg">Inscribirse</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-5 mt-lg-0">
                <div class="card text-center shadow-sm mb-4">
                    <div class="card-body">
                        <img id="fotoOrganizador" src="" class="img-fluid rounded-circle mb-3" style="width: 100px;">
                        <h5 class="highlight font-weight-bold">Organizador</h5>
                        <p id="nombreOrganizador" class="mb-1"></p>
                        <p id="correoOrganizador" class="text-muted small"></p>
                        <div class="d-flex justify-content-center mt-2">
                            <a class="text-info px-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="text-info px-2" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="text-info px-2" href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header card-header-custom">
                        <h6 class="mb-0">Requisitos</h6>
                    </div>
                    <div class="card-body">
                        <div id="requisitosEvento"></div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-header card-header-custom">
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
