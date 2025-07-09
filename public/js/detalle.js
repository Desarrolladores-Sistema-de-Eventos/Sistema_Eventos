document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    if (!id) return;

    axios.get(`../controllers/EventosPublicosController.php?option=detalleCompleto&id=${id}`)
        .then(res => {
            const ev = res.data;
            console.log('Evento cargado:', ev);

            // Mostrar info del evento en pantalla
            const setText = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value || '';
            };

            const setHTML = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.innerHTML = value || '';
            };

            const setSrc = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.src = value || '';
            };

            // Llenar campos
            setText('tituloEvento', ev.TITULO);
            setText('descripcionEvento', ev.DESCRIPCION);
            setText('horasEvento', ev.HORAS);
            setText('costoEvento', ev.COSTO ? parseFloat(ev.COSTO).toFixed(2) : '');
            setText('notaAprobacion', ev.NOTAAPROBACION);
            setText('publicoObjetivo', ev.ES_SOLO_INTERNOS ? 'Solo público interno' : 'Público externo e interno');
            setText('fechaInicio', ev.FECHAINICIO);
            setText('fechaFin', ev.FECHAFIN);
            setText('carrera', ev.CARRERA);
            setText('modalidad', ev.MODALIDAD);
            setText('tipoEvento', ev.TIPO_EVENTO);

            // Imagen principal
            if (ev.GALERIA && ev.GALERIA.length) {
                setSrc('galeriaEvento', '../' + ev.GALERIA[0]);
            } else if (ev.PORTADA) {
                setSrc('galeriaEvento', '../' + ev.PORTADA);
            }

            // Requisitos (texto)
            let reqHtml = '<ul>';
            if (ev.REQUISITOS && ev.REQUISITOS.length) {
                ev.REQUISITOS.forEach(r => reqHtml += `<li>${r}</li>`);
            } else {
                reqHtml += '<li>No hay requisitos registrados</li>';
            }
            reqHtml += '</ul>';
            setHTML('requisitosEvento', reqHtml);

            // Organizador
            if (ev.ORGANIZADOR) {
                setText('nombreOrganizador', `${ev.ORGANIZADOR.NOMBRES} ${ev.ORGANIZADOR.APELLIDOS}`);
                setText('correoOrganizador', ev.ORGANIZADOR.CORREO);
                setSrc('fotoOrganizador', '../public/img/' + (ev.ORGANIZADOR.FOTO_PERFIL || 'public/img/blog-3.jpg'));
            }

            // Redirigir al formulario de inscripción
            document.getElementById('btnInscribirse').addEventListener('click', function () {
    axios.get('../controllers/AuthController.php?option=checkAuth')
        .then(res => {
            if (res.data.authenticated) {
                // Redirige al formulario de inscripción con el ID del evento
                window.location.href = `../views/FormInscribirse.php?id=${ev.SECUENCIAL}`;
            } else {
                // Si no está autenticado, mostrar alerta con opción de iniciar sesión
                Swal.fire({
                    title: '¡Necesitas estar registrado!',
                    text: 'Para inscribirte en el evento debes iniciar sesión.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Iniciar sesión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../views/login.php';
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error al verificar autenticación:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al verificar tu sesión. Intenta nuevamente.',
                icon: 'error'
            });
        });
});


        }).catch(err => {
            console.error('Error al cargar el evento:', err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar la información del evento.'
            });
        });
});
