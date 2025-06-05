const CONFIG_CTRL = '../controllers/ConfiguracionesController.php';

// Utilidad para peticiones POST
async function postConfig(option, data = {}) {
    const formData = new FormData();
    for (const key in data) {
        formData.append(key, data[key]);
    }
    const res = await fetch(`${CONFIG_CTRL}?option=${option}`, {
        method: 'POST',
        body: formData
    });
    return res.json();
}

// Utilidad para peticiones GET
async function getConfig(option) {
    const res = await fetch(`${CONFIG_CTRL}?option=${option}`);
    return res.json();
}

// ================= CRUD ROL USUARIO =================
async function listarRolesUsuario() {
    return await getConfig('rol_usuario_listar');
}
async function guardarRolUsuario(rol) {
    return await postConfig('rol_usuario_guardar', rol);
}
async function actualizarRolUsuario(rol) {
    return await postConfig('rol_usuario_actualizar', rol);
}
async function eliminarRolUsuario(codigo) {
    return await postConfig('rol_usuario_eliminar', { codigo });
}

// Renderizar tabla de roles de usuario
async function renderRolesUsuarioTable() {
    const roles = await listarRolesUsuario();
    const tbody = document.querySelector('#tablaRolesUsuario tbody');
    tbody.innerHTML = '';
    if (Array.isArray(roles)) {
        roles.forEach(r => {
            tbody.innerHTML += `
                <tr>
                    <td>${r.CODIGO}</td>
                    <td>${r.NOMBRE}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="editarRolUsuario('${r.CODIGO}')"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarRolUsuarioConfirm('${r.CODIGO}')"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
    }
}

// Abrir modal para agregar rol de usuario
document.getElementById('btnAgregarRolUsuario').addEventListener('click', function() {
    document.getElementById('modalRolUsuarioLabel').textContent = 'Agregar Rol de Usuario';
    document.getElementById('formRolUsuario').reset();
    document.getElementById('codigoRolUsuario').readOnly = false;
    $('#modalRolUsuario').modal('show');
});

// Guardar o actualizar rol de usuario
document.getElementById('formRolUsuario').addEventListener('submit', async function(e) {
    e.preventDefault();
    const codigo = document.getElementById('codigoRolUsuario').value.trim();
    const nombre = document.getElementById('nombreRolUsuario').value.trim();
    if (!codigo || !nombre) {
        alert('Código y nombre son obligatorios');
        return;
    }
    const data = { codigo, nombre };
    let res;
    if (document.getElementById('codigoRolUsuario').readOnly) {
        res = await actualizarRolUsuario(data);
    } else {
        res = await guardarRolUsuario(data);
    }
    if (res.tipo === 'success') {
        $('#modalRolUsuario').modal('hide');
        renderRolesUsuarioTable();
    } else {
        alert(res.mensaje);
    }
});

// Editar rol de usuario
window.editarRolUsuario = async function(codigo) {
    const roles = await listarRolesUsuario();
    const rol = roles.find(r => r.CODIGO === codigo);
    if (!rol) return;
    document.getElementById('modalRolUsuarioLabel').textContent = 'Editar Rol de Usuario';
    document.getElementById('codigoRolUsuario').value = rol.CODIGO;
    document.getElementById('codigoRolUsuario').readOnly = true;
    document.getElementById('nombreRolUsuario').value = rol.NOMBRE;
    $('#modalRolUsuario').modal('show');
}

// Eliminar rol de usuario
window.eliminarRolUsuarioConfirm = async function(codigo) {
    if (confirm('¿Está seguro de eliminar este rol de usuario?')) {
        const res = await eliminarRolUsuario(codigo);
        if (res.tipo === 'success') {
            renderRolesUsuarioTable();
        } else {
            alert(res.mensaje);
        }
    }
}

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    renderRolesUsuarioTable();
});