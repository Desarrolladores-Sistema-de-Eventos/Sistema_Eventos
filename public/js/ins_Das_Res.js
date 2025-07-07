
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

  // Animación de cargando con spinner Bootstrap
  tbody.innerHTML = `
    <tr>
      <td colspan="4" style="text-align:center;">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Cargando...</span>
        </div>
        <div style="margin-top:8px;">Cargando inscripciones...</div>
      </td>
    </tr>
  `;

  axios.get('../controllers/InscripcionesController.php?option=listarPendientesResponsable')
    .then(res => {
      const data = res.data;

      if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4">No hay inscripciones pendientes.</td></tr>';
        return;
      }

      tbody.innerHTML = data.map(item => {
        // Badge de estado
        let estadoHtml = '';
        switch (item.CODIGOESTADOINSCRIPCION) {
          case 'ACE':
            estadoHtml = '<span class="badge" style="background: #0066cc;">Aceptado</span>';
            break;
          case 'PEN':
            estadoHtml = '<span class="badge" style="background: #ffc107; color: #212529;">Pendiente</span>';
            break;
          case 'REC':
            estadoHtml = '<span class="badge" style="background: #dc3545;">Rechazado</span>';
            break;
          case 'ANU':
            estadoHtml = '<span class="badge" style="background: #6c757d;">Anulado</span>';
            break;
          default:
            estadoHtml = '<span class="badge" style="background: #adb5bd;">Desconocido</span>';
        }
        return `
          <tr>
            <td>${item.NOMBRE_COMPLETO}</td>
            <td>${item.EVENTO}</td>
            <td>${estadoHtml}</td>
            <td class="text-center">
              <button class="btn btn-outline-dark btn-sm" style="background: #222; border-color: #222; color: #fff;" onclick="verDetalleInscripcion(${item.INSCRIPCION_ID})">
                <i class="fa fa-check" style="color: #fff;"></i> Validar
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
      tbody.innerHTML = '<tr><td colspan="4">Error al cargar datos.</td></tr>';
    });
}

// Función para abrir la factura dinámica en una nueva pestaña
function verFacturaDinamica(idInscripcion) {
  window.open(`../views/factura.php?id=${idInscripcion}`, '_blank');
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

// === GRÁFICOS ===

// Paleta institucional UTA: rojo, negro, blanco
const utaColors = {
  rojo: 'rgb(180, 34, 34)',
  negro: '#222',
  blanco: '#fff',
  gris: '#f4f4f4'
};

// === GRÁFICOS ===
let graficoEstadosChart = null; // Variable global para el gráfico

function cargarGraficoEstados() {
  const canvas = document.getElementById('graficoEstados');
  if (!canvas) return;

  axios.get('../controllers/InscripcionesController.php?option=graficoEstados')
    .then(res => {
      const estados = res.data;

      if (graficoEstadosChart) {
        graficoEstadosChart.destroy();
      }

      // Paleta para los estados (rojo, negro, blanco)
      const coloresEstados = [
        utaColors.rojo,
        utaColors.negro,
        utaColors.blanco
      ];

      graficoEstadosChart = new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: {
          labels: estados.map(e => e.CODIGOESTADOINSCRIPCION),
          datasets: [{
            data: estados.map(e => parseInt(e.total)),
            backgroundColor: coloresEstados,
            borderColor: utaColors.negro,
            borderWidth: 2
          }]
        },
        options: {
          plugins: {
            title: { display: true,  },
            legend: {
              labels: {
                color: utaColors.negro,
                font: { weight: 'bold' }
              }
            }
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

      // Paleta institucional para eventos
      const coloresEventos = [
        utaColors.rojo,
        utaColors.negro,
        utaColors.blanco,
        '#bdbdbd', // gris claro extra si hay más eventos
        '#ededed'
      ];

      const data = {
        labels: eventos.map(e => e.TITULO),
        datasets: [{
          data: eventos.map(e => parseInt(e.total)),
          backgroundColor: coloresEventos.slice(0, eventos.length),
          borderColor: utaColors.negro,
          borderWidth: 2
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
              display: true
            },
            legend: {
              labels: {
                color: utaColors.negro,
                font: { weight: 'bold' }
              }
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
            borderColor: utaColors.rojo,
            backgroundColor: 'rgba(155,46,46,0.15)',
            pointBackgroundColor: utaColors.negro,
            pointBorderColor: utaColors.rojo
          }]
        },
        options: {
          plugins: {
            legend: {
              labels: {
                color: utaColors.negro,
                font: { weight: 'bold' }
              }
            }
          },
          scales: {
            x: {
              ticks: { color: utaColors.negro }
            },
            y: {
              ticks: { color: utaColors.negro }
            }
          }
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
        const row = document.createElement('tr');
        // Celda requisito
        const tdReq = document.createElement('td');
        tdReq.textContent = r.REQUISITO;
        row.appendChild(tdReq);

        // Celda archivo (con búsqueda en 3 rutas)
        const tdArchivo = document.createElement('td');
        tdArchivo.textContent = 'Buscando archivo...';
        row.appendChild(tdArchivo);

        // Celda select
        const tdSelect = document.createElement('td');
        tdSelect.innerHTML = `
          <select class="form-control" onchange="validarArchivoRequisito(${r.ARCHIVO_ID}, this.value)">
            <option value="PEN" ${r.ESTADO === 'PEN' ? 'selected' : ''}>Pendiente</option>
            <option value="VAL" ${r.ESTADO === 'VAL' ? 'selected' : ''}>Validado</option>
            <option value="REC" ${r.ESTADO === 'REC' ? 'selected' : ''}>Rechazado</option>
            <option value="INV" ${r.ESTADO === 'INV' ? 'selected' : ''}>Inválido</option>
          </select>
        `;
        row.appendChild(tdSelect);

        tbodyReq.appendChild(row);

        // Lógica para buscar el archivo en 3 rutas
        const rutas = [
          `../documents/requisitos/${r.ARCHIVO}`,
          `../documents/cedulas/${r.ARCHIVO}`,
          `../documents/matriculas/${r.ARCHIVO}`
        ];
        let encontrado = false;
        let idxRuta = 0;
        function probarRuta() {
          if (idxRuta >= rutas.length) {
            tdArchivo.innerHTML = '<span style="color:red">Archivo no encontrado</span>';
            return;
          }
          fetch(rutas[idxRuta], { method: 'HEAD' })
            .then(resp => {
              if (resp.ok) {
                tdArchivo.innerHTML = `<a href="${rutas[idxRuta]}" target="_blank" style="color:#0066cc;">Ver archivo</a>`;
              } else {
                idxRuta++;
                probarRuta();
              }
            })
            .catch(() => {
              idxRuta++;
              probarRuta();
            });
        }
        if (r.ARCHIVO) {
          probarRuta();
        } else {
          tdArchivo.innerHTML = '<span style="color:gray">Sin archivo</span>';
        }
      });

      // === Mostrar pagos solo si el evento es pagado ===
      // Se asume que en data.inscripcion existe una propiedad ES_PAGADO (booleano o 1/0)
      // Acepta 1, '1', true, 'true', pero SOLO si es exactamente 1 o '1' (como en la base de datos)
      const esPagado = data.inscripcion.ES_PAGADO == 1 || data.inscripcion.ES_PAGADO === '1';
      const grupoPagos = document.getElementById('grupo-pagos-registrados');
      const tablaPagos = document.getElementById('tabla-pagos-detalle');
      let mensajeGratis = document.getElementById('mensaje-evento-gratis');
      if (!mensajeGratis) {
        mensajeGratis = document.createElement('div');
        mensajeGratis.id = 'mensaje-evento-gratis';
        mensajeGratis.style = 'color: #222; font-weight: bold; margin-bottom: 12px;';
        mensajeGratis.innerText = 'Este evento es gratuito. No requiere pagos.';
        if (grupoPagos && grupoPagos.parentNode) {
          grupoPagos.parentNode.insertBefore(mensajeGratis, grupoPagos);
        }
      }
      if (esPagado) {
        if (grupoPagos) grupoPagos.style.display = '';
        if (mensajeGratis) mensajeGratis.style.display = 'none';
        const pagosRes = await axios.get(`../controllers/InscripcionesController.php?option=pagosPorInscripcion&id=${idInscripcion}`);
        const pagos = pagosRes.data || [];
        const tbodyPagos = tablaPagos.querySelector('tbody');
        tbodyPagos.innerHTML = '';
        pagos.forEach(p => {
          tbodyPagos.innerHTML += `
            <tr>
              <td><a href="../documents/comprobantes/${p.COMPROBANTE_URL}" target="_blank">Ver comprobante</a></td>
              <td>${p.FORMA_PAGO || 'Desconocida'}</td>
              <td>
                <select class="form-control" onchange="actualizarEstadoPago(${p.PAGO_ID}, this.value)">
                  <option value="PEN" ${p.CODIGOESTADOPAGO === 'PEN' ? 'selected' : ''}>Pendiente</option>
                  <option value="VAL" ${p.CODIGOESTADOPAGO === 'VAL' ? 'selected' : ''}>Validado</option>
                  <option value="RECH" ${p.CODIGOESTADOPAGO === 'RECH' ? 'selected' : ''}>Rechazado</option>
                  <option value="INV" ${p.CODIGOESTADOPAGO === 'INV' ? 'selected' : ''}>Inválido</option>
                </select>
              </td>
              <td>${p.FECHA_PAGO || '-'}</td>
            </tr>
          `;
        });
      } else {
        // Ocultar grupo de pagos y mostrar mensaje si el evento es gratuito
        if (grupoPagos) grupoPagos.style.display = 'none';
        if (mensajeGratis) mensajeGratis.style.display = '';
      }

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
        const mensaje = estado === 'REC' ? 'Requisito rechazado' : 
                       estado === 'VAL' ? 'Requisito validado' : 
                       estado === 'INV' ? 'Requisito marcado como inválido' : 'Requisito actualizado';
        
        Swal.fire({ 
          icon: 'success', 
          title: mensaje, 
          timer: 1500, 
          showConfirmButton: false 
        });
        
        // Verificar si todo está validado para cerrar el modal
        setTimeout(() => {
          verificarYCerrarModal();
        }, 1600);
      } else {
        Swal.fire('Error', 'No se pudo actualizar el requisito', 'error');
      }
    })
    .catch(err => {
      console.error('Error al validar requisito:', err);
      Swal.fire('Error', 'Ocurrió un problema con el servidor', 'error');
    });
}

// Función eliminada: validarAutoAceptacion ya no es necesaria
// El backend maneja automáticamente la validación y actualización del estado

// Función para verificar si todo está validado y cerrar el modal automáticamente
function verificarYCerrarModal() {
  // Obtener todos los selects de requisitos
  const requisitosSelects = Array.from(document.querySelectorAll('#tabla-requisitos-detalle select'));
  const todosRequisitosValidados = requisitosSelects.length > 0 && requisitosSelects.every(sel => sel.value === 'VAL');

  // Obtener todos los selects de pagos (si existen)
  const pagosSelects = Array.from(document.querySelectorAll('#tabla-pagos-detalle select'));
  const todosPagosValidados = pagosSelects.length === 0 || pagosSelects.every(sel => sel.value === 'VAL');

  // Verificar si hay algún requisito o pago rechazado
  const hayRequisitosRechazados = requisitosSelects.some(sel => sel.value === 'REC');
  const hayPagosRechazados = pagosSelects.some(sel => sel.value === 'RECH');

  console.log('🔍 Verificando estado de validaciones:');
  console.log('- Requisitos validados:', todosRequisitosValidados);
  console.log('- Pagos validados:', todosPagosValidados);
  console.log('- Hay requisitos rechazados:', hayRequisitosRechazados);
  console.log('- Hay pagos rechazados:', hayPagosRechazados);

  // Si todo está validado o hay algo rechazado, cerrar modal y actualizar
  if ((todosRequisitosValidados && todosPagosValidados) || hayRequisitosRechazados || hayPagosRechazados) {
    let mensaje = '';
    if (todosRequisitosValidados && todosPagosValidados) {
      mensaje = '¡Inscripción procesada! Todos los requisitos y pagos están validados.';
    } else if (hayRequisitosRechazados || hayPagosRechazados) {
      mensaje = 'Inscripción procesada con elementos rechazados.';
    }
    
    if (mensaje) {
      Swal.fire({
        icon: 'info',
        title: 'Procesamiento completo',
        text: mensaje,
        timer: 2000,
        showConfirmButton: false
      });
    }

    setTimeout(() => {
      $('#modalDetalleInscripcion').modal('hide');
      cargarInscripcionesPendientesResponsable();
      cargarMetricasTotales();
      cargarGraficoEstados();
      cargarGraficoEventos();
    }, 2100);
  }
}

document.getElementById('formDetalleInscripcion').addEventListener('submit', function (e) {
  e.preventDefault();
  const id = document.getElementById('detalleIdInscripcion').value;
  const estado = document.getElementById('estadoInscripcionDetalle').value;

  axios.post('../controllers/InscripcionesController.php?option=estadoInscripcion', new URLSearchParams({ id, estado }))
    .then(res => {
      if (res.data.tipo === 'success') {
        Swal.fire({ 
          icon: 'success', 
          title: 'Inscripción actualizada', 
          timer: 1500, 
          showConfirmButton: false 
        });
        
        // Cerrar modal y actualizar todo
        setTimeout(() => {
          $('#modalDetalleInscripcion').modal('hide');
          cargarInscripcionesPendientesResponsable();
          cargarMetricasTotales();
          cargarGraficoEstados();
          cargarGraficoEventos();
        }, 1600);
      } else {
        Swal.fire('Error', 'No se pudo actualizar el estado', 'error');
      }
    })
    .catch(err => {
      console.error('Error al actualizar inscripción:', err);
      Swal.fire('Error', 'Ocurrió un problema al guardar', 'error');
    });
});

function actualizarEstadoPago(idPago, nuevoEstado) {
  axios.post('../controllers/InscripcionesController.php?option=estadoPago', new URLSearchParams({
    id: idPago,
    estado: nuevoEstado
  }))
  .then(res => {
    if (res.data.tipo === 'success') {
      const mensaje = nuevoEstado === 'RECH' ? 'Pago rechazado' : 
                     nuevoEstado === 'VAL' ? 'Pago validado' : 
                     nuevoEstado === 'INV' ? 'Pago marcado como inválido' : 'Estado actualizado';
      
      Swal.fire({
        icon: 'success',
        title: mensaje,
        timer: 1500,
        showConfirmButton: false
      });

      // Verificar si todo está validado para cerrar el modal
      setTimeout(() => {
        verificarYCerrarModal();
      }, 1600);
    } else {
      Swal.fire('Error', 'No se pudo actualizar el estado del pago', 'error');
    }
  })
  .catch(err => {
    console.error('Error al actualizar pago:', err);
    Swal.fire('Error', 'Ocurrió un problema al actualizar el estado', 'error');
  });
}