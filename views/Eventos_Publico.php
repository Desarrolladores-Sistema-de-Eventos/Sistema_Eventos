<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Eventos Académicos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='black' d='M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z'/></svg>">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --uta-rojo: #b10024; /* Color primario: Rojo */
            --uta-negro: #1a1a1a; /* Color secundario: Negro */
            --uta-blanco: #ffffff; /* Color de complemento: Blanco */
            --uta-gris: #f8f9fa; /* Manteniendo el gris claro para fondos */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--uta-gris);
        }

        .page-header {
            background: linear-gradient(to right, #960c1a, var(--uta-rojo)); /* Degradado de rojo */
            color: var(--uta-blanco);
            padding: 4rem 0 2rem;
            text-align: center;
        }

        .filter-section {
            background: var(--uta-blanco);
            padding: 20px 30px;
            border-radius: 0.5rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .form-control.search-input {
            border-radius: 0.4rem;
            padding-left: 2.8rem;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #888;
        }

        .filter-toggle-button {
            border: none;
            background: none;
            color: var(--uta-negro); /* Botón de filtro en color secundario */
            font-weight: 500;
        }

        .filter-toggle-button i {
            transition: transform 0.3s;
        }

        #secondaryFilters.collapse:not(.show) + div .fa-chevron-up {
            transform: rotate(180deg);
        }

        .custom-select,
        .form-control {
            height: 47px;
        }

        .text-primary {
            color: var(--uta-rojo) !important;
        }

        .pagination {
            padding: 20px;
        }

        .list-inline li {
            font-size: 15px;
        }

        .back-to-top {
            background: var(--uta-rojo);
            border: none;
            color: var(--uta-blanco); /* Color blanco para el icono */
        }

        .back-to-top:hover {
            background: #a0001f;
        }

        /* Nuevos estilos para la paleta de colores */
        .text-uta {
            color: var(--uta-rojo);
        }

        .text-secondary-color { /* Nueva clase para usar el negro como texto secundario */
            color: var(--uta-negro) !important;
        }

        .bg-primary-color { /* Nueva clase para fondos con el rojo primario */
            background-color: var(--uta-rojo) !important;
        }

        .bg-secondary-color { /* Nueva clase para fondos con el negro secundario */
            background-color: var(--uta-negro) !important;
        }

        .border-primary-color { /* Nueva clase para bordes con el rojo primario */
            border-color: var(--uta-rojo) !important;
        }

        .border-secondary-color { /* Nueva clase para bordes con el negro secundario */
            border-color: var(--uta-negro) !important;
        }

        /* Ajustes específicos para elementos existentes */
        #listaCategorias li a {
            text-decoration: none;
            transition: color 0.3s ease;
            font-weight: 500;
            color: var(--uta-negro); /* Las categorías por defecto serán negras */
        }

        #listaCategorias li a:hover {
            color: var(--uta-rojo); /* Al pasar el ratón, se vuelven rojas */
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
            border: 2px solid var(--uta-rojo); /* Borde de la imagen en rojo */
        }

        #eventosRecientesSidebar .evento-item .titulo {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--uta-negro); /* Título en negro */
            transition: color 0.3s ease;
        }

        #eventosRecientesSidebar .evento-item .titulo:hover {
            color: var(--uta-rojo); /* Al pasar el ratón, se vuelve rojo */
        }

        /* Estilo para el borde de las secciones en el sidebar */
        .border-start.border-4.border-danger {
            border-color: var(--uta-rojo) !important; /* Asegura que el borde sea el color primario */
        }
    </style>
</head>
<body>

<?php include 'partials/header.php'; ?>

<div class="container-fluid page-header">
    <h3 class="display-5 fw-bold">Eventos Académicos</h3>
    <div class="d-inline-flex">
        <p class="m-0"><a class="text-white" href="../public/index.php">Inicio</a></p>
        <i class="fa fa-angle-double-right px-3"></i>
        <p class="m-0">Eventos Académicos</p>
    </div>
</div>

<div class="container py-5">
    <div class="filter-section">
        <form onsubmit="return false;">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input id="filtroBusqueda" type="text" class="form-control search-input" placeholder="Buscar por nombre del evento...">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button class="filter-toggle-button" type="button" data-toggle="collapse" data-target="#secondaryFilters">
                    <i class="fa fa-filter me-2"></i> Filtros <i class="fa fa-chevron-up ms-2"></i>
                </button>
            </div>

            <div class="collapse" id="secondaryFilters">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <select id="filtroCarrera" class="form-control">
                            <option value="">Por Carrera</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select id="filtroTipo" class="form-control">
                            <option value="">Por Tipo</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select id="filtroCategoria" class="form-control">
                            <option value="">Por Categoría</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select id="filtroModalidad" class="form-control">
                            <option value="">Por Modalidad</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input id="filtroFecha" type="date" class="form-control" placeholder="Fecha inicio">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="text-center mb-5">
        <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Eventos</h6>
        <h2 class="fw-bold text-secondary-color">Disponibles</h2> </div>

<div class="row">
    <div class="col-lg-8">
        <div class="row" id="contenedorEventos"></div>

        <div class="col-12 mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center bg-white py-3 rounded shadow-sm">
                    </ul>
            </nav>
        </div>
    </div>

    <div class="col-lg-4 mt-5 mt-lg-0">
        <div class="mb-5">
            <h5 class="text-uppercase mb-3 text-uta" style="letter-spacing: 2px;">Categorías</h5>
            <div class="bg-white p-3 rounded shadow-sm border-start border-4 border-danger">
                <ul class="list-unstyled" id="listaCategorias">
                </ul>
            </div>
        </div>

        <div class="mb-5">
            <h5 class="text-uppercase mb-3 text-uta" style="letter-spacing: 2px;">Evento Reciente</h5>
            <div id="eventosRecientesSidebar" class="bg-white p-3 rounded shadow-sm border-start border-4 border-danger">
                </div>
        </div>
    </div>
</div>

</div>

<?php include 'partials/footer.php'; ?>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="../public/js/eventospublicos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>