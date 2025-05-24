<?php include("partials/header_Admin.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<div id="page-wrapper" style="margin-left: 260px; padding: 30px; min-height: 100vh; background-color: #f5f5f5; overflow-y: auto;">
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
    <h1>Se cargarán dimanicamente desde la BD</h1>
</div>


<?php include("partials/footer_Admin.php"); ?>
