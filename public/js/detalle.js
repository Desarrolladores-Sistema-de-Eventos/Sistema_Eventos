// --- Lógica de inscripción (antes en inscribirse.js) ---
function mostrarAlertaUTA(titulo, mensaje, tipo = 'info') {
    Swal.fire({
        title: titulo,
        text: mensaje,
        imageUrl: '../public/img/uta/sweet.png',
        imageAlt: 'Icono UTA',
        imageWidth: 100,
        imageHeight: 100,
        confirmButtonText: 'Aceptar',
        customClass: {
            popup: 'swal2-popup custom-popup',
            confirmButton: 'swal2-confirm'
        }
    });
}

function cargarDatosInscripcion(idEvento) {
    // 1. Cargar evento
    axios.get(`../controllers/EventosPublicosController.php?option=detalleCompleto&id=${idEvento}`)
        .then(res => {
            const evento = res.data;
            document.getElementById('tituloEventoModal').value = evento.TITULO;
            document.getElementById('horasEventoModal').value = evento.HORAS;
            document.getElementById('modalidadEvento').value = evento.MODALIDAD;
            document.getElementById('estadoEvento').value = evento.ESTADO;
            document.getElementById('fechaInicioEvento').value = evento.FECHAINICIO;
            document.getElementById('fechaFinEvento').value = evento.FECHAFIN;
            document.getElementById('idEvento').value = idEvento;

            // 2. Cargar usuario
    axios.get('../controllers/UsuarioController.php?option=miPerfil')
        .then(user => {
            const u = user.data;
            document.getElementById('nombreUsuario').value = `${u.NOMBRES} ${u.APELLIDOS}`;
            document.getElementById('cedulaUsuario').value = u.CEDULA;
            document.getElementById('correoUsuario').value = u.CORREO;
            document.getElementById('telefonoUsuario').value = u.TELEFONO;

            // Validar que ningún campo esté vacío
            const camposObligatorios = [u.NOMBRES, u.APELLIDOS, u.CEDULA, u.CORREO, u.TELEFONO];
            const camposNombres = ['Nombres', 'Apellidos', 'Cédula', 'Correo', 'Teléfono'];
            let camposVacios = [];
            camposObligatorios.forEach((valor, idx) => {
                if (!valor || valor.toString().trim() === '') {
                    camposVacios.push(camposNombres[idx]);
                }
            });
            if (camposVacios.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Actualiza tu perfil',
                    html: `Para inscribirte debes completar todos los datos de tu perfil.<br><b>Campos incompletos:</b><br>${camposVacios.join(', ')}<br><br>Haz clic en Aceptar para actualizar tu perfil.`,
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'swal2-popup custom-popup',
                        confirmButton: 'swal2-confirm'
                    }
                }).then(() => {
                    window.location.href = '../views/dashboard_Pri_Usu.php';
                });
                // Deshabilita el botón de inscripción si existe
                const btn = document.getElementById('btnInscribirseEnviar');
                if (btn) btn.disabled = true;
                return;
            }

            // 3. Verificar requisitos
            axios.get(`../controllers/EventosController.php?option=requisitosUsuarioEvento&idEvento=${idEvento}`)
                .then(resp => {
                    const requisitos = Array.isArray(resp.data) ? resp.data : [];
                    let html = '';
                    if (requisitos.length) {
                        requisitos.forEach(req => {
                            const badge = req.cumplido
                                ? '<span class="badge rounded-pill bg-success px-3">✔ Subido</span>'
                                : '<span class="badge rounded-pill bg-secondary px-3">✖ No Subido</span>';
                            html += `<li class="list-group-item d-flex justify-content-between align-items-center">${req.descripcion}${badge}</li>`;
                        });
                    } else {
                        html = "<li class='list-group-item'>No hay requisitos para este evento.</li>";
                    }
                    document.getElementById('requisitosList').innerHTML = html;
                })
                .catch(error => {
                    console.error("Error al verificar requisitos:", error);
                    document.getElementById('requisitosList').innerHTML = "<li class='list-group-item'>Error al cargar requisitos.</li>";
                });
        })
        .catch(err => {
            console.error('Error al obtener usuario', err);
            mostrarAlertaUTA('Error', 'No se pudo cargar los datos del usuario.', 'error');
        });
        })
        .catch(err => {
            console.error('Error al cargar el evento:', err);
            mostrarAlertaUTA('Error', 'No se pudo cargar la información del evento.', 'error');
        });

    // 4. Enviar inscripción incompleta (sin comprobante ni requisitos aún)
    const form = document.getElementById('formInscripcion');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            axios.get(`../controllers/EventosController.php?option=validarInscripcion&id=${idEvento}`)
                .then(function(response) {
                    if (!response.data.disponible) {
                        mostrarAlertaUTA('Atención', response.data.mensaje, 'warning');
                        return;
                    }
                    const formData = new FormData();
                    formData.append('id_evento', idEvento);
                    const motivacion = document.getElementById('motivacionUsuario') ? document.getElementById('motivacionUsuario').value.trim() : '';
                    formData.append('motivacion', motivacion);
                    axios.post('../controllers/EventosController.php?option=registrarInscripcionIncompleta', formData)
                        .then(function(res) {
                            Swal.fire({
                                title: res.data.mensaje,
                                html: '<div style="margin-top:10px;font-size:16px;">Suba los requisitos y el comprobante desde su dashboard en <b>Mis Inscripciones</b>.</div>',
                                imageUrl: '../public/img/uta/sweet.png',
                                imageAlt: 'Icono UTA',
                                imageWidth: 100,
                                imageHeight: 100,
                                confirmButtonText: 'Aceptar',
                                customClass: {
                                    popup: 'swal2-popup custom-popup',
                                    confirmButton: 'swal2-confirm'
                                }
                            }).then(() => {
                                if (res.data.tipo === 'success') {
                                        window.location.href = '../views/Eventos_Publico.php';
                                }
                            });
                        })
                        .catch(function(error) {
                            console.error('Error al registrar inscripción:', error);
                            mostrarAlertaUTA('Error', 'No se pudo registrar la inscripción.', 'error');
                        });
                })
                .catch(function(err) {
                    console.error('Error al validar disponibilidad:', err);
                    mostrarAlertaUTA('Error', 'No se pudo validar la disponibilidad.', 'error');
                });
        }, { once: true });
    }
}
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
            // Interpretar HTML en la descripción (por ejemplo, si se usó CKEditor o similar)
            setHTML('descripcionEvento', ev.DESCRIPCION);
            setText('horasEvento', ev.HORAS);
            // Mostrar "Gratis" si el costo es null, vacío, 0 o 0.00
            let mostrarGratis = false;
            if (
                ev.COSTO === null ||
                ev.COSTO === undefined ||
                ev.COSTO === '' ||
                parseFloat(ev.COSTO) === 0
            ) {
                mostrarGratis = true;
            }
            setText('costoEvento', mostrarGratis ? 'Gratis' : parseFloat(ev.COSTO).toFixed(2));

            // Nota de aprobación: ocultar h6 y p si es null, vacío, 0 o 0.00
            const notaAprobacionP = document.getElementById('notaAprobacion');
            // Buscar el h6 anterior (hermano previo)
            let notaAprobacionH6 = notaAprobacionP ? notaAprobacionP.previousElementSibling : null;
            let mostrarNota = true;
            if (
                ev.NOTAAPROBACION === null ||
                ev.NOTAAPROBACION === undefined ||
                ev.NOTAAPROBACION === '' ||
                parseFloat(ev.NOTAAPROBACION) === 0
            ) {
                mostrarNota = false;
            }
            if (notaAprobacionP) {
                notaAprobacionP.style.display = mostrarNota ? '' : 'none';
            }
            if (notaAprobacionH6) {
                notaAprobacionH6.style.display = mostrarNota ? '' : 'none';
            }
            setText('notaAprobacion', mostrarNota ? ev.NOTAAPROBACION : '');
            setText('publicoObjetivo', ev.ES_SOLO_INTERNOS ? 'Solo público interno' : 'Público externo e interno');
            setText('fechaInicio', ev.FECHAINICIO);
            setText('fechaFin', ev.FECHAFIN);
            // Mostrar carreras asociadas (formato vertical)
            if (ev.CARRERAS && Array.isArray(ev.CARRERAS) && ev.CARRERAS.length) {
                // Mostrar carreras en formato "recto" (una debajo de otra, alineadas a la izquierda)
                const carrerasHtml = ev.CARRERAS.map(c => `<div>${c.NOMBRE_CARRERA}</div>`).join('');
                setHTML('carrera', carrerasHtml);
            } else if (ev.CARRERA) {
                setText('carrera', ev.CARRERA); // fallback por compatibilidad
            } else {
                setHTML('carrera', '');
            }
            setText('modalidad', ev.MODALIDAD);
            setText('tipoEvento', ev.TIPO_EVENTO);

            // Imagen principal
            if (ev.GALERIA && ev.GALERIA.length) {
                setSrc('galeriaEvento', '../public/img/eventos/galerias/' + ev.GALERIA[0]);
            } else if (ev.PORTADA) {
                setSrc('galeriaEvento', '../public/img/eventos/portadas/' + ev.PORTADA);
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

            if (ev.CONTENIDO) {
                // Interpretar HTML en el contenido (por ejemplo, si se usó CKEditor o similar)
                setHTML('contenidoEvento', ev.CONTENIDO);
            }

            // Organizador
            if (ev.ORGANIZADOR) {
                setText('nombreOrganizador', `${ev.ORGANIZADOR.NOMBRES} ${ev.ORGANIZADOR.APELLIDOS}`);
                setText('correoOrganizador', ev.ORGANIZADOR.CORREO);
                setSrc('fotoOrganizador', '../public/img/perfiles/' + (ev.ORGANIZADOR.FOTO_PERFIL || 'public/img/user.jpg'));
            }

            // Abrir el formulario de inscripción en el modal (ahora embebido)
            document.getElementById('btnInscribirse').addEventListener('click', function (e) {
                e.preventDefault();
                axios.get('../controllers/AuthController.php?option=checkAuth')
                    .then(res => {
                        if (res.data.authenticated) {
                            const modalEl = document.getElementById('modalInscribirse');
                            const modal = new bootstrap.Modal(modalEl);
                            modal.show();
                            cargarDatosInscripcion(ev.SECUENCIAL);

                            // Asegura que los botones cierren el modal correctamente
                            // Botón X personalizado
                            const closeBtn = modalEl.querySelector('.btn-close');
                            if (closeBtn) {
                                closeBtn.onclick = function() {
                                    modal.hide();
                                };
                            }
                            // Botón Cancelar
                            const cancelBtn = modalEl.querySelector('button.btn-outline-secondary[data-bs-dismiss="modal"]');
                            if (cancelBtn) {
                                cancelBtn.onclick = function(e) {
                                    e.preventDefault();
                                    modal.hide();
                                };
                            }
                        } else {
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
