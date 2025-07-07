<?php include("partials/header_Admin.php"); ?>
<?php
$rolRequerido = 'ADMIN';
include("../core/auth.php"); ?>

<style>
  .is-invalid {
    border: 1px solid red !important;
    background-color: #ffe6e6;
  }
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
 div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a:focus,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a:hover {
    color: #111 !important;
    background: #fff !important;
    border: 1px solid #ddd !important;
    box-shadow: none !important;
    outline: none !important;
  }
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
    background-color: #9b2e2e !important;
    border-color: #9b2e2e!important;
    color: #fff !important;
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
ul.nav.nav-tabs {
  margin-top: -8px !important;
  margin-bottom: 15px;
}

.linea-roja-uta {
  width: 100%;
  height: 8px;
  background: #ae0c22;
  border-radius: 3px;
  margin-top: 0px;
  margin-bottom: 18px;
}
  /* Alto máximo y scroll para el cuerpo del modal de eventos */
  .modal-body {
    overflow-y: auto;
  }
/* Estilo para checkboxes verticales */
.custom-checkbox-vertical {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  min-height: 54px;
}
.label-checkbox-vertical {
  font-size: 14px;
  margin-bottom: 4px;
  font-weight: normal;
}
.custom-checkbox-vertical input[type="checkbox"] {
  margin: 10px auto 0 auto; /* Baja el checkbox y lo centra */
  width: 15px;
  height: 15px;
  accent-color: #ae0c22; /* Rojo institucional */
}
  .select2-container--default .select2-results__option--highlighted[aria-selected] {
  background-color:rgb(184, 46, 46) !important; /* Rojo institucional */
  color: #fff !important;
}
</style>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h2><i class="fa fa-tasks"></i> Solicitudes de Cambio</h2>
        <div class="linea-roja-uta"></div>
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
  LEFT JOIN usuario u ON sc.SECUENCIAL_USUARIO = u.SECUENCIAL
  ORDER BY sc.FECHA_ENVIO DESC
");

  $i = 1;


  while ($row = $stmt->fetch()) {
    $nombre = isset($row['NOMBRES']) ? htmlspecialchars($row['NOMBRES'] . ' ' . $row['APELLIDOS']) : 'Anónimo';
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
        <button type="button" class="btn btn-secondary btn-ver"
          style="background-color: #e0e0e0; color: #222; border-color: #b0b0b0;"
          data-toggle="tooltip" title="Ver solicitud"
          data-nombre="<?= $nombre ?>"
          data-codigo="<?= $codigo ?>"
          data-fecha="<?= $fecha ?>"
          data-modulo="<?= $modulo ?>">
          <i class="fa fa-eye"></i>
        </button>

        <button type="button" class="btn btn-evaluar"
          style="background-color: #e0e0e0; color: #222; border-color: #b0b0b0;"
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
