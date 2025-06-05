
let tablaUsuarios;

function inicializarTablaUsuarios() {
    const mostrarInactivos = document.getElementById('mostrarInactivos')?.checked;

    if (tablaUsuarios) tablaUsuarios.destroy();
    tablaUsuarios = $('#tabla-usuarios').DataTable({
        ajax: {
            url: '../controllers/UsuarioController.php?option=listar',
            dataSrc: function (json) {
                // Si el checkbox está marcado, muestra solo inactivos
                if (mostrarInactivos) {
                    return json.filter(u => u.CODIGOESTADO === 'INACTIVO');
                }
                // Si no, muestra solo activos
                return json.filter(u => u.CODIGOESTADO === 'ACTIVO');
            }
        },
        columns: [
            { data: 'NOMBRES' },
            { data: 'APELLIDOS' },
            { data: 'TELEFONO' },
            { data: 'DIRECCION' },
            { data: 'CORREO' },
            { data: 'CODIGOROL' },
            { data: 'CODIGOESTADO' },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                    <button onclick="editarUsuario(${row.SECUENCIAL})" class="btn btn-primary btn-sm" title="Editar"><i class="fa fa-pencil"></i></button>
                    <button onclick="eliminarUsuario(${row.SECUENCIAL})" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash"></i></button>
                    <button onclick="inactivarUsuario(${row.SECUENCIAL})" class="btn btn-warning btn-sm" title="Inactivar"><i class="fa fa-ban"></i></button> 
                    `;
                }
            }
        ],
        language: {
            url: '../public/js/es-ES.json'
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    inicializarTablaUsuarios();

    // Manejar el checkbox para mostrar usuarios inactivos
    const chkInactivos = document.getElementById('mostrarInactivos');
    if (chkInactivos) {
        chkInactivos.addEventListener('change', function () {
            inicializarTablaUsuarios();
        });
    }

    const frm = document.getElementById('formUsuario');
    const btnSave = document.getElementById('btn-save-usuario');
    const idUsuario = document.getElementById('idUsuario');

    frm.onsubmit = function (e) {
        e.preventDefault();
        const formData = new FormData(frm);
        let url = '../controllers/UsuarioController.php?option=insertar';
        if (idUsuario.value !== '') {
            url = '../controllers/UsuarioController.php?option=editar';
            formData.append('id', idUsuario.value);
        }
        axios.post(url, formData)
            .then(res => {
                if (res.data.success) {
                    Swal.fire('Éxito', 'Usuario guardado.', 'success');
                    $('#modalUsuario').modal('hide');
                    tablaUsuarios.ajax.reload();
                    frm.reset();
                    btnSave.innerHTML = 'Guardar';
                } else {
                    Swal.fire('Error', res.data.mensaje, 'error');
                }
            });
    };

    $('#modalUsuario').on('hidden.bs.modal', function () {
        frm.reset();
        btnSave.innerHTML = 'Guardar';
    });

    document.getElementById('btn-nuevo-usuario').addEventListener('click', function () {
        frm.reset();
        idUsuario.value = '';
        btnSave.innerHTML = 'Guardar';
        $('#modalUsuario').modal('show');
    });
});

// ==== REGISTRO PÚBLICO DE USUARIO ====
document.getElementById('formRegistroUsuario')?.addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    axios.post('../controllers/UsuarioController.php?option=registrarUsuario', formData)
        .then(res => {
            if (res.data.success) {
                Swal.fire('Registrado', 'Usuario registrado correctamente.', 'success');
                this.reset();
            } else {
                Swal.fire('Error', res.data.mensaje, 'error');
            }
        });
});

function editarUsuario(id) {
    axios.get(`../controllers/UsuarioController.php?option=get&id=${id}`)
        .then(res => {
            const u = res.data;
            document.getElementById('idUsuario').value = u.SECUENCIAL;
            document.getElementById('nombres').value = u.NOMBRES;
            document.getElementById('apellidos').value = u.APELLIDOS;
            document.getElementById('telefono').value = u.TELEFONO;
            document.getElementById('direccion').value = u.DIRECCION;
            document.getElementById('correo').value = u.CORREO;
            document.getElementById('codigorol').value = u.CODIGOROL;
            document.getElementById('estado').value = u.CODIGOESTADO;
            document.getElementById('es_interno').checked = u.ES_INTERNO == 1;
            document.getElementById('contrasena').value = ''; 
            $('#modalUsuario').modal('show');
            document.getElementById('btn-save-usuario').innerHTML = 'Actualizar';
        })
        .catch(err => {
            Swal.fire('Error', 'No se pudo cargar el usuario.', 'error');
        });
}

function eliminarUsuario(id) {
    Swal.fire({
        title: '¿Eliminar usuario?',
        text: "Viola la Integridad referencial, si elimina se borrarán todos los registros relacionados.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
    }).then(result => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('id', id);
            axios.post('../controllers/UsuarioController.php?option=eliminar', formData)
                .then(res => {
                    if (res.data.success) {
                        Swal.fire('Eliminado', 'Usuario eliminado.', 'success');
                        tablaUsuarios.ajax.reload();
                    } else {
                        Swal.fire('Error', res.data.mensaje, 'error');
                    }
                });
        }
    });
}

function inactivarUsuario(id) {
    Swal.fire({
        title: '¿Inactivar usuario?',
        text: "El usuario no podrá acceder al sistema.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f39c12',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, inactivar'
    }).then(result => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('id', id);
            axios.post('../controllers/UsuarioController.php?option=inactivar', formData)
                .then(res => {
                    if (res.data.success) {
                        Swal.fire('Inactivado', 'Usuario inactivado.', 'success');
                        tablaUsuarios.ajax.reload();
                    } else {
                        Swal.fire('Error', res.data.mensaje, 'error');
                    }
                });
        }
    });
}
// ==== FORMULARIO ADMIN (insertar/editar) ====
document.addEventListener('DOMContentLoaded', function () {
    inicializarTablaUsuarios();

    const frm = document.getElementById('formUsuario');
    const btnSave = document.getElementById('btn-save-usuario');
    const idUsuario = document.getElementById('idUsuario');

    frm.onsubmit = function (e) {
        e.preventDefault();
        const formData = new FormData(frm);
        let url = '../controllers/UsuarioController.php?option=insertar';
        if (idUsuario.value !== '') {
            url = '../controllers/UsuarioController.php?option=editar';
            formData.append('id', idUsuario.value);
        }
        axios.post(url, formData)
            .then(res => {
                if (res.data.success) {
                    Swal.fire('Éxito', 'Usuario guardado.', 'success');
                    $('#modalUsuario').modal('hide');
                    tablaUsuarios.ajax.reload();
                    frm.reset();
                    btnSave.innerHTML = 'Guardar';
                } else {
                    Swal.fire('Error', res.data.mensaje, 'error');
                }
            });
    };

    $('#modalUsuario').on('hidden.bs.modal', function () {
        frm.reset();
        btnSave.innerHTML = 'Guardar';
    });

    document.getElementById('btn-nuevo-usuario').addEventListener('click', function () {
        frm.reset();
        idUsuario.value = '';
        btnSave.innerHTML = 'Guardar';
        $('#modalUsuario').modal('show');
    });
});
