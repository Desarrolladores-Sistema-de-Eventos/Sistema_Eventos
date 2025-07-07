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

  if (!requisitos || requisitos.length === 0) {
    tbody.innerHTML = '<tr><td colspan="2">No hay requisitos registrados.</td></tr>';
    return;
  }

  requisitos.forEach(req => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${req.DESCRIPCION}</td>
      <td>
        <button class="btn btn-primary btn-sm" onclick="editarRequisito(${req.SECUENCIAL})"><i class="fa fa-edit"></i></button>
        <button class="btn btn-danger btn-sm" onclick="eliminarRequisitoConfirm(${req.SECUENCIAL})"><i class="fa fa-trash"></i></button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

// Abrir modal para agregar requisito
document.getElementById('btnAgregarRequisito').addEventListener('click', function () {
  document.getElementById('modalRequisitoLabel').textContent = 'Agregar Requisito';
  document.getElementById('formRequisito').reset();
  document.getElementById('requisitoId').value = '';
  $('#modalRequisito').modal('show');
});

// Guardar o actualizar requisito
document.getElementById('formRequisito').addEventListener('submit', async function (e) {
  e.preventDefault();
  const id = document.getElementById('requisitoId').value;
  const descripcion = document.getElementById('descripcionRequisito').value.trim();

  if (!descripcion) {
    Swal.fire({
      icon: 'warning',
      title: 'Campo requerido',
      text: 'La descripción es obligatoria',
      confirmButtonColor: '#B5121B'
    });
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
    await renderRequisitosTable();
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

// Editar requisito
window.editarRequisito = async function (id) {
  const requisitos = await listarRequisitosEvento();
  const req = requisitos.find(r => r.SECUENCIAL == id);
  if (!req) return;

  document.getElementById('modalRequisitoLabel').textContent = 'Editar Requisito';
  document.getElementById('requisitoId').value = req.SECUENCIAL;
  document.getElementById('descripcionRequisito').value = req.DESCRIPCION;
  $('#modalRequisito').modal('show');
}

// Eliminar requisito con confirmación
window.eliminarRequisitoConfirm = async function (id) {
  const result = await Swal.fire({
    title: '¿Eliminar requisito?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#B5121B',
    cancelButtonColor: '#888'
  });

  if (result.isConfirmed) {
    const res = await eliminarRequisitoEvento(id);
    if (res.tipo === 'success') {
      await renderRequisitosTable();
      Swal.fire({
        icon: 'success',
        title: 'Eliminado',
        text: res.mensaje || 'Requisito eliminado correctamente',
        confirmButtonColor: '#B5121B'
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: res.mensaje || 'No se pudo eliminar el requisito',
        confirmButtonColor: '#B5121B'
      });
    }
  }
}

// Inicializar DataTable
$(document).ready(function () {
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
