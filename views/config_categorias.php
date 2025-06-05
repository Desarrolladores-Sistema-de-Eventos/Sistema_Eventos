<?php include("partials/header_Admin.php"); ?>

<div id="page-wrapper">
  <div id="page-inner">
    <h3 class="text-danger"><i class="fa fa-folder-open"></i> Gestión de Categorías de Evento</h3>
    <p class="text-muted">Administra las categorías temáticas para organizar tus eventos.</p>

    <!-- Botón agregar -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalCategoria">
        <i class="fa fa-plus"></i> Agregar Categoría
    </button>
    <br>
    <br>
    <!-- Tabla de categorías -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contenido dinámico -->
            </tbody>
        </table>
    </div>
    <div>
      <a href="configuracion_datos_base.php" class="btn btn-secondary mt-2"><i class="fa fa-arrow-left"></i> Volver a configuración</a>
    </div>
</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php include("partials/footer_Admin.php"); ?>
