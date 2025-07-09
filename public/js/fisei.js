document.addEventListener('DOMContentLoaded', function () {
    // Cargar info de la facultad
    fetch('/controllers/FacultadController.php')
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('facultad-nombre').textContent = data.NOMBRE;
                document.getElementById('facultad-mision').textContent = data.MISION;
                document.getElementById('facultad-vision').textContent = data.VISION;
                document.getElementById('facultad-ubicacion').textContent = data.UBICACION;

            }
        });

// Cargar carreras de la FISEI
fetch('../controllers/ConfiguracionesController.php?option=carrera_fisei')
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('carreras-row');
        container.innerHTML = '';

        // Filtrar carreras con imagen válida
        if (!Array.isArray(data)) {

        }

        const carrerasConImagen = data.filter(c => c.IMAGEN && c.IMAGEN.trim() !== '');

        if (!Array.isArray(carrerasConImagen) || carrerasConImagen.length === 0) {
            container.innerHTML = "<p class='text-center w-100'>No hay carreras disponibles.</p>";
            return;
        }

            carrerasConImagen.forEach(carrera => {
                container.innerHTML += `
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                            <div class="ratio ratio-4x3 bg-light">
                                <img class="w-100 h-100 object-fit-cover" style="object-fit:cover; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;" src="../${carrera.IMAGEN}" alt="${carrera.NOMBRE_CARRERA}">
                            </div>
                            <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fa fa-graduation-cap fa-2x mb-2 text-primary"></i>
                                <h5 class="card-title text-center mb-1" style="font-size:1.08rem; font-weight:600;">${carrera.NOMBRE_CARRERA}</h5>
                            </div>
                        </div>
                    </div>
                `;
            });



    })
    .catch(err => {
        console.error("Error al cargar carreras FISEI:", err);
        const container = document.getElementById('carreras-row');
        container.innerHTML = "<p class='text-danger text-center w-100'>Error al cargar las carreras why.</p>";
    });


});

//Cargar descripción de la facultad
document.addEventListener('DOMContentLoaded', function () {
    fetch('/controllers/FacultadController.php?option=listar')
        .then(response => response.json())
        .then(data => {
            if (data && data.ABOUT) {
                const about = document.getElementById('facultad-about');
                if (about) {
                    about.innerHTML = data.ABOUT;
                }
            }
        })
        .catch(err => {
            console.error("Error al cargar la descripción de la facultad:", err);
        });
});