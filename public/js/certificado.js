// Listar certificados por evento
function listarCertificadosPorEvento(idEvento) {
  axios.get('../controllers/CertificadoControler.php?option=emitidosPorEvento&idEvento=' + idEvento)
    .then(res => {
      if ($.fn.DataTable.isDataTable('#tabla-certificados')) {
        $('#tabla-certificados').DataTable().destroy();
      }
      const tbody = document.querySelector('#tabla-certificados tbody');
      tbody.innerHTML = '';
      let todosTienenCertificado = true;
      if (res.data.tipo === 'success') {
        res.data.data.forEach(row => {
          if (!row.URL_CERTIFICADO) {
            todosTienenCertificado = false;
          }
          tbody.innerHTML += `
            <tr data-id="${row.ID_USUARIO}">
              <td>${row.CEDULA || ''}</td>
              <td>${row.NOMBRES || ''}</td>
              <td>${row.APELLIDOS || ''}</td>
              <td>${row.CORREO || ''}</td>
              <td>
                ${row.URL_CERTIFICADO
                  ? `<button class="btn btn-outline-dark btn-sm" onclick="verCertificado('${row.URL_CERTIFICADO}')">
                      <i class="fa fa-file-pdf-o"></i> Ver PDF
                    </button>`
                  : '<span class="text-muted">No disponible</span>'
                }
              </td>
            </tr>
          `;
        });
      } else {
        todosTienenCertificado = false;
      }
      $('#tabla-certificados').DataTable({
        language: { url: '../public/js/es-ES.json' },
        responsive: true
      });

      // Lógica para habilitar/deshabilitar el botón de generar certificados
      const btnGenerar = document.getElementById('btnGenerarTodos');
      if (btnGenerar) {
        if (todosTienenCertificado && res.data.data && res.data.data.length > 0) {
          btnGenerar.disabled = true;
          btnGenerar.title = 'Todos los certificados ya han sido generados para este evento.';
        } else {
          btnGenerar.disabled = false;
          btnGenerar.title = '';
        }
      }
    });
}

// Abrir certificado PDF
function verCertificado(url) {
  window.open('../documents/certificados/' + url, '_blank');
}

// Subir certificado en base64 al servidor
async function subirCertificadoBase64(base64, idUsuario, idEvento) {
  try {
    const formData = new FormData();
    formData.append('base64', base64);
    formData.append('idUsuario', idUsuario);
    formData.append('idEvento', idEvento);

    const res = await axios.post('../controllers/CertificadoControler.php?option=subirCertificado', formData);
    if (res.data.tipo !== 'success') {
      console.error(`Error al guardar certificado para usuario ${idUsuario}:`, res.data.mensaje);
    } else {
      console.log(`Certificado guardado correctamente para usuario ${idUsuario}`);
    }
    return res.data;
  } catch (err) {
    console.error('Error al enviar certificado al servidor:', err);
    return { tipo: 'error', mensaje: 'Error en la conexión con el servidor' };
  }
}

// Generar y subir todos los certificados en PDF
async function generarTodosPDFs() {
  const filas = document.querySelectorAll('#tabla-certificados tbody tr');
  // Verifica si la tabla está vacía o solo tiene la fila de "No disponible"
  if (!filas.length || (filas.length === 1 && filas[0].querySelectorAll('td').length === 1)) {
    Swal.fire({
      icon: 'warning',
      title: 'No se puede generar certificados',
      text: 'No hay registros de participantes en la tabla para este evento.',
      confirmButtonColor: '#b93333'
    });
    return;
  }

  Swal.fire({
    icon: 'info',
    title: 'Generando certificados PDF...',
    html: `
      <div style="text-align: left; margin: 20px 0;">
        <p>💾 Guardando certificados en el servidor...</p>
        <p>📧 Preparando notificaciones por correo...</p>
        <br>
        <p><em>Este proceso puede tardar algunos segundos...</em></p>
      </div>
    `,
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading()
  });

  const urlFondo = '../public/img/uta/plantilla.png';
  const fondo = await cargarImagenBase64(urlFondo);
  const idEvento = document.getElementById('selectEvento').value;

  for (const fila of filas) {
    const idUsuario = fila.dataset.id;
    const nombres = fila.children[1].textContent.trim();
    const apellidos = fila.children[2].textContent.trim();
    const nombreCompleto = `${nombres} ${apellidos}`;
    const evento = document.querySelector('#selectEvento option:checked').textContent;

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: "landscape", unit: "px", format: [842, 595] });

    doc.addImage(fondo, 'PNG', 0, 0, 842, 595);

    const offsetY = 40;

    doc.setFont("times", "italic");
    doc.setFontSize(48);
    doc.setTextColor("#8B0000");
    doc.text("CERTIFICADO", 421, 230 + offsetY, { align: "center" });

    doc.setFont("helvetica", "bold");
    doc.setFontSize(20);
    doc.setTextColor("#000");
    doc.text("Otorgado a:", 421, 250 + offsetY, { align: "center" });

    doc.setFont("helvetica", "bold");
    doc.setFontSize(28);
    doc.setTextColor("#0d47a1");
    doc.text(nombreCompleto, 421, 270 + offsetY, { align: "center" });

    doc.setFont("helvetica", "normal");
    doc.setFontSize(18);
    doc.setTextColor("#000");
    doc.text("Por su participación en el evento:", 421, 300 + offsetY, { align: "center" });

    doc.setFont("helvetica", "bold");
    doc.setFontSize(20);
    doc.text(evento, 421, 330 + offsetY, { align: "center" });

    doc.setFont("helvetica", "italic");
    doc.setFontSize(14);
    doc.text(`Ambato, ${new Date().toLocaleDateString()}`, 421, 370 + offsetY, { align: "center" });

    const blob = doc.output('blob');
    const base64 = await new Promise((resolve) => {
      const reader = new FileReader();
      reader.onloadend = () => resolve(reader.result.split(',')[1]);
      reader.readAsDataURL(blob);
    });

    await subirCertificadoBase64(base64, idUsuario, idEvento);
  }

  Swal.close();
  Swal.fire({
    icon: 'success',
    title: '¡Certificados generados exitosamente!',
    html: `
      <div style="text-align: left; margin: 20px 0;">
        <p> Los certificados PDF han sido generados y guardados correctamente.</p>
        <p>Se ha enviado una notificación por correo electrónico a cada participante informándoles que su certificado está disponible para descarga.</p>
      </div>
    `,
    confirmButtonText: 'Entendido',
    confirmButtonColor: '#28a745'
  });
  listarCertificadosPorEvento(idEvento);
}

// Convertir imagen a base64
function cargarImagenBase64(url) {
  return new Promise((resolve) => {
    const img = new Image();
    img.crossOrigin = "Anonymous";
    img.onload = function () {
      const canvas = document.createElement("canvas");
      canvas.width = img.width;
      canvas.height = img.height;
      const ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0);
      resolve(canvas.toDataURL("image/png"));
    };
    img.src = url;
  });
}

document.addEventListener('DOMContentLoaded', function () {
  axios.get('../controllers/Asistencia_NotaController.php?option=eventosResponsable')
    .then(res => {
      const select = document.getElementById('selectEvento');
      select.innerHTML = '<option value="">Seleccione...</option>';
      if (res.data.length === 0) {
        select.innerHTML = '<option value="">No tienes eventos asignados</option>';
        document.getElementById('nombreEventoSeleccionado').textContent = '';
        return;
      }

      res.data.forEach(ev => {
        select.innerHTML += `<option value="${ev.SECUENCIAL}">${ev.TITULO}</option>`;
      });


      // Inicializar Select2 después de llenar el select
      if (window.jQuery && $(select).select2) {
        if ($(select).hasClass('select2-hidden-accessible')) {
          $(select).select2('destroy');
        }
        $(select).select2({
          placeholder: 'Buscar o seleccionar evento...',
          allowClear: true,
          width: '100%',
          language: {
            noResults: function() {
              return 'No se encontraron eventos';
            }
          }
        });
        // Cerrar el menú al seleccionar o al cambiar (incluso si es la misma opción)
        $(select).on('select2:select', function() {
          $(this).select2('close');
        });
        $(select).on('change', function () {
          $(this).select2('close');
          listarCertificadosPorEvento(this.value);
          const selectedText = this.options[this.selectedIndex]?.text || '';
          document.getElementById('nombreEventoSeleccionado').textContent =
            this.value ? 'Evento: ' + selectedText : '';
        });
      } else {
        select.addEventListener('change', function () {
          listarCertificadosPorEvento(this.value);
          const selectedText = this.options[this.selectedIndex]?.text || '';
          document.getElementById('nombreEventoSeleccionado').textContent =
            this.value ? 'Evento: ' + selectedText : '';
        });
      }

      // Al cargar, si hay valor seleccionado, muestra la tabla y el nombre
      if (select.value) {
        listarCertificadosPorEvento(select.value);
        const selectedText = select.options[select.selectedIndex]?.text || '';
        document.getElementById('nombreEventoSeleccionado').textContent =
          select.value ? 'Evento: ' + selectedText : '';
      } else {
        document.getElementById('nombreEventoSeleccionado').textContent = '';
      }
    });

  document.getElementById('btnGenerarTodos')?.addEventListener('click', generarTodosPDFs);
});