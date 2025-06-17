document.addEventListener('DOMContentLoaded', function () {
  axios.get('../controllers/CertificadoControler.php?option=listarPorUsuario')
    .then(res => {
      const certificados = res.data;

      const tabla = $('#tablaCertificados');

      if (!Array.isArray(certificados) || certificados.length === 0) {
        tabla.html('<tr><td colspan="6" style="text-align:center">No hay certificados disponibles</td></tr>');
        return;
      }

      tabla.DataTable({
        data: certificados,
        destroy: true, // Permite reinicializar
        language: {
          url: '../public/js/es-ES.json'
        },
        columns: [
          { data: 'SECUENCIAL', title: 'Orden', className: 'text-center' },
          { data: 'EVENTO', title: 'Evento', className: 'text-center' },
          {
            data: 'CORREO',
            title: 'Correo',
            className: 'text-center',
            render: function (data) {
              return data || 'No disponible';
            }
          },
          {
            data: 'URL_CERTIFICADO',
            title: 'Certificado',
            className: 'text-center',
            render: function (data) {
              return data
                ? `<a href="../documents/${data}" target="_blank" class="btn btn-danger btn-sm">
                     <i class="fa fa-certificate"></i> <small>Ver</small>
                   </a>`
                : '<span style="color:gray">Sin archivo</span>';
            }
          },
          {
            data: 'ESTADO_INSCRIPCION',
            title: 'Tipo',
            className: 'text-center',
            render: function (estado) {
              const tipo = estado === 'ACE' ? 'Aprobación' : 'Participación';
              return `<span class="label label-info">${tipo}</span>`;
            }
          },
          {
            data: 'FECHA_EMISION',
            title: 'Fecha Registro',
            className: 'text-center',
            render: function (fechaISO) {
              const fecha = new Date(fechaISO);
              return fecha.toLocaleDateString('es-EC') + ' ' + fecha.toLocaleTimeString('es-EC');
            }
          }
        ]
      });
    })
    .catch(err => {
      console.error('Error al cargar certificados:', err);
      $('#tablaCertificados').html('<tr><td colspan="6" style="text-align:center;color:red;">Error al cargar certificados</td></tr>');
    });
});
