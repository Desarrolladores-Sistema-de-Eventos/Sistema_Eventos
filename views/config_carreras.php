<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!-- CSS -->
<style>
    /* Definición de colores principales: ÚNICAMENTE ROJO, BLANCO Y NEGRO */
    :root {
        --uta-rojo: #b10024; /* Rojo principal de UTA */
        --uta-rojo-oscuro: #92001c; /* Tono más oscuro de rojo para hover */
        --uta-negro: #000000;
        --uta-blanco: #ffffff;
    }

    .uta-title {
        color: var(--uta-rojo); /* Título en rojo UTA */
        font-weight: bold;
        font-size: 2.2rem; /* Ajustado para consistencia */
        margin-bottom: 0.5rem; /* Ajustado para consistencia */
    }

    .uta-subtitle, .descripcion-seccion {
        color: var(--uta-negro); /* Subtítulo/descripción en negro */
        font-size: 1.1rem; /* Ajustado para consistencia */
        margin-bottom: 1.5rem; /* Ajustado para consistencia */
    }

    .btn-success { /* Botón "Agregar Carrera" */
        background-color: var(--uta-rojo); /* Rojo UTA */
        color: var(--uta-blanco);
        border: none;
        transition: all 0.3s ease-in-out;
        font-weight: 500;
    }

    .btn-success:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al hover */
        color: var(--uta-blanco);
    }

    .table thead {
        background-color: var(--uta-rojo); /* Encabezado de tabla en rojo UTA */
        color: var(--uta-blanco);
    }

    /* Estilos para encabezados de tabla (th) y celdas (td) */
    .table th, .table td {
        vertical-align: middle;
        text-align: center; /* Centrado para el encabezado y contenido */
        border: 1px solid var(--uta-negro) !important; /* Bordes negros para todas las celdas */
    }

    .table td {
        color: var(--uta-negro); /* Texto negro por defecto en celdas */
        background-color: var(--uta-blanco); /* Fondo blanco por defecto en celdas */
    }

    .table tbody tr:hover td {
        background-color: var(--uta-rojo-oscuro) !important; /* Fondo rojo oscuro al hover */
        color: var(--uta-blanco) !important; /* Texto blanco al hover */
    }

    /* Estilos para los botones de acción dentro de la tabla */
    .table td .btn {
        background-color: transparent; /* Fondo transparente por defecto */
        color: var(--uta-negro); /* Texto negro por defecto */
        border: 1px solid var(--uta-negro); /* Borde negro */
        padding: 5px 8px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .table td .btn:hover {
        background-color: var(--uta-rojo); /* Fondo rojo al hover */
        color: var(--uta-blanco); /* Texto blanco al hover */
        border-color: var(--uta-rojo); /* Borde rojo al hover */
    }

    /* Estilo específico para el botón de eliminar (asumo que es btn-danger) */
    .table td .btn-danger {
        background-color: var(--uta-rojo); /* Fondo rojo para el botón de eliminar */
        color: var(--uta-blanco); /* Texto blanco para el botón de eliminar */
        border-color: var(--uta-rojo); /* Borde rojo para el botón de eliminar */
    }

    .table td .btn-danger:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al hover */
        border-color: var(--uta-rojo-oscuro); /* Borde rojo oscuro al hover */
    }

    /* Iconos dentro de los botones de acción */
    .table td .btn i {
        color: inherit; /* Hereda el color del botón padre */
    }
    .table td .btn-primary i { /* Para el botón de editar, si usa btn-primary */
        color: var(--uta-negro);
    }
    .table td .btn-primary:hover i {
        color: var(--uta-blanco);
    }
    .table td .btn-danger i {
        color: var(--uta-blanco);
    }


    .modal-header {
        background-color: var(--uta-rojo); /* Encabezado del modal en rojo UTA */
        color: var(--uta-blanco);
        border-bottom: 2px solid var(--uta-negro); /* Borde inferior del modal en negro */
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .modal-title {
        font-weight: bold;
        color: var(--uta-blanco); /* Asegurar que el título del modal sea blanco */
    }

    .modal-header .btn-close { /* Selector para el botón de cerrar del modal */
        color: var(--uta-blanco); /* Color del botón de cerrar en el modal header */
        opacity: 1; /* Asegurar visibilidad */
        font-size: 24px; /* Mantener tamaño original */
        background: none; /* Asegurar que no tenga fondo */
        border: none; /* Asegurar que no tenga borde */
        padding: 0; /* Eliminar padding extra */
    }
    .modal-header .btn-close:hover {
        color: var(--uta-negro); /* Color del botón de cerrar al hover */
    }

    .form-control:focus {
        border-color: var(--uta-rojo); /* Borde de input en foco en rojo UTA */
        box-shadow: 0 0 0 0.2rem rgba(177, 0, 36, 0.25); /* Sombra en foco en rojo UTA */
    }

    .btn-primary { /* Botón "Guardar" del modal */
        background-color: var(--uta-rojo);
        border-color: var(--uta-rojo);
        color: var(--uta-blanco);
    }

    .btn-primary:hover {
        background-color: var(--uta-rojo-oscuro);
        border-color: var(--uta-rojo-oscuro);
        color: var(--uta-blanco);
    }

    .btn-secondary { /* Botón "Cancelar" del modal */
        background-color: var(--uta-negro); /* Negro */
        color: var(--uta-blanco); /* Texto blanco */
        border: none;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: var(--uta-rojo); /* Rojo al hover */
        color: var(--uta-blanco); /* Texto blanco */
    }


    .modal-content {
        border-radius: 0.5rem;
        border: 2px solid var(--uta-negro); /* Borde del modal en negro */
    }

    /* Estilos para etiquetas de formulario */
    label {
        font-weight: 600;
        color: var(--uta-negro); /* Etiquetas en negro */
    }

    /* Botón "Volver a configuración" */
    .btn-secondary.mt-3 { /* Selector más específico para el botón de volver */
        border: 1px solid var(--uta-negro); /* Borde negro */
        color: var(--uta-negro); /* Texto negro */
        background-color: transparent;
        transition: all 0.3s ease;
    }
    .btn-secondary.mt-3:hover {
        background-color: var(--uta-rojo); /* Fondo rojo al hover */
        color: var(--uta-blanco); /* Texto blanco al hover */
        border-color: var(--uta-rojo); /* Borde rojo al hover */
    }
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="mb-4">
            <h3 class="uta-title"><i class="fa fa-graduation-cap me-2"></i>Gestión de Carreras de Nuestra Facultad</h3>
            <p class="descripcion-seccion">Administra las carreras disponibles en cada facultad.</p>
        </div>

        <div class="mb-4">
            <button class="btn btn-success shadow-sm" id="btnAgregarCarrera">
                <i class="fa fa-plus me-1"></i> Agregar Carrera
            </button>
        </div>
        <br>

        <div class="table-responsive">
            <table class="table table-bordered table-hover shadow-sm" id="tablaCarreras">
                <thead class="text-center">
                    <tr>
                        <th>Nombre de Carrera</th>
                        <th>Facultad</th>
                        <th style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Carga dinámica -->
                </tbody>
            </table>
        </div>

        <div>
            <a href="configuracion_datos_base.php" class="btn btn-secondary mt-3">
                <i class="fa fa-arrow-left"></i> Volver a configuración
            </a>
        </div>
    </div>
</div>

<!-- Modal Carrera -->
<div class="modal fade" id="modalCarrera" tabindex="-1" role="dialog" aria-labelledby="modalCarreraLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow">
            <form id="formCarrera" enctype="multipart/form-data" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCarreraLabel">Agregar Carrera</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="carreraId" name="id">
                    <div class="mb-3">
                        <label for="nombreCarrera" class="form-label">Nombre de Carrera</label>
                        <input type="text" class="form-control" id="nombreCarrera" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="facultadCarrera" class="form-label">Facultad</label>
                        <select class="form-control" id="facultadCarrera" name="facultad" required>
                            <option value="">Seleccione...</option>
                            <!-- Opciones dinámicas -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="imagenCarrera" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="imagenCarrera" name="imagen" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarCarrera">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="../public/js/carreras.js"></script>

<?php include("partials/footer_Admin.php"); ?>
