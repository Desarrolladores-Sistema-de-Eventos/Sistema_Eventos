let tablaUsuarios;
function inicializarTablaUsuarios() {
    if (tablaUsuarios) tablaUsuarios.destroy();
    tablaUsuarios = $('#tabla-usuarios').DataTable({
        ajax: {
            url: '../controllers/UsuarioController.php?option=listar',
            dataSrc: function (json) {
                // Ocultar administradores
                let mostrarInactivos = document.getElementById('mostrarInactivos')?.checked;
                let filtrados = json.filter(u => u.CODIGOROL !== 'ADM');
                if (mostrarInactivos) {
                    return filtrados.filter(u => u.CODIGOESTADO === 'INACTIVO');
                }
                return filtrados.filter(u => u.CODIGOESTADO === 'ACTIVO');
            }
        },
        columns: [
            // Si quieres mostrar la foto en la tabla, descomenta esto:
            // {
            //     data: 'FOTO_PERFIL',
            //     render: function(data) {
            //         return data ? `<img src=\"../public/img/${data}\" style=\"width:40px;height:40px;border-radius:50%;object-fit:cover;\">` : '';
            //     }
            // },
            { data: 'NOMBRES' },
            { data: 'APELLIDOS' },
            { data: 'CEDULA' },
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
    const chkInactivos = document.getElementById('mostrarInactivos');
    if (chkInactivos) {
        chkInactivos.addEventListener('change', function () {
            inicializarTablaUsuarios();
        });
    }

    const frm = document.getElementById('formUsuario');
    const btnSave = document.getElementById('btn-save-usuario');
    const idUsuario = document.getElementById('idUsuario');
    const codigorol = document.getElementById('codigorol');
    const codigorol_hidden = document.getElementById('codigorol_hidden');
    const fotoPerfilActual = document.getElementById('foto_perfil_actual');

    frm.onsubmit = function (e) {
        e.preventDefault();
        const formData = new FormData(frm);
        // Si el select está deshabilitado (edición), usa el valor del hidden
        if (codigorol.disabled && codigorol_hidden) {
            formData.set('codigorol', codigorol_hidden.value);
        }
        // Si hay foto actual y no se sube una nueva, envía el nombre de la foto actual
        if (fotoPerfilActual && fotoPerfilActual.value && !frm.foto_perfil.value) {
            formData.append('foto_perfil_actual', fotoPerfilActual.value);
        }
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
                    frm.reset();
                    btnSave.innerHTML = 'Guardar';
                    codigorol.disabled = false;
                    codigorol_hidden.value = '';
                    if (fotoPerfilActual) fotoPerfilActual.value = '';
                    tablaUsuarios.ajax.reload(null, false);
                } else {
                    Swal.fire('Error', res.data.mensaje, 'error');
                }
            });
    };

    $('#modalUsuario').on('hidden.bs.modal', function () {
        frm.reset();
        btnSave.innerHTML = 'Guardar';
        codigorol.disabled = false;
        codigorol_hidden.value = '';
        if (fotoPerfilActual) fotoPerfilActual.value = '';
    });

    document.getElementById('btn-nuevo-usuario').addEventListener('click', function () {
        frm.reset();
        idUsuario.value = '';
        btnSave.innerHTML = 'Guardar';
        codigorol.disabled = false;
        codigorol_hidden.value = '';
        if (fotoPerfilActual) fotoPerfilActual.value = '';
        $('#modalUsuario').modal('show');
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
            document.getElementById('codigorol').disabled = true;
            document.getElementById('codigorol_hidden').value = u.CODIGOROL;
            document.getElementById('estado').value = u.CODIGOESTADO;
            document.getElementById('es_interno').checked = u.ES_INTERNO == 1;
            document.getElementById('contrasena').value = '';
            // Setea la foto actual en un input hidden
            if (document.getElementById('foto_perfil_actual')) {
                document.getElementById('foto_perfil_actual').value = u.FOTO_PERFIL || '';
            }
            $('#modalUsuario').modal('show');
            document.getElementById('btn-save-usuario').innerHTML = 'Actualizar';
        })
        .catch(err => {
            console.log(err.response ? err.response.data : err);
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
                        tablaUsuarios.ajax.reload(null, false);
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
                        tablaUsuarios.ajax.reload(null, false);
                    } else {
                        Swal.fire('Error', res.data.mensaje, 'error');
                    }
                });
        }
    });
}

// ==== REGISTRO USUARIO ====

document.addEventListener('DOMContentLoaded', function () {
    const frmRegistro = document.getElementById('formRegistroUsuario');
    const inputContrasena = document.getElementById('contrasena');
    const inputConfirmar = document.getElementById('confirmar_contrasena');
    const bar = document.getElementById('password-strength-bar');
    const text = document.getElementById('password-strength-text');

    if (!frmRegistro) return;

    inputContrasena.addEventListener('input', function () {
        const input = this.value;
        let strength = 0;

        if (input.length >= 6) strength += 20;
        if (/[A-Z]/.test(input)) strength += 20;
        if (/[a-z]/.test(input)) strength += 20;
        if (/[0-9]/.test(input)) strength += 20;
        if (/\W|_/.test(input)) strength += 20;

        bar.style.width = strength + '%';
        bar.setAttribute('aria-valuenow', strength);

        if (strength < 40) {
            bar.className = 'progress-bar bg-danger';
            text.textContent = 'Débil';
            text.className = 'text-danger';
        } else if (strength < 80) {
            bar.className = 'progress-bar bg-warning';
            text.textContent = 'Aceptable';
            text.className = 'text-warning';
        } else {
            bar.className = 'progress-bar bg-success';
            text.textContent = 'Fuerte';
            text.className = 'text-success';
        }
    });

    frmRegistro.onsubmit = function (e) {
        e.preventDefault();

        const formData = new FormData(frmRegistro);
        const correo = formData.get('correo')?.trim().toLowerCase();
        const telefono = formData.get('telefono')?.trim();
        const contrasena = formData.get('contrasena');
        const confirmar = formData.get('confirmar_contrasena');

        if (contrasena !== confirmar) {
            Swal.fire('Error', 'Las contraseñas no coinciden', 'error');
            return;
        }

        if (!/^09[89]\d{7}$/.test(telefono)) {
            Swal.fire('Teléfono inválido', 'Debe ser un número celular ecuatoriano válido.', 'warning');
            return;
        }

        let codigorol = 'INV';
        let es_interno = 0;

        if (/^[a-z]{2,}[0-9]{4}@uta\.edu\.ec$/.test(correo)) {
            codigorol = 'EST';
            es_interno = 1;
        } else if (/^[a-z]+\.[a-z]+@uta\.edu\.ec$/.test(correo) || /@uta\.edu\.ec$/.test(correo)) {
            codigorol = 'DOC';
            es_interno = 1;
        }

        formData.set('codigorol', codigorol);
        formData.set('es_interno', es_interno);

        axios.post('../controllers/UsuarioController.php?option=registrarUsuario', formData)
            .then(res => {
                if (res.data.success) {
                    Swal.fire({
                        title: 'Registrado',
                        text: 'Usuario registrado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Ir al login'
                    }).then(() => {
                        frmRegistro.reset();
                        //bar.style.width = '0%';
                        //bar.className = 'progress-bar';
                        //text.textContent = '';
                        window.location.href = 'login.php';
                    });
                } else {
                    Swal.fire('Error', res.data.mensaje || 'No se pudo registrar.', 'error');
                }
            })
            .catch(err => {
                console.error('Error en el registro:', err.response ? err.response.data : err);
                Swal.fire('Error', 'Ocurrió un error inesperado en el registro.', 'error');
            });
    };
});
