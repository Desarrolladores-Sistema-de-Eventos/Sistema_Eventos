function cargarTarjetas() {
    axios.get('../controllers/Asistencia_NotaController.php?option=eventosResponsable')
    .then(res => {
      const eventos = res.data;
      console.log(eventos);
      let html = '';
      eventos.forEach(e => {
        html += `
        <div class="col-lg-3 col-md-4 col-sm-6 col-12" style="padding:8px; margin-left: 20px;">
          <div class="panel panel-danger" style="width:100%; margin:auto; margin-bottom:0;">
            <div class="panel-heading text-center" style="font-weight:bold; font-size:15px;">
              ${e.TITULO}
            </div>
            <div class="panel-body text-center" style="padding:10px;">
              <img src="../${e.IMAGEN || 'public/img/default.jpg'}" alt="Portada" style="width:95%;max-width:270px;height:150px;object-fit:cover;margin-bottom:8px;">
              <p style="margin-bottom:4px; font-size:14px;"><b>Fecha:</b> ${e.FECHAINICIO}</p>
              <p style="margin-bottom:4px; font-size:14px;"><b>Horas:</b> ${e.HORAS}</p>
              <p style="margin-bottom:4px; font-size:14px;"><b>Estado:</b> ${e.ESTADO}</p>
            </div>
            <div class="panel-footer text-center" style="padding:6px;">
              <button class="btn btn-success btn-sm" onclick="window.location.href='dashboard_Notas_Res.php?idEvento=${e.SECUENCIAL}&titulo=${encodeURIComponent(e.TITULO)}&fecha=${encodeURIComponent(e.FECHAINICIO)}&tipo=${encodeURIComponent(e.TIPO_EVENTO)}'">
                <i class="fa fa-edit"></i>
              </button>
            </div>
          </div>
        </div>
        `;
      });
      document.getElementById('contenedor-eventos').innerHTML = html;
    });
}

// Mostrar tabla de inscritos aceptados para calificar
function verInscritosEvento(idEvento, titulo, fecha, tipo) {
    axios.get('../controllers/Asistencia_NotaController.php?option=inscritosEvento&idEvento=' + idEvento)
        .then(res => {
            console.log(res); 
            document.getElementById('titulo-evento').textContent = titulo;
            document.getElementById('fecha-evento').textContent = fecha;
            document.getElementById('tipo-evento').textContent = tipo;
            document.getElementById('total-inscritos').textContent = res.data.length;

            // Selecciona el tbody usando el id correcto de la tabla
            const tbody = document.querySelector('#tablas-notas tbody');
            tbody.innerHTML = '';
            res.data.forEach((ins, idx) => {
                const esEditable = false; 
                tbody.innerHTML += `
                <tr>
                    <td>${idx + 1}</td>
                    <td>${ins.NOMBRE}</td>
                    <td>
                        <select class="form-control form-control-sm" id="asistencia-${ins.INSCRIPCION_ID}" ${esEditable ? '' : 'disabled'}>
                            <option value="1" ${ins.ASISTENCIA == 1 ? 'selected' : ''}>✔️</option>
                            <option value="0" ${ins.ASISTENCIA == 0 ? 'selected' : ''}>❌</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" min="0" max="10" step="0.1" class="form-control form-control-sm" id="nota-${ins.INSCRIPCION_ID}" value="${ins.NOTA !== null ? ins.NOTA : ''}" ${esEditable ? '' : 'disabled'}>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" id="btn-editar-${ins.INSCRIPCION_ID}" onclick="habilitarEdicion(${ins.INSCRIPCION_ID})" title="Editar">
                            <i class="fa fa-pencil" style="color: #000;"></i>
                        </button>
                        <button class="btn btn-success btn-sm d-none" id="btn-guardar-${ins.INSCRIPCION_ID}" onclick="guardarAsistenciaNota(${ins.INSCRIPCION_ID})" title="Guardar">
                            <i class="fa fa-save" style="color: #000;"></i>
                        </button>
                    </td>
                </tr>
                `;
            });
            // DataTable usando el id correcto de la tabla
            setTimeout(() => {
                const tabla = $('#tablas-notas');
                if ( $.fn.DataTable.isDataTable(tabla) ) {
                    tabla.DataTable().destroy();
                }
                tabla.DataTable({
                    language: {
                        url: '../public/js/es-ES.json'
                    },
                    lengthChange: true,
                    responsive: true
                });
            }, 100);

            document.getElementById('seccion-eventos') && (document.getElementById('seccion-eventos').style.display = 'none');
            document.getElementById('seccion-notas').style.display = 'block';
        });
}

// Guardar asistencia y nota
function guardarAsistenciaNota(idInscripcion) {
    const asistencia = document.getElementById('asistencia-' + idInscripcion).value;
    const nota = document.getElementById('nota-' + idInscripcion).value;

    const formData = new FormData();
    formData.append('idInscripcion', idInscripcion);
    formData.append('asistencia', asistencia);
    formData.append('nota', nota);

    axios.post('../controllers/Asistencia_NotaController.php?option=guardarAsistenciaNota', formData)
        .then(res => {
            // Combina mensaje principal y mensaje de certificado si existe
            let mensaje = res.data.mensaje ? res.data.mensaje : (res.data.success ? 'Registro actualizado correctamente.' : 'No se pudo guardar.');
            if (res.data.mensaje_certificado) {
                mensaje += '\n' + res.data.mensaje_certificado;
            }
            Swal.fire({
                icon: res.data.success ? 'success' : 'error',
                title: res.data.success ? 'Guardado' : 'Error',
                text: mensaje,
                timer: 2200,
                showConfirmButton: false
            });
            // Deshabilita los campos y muestra solo el botón Editar
            document.getElementById('asistencia-' + idInscripcion).disabled = true;
            document.getElementById('nota-' + idInscripcion).disabled = true;
            document.getElementById('btn-editar-' + idInscripcion).classList.remove('d-none');
            document.getElementById('btn-guardar-' + idInscripcion).classList.add('d-none');
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error de red',
                text: 'No se pudo conectar con el servidor.',
                timer: 1800,
                showConfirmButton: false
            });
            console.error(error);
        });
}
// Volver a la vista de eventos
function volverAEventos() {
    document.getElementById('seccion-notas').style.display = 'none';
    document.getElementById('seccion-eventos').style.display = 'block';
}
function habilitarEdicion(idInscripcion) {
    document.getElementById('asistencia-' + idInscripcion).disabled = false;
    document.getElementById('nota-' + idInscripcion).disabled = false;
    document.getElementById('btn-editar-' + idInscripcion).classList.add('d-none');
    document.getElementById('btn-guardar-' + idInscripcion).classList.remove('d-none');
}

document.addEventListener('DOMContentLoaded', function() {
    // Obtén los parámetros de la URL
    const params = new URLSearchParams(window.location.search);
    const idEvento = params.get('idEvento');
    const titulo = params.get('titulo');
    const fecha = params.get('fecha');
    const tipo = params.get('tipo');
    
    if (idEvento) {
        verInscritosEvento(idEvento, titulo, fecha, tipo);
    }
});
// Inicializar
document.addEventListener('DOMContentLoaded', cargarTarjetas);