let tablaUsuarios;
let rolSeleccionado = 'EST'; // Por defecto Estudiante
function inicializarTablaUsuarios() {
    if (tablaUsuarios) {
        tablaUsuarios.clear().destroy();
        $('#tabla-usuarios tbody').empty();
    }
    tablaUsuarios = $('#tabla-usuarios').DataTable({
        ajax: {
            url: '../controllers/UsuarioController.php?option=listar',
            dataSrc: function (json) {
                // Ocultar administradores y filtrar por rol seleccionado
                let filtrados = json.filter(u => u.CODIGOROL !== 'ADM');
                // Si el tab es "OTRO" mostrar todos los que no sean EST, DOC, INV, ADM
                if (rolSeleccionado === 'OTRO') {
                    filtrados = filtrados.filter(u => !['EST','DOC','INV','ADM'].includes((u.CODIGOROL||'').toUpperCase()));
                } else {
                    filtrados = filtrados.filter(u => (u.CODIGOROL||'').toUpperCase() === rolSeleccionado);
                }
                return filtrados;
            }
        },
        columns: [
            {
                data: 'FOTO_PERFIL_URL',
                orderable: false,
                render: function(data, type, row) {
                    // Si no hay foto, mostrar user.jpg
                    let url = data && data.trim() !== '' ? data : '../public/img/perfiles/user.jpg';
                    return `<img src="${url}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;" alt="Foto de ${row.NOMBRES}">`;
                },
                className: 'text-center align-middle'
            },
            { data: 'NOMBRES' },
            { data: 'APELLIDOS' },
            { data: 'CEDULA' },
            { data: 'TELEFONO' },
            { data: 'DIRECCION' },
            { data: 'CORREO' },
            { data: 'CODIGOROL' },
            {
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    return `
                    <button onclick="editarUsuario(${row.SECUENCIAL})" class="btn btn-sm" style="background-color:#e0e0e0;color:#222;" title="Editar"><i class="fa fa-pencil"></i></button>
                    <button onclick="eliminarUsuario(${row.SECUENCIAL})" class="btn btn-sm" style="background-color:#e0e0e0;color:#222;" title="Eliminar"><i class="fa fa-trash"></i></button>
                    <button onclick="inactivarUsuario(${row.SECUENCIAL})" class="btn btn-sm" style="background-color:#e0e0e0;color:#222;" title="Inactivar"><i class="fa fa-ban"></i></button>
                    `;
                },
                className: 'text-center align-middle'
            }
        ],
        language: {
            url: '../public/js/es-ES.json'
        }
    });
}
document.addEventListener('DOMContentLoaded', function () {
    // Mostrar/ocultar campo matrícula según el rol seleccionado
    const selectRol = document.getElementById('codigorol');
    const matriculaDiv = document.getElementById('matricula_pdf')?.closest('.col-md-6') || document.getElementById('matricula_pdf')?.closest('div');
    function toggleMatriculaField() {
        if (!selectRol || !matriculaDiv) return;
        const rol = selectRol.value;
        if (rol === 'INV' || rol === 'DOC') {
            matriculaDiv.style.display = 'none';
        } else {
            matriculaDiv.style.display = '';
        }
    }
    if (selectRol && matriculaDiv) {
        selectRol.addEventListener('change', toggleMatriculaField);
        // Ejecutar al cargar por si acaso
        toggleMatriculaField();
    }

    // Lógica para tabs de roles
    $(document).on('click', '#navTabsRoles .nav-link', function (e) {
        e.preventDefault();
        $('#navTabsRoles .nav-link').removeClass('active');
        $(this).addClass('active');
        rolSeleccionado = $(this).data('rol');
        inicializarTablaUsuarios();
    });

    inicializarTablaUsuarios();

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
        const preview = document.getElementById('foto_perfil_preview');
        if (preview) preview.innerHTML = '';
    });

    document.getElementById('btn-nuevo-usuario').addEventListener('click', function () {
        frm.reset();
        idUsuario.value = '';
        btnSave.innerHTML = 'Guardar';
        codigorol.disabled = false;
        codigorol_hidden.value = '';
        if (fotoPerfilActual) fotoPerfilActual.value = '';
        // Limpiar los labels de PDF y la miniatura de foto
        const preview = document.getElementById('foto_perfil_preview');
        if (preview) preview.innerHTML = '';
        const cedulaPdfLabel = document.getElementById('cedula_pdf_label');
        if (cedulaPdfLabel) cedulaPdfLabel.innerHTML = '<span class="text-muted" style="font-size:13px;">Sin PDF</span>';
        const matriculaPdfLabel = document.getElementById('matricula_pdf_label');
        if (matriculaPdfLabel) matriculaPdfLabel.innerHTML = '<span class="text-muted" style="font-size:13px;">Sin PDF</span>';
        // Limpiar los input hidden de archivos actuales
        if (document.getElementById('cedula_pdf_actual')) document.getElementById('cedula_pdf_actual').value = '';
        if (document.getElementById('matricula_pdf_actual')) document.getElementById('matricula_pdf_actual').value = '';
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
            // NUEVO: Setear cédula y fecha de nacimiento si existen
            if(document.getElementById('cedula')) document.getElementById('cedula').value = u.CEDULA || '';
            if(document.getElementById('fecha_nacimiento')) document.getElementById('fecha_nacimiento').value = u.FECHA_NACIMIENTO || '';
            // NUEVO: Setear nombre del PDF de cédula si existe y mostrarlo
            if(document.getElementById('cedula_pdf_actual')) document.getElementById('cedula_pdf_actual').value = u.URL_CEDULA || '';
            // Mostrar nombre del PDF de cédula si existe
            const cedulaPdfLabel = document.getElementById('cedula_pdf_label');
            if (cedulaPdfLabel) {
                if (u.URL_CEDULA) {
                    const nombrePdf = u.URL_CEDULA.split('/').pop();
                    cedulaPdfLabel.innerHTML = `<a href="../documents/cedulas/${nombrePdf}" target="_blank"><i class='fa fa-file-pdf-o'></i> ${nombrePdf}</a>`;
                } else {
                    cedulaPdfLabel.innerHTML = '<span class="text-muted" style="font-size:13px;">Sin PDF</span>';
                }
            }
            // NUEVO: Setear nombre del PDF de matrícula si existe y mostrarlo
            if(document.getElementById('matricula_pdf_actual')) document.getElementById('matricula_pdf_actual').value = u.URL_MATRICULA || '';
            // Mostrar nombre del PDF de matrícula si existe
            const matriculaPdfLabel = document.getElementById('matricula_pdf_label');
            if (matriculaPdfLabel) {
                if (u.URL_MATRICULA) {
                    const nombreMatricula = u.URL_MATRICULA.split('/').pop();
                    matriculaPdfLabel.innerHTML = `<a href="../documents/matriculas/${nombreMatricula}" target="_blank"><i class='fa fa-file-pdf-o'></i> ${nombreMatricula}</a>`;
                } else {
                    matriculaPdfLabel.innerHTML = '<span class="text-muted" style="font-size:13px;">Sin PDF</span>';
                }
            }
            // Setea la foto actual en un input hidden y muestra miniatura
            if (document.getElementById('foto_perfil_actual')) {
                document.getElementById('foto_perfil_actual').value = u.FOTO_PERFIL || '';
            }
            // Mostrar miniatura de la foto actual
            const preview = document.getElementById('foto_perfil_preview');
            if (preview) {
                if (u.FOTO_PERFIL) {
                    preview.innerHTML = `<img src="../public/img/perfiles/${u.FOTO_PERFIL}" style="width:60px;height:60px;border-radius:50%;object-fit:cover;box-shadow:0 0 3px #aaa;"> <span class='text-muted' style='font-size:13px;'>${u.FOTO_PERFIL}</span>`;
                } else {
                    preview.innerHTML = `<img src="../public/img/perfiles/user.jpg" style="width:60px;height:60px;border-radius:50%;object-fit:cover;opacity:0.7;"> <span class='text-muted' style='font-size:13px;'>Sin foto</span>`;
                }
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
