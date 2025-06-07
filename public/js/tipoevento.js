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

// ================= CRUD TIPO EVENTO =================
async function listarTiposEvento() {
    return await getConfig('tipo_evento_listar');
}
async function guardarTipoEvento(tipo) {
    return await postConfig('tipo_evento_guardar', tipo);
}
async function actualizarTipoEvento(tipo) {
    return await postConfig('tipo_evento_actualizar', tipo);
}
async function eliminarTipoEvento(codigo) {
    return await postConfig('tipo_evento_eliminar', { codigo });
}

// Renderizar tabla de tipos de evento
async function renderTiposEventoTable() {
    const tipos = await listarTiposEvento();
    const tbody = document.querySelector('#tablaTiposEvento tbody');
    tbody.innerHTML = '';
    if (Array.isArray(tipos)) {
        tipos.forEach(t => {
            tbody.innerHTML += `
                <tr>
                    <td>${t.CODIGO}</td>
                    <td>${t.NOMBRE}</td>
                    <td>${t.DESCRIPCION || ''}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="editarTipoEvento('${t.CODIGO}')"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarTipoEventoConfirm('${t.CODIGO}')"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
    }
}

// Abrir modal para agregar tipo de evento
document.getElementById('btnAgregarTipoEvento').addEventListener('click', function() {
    document.getElementById('modalTipoEventoLabel').textContent = 'Agregar Tipo de Evento';
    document.getElementById('formTipoEvento').reset();
    document.getElementById('codigoTipoEvento').readOnly = false;
    $('#modalTipoEvento').modal('show');
});

// Guardar o actualizar tipo de evento
document.getElementById('formTipoEvento').addEventListener('submit', async function(e) {
    e.preventDefault();
    const codigo = document.getElementById('codigoTipoEvento').value.trim();
    const nombre = document.getElementById('nombreTipoEvento').value.trim();
    const descripcion = document.getElementById('descripcionTipoEvento').value.trim();
    if (!codigo || !nombre) {
        alert('Código y nombre son obligatorios');
        return;
    }
    const data = { codigo, nombre, descripcion };
    let res;
    if (document.getElementById('codigoTipoEvento').readOnly) {
        res = await actualizarTipoEvento(data);
    } else {
        res = await guardarTipoEvento(data);
    }
    if (res.tipo === 'success') {
        $('#modalTipoEvento').modal('hide');
        renderTiposEventoTable();
    } else {
        alert(res.mensaje);
    }
});

// Editar tipo de evento
window.editarTipoEvento = async function(codigo) {
    const tipos = await listarTiposEvento();
    const tipo = tipos.find(t => t.CODIGO === codigo);
    if (!tipo) return;
    document.getElementById('modalTipoEventoLabel').textContent = 'Editar Tipo de Evento';
    document.getElementById('codigoTipoEvento').value = tipo.CODIGO;
    document.getElementById('codigoTipoEvento').readOnly = true;
    document.getElementById('nombreTipoEvento').value = tipo.NOMBRE;
    document.getElementById('descripcionTipoEvento').value = tipo.DESCRIPCION || '';
    $('#modalTipoEvento').modal('show');
}

// Eliminar tipo de evento
window.eliminarTipoEventoConfirm = async function(codigo) {
    if (confirm('¿Está seguro de eliminar este tipo de evento?')) {
        const res = await eliminarTipoEvento(codigo);
        if (res.tipo === 'success') {
            renderTiposEventoTable();
        } else {
            alert(res.mensaje);
        }
    }
}

// Inicializar
$(document).ready(function() {
    renderTiposEventoTable().then(() => {
        if ($.fn.DataTable.isDataTable('#tablaTiposEvento')) {
            $('#tablaTiposEvento').DataTable().destroy();
        }
        $('#tablaTiposEvento').DataTable({
            language: {
                url: '../public/js/es-ES.json'
            }
        });
    });
});