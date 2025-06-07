document.addEventListener("DOMContentLoaded", () => {
  const tipoSelect = document.getElementById("tipoReporte");
  const eventoSelect = document.getElementById("eventoSeleccionado");
  const form = document.getElementById("formReporte");
  const resultado = document.getElementById("resultado");

  // 🔁 Cargar eventos del responsable
  fetch("../controllers/ReportesController.php?option=eventosResponsable")
    .then(res => res.json())
    .then(eventos => {
      eventoSelect.innerHTML = '<option value="">Seleccione un evento</option>';

      if (!Array.isArray(eventos)) {
        throw new Error("Respuesta inválida al obtener eventos");
      }

      eventos.forEach(e => {
        const option = document.createElement("option");
        option.value = e.SECUENCIAL;
        option.textContent = `${e.TITULO} (ID ${e.SECUENCIAL})`;
        eventoSelect.appendChild(option);
      });
    })
    .catch(error => {
      console.error("Error al cargar eventos:", error);
      Swal.fire("Error", "No se pudieron cargar los eventos", "error");
    });

  // 🔁 Manejo del formulario de reportes
  form.addEventListener("submit", function (e) {
  e.preventDefault();
  const tipo = tipoSelect.value;
  const evento = eventoSelect.value;

  if (!tipo || !evento) {
    Swal.fire("Error", "Debe seleccionar tipo de reporte y evento", "warning");
    return;
  }

  fetch(`../controllers/ReportesController.php?tipo=${tipo}&evento=${evento}`)
    .then(res => res.json())
    .then(data => {
  let detalle = [];
  let total = null;

  if (tipo === "financiero" || tipo === "general") {
    detalle = data.detalle;
    total = data.totalRecaudado;
  } else if (Array.isArray(data)) {
    detalle = data;
  }

  if (!Array.isArray(detalle) || detalle.length === 0) {
    resultado.innerHTML = `<div class="alert alert-warning">⚠️ No hay resultados para este reporte.</div>`;
    return;
  }

  const columnas = Object.keys(detalle[0]);
  let html = `
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="tablaReporte">
      <thead><tr>${columnas.map(col => `<th class="text-center">${col.replace(/_/g, ' ').toUpperCase()}</th>`).join('')}</tr></thead>
        <tbody>
        ${detalle.map(fila => `<tr>${columnas.map(col => `<td class="text-center">${fila[col] ?? ''}</td>`).join('')}</tr>`).join('')}
        </tbody>
      </table>
    </div>
  `;

  if ((tipo === "financiero" || tipo === "general") && total !== null) {
    html += `<div class="mt-2 text-end fw-bold">💰 Total recaudado: $${parseFloat(total).toFixed(2)}</div>`;
  }

  resultado.innerHTML = html;

  if (window.jQuery && $.fn.DataTable) {
    $('#tablaReporte').DataTable({
      language: {
        url: '../public/js/es-ES.json'
      }
    });
  }
})

    .catch(error => {
      console.error("Error al generar el reporte:", error);
      Swal.fire("Error", "Ocurrió un error al generar el reporte", "error");
    });
});

});

// 📤 Exportar a PDF
function exportarPDF() {
  const tipo = document.getElementById("tipoReporte").value;
  const evento = document.getElementById("eventoSeleccionado").value;

  if (!tipo || !evento) {
    Swal.fire("Atención", "Debe seleccionar el tipo de reporte y el evento", "warning");
    return;
  }

  // ✅ Llama al mismo controlador con parámetro ?formato=pdf
  window.open(`../controllers/ReportesController.php?tipo=${tipo}&evento=${evento}&formato=pdf`, '_blank');
}
