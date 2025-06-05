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

// ================= CRUD MODALIDAD EVENTO =================
async function listarModalidadesEvento() {
    return await getConfig('modalidad_evento_listar');
}
async function guardarModalidadEvento(modalidad) {
    return await postConfig('modalidad_evento_guardar', modalidad);
}
async function actualizarModalidadEvento(modalidad) {
    return await postConfig('modalidad_evento_actualizar', modalidad);
}
async function eliminarModalidadEvento(codigo) {
    return await postConfig('modalidad_evento_eliminar', { codigo });
}

// Renderizar tabla de modalidades
async function renderModalidadesTable() {
    const modalidades = await listarModalidadesEvento();
    const tbody = document.querySelector('#tablaModalidades tbody');
    tbody.innerHTML = '';
    if (Array.isArray(modalidades)) {
        modalidades.forEach(m => {
            tbody.innerHTML += `
                <tr>
                    <td>${m.CODIGO}</td>
                    <td>${m.NOMBRE}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="editarModalidad('${m.CODIGO}')"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarModalidadConfirm('${m.CODIGO}')"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
    }
}

// Abrir modal para agregar modalidad
document.getElementById('btnAgregarModalidad').addEventListener('click', function() {
    document.getElementById('modalModalidadLabel').textContent = 'Agregar Modalidad';
    document.getElementById('formModalidad').reset();
    document.getElementById('codigoModalidad').readOnly = false;
    $('#modalModalidad').modal('show');
});

// Guardar o actualizar modalidad
document.getElementById('formModalidad').addEventListener('submit', async function(e) {
    e.preventDefault();
    const codigo = document.getElementById('codigoModalidad').value.trim();
    const nombre = document.getElementById('nombreModalidad').value.trim();
    if (!codigo || !nombre) {
        alert('Código y nombre son obligatorios');
        return;
    }
    const data = { codigo, nombre };
    let res;
    if (document.getElementById('codigoModalidad').readOnly) {
        res = await actualizarModalidadEvento(data);
    } else {
        res = await guardarModalidadEvento(data);
    }
    if (res.tipo === 'success') {
        $('#modalModalidad').modal('hide');
        renderModalidadesTable();
    } else {
        alert(res.mensaje);
    }
});

// Editar modalidad
window.editarModalidad = async function(codigo) {
    const modalidades = await listarModalidadesEvento();
    const modalidad = modalidades.find(m => m.CODIGO === codigo);
    if (!modalidad) return;
    document.getElementById('modalModalidadLabel').textContent = 'Editar Modalidad';
    document.getElementById('codigoModalidad').value = modalidad.CODIGO;
    document.getElementById('codigoModalidad').readOnly = true;
    document.getElementById('nombreModalidad').value = modalidad.NOMBRE;
    $('#modalModalidad').modal('show');
}

// Eliminar modalidad
window.eliminarModalidadConfirm = async function(codigo) {
    if (confirm('¿Está seguro de eliminar esta modalidad?')) {
        const res = await eliminarModalidadEvento(codigo);
        if (res.tipo === 'success') {
            renderModalidadesTable();
        } else {
            alert(res.mensaje);
        }
    }
}

// Inicializar
$(document).ready(function() {
    renderModalidadesTable().then(() => {
        if ($.fn.DataTable.isDataTable('#tablaModalidades')) {
            $('#tablaModalidades').DataTable().destroy();
        }
        $('#tablaModalidades').DataTable({
            language: {
                url: '../public/js/es-ES.json'
            }
        });
    });
});