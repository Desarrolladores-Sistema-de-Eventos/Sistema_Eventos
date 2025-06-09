let tablaEventos;

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

function cargarSelectOrganizadores() {
    axios.get('../controllers/EventosAdminController.php?option=organizadores')
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
            document.getElementById('idEvento').value = e.SECUENCIAL;
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
            document.getElementById('esSoloInternos').value = e.ES_SOLO_INTERNOS;
            document.getElementById('esPagado').checked = e.ES_PAGADO == 1;
            document.getElementById('responsable').value = e.RESPONSABLE || '';
            document.getElementById('organizador').value = e.ORGANIZADOR || '';

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
                        Swal.fire('Eliminado', 'Evento eliminado correctamente.', 'success');
                        tablaEventos.ajax.reload();
                    } else {
                        Swal.fire('Error', res.data.mensaje, 'error');
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

            if (titulo.length < 3) return Swal.fire('Error', 'El título debe tener al menos 3 caracteres.', 'error');
            if (descripcion.length < 10) return Swal.fire('Error', 'La descripción debe tener al menos 10 caracteres.', 'error');
            if (isNaN(horas) || horas <= 0) return Swal.fire('Error', 'Las horas deben ser mayores a 0.', 'error');
            if (isNaN(capacidad) || capacidad <= 0) return Swal.fire('Error', 'La capacidad debe ser positiva.', 'error');
            if (!isNaN(notaAprobacion) && (notaAprobacion < 0 || notaAprobacion > 100)) return Swal.fire('Error', 'Nota fuera de rango.', 'error');
            if (fechaInicio < hoy) return Swal.fire('Error', 'Fecha de inicio inválida.', 'error');
            if (fechaFin && fechaFin < fechaInicio) return Swal.fire('Error', 'Fecha fin menor a inicio.', 'error');
            if (esPagado && (isNaN(costo) || costo <= 0)) return Swal.fire('Error', 'Costo requerido para eventos pagados.', 'error');

            const selects = ['carrera', 'tipoEvento', 'modalidad', 'categoria', 'responsable', 'organizador'];
            for (const id of selects) {
                const val = document.getElementById(id).value;
                if (!val) return Swal.fire('Error', `Debe seleccionar ${id}`, 'error');
            }

            const formData = new FormData(frm);
            formData.set('esPagado', esPagado ? 1 : 0);
            formData.set('costo', esPagado ? costoInput.value : '0');
            formData.set('estado', 'DISPONIBLE'); // se fuerza el estado
            let url = '../controllers/EventosAdminController.php?option=crear';
            if (idEvento.value !== '') {
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
                        btnSave.innerHTML = 'Guardar';
                    } else {
                        Swal.fire('Error', res.data.mensaje, 'error');
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
});
