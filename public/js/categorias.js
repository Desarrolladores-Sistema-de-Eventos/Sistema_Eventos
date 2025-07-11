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

// ================= CRUD CATEGORIA EVENTO =================
async function listarCategoriasEvento() {
  return await getConfig('categoria_evento_listar');
}
async function guardarCategoriaEvento(categoria) {
  return await postConfig('categoria_evento_guardar', categoria);
}
async function actualizarCategoriaEvento(categoria) {
  return await postConfig('categoria_evento_actualizar', categoria);
}
async function eliminarCategoriaEvento(id) {
  return await postConfig('categoria_evento_eliminar', { id });
}

// Renderizar tabla de categorías
async function renderCategoriasTable() {
  const categorias = await listarCategoriasEvento();
  const tbody = document.querySelector('#tablaCategorias tbody');
  tbody.innerHTML = '';

  if (!categorias || categorias.length === 0) {
    tbody.innerHTML = '<tr><td colspan="3">No hay categorías registradas.</td></tr>';
    return;
  }

  categorias.forEach(cat => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${cat.NOMBRE}</td>
      <td>${cat.DESCRIPCION || ''}</td>
      <td>
        <button class="btn btn-primary btn-sm" onclick="editarCategoria(${cat.SECUENCIAL})"><i class="fa fa-edit"></i></button>
        <button class="btn btn-danger btn-sm" onclick="eliminarCategoriaConfirm(${cat.SECUENCIAL})"><i class="fa fa-trash"></i></button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

// Abrir modal para agregar categoría
document.getElementById('btnAgregarCategoria').addEventListener('click', () => {
  document.getElementById('modalCategoriaLabel').textContent = 'Agregar Categoría';
  document.getElementById('formCategoria').reset();
  document.getElementById('categoriaId').value = '';
  $('#modalCategoria').modal('show');
});

// Guardar o actualizar categoría
document.getElementById('formCategoria').addEventListener('submit', async function (e) {
  e.preventDefault();
  const id = document.getElementById('categoriaId').value;
  const nombre = document.getElementById('nombreCategoria').value.trim();
  const descripcion = document.getElementById('descripcionCategoria').value.trim();

  if (!nombre) {
    Swal.fire("Advertencia", "El nombre es obligatorio.", "warning");
    return;
  }

  const data = { nombre, descripcion };
  let res;

  if (id) {
    data.id = id;
    res = await actualizarCategoriaEvento(data);
  } else {
    res = await guardarCategoriaEvento(data);
  }

  if (res.tipo === 'success') {
    $('#modalCategoria').modal('hide');
    await renderCategoriasTable();
    Swal.fire("Éxito", res.mensaje || "Operación realizada correctamente", "success");
  } else {
    Swal.fire("Error", res.mensaje || "No se pudo completar la operación", "error");
  }
});

// Editar categoría
window.editarCategoria = async function (id) {
  const categorias = await listarCategoriasEvento();
  const cat = categorias.find(c => c.SECUENCIAL == id);
  if (!cat) return;

  document.getElementById('modalCategoriaLabel').textContent = 'Editar Categoría';
  document.getElementById('categoriaId').value = cat.SECUENCIAL;
  document.getElementById('nombreCategoria').value = cat.NOMBRE;
  document.getElementById('descripcionCategoria').value = cat.DESCRIPCION || '';
  $('#modalCategoria').modal('show');
}

// Eliminar categoría con confirmación SweetAlert2
window.eliminarCategoriaConfirm = async function (id) {
  const result = await Swal.fire({
    title: "¿Eliminar categoría?",
    text: "Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  });

  if (result.isConfirmed) {
    const res = await eliminarCategoriaEvento(id);
    if (res.tipo === 'success') {
      await renderCategoriasTable();
      Swal.fire("Eliminado", res.mensaje || "Categoría eliminada correctamente", "success");
    } else {
      Swal.fire("Error", res.mensaje || "No se pudo eliminar la categoría", "error");
    }
  }
}

// Inicializar
$(document).ready(function () {
  renderCategoriasTable().then(() => {
    if ($.fn.DataTable.isDataTable('#tablaCategorias')) {
      $('#tablaCategorias').DataTable().destroy();
    }
    $('#tablaCategorias').DataTable({
      language: {
        url: '../public/js/es-ES.json'
      }
    });
  });
});
