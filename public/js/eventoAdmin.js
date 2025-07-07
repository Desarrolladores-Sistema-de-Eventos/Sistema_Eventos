// Cargar requisitos generales y mostrarlos en el modal
// Cargar requisitos generales y mostrarlos en el modal, usando IDs únicos y patrón robusto
function cargarRequisitosGenerales() {
    axios.get('../controllers/EventosAdminController.php?option=requisitos_generales')
        .then(function(response) {
            const requisitos = response.data;
            const contenedor = document.getElementById('listaRequisitos');
            if (!contenedor) return;
            contenedor.innerHTML = '';
            // Título para requisitos generales
            const tituloGen = document.createElement('div');
            tituloGen.innerHTML = '<span style="font-size:1.1em;"><i class="fa fa-list"></i> Requisitos Generales</span>';
            contenedor.appendChild(tituloGen);
            requisitos.forEach(function(req) {
                const div = document.createElement('div');
                div.className = 'form-check';
                const input = document.createElement('input');
                input.type = 'checkbox';
                input.className = 'form-check-input';
                input.name = 'requisitos[]';
                input.value = req.SECUENCIAL;
                input.id = 'req_' + req.SECUENCIAL;
                const label = document.createElement('label');
                label.className = 'form-check-label';
                label.htmlFor = input.id;
                label.textContent = req.DESCRIPCION;
                div.appendChild(input);
                div.appendChild(label);
                contenedor.appendChild(div);
            });
            // Separador para requisitos asociados
            const sep = document.createElement('div');
            sep.innerHTML = '<span style="font-size:1.1em;margin-top:8px;display:block;color:#b71c1c"><i class="fa fa-link"></i> Requisitos Asociados solo a este evento</span>';
            sep.id = 'tituloRequisitosAsociados';
            sep.style.marginTop = '8px';
            contenedor.appendChild(sep);
        });
}
// Función para cargar datos en el modal (flujo clásico)
function cargarDatosEvento(id) {
    // Espera a que todos los selects y requisitos estén listos antes de cargar datos
    Promise.all([
        new Promise(resolve => {
            if ($('#carrera option').length > 0) return resolve();
            cargarSelectsEvento();
            const check = () => $('#carrera option').length > 0 ? resolve() : setTimeout(check, 80);
            check();
        }),
        new Promise(resolve => {
            if ($('#responsable option').length > 0 && $('#organizador option').length > 0) return resolve();
            cargarSelectOrganizadores();
            const check = () => ($('#responsable option').length > 0 && $('#organizador option').length > 0) ? resolve() : setTimeout(check, 80);
            check();
        }),
        new Promise(resolve => {
            if (document.querySelectorAll('#listaRequisitos input[name="requisitos[]"]').length > 0) return resolve();
            cargarRequisitosGenerales();
            const check = () => document.querySelectorAll('#listaRequisitos input[name="requisitos[]"]').length > 0 ? resolve() : setTimeout(check, 80);
            check();
        })
    ]).then(() => {
        axios.get(`../controllers/EventosAdminController.php?option=get&id=${id}`)
            .then(res => {
                const e = res.data;
                console.log('Datos recibidos para edición:', e);
                if (!e || typeof e !== 'object') {
                    mostrarAlertaUTA('Error', 'No se recibieron datos válidos del evento.', 'error');
                    return;
                }
                document.getElementById('idEvento').value = e.SECUENCIAL;
                document.getElementById('titulo').value = e.TITULO;
                // CKEditor para descripcion
                if (window.CKEDITOR && CKEDITOR.instances['descripcion']) {
                  CKEDITOR.instances['descripcion'].setData(e.DESCRIPCION || '');
                } else if (window.ClassicEditor && document.getElementById('descripcion').ckeditorInstance) {
                  document.getElementById('descripcion').ckeditorInstance.setData(e.DESCRIPCION || '');
                } else {
                  document.getElementById('descripcion').value = e.DESCRIPCION;
                }
                // CKEditor para contenido
                if (window.CKEDITOR && CKEDITOR.instances['contenido']) {
                  CKEDITOR.instances['contenido'].setData(e.CONTENIDO || '');
                } else if (window.ClassicEditor && document.getElementById('contenido').ckeditorInstance) {
                  document.getElementById('contenido').ckeditorInstance.setData(e.CONTENIDO || '');
                } else if (document.getElementById('contenido')) {
                  document.getElementById('contenido').value = e.CONTENIDO || '';
                }
                document.getElementById('horas').value = e.HORAS;
                document.getElementById('fechaInicio').value = e.FECHAINICIO;
                document.getElementById('fechaFin').value = e.FECHAFIN;
                document.getElementById('modalidad').value = e.CODIGOMODALIDAD;
                document.getElementById('tipoEvento').value = e.CODIGOTIPOEVENTO;
                // Marcar múltiples carreras y refrescar select2
                if (Array.isArray(e.CARRERAS)) {
                    const select = document.getElementById('carrera');
                    const carrerasStr = e.CARRERAS.map(String);
                    for (const opt of select.options) {
                        opt.selected = carrerasStr.includes(String(opt.value));
                    }
                    if ($(select).hasClass('select2-hidden-accessible')) {
                        $(select).trigger('change');
                    }
                }
                document.getElementById('categoria').value = e.SECUENCIALCATEGORIA;
                document.getElementById('notaAprobacion').value = e.NOTAAPROBACION;
                document.getElementById('costo').value = e.COSTO;
                document.getElementById('capacidad').value = e.CAPACIDAD;
                document.getElementById('esSoloInternos').value = e.ES_SOLO_INTERNOS;
                document.getElementById('esPagado').checked = e.ES_PAGADO == 1;
                document.getElementById('esDestacado').checked = e.ES_DESTACADO == 1;
                document.getElementById('asistenciaMinima').value = e.ASISTENCIAMINIMA || '';

                // Asignar responsable y organizador seleccionados
                const responsableSelect = document.getElementById('responsable');
                const organizadorSelect = document.getElementById('organizador');
                responsableSelect.value = e.RESPONSABLE || '';
                organizadorSelect.value = e.ORGANIZADOR || '';

                if ($(responsableSelect).hasClass('select2-hidden-accessible')) {
                    $(responsableSelect).trigger('change');
                }
                if ($(organizadorSelect).hasClass('select2-hidden-accessible')) {
                    $(organizadorSelect).trigger('change');
                }

                const costoInput = document.getElementById('costo');
                if (e.ES_PAGADO == 1) {
                    costoInput.removeAttribute('readonly');
                } else {
                    costoInput.setAttribute('readonly', true);
                    costoInput.value = '0';
                }

                // --- NUEVO: Marcar los requisitos asociados al evento (patrón robusto y amigable) ---
                if (Array.isArray(e.requisitos)) {
                    console.log('Requisitos para marcar:', e.requisitos);
                    // Desmarcar todos primero
                    document.querySelectorAll('input[name="requisitos[]"]').forEach(cb => cb.checked = false);
                    // Limpiar primero todos los requisitos dinámicos agregados anteriormente
                    document.querySelectorAll('#listaRequisitos .req-dinamico').forEach(el => el.remove());
                    // Ocultar el título de asociados si no hay ninguno
                    const tituloAsociados = document.getElementById('tituloRequisitosAsociados');
                    if (tituloAsociados) tituloAsociados.style.display = 'none';
                    // Obtener el listado de requisitos generales para buscar el nombre
                    const requisitosGenerales = Array.from(document.querySelectorAll('#listaRequisitos input[name="requisitos[]"]')).map(cb => ({
                        id: cb.value,
                        label: cb.nextSibling && cb.nextSibling.textContent ? cb.nextSibling.textContent : ''
                    }));
                    let hayAsociados = false;
                    e.requisitos.map(String).forEach(function(idReq) {
                        var checkbox = document.querySelector('#req_' + idReq);
                        if (!checkbox) {
                            // Buscar el nombre del requisito en la respuesta del backend (si está disponible)
                            let nombreReq = '';
                            if (e.requisitos_detalle && Array.isArray(e.requisitos_detalle)) {
                                const encontrado = e.requisitos_detalle.find(r => String(r.SECUENCIAL) === idReq);
                                if (encontrado) nombreReq = encontrado.DESCRIPCION;
                            }
                            // Si no se encuentra, buscar en los requisitos generales
                            if (!nombreReq) {
                                const encontrado = requisitosGenerales.find(r => r.id === idReq);
                                if (encontrado) nombreReq = encontrado.label;
                            }
                            // Si aún no se encuentra, mostrar solo el ID
                            if (!nombreReq) nombreReq = '(ID: ' + idReq + ')';
                            const contenedor = document.getElementById('listaRequisitos');
                            if (contenedor) {
                                const div = document.createElement('div');
                                div.className = 'form-check req-dinamico';
                                const input = document.createElement('input');
                                input.type = 'checkbox';
                                input.className = 'form-check-input';
                                input.name = 'requisitos[]';
                                input.value = idReq;
                                input.id = 'req_' + idReq;
                                input.checked = true;
                                // Marcar visualmente que es un requisito solo de este evento
                                input.style.outline = '2px solid #b71c1c';
                                const label = document.createElement('label');
                                label.className = 'form-check-label';
                                label.htmlFor = input.id;
                                label.textContent = nombreReq + ' (asociado solo a este evento)';
                                label.style.color = '#222'; // Negro
                                label.style.fontWeight = 'normal'; // Sin negrilla
                                div.appendChild(input);
                                div.appendChild(label);
                                contenedor.appendChild(div);
                                hayAsociados = true;
                            }
                            console.warn('No se encontró checkbox para requisito', idReq, '-> Se agregó dinámicamente con nombre:', nombreReq);
                        } else {
                            checkbox.checked = true;
                        }
                    });
                    // Mostrar u ocultar el título de asociados según corresponda
                    const tituloAsociados2 = document.getElementById('tituloRequisitosAsociados');
                    if (tituloAsociados2) {
                        tituloAsociados2.style.display = hayAsociados ? 'block' : 'none';
                    }
                } else {
                    console.warn('No se recibió array de requisitos para marcar:', e.requisitos);
                }

                // Mostrar nombres de imágenes si existen
                if (window.mostrarNombresImagenesEvento) {
                    window.mostrarNombresImagenesEvento(e.NOMBRE_PORTADA || '', e.NOMBRE_GALERIA || '');
                }
                // Mostrar el modal y cambiar el texto del botón
                $('#modalEvento').modal('show');
                document.getElementById('btn-save').innerHTML = 'Actualizar';
            });
    });
}
let tablaEventos;

// Alerta institucional reutilizable
function mostrarAlertaUTA(titulo, texto = '', tipo = 'info') {
    Swal.fire({
        icon: tipo,
        title: titulo,
        text: texto,
        customClass: {
            popup: 'swal2-popup',
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel'
        }
    });
}

// Estado seleccionado para el filtro de eventos
let estadoSeleccionado = 'DISPONIBLE';

function inicializarTablaEventos() {
    if (tablaEventos) tablaEventos.destroy();
    tablaEventos = $('#tabla-eventos').DataTable({
        ajax: {
            url: '../controllers/EventosAdminController.php?option=listar',
            dataSrc: function (json) {
                return json.filter(e => e.ESTADO === estadoSeleccionado);
            }
        },
        columns: [
            {
                data: 'URLPORTADA',
                orderable: false,
                render: function (data, type, row) {
                    if (data) {
                        return `<img src="${data}" alt="Foto" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">`;
                    } else {
                        return '<span class="text-muted">Sin foto</span>';
                    }
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
                    return `
                        <button onclick="editarEvento(${row.SECUENCIAL})" class="btn btn-primary btn-sm" title="Editar" style="background-color:#e0e0e0;color:#222;border:none;">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button onclick="eliminarEvento(${row.SECUENCIAL})" class="btn btn-danger btn-sm" title="Eliminar" style="background-color:#e0e0e0;color:#222;border:none;">
                            <i class="fa fa-trash"></i>
                        </button>
                        <button onclick="cancelarEvento(${row.SECUENCIAL})" class="btn btn-warning btn-sm" title="Cancelar" style="background-color:#e0e0e0;color:#222;border:none;">
                            <i class="fa fa-ban"></i>
                        </button>
                    `;
                }
            }
        ],
        language: {
            url: '../public/js/es-ES.json'
        }
    });
}

function cargarSelectOrganizadores() {
    return axios.get('../controllers/EventosAdminController.php?option=organizadores')
        .then(res => {
            const data = res.data;
            llenarSelect('responsable', data);
            llenarSelect('organizador', data);
        });
}

function cargarSelectsEvento() {
    axios.get('../controllers/EventosAdminController.php?option=catalogos')
        .then(res => {
            llenarSelectGenerico('carrera', res.data.carreras, 'SECUENCIAL', 'NOMBRE_CARRERA');
            llenarSelectGenerico('tipoEvento', res.data.tipos, 'CODIGO', 'NOMBRE');
            llenarSelectGenerico('modalidad', res.data.modalidades, 'CODIGO', 'NOMBRE');
            llenarSelectGenerico('categoria', res.data.categorias, 'SECUENCIAL', 'NOMBRE');
        });
}

function llenarSelect(id, opciones) {
    const select = document.getElementById(id);
    if (!select) return;
    select.innerHTML = '<option value="">Seleccione</option>';
    opciones.forEach(op => {
        const opt = document.createElement('option');
        opt.value = op.SECUENCIAL;
        opt.textContent = op.NOMBRE;
        select.appendChild(opt);
    });
}

function llenarSelectGenerico(id, opciones, valueField, textField) {
    const select = document.getElementById(id);
    if (!select) return;
    // Si es el select de carreras (múltiple), no poner opción vacía
    if (select.multiple) {
        select.innerHTML = '';
    } else {
        select.innerHTML = '<option value="">Seleccione</option>';
    }
    opciones.forEach(op => {
        const opt = document.createElement('option');
        opt.value = op[valueField];
        opt.textContent = op[textField];
        select.appendChild(opt);
    });
}

// Unificamos el flujo de edición para usar la función robusta con Promise.all
function editarEvento(id) {
    cargarDatosEvento(id);
}

function eliminarEvento(id) {
    Swal.fire({
        title: '¿Eliminar evento?',
        text: 'Viola la integridad referencial. Si lo eliminas, se eliminarán todos los registros relacionados.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        customClass: {
            popup: 'swal2-popup',
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel'
        }
    }).then(result => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('id', id);
            axios.post('../controllers/EventosAdminController.php?option=eliminar', formData)
                .then(res => {
                    if (res.data.success) {
                        mostrarAlertaUTA('Eliminado', 'Evento eliminado correctamente.', 'success');
                        tablaEventos.ajax.reload();
                    } else {
                        mostrarAlertaUTA('Error', res.data.mensaje, 'error');
                    }
                });
        }
    });
}

function cancelarEvento(id) {
    Swal.fire({
        title: '¿Cancelar evento?',
        text: 'El evento será marcado como CANCELADO.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'No',
        customClass: {
            popup: 'swal2-popup',
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel'
        }
    }).then(result => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('id', id);
            axios.post('../controllers/EventosAdminController.php?option=cancelar', formData)
                .then(res => {
                    if (res.data.success) {
                        mostrarAlertaUTA('Cancelado', 'Evento cancelado.', 'success');
                        tablaEventos.ajax.reload();
                    } else {
                        mostrarAlertaUTA('Error', res.data.mensaje, 'error');
                    }
                });
        }
    });
}



document.addEventListener('DOMContentLoaded', function () {
    inicializarTablaEventos();

    // Nav tabs para filtrar por estado
    $('#navEstadosEventos a').on('click', function (e) {
        e.preventDefault();
        $('#navEstadosEventos li').removeClass('active');
        $(this).parent().addClass('active');
        estadoSeleccionado = $(this).data('estado');
        tablaEventos.ajax.reload();
    });
    cargarSelectOrganizadores();
    cargarSelectsEvento();

    // Inicializar select2 para carreras
    $("#carrera").select2({
        placeholder: "Seleccione una o varias carreras",
        width: '100%'
    });



    const frm = document.getElementById('formEvento');
    const btnSave = document.getElementById('btn-save');
    const idEvento = document.getElementById('idEvento');
    const esPagadoCheckbox = document.getElementById('esPagado');
    const costoInput = document.getElementById('costo');

    if (esPagadoCheckbox && costoInput) {
        esPagadoCheckbox.addEventListener('change', function () {
            if (this.checked) {
                costoInput.removeAttribute('readonly');
                costoInput.value = '';
            } else {
                costoInput.setAttribute('readonly', true);
                costoInput.value = '0';
            }
        });

        if (!esPagadoCheckbox.checked) {
            costoInput.setAttribute('readonly', true);
            costoInput.value = '0';
        }
    }

    if (frm) {
        frm.onsubmit = function (e) {
            e.preventDefault();

            const titulo = document.getElementById('titulo').value.trim();
            // Obtener datos de CKEditor si está presente
            let descripcion = '';
            if (window.CKEDITOR && CKEDITOR.instances['descripcion']) {
                descripcion = CKEDITOR.instances['descripcion'].getData();
            } else if (window.ClassicEditor && document.getElementById('descripcion').ckeditorInstance) {
                descripcion = document.getElementById('descripcion').ckeditorInstance.getData();
            } else {
                descripcion = document.getElementById('descripcion').value.trim();
            }
            let contenido = '';
            if (window.CKEDITOR && CKEDITOR.instances['contenido']) {
                contenido = CKEDITOR.instances['contenido'].getData();
            } else if (window.ClassicEditor && document.getElementById('contenido').ckeditorInstance) {
                contenido = document.getElementById('contenido').ckeditorInstance.getData();
            } else if (document.getElementById('contenido')) {
                contenido = document.getElementById('contenido').value.trim();
            }
            const horas = parseFloat(document.getElementById('horas').value);
            const capacidad = parseInt(document.getElementById('capacidad').value);
            const notaAprobacion = parseFloat(document.getElementById('notaAprobacion').value);
            const asistenciaMinima = parseFloat(document.getElementById('asistenciaMinima').value);
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;
            const hoy = new Date().toISOString().split('T')[0];
            const costo = parseFloat(costoInput.value);
            const esPagado = esPagadoCheckbox.checked;
            const esDestacado = document.getElementById('esDestacado').checked;

            if (titulo.length < 3) return mostrarAlertaUTA('Error', 'El título debe tener al menos 3 caracteres.', 'error');
            if (descripcion.replace(/<[^>]*>/g, '').length < 10) return mostrarAlertaUTA('Error', 'La descripción debe tener al menos 10 caracteres.', 'error');
            if (isNaN(horas) || horas <= 0) return mostrarAlertaUTA('Error', 'Las horas deben ser mayores a 0.', 'error');
            if (isNaN(capacidad) || capacidad <= 0) return mostrarAlertaUTA('Error', 'La capacidad debe ser positiva.', 'error');
            if (!isNaN(notaAprobacion) && (notaAprobacion < 0 || notaAprobacion > 100)) return mostrarAlertaUTA('Error', 'Nota fuera de rango.', 'error');
            if (!isNaN(asistenciaMinima) && (asistenciaMinima < 0 || asistenciaMinima > 100)) return mostrarAlertaUTA('Error', 'Asistencia mínima fuera de rango.', 'error');
            if (fechaInicio < hoy) return mostrarAlertaUTA('Error', 'Fecha de inicio inválida.', 'error');
            if (fechaFin && fechaFin < fechaInicio) return mostrarAlertaUTA('Error', 'Fecha fin menor a inicio.', 'error');
            if (esPagado && (isNaN(costo) || costo <= 0)) return mostrarAlertaUTA('Error', 'Costo requerido para eventos pagados.', 'error');

            // Validar que haya al menos una carrera seleccionada
            const carreras = Array.from(document.getElementById('carrera').selectedOptions).map(opt => opt.value).filter(v => v);
            if (carreras.length === 0) return mostrarAlertaUTA('Error', 'Debe seleccionar al menos una carrera.', 'error');

            const formData = new FormData(frm);
            formData.set('descripcion', descripcion);
            formData.set('contenido', contenido);
            formData.set('esPagado', esPagado ? 1 : 0);
            formData.set('esDestacado', esDestacado ? 1 : 0);
            formData.set('costo', esPagado ? costoInput.value : '0');
            formData.set('estado', 'DISPONIBLE');
            formData.set('asistenciaMinima', isNaN(asistenciaMinima) ? '' : asistenciaMinima);
            // Elimina posibles valores vacíos
            formData.delete('carrera');
            carreras.forEach(c => formData.append('carrera[]', c));

            let url = '../controllers/EventosAdminController.php?option=crear';
            if (idEvento.value !== '') {
                url = '../controllers/EventosAdminController.php?option=editar';
                formData.append('id', idEvento.value);
            }

            axios.post(url, formData)
                .then(res => {
                    if (res.data.success) {
                        mostrarAlertaUTA('Éxito', 'Evento guardado.', 'success');
                        $('#modalEvento').modal('hide');
                        tablaEventos.ajax.reload();
                        frm.reset();
                        btnSave.innerHTML = 'Guardar';
                    } else {
                        mostrarAlertaUTA('Error', res.data.mensaje, 'error');
                    }
                });
        };
    }

    $('#modalEvento').on('hidden.bs.modal', function () {
        frm.reset();
        btnSave.innerHTML = 'Guardar';
        document.getElementById('costo').value = '0';
        document.getElementById('costo').setAttribute('readonly', true);
        // Limpiar select2 visualmente
        $('#carrera').val(null).trigger('change');
    });

    // Solo agregar el listener si existe el modal (modo modal)
    if (document.getElementById('modalEvento')) {
      document.getElementById('btn-nuevo')?.addEventListener('click', function (e) {
          e.preventDefault();
          frm.reset();
          idEvento.value = '';
          btnSave.innerHTML = 'Guardar';
          document.getElementById('costo').value = '0';
          document.getElementById('costo').setAttribute('readonly', true);
          // Limpiar select2 visualmente
          $('#carrera').val(null).trigger('change');
          cargarRequisitosGenerales();
          $('#modalEvento').modal('show');
      });
    }
});
  document.addEventListener('DOMContentLoaded', function() {
    // Inicialización robusta de CKEditor 5 para evitar dobles instancias
    if (document.getElementById('descripcion')) {
      if (!document.getElementById('descripcion').ckeditorInstance) {
        ClassicEditor.create(document.getElementById('descripcion'), {
          toolbar: [
            'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'link', 'undo', 'redo'
          ]
        }).then(editor => {
          document.getElementById('descripcion').ckeditorInstance = editor;
        }).catch(error => { console.error(error); });
      }
    }
    if (document.getElementById('contenido')) {
      if (!document.getElementById('contenido').ckeditorInstance) {
        ClassicEditor.create(document.getElementById('contenido'), {
          toolbar: [
            'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'link', 'undo', 'redo'
          ]
        }).then(editor => {
          document.getElementById('contenido').ckeditorInstance = editor;
        }).catch(error => { console.error(error); });
      }
    }
  });