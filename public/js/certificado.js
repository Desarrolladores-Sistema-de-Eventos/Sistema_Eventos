// Listar certificados por evento
function listarCertificadosPorEvento(idEvento) {
  axios.get('../controllers/CertificadoControler.php?option=emitidosPorEvento&idEvento=' + idEvento)
    .then(res => {
      // Si ya existe una instancia, destrúyela y limpia
      if ($.fn.DataTable.isDataTable('#tabla-certificados')) {
        $('#tabla-certificados').DataTable().clear().destroy();
      }

      const tbody = document.querySelector('#tabla-certificados tbody');
      tbody.innerHTML = '';

      if (res.data.tipo === 'success') {
        res.data.data.forEach(row => {
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
                  : '<span class="text-muted">No disponible</span>'}
              </td>
            </tr>
          `;
        });
      }

      // Siempre reinicializa al final
      $('#tabla-certificados').DataTable({
        language: { url: '../public/js/es-ES.json' },
        responsive: true,
        destroy: true  // ← también puedes dejar esto por seguridad
      });
    });
}


// Abrir certificado PDF
function verCertificado(url) {
  window.open('../documents/' + url, '_blank');
}

// Subir certificado en base64 al servidor
async function subirCertificadoBase64(base64, idUsuario, idEvento) {
  try {
    const formData = new FormData();
    formData.append('base64', base64);
    formData.append('idUsuario', idUsuario);
    formData.append('idEvento', idEvento);

    const res = await axios.post('../controllers/CertificadoControler.php?option=subirCertificado', formData, {
      timeout: 30000, // 30 segundos timeout
      maxContentLength: 50 * 1024 * 1024, // 50MB max
      maxBodyLength: 50 * 1024 * 1024
    });
    
    if (res.data.tipo !== 'success') {
      console.error(`Error al guardar certificado para usuario ${idUsuario}:`, res.data.mensaje);
      return { tipo: 'error', mensaje: res.data.mensaje || 'Error desconocido' };
    } else {
      console.log(`Certificado guardado correctamente para usuario ${idUsuario}`);
      return res.data;
    }
  } catch (err) {
    console.error('Error al enviar certificado al servidor:', err);
    let mensaje = 'Error en la conexión con el servidor';
    
    if (err.response) {
      // Error de respuesta del servidor
      mensaje = `Error del servidor: ${err.response.status} - ${err.response.statusText}`;
    } else if (err.request) {
      // Error de conexión
      mensaje = 'Error de conexión con el servidor';
    } else if (err.code === 'ECONNABORTED') {
      // Timeout
      mensaje = 'Tiempo de espera agotado';
    }
    
    return { tipo: 'error', mensaje };
  }
}

// Generar y subir todos los certificados en PDF
async function generarTodosPDFs() {

  const filas = document.querySelectorAll('#tabla-certificados tbody tr');
  if (!filas.length) {
    Swal.fire('Atención', 'No hay certificados emitidos para este evento.', 'info');
    return;
  }

  Swal.fire({
    icon: 'info',
    title: 'Generando certificados...',
    text: 'Esto puede tardar algunos segundos...',
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading()
  });

  // Cargar las imágenes decorativas (verificar que existan)
  const urlRosette = '../public/img/rossete.png';
  const urlSello = '../public/img/sello_UTA.jpg'; // Cambiado a logo existente
  const urlArco = '../public/img/arco.png'; // Cambiado a imagen existente
  
  let rosette, sello, arco;
  
  try {
    rosette = await cargarImagenBase64(urlRosette);
    sello = await cargarImagenBase64(urlSello);
    arco = await cargarImagenBase64(urlArco);
  } catch (error) {
    console.warn('Error cargando imágenes decorativas:', error);
    // Continuar sin imágenes si fallan
    rosette = null;
    sello = null;
    arco = null;
  }
  
  const idEvento = document.getElementById('selectEvento').value;

  for (const fila of filas) {
    const idUsuario = fila.dataset.id;
    const nombres = fila.children[1].textContent.trim();
    const apellidos = fila.children[2].textContent.trim();
    const cedula = fila.children[0].textContent.trim();
    const correo = fila.children[3].textContent.trim();
    const nombreCompleto = `${nombres} ${apellidos}`.toUpperCase();
    const evento = document.querySelector('#selectEvento option:checked').textContent;

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: "landscape", unit: "px", format: [842, 595] });

    // Fondo elegante - color más claro como en la imagen de referencia
    doc.setFillColor(252, 248, 240); // Fondo más claro y cálido
    doc.rect(0, 0, 842, 595, 'F');
    
 
    // Bordes decorativos dorados brillantes - ENCIMA de los triángulos
    const doradoPrincipal = [255, 215, 0]; // Dorado brillante como en la imagen de referencia
    doc.setFillColor(...doradoPrincipal);
    doc.rect(15, 15, 812, 12, 'F'); // Borde superior
    doc.rect(15, 568, 812, 12, 'F'); // Borde inferior
    doc.rect(15, 15, 12, 565, 'F'); // Borde izquierdo
    doc.rect(815, 15, 12, 565, 'F'); // Borde derecho
    
    // Líneas decorativas internas doradas brillantes
    doc.setFillColor(...doradoPrincipal);
    doc.rect(40, 40, 762, 3, 'F'); // Línea superior
    doc.rect(40, 552, 762, 3, 'F'); // Línea inferior

    // Figuras rectangulares decorativas doradas - bien separadas de los triángulos
    

   // Triángulos rojos vino en cada esquina - DEBAJO DE TODO (inmediatamente después del fondo)
    const colorVinoEsquinas = [139, 28, 40]; // Color vino UTA oficial
    doc.setFillColor(...colorVinoEsquinas);
    
    // Esquina superior izquierda - triángulo rojo vino
    for (let i = 0; i < 90; i++) {
      doc.rect(0, i, 90 - i, 1, 'F');
    }
    
    // Esquina superior derecha - triángulo rojo vino
    for (let i = 0; i < 90; i++) {
      doc.rect(752 + i, i, 90 - i, 1, 'F');
    }
    
    // Esquina inferior izquierda - triángulo rojo vino (girado correctamente)
    for (let i = 0; i < 90; i++) {
      doc.rect(i, 505 + i, 1, 90 - i, 'F');
    }
    
    // Esquina inferior derecha - triángulo rojo vino (girado correctamente)  
    for (let i = 0; i < 90; i++) {
      doc.rect(842 - i, 595 - 90 + i, 1, 90 - i, 'F');
    }
    
    // Logos institucionales perfectamente alineados con los triángulos de 90px
    // Rosette decorativa - perfectamente alineado
    if (rosette) {
      doc.addImage(rosette, 'PNG', 90, 70, 140, 160);
    }
    
    // Sello UTA - alineado perfectamente con el rosette
    if (sello) {
      doc.addImage(sello, 'JPEG', 642, 70, 110, 110);
    }
    
    // Arco decorativo - centrado en la parte inferior
    if (arco) {
      doc.addImage(arco, 'PNG', 288, 470, 250, 70);
    }

    // Header superior con información de la universidad - mejorado en dos líneas
    doc.setFont("helvetica", "bold");
    doc.setFontSize(46);
    doc.setTextColor(120, 40, 45); // Color vino elegante
    doc.text("UNIVERSIDAD TÉCNICA", 421, 125, { align: "center" });
    doc.text("DE AMBATO", 421, 165, { align: "center" });

    // Nombre del evento - en rojo vino cursiva elegante
    doc.setFont("helvetica", "italic");
    doc.setFontSize(30);
    doc.setTextColor(120, 40, 45); // Color vino elegante
    doc.text(evento, 421, 195, { align: "center" });

    // Título del certificado - más grande y en negro negrilla
    doc.setFont("times", "bold");
    doc.setFontSize(65);
    doc.setTextColor(0, 0, 0); // Negro
    doc.text("CERTIFICADO", 421, 250, { align: "center" });

    // Subtítulo - en rojo vino cursiva
    doc.setFont("helvetica", "italic");
    doc.setFontSize(26);
    doc.setTextColor(120, 40, 45); // Color vino elegante
    doc.text("Se otorga el presente certificado a:", 421, 290, { align: "center" });

    // Nombre del participante - grande y en negro negrilla
    doc.setFont("helvetica", "bold");
    doc.setFontSize(42);
    doc.setTextColor(0, 0, 0); // Negro
    doc.text(nombreCompleto, 421, 340, { align: "center" });

    // Descripción del curso - en rojo vino normal
    doc.setFont("helvetica", "normal");
    doc.setFontSize(24);
    doc.setTextColor(120, 40, 45); // Color vino elegante
    doc.text("Por su participación en el evento realizado en Ambato, Ecuador", 421, 380, { align: "center" });
    
    // Fechas del evento - en negro cursiva
    const fechaActual = new Date();
    const fechaTexto = `el ${fechaActual.toLocaleDateString('es-ES')}`;
    doc.setFont("helvetica", "italic");
    doc.setFontSize(22);
    doc.setTextColor(0, 0, 0); // Negro
    doc.text(fechaTexto, 421, 405, { align: "center" });

    // Información adicional del participante - en rojo vino más pequeño
    doc.setFont("helvetica", "normal");
    doc.setFontSize(18);
    doc.setTextColor(120, 40, 45); // Color vino elegante
    doc.text(` ${correo}  •   ${cedula}`, 421, 435, { align: "center" });

    // Área de autoridades sin líneas decorativas
    const firmaY = 520;
    
    // Nombres de las autoridades - en negro negrilla
    doc.setFont("helvetica", "bold");
    doc.setFontSize(20);
    doc.setTextColor(0, 0, 0); // Negro
    doc.text("Dra. Sara Camacho", 240, firmaY, { align: "center" });
    doc.text("Ing. Santiago López", 600, firmaY, { align: "center" });
    
    // Cargos de las autoridades - en rojo vino cursiva
    doc.setFont("helvetica", "italic");
    doc.setFontSize(18);
    doc.setTextColor(120, 40, 45); // Color vino elegante
    doc.text("Rectora", 240, firmaY + 25, { align: "center" });
    doc.text("Vicerrector Académico", 600, firmaY + 25, { align: "center" });

    // Fecha y lugar en la esquina inferior - en rojo vino cursiva
    doc.setFont("helvetica", "italic");
    doc.setFontSize(20);
    doc.setTextColor(120, 40, 45); // Color vino elegante

    const blob = doc.output('blob');
    const base64 = await new Promise((resolve) => {
      const reader = new FileReader();
      reader.onloadend = () => resolve(reader.result.split(',')[1]);
      reader.readAsDataURL(blob);
    });

    await subirCertificadoBase64(base64, idUsuario, idEvento);
  }

  Swal.close();
  Swal.fire('Listo', 'Certificados generados y guardados.', 'success');
  listarCertificadosPorEvento(idEvento);
}

// Convertir imagen a base64
function cargarImagenBase64(url) {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.crossOrigin = "Anonymous";
    img.onload = function () {
      try {
        const canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;
        const ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);
        resolve(canvas.toDataURL("image/png"));
      } catch (error) {
        reject(error);
      }
    };
    img.onerror = function () {
      reject(new Error(`No se pudo cargar la imagen: ${url}`));
    };
    img.src = url;
  });
}

// Función auxiliar para obtener sufijos ordinales en inglés
function getOrdinalSuffix(day) {
  if (day > 3 && day < 21) return 'th';
  switch (day % 10) {
    case 1: return 'st';
    case 2: return 'nd';
    case 3: return 'rd';
    default: return 'th';
  }
}

document.addEventListener('DOMContentLoaded', function () {
  axios.get('../controllers/Asistencia_NotaController.php?option=eventosResponsable')
    .then(res => {
      const select = document.getElementById('selectEvento');
      select.innerHTML = '<option value="">Seleccione...</option>';
      if (res.data.length === 0) {
        select.innerHTML = '<option value="">No tienes eventos asignados</option>';
        return;
      }
      res.data.forEach(ev => {
        select.innerHTML += `<option value="${ev.SECUENCIAL}">${ev.TITULO}</option>`;
      });

      // Mostrar solo 3 opciones visibles, luego scroll
      select.size = 1; // select normal, pero el scroll aparece automáticamente si abres el select

      // Evento change: actualiza tabla
      select.addEventListener('change', function () {
        listarCertificadosPorEvento(this.value);
      });

      // Al cargar, si hay valor seleccionado, muestra la tabla
      if (select.value) {
        listarCertificadosPorEvento(select.value);
      }
    });

  document.getElementById('btnGenerarTodos')?.addEventListener('click', generarTodosPDFs);
});