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

    .section-title {
        color: var(--uta-rojo); /* Título de sección en rojo UTA */
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .section-desc { /* Unificado para la descripción */
        color: var(--uta-negro); /* Descripción en negro */
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
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

    /* Color de texto por defecto para celdas de datos */
    .table td {
        color: var(--uta-negro); /* Texto negro para las celdas por defecto */
    }

    .table tbody tr:hover td {
        background-color: var(--uta-rojo-oscuro) !important; /* Fondo rojo oscuro al hover */
        color: var(--uta-blanco) !important; /* Texto blanco al hover */
    }

    /* Estilos para los botones dentro de las celdas de acción */
    /* Botón de Editar (asumo que es el que tiene el borde negro y fondo blanco) */
    .table td .btn-primary { /* Assuming edit button is btn-primary */
        background-color: var(--uta-blanco); /* Fondo blanco */
        color: var(--uta-negro); /* Texto negro */
        border: 1px solid var(--uta-negro); /* Borde negro */
        padding: 5px 8px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .table td .btn-primary:hover {
        background-color: var(--uta-rojo); /* Fondo rojo al hover */
        color: var(--uta-blanco); /* Texto blanco al hover */
        border-color: var(--uta-rojo); /* Borde rojo al hover */
    }

    /* Botón de Eliminar (asumo que es el que tiene el fondo rojo) */
    .table td .btn-danger {
        background-color: var(--uta-rojo); /* Fondo rojo */
        color: var(--uta-blanco); /* Texto blanco */
        border: 1px solid var(--uta-rojo); /* Borde rojo */
        padding: 5px 8px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .table td .btn-danger:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al hover */
        color: var(--uta-blanco); /* Texto blanco al hover */
        border-color: var(--uta-rojo-oscuro); /* Borde rojo oscuro al hover */
    }

    /* Iconos dentro de los botones */
    .table td .btn-primary i {
        color: var(--uta-negro); /* Icono de editar negro por defecto */
    }

    .table td .btn-primary:hover i {
        color: var(--uta-blanco); /* Icono de editar blanco al hover */
    }

    .table td .btn-danger i {
        color: var(--uta-blanco); /* Icono de eliminar blanco */
    }

    .modal-header {
        background-color: var(--uta-rojo); /* Encabezado del modal en rojo UTA */
        color: var(--uta-blanco);
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        border-bottom: 2px solid var(--uta-negro); /* Borde inferior del modal en negro */
    }

    .modal-title {
        font-weight: bold;
        color: var(--uta-blanco); /* Asegurar que el título del modal sea blanco */
    }

    .modal-header .close {
        color: var(--uta-blanco); /* Color del botón de cerrar en el modal header */
        opacity: 1; /* Asegurar visibilidad */
    }
    .modal-header .close:hover {
        color: var(--uta-negro); /* Color del botón de cerrar al hover */
    }

    .modal-footer .btn-primary {
        background-color: var(--uta-rojo); /* Botón primario del modal en rojo UTA */
        border: none;
        color: var(--uta-blanco);
    }

    .modal-footer .btn-primary:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al hover */
        color: var(--uta-blanco);
    }

    .modal-content {
        border-radius: 0.5rem;
        border: 2px solid var(--uta-negro); /* Borde del modal en negro */
    }

    .form-control:focus {
        border-color: var(--uta-rojo); /* Borde de input en foco en rojo UTA */
        box-shadow: 0 0 0 0.2rem rgba(177, 0, 36, 0.25); /* Sombra en foco en rojo UTA */
    }

    .shadow-box {
        background-color: var(--uta-blanco); /* Fondo de caja de sombra en blanco */
        padding: 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    /* Estilos para etiquetas de formulario */
    label {
        font-weight: 600;
        color: var(--uta-negro); /* Etiquetas en negro */
    }

    /* Estilos para checkboxes inline */
    .checkbox-inline label {
        color: var(--uta-negro); /* Texto de checkbox en negro */
    }
    .checkbox-inline input[type="checkbox"] {
        transform: scale(1.2);
        margin-right: 5px;
        accent-color: var(--uta-rojo); /* Color de marcado del checkbox en rojo */
    }

    /* Botón "Volver a configuración" */
    .btn-outline-secondary {
        border: 1px solid var(--uta-negro); /* Borde negro */
        color: var(--uta-negro); /* Texto negro */
        background-color: transparent;
        transition: all 0.3s ease;
    }
    .btn-outline-secondary:hover {
        background-color: var(--uta-rojo); /* Fondo rojo al hover */
        color: var(--uta-blanco); /* Texto blanco al hover */
        border-color: var(--uta-rojo); /* Borde rojo al hover */
    }

</style>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="mb-4">
            <h3 class="section-title"><i class="fa fa-tags me-2"></i> Gestión de Tipos de Evento</h3>
            <p class="descripcion-seccion">Administra los tipos de evento disponibles en el sistema.</p>


            <button class="btn btn-uta shadow-sm mb-3" id="btnAgregarTipoEvento">
                <i class="fa fa-plus me-2"></i> Agregar Tipo de Evento
            </button>
        </div>

        <div class="table-responsive shadow-box">
            <table class="table table-bordered table-hover" id="tablaTiposEvento">
                <thead>
                    <tr>
                        <th style="width: 15%;">Código</th>
                        <th style="width: 25%;">Nombre</th>
                        <th>Descripción</th>
                        <th style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Se cargan dinámicamente -->
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="configuracion_datos_base.php" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> Volver a configuración
            </a>
        </div>
    </div>
</div>

<!-- Modal Tipo de Evento -->
<div class="modal fade" id="modalTipoEvento" tabindex="-1" role="dialog" aria-labelledby="modalTipoEventoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formTipoEvento">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTipoEventoLabel">
                        <i class="fa fa-edit me-2"></i> Formulario de Tipo de Evento
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="codigoTipoEvento">Código</label>
                        <input type="text" class="form-control" id="codigoTipoEvento" name="codigo" maxlength="20" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nombreTipoEvento">Nombre</label>
                        <input type="text" class="form-control" id="nombreTipoEvento" name="nombre" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcionTipoEvento">Descripción</label>
                        <textarea class="form-control" id="descripcionTipoEvento" name="descripcion" maxlength="500"></textarea>
                    </div>
                    <!-- INICIO: Campos agregados para requerir nota/asistencia -->
                    <div class="form-group">
                        <label for="controlesTipoEvento">Requerimientos de control</label><br>
                        <div class="checkbox-inline">
                            <label><input type="checkbox" id="REQUIERENOTA" name="REQUIERENOTA"> Requiere Nota</label>
                        </div>
                        <div class="checkbox-inline">
                            <label><input type="checkbox" id="REQUIEREASISTENCIA" name="REQUIEREASISTENCIA"> Requiere Asistencia</label>
                        </div>
                    </div>
                    <!-- FIN: Campos agregados para requerir nota/asistencia -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts necesarios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="../public/js/tipoevento.js"></script>

<?php include("partials/footer_Admin.php"); ?>
