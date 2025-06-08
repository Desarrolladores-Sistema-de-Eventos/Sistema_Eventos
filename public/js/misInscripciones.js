document.addEventListener('DOMContentLoaded', function () {
  $('#tablaInscripciones').DataTable({
    ajax: {
      url: '../controllers/InscripcionesController.php?option=listarPorUsuario',
      dataSrc: ''
    },
    columns: [
      { data: 'SECUENCIAL', title: 'Orden', className: 'text-center' },
      { data: 'EVENTO', title: 'Evento', className: 'text-center' },
      {
        data: null,
        title: 'Factura',
        className: 'text-center',
        render: function (data, type, row) {
          const id = row.SECUENCIAL;
          const estado = row.CODIGOESTADOINSCRIPCION;

          if (estado === 'ACE') {
            return `
              <button class="btn btn-success btn-sm" onclick="verFacturaDinamica(${id})" title="Ver factura">
                <i class="fa fa-certificate"></i> Ver Factura
              </button>
            `;
          } else {
            return `
              <button class="btn btn-secondary btn-sm" disabled title="Solo si está aceptada">
                <i class="fa fa-certificate"></i> No disponible
              </button>
            `;
          }
        }
      },
      {
        data: 'CODIGOESTADOINSCRIPCION',
        title: 'Estado Inscripción',
        className: 'text-center',
        render: function (estado) {
          let texto = 'Desconocido';
          let color = 'gray';

          switch (estado) {
            case 'ACE': texto = 'ACEPTADO'; color = 'green'; break;
            case 'PEN': texto = 'PENDIENTE'; color = 'orange'; break;
            case 'RECH': texto = 'RECHAZADO'; color = 'red'; break;
            case 'COM': texto = 'COMPLETADO'; color = 'blue'; break;
          }

          return `<span style="color:${color}; font-weight:bold;">${texto}</span>`;
        }
      },
      {
        data: 'FECHAINSCRIPCION',
        title: 'Fecha Inscripción',
        className: 'text-center',
        render: function (fechaISO) {
          const fecha = new Date(fechaISO);
          return fecha.toLocaleDateString('es-EC') + ' ' +
                 fecha.toLocaleTimeString('es-EC', {
                   hour: '2-digit',
                   minute: '2-digit',
                   second: '2-digit'
                 });
        }
      }
    ],
    language: {
      url: '../public/js/es-ES.json'
    },
    responsive: true,
    pageLength: 5,
    order: [[4, 'desc']]
  });
});

function verFacturaDinamica(idInscripcion) {
  window.open(`../views/factura.php?id=${idInscripcion}`, '_blank');
}
