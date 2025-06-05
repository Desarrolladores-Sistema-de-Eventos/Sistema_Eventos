console.log("✅ main.js cargado");

document.addEventListener('DOMContentLoaded', () => {
  console.log("🧪 DOM completamente cargado");
  cargarInscripcionesPendientesResponsable();
  cargarGraficoEstados();
  cargarGraficoEventos();
  cargarGraficoCertificados();
  cargarMetricasTotales();
});

// === MÉTRICAS ===
function cargarMetricasTotales() {
  // Total de inscritos (solo los ACEPTADOS)
  axios.get('../controllers/InscripcionesController.php?option=contarInscritos')
    .then(res => {
      document.getElementById('total-inscritos').textContent = res.data.total || 0;
    });

  // Total de pendientes y rechazados (para íconos)
  axios.get('../controllers/InscripcionesController.php?option=graficoEstados')
    .then(res => {
      const totales = { PEN: 0, REC: 0 };

      res.data.forEach(e => {
        if (e.CODIGOESTADOINSCRIPCION === 'PEN') totales.PEN = parseInt(e.total);
        if (e.CODIGOESTADOINSCRIPCION === 'REC') totales.REC = parseInt(e.total);
      });

      document.getElementById('total-pendientes').textContent = totales.PEN || 0;
      document.getElementById('total-reportes').textContent = totales.REC || 0;
    })
    .catch(() => {
      document.getElementById('total-pendientes').textContent = '0';
      document.getElementById('total-reportes').textContent = '0';
    });

  // Total de eventos
  axios.get('../controllers/InscripcionesController.php?option=contarEventos')
    .then(res => {
      document.getElementById('total-eventos').textContent = res.data.total || 0;
    })
    .catch(() => {
      document.getElementById('total-eventos').textContent = '0';
    });
}


// === INSCRIPCIONES PENDIENTES ===
function cargarInscripcionesPendientesResponsable() {
  const tbody = document.querySelector('#tabla-pendientes tbody');
  if ($.fn.DataTable.isDataTable('#tabla-pendientes')) {
    $('#tabla-pendientes').DataTable().destroy();
  }

  tbody.innerHTML = '<tr><td colspan="5">Cargando...</td></tr>';

  axios.get('../controllers/InscripcionesController.php?option=listarPendientesResponsable')
    .then(res => {
      const data = res.data;

      if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5">No hay inscripciones pendientes.</td></tr>';
        return;
      }

      tbody.innerHTML = data.map(item => {
        const facturaHtml = item.FACTURA
          ? `<a href="../facturas/${item.FACTURA}" target="_blank">Ver factura</a>`
          : `<input type="file" accept=".pdf,.jpg,.png" onchange="subirFactura(this.files[0], ${item.INSCRIPCION_ID})">`;

        return `
          <tr>
            <td>${item.NOMBRE_COMPLETO}</td>
            <td>${item.EVENTO}</td>
            <td>
              <select onchange="actualizarEstadoInscripcion(this.value, ${item.INSCRIPCION_ID})" class="form-control">
                <option value="PEN" ${item.CODIGOESTADOINSCRIPCION === 'PEN' ? 'selected' : ''}>Pendiente</option>
                <option value="ACE" ${item.CODIGOESTADOINSCRIPCION === 'ACE' ? 'selected' : ''}>Aceptado</option>
                <option value="REC" ${item.CODIGOESTADOINSCRIPCION === 'REC' ? 'selected' : ''}>Rechazado</option>
              </select>
            </td>
            <td>${facturaHtml}</td>
            <td class="text-center">
              <button class="btn btn-info btn-sm" onclick="verDetalleInscripcion(${item.INSCRIPCION_ID})">
                <i class="fa fa-eye" style="color: black;"></i> Ver Detalle
              </button>
            </td>
          </tr>
        `;
      }).join('');

      // Re-inicializar
      $('#tabla-pendientes').DataTable({
        language: { url: '../public/js/es-ES.json' },
        destroy: true
      });
    })
    .catch(err => {
      console.error('❌ Error al cargar inscripciones pendientes:', err);
      tbody.innerHTML = '<tr><td colspan="5">Error al cargar datos.</td></tr>';
    });
}


function actualizarEstadoInscripcion(estado, id) {
  axios.post('../controllers/InscripcionesController.php?option=estadoInscripcion', new URLSearchParams({ id, estado }))
    .then(res => {
      if (res.data.tipo === 'success') {
        Swal.fire({ icon: 'success', title: 'Estado actualizado', timer: 1000, showConfirmButton: false });
        cargarInscripcionesPendientesResponsable();
        cargarMetricasTotales();         
        cargarGraficoEstados(); 
        cargarGraficoEventos(); 
      } else {
        Swal.fire('Error', 'No se pudo actualizar el estado', 'error');
      }
    })
    .catch(() => Swal.fire('Error', 'Ocurrió un problema al actualizar', 'error'));
}

function subirFactura(file, idInscripcion) {
  if (!file) return;
  const formData = new FormData();
  formData.append('factura', file);
  formData.append('id', idInscripcion);

  axios.post('../controllers/InscripcionesController.php?option=subirFactura', formData)
    .then(res => {
      if (res.data.tipo === 'success') {
        Swal.fire({ icon: 'success', title: 'Factura subida', timer: 1000, showConfirmButton: false });
        cargarInscripcionesPendientesResponsable();
      } else {
        Swal.fire('Error', res.data.mensaje || 'No se pudo subir la factura', 'error');
      }
    })
    .catch(() => Swal.fire('Error', 'Error en el servidor', 'error'));
}

// === GRÁFICOS ===
let graficoEstadosChart = null; // Variable global para el gráfico

function cargarGraficoEstados() {
  const canvas = document.getElementById('graficoEstados');
  if (!canvas) return;

  axios.get('../controllers/InscripcionesController.php?option=graficoEstados')
    .then(res => {
      const estados = res.data;

      // ✅ Destruir el gráfico anterior si existe
      if (graficoEstadosChart) {
        graficoEstadosChart.destroy();
      }

      // ✅ Crear nuevo gráfico
      graficoEstadosChart = new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: {
          labels: estados.map(e => e.CODIGOESTADOINSCRIPCION),
          datasets: [{
            data: estados.map(e => parseInt(e.total)),
            backgroundColor: ['#f39c12', '#27ae60', '#e74c3c', '#8e44ad']
          }]
        },
        options: {
          plugins: {
            title: { display: true, text: 'Estados de Inscripción' }
          }
        }
      });
    });
}

let graficoEventosChart = null;

function cargarGraficoEventos() {
  const canvas = document.getElementById('graficoEventos');
  if (!canvas) return;

  axios.get('../controllers/InscripcionesController.php?option=graficoPorEvento')
    .then(res => {
      const eventos = res.data;

      const data = {
        labels: eventos.map(e => e.TITULO),
        datasets: [{
          data: eventos.map(e => parseInt(e.total)),
          backgroundColor: ['#3498db', '#9b59b6', '#2ecc71', '#e67e22', '#e74c3c']
        }]
      };

      // 👉 Destruye gráfico anterior si existe
      if (graficoEventosChart) {
        graficoEventosChart.destroy();
      }

      graficoEventosChart = new Chart(canvas.getContext('2d'), {
        type: 'pie',
        data: data,
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: 'Inscripciones por Evento'
            }
          }
        }
      });
    });
}



function cargarGraficoCertificados() {
  const canvas = document.getElementById('graficoCertificados');
  if (!canvas) return;

  axios.get('../controllers/InscripcionesController.php?option=graficoCertificados')
    .then(res => {
      const eventos = res.data;
      new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
          labels: eventos.map(e => e.TITULO),
          datasets: [{
            label: 'Certificados emitidos',
            data: eventos.map(e => parseInt(e.total)),
            fill: true,
            borderColor: '#3498db',
            backgroundColor: 'rgba(52, 152, 219, 0.2)'
          }]
        }
      });
    });
}

// === Mostrar detalle de inscripción ===
function verDetalleInscripcion(idInscripcion) {
  axios.get(`../controllers/InscripcionesController.php?option=detalleInscripcion&id=${idInscripcion}`)
    .then(async res => {
      const data = res.data;

      if (!data || !data.inscripcion) {
        Swal.fire('Error', 'No se pudo cargar el detalle.', 'error');
        return;
      }

      // Llenar campos principales
      document.getElementById('detalleNombre').textContent = data.inscripcion.NOMBRE_COMPLETO;
      document.getElementById('detalleEvento').textContent = data.inscripcion.EVENTO;
      document.getElementById('detalleIdInscripcion').value = data.inscripcion.INSCRIPCION_ID;

      // === Mostrar requisitos ===
      const tbodyReq = document.querySelector('#tabla-requisitos-detalle tbody');
      tbodyReq.innerHTML = '';

      data.requisitos.forEach(r => {
        tbodyReq.innerHTML += `
          <tr>
            <td>${r.REQUISITO}</td>
            <td><a href="../archivos/${r.ARCHIVO}" target="_blank">Ver archivo</a></td>
            <td>
              <select class="form-control" onchange="validarArchivoRequisito(${r.ARCHIVO_ID}, this.value)">
                <option value="PEN" ${r.ESTADO === 'PEN' ? 'selected' : ''}>Pendiente</option>
                <option value="VAL" ${r.ESTADO === 'VAL' ? 'selected' : ''}>Validado</option>
                <option value="RECH" ${r.ESTADO === 'RECH' ? 'selected' : ''}>Rechazado</option>
                <option value="INV" ${r.ESTADO === 'INV' ? 'selected' : ''}>Inválido</option>
              </select>
            </td>
          </tr>
        `;
      });

      // === Mostrar pagos ===
      const pagosRes = await axios.get(`../controllers/InscripcionesController.php?option=pagosPorInscripcion&id=${idInscripcion}`);
      const pagos = pagosRes.data || [];

      const tbodyPagos = document.querySelector('#tabla-pagos-detalle tbody');
      tbodyPagos.innerHTML = '';

      pagos.forEach(p => {
        tbodyPagos.innerHTML += `
          <tr>
            <td><a href="../comprobantes/${p.COMPROBANTE_URL}" target="_blank">Ver comprobante</a></td>
            <td>${p.FORMA_PAGO || 'Desconocida'}</td>
            <td>
              <select class="form-control" onchange="actualizarEstadoPago(${p.PAGO_ID}, this.value)">
                <option value="PEN" ${p.CODIGOESTADOPAGO === 'PEN' ? 'selected' : ''}>Pendiente</option>
                <option value="APR" ${p.CODIGOESTADOPAGO === 'APR' ? 'selected' : ''}>Aprobado</option>
                <option value="RECH" ${p.CODIGOESTADOPAGO === 'RECH' ? 'selected' : ''}>Rechazado</option>
                <option value="INV" ${p.CODIGOESTADOPAGO === 'INV' ? 'selected' : ''}>Inválido</option>
              </select>
            </td>
            <td>${p.FECHA_PAGO || '-'}</td>
          </tr>
        `;
      });

      // Mostrar modal
      $('#modalDetalleInscripcion').modal('show');
    })
    .catch(() => {
      Swal.fire('Error', 'No se pudo cargar el detalle.', 'error');
    });
}



function validarArchivoRequisito(idArchivo, estado) {
  axios.post('../controllers/InscripcionesController.php?option=estadoRequisito', new URLSearchParams({ id: idArchivo, estado }))
    .then(res => {
      if (res.data.tipo === 'success') {
        Swal.fire({ icon: 'success', title: 'Requisito actualizado', timer: 1000, showConfirmButton: false });
      } else {
        Swal.fire('Error', 'No se pudo actualizar el requisito', 'error');
      }
    })
    .catch(() => Swal.fire('Error', 'Ocurrió un problema con el servidor', 'error'));
}

document.getElementById('formDetalleInscripcion').addEventListener('submit', function (e) {
  e.preventDefault();
  const id = document.getElementById('detalleIdInscripcion').value;
  const estado = document.getElementById('estadoInscripcionDetalle').value;

  axios.post('../controllers/InscripcionesController.php?option=estadoInscripcion', new URLSearchParams({ id, estado }))
    .then(res => {
      if (res.data.tipo === 'success') {
        Swal.fire({ icon: 'success', title: 'Inscripción actualizada', timer: 1000, showConfirmButton: false });
        $('#modalDetalleInscripcion').modal('hide');
        cargarInscripcionesPendientesResponsable();
      } else {
        Swal.fire('Error', 'No se pudo actualizar el estado', 'error');
      }
    })
    .catch(() => Swal.fire('Error', 'Ocurrió un problema al guardar', 'error'));
});

function actualizarEstadoPago(idPago, nuevoEstado) {
  axios.post('../controllers/InscripcionesController.php?option=estadoPago', new URLSearchParams({
    id: idPago,
    estado: nuevoEstado
  }))
  .then(res => {
    if (res.data.tipo === 'success') {
      Swal.fire({
        icon: 'success',
        title: 'Estado actualizado',
        timer: 1000,
        showConfirmButton: false
      });

      // Si el estado fue cambiado a "Aprobado", recargar la tabla de pendientes
      if (nuevoEstado === 'APR') {
        $('#modalDetalleInscripcion').modal('hide');
        cargarInscripcionesPendientesResponsable();
        cargarMetricasTotales();         // ✅ ACTUALIZAR MÉTRICAS
        cargarGraficoEstados(); 
      }
    } else {
      Swal.fire('Error', 'No se pudo actualizar el estado del pago', 'error');
    }
  })
  .catch(() => {
    Swal.fire('Error', 'Ocurrió un problema al actualizar el estado', 'error');
  });
}
