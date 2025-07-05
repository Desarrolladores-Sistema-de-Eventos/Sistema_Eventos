document.addEventListener('DOMContentLoaded', function() {
    fetch('../controllers/AutoridadesController.php?option=listar')
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta recibida:', data);

            const row = document.querySelector('#autoridades-row');
            if (!row) return;

            row.innerHTML = '';

            if (Array.isArray(data)) {
                data.forEach(autoridad => {
                        console.log(autoridad); // <-- Esto te mostrará los nombres de los campos
                    row.innerHTML += `
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-4">
                            <div class="card-autoridad">
                                <div class="team-img">
                                    <img src="../public/img/${autoridad.foto_perfil ? autoridad.foto_perfil : 'default.png'}" alt="Foto de ${autoridad.nombre} ${autoridad.apellido}">
                                </div>
                                <div class="text-center">
                                    <h5>${autoridad.nombre} ${autoridad.apellido}</h5>
                                    <p>${autoridad.identificador}</p>
                                    <small>${autoridad.correo}</small>
                                </div>
                            </div>
                        </div>
                    `;

                });
            } else {
                row.innerHTML = '<div class="col-12 text-center text-danger">No se pudo cargar la información de autoridades.</div>';
            }
        })
        .catch(error => {
            console.error('Error al cargar autoridades:', error);
        });
});
