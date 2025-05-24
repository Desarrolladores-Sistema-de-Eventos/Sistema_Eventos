<?php include("partials/header_Admin.php"); ?>
<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
        <div class="col-md-12">
        <h2><i class="fa fa-calendar"></i>Gestion Eventos</h2>
</div>
     </div> 
         <hr /> 
    <div class="panel panel-default">
      <div class="panel-heading">Lista de Eventos</div>
      <div class="panel-body">
        <!-- Botón que abre el modal -->
        <a href="#" class="btn btn-custom" data-toggle="modal" data-target="#modalEvento">
          <span class="icon-circle"><i class="fa fa-plus"></i></span> Nuevo
        </a>
        <br><br>
        <!-- Tabla de eventos -->
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-eventos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td class="text-center">
                                <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button> 
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- fin de Table -->
        <!-- Modal -->
        <div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="modalEventoLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modalEventoLabel"><i class="fa fa-edit"></i> Crear/Editar Evento</h4>
              </div>

              <div class="modal-body">
                <form id="formEvento" role="form">

                  <!-- Título y horas -->
                  <div class="row">
                    <div class="col-md-6">
                      <label for="titulo"><i class="fa fa-book"></i> Título del Evento</label>
                      <input type="text" class="form-control" id="titulo" placeholder="Ej: Congreso de Tecnología">
                    </div>
                    <div class="col-md-6">
                      <label for="horas"><i class="fa fa-clock-o"></i> Horas del Evento</label>
                      <input type="number" class="form-control" id="horas" min="20" step="0.1">
                    </div>
                  </div><br>

                  <!-- Descripción -->
                  <div class="form-group">
                    <label for="descripcion"><i class="fa fa-align-left"></i> Descripción del Evento</label>
                    <textarea class="form-control" id="descripcion" rows="3"></textarea>
                  </div>

                  <!-- Tipo, modalidad, categoría -->
                  <div class="row">
                    <div class="col-md-4">
                      <label for="tipoEvento"><i class="fa fa-folder-open"></i> Tipo de Evento</label>
                      <select class="form-control" id="tipoEvento"><option value="">Seleccione</option></select>
                    </div>
                    <div class="col-md-4">
                      <label for="modalidad"><i class="fa fa-random"></i> Modalidad</label>
                      <select class="form-control" id="modalidad"><option value="">Seleccione</option></select>
                    </div>
                    <div class="col-md-4">
                      <label for="categoria"><i class="fa fa-tags"></i> Categoría</label>
                      <select class="form-control" id="categoria"><option value="">Seleccione</option></select>
                    </div>
                  </div><br>

                  <!-- Fechas -->
                  <div class="row">
                    <div class="col-md-6">
                      <label for="fechaInicio"><i class="fa fa-calendar"></i> Fecha de Inicio</label>
                      <input type="date" class="form-control" id="fechaInicio">
                    </div>
                    <div class="col-md-6">
                      <label for="fechaFin"><i class="fa fa-calendar"></i> Fecha de Fin</label>
                      <input type="date" class="form-control" id="fechaFin">
                    </div>
                  </div><br>

                  <!-- Nota y pago -->
                  <div class="row">
                    <div class="col-md-6">
                      <label for="notaAprobacion"><i class="fa fa-check-circle"></i> Nota mínima de aprobación</label>
                      <input type="number" class="form-control" id="notaAprobacion" min="0" step="0.1">
                    </div>
                    <div class="col-md-6">
                      <label><i class="fa fa-money"></i> ¿El evento es pagado?</label><br>
                      <input type="checkbox" id="esPagado"> Sí
                    </div>
                  </div><br>

                  <!-- Costo -->
                  <div class="row" id="costoContainer" style="display: none;">
                    <div class="col-md-6">
                      <label for="costo">Costo ($)</label>
                      <input type="number" class="form-control" id="costo">
                    </div>
                  </div><br>

                  <!-- Facultad y carrera -->
                  <div class="row">
                    <div class="col-md-6">
                      <label for="facultad"><i class="fa fa-university"></i> Facultad</label>
                      <select class="form-control" id="facultad"><option value="">Seleccione</option></select>
                    </div>
                    <div class="col-md-6">
                      <label for="carrera"><i class="fa fa-graduation-cap"></i> Carrera</label>
                      <select class="form-control" id="carrera" disabled><option>Seleccione una facultad primero</option></select>
                    </div>
                  </div><br>

                  <!-- Público -->
                  <div class="form-group">
                    <label for="publicoDestino"><i class="fa fa-users"></i> ¿Quiénes pueden inscribirse?</label>
                    <select id="publicoDestino" class="form-control">
                      <option value="">Seleccione</option>
                      <option value="internos">Solo internos</option>
                      <option value="externos">Solo externos</option>
                      <option value="ambos">Internos y externos</option>
                    </select>
                  </div>

                  <!-- Certificado -->
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="otorgaCertificado"> <i class="fa fa-certificate"></i> Este evento otorga certificado
                    </label>
                  </div><br>

                  <!-- Requisitos -->
                  <h5><i class="fa fa-tasks"></i> Requisitos del Evento</h5>
                  <p class="text-muted">Seleccione al menos 2 requisitos necesarios para participar.</p>
                  <select id="requisitosSelect" class="form-control" multiple="multiple"></select><br>

                  <!-- Organizadores -->
                  <h5><i class="fa fa-user"></i> Organizadores del Evento</h5>
                  <p class="text-muted">Seleccione al menos 2 organizadores.</p>
                  <select id="organizadoresSelect" class="form-control" multiple="multiple"></select><br>

                  <!-- Botón guardar -->
                  <div class="text-right">
                    <button type="submit" class="btn btn-success">
                      <i class="fa fa-save"></i> Guardar Evento
                    </button>
                  </div>
                </form>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
  $('#requisitosSelect, #organizadoresSelect').select2({
    placeholder: "Seleccione una o más opciones",
    width: '100%'
  });

  $('#esPagado').change(function () {
    $('#costoContainer').toggle(this.checked);
  });

  $('#facultad').change(function () {
    const carrera = $('#carrera');
    carrera.html("<option>Cargando...</option>");
    carrera.prop("disabled", false);
    // Lógica AJAX aquí
  });
});
</script>

<?php include("partials/footer_Admin.php"); ?>
