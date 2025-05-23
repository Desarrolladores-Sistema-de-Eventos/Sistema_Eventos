<?php include("partials/header_Admin.php"); ?>

<div id="page-wrapper" style="margin-left: 260px; height: 100vh; overflow-y: auto;">
    <div class="container-fluid py-4" style="min-height: 100%; background-color: #f5f5f5;">
        
        <!-- Encabezado -->
        <h2 class="text-danger mb-1">
            <i class="fa fa-calendar-plus"></i> Configuración de Eventos
        </h2>
        <p class="text-muted">Formulario para crear o modificar eventos institucionales</p>

        <!-- Tarjeta principal -->
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-light">
                <h4 class="mb-0"><i class="fa fa-edit"></i> Nuevo Evento</h4>
            </div>

            <div class="card-body">
                <!-- Aquí va tu formulario completo -->
                <form id="formEvento">...</form>
            </div>
        </div>
    </div>
</div>
<?php include("partials/footer_Admin.php"); ?>
