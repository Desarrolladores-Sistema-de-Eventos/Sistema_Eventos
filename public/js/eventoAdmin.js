// Variables globales
let tablaEventos;

function inicializarTablaEventos() {
    const mostrarCancelados = document.getElementById('mostrarCancelados')?.checked;

    if (tablaEventos) tablaEventos.destroy();
    tablaEventos = $('#tabla-eventos').DataTable({
        ajax: {
            url: '../controllers/EventosAdminController.php?option=listar',
            dataSrc: function (json) {
                // Si el checkbox está marcado, muestra solo cancelados
                if (mostrarCancelados) {
                    return json.filter(e => e.ESTADO === 'CANCELADO');
                }
                // Si no, muestra solo disponibles
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

function cargarSelectOrganizadores() {
    axios.get('../controllers/EventosAdminController.php?option=organizadores')
        .then(res => {
            const data = res.data;
            llenarSelect('responsable', data);
            llenarSelect('organizador', data);
        });
}

// NUEVO: Cargar catálogos para los selects del formulario de evento
function cargarSelectsEvento() {
    axios.get('../controllers/EventosAdminController.php?option=catalogos')
        .then(res => {
            llenarSelectGenerico('carrera', res.data.carreras, 'SECUENCIAL', 'NOMBRE_CARRERA');
            llenarSelectGenerico('tipoEvento', res.data.tipos, 'CODIGO', 'NOMBRE');
            llenarSelectGenerico('modalidad', res.data.modalidades, 'CODIGO', 'NOMBRE');
            llenarSelectGenerico('categoria', res.data.categorias, 'SECUENCIAL', 'NOMBRE');
            llenarSelectGenerico('estado', res.data.estados, 'value', 'text');
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

// Para catálogos con campos personalizados
function llenarSelectGenerico(id, opciones, valueField, textField) {
    const select = document.getElementById(id);
    if (!select) return;
    select.innerHTML = '<option value="">Seleccione</option>';
    opciones.forEach(op => {
        const opt = document.createElement('option');
        opt.value = op[valueField];
        opt.textContent = op[textField];
        select.appendChild(opt);
    });
}

function editarEvento(id) {
    axios.get(`../controllers/EventosAdminController.php?option=get&id=${id}`)
        .then(res => {
            const e = res.data;
            if (document.getElementById('idEvento')) document.getElementById('idEvento').value = e.SECUENCIAL;
            if (document.getElementById('titulo')) document.getElementById('titulo').value = e.TITULO;
            if (document.getElementById('descripcion')) document.getElementById('descripcion').value = e.DESCRIPCION;
            if (document.getElementById('horas')) document.getElementById('horas').value = e.HORAS;
            if (document.getElementById('fechaInicio')) document.getElementById('fechaInicio').value = e.FECHAINICIO;
            if (document.getElementById('fechaFin')) document.getElementById('fechaFin').value = e.FECHAFIN;
            if (document.getElementById('modalidad')) document.getElementById('modalidad').value = e.CODIGOMODALIDAD;
            if (document.getElementById('tipoEvento')) document.getElementById('tipoEvento').value = e.CODIGOTIPOEVENTO;
            if (document.getElementById('carrera')) document.getElementById('carrera').value = e.SECUENCIALCARRERA;
            if (document.getElementById('categoria')) document.getElementById('categoria').value = e.SECUENCIALCATEGORIA;
            if (document.getElementById('notaAprobacion')) document.getElementById('notaAprobacion').value = e.NOTAAPROBACION;
            if (document.getElementById('costo')) document.getElementById('costo').value = e.COSTO;
            // esSoloInternos: select o checkbox
            if (document.getElementById('publicoDestino')) {
                document.getElementById('publicoDestino').value = e.ES_SOLO_INTERNOS == 1 ? 'internos' : 'externos';
            }
            // esPagado: checkbox
            if (document.getElementById('esPagado')) {
                document.getElementById('esPagado').checked = e.ES_PAGADO == 1;
            }
            if (document.getElementById('estado')) document.getElementById('estado').value = e.ESTADO;
            if (document.getElementById('responsable')) document.getElementById('responsable').value = e.RESPONSABLE || '';
            if (document.getElementById('organizador')) document.getElementById('organizador').value = e.ORGANIZADOR || '';
            $('#modalEvento').modal('show');
            // Cambia el texto del botón guardar
            if (document.getElementById('btn-save')) document.getElementById('btn-save').innerHTML = 'Actualizar';
        });
}

// FIX: Usar FormData para enviar el id correctamente
function eliminarEvento(id) {
    Swal.fire({
        title: '¿Eliminar evento? ¡Advertencia!',
        text: "Viola la integridad referencial, Si lo eliminas, se eliminarán todos los registros relacionados.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
    }).then(result => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('id', id);
            axios.post('../controllers/EventosAdminController.php?option=eliminar', formData)
                .then(res => {
                    if (res.data.success) {
                        Swal.fire('Eliminado', 'Evento y registros relacionados eliminados correctamente.', 'success');
                        tablaEventos.ajax.reload();
                    } else {
                        // Si el mensaje contiene integridad referencial, advertir al usuario
                        if (res.data.mensaje && res.data.mensaje.toLowerCase().includes('relacion')) {
                            Swal.fire({
                                title: '¡Advertencia!',
                                text: 'El evento tiene registros relacionados (inscripciones, imágenes, etc). Si continúas, se eliminarán todos los registros relacionados. ¿Deseas continuar?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Eliminar de todas formas',
                                cancelButtonText: 'Cancelar'
                            }).then(confirmRes => {
                                if (confirmRes.isConfirmed) {
                                    // Intentar de nuevo la eliminación (el modelo ya elimina en cascada)
                                    axios.post('../controllers/EventosAdminController.php?option=eliminar', formData)
                                        .then(res2 => {
                                            if (res2.data.success) {
                                                Swal.fire('Eliminado', 'Evento y registros relacionados eliminados correctamente.', 'success');
                                                tablaEventos.ajax.reload();
                                            } else {
                                                Swal.fire('Error', res2.data.mensaje, 'error');
                                            }
                                        });
                                }
                            });
                        } else {
                            Swal.fire('Error', res.data.mensaje, 'error');
                        }
                    }
                });
        }
    });
}

function cancelarEvento(id) {
    Swal.fire({
        title: '¿Cancelar evento?',
        text: "El evento será marcado como CANCELADO.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f39c12',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, cancelar'
    }).then(result => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('id', id);
            axios.post('../controllers/EventosAdminController.php?option=cancelar', formData)
                .then(res => {
                    if (res.data.success) {
                        Swal.fire('Cancelado', 'Evento cancelado.', 'success');
                        tablaEventos.ajax.reload();
                    } else {
                        Swal.fire('Error', res.data.mensaje, 'error');
                    }
                });
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    inicializarTablaEventos();
    cargarSelectOrganizadores();
    cargarSelectsEvento(); // NUEVO: cargar catálogos

    // Manejar el checkbox para mostrar/ocultar eventos cancelados
    const chkCancelados = document.getElementById('mostrarCancelados');
    if (chkCancelados) {
        chkCancelados.addEventListener('change', function () {
            inicializarTablaEventos();
        });
    }

    const frm = document.getElementById('formEvento');
    const btnSave = document.getElementById('btn-save');
    const idEvento = document.getElementById('idEvento');

    if (frm) {
        frm.onsubmit = function (e) {
            e.preventDefault();
            const formData = new FormData(frm);
            // esPagado: checkbox
            if (document.getElementById('esPagado')) {
                formData.set('esPagado', document.getElementById('esPagado').checked ? 1 : 0);
            }
            // publicoDestino: select
            if (document.getElementById('publicoDestino')) {
                formData.set('esSoloInternos', document.getElementById('publicoDestino').value === 'internos' ? 1 : 0);
            }
            let url = '../controllers/EventosAdminController.php?option=crear';
            if (idEvento && idEvento.value !== '') {
                url = '../controllers/EventosAdminController.php?option=editar';
                formData.append('id', idEvento.value);
            }
            axios.post(url, formData)
                .then(res => {
                    if (res.data.success) {
                        Swal.fire('Éxito', 'Evento guardado.', 'success');
                        $('#modalEvento').modal('hide');
                        tablaEventos.ajax.reload();
                        frm.reset();
                        if (btnSave) btnSave.innerHTML = 'Guardar';
                    } else {
                        Swal.fire('Error', res.data.mensaje, 'error');
                    }
                });
        };
    }

    $('#modalEvento').on('hidden.bs.modal', function () {
        if (frm) frm.reset();
        if (btnSave) btnSave.innerHTML = 'Guardar';
    });

    // El botón para abrir el modal tiene id="btn-nuevo"
    const btnNuevo = document.getElementById('btn-nuevo');
    if (btnNuevo) {
        btnNuevo.addEventListener('click', function () {
            if (frm) frm.reset();
            if (idEvento) idEvento.value = '';
            if (btnSave) btnSave.innerHTML = 'Guardar';
            $('#modalEvento').modal('show');
        });
    }
});