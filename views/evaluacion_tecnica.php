<?php include("partials/header_Admin.php"); ?>
<?php
$rolRequerido = 'ADMIN';
include("../core/auth.php"); ?>

<style>
  :root {
    --uta-rojo: #8B0000;
    --uta-rojo-hover: #6e0000;
    --uta-dorado: #DAA520;
    --uta-texto: #333;
    --uta-gris-claro: #f9f9f9;
  }

  h2 {
    color: var(--uta-rojo);
    font-weight: 700;
    font-size: 2.2rem;
    margin-bottom: 1rem;
    text-align: center;
  }

  .panel {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    border: 1px solid #ddd;
    overflow: hidden;
  }

  .panel-heading {
    background-color: var(--uta-gris-claro);
    padding: 1rem 1.5rem;
    font-weight: 600;
    font-size: 1.1rem;
    border-bottom: 1px solid #e3e3e3;
    color: var(--uta-texto);
  }

  .panel-body {
    padding: 1.5rem;
  }

  .table thead {
    background-color: var(--uta-rojo);
    color: #fff;
  }

  .btn-info, .btn-success {
    font-weight: 500;
    border-radius: 6px;
  }

  .btn-info:hover {
    background-color: #1473a3;
  }

  .btn-success:hover {
    background-color: var(--uta-rojo);
    border-color: var(--uta-rojo);
  }

  .btn-secondary:hover {
    background-color: #666;
  }

  .modal-header {
    background-color: var(--uta-rojo);
    color: white;
    border-bottom: 1px solid #ccc;
  }

  .modal-title {
    font-size: 1.3rem;
    font-weight: 600;
  }

  .form-group label {
    font-weight: 500;
    color: #333;
  }

  .form-control, textarea {
    border-radius: 6px;
    border: 1px solid #ccc;
  }

  .panel-info, .panel-warning, .panel-success {
    border-left: 4px solid var(--uta-rojo);
    margin-bottom: 2rem;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  }

  .panel-info .panel-heading,
  .panel-warning .panel-heading,
  .panel-success .panel-heading {
    background-color: #f4f4f4;
    font-weight: bold;
    font-size: 1rem;
    border-bottom: 1px solid #ddd;
    padding: 0.75rem 1rem;
  }

  .panel-body .form-group {
    margin-bottom: 1.2rem;
  }

  .modal-footer .btn {
    min-width: 130px;
  }

  .btn-danger {
    background-color: var(--uta-rojo);
    border: none;
  }

  .btn-danger:hover {
    background-color: var(--uta-rojo-hover);
  }

  .is-invalid {
    border-color: red !important;
    background-color: #ffeaea !important;
  }

  .swal2-popup ul {
    text-align: left;
    padding-left: 1.2em;
  }
</style>


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
  <?php
  require_once("../core/Conexion.php");
  $conn = Conexion::getConexion();

  $stmt = $conn->query("
  SELECT sc.*, u.NOMBRES, u.APELLIDOS
  FROM solicitud_cambio sc
  JOIN usuario u ON sc.SECUENCIAL_USUARIO = u.SECUENCIAL
  ORDER BY sc.FECHA_ENVIO DESC
");

  $i = 1;

  while ($row = $stmt->fetch()) {
    $nombre = htmlspecialchars($row['NOMBRES'] . ' ' . $row['APELLIDOS']);
    $codigo = htmlspecialchars($row['SECUENCIAL']);
    $fecha = htmlspecialchars($row['FECHA_ENVIO']);
    $estado = htmlspecialchars($row['ESTADO']);
    $modulo = htmlspecialchars($row['MODULO_AFECTADO']);
  ?>

    <tr>
      <td><?= $i++ ?></td>
      <td><?= $nombre ?></td>
      <td><?= $codigo ?></td>
      <td><?= $fecha ?></td>
      <td><?= $estado ?></td>
      <td>
        <button type="button" class="btn btn-info btn-ver"
          data-toggle="tooltip" title="Ver solicitud"
          data-nombre="<?= $nombre ?>"
          data-codigo="<?= $codigo ?>"
          data-fecha="<?= $fecha ?>"
          data-modulo="<?= $modulo ?>">
          <i class="fa fa-eye"></i>
        </button>

        <button type="button" class="btn btn-success btn-evaluar"
          data-toggle="tooltip" title="Evaluar cambio"
          data-nombre="<?= $nombre ?>"
          data-codigo="<?= $codigo ?>"
          data-fecha="<?= $fecha ?>"
          data-modulo="<?= $modulo ?>">
          <i class="fa fa-pencil"></i>
        </button>
      </td>
    </tr>
  <?php } ?>
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
                <form id="formEvaluacion" method="POST" action="../controllers/guardar_evaluacion.php">
                  <div class="panel panel-info">
                    <div class="panel-heading">Información general</div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Código del cambio</label>
                          <input type="text" class="form-control" id="SECUENCIAL_CAMBIO" name="SECUENCIAL_CAMBIO" readonly>
                        </div>
                        <div class="col-md-6">
                          <label>Nombre del solicitante</label>
                          <input type="text" class="form-control" id="solicitante" name="solicitante" readonly>
                        </div>
                      </div><br>
                      <div class="row">
                        <div class="col-md-6">
                          <label>Fecha de solicitud</label>
                          <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud" readonly>
                        </div>
                        <div class="col-md-6">
                          <label>Módulo afectado</label>
                          <input type="text" class="form-control" id="modulo" name="modulo" readonly>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-warning">
                    <div class="panel-heading">Evaluación técnica</div>
                    <div class="panel-body">
                      <div class="form-group">
                        <label>Tipo de cambio (ITIL)</label><br>
                        <label class="radio-inline"><input type="radio" name="TIPO_ITIL" value="Estándar"> Estándar</label>
                        <label class="radio-inline"><input type="radio" name="TIPO_ITIL" value="Normal"> Normal</label>
                        <label class="radio-inline"><input type="radio" name="TIPO_ITIL" value="Emergencia"> Emergencia</label>
                      </div>

                      <div class="form-group">
                        <label>Prioridad</label><br>
                        <label class="radio-inline"><input type="radio" name="PRIORIDAD" value="Alta"> Alta</label>
                        <label class="radio-inline"><input type="radio" name="PRIORIDAD" value="Media"> Media</label>
                        <label class="radio-inline"><input type="radio" name="PRIORIDAD" value="Baja"> Baja</label>
                      </div>

                      <div class="form-group">
                        <label>Categoría técnica</label>
                        <select class="form-control" name="CATEGORIA_TECNICA">
                          <option value="">-- Seleccione --</option>
                          <option>Frontend / Interfaz</option>
                          <option>Backend / Lógica del sistema</option>
                          <option>Base de datos</option>
                          <option>API o integraciones</option>
                          <option>Seguridad / autenticación</option>
                          <option>Otro</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Evaluación técnica / impacto</label>
                        <textarea class="form-control" name="EVALUACION" rows="2"></textarea>
                      </div>

                      <div class="form-group">
                        <label>Beneficios del cambio</label>
                        <textarea class="form-control" name="BENEFICIOS" rows="2"></textarea>
                      </div>

                      <div class="form-group">
                        <label>Impacto de no realizar el cambio</label>
                        <textarea class="form-control" name="IMPACTO_NEGATIVO" rows="2"></textarea>
                      </div>

                      <div class="form-group">
                        <label>Acciones requeridas</label>
                        <textarea class="form-control" name="ACCIONES" rows="2"></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-success">
                    <div class="panel-heading">Decisión y seguimiento</div>
                    <div class="panel-body">
                      <div class="form-group">
                        <label>Decisión</label><br>
                        <label class="radio-inline"><input type="radio" name="DECISION" value="Aprobado"> Aprobado</label>
                        <label class="radio-inline"><input type="radio" name="DECISION" value="Rechazado"> Rechazado</label>
                        <label class="radio-inline"><input type="radio" name="DECISION" value="Más información"> Solicita más info</label>
                      </div>

                      <div class="form-group">
                        <label>Observaciones</label>
                        <textarea class="form-control" name="OBSERVACIONES" rows="2"></textarea>
                      </div>

                      <div class="form-group">
                        <label>Fecha de decisión</label>
                        <input type="date" class="form-control" name="FECHA_DECISION" id="FECHA_DECISION" readonly onkeydown="return false;">
                      </div>

                      <div class="form-group">
                        <label>Responsable técnico</label>
                        <input type="text" class="form-control" name="RESPONSABLE_TECNICO">
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
    const fecha = $(this).data('fecha').substring(0, 10);
    const modulo = $(this).data('modulo');

    $('#formEvaluacion')[0].reset();
    $('#solicitante').val(nombre);
    $('#SECUENCIAL_CAMBIO').val(codigo);
    $('#fecha_solicitud').val(fecha);
    $('#modulo').val(modulo);

     const hoy = new Date().toISOString().split("T")[0];
  $('#FECHA_DECISION').val(hoy);

    $('#formEvaluacion .form-control, #formEvaluacion textarea').removeClass('is-invalid');
    $('#modalEvaluacion').modal('show');
  });

$('#formEvaluacion').submit(function (e) {
  e.preventDefault();

  let errores = [];

  $('#formEvaluacion .form-control, #formEvaluacion textarea').removeClass('is-invalid');

  function marcarInvalido(selector) {
    $(selector).addClass('is-invalid');
  }

  const tipo = $('input[name="TIPO_ITIL"]:checked').val();
  const prioridad = $('input[name="PRIORIDAD"]:checked').val();
  const categoria = $('select[name="CATEGORIA_TECNICA"]').val();
  const evaluacion = $('textarea[name="EVALUACION"]');
  const beneficios = $('textarea[name="BENEFICIOS"]');
  const impacto = $('textarea[name="IMPACTO_NEGATIVO"]');
  const acciones = $('textarea[name="ACCIONES"]');
  const decision = $('input[name="DECISION"]:checked').val();
  const fecha_decision = $('input[name="FECHA_DECISION"]');
  const responsable = $('input[name="RESPONSABLE_TECNICO"]');
  const codigo = $('#SECUENCIAL_CAMBIO').val();

  const hoy = new Date().toISOString().split("T")[0];
  $('#FECHA_DECISION').val(hoy); // Asignar fecha actual

  if (!tipo) errores.push("Selecciona un tipo de cambio.");
  if (!prioridad) errores.push("Selecciona la prioridad.");
  if (!categoria) {
    errores.push("Selecciona la categoría técnica.");
    marcarInvalido('select[name="CATEGORIA_TECNICA"]');
  }
  if (evaluacion.val().trim().length < 10) {
    errores.push("Evaluación técnica debe tener mínimo 10 caracteres.");
    marcarInvalido(evaluacion);
  }
  if (beneficios.val().trim().length < 10) {
    errores.push("Beneficios deben tener mínimo 10 caracteres.");
    marcarInvalido(beneficios);
  }
  if (impacto.val().trim().length < 10) {
    errores.push("Impacto negativo debe tener mínimo 10 caracteres.");
    marcarInvalido(impacto);
  }
  if (acciones.val().trim().length < 10) {
    errores.push("Acciones requeridas deben tener mínimo 10 caracteres.");
    marcarInvalido(acciones);
  }
  if (!decision) errores.push("Selecciona una decisión.");
  if (responsable.val().trim() === "") {
    errores.push("Responsable técnico es obligatorio.");
    marcarInvalido(responsable);
  }
  if (!fecha_decision.val()) {
    errores.push("La fecha de decisión es obligatoria.");
    marcarInvalido(fecha_decision);
  } else if (fecha_decision.val() > hoy) {
    errores.push("La fecha de decisión no puede estar en el futuro.");
    marcarInvalido(fecha_decision);
  }

  if (errores.length > 0) {
    Swal.fire({
      icon: 'warning',
      title: 'Formulario incompleto o inválido',
      html: '<ul style="text-align:left;">' + errores.map(e => `<li>${e}</li>`).join('') + '</ul>'
    });
    return;
  }

  const formData = $(this).serialize();

  $.post('../controllers/guardar_evaluacion.php', formData)
    .done(function () {
      Swal.fire({
        icon: 'success',
        title: 'Evaluación guardada',
        text: 'La evaluación técnica ha sido registrada correctamente.'
      }).then(() => {
        $('#modalEvaluacion').modal('hide');
        $('#formEvaluacion')[0].reset();

        // Actualizar estado en la tabla
        const fila = $(`button.btn-evaluar[data-codigo="${codigo}"]`).closest('tr');
        fila.find('td:nth-child(5)').text(decision); // Columna de estado

        // Deshabilitar botón de evaluación
        fila.find('.btn-evaluar').prop('disabled', true).removeClass('btn-success').addClass('btn-secondary');
      });
    })
    .fail(function (xhr) {
      Swal.fire('❌ Error', xhr.responseText || 'No se pudo guardar la evaluación.', 'error');
    });
});


});
</script>

<?php include("partials/footer_Admin.php"); ?>
