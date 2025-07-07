// ================= FUNCIONES GLOBALES =================

let tablaEventos;
let tiposEventoConfig = [];

// Función reutilizable con diseño personalizado UTA
function mostrarAlertaUTA(titulo, mensaje, tipo = 'info') {
  let config = {
    title: titulo,
    text: mensaje,
    icon: tipo, // Usar el tipo como icono
    confirmButtonText: 'Aceptar',
    customClass: {
      popup: 'swal2-popup',
      confirmButton: 'swal2-confirm'
    }
  };
  // Solo muestra el logo UTA si es informativo
  if (tipo === 'info') {
    config.imageUrl = '../public/img/sweet.png';
    config.imageAlt = 'Icono UTA';
    delete config.icon;
  }
  Swal.fire(config);
}

function toggleCosto() {
  const chkPagado = document.getElementById('esPagado');
  const inputCosto = document.getElementById('costo');
  const divCosto = document.getElementById('costoGroup'); // corregido

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
      contenedor.innerHTML = generarTablaHTML(estados[estado]);
    }
  });
}

function generarTablaHTML(data) {
  if (!data.length) return '<div class="alert alert-info">No hay eventos en este estado.</div>';
  let html = `<table id="tabla-eventos" class="table table-bordered table-striped">
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
    if (window.$ && window.$.fn.DataTable && document.getElementById('tabla-eventos')) {
      if (window.$.fn.DataTable.isDataTable('#tabla-eventos')) {
        window.$('#tabla-eventos').DataTable().destroy();
      }
      window.$('#tabla-eventos').DataTable({
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

function cargarSelectsEventoRes(callback) {
  axios.get('../controllers/SelectsController.php')
    .then(res => {
      const data = res.data;
      llenarSelect('modalidad', data.modalidades);
      llenarSelect('tipoEvento', data.tipos);
      llenarSelect('carreras', data.carreras);
      llenarSelect('categoria', data.categorias);
      llenarSelect('estado', data.estados);
      llenarCheckboxesRequisitos(data.requisitos);
      if (typeof callback === 'function') {
        setTimeout(callback, 150); // Espera breve para Choices.js
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
      cargarSelectsEventoRes(() => {
        // Asignar valores solo si los elementos existen y evitar 'undefined'
        const setValue = (id, value) => { 
          const el = document.getElementById(id); 
          if (el) el.value = value !== undefined && value !== null ? value : ''; 
        };
        setValue('titulo', e.TITULO);
        setValue('descripcion', e.DESCRIPCION);
        setValue('horas', e.HORAS);
        setValue('fechaInicio', e.FECHAINICIO);
        setValue('fechaFin', e.FECHAFIN);
        setValue('modalidad', e.CODIGOMODALIDAD);
        setValue('tipoEvento', e.CODIGOTIPOEVENTO);
        setValue('categoria', e.SECUENCIALCATEGORIA);
        setValue('notaAprobacion', e.NOTAAPROBACION);
        setValue('costo', e.COSTO);
        setValue('capacidad', e.CAPACIDAD);
        setValue('publicoDestino', e.publicoDestino);
        setValue('estado', e.ESTADO);
        setValue('idEvento', e.SECUENCIAL);
        const esPagado = document.getElementById('esPagado');
        if (esPagado) esPagado.checked = e.ES_PAGADO == 1;
        // Carreras con Choices.js
        const selectCarreras = document.getElementById('carreras');
        if (selectCarreras && selectCarreras.choicesInstance) {
          selectCarreras.choicesInstance.removeActiveItems();
          if (Array.isArray(e.carreras)) {
            e.carreras.forEach(function(id) {
              selectCarreras.choicesInstance.setChoiceByValue(id.toString());
            });
          } else if (e.carreras) {
            selectCarreras.choicesInstance.setChoiceByValue(e.carreras.toString());
          }
        }
        toggleCosto();
        if (Array.isArray(e.REQUISITOS)) {
          e.REQUISITOS.map(String).forEach(id => {
            const checkbox = document.querySelector(`#req_${id}`);
            if (checkbox) checkbox.checked = true;
          });
        }
        const btnSave = document.getElementById('btn-save-res');
        if (btnSave) btnSave.innerHTML = 'Actualizar';
        $('#modalEvento').modal('show');
      });
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
      let formData = new FormData();
      formData.append('id', id);
      axios.post('../controllers/EventosController.php?option=eliminarResponsable', formData)
        .then(res => {
          const info = res.data;
          if (info.success === true || info.success === "true" || info.mensaje === "Evento eliminado correctamente") {
            mostrarAlertaUTA('Eliminado', info.mensaje || 'Evento eliminado correctamente', 'success');
            if (typeof tablaEventos !== 'undefined' && tablaEventos.ajax) {
              tablaEventos.ajax.reload();
            } else if (typeof cargarEventosPorEstado === 'function') {
              cargarEventosPorEstado();
            }
            // Cerrar el modal si está abierto (opcional, si usas modal)
            if (typeof $ !== 'undefined' && $('#modalEvento').length) {
              $('#modalEvento').modal('hide');
            }
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

  // Filtrar duplicados por valor y texto
  const vistos = new Set();
  requisitos.forEach(req => {
    const key = req.value + '|' + req.text;
    if (vistos.has(key)) return;
    vistos.add(key);
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
      console.log('REQUISITOS DEL BACKEND:', data.requisitos); // <-- Agregado para depuración
      llenarSelect('modalidad', data.modalidades);
      llenarSelect('tipoEvento', data.tipos);
      llenarSelect('carreras', data.carreras); // Corregido: usar 'carreras' en vez de 'carrera'
      llenarSelect('categoria', data.categorias);
      llenarSelect('estado', data.estados);
      llenarCheckboxesRequisitos(data.requisitos);
      tiposEventoConfig = data.tipos; // Guardar la configuración de tipos de evento
    })
    .catch(err => {
      console.error('❌ Error cargando selects:', err);
      mostrarAlertaUTA('Error', 'No se pudieron cargar los datos del formulario.', 'error');
    });
}

function llenarSelect(id, opciones) {
  const select = document.getElementById(id);
  if (!select) {
    console.error('No existe el select con id:', id);
    return;
  }
  
  const isMultiple = select.hasAttribute('multiple');
  
  // Destruir Choices.js si ya existe
  if (select.choicesInstance) {
    select.choicesInstance.destroy();
    select.choicesInstance = null;
  }
  
  // Limpiar el select
  select.innerHTML = '';
  
  // Manejo especial para carreras
  if (id === 'carreras') {
    // Agregar opción "Todas las carreras" al inicio
    const optTodas = document.createElement('option');
    optTodas.value = 'TODAS';
    optTodas.textContent = 'Todas las carreras';
    select.appendChild(optTodas);
    
    // Ordenar carreras alfabéticamente
    const carrerasOrdenadas = opciones.slice().sort((a, b) => 
      (a.text || a.NOMBRE_CARRERA).toUpperCase().localeCompare((b.text || b.NOMBRE_CARRERA).toUpperCase())
    );
    
    // Guardar IDs de todas las carreras para uso posterior
    window.idsTodasCarreras = carrerasOrdenadas.map(op => (op.value || op.SECUENCIAL).toString());
    
    // Agregar cada carrera
    carrerasOrdenadas.forEach(op => {
      const opt = document.createElement('option');
      opt.value = op.value || op.SECUENCIAL;
      opt.textContent = op.text || op.NOMBRE_CARRERA;
      select.appendChild(opt);
    });
    
    // Inicializar Choices.js para carreras
    select.choicesInstance = new Choices(select, {
      removeItemButton: true,
      searchResultLimit: 20,
      placeholder: true,
      placeholderValue: 'Seleccione una o varias carreras',
      noResultsText: 'No se encontraron carreras',
      noChoicesText: 'No hay carreras disponibles',
      itemSelectText: 'Seleccionar',
      shouldSort: false,
    });
    
    // Lógica de exclusividad para "Todas las carreras"
    const btnLimpiar = document.getElementById('btnLimpiarCarreras');
    
    select.choicesInstance.passedElement.element.addEventListener('addItem', function(event) {
      const value = event.detail.value;
      let currentValues = select.choicesInstance.getValue(true);
      
      if (value === 'TODAS' && currentValues.length > 1) {
        // Si se selecciona 'Todas las carreras' y ya hay otras, limpiar y dejar solo esa
        setTimeout(() => {
          select.choicesInstance.removeActiveItems();
          select.choicesInstance.setChoiceByValue('TODAS');
          select.choicesInstance.disable();
          if (btnLimpiar) btnLimpiar.style.display = '';
        }, 0);
      } else if (value !== 'TODAS' && currentValues.includes('TODAS')) {
        // Si se selecciona otra y estaba 'Todas las carreras', quitar solo 'Todas las carreras'
        setTimeout(() => {
          select.choicesInstance.removeActiveItemsByValue('TODAS');
          select.choicesInstance.enable();
          if (btnLimpiar) btnLimpiar.style.display = 'none';
        }, 0);
      }
    });
    
    select.choicesInstance.passedElement.element.addEventListener('removeItem', function(event) {
      if (event.detail.value === 'TODAS') {
        setTimeout(() => {
          select.choicesInstance.enable();
          if (btnLimpiar) btnLimpiar.style.display = 'none';
        }, 0);
      }
    });
    
    // Evento change para manejar la exclusividad
    select.removeEventListener('change', select.carrerasChangeHandler);
    select.carrerasChangeHandler = function (e) {
      let values = Array.from(select.selectedOptions).map(opt => opt.value);
      if (values.includes('TODAS')) {
        select.choicesInstance.removeActiveItems();
        select.choicesInstance.setChoiceByValue('TODAS');
        select.choicesInstance.disable();
        if (btnLimpiar) btnLimpiar.style.display = '';
      } else {
        select.choicesInstance.enable();
        // Si hay alguna carrera seleccionada, deshabilitar 'Todas las carreras'
        const allChoices = select.choicesInstance._store.choices;
        if (values.length > 0) {
          allChoices.forEach(choice => {
            if (choice.value === 'TODAS') {
              choice.disabled = true;
            } else {
              choice.disabled = false;
            }
          });
        } else {
          allChoices.forEach(choice => {
            choice.disabled = false;
          });
        }
        select.choicesInstance._store.choices = allChoices;
        select.choicesInstance._render();
        if (btnLimpiar) btnLimpiar.style.display = 'none';
      }
    };
    select.addEventListener('change', select.carrerasChangeHandler);
    
    console.log('Carreras cargadas:', carrerasOrdenadas.length, 'opciones');
    
  } else {
    // Para otros selects (modalidad, tipoEvento, categoria, estado)
    opciones.forEach(op => {
      const opt = document.createElement('option');
      opt.value = op.value || op.CODIGO || op.SECUENCIAL;
      opt.textContent = op.text || op.NOMBRE || op.NOMBRE_CARRERA;
      select.appendChild(opt);
    });
  }
}

// ================= INICIALIZACIÓN =================

document.addEventListener('DOMContentLoaded', function() {
  const btnNuevo = document.getElementById('btn-nuevo');
  const form = document.getElementById('formEventoRes');
  const btnSave = document.getElementById('btn-save-res');
  const idEvento = document.getElementById('idEvento');

  if (btnNuevo && form) {
    btnNuevo.addEventListener('click', function() {
      $('#modalEvento').modal('show');
      form.reset();
      idEvento.value = '';
      btnSave.innerHTML = 'Guardar';
      cargarSelects();
      toggleCosto();
    });
  }

  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      // Validaciones estrictas
      const titulo = document.getElementById('titulo').value.trim();
      const descripcion = document.getElementById('descripcion').value.trim();
      const horas = parseFloat(document.getElementById('horas').value);
      const capacidad = parseInt(document.getElementById('capacidad').value);
      const notaAprobacion = document.getElementById('notaAprobacion') ? parseFloat(document.getElementById('notaAprobacion').value) : null;
      const fechaInicio = document.getElementById('fechaInicio').value;
      const fechaFin = document.getElementById('fechaFin').value;
      const hoy = new Date().toISOString().split('T')[0];
      const costo = parseFloat(document.getElementById('costo').value);
      const esPagado = document.getElementById('esPagado').checked;
      if (titulo.length < 3) return mostrarAlertaUTA('Error', 'El título debe tener al menos 3 caracteres.', 'error');
      if (descripcion.length < 10) return mostrarAlertaUTA('Error', 'La descripción debe tener al menos 10 caracteres.', 'error');
      if (isNaN(horas) || horas <= 0) return mostrarAlertaUTA('Error', 'Las horas deben ser mayores a 0.', 'error');
      if (isNaN(capacidad) || capacidad <= 0) return mostrarAlertaUTA('Error', 'La capacidad debe ser positiva.', 'error');
      if (!isNaN(notaAprobacion) && (notaAprobacion < 0 || notaAprobacion > 100)) return mostrarAlertaUTA('Error', 'Nota fuera de rango.', 'error');
      if (fechaInicio < hoy) return mostrarAlertaUTA('Error', 'Fecha de inicio inválida.', 'error');
      if (fechaFin && fechaFin < fechaInicio) return mostrarAlertaUTA('Error', 'Fecha fin menor a inicio.', 'error');
      if (esPagado && (isNaN(costo) || costo < 0)) return mostrarAlertaUTA('Error', 'Costo requerido para eventos pagados.', 'error');
      // Manejo de carreras igual que admin
      const selectCarreras = document.getElementById('carreras');
      let values = Array.from(selectCarreras.selectedOptions).map(opt => opt.value);
      if (values.includes('TODAS')) {
        selectCarreras.choicesInstance.removeActiveItems();
        window.idsTodasCarreras.forEach(function(id) {
          selectCarreras.choicesInstance.setChoiceByValue(id);
        });
        values = window.idsTodasCarreras;
      }
      for (let i = 0; i < selectCarreras.options.length; i++) {
        selectCarreras.options[i].selected = values.includes(selectCarreras.options[i].value);
      }
      const formData = new FormData(form);
      formData.delete('carreras[]');
      values.forEach(id => {
        formData.append('carreras[]', id);
      });
      // Validar requisitos (opcional, según tu lógica)
      // Enviar el campo 'carrera' como el primer valor seleccionado (o 'TODAS')
      if (values.length > 0) {
        formData.set('carrera', values[0]);
      } else {
        formData.set('carrera', '');
      }
      // Siempre enviar notaAprobacion y asistenciaMinima (aunque estén ocultos o no existan)
      const notaAprobacionInput = document.getElementById('notaAprobacion');
      if (notaAprobacionInput) {
        const group = notaAprobacionInput.closest('.form-group');
        if ((group && group.style.display === 'none') || notaAprobacionInput.style.display === 'none') {
          formData.set('notaAprobacion', '');
        }
      } else {
        formData.set('notaAprobacion', '');
      }
      const asistenciaMinimaInput = document.getElementById('asistenciaMinima');
      if (asistenciaMinimaInput) {
        const group = asistenciaMinimaInput.closest('.form-group');
        if ((group && group.style.display === 'none') || asistenciaMinimaInput.style.display === 'none') {
          formData.set('asistenciaMinima', '');
        }
      } else {
        formData.set('asistenciaMinima', '');
      }
      // Envío AJAX igual que el admin
      axios.post('../controllers/EventosController.php?option=save', formData)
        .then(res => {
          if (res.data.tipo === 'success') {
            mostrarAlertaUTA('Éxito', res.data.mensaje, 'success');
            $('#modalEvento').modal('hide');
            cargarEventosPorEstado();
            form.reset();
            btnSave.innerHTML = 'Guardar';
          } else {
            mostrarAlertaUTA('Error', res.data.mensaje || 'No se pudo guardar el evento.', 'error');
          }
        })
        .catch(err => {
          mostrarAlertaUTA('Error', 'Ocurrió un error al guardar el evento.', 'error');
          console.error('Error al guardar evento:', err);
        });
    });
  }
  cargarEventosPorEstado();
  cargarSelects();
  document.getElementById('esPagado')?.addEventListener('change', toggleCosto);
  toggleCosto();
});

// Mostrar/ocultar campos de nota/asistencia según el tipo de evento seleccionado
// Usar el mismo comportamiento que el admin

document.addEventListener('change', function(e) {
  if (e.target && e.target.id === 'tipoEvento') {
    const codigo = e.target.value;
    const tipo = tiposEventoConfig.find(t => t.CODIGO === codigo || t.value === codigo);
    // Usar los IDs correctos del HTML de responsables
    const notaMinimaContainer = document.getElementById('notaAprobacionGroup');
    const asistenciaMinimaContainer = document.getElementById('asistenciaMinimaGroup');
    const notaAprobacion = document.getElementById('notaAprobacion');
    const asistenciaMinima = document.getElementById('asistenciaMinima');
    if (tipo) {
      if (tipo.REQUIERENOTA == 1) {
        if (notaMinimaContainer) notaMinimaContainer.style.display = '';
      } else {
        if (notaMinimaContainer) notaMinimaContainer.style.display = 'none';
        if (notaAprobacion) notaAprobacion.value = '';
      }
      if (tipo.REQUIEREASISTENCIA == 1) {
        if (asistenciaMinimaContainer) asistenciaMinimaContainer.style.display = '';
      } else {
        if (asistenciaMinimaContainer) asistenciaMinimaContainer.style.display = 'none';
        if (asistenciaMinima) asistenciaMinima.value = '';
      }
    } else {
      if (notaMinimaContainer) notaMinimaContainer.style.display = 'none';
      if (asistenciaMinimaContainer) asistenciaMinimaContainer.style.display = 'none';
      if (notaAprobacion) notaAprobacion.value = '';
      if (asistenciaMinima) asistenciaMinima.value = '';
    }
  }
});
