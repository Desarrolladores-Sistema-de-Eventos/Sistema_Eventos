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
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalEventoLabel"><i class="fa fa-edit"></i> Crear/Editar Evento</h4>
              </div>
              <div class="modal-body">
  <form id="formEvento" role="form" enctype="multipart/form-data">

    <!-- Campo oculto para actualizar -->
    <input type="hidden" id="idEvento" name="idEvento">

    <!-- Título y horas -->
    <div class="row">
      <div class="col-md-6">
        <label for="titulo"><i class="fa fa-book"></i> Título del Evento</label>
        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Congreso de Tecnología" required>
      </div>
      <div class="col-md-6">
        <label for="horas"><i class="fa fa-clock-o"></i> Horas del Evento</label>
        <input type="number" class="form-control" id="horas" name="horas" min="1" step="0.1" required>
      </div>
    </div><br>

    <!-- Descripción -->
    <div class="form-group">
      <label for="descripcion"><i class="fa fa-align-left"></i> Descripción del Evento</label>
      <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
    </div>

    <!-- Tipo, modalidad, categoría -->
    <div class="row">
      <div class="col-md-4">
        <label for="tipoEvento"><i class="fa fa-folder-open"></i> Tipo de Evento</label>
        <select class="form-control" id="tipoEvento" name="tipoEvento" required>
          <option value="">Seleccione</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="modalidad"><i class="fa fa-random"></i> Modalidad</label>
        <select class="form-control" id="modalidad" name="modalidad" required>
          <option value="">Seleccione</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="categoria"><i class="fa fa-tags"></i> Categoría</label>
        <select class="form-control" id="categoria" name="categoria" required>
          <option value="">Seleccione</option>
        </select>
      </div>
    </div><br>

    <!-- Fechas -->
    <div class="row">
      <div class="col-md-6">
        <label for="fechaInicio"><i class="fa fa-calendar"></i> Fecha de Inicio</label>
        <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
      </div>
      <div class="col-md-6">
        <label for="fechaFin"><i class="fa fa-calendar"></i> Fecha de Fin</label>
        <input type="date" class="form-control" id="fechaFin" name="fechaFin">
      </div>
    </div><br>

    <!-- Nota y costo -->
    <div class="row">
      <div class="col-md-6">
        <label for="notaAprobacion"><i class="fa fa-check-circle"></i> Nota mínima de aprobación</label>
        <input type="number" class="form-control" id="notaAprobacion" name="notaAprobacion" min="0" step="0.1">
      </div>

      <div class="col-md-6">
        <label for="costo"><i class="fa fa-dollar"></i> Costo ($)</label>
        <input type="number" class="form-control" id="costo" name="costo" min="0" step="0.01" value="0" readonly>
      </div>
    </div><br>

    <!-- Capacidad -->
    <div class="form-group">
      <label for="capacidad"><i class="fa fa-users"></i> Capacidad del Evento</label>
      <input type="number" class="form-control" id="capacidad" name="capacidad" min="1" step="1" required>
    </div><br>

   <!-- Carrera -->
<div class="form-group">
  <label for="carrera"><i class="fa fa-graduation-cap"></i> Carrera</label>
  <select class="form-control" id="carrera" name="carrera" required>
    <option value="">Seleccione</option>
  </select>
</div><br>

<!-- Responsable y Organizador (nuevo) -->
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="responsable"><i class="fa fa-user-shield"></i> Responsable del Evento</label>
      <select class="form-control" id="responsable" name="responsable" required>
        <option value="">Seleccione</option>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="organizador"><i class="fa fa-user"></i> Organizador del Evento</label>
      <select class="form-control" id="organizador" name="organizador" required>
        <option value="">Seleccione</option>
      </select>
    </div>
  </div>
</div>
<br>

<!-- Público destino -->
<div class="form-group">
  <label for="publicoDestino"><i class="fa fa-users"></i> ¿Quiénes pueden inscribirse?</label>
    <select id="esSoloInternos" name="esSoloInternos" class="form-control" required>
      <option value="1">Internos</option>
      <option value="0">Externos</option>
    </select>
</div>

    <!-- Certificado -->
    <div class="form-group">
      <label for="esPagado"><i class="fa fa-certificate"></i> ¿Es pagado?</label>
      <div class="checkbox">
        <label>
          <input type="checkbox" id="esPagado" name="esPagado"> Sí
        </label>
      </div>
    </div><br>
    <div class="form-group">
  <label for="requisitos">Requisitos del evento</label>
  <div id="listaRequisitos" class="form-check">
  </div>
</div>

<!-- Imagen de Portada -->
<div class="form-group">
  <label for="urlPortada"><i class="fa fa-image"></i> Imagen de Portada</label>
  <input type="file" class="form-control" id="urlPortada" name="urlPortada" accept="image/*">
</div>

<!-- Imagen de Galería -->
<div class="form-group">
  <label for="urlGaleria"><i class="fa fa-picture-o"></i> Imagen de Galería</label>
  <input type="file" class="form-control" id="urlGaleria" name="urlGaleria" accept="image/*">
</div><br>

    <!-- Botón -->
    <div class="text-right">
      <button type="submit" id="btn-save" class="btn btn-success">
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="../public/js/eventoAdmin.js"></script>

<?php include("partials/footer_Admin.php"); ?>
