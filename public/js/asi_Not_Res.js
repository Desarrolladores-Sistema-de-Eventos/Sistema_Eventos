let tipoEventoGlobal = '';
let estadoEventoGlobal = '';
let idEventoGlobal = null;

function cargarTarjetas() {
  axios.get('../controllers/Asistencia_NotaController.php?option=eventosResponsable')
    .then(res => {
      const contenedor = document.getElementById('contenedor-eventos');
      contenedor.innerHTML = '';

      res.data.forEach(e => {
        const tarjeta = document.createElement('div');
        tarjeta.classList.add('tarjeta-evento', 'shadow-sm');
        tarjeta.innerHTML = `
          <img src="../public/img/eventos/portadas/${e.IMAGEN || 'public/img/default.jpg'}" class="evento-img rounded-top">
          <div class="p-3 bg-white rounded-bottom">
            <h5 class="text-dark font-weight-bold mb-3">
              <i class="fa fa-calendar-alt mr-2 text-danger"></i> ${e.TITULO}
            </h5>
            <div class="info-line"><i class="fa fa-tags"></i> <span class="etiqueta">${e.TIPO_EVENTO}</span></div>
            <div class="info-line"><i class="fa fa-clock-o"></i> <span class="etiqueta">Fecha Inicio: ${e.FECHAINICIO}</span></div>
            <div class="info-line"><i class="fa fa-flag"></i> <span>Estado: <span class="estado-label ${e.ESTADO.toLowerCase()}">${e.ESTADO}</span></span></div>
            <div class="text-center mt-3">
              <button class="btn btn-sm btn-ver" onclick="window.location.href='dashboard_Notas_Res.php?idEvento=${e.SECUENCIAL}&titulo=${encodeURIComponent(e.TITULO)}&fecha=${encodeURIComponent(e.FECHAINICIO)}&tipo=${encodeURIComponent(e.TIPO_EVENTO_CODIGO)}&tipoNombre=${encodeURIComponent(e.TIPO_EVENTO)}&estado=${encodeURIComponent(e.ESTADO)}'">
                <i class="fa fa-edit"></i> Gestionar
              </button>
            </div>
          </div>`;
        contenedor.appendChild(tarjeta);
      });
    });
}

function verInscritosEvento(idEvento, titulo, fecha, tipo, tipoNombre) {
  idEventoGlobal = idEvento;
  tipoEventoGlobal = tipo?.toUpperCase();
  tipoEventoNombre = tipoNombre;
  const eventoFinalizado = estadoEventoGlobal === 'FINALIZADO';

  axios.get('../controllers/Asistencia_NotaController.php?option=inscritosEvento&idEvento=' + idEvento)
    .then(res => {
      document.getElementById('titulo-evento').textContent = titulo;
      document.getElementById('fecha-evento').textContent = fecha;
      document.getElementById('tipo-evento').textContent = tipoNombre;
      document.getElementById('total-inscritos').textContent = res.data.length;

      const btnFinalizar = document.getElementById('btn-finalizar-evento');
      btnFinalizar.style.display = eventoFinalizado ? 'none' : 'inline-block';

      const thead = document.querySelector('#tablas-notas thead');
      const tbody = document.querySelector('#tablas-notas tbody');

      const mostrarNota = tipoEventoGlobal === 'CUR';
      const mostrarPorcentaje = true;

      thead.innerHTML = `<tr>
        <th>#</th>
        <th>Nombre y Apellido</th>
        <th>Asistió</th>
        ${mostrarNota ? '<th>Nota Final</th>' : ''}
        ${mostrarPorcentaje ? '<th>% Asistencia</th>' : ''}
        <th>Observación</th>
        <th>Acciones</th>
      </tr>`;

      tbody.innerHTML = '';
      res.data.forEach((ins, idx) => {
        const esEditable = !eventoFinalizado;
        const observacion = JSON.stringify(ins.OBSERVACION || '').slice(1, -1);

        tbody.innerHTML += `<tr>
          <td>${idx + 1}</td>
          <td>${ins.NOMBRE}</td>
          <td><select class="form-control form-control-sm" id="asistencia-${ins.INSCRIPCION_ID}" ${esEditable ? '' : 'disabled'}>
            <option value="1" ${ins.ASISTENCIA == 1 ? 'selected' : ''}>Sí</option>
            <option value="0" ${ins.ASISTENCIA == 0 ? 'selected' : ''}>No</option>
          </select></td>
          ${mostrarNota ? `<td><input type="number" id="nota-${ins.INSCRIPCION_ID}" class="form-control form-control-sm" min="0" max="10" step="0.1" value="${ins.NOTA ?? ''}" ${esEditable ? '' : 'disabled'}></td>` : ''}
          ${mostrarPorcentaje ? `<td><input type="number" id="porcentaje-${ins.INSCRIPCION_ID}" class="form-control form-control-sm" min="0" max="100" step="1" value="${ins.PORCENTAJE_ASISTENCIA || ''}" ${esEditable ? '' : 'disabled'}></td>` : ''}
          <td>
            <button class="btn btn-sm btn-outline-dark" onclick="abrirObservacionModal(${ins.INSCRIPCION_ID}, \`${observacion}\`)" ${esEditable ? '' : 'disabled'}>Detallar</button>
            <input type="hidden" id="observacion-hidden-${ins.INSCRIPCION_ID}" value="${observacion}">
          </td>
          <td>
            <button class="btn btn-black-red btn-sm" id="btn-editar-${ins.INSCRIPCION_ID}" onclick="habilitarEdicion(${ins.INSCRIPCION_ID})" ${eventoFinalizado ? 'disabled' : ''}><i class="fa fa-pencil"></i></button>
          </td>
        </tr>`;
      });

      setTimeout(() => {
        const tabla = $('#tablas-notas');
        if ($.fn.DataTable.isDataTable(tabla)) tabla.DataTable().destroy();
        tabla.DataTable({ language: { url: '../public/js/es-ES.json' }, responsive: true });
      }, 100);
    });
}

function guardarAsistenciaNota(idInscripcion) {
  const asistencia = document.getElementById(`asistencia-${idInscripcion}`).value;
  const nota = document.getElementById(`nota-${idInscripcion}`)?.value || '';
  const porcentaje = document.getElementById(`porcentaje-${idInscripcion}`)?.value || '';
  const observacion = document.getElementById(`observacion-hidden-${idInscripcion}`)?.value || '';

  const formData = new FormData();
  formData.append('idInscripcion', idInscripcion);
  formData.append('asistencia', asistencia);
  formData.append('nota', nota);
  formData.append('porcentaje', porcentaje);
  formData.append('observacion', observacion);

  axios.post('../controllers/Asistencia_NotaController.php?option=guardarAsistenciaNota', formData)
    .then(res => {
      Swal.fire({
        icon: res.data.success ? 'success' : 'error',
        title: res.data.success ? 'Guardado' : 'Error',
        text: res.data.mensaje,
        timer: 2000,
        showConfirmButton: false
      });

      document.getElementById(`asistencia-${idInscripcion}`).disabled = true;
      document.getElementById(`nota-${idInscripcion}`)?.setAttribute('disabled', true);
      document.getElementById(`porcentaje-${idInscripcion}`)?.setAttribute('disabled', true);
      document.getElementById(`btn-editar-${idInscripcion}`).classList.remove('d-none');
      document.getElementById(`btn-guardar-${idInscripcion}`).classList.add('d-none');
    });
}

function abrirObservacionModal(idInscripcion, textoActual = '') {
  Swal.fire({
    title: 'Observación',
    input: 'textarea',
    inputValue: textoActual,
    inputPlaceholder: 'Ingrese una observación...',
    inputAttributes: { 'aria-label': 'Observación' },
    showCancelButton: true,
    confirmButtonText: 'Guardar'
  }).then(result => {
    if (result.isConfirmed && result.value !== undefined) {
      const hiddenInput = document.getElementById(`observacion-hidden-${idInscripcion}`);
      if (hiddenInput) {
        hiddenInput.value = result.value;
      } else {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.id = `observacion-hidden-${idInscripcion}`;
        input.value = result.value;
        document.body.appendChild(input);
      }

      // ✅ Guardar al cerrar el modal
      guardarAsistenciaNota(idInscripcion);
    }
  });
}


function finalizarEvento() {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Se guardarán todas las notas y asistencias, y se finalizará el evento. No podrás hacer cambios después.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#999',
    confirmButtonText: 'Sí, finalizar y guardar'
  }).then((result) => {
    if (!result.isConfirmed) return;

    const filas = document.querySelectorAll('#tablas-notas tbody tr');
    const datos = [];

    filas.forEach(fila => {
      const idInscripcion = fila.querySelector('select[id^="asistencia-"]').id.split('-')[1];

      const asistenciaRaw = document.getElementById(`asistencia-${idInscripcion}`)?.value || '';
      const notaRaw = document.getElementById(`nota-${idInscripcion}`)?.value?.trim() ?? '';
      const porcentajeRaw = document.getElementById(`porcentaje-${idInscripcion}`)?.value?.trim() ?? '';
      const observacion = document.getElementById(`observacion-hidden-${idInscripcion}`)?.value?.trim() || null;

      const asistencia = asistenciaRaw === '' ? null : parseInt(asistenciaRaw);
      const nota = notaRaw === '' ? null : parseFloat(notaRaw);
      const porcentaje = porcentajeRaw === '' ? null : parseInt(porcentajeRaw);

      datos.push({
        idInscripcion: parseInt(idInscripcion),
        asistencia,
        nota,
        porcentaje,
        observacion
      });
    });

    // OPCIONAL: inspeccionar datos en consola
    console.log("Datos que se envían:", datos);

    const formData = new FormData();
    formData.append('idEvento', idEventoGlobal);
    formData.append('datos', JSON.stringify(datos));

    axios.post('../controllers/Asistencia_NotaController.php?option=guardarNotasYFinalizar', formData)
      .then(res => {
        Swal.fire({
          icon: res.data.success ? 'success' : 'error',
          title: res.data.success ? 'Finalizado' : 'Error',
          text: res.data.mensaje,
          timer: 3000,
          showConfirmButton: false
        });

        if (res.data.success) {
          setTimeout(() => window.location.href = "dashboard_NotasAsistencia_Res.php", 2500);
        }
      })
      .catch(() => {
        Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
      });
  });
}


function habilitarEdicion(idInscripcion) {
  document.getElementById(`asistencia-${idInscripcion}`).disabled = false;
  document.getElementById(`nota-${idInscripcion}`)?.removeAttribute('disabled');
  document.getElementById(`porcentaje-${idInscripcion}`)?.removeAttribute('disabled');
  document.getElementById(`btn-editar-${idInscripcion}`).classList.add('d-none');
  document.getElementById(`btn-guardar-${idInscripcion}`).classList.remove('d-none');
}

document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  idEventoGlobal = params.get('idEvento');
  tipoEventoGlobal = params.get('tipo');
  estadoEventoGlobal = params.get('estado')?.toUpperCase() || '';
  const titulo = params.get('titulo');
  const fecha = params.get('fecha');
  const tipoNombre = params.get('tipoNombre');

  if (idEventoGlobal) {
    verInscritosEvento(idEventoGlobal, titulo, fecha, tipoEventoGlobal, tipoNombre);
  }

  cargarTarjetas();
});
