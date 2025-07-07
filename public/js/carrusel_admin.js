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
        form.reset();
        Swal.fire({
          title: "Éxito",
          text: "Imagen agregada al carrusel",
          icon: "success",
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          // Destruir DataTable y limpiar tbody antes de recargar
          const tabla = $('#tabla-carrusel');
          if ($.fn.DataTable.isDataTable(tabla)) {
            tabla.DataTable().destroy();
          }
          document.getElementById("contenedorCarrusel").innerHTML = "";
          cargarCarrusel(true); // true para indicar que destaque fila
        });
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
      // Destruir DataTable si existe
      const tabla = $('#tabla-carrusel');
      if ($.fn.DataTable.isDataTable(tabla)) {
        tabla.DataTable().destroy();
      }
      return;
    }

    data.forEach((item, index) => {
      const fila = document.createElement("tr");
      // Escapar comillas simples y dobles para atributos HTML JS
      const safeTitulo = String(item.TITULO).replace(/'/g, "&#39;").replace(/\"/g, '&quot;');
      const safeDescripcion = String(item.DESCRIPCION || "-").replace(/'/g, "&#39;").replace(/\"/g, '&quot;');
      fila.innerHTML =
        `<td>${index + 1}</td>` +
        `<td><img src="../${item.URL_IMAGEN}" style="width: 100px; border-radius: 8px;" alt="imagen"></td>` +
        `<td>${safeTitulo}</td>` +
        `<td>${safeDescripcion}</td>` +
        `<td style="display: flex; justify-content: center; gap: 8px; align-items: center;">` +
          `<button class="btn btn-secondary d-flex align-items-center justify-content-center" style="background-color: #e0e0e0; color: #333; border-radius: 8px; width: 36px; height: 36px; border: none;" title="Editar" onclick="mostrarEditarCarrusel(${item.SECUENCIAL}, '${safeTitulo}', '${safeDescripcion}')">` +
            `<i class=\"fa fa-edit\" style=\"color: #333; font-size: 18px;\"></i>` +
          `</button>` +
          `<button class="btn btn-secondary d-flex align-items-center justify-content-center" style="background-color: #e0e0e0; color: #333; border-radius: 8px; width: 36px; height: 36px; border: none;" title="Eliminar" onclick="eliminarCarrusel(${item.SECUENCIAL})">` +
            `<i class=\"fa fa-trash\" style=\"color: #333; font-size: 18px;\"></i>` +
          `</button>` +
        `</td>`;

      if (destacarUltima && index === data.length - 1) {
        fila.classList.add("table-success");
        setTimeout(() => fila.classList.remove("table-success"), 3000);
      }

      contenedor.appendChild(fila);
    });

    // Forzar refresco visual de la tabla (reflow)
    const tabla = $('#tabla-carrusel');
    if ($.fn.DataTable.isDataTable(tabla)) {
      tabla.DataTable().destroy();
    }
    setTimeout(() => {
      tabla.DataTable({
        language: {
          url: '../public/js/es-ES.json'
        },
        lengthChange: true,
        responsive: true
      });
    }, 100); // Pequeño retraso para asegurar el reflow visual
  } catch (err) {
    console.error("Error al cargar carrusel:", err);
    contenedor.innerHTML = "<tr><td colspan='5'>Error al cargar carrusel.</td></tr>";
    // Destruir DataTable si existe
    const tabla = $('#tabla-carrusel');
    if ($.fn.DataTable.isDataTable(tabla)) {
      tabla.DataTable().destroy();
    }
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
          // Destruir DataTable ANTES de modificar el DOM
          const tabla = $('#tabla-carrusel');
          if ($.fn.DataTable.isDataTable(tabla)) {
            tabla.DataTable().destroy();
          }
          // Limpiar el tbody
          document.getElementById("contenedorCarrusel").innerHTML = "";
          // Mostrar alerta y luego reconstruir la tabla
          Swal.fire("Eliminado", "Imagen eliminada del carrusel", "success").then(() => {
            cargarCarrusel();
          });
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
      Swal.fire({
        title: "Guardado",
        text: "Cambios actualizados correctamente",
        icon: "success",
        timer: 1500,
        showConfirmButton: false
      }).then(() => {
        // Destruir DataTable y limpiar tbody antes de recargar
        const tabla = $('#tabla-carrusel');
        if ($.fn.DataTable.isDataTable(tabla)) {
          tabla.DataTable().destroy();
        }
        document.getElementById("contenedorCarrusel").innerHTML = "";
        cargarCarrusel();
      });
    } else {
      Swal.fire("Error", "Error al editar la imagen", "error");
    }
  })
  .catch(err => {
    console.error("Error en edición:", err);
    Swal.fire("Error", "Ocurrió un problema al editar", "error");
  });
});
