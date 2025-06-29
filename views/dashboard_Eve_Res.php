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
        <button class="btn btn-primary mb-3" id="btn-nuevo" data-toggle="modal" data-target="#modalEvento" style="margin-bottom: 0;">
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
                <form id="formEvento" role="form" enctype="multipart/form-data">

                  <!-- Campo oculto para actualizar -->
                  <input type="hidden" id="idEvento" name="idEvento">

                  <!-- Título y horas -->
                  <div class="row">
                    <div class="col-md-6">
                      <label for="titulo"><i class="fa fa-book"></i> Título del Evento</label>
                      <input type="text" class="form-control" id="titulo" name="titulo"
                        placeholder="Ej: Congreso de Tecnología" required>
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
                      <input type="number" class="form-control" id="notaAprobacion" name="notaAprobacion" min="0"
                        step="0.1">
                    </div>
                    <div class="col-md-6" id="grupoCosto">
                      <label for="costo"><i class="fa fa-dollar"></i> Costo ($)</label>
                      <input type="number" class="form-control" id="costo" name="costo" min="0" step="0.01">
                    </div>
                  </div>



                  <!-- Carrera -->
                  <div class="row">
                    <div class="col-md-6">
                      <label for="carrera"><i class="fa fa-graduation-cap"></i> Carrera</label>
                      <select class="form-control" id="carrera" name="carrera" required>
                        <option value="">Seleccione</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="capacidad"><i class="fa fa-users"></i> Capacidad</label>
                      <input type="number" class="form-control" id="capacidad" name="capacidad" min="1" required>
                    </div>

                  </div><br>

                  <!-- Público destino -->
                  <div class="form-group">
                    <label for="publicoDestino"><i class="fa fa-users"></i> ¿Quiénes pueden inscribirse?</label>
                    <select id="publicoDestino" name="publicoDestino" class="form-control" required>
                      <option value="internos">Internos</option>
                      <option value="externos">Externos</option>
                    </select>
                  </div><br>

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
                  <!-- Estado -->
                  <div class="form-group">
                    <label for="estado"><i class="fa fa-flag"></i> Estado del Evento</label>
                    <select id="estado" name="estado" class="form-control" required></select>
                  </div><br>
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
                      <i class="fa fa-floppy-o"></i> Guardar Evento
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
