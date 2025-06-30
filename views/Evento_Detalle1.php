<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Descripción del Evento</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="../public/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
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
                <img src="../public/img/logo.png" alt="Logo Facultad" style="height: 60px; margin-right: 10px;">
                <div>
                    <h6 class="mb-0 text-uppercase font-weight-bold" style="color: #660000;">UNIVERSIDAD</h6>
                    <h5 class="mb-0 font-weight-bold" style="color: #660000;">TÉCNICA DE AMBATO</h5>
                    <span class="badge" style="background-color:rgb(126, 9, 9); color: white;">CAMPUS-HUACHI</span>
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

    <!-- Contenido del Evento -->
    <div class="container py-5">
        <div class="row">
            <!-- Contenido Izquierdo -->
            <div class="col-lg-8">
                  <div class="bg-white p-4 rounded shadow-sm">
                <!-- Imagen Principal -->
                <h2 id="tituloEvento" class="mb-3 text-primary"></h2>

                <div class="mb-4">
                    <img class="img-fluid rounded w-100" id="galeriaEvento" alt="Imagen del evento">
                </div>

                <!-- Información del Evento -->

                <p class="mb-4" id="descripcionEvento"></p>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar-alt text-primary"></i> Fecha de Inicio:</h6>
                        <p id="fechaInicio"></p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar-check text-primary"></i> Fecha de Finalización:</h6>
                        <p id="fechaFin"></p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="fas fa-clock text-primary"></i> Horas:</h6>
                        <p id="horasEvento"></p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-graduation-cap text-primary"></i> Carrera:</h6>
                        <p id="carrera"></p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="fas fa-laptop text-primary"></i> Modalidad:</h6>
                        <p id="modalidad"></p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-dollar-sign text-primary"></i> Costo:</h6>
                        <p id="costoEvento"></p>
                    </div>
                </div>
            
                <h6><i class="fas fa-check-circle text-primary"></i> Nota de Aprobación:</h6>
                <p id="notaAprobacion"></p>

                <h6><i class="fas fa-users text-primary"></i> Tipo de Público:</h6>
                <p id="publicoObjetivo"></p>
                

                <!-- Boton Inscribirse -->
                <div class="text-center mt-4">
                    <button id="btnInscribirse" class="btn btn-primary btn-lg">Inscribirse</button>
                </div>
              </div>   
            </div>

            <!-- Lado Derecho: Organizador + Requisitos -->
            <div class="col-lg-4">
                <!-- Organizador -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <img id="fotoOrganizador" src="" class="img-fluid rounded-circle mb-3" style="width: 100px;">
                        <h5 class="text-primary">Organizador</h5>
                        <p id="nombreOrganizador"></p>
                        <p id="correoOrganizador"></p>
                    </div>
                </div>

                <!-- Requisitos -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Requisitos del Evento</h5>
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

    <!-- Footer Start -->
    <?php include 'partials/footer.php'; ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../public/lib/easing/easing.min.js"></script>
    <script src="../public/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../public/lib/tempusdominus/js/moment.min.js"></script>
    <script src="../public/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../public/js/detalle.js"></script>
</body>

</html>
