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

// ================= CRUD FACULTAD =================
async function listarFacultades() {
    return await getConfig('facultad_listar');
}
async function guardarFacultad(facultad) {
    return await postConfig('facultad_guardar', facultad);
}
async function actualizarFacultad(facultad) {
    return await postConfig('facultad_actualizar', facultad);
}
async function eliminarFacultad(id) {
    return await postConfig('facultad_eliminar', { id });
}

// Renderizar tabla de facultades
async function renderFacultadesTable() {
    const facultades = await listarFacultades();
    const tbody = document.querySelector('#tablaFacultades tbody');
    tbody.innerHTML = '';
    if (Array.isArray(facultades)) {
        facultades.forEach(f => {
            tbody.innerHTML += `
                <tr>
                    <td>${f.NOMBRE}</td>
                    <td>${f.MISION || ''}</td>
                    <td>${f.VISION || ''}</td>
                    <td>${f.UBICACION || ''}</td>
                    <td>
                        <button class="btn btn-light btn-sm text-dark" style="border:1px solid #ccc;" onclick="editarFacultad(${f.SECUENCIAL})">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-light btn-sm text-dark" onclick="eliminarFacultadConfirm(${f.SECUENCIAL})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    }
}

// Abrir modal para agregar facultad
document.getElementById('btnAgregarFacultad').addEventListener('click', function() {
    document.getElementById('modalFacultadLabel').textContent = 'Agregar Facultad';
    document.getElementById('formFacultad').reset();
    document.getElementById('facultadId').value = '';
    $('#modalFacultad').modal('show');
});

// Guardar o actualizar facultad
document.getElementById('formFacultad').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('facultadId').value;
    const nombre = document.getElementById('nombreFacultad').value.trim();
    const mision = document.getElementById('misionFacultad').value.trim();
    const vision = document.getElementById('visionFacultad').value.trim();
    const ubicacion = document.getElementById('ubicacionFacultad').value.trim();
    if (!nombre || !mision || !vision || !ubicacion) {
        alert('Todos los campos son obligatorios');
        return;
    }
    const data = { nombre, mision, vision, ubicacion };
    let res;
    if (id) {
        data.id = id;
        res = await actualizarFacultad(data);
    } else {
        res = await guardarFacultad(data);
    }
    if (res.tipo === 'success') {
        $('#modalFacultad').modal('hide');
        renderFacultadesTable();
    } else {
        alert(res.mensaje);
    }
});

// Editar facultad
window.editarFacultad = async function(id) {
    const facultades = await listarFacultades();
    const facultad = facultades.find(f => f.SECUENCIAL == id);
    if (!facultad) return;
    document.getElementById('modalFacultadLabel').textContent = 'Editar Facultad';
    document.getElementById('facultadId').value = facultad.SECUENCIAL;
    document.getElementById('nombreFacultad').value = facultad.NOMBRE;
    document.getElementById('misionFacultad').value = facultad.MISION || '';
    document.getElementById('visionFacultad').value = facultad.VISION || '';
    document.getElementById('ubicacionFacultad').value = facultad.UBICACION || '';
    $('#modalFacultad').modal('show');
}

// Eliminar facultad
window.eliminarFacultadConfirm = async function(id) {
    if (confirm('¿Está seguro de eliminar esta facultad?')) {
        const res = await eliminarFacultad(id);
        if (res.tipo === 'success') {
            renderFacultadesTable();
        } else {
            alert(res.mensaje);
        }
    }
}

// Inicializar
$(document).ready(function() {
    renderFacultadesTable().then(() => {
        if ($.fn.DataTable.isDataTable('#tablaFacultades')) {
            $('#tablaFacultades').DataTable().destroy();
        }
        $('#tablaFacultades').DataTable({
            language: {
                url: '../public/js/es-ES.json'
            }
        });
    });
});