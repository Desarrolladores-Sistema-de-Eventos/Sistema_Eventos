<?php include("partials/header_Admin.php");?>
<?php 
$rolRequerido = 'ADMIN';
include("../core/auth.php")?>
<style>
    /* Definición de colores principales: ÚNICAMENTE ROJO, BLANCO Y NEGRO */
    :root {
        --uta-rojo: #b10024; /* Rojo principal de UTA */
        --uta-rojo-oscuro: #92001c; /* Tono más oscuro de rojo para hover */
        --uta-negro: #000000;
        --uta-blanco: #ffffff;
    }

    /* Encabezados principales */
    h2, #modalUsuarioLabel {
        color: var(--uta-rojo); /* Títulos en rojo */
        font-weight: 600;
    }

    .panel-heading {
        background-color: var(--uta-rojo); /* Fondo rojo */
        color: var(--uta-blanco); /* Texto blanco */
        font-weight: bold;
    }

    /* Botones */
    .btn-primary {
        background-color: var(--uta-rojo); /* Botón primario en rojo */
        border: none;
        color: var(--uta-blanco); /* Texto blanco */
    }

    .btn-primary:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al hover */
        color: var(--uta-blanco); /* Texto blanco */
    }

    .btn-success {
        background-color: var(--uta-rojo); /* Botón de éxito en rojo */
        border: none;
        color: var(--uta-blanco); /* Texto blanco */
    }

    .btn-success:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al hover */
        color: var(--uta-blanco); /* Texto blanco */
    }

    .btn-danger {
        background-color: var(--uta-rojo); /* Botón de peligro ahora es rojo */
        border: none;
        color: var(--uta-blanco); /* Texto blanco */
    }

    .btn-danger:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al hover para peligro */
        color: var(--uta-blanco); /* Texto blanco */
    }

    .btn-secondary {
        background-color: var(--uta-negro); /* Botón secundario en negro */
        color: var(--uta-blanco); /* Texto blanco */
        border: none;
    }

    .btn-secondary:hover {
        background-color: var(--uta-rojo); /* Rojo al hover para secundario */
        color: var(--uta-blanco); /* Texto blanco */
    }

    /* Tabla */
    #tabla-usuarios {
        background: var(--uta-blanco); /* Fondo blanco */
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); /* Sombra con negro */
        width: 100%; /* Asegura que la tabla ocupe todo el ancho disponible */
        border-collapse: collapse; /* Elimina el espacio entre las celdas */
    }

    #tabla-usuarios thead {
        background-color: var(--uta-rojo); /* Encabezado de tabla en rojo */
        color: var(--uta-blanco); /* Texto blanco */
    }
    #tabla-usuarios thead th {
        border: 1px solid var(--uta-negro); /* Bordes de encabezado en negro */
        padding: 8px; /* Espaciado interno */
        text-align: left; /* Alineación del texto */
    }

    /* Estilo para las filas y celdas por defecto */
    #tabla-usuarios tbody tr td {
        background-color: var(--uta-blanco); /* Fondo blanco por defecto para todas las celdas */
        color: var(--uta-negro); /* Texto negro por defecto para todas las celdas */
        border: 1px solid var(--uta-negro); /* Bordes de celdas en negro */
        padding: 8px; /* Espaciado interno */
    }

    /* Estilo para las filas al pasar el ratón (hover) */
    #tabla-usuarios tbody tr:hover td {
        background-color: var(--uta-rojo-oscuro) !important; /* ¡FORZADO: Fondo rojo oscuro para las celdas al hover! */
        color: var(--uta-blanco) !important; /* ¡FORZADO: Texto blanco en celdas al hover para legibilidad! */
    }

    /* Eliminada la clase table-striped de Bootstrap para evitar conflictos */
    #tabla-usuarios tbody tr:nth-child(odd) {
        background-color: var(--uta-blanco);
    }
    #tabla-usuarios tbody tr:nth-child(even) {
        background-color: var(--uta-blanco);
    }

    /* Formularios */
    label {
        font-weight: 600;
        color: var(--uta-negro); /* Etiquetas en negro */
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid var(--uta-negro); /* Borde de inputs en negro */
        color: var(--uta-negro); /* Texto de inputs en negro */
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .modal-content {
        border: 2px solid var(--uta-negro); /* Borde del modal en negro */
        border-radius: 12px;
    }

    .modal-header {
        background-color: var(--uta-rojo); /* Fondo del header del modal en rojo */
        color: var(--uta-blanco); /* Texto blanco */
        border-bottom: 2px solid var(--uta-negro); /* Borde inferior en negro */
    }
    .modal-header .modal-title {
        color: var(--uta-blanco); /* Asegurar que el título del modal sea blanco */
    }
    .modal-header .close {
        color: var(--uta-blanco); /* Color del botón de cerrar en el modal header */
        opacity: 1; /* Asegurar visibilidad */
    }
    .modal-header .close:hover {
        color: var(--uta-negro); /* Color del botón de cerrar al hover */
    }


    .modal-footer {
        border-top: 1px solid var(--uta-negro); /* Borde superior en negro */
    }

    .form-check-label {
        font-size: 14px;
        color: var(--uta-negro); /* Texto de label de checkbox en negro */
    }

    .form-check-input {
        transform: scale(1.2);
        margin-right: 5px;
        accent-color: var(--uta-rojo); /* Color de marcado del checkbox en rojo */
    }

    .form-text.text-muted {
        font-size: 12px;
        color: var(--uta-negro); /* Texto muted en negro */
    }
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
            <h2><i class="fa fa-users"></i> Gestión de Usuarios</h2>
            </div>
        </div> 
        <hr /> 
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-list"></i> Lista de Usuarios</div>
            <div class="panel-body">
                <button class="btn btn-primary mb-3" id="btn-nuevo-usuario" data-toggle="modal" data-target="#modalUsuario">
                    <i class="fa fa-user-plus"></i> Nuevo Usuario
                </button>
                <BR></BR>
                <div class="form-check mb-2">
                    <label class="form-check-label">
                        <input type="checkbox" id="mostrarInactivos" class="form-check-input"> Mostrar usuarios inactivos
                    </label>
                </div>
                <br><br>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tabla-usuarios"> <!-- Eliminada la clase table-striped -->
                        <thead class="thead-dark">
                            <tr>
                                <th>NOMBRES</th>
                                <th>APELLIDOS</th>
                                <th>CÉDULA</th>
                                <th>TELÉFONO</th>
                                <th>DIRECCIÓN</th>
                                <th>CORREO</th>
                                <th>ROL</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal para Añadir/Editar Usuario -->
                <div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalUsuarioLabel">➕ REGISTRO / EDICIÓN DE USUARIO</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formUsuario" enctype="multipart/form-data">
                                    <input type="hidden" id="idUsuario" name="id">
                                    <div class="form-group">
                                        <label for="nombres">📛 Nombres:</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellidos">📛 Apellidos:</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="correo">📧 Correo:</label>
                                        <input type="email" class="form-control" id="correo" name="correo" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contrasena">🔒 Contraseña:</label>
                                        <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="new-password">
                                        <small id="contrasenaHelp" class="form-text text-muted">Dejar vacío para no cambiar (solo en edición).</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="codigorol">🧑‍🏫 Rol:</label>
                                        <select class="form-control" id="codigorol" name="codigorol"required >
                                            <option value="">Seleccione</option>
                                            <option value="EST">Estudiante</option>
                                            <option value="DOC">Docente</option>
                                            <option value="INV">Invitado</option>
                                            <option value="ADM">Administrador</option>
                                        </select>
                                        <input type="hidden" id="codigorol_hidden" name="codigorol_hidden">

                                    </div>
                                    <div class="form-group">
                                        <label for="telefono">📱 Teléfono:</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion">🏠 Dirección:</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion">
                                    </div>
                                    <div class="form-group">
                                            <div class="form-group">
                                        <label for="fecha_nacimiento">🎂 Fecha de Nacimiento:</label>
                                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required max="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                        <label for="es_interno">🏢 Es Interno:</label>
                                        <select class="form-control" id="es_interno" name="es_interno" required>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cedula">🆔 Cédula:</label>
                                        <input type="text" class="form-control" id="cedula" name="cedula" required pattern="^\d{10}$" maxlength="10" title="Ingrese 10 dígitos numéricos">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="cedula_pdf">📄 Cédula (PDF):</label>
                                        <input type="file" class="form-control-file" id="cedula_pdf" name="cedula_pdf" accept="application/pdf">
                                        <small class="form-text text-muted">Solo PDF. Opcional en edición si ya existe.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto_perfil">🖼️ Foto de Perfil:</label>
                                        <input type="file" class="form-control-file" id="foto_perfil" name="foto_perfil">
                                    </div>
                                    <div class="form-group">
                                        <label for="estado">🟢 Estado:</label>
                                        <select class="form-control" id="estado" name="estado" required>
                                            <option value="ACTIVO">Activo</option>
                                            <option value="INACTIVO">Inactivo</option>
                                            <option value="BLOQUEADO">Bloqueado</option>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary" id="btn-save-usuario">💾 Guardar usuario</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">❌ Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de Confirmación de Eliminación -->
                <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmar Eliminación</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">¿Está seguro que desea eliminar a <strong id="userNameToDelete"></strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
</div>
    <!-- Scripts necesarios -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/usuario.js"></script>
<script>
document.getElementById('cedula_pdf')?.addEventListener('change', function() {
    if (this.files.length > 0) {
        const file = this.files[0];
        if (file.type !== 'application/pdf') {
            Swal.fire('Archivo inválido', 'Solo se permite subir archivos PDF para la cédula.', 'warning');
            this.value = '';
        }
    }
});
</script>
<?php include("partials/footer_Admin.php"); ?>
