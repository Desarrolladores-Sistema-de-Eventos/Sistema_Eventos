function cargarUsuarios() {
    fetch('../controllers/UsuarioController.php')
        .then(res => res.json())
        .then(data => {
            let tbody = document.getElementById('tablaUsuarios');
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
                                <button class="btn btn-warning btn-sm" onclick="editarUsuario(${usuario.SECUENCIAL})"><i class="fa fa-pencil"></i> Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${usuario.SECUENCIAL})"><i class="fa fa-trash"></i> Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="8">No hay usuarios disponibles.</td></tr>';
            }
        });
}

// Limpiar formulario y estado de edición
function limpiarFormulario() {
    document.getElementById('userForm').reset();
    document.getElementById('userForm').removeAttribute('data-edit');
    document.getElementById('btnGuardar').style.display = 'inline-block';
    document.getElementById('btnActualizar').style.display = 'none';
}

// Abrir modal para nuevo usuario
document.querySelector('[data-target="#myModal"]').addEventListener('click', function() {
    limpiarFormulario();
});

// Crear usuario
document.getElementById('btnGuardar').addEventListener('click', function(e) {
    e.preventDefault();
    let form = new FormData(document.getElementById('userForm'));
    let data = {};
    form.forEach((v, k) => data[k] = v);

    fetch('../controllers/UsuarioController.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(resp => {
        if (resp.success) {
            $('#myModal').modal('hide');
            cargarUsuarios();
            limpiarFormulario();
        } else {
            alert('Error al crear usuario');
        }
    });
});

// Editar usuario (cargar datos en modal)
window.editarUsuario = function(id) {
    fetch(`../controllers/UsuarioController.php?id=${id}`)
        .then(res => res.json())
        .then(usuario => {
            document.querySelector('[name="nombre"]').value = usuario.NOMBRES;
            document.querySelector('[name="apellido"]').value = usuario.APELLIDOS;
            document.querySelector('[name="fecha_nacimiento"]').value = usuario.FECHA_NACIMIENTO;
            document.querySelector('[name="telefono"]').value = usuario.TELEFONO;
            document.querySelector('[name="direccion"]').value = usuario.DIRECCION;
            document.querySelector('[name="correo"]').value = usuario.CORREO;
            document.querySelector('[name="contrasena"]').value = usuario.CONTRASENA;
            document.querySelector('[name="rol"]').value = usuario.CODIGOROL;
            document.getElementById('userForm').setAttribute('data-edit', id);
            document.getElementById('btnGuardar').style.display = 'none';
            document.getElementById('btnActualizar').style.display = 'inline-block';
            $('#myModal').modal('show');
        });
};

// Guardar edición
document.getElementById('btnActualizar').addEventListener('click', function(e) {
    e.preventDefault();
    let form = new FormData(document.getElementById('userForm'));
    let data = {};
    form.forEach((v, k) => data[k] = v);
    let id = document.getElementById('userForm').getAttribute('data-edit');
    data.id = id;

    fetch('../controllers/UsuarioController.php', {
        method: 'PUT',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    })
    .then(res => res.json())
    .then(resp => {
        if (resp.success) {
            $('#myModal').modal('hide');
            cargarUsuarios();
            limpiarFormulario();
        } else {
            alert('Error al editar usuario');
        }
    });
});

// Eliminar usuario
window.eliminarUsuario = function(id) {
    if (confirm('¿Seguro de eliminar este usuario?')) {
        fetch('../controllers/UsuarioController.php', {
            method: 'DELETE',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}`
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.success) {
                cargarUsuarios();
            } else {
                alert('Error al eliminar usuario');
            }
        });
    }
};

document.addEventListener('DOMContentLoaded', cargarUsuarios);