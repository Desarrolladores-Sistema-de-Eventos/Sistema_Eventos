<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Eventos Académicos</title>
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
            <h3 class="display-4 text-white text-uppercase">Eventos Académicos</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="#">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Eventos Académicos</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Booking Start (Filtros) -->
<div class="container-fluid booking mt-5 pb-5">
    <div class="container pb-5">
        <div class="bg-light shadow" style="padding: 30px;">
            <form onsubmit="return false;">
                <div class="row align-items-center" style="min-height: 60px;">
                    <div class="col-md-2 mb-3 mb-md-0">
                        <select id="filtroTipo" class="custom-select px-4" style="height: 47px;">
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <select id="filtroCategoria" class="custom-select px-4" style="height: 47px;">
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <select id="filtroModalidad" class="custom-select px-4" style="height: 47px;">
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <select id="filtroCarrera" class="custom-select px-4" style="height: 47px;">
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <input id="filtroFecha" type="date" class="form-control p-4" placeholder="Fecha inicio">
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <input id="filtroBusqueda" type="text" class="form-control p-4" placeholder="🔍 Buscar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Booking End -->

<!-- Blog & Sidebar Start -->
<div class="container py-5">
    <div class="text-center mb-3 pb-3">
        <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Eventos</h6>
        <h1>Disponibles</h1>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="row" id="contenedorEventos"></div>
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-lg justify-content-center bg-white mb-0" style="padding: 30px;">
                        
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Sidebar -->
        <div class="col-lg-4 mt-5 mt-lg-0">
            
            <!-- Search Form -->
            <div class="mb-5">
                <div class="bg-white" style="padding: 30px;">
                    <div class="input-group">
                        <input type="text" id="inputBusqueda" class="form-control p-4" placeholder="Enter keyword to events">
                        <div class="input-group-append">
                            <span class="input-group-text bg-primary border-primary text-white"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Category List -->
            <div class="mb-5">
                <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Categorias</h4>
                <div class="bg-white" style="padding: 30px;">
                    <ul class="list-inline m-0" id="listaCategorias">
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Recent Post -->
            <div class="mb-5">
                <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Evento Riciente</h4>
                <div id="eventosRecientesSidebar"></div>
            </div>
            <!-- Tag Cloud -->
            
        <!-- Sidebar End -->
    </div>
</div>
</div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../public/lib/easing/easing.min.js"></script>
    <script src="../public/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../public/lib/tempusdominus/js/moment.min.js"></script>
    <script src="../public/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../public/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="../public/mail/jqBootstrapValidation.min.js"></script>
    <script src="../public/mail/contact.js"></script>
    <script src="../public/js/eventospublicos.js"></script>

   <!-- Footer Start -->
    <?php include 'partials/footer.php'; ?>
    <!-- Footer End -->
</body>
</html>
