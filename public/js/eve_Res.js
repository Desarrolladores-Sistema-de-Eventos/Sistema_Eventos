// ==== TABLA EVENTOS RESPONSABLE ====
let tablaEventos;
function inicializarTablaEventos() {
  const incluirCancelados = document.getElementById('mostrarCancelados')?.checked;
  localStorage.setItem('verCancelados', incluirCancelados ? '1' : '0');

  if (tablaEventos) tablaEventos.destroy();

  tablaEventos = $('#tabla-eventos').DataTable({
    ajax: {
      url: '../controllers/EventosController.php?option=listarResponsable',
      dataSrc: function (json) {
        if (incluirCancelados) {
          // Mostrar solo eventos CANCELADOS o CERRADOS
          return json.filter(e => {
            const estado = (e.ESTADO || '').trim().toUpperCase();
            return estado === 'CANCELADO' || estado === 'CERRADO';
          });
        }
        // Mostrar solo eventos DISPONIBLES
        return json.filter(e => (e.ESTADO || '').trim().toUpperCase() === 'DISPONIBLE');
      }
    },
    columns: [
      { data: 'TITULO' },
      { data: 'TIPO' },
      { data: 'FECHAINICIO' },
      { data: 'FECHAFIN' },
      { data: 'MODALIDAD' },
      { data: 'HORAS' },
      { data: 'COSTO' },
      { data: 'ESTADO' },
      { data: 'accion' }
    ],
    language: {
      url: '../public/js/es-ES.json'
    },
    order: [[2, 'desc']]
  });
}

// ==== EDITAR ====
function edit(id) {
  axios.get(`../controllers/EventosController.php?option=edit&id=${id}`)
    .then(res => {
      const e = res.data;
      console.log('🧪 Evento recibido:', e);

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
      toggleCosto();

      document.getElementById('estado').value = e.ESTADO;
      document.getElementById('idEvento').value = e.SECUENCIAL;

      // No se puede precargar archivos en input type="file" por seguridad

      document.getElementById('btn-save').innerHTML = 'Actualizar';
      $('#modalEvento').modal('show');
      if (Array.isArray(e.REQUISITOS)) {
        e.REQUISITOS.map(String).forEach(id => {
          const checkbox = document.querySelector(`#req_${id}`);
          if (checkbox) checkbox.checked = true;
        });
      }
    })
    .catch(err => {
      console.error('Error al cargar evento para edición:', err);
      Swal.fire('Error', 'No se pudo cargar el evento.', 'error');
    });
}

function llenarCheckboxesRequisitos(requisitos) {
  const contenedor = document.getElementById('listaRequisitos');
  if (!contenedor) return;
  contenedor.innerHTML = ''; // Limpiar contenido previo

  requisitos.forEach(req => {
    const wrapper = document.createElement('div');
    wrapper.className = 'form-check';

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

    wrapper.appendChild(input);
    wrapper.appendChild(label);
    contenedor.appendChild(wrapper);
  });
}
// ==== CANCELAR (Soft Delete) ====
function eliminar(id) {
  console.log('🗑️ Cancelando evento con ID:', id);

  if (!id) {
    Swal.fire('Error', 'ID del evento no válido.', 'error');
    return;
  }

  Swal.fire({
    title: '¿Estás seguro?',
    text: "El evento será marcado como CANCELADO.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, cancelar'
  }).then(result => {
    if (result.isConfirmed) {
      axios.get(`../controllers/EventosController.php?option=delete&id=${id}`)
        .then(res => {
          const info = res.data;
          console.log('🧾 Respuesta del backend:', info);

          if (info.tipo === 'success') {
            Swal.fire('Cancelado', info.mensaje, 'success');
            tablaEventos.ajax.reload();
          } else {
            Swal.fire('Error', info.mensaje || 'No se pudo cancelar el evento.', 'error');
          }
        })
        .catch(err => {
          console.error('❌ Error al cancelar:', err);
          Swal.fire('Error', 'Ocurrió un error al cancelar el evento.', 'error');
        });
    }
  });
}

// ==== CARGAR SELECTS ====
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
      console.error('❌ Error cargando selects', err);
      Swal.fire('Error', 'No se pudieron cargar los datos del formulario.', 'error');
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

//----------------------------------------------------------------------------
// ==== DOM READY ====
document.addEventListener('DOMContentLoaded', function () {
  const verCancelados = localStorage.getItem('verCancelados') === '1';
  const chk = document.getElementById('mostrarCancelados');
  if (chk) chk.checked = verCancelados;

  inicializarTablaEventos();
  cargarSelects();

  if (chk) {
    chk.addEventListener('change', () => inicializarTablaEventos());
  }

  const frm = document.querySelector('#formEvento');
  const btnNuevo = document.querySelector('#btn-nuevo');
  const btnSave = document.querySelector('#btn-save');
  const idEvento = document.querySelector('#idEvento');

  const chkPagado = document.getElementById('esPagado');
  const inputCosto = document.getElementById('costo');
  const divCosto = document.getElementById('grupoCosto');
  console.log('grupoCosto cargado:', divCosto);


  function toggleCosto() {
    
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

  chkPagado.addEventListener('change', toggleCosto);
  toggleCosto();


  // === ENVÍO DEL FORMULARIO ===
  frm.onsubmit = function (e) {
    e.preventDefault();
    const hoy = new Date().toISOString().split("T")[0];
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    const capacidad = parseInt(document.getElementById('capacidad').value, 10);

    if (fechaInicio < hoy) {
      Swal.fire('Error', 'La fecha de inicio no puede ser anterior a hoy.', 'error');
      return;
    }
    if (fechaFin && fechaFin < fechaInicio) {
      Swal.fire('Error', 'La fecha de fin no puede ser anterior a la de inicio.', 'error');
      return;
    }

    if (!capacidad || capacidad <= 0) {
      Swal.fire('Error', 'La capacidad debe ser mayor que cero.', 'error');
      return;
    }

    const formData = new FormData(frm);

    // Adjuntar archivos de portada y galería si existen
    const portadaInput = document.getElementById('urlPortada');
    const galeriaInput = document.getElementById('urlGaleria');
    if (portadaInput && portadaInput.files.length > 0) {
      formData.set('urlPortada', portadaInput.files[0]);
    }
    if (galeriaInput && galeriaInput.files.length > 0) {
      formData.set('urlGaleria', galeriaInput.files[0]);
    }

    let url = '../controllers/EventosController.php?option=save';
    if (idEvento.value !== '') {
      url = '../controllers/EventosController.php?option=update';
    }

    axios.post(url, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
      .then(res => {
        const info = res.data;
        console.log('📬 Respuesta del servidor:', info);

        if (info?.tipo === 'success') {
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: info.mensaje,
            timer: 1500,
            showConfirmButton: false
          }).then(() => {
            // 🧼 Cerrar modal y limpiar backdrop
            $('#modalEvento').modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');

            frm.reset();
            btnSave.innerHTML = 'Guardar';
            tablaEventos.ajax.reload();
          });
        } else {
          Swal.fire('Error', info?.mensaje || 'Ocurrió un error al guardar el evento.', 'error');
        }
      })
      .catch(err => {
        console.error('❌ Error inesperado:', err);
        Swal.fire('Error', 'No se pudo guardar el evento. Intenta nuevamente.', 'error');
      });
  };

  // ✅ LIMPIEZA DESPUÉS DE CERRAR EL MODAL
  $('#modalEvento').on('hidden.bs.modal', function () {
    frm.reset();
    btnSave.innerHTML = 'Guardar';
    toggleCosto();
    tablaEventos.ajax.reload();
  });

  // === BOTÓN NUEVO EVENTO ===
  btnNuevo.addEventListener('click', function () {
    frm.reset();
    idEvento.value = '';
    btnSave.innerHTML = 'Guardar';
     toggleCosto();
    $('#modalEvento').modal('show');
  });
});