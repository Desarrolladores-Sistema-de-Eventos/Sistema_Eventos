<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Eventos Académicos</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <link href="../public/img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <link href="../public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../public/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <link href="../public/css/style.css" rel="stylesheet">
    <!-- AOS Animate On Scroll CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        /* Estilos adicionales para que se vea más parecido al ejemplo */
        .filter-section {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: .25rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 0.5rem;
        }

        /* Tarjetas de evento con efecto tipo home */
        .evento-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .evento-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15);
        }
        .evento-imagen {
            position: relative;
            height: 180px;
            overflow: hidden;
        }
        .evento-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease-in-out;
        }
        .evento-card:hover .evento-imagen img {
            transform: scale(1.1);
        }
        .evento-overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0,0,0,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s ease-in-out;
        }
        .evento-card:hover .evento-overlay {
            opacity: 1;
        }
        .evento-card .evento-footer {
            margin-top: auto;
        }
        .evento-card .evento-precio {
            font-weight: bold;
            color: rgb(119, 23, 20);
            font-size: 1.1rem;
        }
        .filter-toggle-button {
            border: none;
            background: none;
            padding: 0;
            cursor: pointer;
            font-size: 1.1rem;
            color: #343a40; /* Color oscuro */
            display: flex; /* Para alinear icono y texto */
            align-items: center;
        }
        .filter-toggle-button:focus {
            outline: none;
        }
        .filter-toggle-button .fa-chevron-up {
            transition: transform 0.3s ease-in-out;
            /* La flecha por defecto está hacia arriba, rotará 180deg cuando esté colapsado */
        }
        /* Cuando el colapsable NO está expandido (por defecto), rota la flecha hacia abajo */
        #secondaryFilters.collapse:not(.show) + div .filter-toggle-button .fa-chevron-up {
            transform: rotate(180deg); 
        }
        /* Cuando el colapsable está expandido, la flecha hacia arriba */
        #secondaryFilters.collapse.show + div .filter-toggle-button .fa-chevron-up {
            transform: rotate(0deg);
        }

        .filter-button-text {
            font-size: 1rem; /* Ajusta el tamaño del texto "Filtros" */
            font-weight: 500;
        }
        .form-control.search-input {
            border: 1px solid #ced4da;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
        }
        /* Estilos para el input de búsqueda principal */
        .main-search-input-group .form-control {
            padding-left: 3rem; /* Espacio para el icono de lupa */
        }
        .main-search-input-group .input-group-prepend .input-group-text {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 10;
            background: none;
            border: none;
            padding-left: 1rem;
            color: #6c757d; /* Color del icono */
        }

        /* Estilo para los filtros dentro del área colapsable */
        .filter-group .col-md-3 { /* Usamos col-md-3 para que quepan 4 por fila */
            margin-bottom: 1rem !important; /* Espacio entre los filtros cuando están en varias filas */
        }
        .filter-group .custom-select,
        .filter-group .form-control {
            border: 1px solid #ced4da;
            height: 47px;
            padding: 0.75rem 1rem;
        }
        /* Ocultar el input de búsqueda del sidebar si no se va a usar */
        #sidebarSearchForm {
            display: none; 
        }
        #listaCategorias li a {
    text-decoration: none;
    transition: color 0.3s ease;
    font-weight: 500;
}

#listaCategorias li a:hover {
    color: #b10024;
}

#eventosRecientesSidebar .evento-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

#eventosRecientesSidebar .evento-item img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #b10024;
}

#eventosRecientesSidebar .evento-item .titulo {
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    transition: color 0.3s ease;
}

#eventosRecientesSidebar .evento-item .titulo:hover {
    color: #b10024;
}
.sidebar-bordered {
    border-left: 5px solid #b10024;
}
    </style>
</head>
<body>
<?php
if (!isset($_SESSION['usuario'])) {
    include 'partials/header.php';
?>
    <div class="container-fluid page-header" style="background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('../public/img/uta/uta.png') center 20%/cover no-repeat; min-height: 420px; display: flex; align-items: center;">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center w-100" style="min-height: 485px;">
                <h3 class="display-4 text-white text-uppercase text-shadow" style="text-shadow: 2px 2px 8px #000, 0 1px 10px #b10024;">Eventos Académicos</h3>
                <div class="d-inline-flex text-white mt-2" style="background: rgba(0,0,0,0.25); border-radius: 8px; padding: 6px 18px;">
                    <p class="m-0 text-uppercase"><a class="text-white" href="#">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Eventos Académicos</p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (isset($_SESSION['usuario'])): ?>
<div class="container-fluid py-2 border-bottom" style="background-color:#fff;">
      <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center">
        <div class="d-flex align-items-center mb-2 mb-lg-0">
          <img src="../public/img/uta/logo.png" alt="Logo Facultad" style="height: 60px; margin-right: 10px;">
          <div>
            <h6 class="mb-0 text-uppercase font-weight-bold" style="color: rgb(134, 17, 17);">UNIVERSIDAD</h6>
            <h5 class="mb-0 font-weight-bold" style="color: rgb(134, 17, 17);">TÉCNICA DE AMBATO</h5>
      <span class="badge" style="background-color:rgb(49, 49, 49); color: white;">CAMPUS-HUACHI</span>
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
 </div>
<?php endif; ?>

<div class="container-fluid booking mt-4" style="padding-bottom: 0; margin-top: 1.2rem !important;">
    <div class="container" style="padding-bottom: 0;">
        <div class="filter-section"> <form onsubmit="return false;">
                <div class="row align-items-center mb-3">
                    <div class="col-12">
                        <div class="input-group main-search-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input id="filtroBusqueda" type="text" class="form-control search-input" placeholder="Buscar por nombre del evento...">
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-3 justify-content-start"> <button class="filter-toggle-button" type="button" data-toggle="collapse" data-target="#secondaryFilters" aria-expanded="false" aria-controls="secondaryFilters">
                        <i class="fa fa-filter mr-2"></i>
                        <span class="filter-button-text">Filtros</span>
                        <i class="fa fa-chevron-up ml-2"></i> </button>
                </div>

                <div class="collapse" id="secondaryFilters">
                    <div class="row filter-group">
                        <div class="col-md-3 mb-3"> 
                            <label for="filtroCarrera" class="sr-only">Por Carrera</label>
                            <select id="filtroCarrera" class="custom-select px-4">
                                <option value="">Por Carrera</option>
                                </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="filtroTipo" class="sr-only">Por Tipo</label>
                            <select id="filtroTipo" class="custom-select px-4">
                                <option value="">Por Tipo</option>
                                </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="filtroCategoria" class="sr-only">Por Categoría</label>
                            <select id="filtroCategoria" class="custom-select px-4">
                                <option value="">Por Categoría</option>
                                </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="filtroModalidad" class="sr-only">Por Modalidad</label>
                            <select id="filtroModalidad" class="custom-select px-4">
                                <option value="">Por Modalidad</option>
                                </select>
                        </div>
                        <div class="col-md-3 mb-3"> 
                            <label for="filtroFecha" class="sr-only">Fecha</label>
                            <input id="filtroFecha" type="date" class="form-control px-4" placeholder="Fecha inicio">
                        </div>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container pt-3 pb-4">
    <div class="text-center mb-3 pb-3">
    <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Disponibles</h6>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="row" id="contenedorEventos"><!-- Las tarjetas de eventos se insertan aquí por JS, pero agregamos el atributo data-aos a cada tarjeta vía JS --></div>
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
                        <input type="text" id="inputBusqueda" class="form-control p-4" placeholder="Enter keyword to events">
                        <div class="input-group-append">
                            <span class="input-group-text bg-primary border-primary text-white"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Categorias</h4>
                <div class="bg-white sidebar-bordered" style="padding: 30px;">
                    <ul class="list-inline m-0" id="listaCategorias">
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
                <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Evento Reciente</h4>
                <div id="eventosRecientesSidebar" style="padding: 30px;"></div>
            </div>
            </div>
</div>
</div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

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
    <!-- AOS Animate On Scroll JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
      AOS.init({
        once: true,
        duration: 700,
        offset: 60
      });
    </script>
    <script src="../public/js/eventospublicos.js"></script>
   <?php include 'partials/footer.php'; ?>

    </body>
</html>