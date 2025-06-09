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
      tarjeta.classList.add('tarjeta-evento', 'activo');

      tarjeta.innerHTML = `
        <img src="../${evento.PORTADA || 'assets/img/default.jpg'}" alt="Evento" class="evento-img">
        <h4><i class="fa fa-calendar-alt"></i> ${evento.TITULO}</h4>
        <p><i class="fa fa-calendar"></i> <strong>${formatearFecha(evento.FECHAINICIO)}</strong> al <strong>${formatearFecha(evento.FECHAFIN)}</strong></p>
        <p><i class="fa fa-clock"></i> En curso</p>
        <p><i class="fa fa-check-circle"></i> <span class="inscrito">Inscrito</span></p>
      `;

      contenedor.appendChild(tarjeta);
    });
  }

  function formatearFecha(fechaISO) {
    const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
    const fecha = new Date(fechaISO);
    return fecha.toLocaleDateString('es-ES', opciones);
  }

  // Buscador
  inputBusqueda.addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    const tarjetas = document.querySelectorAll('.tarjeta-evento');

    tarjetas.forEach(tarjeta => {
      const titulo = tarjeta.querySelector('h4')?.textContent.toLowerCase() || '';
      tarjeta.style.display = titulo.includes(filtro) ? '' : 'none';
    });
  });

  cargarEventos();
});
