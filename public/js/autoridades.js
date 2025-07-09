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
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-2">
                            <div class="team-item bg-white mb-4">
                                <div class="team-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="../public/img/${autoridad.foto_perfil ? autoridad.foto_perfil : 'default.png'}" alt="Foto de ${autoridad.nombre} ${autoridad.apellido}">
                                </div>
                                <div class="text-center py-4">
                                    <h5 class="text-truncate">${autoridad.nombre} ${autoridad.apellido}</h5>
                                    <p class="text-muted">${autoridad.identificador}</p>
                                    <small class="text-muted">${autoridad.correo}</small>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                row.innerHTML = '<div class="col-12 text-center text-danger">No se pudo cargar la información de autoridades.</div>';
                console.error('La respuesta no es un array:', data);
            }
        })
        .catch(error => {
            console.error('Error al cargar autoridades:', error);
        });
});
