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
        font-weight: bold;
        color: var(--uta-rojo); /* Título en rojo UTA */
        font-size: 2.2rem; /* Ajustado para consistencia */
        margin-bottom: 0.5rem; /* Ajustado para consistencia */
    }

    .uta-subtitle, .descripcion-seccion {
        color: var(--uta-negro); /* Subtítulo/descripción en negro */
        font-size: 1.1rem; /* Ajustado para consistencia */
        margin-bottom: 1.5rem; /* Ajustado para consistencia */
    }

    .table-responsive {
        background: var(--uta-blanco); /* Fondo blanco */
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05); /* Sombra con negro */
        max-height: 600px;
        overflow-y: auto;
    }

    #tablaFacultades thead th {
        background-color: var(--uta-rojo); /* Encabezado de tabla en rojo UTA */
        color: var(--uta-blanco);
        font-weight: bold;
        text-align: center;
        border: 1px solid var(--uta-negro) !important; /* Bordes negros para el encabezado */
    }

    #tablaFacultades tbody td {
        vertical-align: middle;
        background-color: var(--uta-blanco); /* Fondo blanco por defecto */
        border: 1px solid var(--uta-negro) !important; /* Bordes negros para las celdas */
        color: var(--uta-negro); /* Texto negro por defecto */
        font-size: 14px;
        text-align: center; /* Centrado para el contenido de las celdas */
    }

    #tablaFacultades tbody tr:hover {
        background-color: var(--uta-rojo-oscuro); /* Fondo rojo oscuro al hover para la fila */
        cursor: pointer;
    }

    #tablaFacultades tbody tr:hover td {
        background-color: var(--uta-rojo-oscuro) !important; /* Fondo rojo oscuro para las celdas al hover */
        color: var(--uta-blanco) !important; /* Texto blanco en celdas al hover para legibilidad */
    }

    /* Botón "Agregar Facultad" */
    .btn-success {
        background-color: var(--uta-rojo); /* Rojo UTA */
        border-color: var(--uta-rojo);
        color: var(--uta-blanco);
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: var(--uta-rojo-oscuro);
        border-color: var(--uta-rojo-oscuro);
        color: var(--uta-blanco);
    }

    /* Botón "Guardar" del modal */
    .btn-primary {
        background-color: var(--uta-rojo);
        border-color: var(--uta-rojo);
        color: var(--uta-blanco);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--uta-rojo-oscuro);
        border-color: var(--uta-rojo-oscuro);
        color: var(--uta-blanco);
    }

    /* Botón "Cancelar" del modal y "Volver a configuración" */
    .btn-secondary {
        background-color: var(--uta-negro); /* Negro */
        color: var(--uta-blanco); /* Texto blanco */
        border: none;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: var(--uta-rojo); /* Rojo al hover */
        color: var(--uta-blanco); /* Texto blanco */
    }

    .modal-header {
        background-color: var(--uta-rojo); /* Encabezado del modal en rojo UTA */
        color: var(--uta-blanco);
        border-bottom: 2px solid var(--uta-negro); /* Borde inferior del modal en negro */
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .modal-title {
        font-weight: bold; /* Ajustado a bold para consistencia */
        color: var(--uta-blanco); /* Asegurar que el título del modal sea blanco */
    }

    .modal-header .close {
        color: var(--uta-blanco); /* Color del botón de cerrar en el modal header */
        opacity: 1; /* Asegurar visibilidad */
        font-size: 24px; /* Mantener tamaño original */
    }
    .modal-header .close:hover {
        color: var(--uta-negro); /* Color del botón de cerrar al hover */
    }

    .form-control:focus {
        border-color: var(--uta-rojo); /* Borde de input en foco en rojo UTA */
        box-shadow: 0 0 0 0.2rem rgba(177, 0, 36, 0.25); /* Sombra en foco en rojo UTA */
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

    /* Estilos para los botones de acción dentro de la tabla (Editar/Eliminar) */
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
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="mb-4">
            <h3 class="uta-title"><i class="fa fa-university me-2"></i> Gestión de Facultades</h3>
            <p class="descripcion-seccion">Administra las facultades disponibles en el sistema.</p>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-success shadow-sm" id="btnAgregarFacultad">
                <i class="fa fa-plus me-1"></i> Agregar Facultad
            </button>
            <a href="configuracion_datos_base.php" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Volver a configuración
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tablaFacultades">
                <thead class="text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Misión</th>
                        <th>Visión</th>
                        <th>Ubicación</th>
                        <th style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contenido dinámico -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para agregar/editar facultad -->
<div class="modal fade" id="modalFacultad" tabindex="-1" role="dialog" aria-labelledby="modalFacultadLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow-sm">
            <form id="formFacultad" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFacultadLabel">Agregar Facultad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="facultadId" name="id">

                    <div class="mb-3">
                        <label for="nombreFacultad" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreFacultad" name="nombre" maxlength="100" required>
                    </div>

                    <div class="mb-3">
                        <label for="misionFacultad" class="form-label">Misión</label>
                        <textarea class="form-control" id="misionFacultad" name="mision" maxlength="500" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="visionFacultad" class="form-label">Visión</label>
                        <textarea class="form-control" id="visionFacultad" name="vision" maxlength="500" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="ubicacionFacultad" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacionFacultad" name="ubicacion" maxlength="255" required>
                    </div>

                    <div class="mb-3">
                        <label for="siglaFacultad" class="form-label">Sigla</label>
                        <input type="text" class="form-control" id="siglaFacultad" name="sigla" maxlength="20">
                    </div>

                    <div class="mb-3">
                        <label for="aboutFacultad" class="form-label">Acerca de (Descripción)</label>
                        <textarea class="form-control" id="aboutFacultad" name="about" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="urlLogoFacultad" class="form-label">Logo (imagen)</label>
                        <input type="file" class="form-control" id="urlLogoFacultad" name="urlLogo" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="urlPortadaFacultad" class="form-label">Portada (imagen)</label>
                        <input type="file" class="form-control" id="urlPortadaFacultad" name="urlPortada" accept="image/*">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarFacultad">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/facultades.js"></script>

<?php include("partials/footer_Admin.php"); ?>
