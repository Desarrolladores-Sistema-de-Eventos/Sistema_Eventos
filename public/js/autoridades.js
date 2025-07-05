document.addEventListener('DOMContentLoaded', function() {
    fetch('../controllers/AutoridadesController.php?option=listar')
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta recibida:', data);

            const row = document.querySelector('#autoridades-row');
            if (!row) return;

            row.innerHTML = '';

            if (Array.isArray(data)) {
                data.forEach(autoridad => {
                    row.innerHTML += `
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-2">
                            <div class="team-item bg-white mb-4">
                                <div class="team-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="../public/img/autoridades/${autoridad.FOTO_URL ? autoridad.FOTO_URL : 'default.png'}" alt="Foto de ${autoridad.NOMBRE}">
                                </div>
                                <div class="text-center py-4">
                                    <h5 class="text-truncate">${autoridad.NOMBRE}</h5>
                                    <p class="text-muted">${autoridad.CARGO || ''}</p>
                                    <small class="text-muted">${autoridad.CORREO || ''}</small>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                row.innerHTML = '<div class="col-12 text-center text-danger">No se pudo cargar la información de autoridades.</div>';
                console.error('La respuesta no es un array:', data);
            }
        })
        .catch(error => {
            console.error('Error al cargar autoridades:', error);
        });
});

const AUTORIDADES_CTRL = '../controllers/AutoridadesController.php';

// Utilidad para peticiones POST
async function postAutoridad(option, data = {}) {
    const formData = new FormData();
    for (const key in data) {
        formData.append(key, data[key]);
    }
    const res = await fetch(`${AUTORIDADES_CTRL}?option=${option}`, {
        method: 'POST',
        body: formData
    });
    return res.json();
}

// Utilidad para peticiones GET
async function getAutoridad(option) {
    const res = await fetch(`${AUTORIDADES_CTRL}?option=${option}`);
    return res.json();
}

// ================= CRUD AUTORIDAD =================
async function listarAutoridades() {
    return await getAutoridad('listar');
}
async function guardarAutoridad(autoridad) {
    return await postAutoridad('crear', autoridad);
}
async function actualizarAutoridad(autoridad) {
    return await postAutoridad('editar', autoridad);
}
async function eliminarAutoridad(id) {
    return await postAutoridad('eliminar', { id });
}

// Renderizar tabla de autoridades
async function renderAutoridadesTable() {
    const autoridades = await listarAutoridades();
    const tbody = document.querySelector('#tabla-autoridades tbody');
    tbody.innerHTML = '';
    if (Array.isArray(autoridades)) {
        autoridades.forEach(a => {
            tbody.innerHTML += `
                <tr>
                    <td>${a.FOTO_URL ? `<img src="../public/img/autoridades/${a.FOTO_URL}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">` : '<i class="fa fa-user-circle" style="font-size: 2rem; color: #888;"></i>'}</td>
                    <td>${a.NOMBRE}</td>
                    <td>${a.CARGO}</td>
                    <td>${a.CORREO}</td>
                    <td>${a.TELEFONO || ''}</td>
                    <td>
                        <button class="btn btn-sm" style="background-color: #d3d3d3; color: #000;" onclick="editarAutoridad('${a.identificador}')"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm" style="background-color: #d3d3d3; color: #000;" onclick="eliminarAutoridadConfirm('${a.identificador}')"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
    }
}

// Abrir modal para agregar autoridad
const btnAgregarAutoridad = document.getElementById('btnAgregarAutoridad');
if (btnAgregarAutoridad) {
    btnAgregarAutoridad.addEventListener('click', function() {
        document.getElementById('modalAutoridadLabel').textContent = 'Agregar Autoridad';
        document.getElementById('formAutoridad').reset();
        document.getElementById('autoridadId').value = '';
        $('#modalAutoridad').modal('show');
    });
}

// Guardar o actualizar autoridad
const formAutoridad = document.getElementById('formAutoridad');
if (formAutoridad) {
    formAutoridad.addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('autoridadId') ? document.getElementById('autoridadId').value : '';
        const nombresInput = document.getElementById('nombresAutoridad');
        const cargoInput = document.getElementById('cargoAutoridad');
        const correoInput = document.getElementById('correoAutoridad');
        if (!nombresInput || !cargoInput || !correoInput) {
            Swal.fire('Error', 'Faltan campos obligatorios en el formulario.', 'error');
            return;
        }
        const nombres = nombresInput.value;
        const cargo = cargoInput.value;
        const correo = correoInput.value;
        // El campo telefono y facultad pueden no existir en el modal
        const telefonoInput = document.getElementById('telefonoAutoridad');
        const facultadInput = document.getElementById('facultadAutoridad');
        const telefono = telefonoInput ? telefonoInput.value : '';
        const facultad_secuencial = facultadInput ? facultadInput.value : null;
        const fotoInput = document.getElementById('fotoAutoridad');
        let foto_url = '';
        if (fotoInput && fotoInput.files.length > 0) {
            foto_url = fotoInput.files[0];
        }
        const data = { nombre: nombres, cargo, correo, telefono };
        if (facultad_secuencial) data.facultad_secuencial = facultad_secuencial;
        // El backend espera el archivo como 'foto_url', pero el input se llama 'foto_perfil'.
        if (foto_url) data.foto_url = foto_url;
        let res;
        if (id) {
            data.id = id;
            res = await actualizarAutoridad(data);
        } else {
            res = await guardarAutoridad(data);
        }
        if (res.tipo === 'success') {
            $('#modalAutoridad').modal('hide');
            renderAutoridadesTable();
        } else {
            Swal.fire('Error', res.mensaje, 'error');
        }
    });
}

// Editar autoridad
window.editarAutoridad = async function(id) {
    const autoridades = await listarAutoridades();
    const autoridad = autoridades.find(a => a.identificador == id);
    if (!autoridad) return;
    document.getElementById('modalAutoridadLabel').textContent = 'Editar Autoridad';
    document.getElementById('autoridadId').value = autoridad.identificador;
    document.getElementById('nombresAutoridad').value = autoridad.NOMBRE;
    document.getElementById('cargoAutoridad').value = autoridad.CARGO;
    document.getElementById('correoAutoridad').value = autoridad.CORREO;
    if (document.getElementById('telefonoAutoridad')) {
        document.getElementById('telefonoAutoridad').value = autoridad.TELEFONO || '';
    }
    if (document.getElementById('facultadAutoridad')) {
        document.getElementById('facultadAutoridad').value = autoridad.FACULTAD_SECUENCIAL || '';
    }
    // Mostrar nombre de archivo de foto si existe
    if (document.getElementById('fotoAutoridad')) {
        document.getElementById('fotoAutoridad').value = '';
        const labelFoto = document.getElementById('labelFotoNombre');
        if (labelFoto) {
            labelFoto.textContent = autoridad.FOTO_URL ? `Archivo actual: ${autoridad.FOTO_URL}` : '';
        }
    }
    $('#modalAutoridad').modal('show');
}

// Eliminar autoridad
window.eliminarAutoridadConfirm = async function(id) {
    if (confirm('¿Está seguro de eliminar esta autoridad?')) {
        const res = await eliminarAutoridad(id);
        if (res.tipo === 'success') {
            renderAutoridadesTable();
        } else {
            Swal.fire('Error', res.mensaje, 'error');
        }
    }
}

// Inicializar
$(document).ready(function() {
    renderAutoridadesTable().then(() => {
        if ($.fn.DataTable.isDataTable('#tabla-autoridades')) {
            $('#tabla-autoridades').DataTable().destroy();
        }
        $('#tabla-autoridades').DataTable({
            language: {
                url: '../public/js/es-ES.json'
            }
        });
    });
});

