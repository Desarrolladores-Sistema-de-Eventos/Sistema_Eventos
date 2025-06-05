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

// ================= CRUD FORMA DE PAGO =================
async function listarFormasPago() {
    return await getConfig('forma_pago_listar');
}
async function guardarFormaPago(forma) {
    return await postConfig('forma_pago_guardar', forma);
}
async function actualizarFormaPago(forma) {
    return await postConfig('forma_pago_actualizar', forma);
}
async function eliminarFormaPago(codigo) {
    return await postConfig('forma_pago_eliminar', { codigo });
}

// Renderizar tabla de formas de pago
async function renderFormasPagoTable() {
    const formas = await listarFormasPago();
    const tbody = document.querySelector('#tablaFormasPago tbody');
    tbody.innerHTML = '';
    if (Array.isArray(formas)) {
        formas.forEach(f => {
            tbody.innerHTML += `
                <tr>
                    <td>${f.CODIGO}</td>
                    <td>${f.NOMBRE}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="editarFormaPago('${f.CODIGO}')"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarFormaPagoConfirm('${f.CODIGO}')"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
    }
}

// Abrir modal para agregar forma de pago
document.getElementById('btnAgregarFormaPago').addEventListener('click', function() {
    document.getElementById('modalFormaPagoLabel').textContent = 'Agregar Forma de Pago';
    document.getElementById('formFormaPago').reset();
    document.getElementById('codigoFormaPago').readOnly = false;
    $('#modalFormaPago').modal('show');
});

// Guardar o actualizar forma de pago
document.getElementById('formFormaPago').addEventListener('submit', async function(e) {
    e.preventDefault();
    const codigo = document.getElementById('codigoFormaPago').value.trim();
    const nombre = document.getElementById('nombreFormaPago').value.trim();
    if (!codigo || !nombre) {
        alert('Código y nombre son obligatorios');
        return;
    }
    const data = { codigo, nombre };
    let res;
    if (document.getElementById('codigoFormaPago').readOnly) {
        res = await actualizarFormaPago(data);
    } else {
        res = await guardarFormaPago(data);
    }
    if (res.tipo === 'success') {
        $('#modalFormaPago').modal('hide');
        renderFormasPagoTable();
    } else {
        alert(res.mensaje);
    }
});

// Editar forma de pago
window.editarFormaPago = async function(codigo) {
    const formas = await listarFormasPago();
    const forma = formas.find(f => f.CODIGO === codigo);
    if (!forma) return;
    document.getElementById('modalFormaPagoLabel').textContent = 'Editar Forma de Pago';
    document.getElementById('codigoFormaPago').value = forma.CODIGO;
    document.getElementById('codigoFormaPago').readOnly = true;
    document.getElementById('nombreFormaPago').value = forma.NOMBRE;
    $('#modalFormaPago').modal('show');
}

// Eliminar forma de pago
window.eliminarFormaPagoConfirm = async function(codigo) {
    if (confirm('¿Está seguro de eliminar esta forma de pago?')) {
        const res = await eliminarFormaPago(codigo);
        if (res.tipo === 'success') {
            renderFormasPagoTable();
        } else {
            alert(res.mensaje);
        }
    }
}

// Inicializar
$(document).ready(function() {
    renderFormasPagoTable().then(() => {
        if ($.fn.DataTable.isDataTable('#tablaFormasPago')) {
            $('#tablaFormasPago').DataTable().destroy();
        }
        $('#tablaFormasPago').DataTable({
            language: {
                url: '../public/js/es-ES.json'
            }
        });
    });
});