<?php include("partials/head_Admin.php"); ?>

<div id="page-wrapper">
<div id="page-inner">

<h2 class="text-primary">Gestión de Eventos</h2>
<h5>Desde aquí puedes crear, buscar y listar eventos.</h5>
<hr />

<!-- 🔧 FORMULARIO CREAR/EDITAR EVENTO -->
<form id="formEvento">
    <div class="form-group">
        <label for="titulo">Título del Evento</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required>
        <input type="hidden" id="eventoId" name="eventoId">

    </div>

    <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="fechainicio">Fecha Inicio</label>
            <input type="date" class="form-control" id="fechainicio" name="fechainicio" required>
        </div>
        <div class="form-group col-md-6">
            <label for="fechafin">Fecha Fin</label>
            <input type="date" class="form-control" id="fechafin" name="fechafin" required>
        </div>
    </div>

    <div class="form-group">
        <label for="tipoevento">Tipo de Evento</label>
        <select class="form-control" id="tipoevento" name="tipoevento">
            <option value="CURSO">Curso</option>
            <option value="CONGRESO">Congreso</option>
        </select>
    </div>

    <div class="form-group">
        <label for="modalidad">Modalidad</label>
        <select class="form-control" id="modalidad" name="modalidad">
            <option value="VIRTUAL">Virtual</option>
            <option value="PRESENCIAL">Presencial</option>
        </select>
    </div>

    <div class="form-group">
        <label for="horas">Horas</label>
        <input type="number" class="form-control" id="horas" name="horas" required>
    </div>

    <div class="form-group">
        <label for="notaaprobacion">Nota Aprobación</label>
        <input type="number" step="0.01" class="form-control" id="notaaprobacion" name="notaaprobacion">
    </div>

    <div class="form-group">
        <label for="espagado">¿Es Pagado?</label>
        <select class="form-control" id="espagado" name="espagado">
            <option value="1">Sí</option>
            <option value="0">No</option>
        </select>
    </div>

   <div class="form-group" id="grupoCosto">
    <label for="costo">Costo</label>
    <input type="number" step="0.01" class="form-control" id="costo" name="costo">
</div>


    <div class="form-group">
        <label for="internos">¿Solo para Internos?</label>
        <select class="form-control" id="internos" name="internos">
            <option value="1">Sí</option>
            <option value="0">No</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar Evento</button>
</form>

<hr class="my-4">

<!-- 🔍 BÚSQUEDA Y FILTROS -->
<div class="row mb-3">
    <div class="col-md-4">
        <input type="text" id="buscarNombre" class="form-control" placeholder="Buscar por título...">
    </div>
    <div class="col-md-4">
        <input type="date" id="buscarFecha" class="form-control" placeholder="Buscar por fecha...">
    </div>
    <div class="col-md-4">
        <select id="filtrarEstado" class="form-control">
            <option value="">Filtrar por estado</option>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select>
    </div>
</div>

<!-- 📋 TABLA DE EVENTOS -->
<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Título</th>
            <th>Fecha Inicio</th>
            <th>Modalidad</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="tablaEventos">
        <!-- Aquí irán los eventos cargados dinámicamente más adelante -->
    </tbody>
</table>

</div> <!-- /#page-inner -->
</div> <!-- /#page-wrapper -->

<?php include("partials/footer_Admin.php"); ?>

<script>

// 👉 Función vacía para editar (la usarás cuando conectes con el backend)
function editarEvento(evento) {
    document.getElementById("eventoId").value = evento.id;
    document.getElementById("titulo").value = evento.titulo;
    document.getElementById("descripcion").value = evento.descripcion;
    document.getElementById("fechainicio").value = evento.fechainicio;
    document.getElementById("fechafin").value = evento.fechafin;
    document.getElementById("tipoevento").value = evento.tipoevento;
    document.getElementById("modalidad").value = evento.modalidad;
    document.getElementById("horas").value = evento.horas;
    document.getElementById("notaaprobacion").value = evento.notaaprobacion;
    document.getElementById("espagado").value = evento.espagado;
    document.getElementById("costo").value = evento.costo;
    document.getElementById("internos").value = evento.internos;
    document.querySelector("#formEvento button").textContent = "Actualizar Evento";
}

// 👉 Inicializar al cargar
document.addEventListener("DOMContentLoaded", () => {
    // Comportamiento para mostrar/ocultar campo costo
    document.getElementById("espagado").addEventListener("change", toggleCosto);
    toggleCosto();

    // Filtros (quedarán activos cuando tengas datos del backend)
    document.getElementById("buscarNombre").addEventListener("input", function () {
        // Aquí luego aplicarás búsqueda cuando tengas eventos reales
    });

    document.getElementById("buscarFecha").addEventListener("input", function () {
        // Aquí luego aplicarás búsqueda por fecha real
    });

    document.getElementById("filtrarEstado").addEventListener("change", function () {
        // Aquí luego aplicarás filtro por estado real
    });
});
</script>


