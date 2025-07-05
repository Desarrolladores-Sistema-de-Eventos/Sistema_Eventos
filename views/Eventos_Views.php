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

    <style>
        /* Estilos generales para la sección de filtros */
        .filter-section {
            background-color: #f8f9fa; /* Un gris claro de fondo */
            padding: 30px; /* Aumenté el padding */
            border-radius: 0.5rem; /* Bordes más redondeados */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05); /* Sombra más pronunciada */
            margin-bottom: 30px; /* Más espacio debajo */
        }

        /* Estilos para el botón de alternancia de filtros */
        .filter-toggle-button {
            border: none;
            background: transparent; /* Fondo transparente */
            padding: 10px 0; /* Algo de padding vertical */
            cursor: pointer;
            font-size: 1.1rem;
            color: #343a40; /* Color oscuro */
            display: flex;
            align-items: center;
        }
        .filter-toggle-button:focus {
            outline: none;
        }
        .filter-toggle-button .fa-chevron-up {
            transition: transform 0.3s ease-in-out;
        }
        /* La flecha por defecto está hacia arriba, rotará 180deg cuando esté colapsado */
        #secondaryFilters.collapse:not(.show) + div .filter-toggle-button .fa-chevron-up {
            transform: rotate(180deg); 
        }
        /* Cuando el colapsable está expandido, la flecha hacia arriba */
        #secondaryFilters.collapse.show + div .filter-toggle-button .fa-chevron-up {
            transform: rotate(0deg);
        }
        .filter-button-text {
            font-size: 1.05rem; /* Ligeramente más grande */
            font-weight: 600; /* Más negrita */
            margin-left: 5px; /* Espacio entre el icono y el texto */
        }

        /* Estilos para el input de búsqueda principal */
        .main-search-input-group {
            margin-bottom: 20px; /* Espacio debajo del buscador principal */
        }
        .form-control.search-input {
            border: 1px solid #ced4da;
            padding: 1rem 1.5rem; /* Más padding dentro del input */
            border-radius: 0.3rem;
            font-size: 1rem;
            padding-left: 3.5rem; /* Espacio para el icono de lupa */
        }
        .main-search-input-group .input-group-prepend .input-group-text {
            background-color: #fff; /* Fondo blanco para el icono */
            border: 1px solid #ced4da;
            border-right: none; /* Sin borde derecho para que se una al input */
            padding: 1rem 1rem;
            color: #6c757d;
            border-radius: 0.3rem 0 0 0.3rem; /* Bordes redondeados a la izquierda */
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 10;
        }

        /* Estilos para los filtros dentro del área colapsable */
        .filter-group {
            padding-top: 20px; /* Espacio en la parte superior de los filtros */
            border-top: 1px solid #dee2e6; /* Línea divisoria */
        }
        .filter-group .col-md-3 { /* Usamos col-md-3 para que quepan 4 por fila */
            margin-bottom: 15px !important; /* Espacio entre los filtros cuando están en varias filas */
        }
        .filter-group .custom-select,
        .filter-group .form-control {
            border: 1px solid #ced4da;
            height: auto; /* Altura automática para más espacio vertical */
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border-radius: 0.3rem;
        }

        /* Ocultar el input de búsqueda del sidebar si no se va a usar */
        #sidebarSearchForm {
            display: none; 
        }

        /* Estilos para el Topbar */
        .topbar-section {
            background-color: #fff;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        .topbar-section .logo-container {
            display: flex;
            align-items: center;
        }
        .topbar-section .logo-container img {
            height: 60px;
            margin-right: 15px;
        }
        .topbar-section .faculty-info h6 {
            color: #660000;
            margin-bottom: 0;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem; /* Ajuste para el texto más pequeño */
        }
        .topbar-section .faculty-info h5 {
            color: #660000;
            margin-bottom: 0;
            font-weight: bold;
            font-size: 1.1rem; /* Ajuste para el texto más grande */
        }
        .topbar-section .faculty-info .badge {
            font-size: 0.75rem;
            padding: 0.3em 0.6em;
            margin-top: 5px;
        }
        .topbar-section .user-actions {
            display: flex;
            align-items: center;
        }
        .topbar-section .user-actions .fas {
            color: #dc3545; /* Color rojo de Bootstrap para danger */
            font-size: 2rem;
            margin-right: 10px;
        }
        .topbar-section .user-actions .btn {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
        }

        /* Responsive adjustments for topbar */
        @media (max-width: 991.98px) {
            .topbar-section .d-flex.flex-column.flex-lg-row {
                flex-direction: column;
                align-items: center;
            }
            .topbar-section .logo-container {
                margin-bottom: 15px;
            }
            .topbar-section .user-actions {
                margin-top: 15px;
            }
        }
        @media (max-width: 767.98px) {
            .topbar-section .user-actions .d-flex.flex-column.flex-md-row {
                flex-direction: column;
                gap: 5px;
            }
            .topbar-section .user-actions .btn {
                margin: 5px 0 !important;
            }
        }
    .sidebar-bordered {
        border-left: 5px solid #b10024;
    }
    </style>
</head>
<body>

<div class="container-fluid bg-white py-2 border-bottom topbar-section">
    <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center">

        <div class="d-flex align-items-center mb-2 mb-lg-0">
          <img src="../public/img/uta/logo.png" alt="Logo Facultad" style="height: 60px; margin-right: 10px;">
          <div>
            <h6 class="mb-0 text-uppercase font-weight-bold" style="color: #660000;">UNIVERSIDAD</h6>
            <h5 class="mb-0 font-weight-bold" style="color: #660000;">TÉCNICA DE AMBATO</h5>
            <span class="badge" style="background-color:rgb(32, 31, 31); color: white;">CAMPUS-HUACHI</span>
          </div>
        </div>
        <div class="d-flex align-items-center user-actions">
            <i class="fas fa-user-circle"></i>
            <div class="d-flex flex-column flex-md-row gap-2">
                <a href="../views/dashboard_Pri_Usu.php" class="btn btn-outline-dark btn-sm mx-1">Dashboard</a>
                <a href="../controllers/logout.php" class="btn btn-outline-danger btn-sm mx-1">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="text-center mb-3 pb-3">
        <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Eventos</h6>
        <h1>Disponibles</h1>
    </div>
    <br/>
    <hr/>

    <div class="container-fluid booking pb-4">
        <div class="container">
            <div class="filter-section">
                <form onsubmit="return false;">
                    <div class="input-group main-search-input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input id="filtroBusqueda" type="text" class="form-control search-input" placeholder="Buscar por nombre del evento...">
                    </div>

                    <div class="d-flex align-items-center justify-content-start mb-3">
                        <button class="filter-toggle-button" type="button" data-toggle="collapse" data-target="#secondaryFilters" aria-expanded="false" aria-controls="secondaryFilters">
                            <i class="fa fa-filter mr-2"></i>
                            <span class="filter-button-text">Filtros</span>
                            <i class="fa fa-chevron-up ml-2"></i>
                        </button>
                    </div>

                    <div class="collapse" id="secondaryFilters">
                        <div class="row filter-group">
                            <div class="col-md-3 mb-3"> 
                                <label for="filtroCarrera" class="sr-only">Por Carrera</label>
                                <select id="filtroCarrera" class="custom-select">
                                    <option value="">Por Carrera</option>
                                    </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="filtroTipo" class="sr-only">Por Tipo</label>
                                <select id="filtroTipo" class="custom-select">
                                    <option value="">Por Tipo</option>
                                    </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="filtroCategoria" class="sr-only">Por Categoría</label>
                                <select id="filtroCategoria" class="custom-select">
                                    <option value="">Por Categoría</option>
                                    </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="filtroModalidad" class="sr-only">Por Modalidad</label>
                                <select id="filtroModalidad" class="custom-select">
                                    <option value="">Por Modalidad</option>
                                    </select>
                            </div>
                            <div class="col-md-3 mb-3"> 
                                <label for="filtroFecha" class="sr-only">Fecha</label>
                                <input id="filtroFecha" type="date" class="form-control" placeholder="Fecha inicio">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="row" id="contenedorEventos"></div>
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-lg justify-content-center bg-white mb-0" style="padding: 30px;">
                        </ul>
                </nav>
            </div>
        </div>

        <div class="col-lg-4 mt-5 mt-lg-0">
            
            <div class="mb-5" id="sidebarSearchForm">
                <div class="bg-white" style="padding: 30px;">
                    <div class="input-group">
                        <input type="text" id="inputBusqueda" class="form-control p-4" placeholder="Buscar eventos">
                        <div class="input-group-append">
                            <span class="input-group-text bg-primary border-primary text-white"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Categorías</h4>
                <div class="bg-white sidebar-bordered" style="padding: 30px;">
                    <ul class="list-inline m-0" id="listaCategorias">
                        </ul>
                </div>
            </div>

            <div class="mb-5">
                <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Evento Reciente</h4>
                <div id="eventosRecientesSidebar" style="padding: 30px;"></div>
            </div>
        </div>
    </div>
</div>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
    <i class="fa fa-angle-double-up"></i>
</a>

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

<?php include 'partials/footer.php'; ?>

</body>
</html>