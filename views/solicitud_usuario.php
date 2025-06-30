
<style>
  #btn-flotante {
    position: fixed;
    bottom: 25px;
    left: 25px;
    z-index: 1050;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    font-size: 24px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color:rgb(133, 37, 34);
    color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
  }

  #btn-flotante:hover {
    transform: scale(1.05);
    transition: 0.2s ease-in-out;
  }

  .is-invalid {
    border: 1px solid red !important;
    background-color:rgb(10, 10, 10);
  }
</style>

<!-- Botón de solicitud flotante -->
<button id="btn-flotante" class="btn" data-toggle="modal" data-target="#modalSolicitud" title="Solicitar un cambio">
  <i class="fa fa-question-circle"></i>
</button>

<!-- Modal de Solicitud -->
<div class="modal fade" id="modalSolicitud" tabindex="-1" role="dialog" aria-labelledby="modalSolicitudLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="modalSolicitudLabel"><i class="fa fa-file-text-o"></i> Solicitud de Cambio</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="formSolicitud" method="POST" enctype="multipart/form-data">
        <div class="modal-body">

          <div class="form-group">
            <label for="MODULO_AFECTADO"><i class="fa fa-cogs"></i> ¿Qué parte del sistema deseas cambiar o reportar?</label>
            <input type="text" class="form-control" name="MODULO_AFECTADO" required>
          </div>

          <div class="form-group">
            <label><i class="fa fa-list-alt"></i> Tipo de solicitud</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="TIPO_SOLICITUD" value="Problema" required>
              <label class="form-check-label">Reportar un problema</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="TIPO_SOLICITUD" value="Mejora">
              <label class="form-check-label">Sugerir una mejora</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="TIPO_SOLICITUD" value="Idea">
              <label class="form-check-label">Proponer una nueva función</label>
            </div>
          </div>

          <div class="form-group">
            <label for="DESCRIPCION"><i class="fa fa-commenting"></i> Describe claramente tu solicitud</label>
            <textarea class="form-control" name="DESCRIPCION" rows="3" required></textarea>
          </div>

          <div class="form-group">
            <label for="JUSTIFICACION"><i class="fa fa-question-circle"></i> ¿Por qué crees que esto debería cambiarse?</label>
            <textarea class="form-control" name="JUSTIFICACION" rows="2" required></textarea>
          </div>

          <div class="form-group">
            <label><i class="fa fa-thermometer-half"></i> ¿Qué tan urgente es este cambio para ti?</label>
            <select class="form-control" name="URGENCIA" required>
              <option value="">Seleccione</option>
              <option value="Alta">Alta – Me impide avanzar</option>
              <option value="Media">Media – Es molesto pero puedo continuar</option>
              <option value="Baja">Baja – Es solo una sugerencia</option>
            </select>
          </div>

          <div class="form-group">
            <label for="ARCHIVO_EVIDENCIA"><i class="fa fa-paperclip"></i> Adjuntar evidencia (opcional)</label>
            <input type="file" class="form-control" name="ARCHIVO_EVIDENCIA" accept="image/*,.pdf">
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-danger"><i class="fa fa-paper-plane"></i> Enviar Solicitud</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $('#formSolicitud').on('submit', function (e) {
    e.preventDefault();

    const form = $(this)[0];
    const formData = new FormData(form);
    let errores = [];

    // Limpiar estados anteriores
    $('#formSolicitud .form-control, textarea, select').removeClass('is-invalid');

    // Campos
    const modulo = form.MODULO_AFECTADO;
    const tipo = $('input[name="TIPO_SOLICITUD"]:checked').val();
    const descripcion = form.DESCRIPCION;
    const justificacion = form.JUSTIFICACION;
    const urgencia = form.URGENCIA;
    const archivo = form.ARCHIVO_EVIDENCIA;

    // Validaciones
    if (modulo.value.trim().length < 5) {
      errores.push('El módulo afectado debe tener al menos 5 caracteres.');
      $(modulo).addClass('is-invalid');
    }

    if (!tipo) {
      errores.push('Debes seleccionar un tipo de solicitud.');
    }

    if (descripcion.value.trim().length < 10) {
      errores.push('La descripción debe tener al menos 10 caracteres.');
      $(descripcion).addClass('is-invalid');
    }

    if (justificacion.value.trim().length < 10) {
      errores.push('La justificación debe tener al menos 10 caracteres.');
      $(justificacion).addClass('is-invalid');
    }

    if (!urgencia.value) {
      errores.push('Debes seleccionar una urgencia.');
      $(urgencia).addClass('is-invalid');
    }

    // Validación opcional del archivo (si se adjunta)
    if (archivo.files.length > 0) {
      const file = archivo.files[0];
      const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
      const maxSize = 2 * 1024 * 1024; // 2 MB

      if (!allowedTypes.includes(file.type)) {
        errores.push('El archivo debe ser imagen o PDF.');
        $(archivo).addClass('is-invalid');
      }

      if (file.size > maxSize) {
        errores.push('El archivo no debe superar los 2MB.');
        $(archivo).addClass('is-invalid');
      }
    }

    if (errores.length > 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Formulario incompleto o inválido',
        html: '<ul style="text-align:left;">' + errores.map(e => `<li>${e}</li>`).join('') + '</ul>'
      });
      return;
    }

    // Envío vía AJAX
    $.ajax({
      url: '../controllers/guardar_solicitud.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function () {
        Swal.fire('¡Enviado!', 'Tu solicitud ha sido registrada.', 'success');
        $('#modalSolicitud').modal('hide');
        $('#formSolicitud')[0].reset();
      },
      error: function () {
        Swal.fire('Error', 'No se pudo enviar la solicitud.', 'error');
      }
    });
  });
</script>

