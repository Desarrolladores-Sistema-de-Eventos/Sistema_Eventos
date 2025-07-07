<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Eventos Académicos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path fill='black' d='M128 0V32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H384V0c0-17.7-14.3-32-32-32s-32 14.3-32 32V32H192V0c0-17.7-14.3-32-32-32s-32 14.3-32 32zM64 96H448V416H64V96z'/></svg>">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    :root {
      --uta-rojo: #b10024;
      --uta-blanco: #ffffff;
      --uta-gris: #f8f9fa;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--uta-gris);
    }

    .page-header {
      background: linear-gradient(to right, #960c1a, #b10024);
      color: white;
      padding: 4rem 0 2rem;
      text-align: center;
    }

    .filter-section {
      background: #fff;
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
      color: #333;
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
    }

    .back-to-top:hover {
      background: #a0001f;
    }

    .text-uta {
    color: #b10024;
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
    <h2 class="fw-bold">Disponibles</h2>
  </div>

<div class="row">
    <div class="col-lg-8">
        <div class="row" id="contenedorEventos"></div>

        <div class="col-12 mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center bg-white py-3 rounded shadow-sm">
                    <!-- Paginación dinámica -->
                </ul>
            </nav>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4 mt-5 mt-lg-0">
        <!-- Categorías -->
        <div class="mb-5">
            <h5 class="text-uppercase mb-3 text-uta" style="letter-spacing: 2px;">Categorías</h5>
            <div class="bg-white p-3 rounded shadow-sm border-start border-4 border-danger">
                <ul class="list-unstyled" id="listaCategorias">
                </ul>
            </div>
        </div>

        <!-- Evento Reciente -->
        <div class="mb-5">
            <h5 class="text-uppercase mb-3 text-uta" style="letter-spacing: 2px;">Evento Reciente</h5>
            <div id="eventosRecientesSidebar" class="bg-white p-3 rounded shadow-sm border-start border-4 border-danger">
                <!-- Contenido dinámico -->
            </div>
        </div>
    </div>
</div>

</div>

<?php include 'partials/footer.php'; ?>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="../public/js/eventospublicos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>
