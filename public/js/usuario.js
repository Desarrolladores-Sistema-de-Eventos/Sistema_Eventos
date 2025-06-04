<<<<<<< HEAD
function cargarUsuarios() {
    fetch('../controllers/UsuarioController.php')
        .then(res => res.json())
        .then(data => {
            // Destruir instancia previa si existe
            if ($.fn.DataTable.isDataTable('#dataTables-users')) {
                $('#dataTables-users').DataTable().destroy();
            }

            // Limpiar cuerpo de la tabla
            const tbody = document.querySelector('#dataTables-users tbody');
            tbody.innerHTML = '';

            if (Array.isArray(data) && data.length > 0) {
                data.forEach(usuario => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${usuario.NOMBRES}</td>
                            <td>${usuario.APELLIDOS}</td>
                            <td>${usuario.FECHA_NACIMIENTO}</td>
                            <td>${usuario.TELEFONO}</td>
                            <td>${usuario.DIRECCION}</td>
                            <td>${usuario.CORREO}</td>
                            <td>${usuario.CODIGOROL}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editarUsuario(${usuario.SECUENCIAL})">
                                    <i class="fa fa-pencil"></i> Editar
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${usuario.SECUENCIAL})">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="8">No hay usuarios disponibles.</td></tr>';
            }

            // Inicializar DataTable
            const tabla = $('#dataTables-users').DataTable({
                language: {
                    decimal: "",
                    emptyTable: "No hay datos disponibles en la tabla",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    zeroRecords: "Búsqueda no encontrada",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                pageLength: 10,
                ordering: true,
                searching: true,
                responsive: true,
                search: {
                    smart: true, // Habilitar búsqueda inteligente (coincidencias parciales)
                    caseInsensitive: true // Sin distinción entre mayúsculas y minúsculas
                },
                columnDefs: [
                    {
                        targets: -1,
                        searchable: false,
                        orderable: false
                    }
                ]
            });

            // Personalizar el input de búsqueda
            const searchInput = $('#dataTables-users_filter input');
            searchInput
                .unbind()
                .bind('keyup', function (e) {
                    if (this.value.length === 0 || this.value.length >= 1) {
                        tabla.search(this.value).draw();
                    }
                })
                .attr('placeholder', 'Buscar por cualquier campo...')
                .css('width', '300px')
                .addClass('form-control');
        })
        .catch(error => {
            console.error('Error al cargar usuarios:', error);
            alert('Error al cargar los usuarios');
        });
}

// Crear usuario
window.nuevoUsuario = function() {
    const form = document.getElementById('userForm');
    form.reset();
    form.removeAttribute('data-edit');
    document.getElementById('btnGuardar').style.display = 'inline-block';
    document.getElementById('btnActualizar').style.display = 'none';
    $('#myModal').modal('show');
};

// Asocia el botón NUEVO con la función
document.querySelector('.btn.btn-custom[data-target="#myModal"]').onclick = window.nuevoUsuario;
document.getElementById('userForm').addEventListener('submit', function (e) {
    e.preventDefault();

    document.getElementById('userFormError').style.display = 'none';
    document.getElementById('userFormError').innerText = '';

    let id = this.getAttribute('data-edit');
    let form = new FormData(this);
    let data = {};
    form.forEach((v, k) => data[k] = v);

    if (id) {
        // Modo edición
        data.id = id;
        fetch('../controllers/UsuarioController.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(data)
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.success) {
                $('#myModal').modal('hide');
                cargarUsuarios();
                this.removeAttribute('data-edit');
                document.getElementById('btnGuardar').style.display = 'inline-block';
                document.getElementById('btnActualizar').style.display = 'none';
            } else {
                // Mostrar mensaje de error
                document.getElementById('userFormError').innerText = resp.message || 'Error al editar usuario';
                document.getElementById('userFormError').style.display = 'block';
            }
        });
    } else {
  
        // Modo creación
        fetch('../controllers/UsuarioController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.success) {
                $('#myModal').modal('hide');
                cargarUsuarios();
            } else {
                // Mostrar mensaje si el correo ya existe
                document.getElementById('userFormError').innerText = resp.message || 'El usuario ya existe, vuelva a ingresar el correo electrónico.';
                document.getElementById('userFormError').style.display = 'block';
            }
        });
    }
});
// Función para precargar datos y mostrar el modal
window.editarUsuario = function (id) {
    fetch(`../controllers/UsuarioController.php?id=${id}`)
        .then(res => res.json())
        .then(usuario => {
            if (!usuario) return;

            // Precargar los datos en el formulario
            document.querySelector('[name="nombre"]').value = usuario.NOMBRES || '';
            document.querySelector('[name="apellido"]').value = usuario.APELLIDOS || '';
            document.querySelector('[name="fecha_nacimiento"]').value = usuario.FECHA_NACIMIENTO || '';
            document.querySelector('[name="telefono"]').value = usuario.TELEFONO || '';
            document.querySelector('[name="direccion"]').value = usuario.DIRECCION || '';
            document.querySelector('[name="correo"]').value = usuario.CORREO || '';
            document.querySelector('[name="contrasena"]').value = ''; // por seguridad
            document.querySelector('[name="rol"]').value = usuario.CODIGOROL || '';

            // Cambiar botones
            document.getElementById('btnGuardar').style.display = 'none';
            document.getElementById('btnActualizar').style.display = 'inline-block';

            // Guardar el id en el formulario
            document.getElementById('userForm').setAttribute('data-edit', id);

            // Mostrar el modal
            $('#myModal').modal('show');
        })
        .catch(err => console.error('Error al cargar usuario:', err));
};

// Eliminar usuario
window.eliminarUsuario = function(id) {
    if (confirm('¿Seguro de eliminar este usuario?')) {
        fetch('../controllers/UsuarioController.php', {
            method: 'DELETE',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}`
        })
        .then(response => response.json()) // <-- ¡Parsear el JSON!
        .then(resp => {
            if (resp.success) {
                let mensaje = (resp.tipo === 'logico') 
                    ? 'Usuario desactivado correctamente (eliminación lógica).' 
                    : 'Usuario eliminado correctamente (eliminación física).';
                alert(mensaje);
                cargarUsuarios();
            } else {
                alert('Error al eliminar usuario: ' + (resp.mensaje || ''));
            }
        })
        .catch(error => {
            console.error('Error en la solicitud DELETE:', error);
            alert('Hubo un error al intentar eliminar el usuario.');
        });
    }
};
// Inicializar
document.addEventListener('DOMContentLoaded', cargarUsuarios);
=======
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
>>>>>>> feature/Modulo-Eventos-Sesiones
