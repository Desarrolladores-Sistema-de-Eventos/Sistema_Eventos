<?php include("partials/header_Admin.php"); ?>
<?php
$requiereResponsable = true;
include("../core/auth.php")
  ?>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-md-12 d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
        <h2 style="margin-bottom: 0;"><i class="fa fa-calendar"></i> Gestión de Eventos</h2>
        <button class="btn btn-primary mb-3" id="btn-nuevo">
          <i class="fa fa-plus-square-o"></i> Nuevo
        </button>
      </div>
    </div>
     <div class="titulo-linea"></div>
    
    <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-list"></i> Lista de Eventos</div>
      <div class="panel-body">
        <!-- Botón Nuevo movido arriba -->
        <ul class="nav nav-tabs" id="tabsEstados">
          <li class="active"><a data-toggle="tab" href="#tab-disponible">Disponible</a></li>
          <li><a data-toggle="tab" href="#tab-curso">En Curso</a></li>
          <li><a data-toggle="tab" href="#tab-finalizado">Finalizado</a></li>
          <li><a data-toggle="tab" href="#tab-cancelado">Cancelado</a></li>
        </ul>
        <div class="tab-content" style="background: #fff; padding: 20px;">
          <div id="tab-disponible" class="tab-pane fade in active">
            <div id="tabla-disponible"></div>
          </div>
          <div id="tab-curso" class="tab-pane fade">
            <div id="tabla-curso"></div>
          </div>
          <div id="tab-finalizado" class="tab-pane fade">
            <div id="tabla-finalizado"></div>
          </div>
          <div id="tab-cancelado" class="tab-pane fade">
            <div id="tabla-cancelado"></div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="modalEventoLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modalEventoLabel"><i class="fa fa-edit"></i> Crear/Editar Evento</h4>
              </div>
              <div class="modal-body">
                <!-- Formulario de gestión de eventos para responsables, estructurado igual que el admin -->
<form id="formEventoRes" role="form" enctype="multipart/form-data">
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
  <!-- Tipo, modalidad, categoría, estado y público destino -->
  <div class="row">
    <div class="col-md-3">
      <label for="tipoEvento" class="uta-label"><i class="fa fa-folder-open"></i> Tipo de Evento</label>
      <select class="form-control uta-select" id="tipoEvento" name="tipoEvento" required>
        <option value="">Seleccione</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="modalidad" class="uta-label"><i class="fa fa-random"></i> Modalidad</label>
      <select class="form-control uta-select" id="modalidad" name="modalidad" required>
        <option value="">Seleccione</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="categoria" class="uta-label"><i class="fa fa-tags"></i> Categoría</label>
      <select class="form-control uta-select" id="categoria" name="categoria" required>
        <option value="">Seleccione</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="estado" class="uta-label"><i class="fa fa-flag"></i> Estado</label>
      <select class="form-control" id="estado" name="estado" required>
        <!-- Opciones dinámicas -->
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <label for="publicoDestino" class="uta-label"><i class="fa fa-users"></i> Público Destino</label>
      <select class="form-control" id="publicoDestino" name="publicoDestino" required>
        <option value="TODOS">Todos</option>
        <option value="INTERNOS">Solo internos</option>
        <option value="EXTERNOS">Solo externos</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="fechaInicio" class="uta-label"><i class="fa fa-calendar"></i> Fecha de Inicio</label>
      <input type="date" class="form-control uta-input" id="fechaInicio" name="fechaInicio" required>
    </div>
    <div class="col-md-3">
      <label for="fechaFin" class="uta-label"><i class="fa fa-calendar"></i> Fecha de Fin</label>
      <input type="date" class="form-control uta-input" id="fechaFin" name="fechaFin">
    </div>
    <div class="col-md-3">
      <label for="capacidad" class="uta-label"><i class="fa fa-users"></i> Capacidad del Evento</label>
      <input type="number" class="form-control uta-input" id="capacidad" name="capacidad" min="1" step="1" required>
    </div>
  </div>
  <!-- Nota, asistencia y pagado/costo -->
  <div class="row">
    <div class="col-md-4" id="notaAprobacionGroup" style="display:none;">
      <label for="notaAprobacion" class="uta-label"><i class="fa fa-check-circle"></i> Nota mínima de aprobación</label>
      <input type="number" class="form-control uta-input" id="notaAprobacion" name="notaAprobacion" min="0" step="0.1">
    </div>
    <div class="col-md-4" id="asistenciaMinimaGroup" style="display:none;">
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
        <div class="form-group mb-0" id="costoGroup" style="display:none; margin-bottom:0; min-width: 160px;">
          <label for="costo" class="uta-label" style="margin-bottom:0; margin-right:8px; white-space:nowrap;"><i class="fa fa-dollar"></i> Costo ($)</label>
          <input type="number" class="form-control uta-input" id="costo" name="costo" min="0" step="0.01" value="0" style="display:inline-block; width:100px;">
        </div>
      </div>
    </div>
  </div><br>
  <!-- Carreras -->
  <div class="form-group">
    <label for="carreras" class="uta-label"><i class="fa fa-graduation-cap"></i> Carreras</label>
    <select class="form-control uta-select" id="carreras" name="carreras[]" multiple>
      <!-- Opciones dinámicas -->
    </select>
    <button type="button" id="btnLimpiarCarreras" class="btn btn-outline-secondary btn-sm mt-2" style="display:none;">Limpiar selección</button>
    <small class="text-muted">Puede seleccionar una o varias carreras.</small>
  </div><br>
  <!-- Requisitos -->
  <div class="form-group">
    <label for="requisitos" class="uta-label">Requisitos del evento</label>
    <div id="listaRequisitos" class="form-check">
      <div class="form-check me-3">
        <input class="form-check-input" type="checkbox" id="reqCedula" name="requisitos[]" value="cedula" checked disabled>
        <label class="form-check-label" for="reqCedula">Cédula o documento de identidad</label>
      </div>
      <span id="requisitosExtras"></span>
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
  </div>
  <!-- Botón -->
  <div class="text-right">
    <button type="submit" id="btn-save-res" class="btn uta-btn">
      <i class="fa fa-save"></i> Guardar Evento
    </button>
  </div>
</form>

<!-- Choices.js para carreras -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<!-- Eliminar la inicialización embebida de Choices.js aquí para evitar doble inicialización y conflictos -->

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
<style>
  body {
    background-color: #fff;
    color: #000;
    font-family: Arial, sans-serif;
  }
  .alert-info {
  background-color: #ffd6d6 !important; /* Rojo claro */
  color: #222 !important;               /* Letra negra */
  border-color: #ffb3b3 !important;     /* Borde rojo suave */
}

  .panel-heading {
    background: rgb(27, 26, 26) !important;
    color: #fff !important;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    border-bottom: 2px solid #7b2020;
     font-weight: normal;
     font-size: 14px;

  }
   h2 {
    font-size: 24px;
    color: rgb(23, 23, 23);
    font-weight: bold;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  

  .panel-heading {
    background:rgb(185, 51, 51);
    color: #fff;
    
  }
 select.form-control {
    border: 1.5px solid #9b2e2e;
    border-radius: 6px;
    font-size: 14px;
    background: #f9fafb;
    color: #222;
    transition: border-color 0.2s;
  }
   th.nombre-columna, td.nombre-columna {
  max-width: 100px;
  width: 100px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* Botón PDF estilo claro con icono */
.btn-primary {
  background: #f3f3f3;
  color: #222;
  border: none;
  border-radius: 8px;
  padding: 6px 16px;
  font-size: 15px;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: none;
  transition: background 0.2s;
  font-weight: normal;
  font-size: 14px;

}
.btn-primary:hover {
  background: #e0e0e0;
  color: #b32d2d;
}

.btn-secundary {
  background: #f3f3f3;
  color: #222;
  border: none;
  border-radius: 8px;
  padding: 6px 16px;
  font-size: 15px;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: none;
  transition: background 0.2s;
}
.btn-secundary:hover {
  background: #e0e0e0;
  color: #b32d2d;
}
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: #c0392b !important;
  border-color: #c0392b !important;
  color: white !important;
  box-shadow: none !important;
  outline: none !important;
}
thead {
  background-color: rgb(180, 34, 34);
  color: white;
  font-size: 14px;
  font-weight: normal;
}
.table {
  width: 100% !important;
  max-width: 90vw !important;
  margin: 0 auto;
}
.table th, .table td {
  padding: 12px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ddd;
  font-size: 14px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.table th {
  background-color: rgb(180, 34, 34);
  color: #fff;
  font-weight: normal;
}
h4 {
  font-size: 14px;
  
}
label{
  font-weight: normal;
  font-size: 14px;
}
p{
  font-size: 14px;
  font-weight: normal;
}
hr{
  border-top: 2px solid #9b2e2e;
  opacity: 1;
}
.dataTables_length label,
.dataTables_length select {
  font-size: 14px !important;
}
 .titulo-linea {
    border-bottom: 2px solid rgb(185, 51, 51);
    margin-top: 6px;
    margin-bottom: 20px;
  }
  /* Tabs UTA institucional */
.nav-tabs > li > a {
  color: #222 !important; /* Negro para inactivos */
}
.nav-tabs > li > a:hover {
  background: #c0392b !important;
  color: #fff !important;
}

/* --- Estilo profesional para el formulario de eventos --- */
#formEventoRes {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 24px #0002;
  padding: 32px 24px 24px 24px;
  margin-bottom: 0;
}
/* Colores institucionales con rojo oscuro pero más claro para mejor contraste */
#formEventoRes label {
  font-size: 0.97rem;
  color: #222;
  font-weight: 600;
  margin-bottom: 4px;
}
#formEventoRes .form-control, #formEventoRes .form-select {
  border-radius: 8px;
  border: 2px solid #8B0000;
  font-size: 1rem;
  margin-bottom: 8px;
  box-shadow: 0 1px 4px #0001;
  color: #222;
}
#formEventoRes .form-row {
  margin-bottom: 18px;
}
#formEventoRes .form-group {
  margin-bottom: 18px;
}
#formEventoRes .form-check-input {
  width: 1.3em;
  height: 1.3em;
  margin-right: 8px;
}
#formEventoRes .form-check-label {
  font-size: 1rem;
  margin-right: 18px;
}
#formEventoRes .btn.uta-btn {
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
#formEventoRes .btn.uta-btn:hover {
  background: #8B0000;
  color: #fff;
}
#formEventoRes .text-muted {
  font-size: 0.95em;
}
#formEventoRes .uta-label i {
  color: #8B0000;
  margin-right: 6px;
}
#formEventoRes .requisitos-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px 24px;
  margin-top: 8px;
}
@media (max-width: 768px) {
  #formEventoRes .form-row {
    flex-direction: column;
  }
  #formEventoRes .requisitos-grid {
    grid-template-columns: 1fr;
  }
}
/* Choices.js select de carreras */
#formEventoRes .choices__inner,
#formEventoRes .choices__list--dropdown,
#formEventoRes .choices__list[role='listbox'] {
  border: 2px solid #8B0000 !important;
  color: #222 !important;
  border-radius: 8px !important;
}
#formEventoRes .choices__input,
#formEventoRes .choices__item {
  color: #222 !important;
}
#formEventoRes .choices__list--dropdown .choices__item {
  color: #222 !important;
}
/* Checkboxes de requisitos: borde y fondo rojo institucional, y tamaño más grande */
#formEventoRes .form-check-input[type='checkbox'] {
  border: 2.5px solid #8B0000;
  background-color: #fff;
  border-radius: 4px;
  width: 1.5em;
  height: 1.5em;
  margin-right: 10px;
  accent-color: #8B0000; /* Para navegadores modernos */
}
#formEventoRes .form-check-input[type='checkbox']:checked {
  background-color: #8B0000;
  border-color: #8B0000;
}
#formEventoRes .form-check-label {
  color: #222;
  font-size: 1.15rem;
  margin-left: 8px;
  font-weight: 500;
}
/* Aumentar tamaño de fuente general del formulario */
#formEventoRes label,
#formEventoRes .form-control,
#formEventoRes .form-select,
#formEventoRes .choices__inner,
#formEventoRes .choices__item,
#formEventoRes .choices__input,
#formEventoRes .btn.uta-btn,
#formEventoRes .text-muted {
  font-size: 1.15rem !important;
}
#formEventoRes input,
#formEventoRes select,
#formEventoRes textarea {
  font-size: 1.15rem !important;
}
/* Tags de Choices.js (burbujas de selección) */
#formEventoRes .choices__list--multiple .choices__item {
  background: #fff !important;
  color: #000 !important;
  border: 2px solid #000 !important;
  border-radius: 20px !important;
  font-weight: 600;
  box-shadow: none !important;
}
#formEventoRes .choices__list--multiple .choices__item .choices__button {
  color: #000 !important;
  opacity: 1 !important;
}
#formEventoRes .choices__list--multiple .choices__item.is-highlighted {
  background: #eee !important;
  color: #000 !important;
}
#formEventoRes #listaRequisitos {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px 24px;
  margin-top: 8px;
}
@media (max-width: 768px) {
  #formEventoRes #listaRequisitos {
    grid-template-columns: 1fr;
  }
}
</style>
<!-- Scripts necesarios -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/eve_Res.js"></script>
<?php include("partials/footer_Admin.php"); ?>

</body>
</html>
