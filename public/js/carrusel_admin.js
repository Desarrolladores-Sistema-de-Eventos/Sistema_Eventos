document.addEventListener("DOMContentLoaded", () => {
  cargarCarrusel();

  const form = document.getElementById("formCarrusel");
  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const res = await fetch("../controllers/CarruselController.php?accion=crear", {
        method: "POST",
        body: formData
      });

      const data = await res.json();

      if (data.success) {
        Swal.fire("Éxito", "Imagen agregada al carrusel", "success");
        form.reset();
        cargarCarrusel(true); // true para indicar que destaque fila
      } else {
        Swal.fire("Error", data.mensaje || "No se pudo agregar la imagen", "error");
      }
    } catch (err) {
      console.error("Error en creación de carrusel:", err);
      Swal.fire("Error", "Ocurrió un problema con el servidor", "error");
    }
  });
});

async function cargarCarrusel(destacarUltima = false) {
  const contenedor = document.getElementById("contenedorCarrusel");

  try {
    const res = await fetch("../controllers/CarruselController.php?accion=listar");
    const data = await res.json();

    contenedor.innerHTML = "";

    if (!data || data.length === 0) {
      contenedor.innerHTML = "<tr><td colspan='5'>No hay imágenes en el carrusel.</td></tr>";
      return;
    }

    data.forEach((item, index) => {
      const fila = document.createElement("tr");
      fila.innerHTML = `
        <td>${index + 1}</td>
        <td><img src="../${item.URL_IMAGEN}" style="width: 100px; border-radius: 8px;" alt="imagen"></td>
        <td>${item.TITULO}</td>
        <td>${item.DESCRIPCION || "-"}</td>
        <td>
          <button class="btn btn-warning btn-sm" onclick="mostrarEditarCarrusel(${item.SECUENCIAL}, '${item.TITULO}', '${item.DESCRIPCION || ""}')">Editar</button>
          <button class="btn btn-danger btn-sm" onclick="eliminarCarrusel(${item.SECUENCIAL})">Eliminar</button>
        </td>
      `;

      if (destacarUltima && index === data.length - 1) {
        fila.classList.add("table-success");
        setTimeout(() => fila.classList.remove("table-success"), 3000);
      }

      contenedor.appendChild(fila);
    });
  } catch (err) {
    console.error("Error al cargar carrusel:", err);
    contenedor.innerHTML = "<tr><td colspan='5'>Error al cargar carrusel.</td></tr>";
  }
}

function eliminarCarrusel(id) {
  Swal.fire({
    title: "¿Eliminar imagen del carrusel?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar"
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const res = await fetch("../controllers/CarruselController.php?accion=eliminar", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `id=${id}`
        });

        const data = await res.json();

        if (data.success) {
          Swal.fire("Eliminado", "Imagen eliminada del carrusel", "success");
          cargarCarrusel();
        } else {
          Swal.fire("Error", data.mensaje || "No se pudo eliminar", "error");
        }
      } catch (err) {
        console.error("Error al eliminar imagen:", err);
        Swal.fire("Error", "Problema al eliminar la imagen", "error");
      }
    }
  });
}

function mostrarEditarCarrusel(id, titulo, descripcion) {
  document.getElementById('editId').value = id;
  document.getElementById('editTitulo').value = titulo;
  document.getElementById('editDescripcion').value = descripcion;
  $('#modalEditarCarrusel').modal('show');
}

document.getElementById('formEditarCarrusel').addEventListener('submit', function(e) {
  e.preventDefault();
  const form = new FormData(this);

  fetch('../controllers/CarruselController.php?accion=editar', {
    method: 'POST',
    body: form
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      $('#modalEditarCarrusel').modal('hide');
      Swal.fire("Guardado", "Cambios actualizados correctamente", "success");
      cargarCarrusel();
    } else {
      Swal.fire("Error", "Error al editar la imagen", "error");
    }
  })
  .catch(err => {
    console.error("Error en edición:", err);
    Swal.fire("Error", "Ocurrió un problema al editar", "error");
  });
});
