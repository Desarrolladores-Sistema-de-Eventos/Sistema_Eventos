// Listar certificados por evento (para responsable)
function listarCertificadosPorEvento(idEvento) {
    axios.get('../controllers/CertificadoControler.php?option=listarPorEvento&idEvento=' + idEvento)
        .then(res => {
            // 1. Destruir DataTable si ya está inicializado
            if ($.fn.DataTable.isDataTable('#tabla-certificados')) {
                $('#tabla-certificados').DataTable().destroy();
            }

            // 2. Limpiar el tbody
            const tbody = document.querySelector('#tabla-certificados tbody');
            tbody.innerHTML = '';

            // 3. Llenar el tbody con los nuevos datos
            res.data.forEach((row, idx) => {
                tbody.innerHTML += `
                    <tr>
                        <td>${idx + 1}</td>
                        <td>${row.EVENTO}</td>
                        <td>${row.NOMBRES} ${row.APELLIDOS}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="generarCertificadoPDFySubir(${row.SECUENCIAL}, '../public/img/plantilla.png')">
                                <i class="fa fa-magic" style="color: #000;"></i> <span style="color: #000;">Generar PDF</span>
                            </button>
                            <button class="btn btn-info btn-sm" onclick="verCertificado('${row.URL_CERTIFICADO}')">
                                <i class="fa fa-file-pdf-o" style="color: #000;"></i> <span style="color: #000;">Ver</span>
                            </button>
                            <button class="btn btn-warning btn-sm" onclick="editarCertificado(${row.SECUENCIAL})">
                                <i class="fa fa-edit" style="color: #000;"></i> <span style="color: #000;">Editar</span>
                            </button>
                        </td>
                    </tr>
                `;
            });

            // 4. Inicializar DataTable
            $('#tabla-certificados').DataTable({
                language: {
                    url: '../public/js/es-ES.json'
                },
                lengthChange: true,
                responsive: true
            });
        });
}

// FALTA IMPLEMENTAR BIEN
function listarCertificadosPorUsuario(idUsuario) {
    axios.get('../controllers/CertificadoControler.php?option=listarPorUsuario&idUsuario=' + idUsuario)
        .then(res => {
            const tbody = document.querySelector('#tabla-certificados-usuario tbody');
            tbody.innerHTML = '';
            res.data.forEach((row, idx) => {
                let accion = '';
                const aceptado = row.ESTADO_INSCRIPCION === 'ACEPTADO' || row.ESTADO_INSCRIPCION === 1;
                const asistencia = row.ASISTENCIA == 1;
                const notaOk = parseFloat(row.NOTA) >= 7;
                if (aceptado && asistencia && notaOk) {
                    if (row.URL_CERTIFICADO && row.URL_CERTIFICADO !== '') {
                        accion = `<button class="btn btn-success btn-sm" onclick="verCertificado('${row.URL_CERTIFICADO}')">Ver</button>`;
                    } else {
                        accion = `<button class="btn btn-primary btn-sm" onclick="generarCertificadoUsuario(${row.SECUENCIAL}, '${row.EVENTO}', '${row.FECHA_EMISION}')">Generar</button>`;
                    }
                } else {
                    accion = `<span class="text-muted">No disponible</span>`;
                }
                tbody.innerHTML += `
                    <tr>
                        <td>${idx + 1}</td>
                        <td>${row.EVENTO}</td>
                        <td>${accion}</td>
                        <td>${row.FECHA_EMISION || ''}</td>
                    </tr>
                `;
            });
        });
}

function verCertificado(url) {
    window.open('../documents/' + url, '_blank');
}

function editarCertificado(idCertificado) {
    const urlCertificado = prompt("Nueva URL del certificado:");
    if (!urlCertificado) return;
    const formData = new FormData();
    formData.append('idCertificado', idCertificado);
    formData.append('urlCertificado', urlCertificado);

    axios.post('../controllers/CertificadoControler.php?option=editar', formData)
        .then(res => {
            Swal.fire(res.data.mensaje);
        });
}

function generarCertificadoPDFySubir(idCertificado, urlFondo) {
    axios.get('../controllers/CertificadoControler.php?option=datosParaGenerar&idCertificado=' + idCertificado)
        .then(async res => {
            if (!res.data || res.data.tipo === 'error') {
                Swal.fire('Error', res.data.mensaje || 'No se pudo obtener los datos', 'error');
                return;
            }

            const cert = res.data;
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({
                orientation: "landscape",
                unit: "px",
                format: [842, 595]
            });

            const fondo = await cargarImagenBase64(urlFondo);
            doc.addImage(fondo, 'PNG', 0, 0, 842, 595);

            // Bajamos todo 40px
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
            doc.text(cert.NOMBRES + ' ' + cert.APELLIDOS, 421, 270 + offsetY, { align: "center" });

            doc.setFont("helvetica", "normal");
            doc.setFontSize(18);
            doc.setTextColor("#000");
            doc.text("Por su participación en el evento:", 421, 300 + offsetY, { align: "center" });

            doc.setFont("helvetica", "bold");
            doc.setFontSize(20);
            doc.text(cert.EVENTO || cert.TITULO, 421, 330 + offsetY, { align: "center" });

            doc.setFont("helvetica", "italic");
            doc.setFontSize(14);
            doc.text(`Ambato, ${cert.FECHA_EMISION || (new Date()).toLocaleDateString()}`, 421, 370 + offsetY, { align: "center" });

            const pdfBlob = doc.output('blob');
            await subirCertificadoPDF(pdfBlob, cert.SECUENCIALUSUARIO, cert.SECUENCIALEVENTO);
            listarCertificadosPorEvento(cert.SECUENCIALEVENTO);
        });
}


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

async function subirCertificadoPDF(pdfBlob, idUsuario, idEvento) {
    const formData = new FormData();
    formData.append('certificado', pdfBlob, 'certificado.pdf');
    formData.append('idUsuario', idUsuario);
    formData.append('idEvento', idEvento);

    const response = await axios.post(
        '../controllers/CertificadoControler.php?option=subirCertificado',
        formData,
        { headers: { 'Content-Type': 'multipart/form-data' } }
    );
    Swal.fire(response.data.mensaje);

    // Si el backend devuelve la URL del certificado, ábrelo automáticamente
   // if (response.data.url_certificado) {
      //  window.open('../documents/' + response.data.url_certificado, '_blank');
   // }
}
// Cargar eventos del responsable al cargar la página
 document.addEventListener('DOMContentLoaded', function() {
        axios.get('../controllers/Asistencia_NotaController.php?option=eventosResponsable')
            .then(res => {
                const select = document.getElementById('selectEvento');
                select.innerHTML = '';
                if (res.data.length === 0) {
                    select.innerHTML = '<option value="">No tienes eventos asignados</option>';
                    return;
                }
                res.data.forEach(ev => {
                    select.innerHTML += `<option value="${ev.SECUENCIAL}">${ev.TITULO}</option>`;
                });
                // Cargar certificados del primer evento
                listarCertificadosPorEvento(select.value);
                // Cambiar evento
                select.addEventListener('change', function() {
                    listarCertificadosPorEvento(this.value);
                });
            });
    });
 function editarCertificado(idCertificado) {
        document.getElementById('editIdCertificado').value = idCertificado;
        $('#modalEditarCertificado').modal('show');
    }
    function guardarEdicionCertificado() {
        const idCertificado = document.getElementById('editIdCertificado').value;
        const urlCertificado = document.getElementById('editUrlCertificado').value;
        if (!urlCertificado) {
            Swal.fire('Error', 'Debe ingresar la nueva URL', 'error');
            return;
        }
        const formData = new FormData();
        formData.append('idCertificado', idCertificado);
        formData.append('urlCertificado', urlCertificado);

        axios.post('../controllers/CertificadoControler.php?option=editar', formData)
            .then(res => {
                Swal.fire(res.data.mensaje);
                $('#modalEditarCertificado').modal('hide');
                listarCertificadosPorEvento(document.getElementById('selectEvento').value);
            });
    }