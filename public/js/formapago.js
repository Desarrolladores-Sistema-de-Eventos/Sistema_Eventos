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

  if (!formas || formas.length === 0) {
    tbody.innerHTML = '<tr><td colspan="3">No hay formas de pago registradas.</td></tr>';
    return;
  }

  formas.forEach(f => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${f.CODIGO}</td>
      <td>${f.NOMBRE}</td>
      <td>
        <button class="btn btn-primary btn-sm" onclick="editarFormaPago('${f.CODIGO}')"><i class="fa fa-edit"></i></button>
        <button class="btn btn-danger btn-sm" onclick="eliminarFormaPagoConfirm('${f.CODIGO}')"><i class="fa fa-trash"></i></button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

// Abrir modal para agregar forma de pago
document.getElementById('btnAgregarFormaPago').addEventListener('click', () => {
  document.getElementById('modalFormaPagoLabel').textContent = 'Agregar Forma de Pago';
  document.getElementById('formFormaPago').reset();
  document.getElementById('codigoFormaPago').readOnly = false;
  $('#modalFormaPago').modal('show');
});

// Guardar o actualizar forma de pago
document.getElementById('formFormaPago').addEventListener('submit', async function (e) {
  e.preventDefault();
  const codigo = document.getElementById('codigoFormaPago').value.trim();
  const nombre = document.getElementById('nombreFormaPago').value.trim();

  if (!codigo || !nombre) {
    Swal.fire({
      icon: 'warning',
      title: 'Campos requeridos',
      text: 'Código y nombre son obligatorios.',
      confirmButtonColor: '#B5121B'
    });
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
    await renderFormasPagoTable();
    Swal.fire({
      icon: 'success',
      title: 'Éxito',
      text: res.mensaje || 'Operación realizada correctamente',
      confirmButtonColor: '#B5121B'
    });
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: res.mensaje || 'No se pudo completar la operación',
      confirmButtonColor: '#B5121B'
    });
  }
});

// Editar forma de pago
window.editarFormaPago = async function (codigo) {
  const formas = await listarFormasPago();
  const forma = formas.find(f => f.CODIGO === codigo);
  if (!forma) return;

  document.getElementById('modalFormaPagoLabel').textContent = 'Editar Forma de Pago';
  document.getElementById('codigoFormaPago').value = forma.CODIGO;
  document.getElementById('codigoFormaPago').readOnly = true;
  document.getElementById('nombreFormaPago').value = forma.NOMBRE;
  $('#modalFormaPago').modal('show');
}

// Eliminar forma de pago con confirmación SweetAlert2
window.eliminarFormaPagoConfirm = async function (codigo) {
  const result = await Swal.fire({
    title: '¿Eliminar forma de pago?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#B5121B',
    cancelButtonColor: '#888'
  });

  if (result.isConfirmed) {
    const res = await eliminarFormaPago(codigo);
    if (res.tipo === 'success') {
      await renderFormasPagoTable();
      Swal.fire({
        icon: 'success',
        title: 'Eliminado',
        text: res.mensaje || 'Forma de pago eliminada correctamente',
        confirmButtonColor: '#B5121B'
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: res.mensaje || 'No se pudo eliminar la forma de pago',
        confirmButtonColor: '#B5121B'
      });
    }
  }
}

// Inicializar
$(document).ready(function () {
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
