const CONFIG_CTRL = '../controllers/ConfiguracionesController.php';

// POST utilitario
async function postCarrusel(option, data = {}, files = {}) {
    const formData = new FormData();
    for (const key in data) formData.append(key, data[key]);
    for (const key in files) formData.append(key, files[key]);

    const res = await fetch(`${CONFIG_CTRL}?option=${option}`, {
        method: 'POST',
        body: formData
    });
    return res.json();
}

async function getCarrusel() {
    const res = await fetch(`${CONFIG_CTRL}?option=carrusel_listar`);
    return res.json();
}

async function guardarImagenCarrusel(data, file) {
    return await postCarrusel('carrusel_guardar', data, { imagen: file });
}

async function eliminarImagenCarrusel(id) {
    return await postCarrusel('carrusel_eliminar', { id });
}
