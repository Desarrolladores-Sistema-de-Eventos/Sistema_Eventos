<?php include("partials/header_Admin.php"); ?>
<style>
    /* Definición de colores principales (asegúrate de que estas variables estén en tu :root global o aquí) */
    :root {
        --uta-rojo: #b10024; /* Rojo principal de UTA */
        --uta-rojo-oscuro: #92001c; /* Tono más oscuro de rojo */
        --uta-negro: #000000;
        --uta-blanco: #ffffff;
        --uta-gris-claro: #f5f5f5; /* Gris muy claro para fondos sutiles */
        --uta-gris-medio: #e0e0e0; /* Gris para bordes */
    }

    /* Título principal de la sección */
    h2 {
        color: var(--uta-negro); /* Título en negro */
        font-weight: bold;
        text-align: center; /* Centrar el título */
        margin-bottom: 1.5rem; /* Espacio debajo del título */
    }

    h2 i {
        color: var(--uta-rojo); /* Icono del título en rojo */
        margin-right: 10px;
    }

    hr {
        border-top: 2px solid var(--uta-rojo); /* Línea divisoria en rojo */
        width: 80px; /* Ancho de la línea */
        margin: 0.5rem auto 2.5rem auto; /* Centrar y espaciar la línea */
    }

    /* Estilos generales de los paneles */
    .panel {
        transition: transform 0.2s ease, box-shadow 0.3s ease;
        background: var(--uta-blanco); /* Fondo blanco para los paneles */
        border-radius: 10px;
        border: 1px solid var(--uta-gris-medio); /* Borde sutil en gris */
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Sombra más pronunciada */
        display: flex; /* Para que el contenido del panel se ajuste */
        flex-direction: column; /* Contenido en columna */
        height: 100%; /* Asegura que todos los paneles tengan la misma altura en una fila */
    }

    .panel:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); /* Sombra al pasar el ratón */
    }

    /* Cabecera del panel */
    .panel-heading {
        background-color: var(--uta-gris-claro); /* Fondo gris claro para la cabecera */
        padding: 1.25rem; /* Aumentar padding */
        border-bottom: 1px solid var(--uta-gris-medio); /* Borde inferior en gris */
    }

    .panel-heading h5 {
        margin: 0;
        font-weight: 700; /* Más negrita para los títulos de los paneles */
        font-size: 1.2rem; /* Tamaño de fuente ligeramente más grande */
        color: var(--uta-negro); /* Título del panel en negro */
        display: flex;
        align-items: center;
    }

    .panel-heading i {
        margin-right: 12px; /* Margen derecho del icono */
        font-size: 1.6rem; /* Tamaño del icono ligeramente más grande */
        color: var(--uta-rojo); /* Iconos de la cabecera en rojo */
    }

    /* Cuerpo del panel */
    .panel-body {
        padding: 1.5rem; /* Aumentar padding */
        font-size: 1rem; /* Tamaño de fuente estándar */
        color: var(--uta-negro); /* Texto del cuerpo en negro */
        background-color: var(--uta-blanco); /* Fondo blanco */
        flex-grow: 1; /* Para que el cuerpo ocupe el espacio restante */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Empujar el botón hacia abajo */
    }

    .panel-body p {
        margin-bottom: 1.5rem; /* Espacio debajo del párrafo */
        line-height: 1.6; /* Mejorar legibilidad */
        color: #333; /* Un gris oscuro para el texto del párrafo */
    }

    /* Botones */
    .btn-outline-primary {
        border: 2px solid var(--uta-rojo); /* Borde en rojo UTA */
        color: var(--uta-rojo); /* Texto en rojo UTA */
        font-weight: 600; /* Más negrita */
        transition: all 0.3s ease;
        border-radius: 8px; /* Bordes más redondeados */
        padding: 10px 20px; /* Aumentar padding del botón */
        font-size: 1.05rem; /* Tamaño de fuente ligeramente más grande */
    }

    .btn-outline-primary:hover {
        background-color: var(--uta-rojo); /* Fondo rojo al pasar el ratón */
        color: var(--uta-blanco); /* Texto blanco al pasar el ratón */
        box-shadow: 0 4px 10px rgba(var(--uta-rojo), 0.3); /* Sombra al pasar el ratón */
    }

    /* Espaciado de las columnas */
    .row.g-4 {
        --bs-gutter-x: 1.5rem; /* Espacio horizontal entre columnas */
        --bs-gutter-y: 1.5rem; /* Espacio vertical entre filas */
    }
    .row.g-4 > [class*="col-"] {
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
        padding-top: calc(var(--bs-gutter-y) * .5);
        padding-bottom: calc(var(--bs-gutter-y) * .5);
    }

    /* Media queries para responsividad */
    @media (max-width: 768px) {
        .panel-heading h5 {
            font-size: 1.1rem;
        }
        .panel-heading i {
            font-size: 1.4rem;
        }
        .panel-body {
            padding: 1rem;
        }
        .panel-body p {
            font-size: 0.95rem;
        }
        .btn-outline-primary {
            padding: 8px 15px;
            font-size: 1rem;
        }
    }
</style>


<?php 

$rolRequerido = 'ADMIN';
include("../core/auth.php"); 
?>

<div id="page-wrapper">
  <div id="page-inner" class="container py-4">

    <div class="row mb-4">
      <div class="col text-center">
        <h2><i class="fa fa-file"></i> Generación de Reportes</h2>
        <hr>
      </div>
    </div>

    <div class="row g-4">

      <!-- Panel 1 -->
      <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-certificate me-2"></i>Certificados Emitidos</h5>
          </div>
          <div class="panel-body p-3">
            <p>Consulta y descarga los certificados emitidos por evento.</p>
            <a href="informeCertificadosView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>

      <!-- Panel 2 -->
      <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-user-check me-2"></i>Inscripciones por Evento</h5>
          </div>
          <div class="panel-body p-3">
            <p>Revisa cuántos estudiantes se han inscrito por evento.</p>
            <a href="informeInscripcionesView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>

      <!-- Panel 3 -->
      <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-money-bill-wave me-2"></i>Reporte Financiero</h5>
          </div>
          <div class="panel-body p-3">
            <p>Pagos realizados, pendientes y comprobantes por evento.</p>
            <a href="informeFinancieroView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>

      <!-- Panel 4 -->
      <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-users me-2"></i>Evento y Asistentes</h5>
          </div>
          <div class="panel-body p-3">
            <p>Listado de asistentes con detalles por evento.</p>
            <a href="informeAsistentesView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>

      <!-- Panel 5 -->
      <div class="col-md-6 col-lg-4">
        <div class="panel panel-default shadow-sm border rounded-2">
          <div class="panel-heading bg-light p-3 border-bottom">
            <h5 class="mb-0"><i class="fa fa-tags me-2"></i>Eventos por Categoría</h5>
          </div>
          <div class="panel-body p-3">
            <p>Listado y estado de eventos por categoría.</p>
            <a href="informeEventosCategoriaView.php" class="btn btn-outline-primary w-100">Ver Reporte</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include("partials/footer_Admin.php"); ?>
