document.addEventListener('DOMContentLoaded', function() {
    fetch('../controllers/FacultadController.php')
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('facultad-nombre').textContent = data.NOMBRE;
                document.getElementById('facultad-mision').textContent = data.MISION;
                document.getElementById('facultad-vision').textContent = data.VISION;
                document.getElementById('facultad-ubicacion').textContent = data.UBICACION;
            }
        });
});