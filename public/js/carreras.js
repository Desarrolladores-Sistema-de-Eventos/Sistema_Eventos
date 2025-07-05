const CARRERA_CTRL = '../controllers/CarreraController.php';
const CONFIG_CTRL = '../controllers/ConfiguracionesController.php';



async function postConfigFormData(option, formData) {
    const res = await fetch(`${CONFIG_CTRL}?option=${option}`, {
        method: 'POST',
        body: formData
    });
    return res.json();
}


async function getConfig(option) {
    const res = await fetch(`${CONFIG_CTRL}?option=${option}`);
    return res.json();
}



// ================= CRUD CARRERA =================
async function listarCarreras() {
    return await getConfig('carrera_listar');
}

async function guardarCarrera(formData) {
    return await postConfigFormData('carrera_guardar', formData);
}

async function actualizarCarrera(formData) {
    return await postConfigFormData('carrera_actualizar', formData);
}

async function eliminarCarrera(id) {
    const formData = new FormData();
    formData.append('id', id);
    return await postConfigFormData('carrera_eliminar', formData);
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
                        <button class="btn btn-primary btn-sm" onclick="editarCarrera(${c.SECUENCIAL})"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarCarreraConfirm(${c.SECUENCIAL})"><i class="fa fa-trash"></i></button>
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
    console.log('Facultades:', facultades);
    if (Array.isArray(facultades)) {
        facultades.forEach(f => {
            select.innerHTML += `<option value="${f.SECUENCIAL}">${f.NOMBRE}</option>`;
        });
    } else {
        console.error('Facultades no es un array:', facultades);
    }

}

// Abrir modal para agregar carrera
document.getElementById('btnAgregarCarrera').addEventListener('click', async function () {
    document.getElementById('modalCarreraLabel').textContent = 'Agregar Carrera';
    document.getElementById('formCarrera').reset();
    document.getElementById('carreraId').value = '';
    await renderFacultadesSelect();
    $('#modalCarrera').modal('show');
});

// Guardar o actualizar carrera
document.getElementById('formCarrera').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = document.getElementById('formCarrera');
    const formData = new FormData(form);
    const id = formData.get('id');
    const imagen = formData.get('imagen');

    if (!formData.get('nombre') || !formData.get('facultad')) {
        Swal.fire("Campos requeridos", "Todos los campos son obligatorios", "warning");
        return;
    }

    if (!id && (!imagen || imagen.name.trim() === '')) {
        Swal.fire("Imagen requerida", "Debe seleccionar una imagen para la nueva carrera", "warning");
        return;
    }

    let res;
    try {
        if (id) {
            res = await actualizarCarrera(formData);
        } else {
            res = await guardarCarrera(formData);
        }

        if (res.tipo === 'success') {
            $('#modalCarrera').modal('hide');
            await renderCarrerasTable();
            Swal.fire("Éxito", res.mensaje || "Carrera guardada correctamente", "success");
        } else {
            Swal.fire("Error", res.mensaje || "Ocurrió un error", "error");
        }
    } catch (err) {
        console.error("Error al guardar/actualizar carrera:", err);
        Swal.fire("Error", "Problema al guardar los datos", "error");
    }
});

// Eliminar carrera
window.eliminarCarreraConfirm = async function (id) {
    const result = await Swal.fire({
        title: "¿Está seguro?",
        text: "Esta acción eliminará la carrera",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    });

    if (result.isConfirmed) {
        try {
            const res = await eliminarCarrera(id);
            if (res.tipo === 'success') {
                await renderCarrerasTable();
                Swal.fire("Eliminado", res.mensaje || "Carrera eliminada exitosamente", "success");
            } else {
                Swal.fire("Error", res.mensaje || "No se pudo eliminar la carrera", "error");
            }
        } catch (err) {
            console.error("Error al eliminar carrera:", err);
            Swal.fire("Error", "Problema al intentar eliminar la carrera", "error");
        }
    }
};
window.editarCarrera = async function (id) {
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
// Inicializar
$(document).ready(function () {
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
