<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php") ?>

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

    .titulo-seccion {
        color: var(--uta-rojo); /* Título de sección en rojo UTA */
        font-size: 2.2rem; /* Ajustado para consistencia */
        font-weight: 700;
        margin-bottom: 0.5rem; /* Ajustado para consistencia */
    }

    .descripcion-seccion {
        color: var(--uta-negro); /* Descripción en negro */
        font-size: 1.1rem; /* Ajustado para consistencia */
        margin-bottom: 1.5rem; /* Ajustado para consistencia */
    }

    .btn-uta {
        background-color: var(--uta-rojo); /* Botón principal en rojo UTA */
        color: var(--uta-blanco);
        border: none;
        transition: all 0.3s ease-in-out;
        font-weight: 500;
    }

    .btn-uta:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al hover */
        color: var(--uta-blanco); /* Asegurar texto blanco al hover */
    }

    .table > thead {
        background-color: var(--uta-rojo); /* Encabezado de tabla en rojo UTA */
        color: var(--uta-blanco);
    }

    /* Estilos para encabezados de tabla (th) y celdas (td) */
    .table th, .table td {
        vertical-align: middle;
        text-align: center; /* Centrado para el encabezado y contenido */
        border: 1px solid var(--uta-negro) !important; /* Bordes negros para todas las celdas */
    }

    /* Color de texto por defecto para celdas de datos */
    .table td {
        color: var(--uta-negro); /* Texto negro para las celdas por defecto */
        background-color: var(--uta-blanco); /* Fondo blanco para las celdas por defecto */
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

    /* Estilo específico para el botón de eliminar (si aplica, asumiendo btn-danger) */
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

    .modal-footer .btn-uta { /* Botón Guardar del modal */
        background-color: var(--uta-rojo);
        color: var(--uta-blanco);
        border: none;
    }
    .modal-footer .btn-uta:hover {
        background-color: var(--uta-rojo-oscuro);
        color: var(--uta-blanco);
    }

    .modal-footer .btn-default { /* Botón Cancelar del modal */
        background-color: var(--uta-negro); /* Negro */
        color: var(--uta-blanco); /* Texto blanco */
        border: none;
        transition: all 0.3s ease;
    }
    .modal-footer .btn-default:hover {
        background-color: var(--uta-rojo); /* Rojo al hover */
        color: var(--uta-blanco); /* Texto blanco */
    }

    .modal-content {
        border-radius: 0.5rem;
        border: 2px solid var(--uta-negro); /* Borde del modal en negro */
    }

    .form-control:focus {
        border-color: var(--uta-rojo); /* Borde de input en foco en rojo UTA */
        box-shadow: 0 0 0 0.2rem rgba(177, 0, 36, 0.25); /* Sombra en foco en rojo UTA */
    }

    /* Estilos para etiquetas de formulario */
    label {
        font-weight: 600;
        color: var(--uta-negro); /* Etiquetas en negro */
    }

    /* Botón "Volver a configuración" */
    .btn-default.mt-3 { /* Selector más específico para el botón de volver */
        border: 1px solid var(--uta-negro); /* Borde negro */
        color: var(--uta-negro); /* Texto negro */
        background-color: transparent;
        transition: all 0.3s ease;
    }
    .btn-default.mt-3:hover {
        background-color: var(--uta-rojo); /* Fondo rojo al hover */
        color: var(--uta-blanco); /* Texto blanco al hover */
        border-color: var(--uta-rojo); /* Borde rojo al hover */
    }
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <h3 class="titulo-seccion"><i class="fa fa-random"></i> Gestión de Modalidades de Evento</h3>
        <p class="descripcion-seccion">Administra las modalidades de evento disponibles en el sistema.</p>

        <div class="mb-3">
            <button class="btn btn-uta" id="btnAgregarModalidad"><i class="fa fa-plus"></i> Agregar Modalidad</button>
        </div>
        <br>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tablaModalidades">
                <thead>
                    <tr>
                        <th style="width: 25%;">Código</th>
                        <th>Nombre</th>
                        <th style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Se cargan dinámicamente -->
                </tbody>
            </table>
        </div>

        <div>
            <a href="configuracion_datos_base.php" class="btn btn-default mt-3">
                <i class="fa fa-arrow-left"></i> Volver a configuración
            </a>
        </div>
    </div>
</div>

<!-- Modal Modalidad -->
<div class="modal fade" id="modalModalidad" tabindex="-1" role="dialog" aria-labelledby="modalModalidadLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formModalidad">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalModalidadLabel"><i class="fa fa-plus-circle"></i> Registrar Modalidad</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white; font-size: 24px;">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="codigoModalidad">Código</label>
                        <input type="text" class="form-control" id="codigoModalidad" name="codigo" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="nombreModalidad">Nombre</label>
                        <input type="text" class="form-control" id="nombreModalidad" name="nombre" maxlength="50" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-uta">Guardar</button>
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
<script src="../public/js/modalidades.js"></script>

<?php include("partials/footer_Admin.php"); ?>
