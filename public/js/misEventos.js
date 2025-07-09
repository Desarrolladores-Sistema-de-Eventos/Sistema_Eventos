document.addEventListener('DOMContentLoaded', function () {
  const contenedor = document.querySelector('.eventos-grid');
  const inputBusqueda = document.getElementById('buscarEvento');

  function cargarEventos() {
    axios.get('../controllers/EventosController.php?option=eventosInscritoCurso')
      .then(res => {
        const eventos = res.data;

        if (Array.isArray(eventos) && eventos.length > 0) {
          mostrarTarjetas(eventos);
        } else {
          contenedor.innerHTML = '<p style="text-align:center; width:100%">No tienes eventos en curso actualmente.</p>';
        }
      })
      .catch(err => {
        console.error('Error cargando eventos en curso:', err);
        contenedor.innerHTML = '<p style="text-align:center; color:red;">Error al cargar eventos.</p>';
      });
  }

  function mostrarTarjetas(eventos) {
    contenedor.innerHTML = ''; // Limpiar tarjetas actuales

    eventos.forEach(evento => {
      const tarjeta = document.createElement('div');
      tarjeta.classList.add('tarjeta-evento', 'activo', 'shadow-sm');

     tarjeta.innerHTML = `
  <img src="../public/img/eventos/portadas/${evento.PORTADA || 'assets/img/default.jpg'}" alt="Evento" class="evento-img rounded-top" style="height: 170px; object-fit: cover;">
  <div class="p-3 bg-white rounded-bottom">

    <h5 class="text-dark font-weight-bold mb-3">
      <i class="fa fa-calendar-alt mr-2 text-danger"></i> ${evento.TITULO}
    </h5>

    <div class="info-line">
      <i class="fa fa-calendar text-curso"></i>
      <span class="etiqueta">${evento.TIPO_EVENTO || 'General'}</span>
    </div>

    <div class="info-line">
      <i class="fa fa-flag text-estado"></i>
      <span>Estado: <span class="estado-label ${evento.ESTADO.toLowerCase()}">${evento.ESTADO}</span></span>
    </div>

    <div class="info-line">
      <i class="fa fa-check-circle text-inscrito"></i>
      <span class="inscrito-texto">Inscrito</span>
    </div>

    <div class="text-center mt-3">
      <button class="btn btn-sm ver-contenido btn-ver"
              data-contenido="${evento.CONTENIDO || ''}">
        <i class="fas fa-book-open"></i> Ver Contenido
      </button>
    </div>

  </div>
`;

      contenedor.appendChild(tarjeta);
    });
  }

  function formatearFecha(fechaISO) {
    const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
    const fecha = new Date(fechaISO);
    return fecha.toLocaleDateString('es-ES', opciones);
  }
  function mostrarModalContenido(contenido) {
  $('#contenidoModal .modal-body').html(contenido || '<p class="text-muted">Sin contenido disponible.</p>');
  $('#contenidoModal').modal('show');
}


  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('ver-contenido') || e.target.closest('.ver-contenido')) {
      const btn = e.target.closest('.ver-contenido');
      const contenido = btn.dataset.contenido || 'Sin contenido registrado.';
      mostrarModalContenido(contenido);
    }
  });

  inputBusqueda.addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    const tarjetas = document.querySelectorAll('.tarjeta-evento');

    tarjetas.forEach(tarjeta => {
      const titulo = tarjeta.querySelector('h5')?.textContent.toLowerCase() || '';
      tarjeta.style.display = titulo.includes(filtro) ? '' : 'none';
    });
  });

  cargarEventos();
});

