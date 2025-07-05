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

// ================= CRUD CARRERA =================
async function listarCarreras() {
    return await getConfig('carrera_listar');
}
async function guardarCarrera(carrera) {
    return await postConfig('carrera_guardar', carrera);
}
async function actualizarCarrera(carrera) {
    return await postConfig('carrera_actualizar', carrera);
}
async function eliminarCarrera(id) {
    return await postConfig('carrera_eliminar', { id });
}

// ================= FACULTADES =================
async function listarFacultades() {
    return await getConfig('facultad_listar');
}

// Renderizar tabla de carreras
async function renderCarrerasTable() {
    const carreras = await listarCarreras();
    const facultades = await listarFacultades();
    const tbody = document.querySelector('#tablaCarreras tbody');
    tbody.innerHTML = '';
    if (Array.isArray(carreras)) {
        carreras.forEach(c => {
            const facultad = facultades.find(f => f.SECUENCIAL == c.SECUENCIALFACULTAD);
            tbody.innerHTML += `
                <tr>
                    <td>${c.NOMBRE_CARRERA}</td>
                    <td>${facultad ? facultad.NOMBRE : ''}</td>
                    <td>
                        <button class="btn btn-sm" style="background-color: #d3d3d3; color: #000;" onclick="editarCarrera(${c.SECUENCIAL})"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm" style="background-color: #d3d3d3; color: #000;" onclick="eliminarCarreraConfirm(${c.SECUENCIAL})"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
    }
}

// Renderizar opciones de facultad en el select
async function renderFacultadesSelect() {
    const facultades = await listarFacultades();
    const select = document.getElementById('facultadCarrera');
    select.innerHTML = '<option value="">Seleccione...</option>';
    facultades.forEach(f => {
        select.innerHTML += `<option value="${f.SECUENCIAL}">${f.NOMBRE}</option>`;
    });
}

// Abrir modal para agregar carrera
document.getElementById('btnAgregarCarrera').addEventListener('click', async function() {
    document.getElementById('modalCarreraLabel').textContent = 'Agregar Carrera';
    document.getElementById('formCarrera').reset();
    document.getElementById('carreraId').value = '';
    await renderFacultadesSelect();
    $('#modalCarrera').modal('show');
});

// Guardar o actualizar carrera
document.getElementById('formCarrera').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('carreraId').value;
    const nombre = document.getElementById('nombreCarrera').value;
    const idFacultad = document.getElementById('facultadCarrera').value;
    if (!nombre || !idFacultad) {
        alert('Todos los campos son obligatorios');
        return;
    }
    const data = { nombre, idFacultad };
    let res;
    if (id) {
        data.id = id;
        res = await actualizarCarrera(data);
    } else {
        res = await guardarCarrera(data);
    }
    if (res.tipo === 'success') {
        $('#modalCarrera').modal('hide');
        renderCarrerasTable();
    } else {
        alert(res.mensaje);
    }
});

// Editar carrera
window.editarCarrera = async function(id) {
    const carreras = await listarCarreras();
    const carrera = carreras.find(c => c.SECUENCIAL == id);
    if (!carrera) return;
    document.getElementById('modalCarreraLabel').textContent = 'Editar Carrera';
    document.getElementById('carreraId').value = carrera.SECUENCIAL;
    document.getElementById('nombreCarrera').value = carrera.NOMBRE_CARRERA;
    await renderFacultadesSelect();
    document.getElementById('facultadCarrera').value = carrera.SECUENCIALFACULTAD;
    $('#modalCarrera').modal('show');
}

// Eliminar carrera
window.eliminarCarreraConfirm = async function(id) {
    if (confirm('¿Está seguro de eliminar esta carrera?')) {
        const res = await eliminarCarrera(id);
        if (res.tipo === 'success') {
            renderCarrerasTable();
        } else {
            alert(res.mensaje);
        }
    }
}

// Inicializar
$(document).ready(function() {
    renderCarrerasTable().then(() => {
        if ($.fn.DataTable.isDataTable('#tablaCarreras')) {
            $('#tablaCarreras').DataTable().destroy();
        }
        $('#tablaCarreras').DataTable({
            language: {
                url: '../public/js/es-ES.json'
            }
        });
    });
});