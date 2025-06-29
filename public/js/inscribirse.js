function mostrarAlertaUTA(titulo, mensaje, tipo = 'info') {
    Swal.fire({
        title: titulo,
        text: mensaje,
        imageUrl: '../public/img/sweet.png',
        imageAlt: 'Icono UTA',
        imageWidth: 100,         // ← Tamaño controlado
        imageHeight: 100,
        confirmButtonText: 'Aceptar',
        customClass: {
            popup: 'swal2-popup custom-popup', // puedes definir estilo propio si quieres más ajustes
            confirmButton: 'swal2-confirm'
        }
    });
}


document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const idEvento = params.get('id');

    if (!idEvento) {
        mostrarAlertaUTA('Error', 'Evento no especificado', 'error');
        return;
    }

    // 1. Cargar evento
    axios.get(`../controllers/EventosPublicosController.php?option=detalleCompleto&id=${idEvento}`)
        .then(res => {
            const evento = res.data;

            document.getElementById('tituloEvento').value = evento.TITULO;
            document.getElementById('horasEvento').value = evento.HORAS;
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

                    // 3. Verificar requisitos
                   axios.get(`../controllers/EventosController.php?option=requisitosUsuarioEvento&idEvento=${idEvento}`)
    .then(resp => {
        const requisitos = Array.isArray(resp.data) ? resp.data : [];
        let html = '';

        if (requisitos.length) {
            requisitos.forEach(req => {
                const badge = req.cumplido
                    ? '<span class="badge rounded-pill bg-success px-3">✔</span>'
                    : '<span class="badge rounded-pill bg-secondary px-3">✖</span>';

                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                            ${req.descripcion}
                            ${badge}
                        </li>`;
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
    document.getElementById('formInscripcion').addEventListener('submit', function (e) {
        e.preventDefault();

        axios.get(`../controllers/EventosController.php?option=validarInscripcion&id=${idEvento}`)
            .then(response => {
                if (!response.data.disponible) {
                    mostrarAlertaUTA('Atención', response.data.mensaje, 'warning');
                    return;
                }

                const formData = new FormData();
                formData.append('id_evento', idEvento);

                axios.post('../controllers/EventosController.php?option=registrarInscripcionIncompleta', formData)
                    .then(res => {
                        Swal.fire({
                            title: res.data.mensaje,
                            imageUrl: '../public/img/sweet.png',
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
                                window.location.href = '../index.php';
                            }
                        });
                    })
                    .catch(error => {
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
