document.addEventListener('DOMContentLoaded', function () {
  $('#tablaInscripciones').DataTable({
    ajax: {
      url: '../controllers/InscripcionesController.php?option=listarPorUsuario',
      dataSrc: ''
    },
    columns: [
      { data: 'EVENTO', title: 'Evento', className: 'text-center' },
      {
        data: null,
        title: 'Factura',
        className: 'text-center',
        render: function (data, type, row) {
          const id = row.SECUENCIAL;
          const estado = row.CODIGOESTADOINSCRIPCION;
          if (estado === 'ACE') {
            return `<button class="btn btn-sm" style="background-color: black; color: white;" onclick="verFacturaDinamica(${id})"><i class="fa fa-certificate"></i> Ver Factura</button>`;
          } else {
            return `<button class="btn btn-secondary btn-sm" disabled><i class="fa fa-certificate"></i> No disponible</button>`;
          }
        }
      },
      {
        data: 'CODIGOESTADOINSCRIPCION',
        title: 'Estado Inscripción',
        className: 'text-center',
        render: function (estado) {
          const estados = {
            'ACE': ['ACEPTADO', 'blue'],
            'PEN': ['PENDIENTE', 'orange'],
            'REC': ['RECHAZADO', 'red'],
            'COM': ['COMPLETADO', 'blue']
          };
          const [texto, color] = estados[estado] || ['Desconocido', 'gray'];
          return `<span style="color:${color}; font-weight:bold;">${texto}</span>`;
        }
      },
      {
        data: 'FECHAINSCRIPCION',
        title: 'Fecha Inscripción',
        className: 'text-center',
        render: function (fechaISO) {
          const fecha = new Date(fechaISO);
          return fecha.toLocaleDateString('es-EC') + ' ' + fecha.toLocaleTimeString('es-EC', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
      },
      {
        data: null,
        title: 'Documentos',
        className: 'text-center',
        render: function (data, type, row) {
          // Si la inscripción está aceptada, deshabilita el botón
          if (row.CODIGOESTADOINSCRIPCION === 'ACE') {
            return `<button class="btn btn-dark btn-sm" disabled title="Inscripción aceptada"><i class="fa fa-upload"></i> Subir Documentos</button>`;
          }
          return `<button class="btn btn-dark btn-sm" onclick="abrirModalSubida(${row.SECUENCIAL}, ${row.SECUENCIALEVENTO}, ${row.ES_PAGADO})"><i class="fa fa-upload"></i> Subir Documentos</button>`;
        }
      }
    ],
    language: { url: '../public/js/es-ES.json' },
    responsive: true,
    pageLength: 10,
    order: [[3, 'desc']]
  });
});

function verFacturaDinamica(idInscripcion) {
  window.open(`../views/factura.php?id=${idInscripcion}`, '_blank');
}

function abrirModalSubida(idInscripcion, idEvento, esPagado) {
  const inputInscripcion = document.getElementById('inputIdInscripcion');
  const inputEvento = document.getElementById('inputIdEvento');
  const inputEsPagado = document.getElementById('inputEsPagado');
  const grupoPago = document.getElementById('grupoPago');
  const contenedor = document.getElementById('contenedorRequisitos');

  inputInscripcion.value = idInscripcion;
  inputEvento.value = idEvento;
  inputEsPagado.value = esPagado;
  grupoPago.style.display = parseInt(esPagado) === 1 ? 'block' : 'none';
  contenedor.innerHTML = '<p class="text-muted">Cargando requisitos...</p>';

  axios.get(`../controllers/EventosController.php?option=requisitosUsuarioEvento&idEvento=${idEvento}&idInscripcion=${idInscripcion}`)
    .then(resp => {
      contenedor.innerHTML = '';
      const requisitos = resp.data;

      if (!Array.isArray(requisitos) || requisitos.length === 0) {
        contenedor.innerHTML = '<p class="text-muted">Este evento no requiere archivos.</p>';
        return;
      }

      requisitos.forEach(req => {
        const idReq = req.id;
        const descripcion = req.descripcion.toLowerCase();
        const div = document.createElement('div');
        div.className = 'form-group';

        if (req.cumplido && (descripcion.includes('cédula') || descripcion.includes('matrícula'))) {
          div.innerHTML = `<label><strong>${req.descripcion}</strong></label><div style="color: #0066cc; font-weight: 500; font-size: 14px;">
  <i class="fa fa-check-circle" style="color: #0066cc; margin-right: 5px;"></i> Ya ha sido cargado previamente.
</div>
`;
        } else if (req.cumplido && req.archivo) {
          div.innerHTML = `
            <label><strong>${req.descripcion}</strong></label>
            <div class="grupo-archivo" data-id="${idReq}">
              <a href="../documents/requisitos/${req.archivo}" target="_blank" class="nombre-archivo mr-2" style="color: #0066cc;">${req.archivo}</a>
              <button type="button" class="btn btn-sm btn-outline-primary cambiar-archivo">Cambiar</button>
              <input type="file" name="requisito_${idReq}" class="form-control-file mt-2" style="display: none;" accept=".pdf,.jpg,.jpeg,.png">
            </div>`;
        } else {
          div.innerHTML = `<label><strong>${req.descripcion}</strong></label><input type="file" name="requisito_${idReq}" class="form-control-file" accept=".pdf,.jpg,.jpeg,.png">`;
        }

        contenedor.appendChild(div);
      });

      contenedor.querySelectorAll('.cambiar-archivo').forEach(btn => {
        btn.addEventListener('click', function () {
          const grupo = this.closest('.grupo-archivo');
          const input = grupo.querySelector('input[type="file"]');
          const link = grupo.querySelector('.nombre-archivo');
          input.style.display = 'block';
          this.style.display = 'none';
          if (link) link.classList.add('text-muted');
        });
      });

      $('#modalRequisitos').modal('show');
    })
    .catch(err => {
      console.error('Error al cargar requisitos:', err);
      Swal.fire('Error', 'No se pudieron cargar los requisitos.', 'error');
    });

    if (parseInt(esPagado) === 1) {
  axios.get(`../controllers/EventosController.php?option=comprobantePago&idInscripcion=${idInscripcion}`)
    .then(res => {
      const comprobante = res.data?.comprobante;
      const wrapper = document.getElementById('wrapperComprobantePago');
      const nuevo = document.getElementById('wrapperNuevoComprobante');
      const link = document.getElementById('linkComprobante');
      const btn = document.getElementById('btnCambiarComprobante');
      const input = document.getElementById('inputComprobante');

      if (comprobante) {
        wrapper.style.display = 'block';
        nuevo.style.display = 'none';
        link.textContent = comprobante;
        link.href = `../documents/comprobantes/${comprobante}`;
        link.style.color = '#0066cc';
        link.classList.remove('text-muted');
        input.style.display = 'none';
        input.value = ''; // Limpia valor previo
        btn.style.display = 'inline-block';

        btn.onclick = () => {
          input.style.display = 'block';
          input.value = '';
          btn.style.display = 'none';
          link.classList.add('text-muted');
        };
      } else {
        wrapper.style.display = 'none';
        nuevo.style.display = 'block';
        nuevo.innerHTML = `
          <input type="file" name="comprobante_pago" class="form-control-file" accept=".pdf,.jpg,.jpeg,.png">
        `;
      }
    })
    .catch(() => {
      document.getElementById('wrapperComprobantePago').style.display = 'none';
      const nuevo = document.getElementById('wrapperNuevoComprobante');
      if (nuevo) {
        nuevo.style.display = 'block';
        nuevo.innerHTML = `
          <input type="file" name="comprobante_pago" class="form-control-file" accept=".pdf,.jpg,.jpeg,.png">
        `;
      }
    });
}



}

document.getElementById('formRequisitos').addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(this);
  const idInscripcion = document.getElementById('inputIdInscripcion').value;
  const idEvento = document.getElementById('inputIdEvento').value;
  const esPagado = document.getElementById('inputEsPagado').value;

  formData.append('option', 'actualizarInscripcion');
  formData.append('id_inscripcion', idInscripcion);
  formData.append('id_evento', idEvento);
  formData.append('es_pagado', esPagado);

  if (esPagado === '1') {
    formData.append('forma_pago', document.getElementById('inputFormaPago').value);
    const comprobanteInput = document.getElementById('inputComprobante');
    if (comprobanteInput?.files[0]) {
      formData.append('comprobante_pago', comprobanteInput.files[0]);
    } else {
      const nuevoInput = document.querySelector('#wrapperNuevoComprobante input[type="file"]');
      if (nuevoInput?.files[0]) {
        formData.append('comprobante_pago', nuevoInput.files[0]);
      }
    }
  }

  const requisitos = [];
  document.querySelectorAll('#contenedorRequisitos input[type="file"]').forEach(input => {
    const match = input.name.match(/requisito_(\d+)/);
    if (match) requisitos.push(match[1]);
  });
  formData.append('requisitos', JSON.stringify(requisitos));

  axios.post(`../controllers/EventosController.php?option=actualizarInscripcion`, formData)
    .then(res => {
      const r = res.data;
      if (r.tipo === 'success') {
        Swal.fire('Éxito', r.mensaje, 'success');
        $('#modalRequisitos').modal('hide');
        $('#tablaInscripciones').DataTable().ajax.reload();
      } else {
        Swal.fire('Error', r.mensaje || 'Error al actualizar inscripción', 'error');
      }
    })
    .catch(err => {
      console.error('Error al enviar el formulario:', err);
      Swal.fire('Error', 'Error inesperado al procesar la solicitud.', 'error');
    });
});
