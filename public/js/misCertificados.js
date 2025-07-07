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
                ? `<a href="../documents/${data}" target="_blank" class="btn btn-dark btn-sm" style="background:#222; color:#fff; font-size:12px; font-weight:600; padding:4px 10px; border-radius:6px; display:inline-block; min-width:120px;">
                     <i class="fa fa-eye" style="color:#fff; font-size:13px; font-weight:normal;"></i> <span style="font-size:12px; font-weight:600;">Ver Certificado</span>
                   </a>`
                : '<span style="color:gray">Sin archivo</span>';
            }
          },
          
            {
  data: 'TIPO_CERTIFICADO',
  title: 'Tipo',
  className: 'text-center',
  render: function (tipo) {
    if (!tipo) {
      return '<span style="color:gray;">No asignado</span>';
    }

    const color = tipo === 'Aprobación' ? '#000' : '#000'; 

    return `<span style="background-color:${color}; color:#fff; padding:4px 10px; border-radius:4px; font-weight:600; font-size:12px;">
      ${tipo}
    </span>`;
  }
}
,
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
