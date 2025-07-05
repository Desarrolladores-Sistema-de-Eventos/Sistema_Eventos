// Cargar facultades en el select del modal de autoridades
$(document).ready(function() {
    const selectFacultad = document.getElementById('facultadAutoridad');
    if (!selectFacultad) return;
    fetch('../controllers/ConfiguracionesController.php?option=facultad_listar')
        .then(res => res.json())
        .then(facultades => {
            selectFacultad.innerHTML = '<option value="">Seleccione facultad...</option>';
            if (Array.isArray(facultades)) {
                facultades.forEach(f => {
                    selectFacultad.innerHTML += `<option value="${f.SECUENCIAL}">${f.NOMBRE}</option>`;
                });
            } else {
                selectFacultad.innerHTML = '<option value="">No hay facultades</option>';
            }
        })
        .catch(() => {
            selectFacultad.innerHTML = '<option value="">Error al cargar facultades</option>';
        });
});
