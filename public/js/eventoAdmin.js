let tablaEventos;
let tiposEventoConfig = [];

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

function inicializarTablaEventos() {
    const mostrarCancelados = document.getElementById('mostrarCancelados')?.checked;

    if (tablaEventos) tablaEventos.destroy();
    tablaEventos = $('#tabla-eventos').DataTable({
        ajax: {
            url: '../controllers/EventosAdminController.php?option=listar',
            dataSrc: function (json) {
                if (mostrarCancelados) {
                    return json.filter(e => e.ESTADO === 'CANCELADO');
                }
                return json.filter(e => e.ESTADO === 'DISPONIBLE');
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
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <button onclick="editarEvento(${row.SECUENCIAL})" class="btn btn-primary btn-sm" title="Editar"><i class="fa fa-pencil"></i></button>
                        <button onclick="eliminarEvento(${row.SECUENCIAL})" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash"></i></button>
                        <button onclick="cancelarEvento(${row.SECUENCIAL})" class="btn btn-warning btn-sm" title="Cancelar"><i class="fa fa-ban"></i></button>
                    `;
                }
            }
        ],
        language: {
            url: '../public/js/es-ES.json'
        }
    });
}

function cargarSelectOrganizadores(callback) {
    axios.get('../controllers/EventosAdminController.php?option=organizadores')
        .then(res => {
            const data = res.data;
            llenarSelect('responsable', data);
            llenarSelect('organizador', data);
            if (typeof callback === 'function') callback();
        });
}

function cargarSelectsEvento() {
    axios.get('../controllers/EventosAdminController.php?option=catalogos')
        .then(res => {
            llenarSelectGenerico('carrera', res.data.carreras, 'SECUENCIAL', 'NOMBRE_CARRERA');
            llenarSelectGenerico('tipoEvento', res.data.tipos, 'CODIGO', 'NOMBRE');
            llenarSelectGenerico('modalidad', res.data.modalidades, 'CODIGO', 'NOMBRE');
            llenarSelectGenerico('categoria', res.data.categorias, 'SECUENCIAL', 'NOMBRE');
            // Guardar la configuración de tipos de evento para uso posterior
            tiposEventoConfig = res.data.tipos;
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
    // Si es el select de carreras, agrega la opción "Todas las carreras" primero
    if (id === 'carrera') {
        const idTodas = 'TODAS';
        select.value = null;
        if (select.choicesInstance) {
            select.choicesInstance.destroy();
            select.choicesInstance = null;
        }
        select.innerHTML = `<option value="${idTodas}">Todas las carreras</option>`;
        // Ordenar alfabéticamente las carreras por nombre
        opciones = opciones.slice().sort((a, b) => {
            const nombreA = a[textField].toUpperCase();
            const nombreB = b[textField].toUpperCase();
            if (nombreA < nombreB) return -1;
            if (nombreA > nombreB) return 1;
            return 0;
        });
        // Guardar los IDs de todas las carreras reales en window.idsTodasCarreras
        window.idsTodasCarreras = opciones.map(op => op[valueField].toString());
    } else {
        select.innerHTML = '<option value="">Seleccione</option>';
    }
    opciones.forEach(op => {
        const opt = document.createElement('option');
        opt.value = op[valueField];
        opt.textContent = op[textField];
        select.appendChild(opt);
    });
    // Inicializar Choices.js solo para carreras (después de llenar)
    if (id === 'carrera') {
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

        // Lógica para controlar la opción 'Todas las carreras' (ahora valor idTodas)
        select.removeEventListener('change', select.carrerasChangeHandler);
        select.carrerasChangeHandler = function (e) {
            const idTodas = 'TODAS';
            let values = Array.from(select.selectedOptions).map(opt => opt.value);
            const btnLimpiar = document.getElementById('btnLimpiarCarreras');
            // Si seleccionas 'Todas las carreras', deshabilitar Choices.js completamente
            if (values.includes(idTodas)) {
                // Solo dejar 'Todas las carreras' seleccionada
                select.choicesInstance.removeActiveItems();
                select.choicesInstance.setChoiceByValue(idTodas);
                select.choicesInstance.disable();
                if (btnLimpiar) btnLimpiar.style.display = '';
            } else {
                select.choicesInstance.enable();
                // Si hay alguna carrera seleccionada, deshabilitar 'Todas las carreras'
                const allChoices = select.choicesInstance._store.choices;
                if (values.length > 0) {
                    allChoices.forEach(choice => {
                        if (choice.value === idTodas) {
                            choice.disabled = true;
                        } else {
                            choice.disabled = false;
                        }
                    });
                } else {
                    // Si no hay nada seleccionado, habilitar todo
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
        // Lógica para limpiar selección
        const btnLimpiar = document.getElementById('btnLimpiarCarreras');
        if (btnLimpiar) {
            btnLimpiar.addEventListener('click', function() {
                if (select.choicesInstance) {
                    select.choicesInstance.removeActiveItems();
                    select.choicesInstance.enable();
                }
                btnLimpiar.style.display = 'none';
            });
        }
        // --- NUEVO: Forzar exclusividad en tiempo real usando addItem de Choices.js ---
        select.choicesInstance.passedElement.element.addEventListener('addItem', function(event) {
            const idTodas = 'TODAS';
            const value = event.detail.value;
            let currentValues = select.choicesInstance.getValue(true);
            const btnLimpiar = document.getElementById('btnLimpiarCarreras');
            if (value === idTodas && currentValues.length > 1) {
                // Si se selecciona 'Todas las carreras' y ya hay otras, limpiar y dejar solo esa
                setTimeout(() => {
                    select.choicesInstance.removeActiveItems();
                    select.choicesInstance.setChoiceByValue(idTodas);
                    select.choicesInstance.disable();
                    if (btnLimpiar) btnLimpiar.style.display = '';
                }, 0);
            } else if (value !== idTodas && currentValues.includes(idTodas)) {
                // Si se selecciona otra y estaba 'Todas las carreras', quitar 'Todas las carreras'
                setTimeout(() => {
                    select.choicesInstance.removeActiveItemsByValue(idTodas);
                    select.choicesInstance.enable();
                    if (btnLimpiar) btnLimpiar.style.display = 'none';
                }, 0);
            }
        });
        // Permitir quitar 'Todas las carreras' con la 'X' aunque Choices.js esté deshabilitado
        select.choicesInstance.passedElement.element.addEventListener('removeItem', function(event) {
            const idTodas = 'TODAS';
            if (event.detail.value === idTodas) {
                setTimeout(() => {
                    select.choicesInstance.enable();
                    const btnLimpiar = document.getElementById('btnLimpiarCarreras');
                    if (btnLimpiar) btnLimpiar.style.display = 'none';
                }, 0);
            }
        });
    }
}

function editarEvento(id) {
    axios.get(`../controllers/EventosAdminController.php?option=get&id=${id}`)
        .then(res => {
            const e = res.data;
            // Esperar a que los selects estén llenos antes de asignar responsable y organizador
            cargarSelectOrganizadores(function() {
                document.getElementById('responsable').value = e.responsable || '';
                document.getElementById('organizador').value = e.organizador || '';
            });
            document.getElementById('idEvento').value = e.SECUENCIAL;
            document.getElementById('titulo').value = e.TITULO;
            document.getElementById('descripcion').value = e.DESCRIPCION;
            document.getElementById('horas').value = e.HORAS;
            document.getElementById('fechaInicio').value = e.FECHAINICIO;
            document.getElementById('fechaFin').value = e.FECHAFIN;
            document.getElementById('modalidad').value = e.CODIGOMODALIDAD;
            document.getElementById('tipoEvento').value = e.CODIGOTIPOEVENTO;
            // Adaptar para múltiples carreras (Choices.js)
            const selectCarrera = document.getElementById('carrera');
            if (selectCarrera && selectCarrera.choicesInstance) {
                selectCarrera.choicesInstance.removeActiveItems();
                if (Array.isArray(e.carreras)) {
                    e.carreras.forEach(function(id) {
                        selectCarrera.choicesInstance.setChoiceByValue(id.toString());
                    });
                } else if (e.carreras) {
                    selectCarrera.choicesInstance.setChoiceByValue(e.carreras.toString());
                }
            }
            document.getElementById('categoria').value = e.SECUENCIALCATEGORIA;
            document.getElementById('notaAprobacion').value = e.NOTAAPROBACION;
            document.getElementById('costo').value = e.COSTO;
            document.getElementById('capacidad').value = e.CAPACIDAD;
            document.getElementById('esSoloInternos').value = e.ES_SOLO_INTERNOS;
            document.getElementById('esPagado').checked = e.ES_PAGADO == 1;
            document.getElementById('esDestacado').checked = e.ES_DESTACADO == 1;

            const costoInput = document.getElementById('costo');
            if (e.ES_PAGADO == 1) {
                costoInput.removeAttribute('readonly');
            } else {
                costoInput.setAttribute('readonly', true);
                costoInput.value = '0';
            }

            $('#modalEvento').modal('show');
            document.getElementById('btn-save').innerHTML = 'Actualizar';
        });
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
    cargarSelectOrganizadores();
    cargarSelectsEvento();

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
            // --- AGREGADO: Si se selecciona 'TODAS', reemplazar por todos los IDs reales antes de enviar ---
            const selectCarrera = document.getElementById('carrera');
            let values = Array.from(selectCarrera.selectedOptions).map(opt => opt.value);
            if (values.includes('TODAS')) {
                // Limpiar selección y seleccionar todas las carreras reales
                selectCarrera.choicesInstance.removeActiveItems();
                window.idsTodasCarreras.forEach(function(id) {
                    selectCarrera.choicesInstance.setChoiceByValue(id);
                });
                // Actualizar el array de valores
                values = window.idsTodasCarreras;
            }
            // Forzar el valor del select antes de crear el FormData
            for (let i = 0; i < selectCarrera.options.length; i++) {
                selectCarrera.options[i].selected = values.includes(selectCarrera.options[i].value);
            }
            // --- FIN AGREGADO ---

            const titulo = document.getElementById('titulo').value.trim();
            const descripcion = document.getElementById('descripcion').value.trim();
            const horas = parseFloat(document.getElementById('horas').value);
            const capacidad = parseInt(document.getElementById('capacidad').value);
            const notaAprobacion = parseFloat(document.getElementById('notaAprobacion').value);
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;
            const hoy = new Date().toISOString().split('T')[0];
            const costo = parseFloat(costoInput.value);
            const esPagado = esPagadoCheckbox.checked;
            const esDestacado = document.getElementById('esDestacado').checked;

            if (titulo.length < 3) return mostrarAlertaUTA('Error', 'El título debe tener al menos 3 caracteres.', 'error');
            if (descripcion.length < 10) return mostrarAlertaUTA('Error', 'La descripción debe tener al menos 10 caracteres.', 'error');
            if (isNaN(horas) || horas <= 0) return mostrarAlertaUTA('Error', 'Las horas deben ser mayores a 0.', 'error');
            if (isNaN(capacidad) || capacidad <= 0) return mostrarAlertaUTA('Error', 'La capacidad debe ser positiva.', 'error');
            if (!isNaN(notaAprobacion) && (notaAprobacion < 0 || notaAprobacion > 100)) return mostrarAlertaUTA('Error', 'Nota fuera de rango.', 'error');
            if (fechaInicio < hoy) return mostrarAlertaUTA('Error', 'Fecha de inicio inválida.', 'error');
            if (fechaFin && fechaFin < fechaInicio) return mostrarAlertaUTA('Error', 'Fecha fin menor a inicio.', 'error');
            if (esPagado && (isNaN(costo) || costo <= 0)) return mostrarAlertaUTA('Error', 'Costo requerido para eventos pagados.', 'error');

            const selects = ['carrera', 'tipoEvento', 'modalidad', 'categoria', 'responsable', 'organizador'];
            for (const id of selects) {
                const val = document.getElementById(id).value;
                if (!val) return mostrarAlertaUTA('Error', `Debe seleccionar ${id}`, 'error');
            }

            const formData = new FormData(frm);
            formData.set('esPagado', esPagado ? 1 : 0);
            formData.set('esDestacado', esDestacado ? 1 : 0);
            formData.set('costo', esPagado ? costoInput.value : '0');
            formData.set('estado', 'DISPONIBLE');
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
    });

    document.getElementById('btn-nuevo')?.addEventListener('click', function (e) {
        e.preventDefault();
        frm.reset();
        idEvento.value = '';
        btnSave.innerHTML = 'Guardar';
        document.getElementById('costo').value = '0';
        document.getElementById('costo').setAttribute('readonly', true);
        $('#modalEvento').modal('show');
    });

    $('#carrera').on('change', function(e) {
       const values = $(this).val();
       if (values && values.includes('TODAS')) {
         $(this).val(['TODAS']).trigger('change.select2');
       } else if (values && values.length > 1 && values.includes('TODAS') === false) {
         $(this).find('option[value=\"TODAS\"]').prop('selected', false);
       }
     });

    // Mostrar/ocultar campos de nota/asistencia según el tipo de evento seleccionado
    $(document).on('change', '#tipoEvento', function() {
        const codigo = $(this).val();
        const tipo = tiposEventoConfig.find(t => t.CODIGO === codigo);
        if (tipo) {
            if (tipo.REQUIERENOTA == 1) {
                $('#notaMinimaContainer').show();
            } else {
                $('#notaMinimaContainer').hide();
                $('#notaAprobacion').val('');
            }
            if (tipo.REQUIEREASISTENCIA == 1) {
                $('#asistenciaMinimaContainer').show();
            } else {
                $('#asistenciaMinimaContainer').hide();
                $('#asistenciaMinima').val('');
            }
        } else {
            $('#notaMinimaContainer').hide();
            $('#asistenciaMinimaContainer').hide();
            $('#notaAprobacion').val('');
            $('#asistenciaMinima').val('');
        }
    });

    // Mostrar/ocultar el campo de costo según si es pagado
    $(document).on('change', '#esPagado', function() {
        if (this.checked) {
            $('#costoContainer').show();
        } else {
            $('#costoContainer').hide();
            $('#costo').val('0');
        }
    });
    // Al abrir el modal, ocultar por defecto los campos de nota/asistencia y costo
    $('#modalEvento').on('show.bs.modal', function () {
        $('#notaMinimaContainer').hide();
        $('#asistenciaMinimaContainer').hide();
        $('#costoContainer').hide();
        $('#notaAprobacion').val('');
        $('#asistenciaMinima').val('');
        $('#costo').val('0');
    });
});
