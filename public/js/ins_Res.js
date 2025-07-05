document.addEventListener('DOMContentLoaded', cargarEventosSeleccion);

function cargarEventosSeleccion() {
  axios.get('../controllers/EventosController.php?option=listarResponsable')
    .then(res => {
      const select = document.getElementById('eventoSeleccionado');
      select.innerHTML = '<option value="">Seleccione</option>';
      res.data.forEach(e => {
        const opt = document.createElement('option');
        opt.value = e.SECUENCIAL;
        opt.textContent = e.TITULO;
        select.appendChild(opt);
      });

      // Eliminar manipulación de size y estilos para que el select sea un dropdown normal
      select.size = 1;
      select.style.overflowY = '';
      select.style.height = '';

      // Evento change nativo
      select.onchange = function () {
        const idEvento = this.value;
        if (!idEvento) return;
        cargarInscripciones(idEvento);
      };
    });
}

function cargarInscripciones(idEvento) {
  const tabla = $('#tabla-inscripciones');
  const tbody = tabla.find('tbody');

  if ($.fn.DataTable.isDataTable('#tabla-inscripciones')) {
    tabla.DataTable().clear().destroy();
  }

  // Animación de cargando con spinner Bootstrap
  tbody.html(`
    <tr>
      <td colspan="5" style="text-align:center;">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Cargando...</span>
        </div>
        <div style="margin-top:8px;">Cargando inscripciones...</div>
      </td>
    </tr>
  `);

  axios.get(`../controllers/InscripcionesController.php?option=listarPorEvento&idEvento=${idEvento}`)
    .then(res => {
      const datos = res.data;

      if (datos && datos.length > 0) {
        tbody.empty();
        datos.forEach(i => {
          let facturaHtml = `<div class="celda-factura" id="factura-${i.INSCRIPCION_ID}">`;

          // Mostrar botón solo si la inscripción está aceptada
          if (i.CODIGOESTADOINSCRIPCION === 'ACE') {
            facturaHtml += `
              <button class="btn btn-dark btn-sm" onclick="verFacturaDinamica(${i.INSCRIPCION_ID})" title="Ver factura">
                <i class="fa fa-certificate"></i> Ver Factura
              </button>
            `;
          } else {
            facturaHtml += `
              <button class="btn btn-secondary btn-sm" disabled title="Solo disponible si la inscripción está aceptada">
                <i class="fa fa-file-pdf-o"></i> Ver Factura
              </button>
            `;
          }

          facturaHtml += `</div>`;

          tbody.append(`
            <tr id="fila-${i.INSCRIPCION_ID}">
              <td>${i.NOMBRES} ${i.APELLIDOS}</td>
              <td>${i.FECHAINSCRIPCION}</td>
              <td>
                ${(() => {
                  switch (i.CODIGOESTADOINSCRIPCION) {
                    case 'ACE': return '<span class="badge" style="background: #0066cc;">Aceptado</span>';
                    case 'PEN': return '<span class="badge" style="background: #ffc107; color: #212529;">Pendiente</span>';
                    case 'REC': return '<span class="badge" style="background: #dc3545;">Rechazado</span>';
                    case 'ANU': return '<span class="badge" style="background: #6c757d;">Anulado</span>';
                    default: return '<span class="badge" style="background: #adb5bd;">Desconocido</span>';
                  }
                })()}
              </td>
              <td>${facturaHtml}</td>
              <td>
                <button class="btn btn-dark btn-sm" onclick="verRequisitosPagos(${i.INSCRIPCION_ID}, '${i.NOMBRES} ${i.APELLIDOS}')">
                  <i class="fa fa-check"></i> Validar
                </button>
              </td>
            </tr>
          `);
        });
      } else {
        tbody.html('<tr><td colspan="5">No hay inscripciones para este evento.</td></tr>');
      }

      tabla.DataTable({
        language: {
          url: '../public/js/es-ES.json'
        },
        lengthChange: true,
        responsive: true
      });
    })
    .catch(err => {
      console.error('Error al cargar inscripciones:', err);
      tbody.html('<tr><td colspan="5">Error al cargar inscripciones.</td></tr>');
      Swal.fire('Error', 'No se pudieron cargar las inscripciones', 'error');
    });
}

// Función para abrir la factura dinámica en una nueva pestaña
function verFacturaDinamica(idInscripcion) {
  window.open(`../views/factura.php?id=${idInscripcion}`, '_blank');
}

function actualizarEstadoInscripcion(estado, id) {
  // Obtener el evento seleccionado para recargar la tabla
  const idEvento = document.getElementById('eventoSeleccionado').value;
  axios.post('../controllers/InscripcionesController.php?option=estadoInscripcion', new URLSearchParams({ id, estado }))
    .then(res => {
      Swal.fire('Estado actualizado', '', res.data.tipo);
      // Recargar la tabla de inscripciones para reflejar el cambio
      if (idEvento) {
        cargarInscripciones(idEvento);
      }
    })
    .catch(() => Swal.fire('Error', 'No se pudo actualizar el estado', 'error'));
}

function actualizarEstadoPago(estado, id) {
  // Obtener el evento seleccionado para recargar la tabla
  const idEvento = document.getElementById('eventoSeleccionado').value;
  axios.post('../controllers/InscripcionesController.php?option=estadoPago', new URLSearchParams({ id, estado }))
    .then(res => {
      const mensaje = estado === 'RECH' ? 'Pago rechazado' : 
                     estado === 'VAL' ? 'Pago validado' : 
                     estado === 'INV' ? 'Pago marcado como inválido' : 'Estado actualizado';
      
      Swal.fire('Pago actualizado', mensaje, res.data.tipo);
      
      // Verificar si todo está validado para cerrar el modal
      setTimeout(() => {
        verificarYCerrarModalRequisitos();
      }, 1600);
      
      // Recargar la tabla de inscripciones para reflejar el cambio
      if (idEvento) {
        cargarInscripciones(idEvento);
      }
    })
    .catch(err => {
      console.error('Error al actualizar pago:', err);
      Swal.fire('Error', 'No se pudo actualizar el estado del pago', 'error');
    });
}

function validarArchivoRequisito(idArchivo, estado) {
  // Obtener el evento seleccionado para recargar la tabla
  const idEvento = document.getElementById('eventoSeleccionado').value;
  axios.post('../controllers/InscripcionesController.php?option=estadoRequisito', new URLSearchParams({ id: idArchivo, estado }))
    .then(res => {
      const mensaje = estado === 'REC' ? 'Requisito rechazado' : 
                     estado === 'VAL' ? 'Requisito validado' : 
                     estado === 'INV' ? 'Requisito marcado como inválido' : 'Estado actualizado';
      
      Swal.fire(res.data.tipo === 'success' ? 'Éxito' : 'Error', mensaje, res.data.tipo);
      
      // Verificar si todo está validado para cerrar el modal
      setTimeout(() => {
        verificarYCerrarModalRequisitos();
      }, 1600);
      
      // Recargar la tabla principal si está visible
      if (idEvento) cargarInscripciones(idEvento);
    })
    .catch(err => {
      console.error('Error al validar requisito:', err);
      Swal.fire('Error', 'No se pudo actualizar el estado del requisito', 'error');
    });
}

function verRequisitosPagos(idInscripcion, nombreParticipante = '') {
  document.getElementById('nombreParticipanteModal').textContent = nombreParticipante;
  const reqUrl = `../controllers/InscripcionesController.php?option=requisitosPorInscripcion&id=${idInscripcion}`;
  const pagosUrl = `../controllers/InscripcionesController.php?option=pagosPorInscripcion&id=${idInscripcion}`;

  axios.get(reqUrl).then(resReq => {
    const tbodyReq = document.getElementById('tablaRequisitosModal');
    tbodyReq.innerHTML = '';
    resReq.data.requisitos.forEach(r => {
      tbodyReq.innerHTML += `
        <tr>
          <td>${r.REQUISITO}</td>
          <td id="requisito-${r.ARCHIVO_ID}">
            ${r.ARCHIVO ? `
            <button class="btn btn-dark btn-sm mb-1" onclick="window.open('../documents/${r.ARCHIVO}', '_blank')" title="Ver archivo" type="button">
              <i class="fa fa-eye"></i>
            </button>
            <button class="btn btn-dark btn-sm" onclick="mostrarActualizarRequisito(${r.ARCHIVO_ID})" title="Actualizar archivo">
              <i class="fa fa-edit"></i>
            </button>
            ` : `
              <input type="file" onchange="subirRequisito(this, ${r.ARCHIVO_ID})" class="form-control form-control-sm" />
            `}
          </td>
          <td>
            <select onchange="validarArchivoRequisito(${r.ARCHIVO_ID}, this.value)" class="form-control">
              <option value="PEN" ${r.ESTADO === 'PEN' ? 'selected' : ''}>Pendiente</option>
              <option value="VAL" ${r.ESTADO === 'VAL' ? 'selected' : ''}>Validado</option>
              <option value="REC" ${r.ESTADO === 'REC' ? 'selected' : ''}>Rechazado</option>
              <option value="INV" ${r.ESTADO === 'INV' ? 'selected' : ''}>Inválido</option>
            </select>
          </td>
        </tr>
      `;
    });

    // Mostrar u ocultar la sección de pagos
    const pagosSection = document.getElementById('seccionPagosModal');
    if (resReq.data.esPagado == 1) {
      pagosSection.style.display = '';
      // Cargar pagos solo si es pagado
      axios.get(pagosUrl).then(resPagos => {
        const tbodyPagos = document.getElementById('tablaPagosModal');
        tbodyPagos.innerHTML = '';
        resPagos.data.forEach(p => {
          tbodyPagos.innerHTML += `
            <tr>
              <td id="comprobante-${p.PAGO_ID}">
                ${p.COMPROBANTE_URL ? `
                  <button class="btn btn-dark btn-sm mb-1" onclick="window.open('../documents/${p.COMPROBANTE_URL}', '_blank')" title="Ver comprobante" type="button">
                    <i class="fa fa-eye"></i>
                  </button>
                  <button class="btn btn-dark btn-sm" onclick="mostrarActualizarComprobante(${p.PAGO_ID})" title="Actualizar comprobante">
                    <i class="fa fa-edit"></i>
                  </button>
                ` : `
                  <input type="file" onchange="subirComprobantePago(this, ${p.PAGO_ID})" class="form-control form-control-sm" />
                `}
              </td>
              <td>${p.FORMA_PAGO || 'Desconocida'}</td>
              <td>
                <select onchange="actualizarEstadoPago(this.value, ${p.PAGO_ID})" class="form-control">
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
      });
    } else {
      pagosSection.style.display = 'none';
      // Limpia la tabla de pagos si no es pagado
      document.getElementById('tablaPagosModal').innerHTML = '';
    }

    $('#modalRequisitosPagos').modal('show');
  });
}

function mostrarActualizarRequisito(idArchivo) {
  const contenedor = document.getElementById(`requisito-${idArchivo}`);
  contenedor.innerHTML = `
    <input type="file" onchange="subirRequisito(this, ${idArchivo})" class="form-control form-control-sm" />
  `;
}

function subirRequisito(input, idArchivo) {
  const file = input.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('archivo', file);
  formData.append('idArchivo', idArchivo);

  axios.post('../controllers/RequisitosControler.php?option=subirArchivo', formData)
    .then(res => {
      if (res.data.tipo === 'success') {
        const div = document.getElementById(`requisito-${idArchivo}`);
        div.innerHTML = `
          <a href="../documents/${res.data.nombreArchivo}" target="_blank" class="btn btn-sm btn-primary mb-1" title="Ver archivo"><i class="fa fa-eye"></i></a>
          <button class="btn btn-warning btn-sm" onclick="mostrarActualizarRequisito(${idArchivo})" title="Actualizar archivo"><i class="fa fa-undo"></i></button>
        `;
      }

      Swal.fire({
        icon: res.data.tipo,
        title: res.data.tipo === 'success' ? 'Éxito' : 'Error',
        text: res.data.mensaje,
        timer: 2000,
        showConfirmButton: false
      });
    })
    .catch(() => {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudo subir el requisito',
        timer: 2500,
        showConfirmButton: false
      });
    });
}

function mostrarActualizarComprobante(idPago) {
  const contenedor = document.getElementById(`comprobante-${idPago}`);
  contenedor.innerHTML = `
    <input type="file" onchange="subirComprobantePago(this, ${idPago})" class="form-control form-control-sm" />
  `;
}

function subirComprobantePago(input, idPago) {
  const file = input.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('comprobante', file);
  formData.append('id', idPago);

  axios.post('../controllers/InscripcionesController.php?option=subirComprobantePago', formData)
    .then(res => {
      if (res.data.tipo === 'success') {
        const div = document.getElementById(`comprobante-${idPago}`);
        div.innerHTML = `
          <button class="btn btn-dark btn-sm mb-1" onclick="window.open('../documents/${res.data.nombreArchivo}', '_blank')" title="Ver comprobante" type="button"><i class="fa fa-eye"></i></button>
          <button class="btn btn-dark btn-sm" onclick="mostrarActualizarComprobante(${idPago})" title="Actualizar comprobante"><i class="fa fa-edit"></i></button>
        `;
      }
      Swal.fire({
        icon: res.data.tipo,
        title: res.data.tipo === 'success' ? 'Éxito' : 'Error',
        text: res.data.mensaje,
        timer: 2500,
        showConfirmButton: false
      });
    })
    .catch(() => {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudo subir el comprobante',
        timer: 2500,
        showConfirmButton: false
      });
    });
}

// Función para verificar si todo está validado y cerrar el modal automáticamente
function verificarYCerrarModalRequisitos() {
  // Obtener todos los selects de requisitos
  const requisitosSelects = Array.from(document.querySelectorAll('#tablaRequisitosModal select'));
  const todosRequisitosValidados = requisitosSelects.length > 0 && requisitosSelects.every(sel => sel.value === 'VAL');

  // Obtener todos los selects de pagos (si existen)
  const pagosSelects = Array.from(document.querySelectorAll('#tablaPagosModal select'));
  const todosPagosValidados = pagosSelects.length === 0 || pagosSelects.every(sel => sel.value === 'VAL');

  // Verificar si hay algún requisito o pago rechazado
  const hayRequisitosRechazados = requisitosSelects.some(sel => sel.value === 'REC');
  const hayPagosRechazados = pagosSelects.some(sel => sel.value === 'RECH');

  console.log('🔍 Verificando estado de validaciones en ins_Res:');
  console.log('- Requisitos validados:', todosRequisitosValidados);
  console.log('- Pagos validados:', todosPagosValidados);
  console.log('- Hay requisitos rechazados:', hayRequisitosRechazados);
  console.log('- Hay pagos rechazados:', hayPagosRechazados);

  // Si todo está validado o hay algo rechazado, cerrar modal
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
      $('#modalRequisitosPagos').modal('hide');
    }, 2100);
  }
}