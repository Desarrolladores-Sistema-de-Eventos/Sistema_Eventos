<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h2><i class="fa fa-tasks"></i> Solicitudes de Cambio</h2>
      </div>
    </div>
    <hr />

    <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-list"></i> Lista de Solicitudes</div>
      <div class="panel-body">

        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tabla-solicitudes">
            <thead class="thead-dark">
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Código de Cambio</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Ana Ruiz</td>
                <td>CAM-2024-001</td>
                <td>2025-06-01</td>
                <td>Pendiente</td>
                <td>
                  <button type="button" class="btn btn-info btn-ver"
                    data-toggle="tooltip" title="Ver solicitud"
                    data-nombre="Ana Ruiz"
                    data-codigo="CAM-2024-001"
                    data-fecha="2025-06-01"
                    data-modulo="Matrícula">
                    <i class="fa fa-eye"></i>
                  </button>

                  <button type="button" class="btn btn-success btn-evaluar"
                    data-toggle="tooltip" title="Evaluar cambio"
                    data-nombre="Ana Ruiz"
                    data-codigo="CAM-2024-001"
                    data-fecha="2025-06-01"
                    data-modulo="Matrícula">
                    <i class="fa fa-pencil"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Modal Evaluación Técnica -->
        <div class="modal fade" id="modalEvaluacion" tabindex="-1" role="dialog" aria-labelledby="modalEvaluacionLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="modalEvaluacionLabel"><i class="fa fa-edit"></i> Evaluación Técnica del Cambio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <form id="formEvaluacion">
                  <div class="panel panel-info">
                    <div class="panel-heading"><i class="fa fa-info-circle"></i> Información general</div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-6">
                          <label><i class="fa fa-barcode"></i> Código del cambio</label>
                          <input type="text" class="form-control" id="codigo" name="codigo" readonly>
                        </div>
                        <div class="col-md-6">
                          <label><i class="fa fa-user"></i> Nombre del solicitante</label>
                          <input type="text" class="form-control" id="solicitante" name="solicitante" readonly>
                        </div>
                      </div><br>
                      <div class="row">
                        <div class="col-md-6">
                          <label><i class="fa fa-calendar"></i> Fecha de solicitud</label>
                          <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud" readonly>
                        </div>
                        <div class="col-md-6">
                          <label><i class="fa fa-cubes"></i> Módulo afectado</label>
                          <input type="text" class="form-control" id="modulo" name="modulo" readonly>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-warning">
                    <div class="panel-heading"><i class="fa fa-sliders"></i> Evaluación técnica</div>
                    <div class="panel-body">
                      <div class="form-group">
                        <label><i class="fa fa-tasks"></i> Tipo de cambio (ITIL)</label><br>
                        <label class="radio-inline"><input type="radio" name="tipo_itil" value="Estándar"> Estándar</label>
                        <label class="radio-inline"><input type="radio" name="tipo_itil" value="Normal"> Normal</label>
                        <label class="radio-inline"><input type="radio" name="tipo_itil" value="Emergencia"> Emergencia</label>
                      </div>

                      <div class="form-group">
                        <label><i class="fa fa-exclamation-triangle"></i> Prioridad</label><br>
                        <label class="radio-inline"><input type="radio" name="prioridad" value="Alta"> Alta</label>
                        <label class="radio-inline"><input type="radio" name="prioridad" value="Media"> Media</label>
                        <label class="radio-inline"><input type="radio" name="prioridad" value="Baja"> Baja</label>
                      </div>

                      <div class="form-group">
                        <label><i class="fa fa-wrench"></i> Categoría técnica</label>
                        <select class="form-control" id="categoria" name="categoria">
                          <option>Frontend / Interfaz</option>
                          <option>Backend / Lógica del sistema</option>
                          <option>Base de datos</option>
                          <option>API o integraciones</option>
                          <option>Seguridad / autenticación</option>
                          <option>Otro</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label><i class="fa fa-lightbulb-o"></i> Evaluación técnica / impacto</label>
                        <textarea class="form-control" id="evaluacion" name="evaluacion" rows="2"></textarea>
                      </div>

                      <div class="form-group">
                        <label><i class="fa fa-thumbs-up"></i> Beneficios del cambio</label>
                        <textarea class="form-control" id="beneficios" name="beneficios" rows="2"></textarea>
                      </div>

                      <div class="form-group">
                        <label><i class="fa fa-thumbs-down"></i> Impacto de no realizar el cambio</label>
                        <textarea class="form-control" id="impacto_negativo" name="impacto_negativo" rows="2"></textarea>
                      </div>

                      <div class="form-group">
                        <label><i class="fa fa-list-ul"></i> Acciones requeridas</label>
                        <textarea class="form-control" id="acciones" name="acciones" rows="2"></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-success">
                    <div class="panel-heading"><i class="fa fa-check-circle"></i> Decisión y seguimiento</div>
                    <div class="panel-body">
                      <div class="form-group">
                        <label><i class="fa fa-balance-scale"></i> Decisión</label><br>
                        <label class="radio-inline"><input type="radio" name="estado" value="Aprobado"> Aprobado</label>
                        <label class="radio-inline"><input type="radio" name="estado" value="Rechazado"> Rechazado</label>
                        <label class="radio-inline"><input type="radio" name="estado" value="Más información"> Solicita más info</label>
                      </div>

                      <div class="form-group">
                        <label><i class="fa fa-comments"></i> Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
                      </div>

                      <div class="form-group">
                        <label><i class="fa fa-calendar-check-o"></i> Fecha de decisión</label>
                        <input type="date" class="form-control" id="fecha_decision" name="fecha_decision">
                      </div>

                      <div class="form-group">
                        <label><i class="fa fa-user-circle"></i> Responsable técnico</label>
                        <input type="text" class="form-control" id="responsable" name="responsable">
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Guardar evaluación</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div> <!-- Fin modal -->

      </div>
    </div>
  </div>
</div>

<!-- Scripts necesarios -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();

  $('.btn-ver').click(function () {
    const nombre = $(this).data('nombre');
    const codigo = $(this).data('codigo');
    const fecha = $(this).data('fecha');
    const modulo = $(this).data('modulo');

    Swal.fire({
      title: 'Solicitud de ' + nombre,
      html: `<b>Código:</b> ${codigo}<br><b>Fecha:</b> ${fecha}<br><b>Módulo:</b> ${modulo}`,
      icon: 'info'
    });
  });

  $('.btn-evaluar').click(function () {
    const nombre = $(this).data('nombre');
    const codigo = $(this).data('codigo');
    const fecha = $(this).data('fecha');
    const modulo = $(this).data('modulo');

    $('#formEvaluacion')[0].reset();
    $('#solicitante').val(nombre);
    $('#codigo').val(codigo);
    $('#fecha_solicitud').val(fecha);
    $('#modulo').val(modulo);

    setTimeout(() => {
      $('#modalEvaluacion').modal('show');
    }, 100);
  });

  $('#formEvaluacion').submit(function (e) {
    e.preventDefault();
    Swal.fire('Guardado', 'Evaluación registrada (simulada).', 'success');
    $('#modalEvaluacion').modal('hide');
  });
});
</script>

<?php include("partials/footer_Admin.php"); ?>
