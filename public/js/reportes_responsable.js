document.addEventListener("DOMContentLoaded", () => {
  const tipoSelect = document.getElementById("tipoReporte");
  const eventoSelect = document.getElementById("eventoSeleccionado");
  const form = document.getElementById("formReporte");
  const resultado = document.getElementById("resultado");

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
        option.textContent = `${e.TITULO}`;
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

      // Siempre usar data.detalle si existe, si no, usar data como array
      if (data.detalle && Array.isArray(data.detalle)) {
        detalle = data.detalle;
      } else if (Array.isArray(data)) {
        detalle = data;
      } else {
        detalle = [];
      }

      if (data.totalRecaudado !== undefined) {
        total = data.totalRecaudado;
      }

      if (!Array.isArray(detalle) || detalle.length === 0) {
        resultado.innerHTML = `<div class="alert alert-warning">⚠️ No hay resultados para este reporte.</div>`;
        return;
      }

      // Obtener si el evento es un curso (se asume que el backend puede enviar esta info, si no, se puede consultar por AJAX)
      let esCurso = false;
      if (data.tipo_evento) {
        esCurso = data.tipo_evento.toLowerCase() === 'curso';
      } else if (detalle[0] && detalle[0].tipo_evento) {
        esCurso = String(detalle[0].tipo_evento).toLowerCase() === 'curso';
      }

      // Filtrar columnas: si no es curso, quitamos nota_final y mostramos solo % de asistencia si existe
      let columnas = Object.keys(detalle[0]);
      if (!esCurso) {
        // Elimina todas las variantes de nota_final (mayúsculas/minúsculas)
        columnas = columnas.filter(col => col.toLowerCase() !== 'nota_final' && col.toLowerCase() !== 'notafinal');
        // Elimina también la columna PORCENTAJE_ASISTENCIA si existe (para evitar duplicidad)
        columnas = columnas.filter(col => col.toLowerCase() !== 'porcentaje_asistencia');
        // Solo agrega la columna porcentaje_asistencia para mostrarla como % de Asistencia
        if (detalle[0].hasOwnProperty('porcentaje_asistencia')) {
          columnas.push('porcentaje_asistencia');
        }
      }

      // Validación: si el evento no es pagado, mostrar "Gratis" en Monto Pagado
      let esPagado = true;
      if (data.eventoInfo && data.eventoInfo.ES_PAGADO !== undefined) {
        esPagado = data.eventoInfo.ES_PAGADO == 1;
      } else if (data.es_pagado !== undefined) {
        esPagado = data.es_pagado == 1;
      }
      // Si no es pagado, reemplazar el valor de la columna correspondiente
      if (!esPagado && columnas.some(col => col.toLowerCase() === 'monto_pagado')) {
        detalle = detalle.map(fila => {
          let copia = { ...fila };
          Object.keys(copia).forEach(col => {
            if (col.toLowerCase() === 'monto_pagado') {
              copia[col] = 'Gratis';
            }
          });
          return copia;
        });
      }

      function capitalizar(str) {
        let texto = str.replace(/_/g, ' ');
        texto = texto.replace(/([a-záéíóúñ])([A-ZÁÉÍÓÚÑ])/g, '$1 $2');
        texto = texto.toLowerCase().replace(/(^|\s)([a-záéíóúñ])/g, (m, p1, p2) => p1 + p2.toUpperCase());
        return texto;
      }
      let html = `
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tablaReporte">
          <thead><tr>${columnas.map(col => {
            if (!esCurso && col === 'porcentaje_asistencia') {
              return `<th class="text-center">% de Asistencia</th>`;
            }
            return `<th class="text-center">${capitalizar(col)}</th>`;
          }).join('')}</tr></thead>
            <tbody>
            ${detalle.map(fila => `<tr>${columnas.map(col => {
              if (!esCurso && col === 'porcentaje_asistencia') {
                return `<td class="text-center">${fila[col] !== undefined ? fila[col] + '%' : ''}</td>`;
              }
              return `<td class="text-center">${fila[col] ?? ''}</td>`;
            }).join('')}</tr>`).join('')}
            </tbody>
          </table>
        </div>
      `;

      if (total !== null && total !== undefined) {
        html += `<div class="mt-2 text-end fw-bold"> Total recaudado: $${parseFloat(total).toFixed(2)}</div>`;
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
