// Función reutilizable con diseño personalizado UTA
function mostrarAlertaUTA(titulo, mensaje, tipo = 'info') {
    Swal.fire({
        title: titulo,
        text: mensaje,
        imageUrl: '../public/img/sweet.png',
        imageAlt: 'Icono UTA',
        confirmButtonText: 'Aceptar',
        customClass: {
            popup: 'swal2-popup',
            confirmButton: 'swal2-confirm'
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const idEvento = params.get('id');
    let eventoActual = null;

    if (!idEvento) {
        mostrarAlertaUTA('Error', 'Evento no especificado', 'error');
        return;
    }

    // 1. Cargar evento
    axios.get(`../controllers/EventosPublicosController.php?option=detalleCompleto&id=${idEvento}`)
        .then(res => {
            eventoActual = res.data;

            document.getElementById('tituloEvento').value = eventoActual.TITULO;
            document.getElementById('horasEvento').value = eventoActual.HORAS;
            document.getElementById('modalidadEvento').value = eventoActual.MODALIDAD;
            document.getElementById('estadoEvento').value = eventoActual.ESTADO;
            document.getElementById('fechaInicioEvento').value = eventoActual.FECHAINICIO;
            document.getElementById('fechaFinEvento').value = eventoActual.FECHAFIN;

            // Mostrar requisitos
            let html = '';
            let ids = [];
            if (eventoActual.REQUISITOS && eventoActual.REQUISITOS.length) {
                eventoActual.REQUISITOS.forEach((req, i) => {
                    const id = req.SECUENCIAL || i + 1;
                    html += `<li class="mb-3">
                                <strong>${req.NOMBRE || req}</strong><br>
                                <input type="file" id="archivoRequisito_${id}" class="form-control" required>
                             </li>`;
                    ids.push(id);
                });
            } else {
                html = "<li>No hay requisitos para este evento.</li>";
            }
            eventoActual.REQUISITOS_ID = ids;
            document.getElementById('requisitosList').innerHTML = html;

            // Mostrar u ocultar campos de pago
            const esPagado = parseInt(eventoActual.ES_PAGADO) === 1;
            if (esPagado) {
                document.getElementById('tipoPago').required = true;
                document.getElementById('archivoPago').required = true;
            } else {
                document.getElementById('tipoPago').parentElement.style.display = 'none';
                document.getElementById('archivoPago').parentElement.style.display = 'none';
            }

            // 2. Cargar datos del usuario
            axios.get('../controllers/UsuarioController.php?option=miPerfil')
                .then(user => {
                    const u = user.data;
                    document.getElementById('nombreUsuario').value = `${u.NOMBRES} ${u.APELLIDOS}`;
                    document.getElementById('cedulaUsuario').value = u.CEDULA;
                    document.getElementById('correoUsuario').value = u.CORREO;
                    document.getElementById('telefonoUsuario').value = u.TELEFONO;
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

    // 3. Enviar inscripción
    document.getElementById('formInscripcion').addEventListener('submit', function (e) {
        e.preventDefault();

        if (!eventoActual || !eventoActual.REQUISITOS_ID) {
            mostrarAlertaUTA('Error', 'Datos del evento incompletos.', 'error');
            return;
        }

        axios.get(`../controllers/EventosController.php?option=validarInscripcion&id=${idEvento}`)
            .then(response => {
                if (!response.data.disponible) {
                    mostrarAlertaUTA('Atención', response.data.mensaje, 'warning');
                    return;
                }

                const formData = new FormData();
                formData.append('id_evento', idEvento);
                formData.append('es_pagado', parseInt(eventoActual.ES_PAGADO));
                formData.append('monto', eventoActual.COSTO || 0);
                formData.append('forma_pago', document.getElementById('tipoPago').value || '');
                formData.append('requisitos', JSON.stringify(eventoActual.REQUISITOS_ID));

                eventoActual.REQUISITOS_ID.forEach(id => {
                    const input = document.getElementById(`archivoRequisito_${id}`);
                    if (input && input.files[0]) {
                        formData.append(`requisito_${id}`, input.files[0]);
                    }
                });

                const comprobante = document.getElementById('archivoPago');
                if (comprobante && comprobante.files[0]) {
                    formData.append('comprobante_pago', comprobante.files[0]);
                }

                axios.post('../controllers/EventosController.php?option=registrarInscripcion', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(res => {
                    Swal.fire({
                        title: res.data.mensaje,
                        imageUrl: '../public/img/sweet.png',
                        imageAlt: 'Icono UTA',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            popup: 'swal2-popup',
                            confirmButton: 'swal2-confirm'
                        }
                    }).then(() => {
                        if (res.data.tipo === 'success') {
                            window.location.href = '../index.php';
                        }
                    });
                }).catch(error => {
                    console.error('Error al registrar inscripción:', error);
                    mostrarAlertaUTA('Error', 'No se pudo registrar la inscripción.', 'error');
                });
            })
            .catch(err => {
                console.error('Error al validar disponibilidad:', err);
                mostrarAlertaUTA('Error', 'No se pudo validar la disponibilidad.', 'error');
            });
    });
});
