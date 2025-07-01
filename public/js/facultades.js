const CONFIG_CTRL = '../controllers/ConfiguracionesController.php';

// Utilidad para peticiones POST (con archivos o sin)
async function postConfig(option, data = {}, files = {}) {
    const formData = new FormData();

    for (const key in data) {
        formData.append(key, data[key]);
    }

    for (const key in files) {
        if (files[key]) {
            formData.append(key, files[key]);
        }
    }

    const res = await fetch(`${CONFIG_CTRL}?option=${option}`, {
        method: 'POST',
        body: formData
    });

    return res.json();
}

// Utilidad para GET
async function getConfig(option) {
    const res = await fetch(`${CONFIG_CTRL}?option=${option}`);
    return res.json();
}

// ========== CRUD FACULTAD ==========
async function listarFacultades() {
    return await getConfig('facultad_listar');
}

async function guardarFacultad(facultad, archivos = {}) {
    return await postConfig('facultad_guardar', facultad, archivos);
}

async function actualizarFacultad(facultad, archivos = {}) {
    return await postConfig('facultad_actualizar', facultad, archivos);
}

async function eliminarFacultad(id) {
    return await postConfig('facultad_eliminar', { id });
}

// Render tabla
async function renderFacultadesTable() {
    const facultades = await listarFacultades();
    const tbody = document.querySelector('#tablaFacultades tbody');
    tbody.innerHTML = '';

    if ($.fn.DataTable.isDataTable('#tablaFacultades')) {
        $('#tablaFacultades').DataTable().destroy();
    }

    if (Array.isArray(facultades)) {
        facultades.forEach(f => {
            tbody.innerHTML += `
                <tr class="clickable-row" data-id="${f.SECUENCIAL}">
                    <td>${f.NOMBRE || ''}</td>
                    <td>${f.MISION || ''}</td>
                    <td>${f.VISION || ''}</td>
                    <td>${f.UBICACION || ''}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="event.stopPropagation(); editarFacultad(${f.SECUENCIAL})"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="event.stopPropagation(); eliminarFacultadConfirm(${f.SECUENCIAL})"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
    }

    $('#tablaFacultades').DataTable({
        language: {
            url: '../public/js/es-ES.json'
        }
    });

    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', function () {
            editarFacultad(this.dataset.id);
        });
    });
}

// Agregar facultad
document.getElementById('btnAgregarFacultad').addEventListener('click', function () {
    document.getElementById('modalFacultadLabel').textContent = 'Agregar Facultad';
    document.getElementById('formFacultad').reset();
    document.getElementById('facultadId').value = '';
    $('#modalFacultad').modal('show');
});

// Guardar/Actualizar
document.getElementById('formFacultad').addEventListener('submit', async function (e) {
    e.preventDefault();

    const id = document.getElementById('facultadId').value;
    const nombre = document.getElementById('nombreFacultad').value.trim();
    const mision = document.getElementById('misionFacultad').value.trim();
    const vision = document.getElementById('visionFacultad').value.trim();
    const ubicacion = document.getElementById('ubicacionFacultad').value.trim();
    const sigla = document.getElementById('siglaFacultad').value.trim();
    const about = document.getElementById('aboutFacultad').value.trim();

    const logoFile = document.getElementById('urlLogoFacultad').files[0];
    const portadaFile = document.getElementById('urlPortadaFacultad').files[0];

    if (!nombre || !mision || !vision || !ubicacion || !sigla) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos obligatorios',
            text: 'Debe completar todos los campos requeridos.',
            confirmButtonColor: '#B5121B'
        });
        return;
    }

    const data = { nombre, mision, vision, ubicacion, sigla, about };
    const files = {};
    if (logoFile) files.urlLogo = logoFile;
    if (portadaFile) files.urlPortada = portadaFile;

    let res;
    if (id) {
        data.id = id;
        res = await actualizarFacultad(data, files);
    } else {
        res = await guardarFacultad(data, files);
    }

    if (res.tipo === 'success') {
        $('#modalFacultad').modal('hide');
        await renderFacultadesTable();
        Swal.fire({
            icon: 'success',
            title: res.mensaje || 'Operación exitosa',
            showConfirmButton: false,
            timer: 1800,
            background: '#f5f5f5',
            iconColor: '#B5121B'
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: res.mensaje || 'No se pudo completar la operación.',
            confirmButtonColor: '#B5121B'
        });
    }
});

// Editar
window.editarFacultad = async function (id) {
    const facultades = await listarFacultades();
    const facultad = facultades.find(f => f.SECUENCIAL == id);
    if (!facultad) return;

    document.getElementById('modalFacultadLabel').textContent = 'Editar Facultad';
    document.getElementById('facultadId').value = facultad.SECUENCIAL;
    document.getElementById('nombreFacultad').value = facultad.NOMBRE || '';
    document.getElementById('misionFacultad').value = facultad.MISION || '';
    document.getElementById('visionFacultad').value = facultad.VISION || '';
    document.getElementById('ubicacionFacultad').value = facultad.UBICACION || '';
    document.getElementById('siglaFacultad').value = facultad.SIGLA || '';
    document.getElementById('aboutFacultad').value = facultad.ABOUT || '';

    document.getElementById('urlLogoFacultad').value = '';
    document.getElementById('urlPortadaFacultad').value = '';

    $('#modalFacultad').modal('show');
}

// Eliminar
window.eliminarFacultadConfirm = function (id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B5121B',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const res = await eliminarFacultad(id);
            if (res.tipo === 'success') {
                await renderFacultadesTable();
                Swal.fire({
                    icon: 'success',
                    title: res.mensaje || 'Eliminado correctamente',
                    showConfirmButton: false,
                    timer: 1500,
                    iconColor: '#B5121B'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.mensaje || 'No se pudo eliminar',
                    confirmButtonColor: '#B5121B'
                });
            }
        }
    });
}

// Iniciar tabla al cargar
$(document).ready(function () {
    renderFacultadesTable();
});
