// Notificaciones de inscripciones aprobadas para DOCENTE, ESTUDIANTE, INVITADO

document.addEventListener('DOMContentLoaded', function() {
  const fotoPerfil = document.getElementById('fotoPerfilHeader');
  const badge = document.getElementById('badgeAprobacion');
  const panel = document.getElementById('panelAprobaciones');
  const lista = document.getElementById('listaAprobaciones');
  const campana = document.getElementById('notificacionAprobaciones');
  if (!fotoPerfil || !badge || !panel || !lista || !campana) return;

  // Obtener datos de perfil
  axios.get('../controllers/UsuarioController.php?option=miPerfil')
    .then(res => {
      if (res.data && res.data.FOTO_PERFIL) {
        let url = '../public/img/perfiles/' + (res.data.FOTO_PERFIL || 'default.png');
        fotoPerfil.src = url;
      }
    });

  // Consultar certificados generados
  function consultarCertificadosDisponibles() {
    axios.get('../controllers/InscripcionesController.php?option=notificacionesCertificadosUsuario')
      .then(res => {
        const notificaciones = Array.isArray(res.data) ? res.data : [];
        if (notificaciones.length > 0) {
          badge.textContent = notificaciones.length;
          badge.style.display = 'inline-block';
        } else {
          badge.style.display = 'none';
        }
        if (notificaciones.length === 0) {
          lista.innerHTML = '<div style="padding: 18px; text-align: center; color: #888;">No hay notificaciones nuevas.</div>';
        } else {
          // Filtrar certificados generados hoy
          const hoy = new Date().toISOString().slice(0, 10);
          const recientes = notificaciones.filter(n => (n.FECHA_CERTIFICADO || '').slice(0, 10) === hoy);
          if (recientes.length === 0) {
            lista.innerHTML = '<div style="padding: 18px; text-align: center; color: #888;">No hay notificaciones nuevas.</div>';
          } else {
            lista.innerHTML = recientes.map(n => `
              <div style=\"padding: 12px 16px; border-bottom: 1px solid #f2f2f2; display: flex; align-items: flex-start; gap: 10px;\">
                <i class='fa fa-certificate' style='font-size: 22px; color: #2980b9; margin-top: 2px;'></i>
                <div style=\"flex:1;\">
                  <div style=\"font-weight: 500; font-size: 15px;\">¡Tu certificado del evento <b>${n.EVENTO}</b> ya está disponible!</div>
                  <div style=\"font-size: 13px; color: #888; margin-top: 2px;\">Fecha: <b>${n.FECHA_CERTIFICADO || ''}</b></div>
                  <a href="../views/dashboard_Cer_Usu.php" style=\"font-size: 13px; color: #2980b9; text-decoration: underline;\">Ir a mis certificados</a>
                </div>
              </div>
            `).join('');
          }
        }
      });
  }
  consultarCertificadosDisponibles();
  setInterval(consultarCertificadosDisponibles, 2000);

  // Mostrar/ocultar panel de notificaciones al hacer click en la campana
  let panelVisible = false;
  campana.onclick = function(e) {
    e.stopPropagation();
    panelVisible = !panelVisible;
    panel.style.display = panelVisible ? 'block' : 'none';
  };
  document.addEventListener('click', function(ev) {
    if (panelVisible && !panel.contains(ev.target) && ev.target !== campana && !campana.contains(ev.target)) {
      panel.style.display = 'none';
      panelVisible = false;
    }
  });
});
