<?php include("partials/header_Admin.php");?>
<?php 
$rolRequerido = 'ADMIN';
include("../core/auth.php")?>
<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
        <div class="col-md-12">
        <h2><i class="fa fa-calendar"></i> Gestión de Eventos</h2>
        </div>
    </div> 
    <hr /> 
    <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-list"></i> Lista de Eventos</div>
      <div class="panel-body">
        <button class="btn btn-primary mb-3" id="btn-nuevo" data-toggle="modal" data-target="#modalEvento">
          <i class="fa fa-plus"></i> Nuevo Evento
        </button>
        <div class="form-check mb-2">
          <label class="form-check-label">
            <input type="checkbox" id="mostrarCancelados" class="form-check-input">Mostrar eventos cancelados
          </label>
        </div>
        <br><br>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tabla-eventos">
            <thead class="thead-dark">
              <tr>
                <th>TÍTULO</th>
                <th>TIPO</th>
                <th>INICIO</th>
                <th>FINALIZACIÓN</th>
                <th>MODALIDAD</th>
                <th>HORAS</th>
                <th>COSTO</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        

<!-- Modal -->
        <div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="modalEventoLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content uta-evento">

              <div class="modal-header uta-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title uta-title" id="modalEventoLabel"><i class="fa fa-edit"></i> Crear/Editar Evento</h4>
              </div>
              <div class="modal-body">
  <form id="formEvento" role="form" enctype="multipart/form-data">

    <!-- Campo oculto para actualizar -->
    <input type="hidden" id="idEvento" name="idEvento">

    <!-- Título y horas -->
    <div class="row">
      <div class="col-md-6">
        <label for="titulo" class="uta-label"><i class="fa fa-book"></i> Título del Evento</label>
        <input type="text" class="form-control uta-input" id="titulo" name="titulo" placeholder="Ej: Congreso de Tecnología" required>
      </div>
      <div class="col-md-6">
        <label for="horas" class="uta-label"><i class="fa fa-clock-o"></i> Horas del Evento</label>
        <input type="number" class="form-control uta-input" id="horas" name="horas" min="1" step="0.1" required>
      </div>
    </div><br>

    <!-- Descripción -->
    <div class="form-group">
      <label for="descripcion" class="uta-label"><i class="fa fa-align-left"></i> Descripción del Evento</label>
      <textarea class="form-control uta-textarea" id="descripcion" name="descripcion" rows="3" required></textarea>
    </div>

    <!-- Tipo, modalidad, categoría -->
    <div class="row">
      <div class="col-md-4">
        <label for="tipoEvento" class="uta-label"><i class="fa fa-folder-open"></i> Tipo de Evento</label>
        <select class="form-control uta-select" id="tipoEvento" name="tipoEvento" required>
          <option value="">Seleccione</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="modalidad" class="uta-label"><i class="fa fa-random"></i> Modalidad</label>
        <select class="form-control uta-select" id="modalidad" name="modalidad" required>
          <option value="">Seleccione</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="categoria" class="uta-label"><i class="fa fa-tags"></i> Categoría</label>
        <select class="form-control uta-select" id="categoria" name="categoria" required>
          <option value="">Seleccione</option>
        </select>
      </div>
    </div><br>

    <!-- Fechas -->
    <div class="row">
      <div class="col-md-6">
        <label for="fechaInicio" class="uta-label"><i class="fa fa-calendar"></i> Fecha de Inicio</label>
        <input type="date" class="form-control uta-input" id="fechaInicio" name="fechaInicio" required>
      </div>
      <div class="col-md-6">
        <label for="fechaFin" class="uta-label"><i class="fa fa-calendar"></i> Fecha de Fin</label>
        <input type="date" class="form-control uta-input" id="fechaFin" name="fechaFin">
      </div>
    </div><br>

    <!-- Nota, asistencia y pagado/costo -->
    <div class="row">
      <div class="col-md-4" id="notaMinimaContainer" style="display:none;">
        <label for="notaAprobacion" class="uta-label"><i class="fa fa-check-circle"></i> Nota mínima de aprobación</label>
        <input type="number" class="form-control uta-input" id="notaAprobacion" name="notaAprobacion" min="0" step="0.1">
      </div>
      <div class="col-md-4" id="asistenciaMinimaContainer" style="display:none;">
        <label for="asistenciaMinima" class="uta-label"><i class="fa fa-check-circle"></i> Asistencia mínima (%)</label>
        <input type="number" class="form-control uta-input" id="asistenciaMinima" name="asistenciaMinima" min="0" max="100" step="0.1">
      </div>
      <div class="col-md-4">
      <div class="d-flex align-items-center" style="display: flex; align-items: center; gap: 15px; height: 60px;">
        <div class="form-group mb-0" style="margin-bottom:0; display: flex; align-items: center;">
          <label for="esPagado" class="uta-label" style="margin-bottom:0; margin-right:8px;"><i class="fa fa-certificate"></i> ¿Es pagado?</label>
          <input type="checkbox" id="esPagado" name="esPagado" style="margin-top:0; margin-right:8px;">
          <span style="margin-bottom:0;">Sí</span>
        </div>
        <div class="form-group mb-0" id="costoContainer" style="display:none; margin-bottom:0; min-width: 160px;">
          <label for="costo" class="uta-label" style="margin-bottom:0; margin-right:8px; white-space:nowrap;"><i class="fa fa-dollar"></i> Costo ($)</label>
          <input type="number" class="form-control uta-input" id="costo" name="costo" min="0" step="0.01" value="0" style="display:inline-block; width:100px;">
        </div>
      </div>
    </div>
    </div><br>

    <!-- Capacidad -->
    <div class="form-group">
      <label for="capacidad" class="uta-label"><i class="fa fa-users"></i> Capacidad del Evento</label>
      <input type="number" class="form-control uta-input" id="capacidad" name="capacidad" min="1" step="1" required>
    </div><br>

   <!-- Carrera -->
<div class="form-group">
  <label for="carrera" class="uta-label"><i class="fa fa-graduation-cap"></i> Carrera</label>
  <select class="form-control uta-select" id="carrera" name="carrera[]" multiple required>
    <option value="TODAS">Todas las carreras</option>
    <!-- Opciones dinámicas -->
  </select>
  <button type="button" id="btnLimpiarCarreras" class="btn btn-outline-secondary btn-sm mt-2" style="display:none;">Limpiar selección</button>
  <small class="text-muted">Puede seleccionar una o varias carreras.</small>
</div><br>

<script>
// Este bloque será reemplazado dinámicamente por el JS al cargar las carreras
window.idsTodasCarreras = [];
</script>

<!-- Responsable y Organizador (nuevo) -->
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="responsable" class="uta-label"><i class="fa fa-user-shield"></i> Responsable del Evento</label>
      <select class="form-control uta-select" id="responsable" name="responsable" required>
        <option value="">Seleccione</option>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="organizador" class="uta-label"><i class="fa fa-user"></i> Organizador del Evento</label>
      <select class="form-control uta-select" id="organizador" name="organizador" required>
        <option value="">Seleccione</option>
      </select>
    </div>
  </div>
</div>
<br>

<!-- Público destino -->
<div class="form-group">
  <label for="publicoDestino" class="uta-label"><i class="fa fa-users"></i> ¿Quiénes pueden inscribirse?</label>
    <select id="esSoloInternos" name="esSoloInternos" class="form-control uta-select" required>
      <option value="2">Todos</option>
      <option value="1">Internos</option>
      <option value="0">Externos</option>
    </select>
</div>

    <!-- Certificado -->
    <div class="form-group">
      <label for="esDestacado" class="uta-label"><i class="fa fa-star"></i> ¿Es un evento destacado?</label>
      <div class="checkbox">
        <label>
          <input type="checkbox" id="esDestacado" name="esDestacado"> Sí
        </label>
      </div>
    </div><br>
    <div class="form-group">
  <label for="requisitos" class="uta-label">Requisitos del evento</label>
  <div id="listaRequisitos" class="form-check">
  </div>
</div>

<!-- Imagen de Portada -->
<div class="form-group">
  <label for="urlPortada" class="uta-label"><i class="fa fa-image"></i> Imagen de Portada</label>
  <input type="file" class="form-control uta-input" id="urlPortada" name="urlPortada" accept="image/*">
</div>

<!-- Imagen de Galería -->
<div class="form-group">
  <label for="urlGaleria" class="uta-label"><i class="fa fa-picture-o"></i> Imagen de Galería</label>
  <input type="file" class="form-control uta-input" id="urlGaleria" name="urlGaleria" accept="image/*">
</div><br>

    <!-- Botón -->
    <div class="text-right">
      <button type="submit" id="btn-save" class="btn uta-btn">
        <i class="fa fa-save"></i> Guardar Evento
      </button>
    </div>
  </form>
</div>

<!-- Footer del modal -->
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
  </div>
              </div>
            </div>
          </div>

<!-- Fin modal -->
         

      </div>
    </div>
  </div>
</div>
    <!-- Scripts necesarios -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Choices.js CSS y JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="../public/js/eventoAdmin.js"></script>
<style>
/* --- Estilo profesional para el formulario de eventos (ADMIN) --- */
#formEvento {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 24px #0002;
  padding: 32px 24px 24px 24px;
  margin-bottom: 0;
}
#formEvento label {
  font-size: 0.97rem;
  color: #222;
  font-weight: 600;
  margin-bottom: 4px;
}
#formEvento .form-control, #formEvento .form-select {
  border-radius: 8px;
  border: 2px solid #8B0000;
  font-size: 1rem;
  margin-bottom: 8px;
  box-shadow: 0 1px 4px #0001;
  color: #222;
}
#formEvento .form-row {
  margin-bottom: 18px;
}
#formEvento .form-group {
  margin-bottom: 18px;
}
#formEvento .form-check-input {
  width: 1.3em;
  height: 1.3em;
  margin-right: 8px;
}
#formEvento .form-check-label {
  font-size: 1rem;
  margin-right: 18px;
}
#formEvento .btn.uta-btn {
  background: #fff;
  color: #8B0000;
  border: 2px solid #8B0000;
  border-radius: 8px;
  font-size: 1.1rem;
  padding: 10px 32px;
  box-shadow: 0 2px 8px #8B000022;
  font-weight: 600;
  transition: background 0.2s, color 0.2s;
}
#formEvento .btn.uta-btn:hover {
  background: #8B0000;
  color: #fff;
}
#formEvento .text-muted {
  font-size: 0.95em;
}
#formEvento .uta-label i {
  color: #8B0000;
  margin-right: 6px;
}
#formEvento .requisitos-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px 24px;
  margin-top: 8px;
}
@media (max-width: 768px) {
  #formEvento .form-row {
    flex-direction: column;
  }
  #formEvento .requisitos-grid {
    grid-template-columns: 1fr;
  }
}
/* Choices.js select de carreras */
#formEvento .choices__inner,
#formEvento .choices__list--dropdown,
#formEvento .choices__list[role='listbox'] {
  border: 2px solid #8B0000 !important;
  color: #222 !important;
  border-radius: 8px !important;
}
#formEvento .choices__input,
#formEvento .choices__item {
  color: #222 !important;
}
#formEvento .choices__list--dropdown .choices__item {
  color: #222 !important;
}
/* Checkboxes de requisitos: borde y fondo rojo institucional, y tamaño más grande */
#formEvento .form-check-input[type='checkbox'] {
  border: 2.5px solid #8B0000;
  background-color: #fff;
  border-radius: 4px;
  width: 1.5em;
  height: 1.5em;
  margin-right: 10px;
  accent-color: #8B0000; /* Para navegadores modernos */
}
#formEvento .form-check-input[type='checkbox']:checked {
  background-color: #8B0000;
  border-color: #8B0000;
}
#formEvento .form-check-label {
  color: #222;
  font-size: 1.15rem;
  margin-left: 8px;
  font-weight: 500;
}
/* Aumentar tamaño de fuente general del formulario */
#formEvento label,
#formEvento .form-control,
#formEvento .form-select,
#formEvento .choices__inner,
#formEvento .choices__item,
#formEvento .choices__input,
#formEvento .btn.uta-btn,
#formEvento .text-muted {
  font-size: 1.15rem !important;
}
#formEvento input,
#formEvento select,
#formEvento textarea {
  font-size: 1.15rem !important;
}
/* Tags de Choices.js (burbujas de selección) */
#formEvento .choices__list--multiple .choices__item {
  background: #fff !important;
  color: #000 !important;
  border: 2px solid #000 !important;
  border-radius: 20px !important;
  font-weight: 600;
  box-shadow: none !important;
}
#formEvento .choices__list--multiple .choices__item .choices__button {
  color: #000 !important;
  opacity: 1 !important;
}
#formEvento .choices__list--multiple .choices__item.is-highlighted {
  background: #eee !important;
  color: #000 !important;
}
#formEvento #listaRequisitos {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px 24px;
  margin-top: 8px;
}
@media (max-width: 768px) {
  #formEvento #listaRequisitos {
    grid-template-columns: 1fr;
  }
}
</style>
<?php include("partials/footer_Admin.php"); ?>
