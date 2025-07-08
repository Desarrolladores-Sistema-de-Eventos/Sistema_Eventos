// Script para mostrar foto de perfil y notificaciones de inscripciones pendientes

document.addEventListener('DOMContentLoaded', function() {
  // Solo ejecuta si existe el contenedor de foto y badge
  const fotoPerfil = document.getElementById('fotoPerfilHeader');
  const badge = document.getElementById('badgeNotificacion');
  if (!fotoPerfil || !badge) return;

  // Obtener datos de perfil
  axios.get('../controllers/UsuarioController.php?option=miPerfil')
    .then(res => {
      if (res.data && res.data.FOTO_PERFIL) {
        let url = '../public/img/perfiles/' + (res.data.FOTO_PERFIL || 'default.png');
        fotoPerfil.src = url;
      }
    });

  // Consultar inscripciones pendientes y notificaciones
  let notificacionesPrevias = [];
  function arraysIguales(a, b) {
    if (a.length !== b.length) return false;
    for (let i = 0; i < a.length; i++) {
      if (a[i].INSCRIPCION_ID !== b[i].INSCRIPCION_ID || a[i].CODIGOESTADOINSCRIPCION !== b[i].CODIGOESTADOINSCRIPCION) return false;
    }
    return true;
  }
  function consultarPendientesYNotificaciones(forceUpdate = false) {
    axios.get('../controllers/InscripcionesController.php?option=listarPendientesResponsable')
      .then(res => {
        const lista = document.getElementById('listaNotificaciones');
        const notificaciones = Array.isArray(res.data) ? res.data : [];
        const total = notificaciones.length;
        // Solo actualizar si hay cambios o si es forzado
        if (!arraysIguales(notificaciones, notificacionesPrevias) || forceUpdate) {
          notificacionesPrevias = notificaciones;
          if (total > 0) {
            badge.textContent = total;
            badge.style.display = 'inline-block';
          } else {
            badge.style.display = 'none';
          }
          // Renderizar notificaciones
          if (lista) {
            if (total === 0) {
              lista.innerHTML = '<div style="padding: 18px; text-align: center; color: #888;">No hay notificaciones nuevas.</div>';
            } else {
              lista.innerHTML = notificaciones.map(n => `
                <div style="padding: 12px 16px; border-bottom: 1px solid #f2f2f2; display: flex; align-items: flex-start; gap: 10px;">
                  <i class='fa fa-user-circle' style='font-size: 22px; color: #9b2e2e; margin-top: 2px;'></i>
                  <div style="flex:1;">
                    <div style="font-weight: 500; font-size: 15px;">${n.NOMBRE_COMPLETO} se inscribió a <b>${n.EVENTO}</b></div>
                    <div style="font-size: 13px; color: #888; margin-top: 2px;">Estado: <b>${n.CODIGOESTADOINSCRIPCION === 'PEN' ? 'Pendiente' : 'Rechazado'}</b></div>
                    <a href="../views/dashboard_Ins_Res.php?idEvento=${n.SECUENCIALEVENTO}&idInscripcion=${n.INSCRIPCION_ID}" style="font-size: 13px; color: #b53232; text-decoration: underline;">Ver inscripción</a>
                  </div>
                </div>
              `).join('');
            }
          }
        }
      });
  }
  consultarPendientesYNotificaciones(true);
  // Escucha eventos de aceptación/rechazo de inscripción para refrescar notificaciones
  window.addEventListener('inscripcionActualizada', function() {
    consultarPendientesYNotificaciones(true);
  });
  setInterval(consultarPendientesYNotificaciones, 2000);

  // Mostrar/ocultar panel de notificaciones al hacer click en la campana
  const campana = document.getElementById('notificacionInscripciones');
  const panel = document.getElementById('panelNotificaciones');
  let panelVisible = false;
  if (campana && panel) {
    campana.onclick = function(e) {
      e.stopPropagation();
      panelVisible = !panelVisible;
      panel.style.display = panelVisible ? 'block' : 'none';
    };
    // Ocultar panel si se hace click fuera
    document.addEventListener('click', function(ev) {
      if (panelVisible && !panel.contains(ev.target) && ev.target !== campana && !campana.contains(ev.target)) {
        panel.style.display = 'none';
        panelVisible = false;
      }
    });
  }
});
