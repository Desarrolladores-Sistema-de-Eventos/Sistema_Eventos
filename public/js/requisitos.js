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

// ================= CRUD REQUISITO EVENTO =================
async function listarRequisitosEvento() {
    return await getConfig('requisito_evento_listar');
}
async function guardarRequisitoEvento(requisito) {
    return await postConfig('requisito_evento_guardar', requisito);
}
async function actualizarRequisitoEvento(requisito) {
    return await postConfig('requisito_evento_actualizar', requisito);
}
async function eliminarRequisitoEvento(id) {
    return await postConfig('requisito_evento_eliminar', { id });
}

// Renderizar tabla de requisitos
async function renderRequisitosTable() {
    const requisitos = await listarRequisitosEvento();
    const tbody = document.querySelector('#tablaRequisitos tbody');
    tbody.innerHTML = '';
    if (Array.isArray(requisitos)) {
        requisitos.forEach(req => {
            tbody.innerHTML += `
                <tr>
                    <td>${req.DESCRIPCION}</td>
                    <td>
                        <button class="btn btn-sm" style="background-color: #d3d3d3; color: #222;" onclick="editarRequisito(${req.SECUENCIAL})">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm" style="background-color: #d3d3d3; color: #222;" onclick="eliminarRequisitoConfirm(${req.SECUENCIAL})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    }
}

// Abrir modal para agregar requisito
document.getElementById('btnAgregarRequisito').addEventListener('click', function() {
    document.getElementById('modalRequisitoLabel').textContent = 'Agregar Requisito';
    document.getElementById('formRequisito').reset();
    document.getElementById('requisitoId').value = '';
    $('#modalRequisito').modal('show');
});

// Guardar o actualizar requisito
document.getElementById('formRequisito').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('requisitoId').value;
    const descripcion = document.getElementById('descripcionRequisito').value.trim();
    if (!descripcion) {
        alert('La descripción es obligatoria');
        return;
    }
    const data = { descripcion };
    let res;
    if (id) {
        data.id = id;
        res = await actualizarRequisitoEvento(data);
    } else {
        res = await guardarRequisitoEvento(data);
    }
    if (res.tipo === 'success') {
        $('#modalRequisito').modal('hide');
        renderRequisitosTable();
    } else {
        alert(res.mensaje);
    }
});

// Editar requisito
window.editarRequisito = async function(id) {
    const requisitos = await listarRequisitosEvento();
    const req = requisitos.find(r => r.SECUENCIAL == id);
    if (!req) return;
    document.getElementById('modalRequisitoLabel').textContent = 'Editar Requisito';
    document.getElementById('requisitoId').value = req.SECUENCIAL;
    document.getElementById('descripcionRequisito').value = req.DESCRIPCION;
    $('#modalRequisito').modal('show');
}

// Eliminar requisito
window.eliminarRequisitoConfirm = async function(id) {
    if (confirm('¿Está seguro de eliminar este requisito?')) {
        const res = await eliminarRequisitoEvento(id);
        if (res.tipo === 'success') {
            renderRequisitosTable();
        } else {
            alert(res.mensaje);
        }
    }
}

// Inicializar
$(document).ready(function() {
    renderRequisitosTable().then(() => {
        if ($.fn.DataTable.isDataTable('#tablaRequisitos')) {
            $('#tablaRequisitos').DataTable().destroy();
        }
        $('#tablaRequisitos').DataTable({
            language: {
                url: '../public/js/es-ES.json'
            }
        });
    });
});