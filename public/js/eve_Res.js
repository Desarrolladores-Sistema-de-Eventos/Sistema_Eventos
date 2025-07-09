// Inicialización de CKEditor para contenido y descripción
window.initCKEditor = function() {
  if (window.ClassicEditor) {
    if (document.getElementById('contenido')) {
      ClassicEditor.create(document.getElementById('contenido'))
        .then(editor => { window.ckEditorContenido = editor; });
    }
    if (document.getElementById('descripcion')) {
      ClassicEditor.create(document.getElementById('descripcion'))
        .then(editor => { window.ckEditorDescripcion = editor; });
    }
  }
};
// ================= INICIALIZACIÓN FRONTEND =================
$(document).ready(function() {
  // Inicializar select2 con placeholder y mensaje personalizado
  $('#carrera').select2({
    placeholder: 'Seleccione una o varias carreras',
    width: '100%',
    language: {
      noResults: function() {
        return 'No se encontraron carreras';
      },
      searching: function() {
        return 'Buscando...';
      }
    }
  });
  // Estado seleccionado global para el filtro
  window.estadoSeleccionado = $('#navEstadosEventos li.active a').data('estado') || 'DISPONIBLE';

  // Inicializar DataTable con AJAX y filtrado por estado
  window.tablaEventos = $('#tabla-eventos').DataTable({
    ajax: {
      url: '../controllers/EventosController.php?option=listarResponsable',
      dataSrc: function (json) {
        // Filtrar por estado seleccionado en el frontend (como antes)
        if (!window.estadoSeleccionado || window.estadoSeleccionado === '') return json;
        return json.filter(e => {
          let est = (e.ESTADO || e.estado || '').toString().trim().toUpperCase();
          let filtro = window.estadoSeleccionado.toString().trim().toUpperCase();
          return est === filtro;
        });
      }
    },
    columns: [
      {
        data: 'PORTADA',
        orderable: false,
        render: function (data, type, row) {
          return data ? `<img src="../public/img/eventos/portadas/${data}" style="width:60px;">` : '';
        }
      },
      { data: 'TITULO' },
      { data: 'TIPO' },
      { data: 'FECHAINICIO' },
      { data: 'FECHAFIN' },
      { data: 'MODALIDAD' },
      { data: 'HORAS' },
      { data: 'COSTO' },
      {
        data: null,
        orderable: false,
        render: function (data, type, row) {
            return `<button class="btn btn-editar" data-id="${row.SECUENCIAL}" style="background-color:#e0e0e0;color:#222;border:none;"><i class="fa fa-edit"></i></button>
              <button class="btn btn-cancelar" data-id="${row.SECUENCIAL}" style="background-color:#e0e0e0;color:#222;border:none;"><i class="fa fa-ban"></i></button>`;
        }
      }
    ],
    language: { url: '../public/js/es-ES.json' },
    responsive: true
  });

  // Filtrado de eventos por estado (delegado, robusto ante cambios dinámicos)
  $('#navEstadosEventos').off('click').on('click', 'a', function(e) {
    e.preventDefault();
    $('#navEstadosEventos li').removeClass('active');
    $(this).closest('li').addClass('active');
    window.estadoSeleccionado = $(this).data('estado');
    window.tablaEventos.ajax.reload();
  });

  // Mostrar/ocultar y habilitar/deshabilitar notaAprobacion según tipo de evento
  const tipoEvento = document.getElementById('tipoEvento');
  const notaAprobacion = document.getElementById('notaAprobacion');
  const notaAprobacionGroup = notaAprobacion?.closest('.col-md-2') || null;
  if (tipoEvento && notaAprobacion && notaAprobacionGroup) {
    function toggleNotaAprobacion() {
      var selected = tipoEvento.options[tipoEvento.selectedIndex]?.text?.toLowerCase() || '';
      if (selected.includes('curso')) {
        notaAprobacionGroup.style.display = '';
        notaAprobacion.disabled = false;
      } else {
        notaAprobacionGroup.style.display = 'none';
        notaAprobacion.disabled = true;
        notaAprobacion.value = '';
      }
    }
    tipoEvento.addEventListener('change', toggleNotaAprobacion);
    toggleNotaAprobacion();
  }
});


// Ya no se usa filtrarEventosPorEstado, el filtrado es por DataTable AJAX
// ================= FUNCIONES GLOBALES =================


// Tabla global para recarga
let tablaEventos = null;

// Función reutilizable con diseño personalizado UTA
function mostrarAlertaUTA(titulo, mensaje, tipo = 'info') {
  Swal.fire({
    title: titulo,
    text: mensaje,
    imageUrl: '../public/img/uta/sweet.png',
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
  if (!chkPagado || !inputCosto) {
    console.warn('❗ Elementos del costo no encontrados.');
    return;
  }
  if (chkPagado.checked) {
    inputCosto.disabled = false;
    if (inputCosto.value == 0) inputCosto.value = '';
  } else {
    inputCosto.disabled = true;
    inputCosto.value = 0;
  }
}

// ================== GESTIÓN DE REQUISITOS ASOCIADOS (EDICIÓN) ==================
let requisitosAsociadosOriginal = [];

// Editar evento: llena el formulario y muestra el modal
function editarEvento(id) {
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
      document.getElementById('idEvento').value = e.SECUENCIAL;
      document.getElementById('titulo').value = e.TITULO;
      // Usar CKEditor para descripción si está disponible
      if (window.ckEditorDescripcion) {
        window.ckEditorDescripcion.setData(e.DESCRIPCION || '');
      } else {
        document.getElementById('descripcion').value = e.DESCRIPCION;
      }
      document.getElementById('horas').value = e.HORAS;
      document.getElementById('fechaInicio').value = e.FECHAINICIO;
      document.getElementById('fechaFin').value = e.FECHAFIN;
      document.getElementById('modalidad').value = e.CODIGOMODALIDAD;
      document.getElementById('tipoEvento').value = e.CODIGOTIPOEVENTO;
      // Selección múltiple de carreras y refresco visual con select2
      const selectCarrera = document.getElementById('carrera');
      if (selectCarrera && Array.isArray(e.CARRERAS)) {
        // Obtener los valores seleccionados como array de string
        const valoresSeleccionados = e.CARRERAS.map(c => String(c.SECUENCIAL));
        // Marcar seleccionados en el select
        Array.from(selectCarrera.options).forEach(opt => {
          opt.selected = valoresSeleccionados.includes(String(opt.value));
        });
        // Si usa select2, refrescar visualmente
        if ($(selectCarrera).data('select2')) {
          $(selectCarrera).trigger('change');
        }
      }
      document.getElementById('categoria').value = e.SECUENCIALCATEGORIA;
      document.getElementById('notaAprobacion').value = e.NOTAAPROBACION;
      document.getElementById('costo').value = e.COSTO;
      document.getElementById('capacidad').value = e.CAPACIDAD;
      document.getElementById('asistenciaMinima').value = e.ASISTENCIAMINIMA || '';
      // Usar CKEditor si está disponible
      if (window.ckEditorContenido) {
        window.ckEditorContenido.setData(e.CONTENIDO || '');
      } else {
        document.getElementById('contenido').value = e.CONTENIDO || '';
      }
      document.getElementById('esPagado').checked = e.ES_PAGADO == 1;
      // Habilitar/deshabilitar el campo de costo según el valor cargado
      toggleCosto();
      // Validar existencia de campo estado antes de asignar
      if (document.getElementById('estado')) {
        document.getElementById('estado').value = e.ESTADO;
      }
      // --- VISUALIZACIÓN ESTILO ADMIN: Generales primero, luego asociados con texto y color especial ---
      // Mostrar solo requisitos generales (SECUENCIALEVENTO == null) y asociados SOLO a este evento
      if (Array.isArray(e.TODOS_REQUISITOS) && e.SECUENCIAL) {
        const contenedor = document.getElementById('listaRequisitos');
        if (contenedor) {
          contenedor.innerHTML = '';
          // 1. Generales (SECUENCIALEVENTO == null)
          const tituloGen = document.createElement('div');
          tituloGen.innerHTML = '<span style="font-size:1.1em;"><i class="fa fa-list"></i> Requisitos Generales</span>';
          contenedor.appendChild(tituloGen);
          e.TODOS_REQUISITOS.filter(r => r.SECUENCIALEVENTO === null || r.SECUENCIALEVENTO === undefined).forEach(req => {
            const div = document.createElement('div');
            div.className = 'form-check';
            const input = document.createElement('input');
            input.type = 'checkbox';
            input.className = 'form-check-input';
            input.name = 'requisitos[]';
            input.value = req.SECUENCIAL;
            input.id = 'req_' + req.SECUENCIAL;
            // Marcar si está en REQUISITOS_ASOCIADOS
            if (Array.isArray(e.REQUISITOS_ASOCIADOS)) {
              const found = e.REQUISITOS_ASOCIADOS.some(r => {
                if (typeof r === 'object' && r !== null) return String(r.SECUENCIAL) === String(req.SECUENCIAL);
                return String(r) === String(req.SECUENCIAL);
              });
              input.checked = found;
            }
            const label = document.createElement('label');
            label.className = 'form-check-label';
            label.htmlFor = input.id;
            label.textContent = req.DESCRIPCION;
            div.appendChild(input);
            div.appendChild(label);
            contenedor.appendChild(div);
          });
          // 2. Separador para asociados
          const sep = document.createElement('div');
          sep.innerHTML = '<span style="font-size:1.1em;margin-top:8px;display:block;color:#b71c1c"><i class="fa fa-link"></i> Requisitos Asociados solo a este evento</span>';
          sep.id = 'tituloRequisitosAsociados';
          sep.style.marginTop = '8px';
          contenedor.appendChild(sep);
          // 3. Asociados (SOLO de este evento, SECUENCIALEVENTO == e.SECUENCIAL)
          e.TODOS_REQUISITOS.filter(r => String(r.SECUENCIALEVENTO) === String(e.SECUENCIAL)).forEach(req => {
            const div = document.createElement('div');
            div.className = 'form-check req-dinamico';
            const input = document.createElement('input');
            input.type = 'checkbox';
            input.className = 'form-check-input';
            input.name = 'requisitos[]';
            input.value = req.SECUENCIAL;
            input.id = 'req_' + req.SECUENCIAL;
            input.checked = true;
            input.style.outline = '2px solid #b71c1c';
            const label = document.createElement('label');
            label.className = 'form-check-label';
            label.htmlFor = input.id;
            label.textContent = req.DESCRIPCION;
            label.style.color = '#222';
            label.style.fontWeight = 'normal';
            div.appendChild(input);
            div.appendChild(label);
            contenedor.appendChild(div);
          });
        }
      }
      // Guardar los requisitos asociados originales (para validación de duplicados y control de desasociación)
      requisitosAsociadosOriginal = [];
      if (Array.isArray(e.REQUISITOS_ASOCIADOS)) {
        requisitosAsociadosOriginal = e.REQUISITOS_ASOCIADOS.map(r => typeof r === 'object' && r !== null ? String(r.SECUENCIAL) : String(r));
      }
      // Añadir listeners para prevenir duplicados y advertir si ya estaba asociado
      setTimeout(() => {
        document.querySelectorAll('input[name="requisitos[]"]').forEach(chk => {
          chk.addEventListener('change', function (ev) {
            const val = String(this.value);
            // Buscar todos los checkboxes con el mismo valor
            const allSame = Array.from(document.querySelectorAll('input[name="requisitos[]"][value="' + val + '"]'));
            // Si ya hay uno marcado (además de este), no permitir marcar otro
            const checkedCount = allSame.filter(c => c.checked).length;
            if (this.checked && checkedCount > 1) {
              this.checked = false;
              Swal.fire({
                icon: 'warning',
                title: 'Requisito duplicado',
                text: 'Ya seleccionaste este requisito para este evento. No puedes asociarlo más de una vez.',
                confirmButtonText: 'Aceptar',
                customClass: { popup: 'swal2-popup', confirmButton: 'swal2-confirm' }
              });
              return;
            }
            // Si el usuario intenta marcar un requisito general que ya tiene una copia asociada
            // (es decir, si existe un asociado con la misma descripción y este checkbox es general)
            const label = this.parentElement.querySelector('label');
            const desc = label ? label.textContent.trim() : '';
            // Buscar si hay un asociado (checkbox con outline rojo y misma descripción)
            const asociados = Array.from(document.querySelectorAll('.req-dinamico label'));
            const yaAsociado = asociados.some(lab => lab.textContent.trim() === desc);
            if (this.checked && yaAsociado && this.parentElement.className.indexOf('req-dinamico') === -1) {
              this.checked = false;
              Swal.fire({
                icon: 'warning',
                title: 'Requisito ya asociado',
                text: 'Este requisito general ya está asociado a este evento como exclusivo. No puedes volver a seleccionarlo.',
                confirmButtonText: 'Aceptar',
                customClass: { popup: 'swal2-popup', confirmButton: 'swal2-confirm' }
              });
              return;
            }
          });
        });
      }, 200);
      // Mostrar nombres de imágenes si existen
      const nombrePortada = document.getElementById('nombrePortada');
      const nombreGaleria = document.getElementById('nombreGaleria');
      if (nombrePortada) {
        nombrePortada.textContent = e.PORTADA ? e.PORTADA : '';
      }
      if (nombreGaleria) {
        nombreGaleria.textContent = e.GALERIA ? e.GALERIA : '';
      }
      document.getElementById('btn-save').innerHTML = 'Actualizar';
      // Marcar el checkbox de destacado si corresponde
      const chkDestacado = document.getElementById('esDestacado');
      if (chkDestacado) {
        chkDestacado.checked = e.ES_DESTACADO == 1 || e.ES_DESTACADO === '1';
      }
      $('#modalEvento').modal('show');
    })
    .catch(err => {
      console.error('Error al cargar evento para edición:', err);
      mostrarAlertaUTA('Error', 'No se pudo cargar el evento.', 'error');
    });
}

// Cancelar evento (marcar como cancelado)
function cancelarEvento(id) {
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
      axios.get(`../controllers/EventosController.php?option=cancelar&id=${id}`)
        .then(res => {
          const info = res.data;
          if (info.tipo === 'success') {
            mostrarAlertaUTA('Cancelado', info.mensaje, 'success');
            if (window.tablaEventos) window.tablaEventos.ajax.reload(null, false);
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
  // cargarEventos(); // Eliminado: ya no existe, DataTable maneja la carga
  cargarSelects();

  const frm = document.querySelector('#formEvento');
  const btnSave = document.getElementById('btn-save');
  const idEvento = document.getElementById('idEvento');
  const btnNuevo = document.getElementById('btn-nuevo');

  document.getElementById('esPagado')?.addEventListener('change', toggleCosto);
  toggleCosto();

  // Delegación para editar
  $(document).on('click', '.btn-editar', function () {
    const id = $(this).data('id');
    editarEvento(id);
  });
  // Delegación para cancelar
  $(document).on('click', '.btn-cancelar', function () {
    const id = $(this).data('id');
    cancelarEvento(id);
  });

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
    // Añadir campos manualmente para asegurar que se envían correctamente
    // Usar CKEditor para obtener el contenido y la descripción si están disponibles
    if (window.ckEditorContenido) {
      formData.set('contenido', window.ckEditorContenido.getData());
    } else {
      formData.set('contenido', frm.contenido?.value || '');
    }
    if (window.ckEditorDescripcion) {
      formData.set('descripcion', window.ckEditorDescripcion.getData());
    } else {
      formData.set('descripcion', frm.descripcion?.value || '');
    }
    formData.set('asistenciaMinima', frm.asistenciaMinima?.value || '');
    // Carreras: enviar como array (soporte para select múltiple)
    const selectCarrera = frm.carrera;
    if (selectCarrera && selectCarrera.multiple) {
      // Elimina cualquier valor previo
      formData.delete('carrera');
      Array.from(selectCarrera.selectedOptions).forEach(opt => {
        formData.append('carrera[]', opt.value);
      });
    }
    // Requisitos: enviar como array (soporte para checkboxes)
    formData.delete('requisitos[]');
    document.querySelectorAll('input[name="requisitos[]"]:checked').forEach(chk => {
      formData.append('requisitos[]', chk.value);
    });
    // Habilitar/deshabilitar el input de costo según el checkbox esPagado
    const chkPagado = document.getElementById('esPagado');
    const inputCosto = document.getElementById('costo');
    if (chkPagado) {
      if (chkPagado.checked) {
        inputCosto.disabled = false;
      } else {
        inputCosto.disabled = true;
        inputCosto.value = 0;
      }
    }
    // Imágenes
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
            // Recargar la tabla de eventos dinámicamente
            if (window.tablaEventos) window.tablaEventos.ajax.reload(null, false);
          });
        } else {
          // Mostrar el error devuelto por el backend, si existe
          let mensaje = info?.mensaje || 'Ocurrió un error al guardar.';
          // Mostrar todo el objeto info por consola para depuración
          console.error('Respuesta backend:', info);
          // Si hay más información, mostrarla en el alert
          if (info?.debug) {
            mensaje += `\n\n[Debug: ${info.debug}]`;
          }
          if (info?.error) {
            mensaje += `\n\n[Detalles: ${info.error}]`;
          }
          mostrarAlertaUTA('Error', mensaje, 'error');
        }
      })
      .catch(err => {
        // Imprimir el error completo en consola para depuración
        if (err.response) {
          console.error('❌ Error inesperado (response):', err.response);
          mostrarAlertaUTA('Error', `No se pudo guardar el evento.\n\n[${err.response.status}: ${err.response.statusText}]`, 'error');
        } else if (err.request) {
          console.error('❌ Error inesperado (request):', err.request);
          mostrarAlertaUTA('Error', 'No se pudo guardar el evento.\n\n[Sin respuesta del servidor]', 'error');
        } else {
          console.error('❌ Error inesperado:', err);
          mostrarAlertaUTA('Error', 'No se pudo guardar el evento.\n\n[Error desconocido]', 'error');
        }
      });
  };

  $('#modalEvento').on('hidden.bs.modal', () => {
    frm.reset();
    btnSave.innerHTML = 'Guardar';
    toggleCosto();
  });

  btnNuevo?.addEventListener('click', () => {
    frm.reset();
    idEvento.value = '';
    btnSave.innerHTML = 'Guardar';
    // Limpiar CKEditor
    if (window.ckEditorDescripcion) window.ckEditorDescripcion.setData('');
    if (window.ckEditorContenido) window.ckEditorContenido.setData('');
    // Limpiar selects con select2
    const selectCarrera = document.getElementById('carrera');
    if (selectCarrera && $(selectCarrera).data('select2')) {
      $(selectCarrera).val(null).trigger('change');
    }
    // Limpiar checkboxes
    document.getElementById('esPagado').checked = false;
    document.getElementById('esDestacado').checked = false;
    // Limpiar input de costo
    document.getElementById('costo').value = 0;
    document.getElementById('costo').disabled = true;
    // Limpiar archivos
    if (document.getElementById('urlPortada')) document.getElementById('urlPortada').value = '';
    if (document.getElementById('urlGaleria')) document.getElementById('urlGaleria').value = '';
    if (document.getElementById('nombrePortada')) document.getElementById('nombrePortada').textContent = '';
    if (document.getElementById('nombreGaleria')) document.getElementById('nombreGaleria').textContent = '';
    // Limpiar requisitos
    document.querySelectorAll('input[name="requisitos[]"]').forEach(chk => chk.checked = false);
    toggleCosto();
    $('#modalEvento').modal('show');
  });
});
