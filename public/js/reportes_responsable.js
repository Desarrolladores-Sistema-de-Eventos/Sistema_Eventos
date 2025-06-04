/**
 * JS para reportes de responsable de eventos UTA
 * Incluye datos del evento en los PDFs exportados.
 */

// Variables globales para los datos del evento seleccionado
let eventoSeleccionado = {
    TITULO: '',
    FECHAINICIO: '',
    FECHAFIN: '',
    TIPO: '',
    HORAS: '',
    ESTADO: ''
};

// 1. Cargar eventos a cargo del responsable
function cargarEventosResponsable() {
    axios.get('../controllers/ReportesController.php?option=eventosResponsable')
        .then(res => {
            const eventos = res.data;
            const select = document.getElementById('select-evento');
            select.innerHTML = '<option value="">Seleccione un evento</option>';
            eventos.forEach(ev => {
                select.innerHTML += `<option value="${ev.SECUENCIAL}" 
                    data-titulo="${ev.TITULO}" 
                    data-fechainicio="${ev.FECHAINICIO}" 
                    data-fechafin="${ev.FECHAFIN}" 
                    data-tipo="${ev.TIPO}" 
                    data-horas="${ev.HORAS}" 
                    data-estado="${ev.ESTADO}"
                >${ev.TITULO} (${ev.FECHAINICIO})</option>`;
            });
        });
}

// 2. Mostrar inscritos por evento
function mostrarInscritosPorEvento(idEvento) {
    axios.get('../controllers/ReportesController.php?option=inscritosPorEvento&idEvento=' + idEvento)
        .then(res => {
            renderTabla('tabla-inscritos', res.data, [
                { label: '#', key: null },
                { label: 'Nombre', key: 'NOMBRE' },
                { label: 'Correo', key: 'CORREO' },
                { label: 'Carrera', key: 'CARRERA' },
                { label: 'Estado', key: 'ESTADO_INSCRIPCION' },
                { label: 'Fecha Inscripción', key: 'FECHAINSCRIPCION' }
            ]);
        });
}

// 3. Mostrar asistencia y notas por evento
function mostrarAsistenciaNotasPorEvento(idEvento) {
    axios.get('../controllers/ReportesController.php?option=asistenciaNotasPorEvento&idEvento=' + idEvento)
        .then(res => {
            renderTabla('tabla-asistencia', res.data, [
                { label: '#', key: null },
                { label: 'Nombre', key: 'NOMBRE' },
                { label: 'Asistencia', key: 'ASISTENCIA' },
                { label: 'Nota Final', key: 'NOTA_FINAL' }
            ]);
        });
}

// 4. Mostrar certificados emitidos por evento
function mostrarCertificadosPorEvento(idEvento) {
    axios.get('../controllers/ReportesController.php?option=certificadosPorEvento&idEvento=' + idEvento)
        .then(res => {
            renderTabla('tabla-certificados', res.data, [
                { label: '#', key: null },
                { label: 'Nombre', key: 'NOMBRE' },
                { label: 'URL Certificado', key: 'URL_CERTIFICADO' },
                { label: 'Fecha Emisión', key: 'FECHA_EMISION' }
            ]);
        });
}

// 5. Mostrar estadísticas generales del evento
function mostrarEstadisticasEvento(idEvento) {
    axios.get('../controllers/ReportesController.php?option=estadisticasEvento&idEvento=' + idEvento)
        .then(res => {
            const stats = res.data;
            let html = `
                <ul>
                    <li><b>Total inscritos:</b> ${stats.TOTAL_INSCRITOS ?? 0}</li>
                    <li><b>Total asistentes:</b> ${stats.TOTAL_ASISTENTES ?? 0}</li>
                    <li><b>Total aprobados:</b> ${stats.TOTAL_APROBADOS ?? 0}</li>
                    <li><b>Total certificados emitidos:</b> ${stats.TOTAL_CERTIFICADOS ?? 0}</li>
                </ul>
            `;
            document.getElementById('estadisticas-evento').innerHTML = html;
        });
}

// Utilidad para renderizar tablas
function renderTabla(idTabla, data, columns) {
    const tbody = document.querySelector(`#${idTabla} tbody`);
    tbody.innerHTML = '';
    if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="${columns.length}" class="text-center">Sin datos</td></tr>`;
        return;
    }
    data.forEach((row, idx) => {
        let tr = '<tr>';
        columns.forEach(col => {
            if (col.key === null) {
                tr += `<td>${idx + 1}</td>`;
            } else {
                let valor = row[col.key];
                // Mostrar enlace para certificado si aplica
                if (col.key === 'URL_CERTIFICADO') {
                    valor = valor ? `<a href="../facturas_Comprobantes/${valor}" target="_blank" style="color:#d32f2f;font-weight:bold;">Ver PDF</a>` : 'N/A';
                } else if (valor === undefined || valor === null) {
                    valor = '';
                }
                tr += `<td>${valor}</td>`;
            }
        });
        tr += '</tr>';
        tbody.innerHTML += tr;
    });
}

// Utilidad para descargar tabla como CSV
function descargarTablaComoCSV(idTabla, nombreArchivo) {
    const table = document.getElementById(idTabla);
    let csv = [];
    // Encabezados
    let headers = [];
    table.querySelectorAll('thead th').forEach(th => headers.push(th.innerText));
    csv.push(headers.join(','));
    // Filas
    table.querySelectorAll('tbody tr').forEach(tr => {
        let row = [];
        tr.querySelectorAll('td').forEach(td => {
            let text = td.innerText.replace(/"/g, '""');
            row.push('"' + text + '"');
        });
        csv.push(row.join(','));
    });
    // Descargar
    const blob = new Blob([csv.join('\n')], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = nombreArchivo;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Utilidad para descargar tabla como PDF (usa jsPDF y autoTable)
function descargarTablaComoPDF(idTabla, nombreArchivo, tituloReporte) {
    const table = document.getElementById(idTabla);
    if (!table) return;
    const doc = new window.jspdf.jsPDF('l', 'pt', 'a4');
    doc.setFontSize(16);
    doc.text(tituloReporte, 40, 40);

    // Imprimir datos del evento
    let y = 60;
    doc.setFontSize(11);
    doc.text(`Evento: ${eventoSeleccionado.TITULO}`, 40, y);
    doc.text(`Fecha: ${eventoSeleccionado.FECHAINICIO} a ${eventoSeleccionado.FECHAFIN}`, 320, y);
    y += 16;
    doc.text(`Tipo: ${eventoSeleccionado.TIPO}`, 40, y);
    doc.text(`Horas: ${eventoSeleccionado.HORAS}`, 320, y);
    doc.text(`Estado: ${eventoSeleccionado.ESTADO}`, 500, y);

    // Extraer encabezados y filas
    let headers = [];
    table.querySelectorAll('thead th').forEach(th => headers.push(th.innerText));
    let rows = [];
    table.querySelectorAll('tbody tr').forEach(tr => {
        let row = [];
        tr.querySelectorAll('td').forEach(td => {
            row.push(td.innerText);
        });
        rows.push(row);
    });

    // autoTable
    doc.autoTable({
        head: [headers],
        body: rows,
        startY: y + 20,
        theme: 'grid',
        headStyles: { fillColor: [211, 47, 47] }, // UTA rojo institucional
        alternateRowStyles: { fillColor: [232, 234, 246] }, // azul claro
        styles: { fontSize: 10 }
    });

    doc.save(nombreArchivo);
}

// Inicialización y listeners
document.addEventListener('DOMContentLoaded', function() {
    cargarEventosResponsable();

    // Cuando se selecciona un evento, cargar los reportes y guardar los datos del evento
    document.getElementById('select-evento').addEventListener('change', function() {
        const idEvento = this.value;
        if (!idEvento) return;

        // Guardar datos del evento seleccionado
        const option = this.options[this.selectedIndex];
        eventoSeleccionado = {
            TITULO: option.getAttribute('data-titulo') || '',
            FECHAINICIO: option.getAttribute('data-fechainicio') || '',
            FECHAFIN: option.getAttribute('data-fechafin') || '',
            TIPO: option.getAttribute('data-tipo') || '',
            HORAS: option.getAttribute('data-horas') || '',
            ESTADO: option.getAttribute('data-estado') || ''
        };

        mostrarInscritosPorEvento(idEvento);
        mostrarAsistenciaNotasPorEvento(idEvento);
        mostrarCertificadosPorEvento(idEvento);
        mostrarEstadisticasEvento(idEvento);
    });

    // Botones de descarga CSV
    document.getElementById('btn-descargar-inscritos').addEventListener('click', function() {
        descargarTablaComoCSV('tabla-inscritos', 'inscritos_evento.csv');
    });
    document.getElementById('btn-descargar-asistencia').addEventListener('click', function() {
        descargarTablaComoCSV('tabla-asistencia', 'asistencia_notas_evento.csv');
    });
    document.getElementById('btn-descargar-certificados').addEventListener('click', function() {
        descargarTablaComoCSV('tabla-certificados', 'certificados_evento.csv');
    });

    // Botones de descarga PDF (requiere jsPDF y autoTable)
    document.getElementById('btn-descargar-inscritos-pdf').addEventListener('click', function() {
        descargarTablaComoPDF('tabla-inscritos', 'inscritos_evento.pdf', 'Reporte de Inscritos');
    });
    document.getElementById('btn-descargar-asistencia-pdf').addEventListener('click', function() {
        descargarTablaComoPDF('tabla-asistencia', 'asistencia_notas_evento.pdf', 'Reporte de Asistencia y Notas');
    });
    document.getElementById('btn-descargar-certificados-pdf').addEventListener('click', function() {
        descargarTablaComoPDF('tabla-certificados', 'certificados_evento.pdf', 'Reporte de Certificados Emitidos');
    });
});