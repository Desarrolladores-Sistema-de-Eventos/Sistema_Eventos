<?php include("partials/header_Admin.php"); ?>

<!-- Contenedor principal con scroll y margen del sidebar -->
<div id="page-wrapper" style="margin-left: 260px; height: 100vh; overflow-y: auto;">
    <div class="container-fluid py-4" style="min-height: 100%; background-color: #f5f5f5;">
        
        <!-- Encabezado -->
        <h2 class="text-danger mb-1">
            <i class="fa fa-calendar-plus"></i> Configuración de Eventos
        </h2>

        <!-- Tarjeta principal -->
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-light">
                <h4 class="mb-0"><i class="fa fa-edit"></i> Nuevo Evento</h4>
            </div>

            <div class="card-body">
                 <!-- Título y horas -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="titulo">
                                <i class="fas fa-book-open"></i> Título del Evento
                            </label>
                            <input type="text" class="form-control" id="titulo" placeholder="Ej: Congreso de Tecnología">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="horas">
                              <i class="fas fa-clock"></i> Horas del Evento
                            </label>
                            <input type="number" class="form-control" id="horas" min="20" step="0.1">
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="descripcion">
                            <i class="fas fa-list-alt"></i> Descripción del Evento
                        </label>
                        <textarea class="form-control" id="descripcion" rows="3"></textarea>
                    </div>

                    <!-- Tipo, modalidad, categoría -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tipoEvento">
                              <i class="fas fa-folder-open"></i> Tipo de Evento
                            </label>
                            <select class="form-control" id="tipoEvento">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="modalidad">
                              <i class="fas fa-random"></i> Modalidad
                            </label>
                            <select class="form-control" id="modalidad">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="categoria">
                              <i class="fas fa-tags"></i> Categoría
                            </label>
                            <select class="form-control" id="categoria">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                    </div>

                    <!-- Fechas -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fechaInicio">
                              <i class="fas fa-calendar-alt"></i> Fecha de Inicio
                            </label>
                            <input type="date" class="form-control" id="fechaInicio">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fechaFin">
                              <i class="fas fa-calendar-alt"></i> Fecha de Fin
                            </label>
                            <input type="date" class="form-control" id="fechaFin">
                        </div>
                    </div>

                    <!-- Nota y pago -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="notaAprobacion">
                              <i class="fas fa-check-circle"></i> Nota mínima de aprobación
                            </label>
                            <input type="number" class="form-control" id="notaAprobacion" min="0" step="0.1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="d-block">
                             <i class="fas fa-dollar-sign"></i> ¿El evento es pagado?
                            </label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="esPagado">
                                <label class="form-check-label" for="esPagado">Sí</label>
                            </div>
                        </div>
                    </div>

                    <!-- Costo -->
                    <div class="row" id="costoContainer" style="display: none;">
                        <div class="col-md-6 mb-3">
                            <label for="costo">Costo ($)</label>
                            <input type="number" class="form-control" id="costo">
                        </div>
                    </div>

                    <!-- Facultad y carrera -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="facultad">
                              <i class="fas fa-university"></i> Facultad
                            </label>
                            <select class="form-control" id="facultad">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="carrera">
                              <i class="fas fa-graduation-cap"></i> Carrera
                            </label>
                            <select class="form-control" id="carrera" disabled>
                                <option value="">Seleccione una facultad primero</option>
                            </select>
                        </div>
                    </div>

                    <!-- Publico destino -->
                    <div class="mb-3">
                        <label for="publicoDestino">
                          <i class="fas fa-users"></i> ¿Quiénes pueden inscribirse?
                        </label>
                        <select id="publicoDestino" name="publicoDestino" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="internos">Solo internos</option>
                            <option value="externos">Solo externos</option>
                            <option value="ambos">Internos y externos</option>
                        </select>
                    </div>

                    <!-- Certificado -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="otorgaCertificado" name="otorgaCertificado">
                        <label class="form-check-label" for="otorgaCertificado">
                            <i class="fas fa-certificate"></i> Este evento otorga certificado 
                        </label>
                    </div>

                    <!-- Requisitos -->
                    <h5 class="mt-4"><i class="fa fa-tasks"></i> Requisitos del Evento</h5>
                    <p class="text-muted">Seleccione al menos 2 requisitos necesarios para participar en este evento.</p>
                    <select id="requisitosSelect" name="requisitos[]" class="form-control" multiple="multiple">
                        <!-- Opciones se llenarán desde la base de datos vía PHP o AJAX -->
                    </select>

                    <!-- Organizadores -->
                    <h5 class="mt-4"><i class="fa fa-user-cog"></i> Organizadores del Evento</h5>
                    <p class="text-muted">Seleccione al menos 2 usuarios que coordinarán o liderarán el evento.</p>
                    <select id="organizadoresSelect" name="organizadores[]" class="form-control" multiple="multiple">
                        <!-- Opciones se llenarán desde la base de datos vía PHP o AJAX -->
                    </select>
                    
                    <br>
                    <!-- Botón de guardar -->
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fa fa-save"></i> Guardar Evento
                        </button>
                    </div>
                     <br>
                     <br><br>
  

                <form id="formEvento">...</form>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {
    $('#requisitosSelect, #organizadoresSelect').select2({
        placeholder: "Seleccione una o más opciones",
        width: '100%'
    });
});

document.getElementById("esPagado").addEventListener("change", function () {
    document.getElementById("costoContainer").style.display = this.checked ? "block" : "none";
});

document.getElementById("facultad").addEventListener("change", function () {
    const carrera = document.getElementById("carrera");
    carrera.innerHTML = "<option>Cargando...</option>";
    carrera.disabled = false;
    // futura llamada AJAX
});
</script>

<?php include("partials/footer_Admin.php"); ?>
