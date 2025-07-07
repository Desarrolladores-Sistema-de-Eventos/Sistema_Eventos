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

  if (!tipos || tipos.length === 0) {
    tbody.innerHTML = '<tr><td colspan="4">No hay tipos de evento registrados.</td></tr>';
    return;
  }

  tipos.forEach(t => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${t.CODIGO}</td>
      <td>${t.NOMBRE}</td>
      <td>${t.DESCRIPCION || ''}</td>
      <td>
        <button class="btn btn-primary btn-sm" onclick="editarTipoEvento('${t.CODIGO}')"><i class="fa fa-edit"></i></button>
        <button class="btn btn-danger btn-sm" onclick="eliminarTipoEventoConfirm('${t.CODIGO}')"><i class="fa fa-trash"></i></button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

// Abrir modal para agregar tipo de evento
document.getElementById('btnAgregarTipoEvento').addEventListener('click', () => {
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
    // NUEVO: obtener valores de los checkboxes
    const REQUIERENOTA = document.getElementById('REQUIERENOTA').checked ? 1 : 0;
    const REQUIEREASISTENCIA = document.getElementById('REQUIEREASISTENCIA').checked ? 1 : 0;
    
    if (!codigo || !nombre) {
        Swal.fire("Advertencia", "Código y nombre son obligatorios.", "warning");
        return;
    }
    
    // Agregar los nuevos campos al objeto data
    const data = { codigo, nombre, descripcion, REQUIERENOTA, REQUIEREASISTENCIA };
    let res;
    
    if (document.getElementById('codigoTipoEvento').readOnly) {
        res = await actualizarTipoEvento(data);
    } else {
        res = await guardarTipoEvento(data);
    }
    
    if (res.tipo === 'success') {
        $('#modalTipoEvento').modal('hide');
        await renderTiposEventoTable();
        Swal.fire("Éxito", res.mensaje || "Operación realizada correctamente", "success");
    } else {
        Swal.fire("Error", res.mensaje || "No se pudo completar la operación", "error");
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
    // NUEVO: marcar los checkboxes según los valores guardados
    document.getElementById('REQUIERENOTA').checked = tipo.REQUIERENOTA == 1;
    document.getElementById('REQUIEREASISTENCIA').checked = tipo.REQUIEREASISTENCIA == 1;
    $('#modalTipoEvento').modal('show');
}

// Eliminar tipo de evento con confirmación
window.eliminarTipoEventoConfirm = async function (codigo) {
  const result = await Swal.fire({
    title: "¿Eliminar tipo de evento?",
    text: "Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  });

  if (result.isConfirmed) {
    const res = await eliminarTipoEvento(codigo);
    if (res.tipo === 'success') {
      await renderTiposEventoTable();
      Swal.fire("Eliminado", res.mensaje || "Tipo de evento eliminado", "success");
    } else {
      Swal.fire("Error", res.mensaje || "No se pudo eliminar el tipo de evento", "error");
    }
  }
}

// Inicializar tabla
$(document).ready(function () {
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
