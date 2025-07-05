// ================= FUNCIONES GLOBALES =================

let tablaEventos;

// Función reutilizable con diseño personalizado UTA
function mostrarAlertaUTA(titulo, mensaje, tipo = 'info') {
  Swal.fire({
    title: titulo,
    text: mensaje,
    imageUrl: '../public/img/sweet.png',
    imageAlt: 'Icono UTA',
    confirmButtonText: 'Aceptar',
    customClass: {
      popup: 'swal2-popup',
      confirmButton: 'swal2-confirm'
    }
  });
}

function toggleCosto() {
  const chkPagado = document.getElementById('esPagado');
  const inputCosto = document.getElementById('costo');
  const divCosto = document.getElementById('grupoCosto');

  if (!chkPagado || !inputCosto || !divCosto) {
    console.warn('❗ Elementos del costo no encontrados.');
    return;
  }

  if (chkPagado.checked) {
    divCosto.style.display = 'block';
    inputCosto.disabled = false;
    if (inputCosto.value == 0) inputCosto.value = '';
  } else {
    inputCosto.disabled = true;
    inputCosto.value = 0;
    divCosto.style.display = 'none';
  }
}


// Nueva función para renderizar tablas por estado en tabs
function renderTablasPorEstado(eventos) {
  // Usar claves consistentes con los ids de los contenedores
  const estados = {
    'DISPONIBLE': [],
    'CURSO': [],
    'FINALIZADO': [],
    'CANCELADO': []
  };

  eventos.forEach(e => {
    let estado = (e.ESTADO || '').toString().normalize('NFD').replace(/\p{Diacritic}/gu, '').trim().toUpperCase();
    if (estado === 'EN CURSO' || estado === 'ENCURSO' || estado === 'EN_CURSO') estado = 'CURSO';
    if (estados[estado]) estados[estado].push(e);
  });

  Object.keys(estados).forEach(estado => {
    let id = 'tabla-' + estado.toLowerCase();
    const contenedor = document.getElementById(id);
    if (contenedor) {
      // Usar un id único para cada tabla según el estado
      contenedor.innerHTML = generarTablaHTML(estados[estado], estado.toLowerCase());
    }
  });
}

function generarTablaHTML(data, estado) {
  if (!data.length) return '<div class="alert alert-info">No hay eventos en este estado.</div>';
  const tablaId = `tabla-eventos-${estado}`;
  let html = `<table id="${tablaId}" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Título</th>
        <th>Tipo</th>
        <th>Inicio</th>
        <th>Finalización</th>
        <th>Modalidad</th>
        <th>Horas</th>
        <th>Costo</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      ${data.map(e => {
        let acciones = e.accion || '';
        acciones = acciones.replace(/btn-danger/g, 'btn-primary');
        return `
        <tr>
          <td>${e.TITULO}</td>
          <td>${e.TIPO}</td>
          <td>${e.FECHAINICIO}</td>
          <td>${e.FECHAFIN}</td>
          <td>${e.MODALIDAD}</td>
          <td>${e.HORAS}</td>
          <td>${e.COSTO}</td>
          <td>${e.ESTADO}</td>
          <td>${acciones}</td>
        </tr>
        `;
      }).join('')}
    </tbody>
  </table>`;
  // Inicializar DataTable con español y responsive
  setTimeout(() => {
    if (window.$ && window.$.fn.DataTable && document.getElementById(tablaId)) {
      if ($.fn.DataTable.isDataTable(`#${tablaId}`)) {
        $(`#${tablaId}`).DataTable().destroy();
      }
      $(`#${tablaId}`).DataTable({
        language: {
          url: '../public/js/es-ES.json'
        },
        lengthChange: true,
        responsive: true
      });
    }
  }, 10);
  return html;
}

function cargarEventosPorEstado() {
  $.ajax({
    url: '../controllers/EventosController.php?option=listarResponsable',
    dataType: 'json',
    success: function (data) {
      renderTablasPorEstado(data);
    }
  });
}

function edit(id) {
  if (!id) {
    mostrarAlertaUTA('Error', 'ID de evento no válido.', 'error');
    return;
  }

  axios.get(`../controllers/EventosController.php?option=edit&id=${id}`)
    .then(res => {
      const e = res.data;

      if (e.tipo === 'error') {
        mostrarAlertaUTA('Error', e.mensaje, 'error');
        return;
      }

      console.log('🧪 Evento recibido:', e);

      // Asignar valores
      document.getElementById('titulo').value = e.TITULO;
      document.getElementById('descripcion').value = e.DESCRIPCION;
      document.getElementById('horas').value = e.HORAS;
      document.getElementById('fechaInicio').value = e.FECHAINICIO;
      document.getElementById('fechaFin').value = e.FECHAFIN;
      document.getElementById('modalidad').value = e.CODIGOMODALIDAD;
      document.getElementById('tipoEvento').value = e.CODIGOTIPOEVENTO;
      document.getElementById('carrera').value = e.SECUENCIALCARRERA;
      document.getElementById('categoria').value = e.SECUENCIALCATEGORIA;
      document.getElementById('notaAprobacion').value = e.NOTAAPROBACION;
      document.getElementById('costo').value = e.COSTO;
      document.getElementById('capacidad').value = e.CAPACIDAD;
      document.getElementById('publicoDestino').value = e.ES_SOLO_INTERNOS == 1 ? 'internos' : 'externos';
      document.getElementById('esPagado').checked = e.ES_PAGADO == 1;
      document.getElementById('estado').value = e.ESTADO;
      document.getElementById('idEvento').value = e.SECUENCIAL;

      toggleCosto();

      if (Array.isArray(e.REQUISITOS)) {
        e.REQUISITOS.map(String).forEach(id => {
          const checkbox = document.querySelector(`#req_${id}`);
          if (checkbox) checkbox.checked = true;
        });
      }

      document.getElementById('btn-save').innerHTML = 'Actualizar';
      $('#modalEvento').modal('show');
    })
    .catch(err => {
      console.error('Error al cargar evento para edición:', err);
      const mensaje = err?.response?.data?.mensaje || 'No se pudo cargar el evento.';
      mostrarAlertaUTA('Error', mensaje, 'error');
    });
}

function eliminar(id) {
  if (!id) {
    mostrarAlertaUTA('Error', 'ID no válido.', 'error');
    return;
  }

  Swal.fire({
    title: '¿Estás seguro?',
    text: 'El evento será marcado como CANCELADO.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, cancelar',
    cancelButtonText: 'No',
    customClass: {
      popup: 'swal2-popup',
      confirmButton: 'swal2-confirm',
      cancelButton: 'swal2-confirm'
    }
  }).then(result => {
    if (result.isConfirmed) {
      axios.get(`../controllers/EventosController.php?option=delete&id=${id}`)
        .then(res => {
          const info = res.data;
          if (info.tipo === 'success') {
            mostrarAlertaUTA('Cancelado', info.mensaje, 'success');
            tablaEventos.ajax.reload();
          } else {
            mostrarAlertaUTA('Error', info.mensaje || 'No se pudo cancelar el evento.', 'error');
          }
        })
        .catch(err => {
          console.error('Error al cancelar:', err);
          mostrarAlertaUTA('Error', 'Ocurrió un error al cancelar el evento.', 'error');
        });
    }
  });
}

function llenarCheckboxesRequisitos(requisitos) {
  const contenedor = document.getElementById('listaRequisitos');
  if (!contenedor) return;
  contenedor.innerHTML = '';

  requisitos.forEach(req => {
    const div = document.createElement('div');
    div.className = 'form-check';

    const input = document.createElement('input');
    input.type = 'checkbox';
    input.className = 'form-check-input';
    input.id = 'req_' + req.value;
    input.name = 'requisitos[]';
    input.value = req.value;

    const label = document.createElement('label');
    label.className = 'form-check-label';
    label.htmlFor = input.id;
    label.textContent = req.text;

    div.appendChild(input);
    div.appendChild(label);
    contenedor.appendChild(div);
  });
}

function cargarSelects() {
  axios.get('../controllers/SelectsController.php')
    .then(res => {
      const data = res.data;
      llenarSelect('modalidad', data.modalidades);
      llenarSelect('tipoEvento', data.tipos);
      llenarSelect('carrera', data.carreras);
      llenarSelect('categoria', data.categorias);
      llenarSelect('estado', data.estados);
      llenarCheckboxesRequisitos(data.requisitos);
    })
    .catch(err => {
      console.error('❌ Error cargando selects:', err);
      mostrarAlertaUTA('Error', 'No se pudieron cargar los datos del formulario.', 'error');
    });
}

function llenarSelect(id, opciones) {
  const select = document.getElementById(id);
  if (!select) return;
  const isMultiple = select.hasAttribute('multiple');
  select.innerHTML = isMultiple ? '' : '<option value="">Seleccione</option>';

  opciones.forEach(op => {
    const opt = document.createElement('option');
    opt.value = op.value;
    opt.textContent = op.text;
    select.appendChild(opt);
  });
}

// ================= INICIALIZACIÓN =================

document.addEventListener('DOMContentLoaded', function () {
  cargarEventosPorEstado();
  cargarSelects();

  const frm = document.querySelector('#formEvento');
  const btnSave = document.getElementById('btn-save');
  const idEvento = document.getElementById('idEvento');
  const btnNuevo = document.getElementById('btn-nuevo');

  document.getElementById('esPagado')?.addEventListener('change', toggleCosto);
  toggleCosto();

  frm.onsubmit = function (e) {
    e.preventDefault();

    const hoy = new Date().toISOString().split("T")[0];
    const fechaInicio = frm.fechaInicio.value;
    const fechaFin = frm.fechaFin.value;
    const capacidad = parseInt(frm.capacidad.value, 10);

    if (fechaInicio < hoy) {
      mostrarAlertaUTA('Error', 'La fecha de inicio no puede ser anterior a hoy.', 'error');
      return;
    }

    if (fechaFin && fechaFin < fechaInicio) {
      mostrarAlertaUTA('Error', 'La fecha de fin no puede ser anterior a la de inicio.', 'error');
      return;
    }

    if (!capacidad || capacidad <= 0) {
      mostrarAlertaUTA('Error', 'La capacidad debe ser mayor que cero.', 'error');
      return;
    }

    const formData = new FormData(frm);

    const portada = frm.urlPortada?.files[0];
    const galeria = frm.urlGaleria?.files[0];
    if (portada) formData.set('urlPortada', portada);
    if (galeria) formData.set('urlGaleria', galeria);

    const url = idEvento.value ? '../controllers/EventosController.php?option=update' : '../controllers/EventosController.php?option=save';

    axios.post(url, formData, { headers: { 'Content-Type': 'multipart/form-data' } })
      .then(res => {
        const info = res.data;
        if (info?.tipo === 'success') {
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: info.mensaje,
            timer: 1500,
            showConfirmButton: false,
            customClass: {
              popup: 'swal2-popup'
            }
          }).then(() => {
            $('#modalEvento').modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
            frm.reset();
            btnSave.innerHTML = 'Guardar';
            tablaEventos.ajax.reload();
          });
        } else {
          mostrarAlertaUTA('Error', info?.mensaje || 'Ocurrió un error al guardar.', 'error');
        }
      })
      .catch(err => {
        console.error('❌ Error inesperado:', err);
        mostrarAlertaUTA('Error', 'No se pudo guardar el evento.', 'error');
      });
  };

  $('#modalEvento').on('hidden.bs.modal', () => {
    frm.reset();
    btnSave.innerHTML = 'Guardar';
    toggleCosto();
    tablaEventos.ajax.reload();
  });

  btnNuevo?.addEventListener('click', () => {
    frm.reset();
    idEvento.value = '';
    btnSave.innerHTML = 'Guardar';
    toggleCosto();
    $('#modalEvento').modal('show');
  });
});
