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
    });
}

document.getElementById('eventoSeleccionado').addEventListener('change', function () {
  const idEvento = this.value;
  if (!idEvento) return;
  cargarInscripciones(idEvento);
  cargarValidaciones(idEvento);
});

function cargarInscripciones(idEvento) {
  const tabla = $('#tabla-inscripciones');
  const tbody = tabla.find('tbody');

  if ($.fn.DataTable.isDataTable('#tabla-inscripciones')) {
    tabla.DataTable().clear().destroy();
  }

  tbody.empty();

  axios.get(`../controllers/InscripcionesController.php?option=listarPorEvento&idEvento=${idEvento}`)
    .then(res => {
      const datos = res.data;

      if (datos && datos.length > 0) {
        datos.forEach(i => {
          let facturaHtml = `<div class="celda-factura" id="factura-${i.INSCRIPCION_ID}">`;

          if (i.FACTURA) {
            facturaHtml += `
              <a href="../facturas_Comprobantes/${i.FACTURA}" target="_blank" class="btn btn-sm btn-primary mb-1" title="Ver factura">
              <i class="fa fa-eye"></i>
              </a>
              <button class="btn btn-warning btn-sm" onclick="mostrarCampoActualizar(${i.INSCRIPCION_ID})" title="Actualizar factura">
              <i class="fa fa-rotate-right"></i>
              </button>
            `;
          } else {
            facturaHtml += `
              <input type="file" onchange="subirFactura(this, ${i.INSCRIPCION_ID})" class="form-control form-control-sm" />
            `;
          }

          facturaHtml += `</div>`;

          tbody.append(`
            <tr id="fila-${i.INSCRIPCION_ID}">
              <td>${i.NOMBRES} ${i.APELLIDOS}</td>
              <td>${i.FECHAINSCRIPCION}</td>
              <td>
                <select onchange="actualizarEstadoInscripcion(this.value, ${i.INSCRIPCION_ID})" class="form-control">
                  <option value="PEN" ${i.CODIGOESTADOINSCRIPCION === 'PEN' ? 'selected' : ''}>Pendiente</option>
                  <option value="ACE" ${i.CODIGOESTADOINSCRIPCION === 'ACE' ? 'selected' : ''}>Aceptado</option>
                  <option value="REC" ${i.CODIGOESTADOINSCRIPCION === 'REC' ? 'selected' : ''}>Rechazado</option>
                  <option value="ANU" ${i.CODIGOESTADOINSCRIPCION === 'ANU' ? 'selected' : ''}>Anulado</option>
                </select>
              </td>
              <td>${facturaHtml}</td>
              <td>
                <button class="btn btn-info btn-sm" onclick="verRequisitosPagos(${i.INSCRIPCION_ID}, '${i.NOMBRES} ${i.APELLIDOS}')">
                  <i class="fa fa-eye" style="color: black;"></i> Ver
                </button>
              </td>
            </tr>
          `);
        });
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
      Swal.fire('Error', 'No se pudieron cargar las inscripciones', 'error');
    });
}

function actualizarEstadoInscripcion(estado, id) {
  axios.post('../controllers/InscripcionesController.php?option=estadoInscripcion', new URLSearchParams({ id, estado }))
    .then(res => Swal.fire('Estado actualizado', '', res.data.tipo))
    .catch(() => Swal.fire('Error', 'No se pudo actualizar el estado', 'error'));
}

function actualizarEstadoPago(estado, id) {
  axios.post('../controllers/InscripcionesController.php?option=estadoPago', new URLSearchParams({ id, estado }))
    .then(res => Swal.fire('Pago actualizado', '', res.data.tipo));
}

function validarArchivoRequisito(idArchivo, estado) {
  axios.post('../controllers/InscripcionesController.php?option=estadoRequisito', new URLSearchParams({ id: idArchivo, estado }))
    .then(res => Swal.fire(res.data.tipo === 'success' ? 'Validado' : 'Error', '', res.data.tipo));
}

function verRequisitosPagos(idInscripcion, nombreParticipante = '') {
  document.getElementById('nombreParticipanteModal').textContent = nombreParticipante;
  const reqUrl = `../controllers/InscripcionesController.php?option=requisitosPorInscripcion&id=${idInscripcion}`;
  const pagosUrl = `../controllers/InscripcionesController.php?option=pagosPorInscripcion&id=${idInscripcion}`;

  axios.all([axios.get(reqUrl), axios.get(pagosUrl)])
    .then(axios.spread((resReq, resPagos) => {
      const tbodyReq = document.getElementById('tablaRequisitosModal');
      const tbodyPagos = document.getElementById('tablaPagosModal');
      tbodyReq.innerHTML = '';
      tbodyPagos.innerHTML = '';

    resReq.data.forEach(r => {
  tbodyReq.innerHTML += `
    <tr>
      <td>${r.REQUISITO}</td>
      <td id="requisito-${r.ARCHIVO_ID}">
        ${r.ARCHIVO ? `
        <a href="../facturas_Comprobantes/${r.ARCHIVO}" target="_blank" class="btn btn-sm btn-primary mb-1" title="Ver archivo">
          <i class="fa fa-eye"></i>
        </a>
        <button class="btn btn-warning btn-sm" onclick="mostrarActualizarRequisito(${r.ARCHIVO_ID})" title="Actualizar archivo">
          <i class="fa fa-undo"></i>
        </button>
        ` : `
          <input type="file" onchange="subirRequisito(this, ${r.ARCHIVO_ID})" class="form-control form-control-sm" />
        `}
      </td>
      <td>
        <select onchange="validarArchivoRequisito(${r.ARCHIVO_ID}, this.value)" class="form-control">
          <option value="PEN" ${r.ESTADO === 'PEN' ? 'selected' : ''}>Pendiente</option>
          <option value="VAL" ${r.ESTADO === 'VAL' ? 'selected' : ''}>Validado</option>
          <option value="RECH" ${r.ESTADO === 'RECH' ? 'selected' : ''}>Rechazado</option>
          <option value="INV" ${r.ESTADO === 'INV' ? 'selected' : ''}>Inválido</option>
        </select>
      </td>
    </tr>
  `;
});
      resPagos.data.forEach(p => {
  tbodyPagos.innerHTML += `
    <tr>
      <td id="comprobante-${p.PAGO_ID}">
        ${p.COMPROBANTE_URL ? `
          <a href="../facturas_Comprobantes/${p.COMPROBANTE_URL}" target="_blank" class="btn btn-sm btn-primary mb-1" title="Ver comprobante">
            <i class="fa fa-eye"></i>
          </a>
          <button class="btn btn-warning btn-sm" onclick="mostrarActualizarComprobante(${p.PAGO_ID})" title="Actualizar comprobante">
            <i class="fa fa-undo"></i>
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

      $('#modalRequisitosPagos').modal('show');
    }));
}
function subirFactura(input, idInscripcion) {
  const file = input.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('factura', file);
  formData.append('id', idInscripcion);

  axios.post('../controllers/InscripcionesController.php?option=subirFactura', formData)
    .then(res => {
      if (res.data.tipo === 'success') {
        // ✅ Reemplazar el contenido del div con el nuevo estado (ver + actualizar)
        const divFactura = document.getElementById(`factura-${idInscripcion}`);
        divFactura.innerHTML = `
          <a href="../facturas_Comprobantes/${res.data.nombreArchivo}" target="_blank" class="btn btn-sm btn-primary mb-1" title="Ver factura">
            <i class="fa fa-file-pdf-o"></i>
          </a>
          <button class="btn btn-warning btn-sm" onclick="mostrarCampoActualizar(${idInscripcion})" title="Actualizar factura">
            <i class="fa fa-undo"></i>
          </button>
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
        text: 'No se pudo subir la factura',
        timer: 2500,
        showConfirmButton: false
      });
    });
}


function mostrarCampoActualizar(idInscripcion) {
  const contenedor = document.getElementById(`factura-${idInscripcion}`);
  contenedor.innerHTML = `
    <input type="file" onchange="subirFactura(this, ${idInscripcion})" class="form-control form-control-sm" />
  `;
}
function mostrarCampoActualizar(idInscripcion) {
  const contenedor = document.getElementById(`factura-${idInscripcion}`);
  contenedor.innerHTML = `
    <input type="file" onchange="subirFactura(this, ${idInscripcion})" class="form-control form-control-sm" />
  `;
}
function mostrarCampoActualizar(idInscripcion) {
  const contenedor = document.getElementById(`factura-${idInscripcion}`);
  contenedor.innerHTML = `
    <input type="file" onchange="subirFactura(this, ${idInscripcion})" class="form-control form-control-sm" />
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
          <a href="../facturas_Comprobantes/${res.data.nombreArchivo}" target="_blank" class="btn btn-sm btn-primary mb-1" title="Ver archivo"><i class="fa fa-eye"></i></a>
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
function mostrarActualizarRequisito(idArchivo) {
  const contenedor = document.getElementById(`requisito-${idArchivo}`);
  contenedor.innerHTML = `
    <input type="file" onchange="subirRequisito(this, ${idArchivo})" class="form-control form-control-sm" />
  `;
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
          <a href="../facturas_Comprobantes/${res.data.nombreArchivo}" target="_blank" class="btn btn-sm btn-primary mb-1" title="Ver comprobante">
            <i class="fa fa-eye"></i>
          </a>
          <button class="btn btn-warning btn-sm" onclick="mostrarActualizarComprobante(${idPago})" title="Actualizar comprobante">
            <i class="fa fa-undo"></i>
          </button>
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

