<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Eventos Académicos</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Eventos UTA" name="keywords">
    <meta content="Eventos UTA" name="description">

    <link href="../public/img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="../public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../public/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
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

<!-- Contenido principal -->
<div class="container py-5">
    <div class="text-center mb-3 pb-3">
        <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Eventos</h6>
        <h1>Disponibles</h1>
    </div>
    <br/>
    <hr/>

    <!-- Booking Start (Filtros) -->
    <div class="container-fluid booking pb-4">
        <div class="container">
            <div class="bg-light shadow" style="padding: 30px;">
                <form onsubmit="return false;">
                    <div class="row align-items-center" style="min-height: 60px;">
                        <div class="col-md-2 mb-3 mb-md-0">
                            <select id="filtroTipo" class="custom-select px-4" style="height: 47px;">
                                <option value="">Tipo</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <select id="filtroCategoria" class="custom-select px-4" style="height: 47px;">
                                <option value="">Categoría</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <select id="filtroModalidad" class="custom-select px-4" style="height: 47px;">
                                <option value="">Modalidad</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <select id="filtroCarrera" class="custom-select px-4" style="height: 47px;">
                                <option value="">Carrera</option>
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

    <!-- Eventos y Sidebar -->
    <div class="row mt-4">
        <!-- Eventos -->
        <div class="col-lg-8">
            <div class="row" id="contenedorEventos"></div>
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-lg justify-content-center bg-white mb-0" style="padding: 30px;">
                        <!-- Paginación -->
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 mt-5 mt-lg-0">
            <!-- Buscador -->
            <div class="mb-5">
                <div class="bg-white" style="padding: 30px;">
                    <div class="input-group">
                        <input type="text" id="inputBusqueda" class="form-control p-4" placeholder="Buscar eventos">
                        <div class="input-group-append">
                            <span class="input-group-text bg-primary border-primary text-white"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categorías -->
            <div class="mb-5">
                <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Categorías</h4>
                <div class="bg-white" style="padding: 30px;">
                    <ul class="list-inline m-0" id="listaCategorias">
                        <!-- Categorías dinámicas -->
                    </ul>
                </div>
            </div>

            <!-- Evento reciente -->
            <div class="mb-5">
                <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Evento Reciente</h4>
                <div id="eventosRecientesSidebar"></div>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
    <i class="fa fa-angle-double-up"></i>
</a>

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
<script src="../public/js/eventosViews.js"></script>

<!-- Footer -->
<?php include 'partials/footer.php'; ?>

</body>
</html>
