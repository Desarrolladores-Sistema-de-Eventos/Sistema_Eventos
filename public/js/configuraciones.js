// URL base del controlador
const CONFIG_CTRL = '../controllers/ConfiguracionesController.php';

// Utilidad para peticiones POST
async function postConfig(option, data = {}) {
    const formData = new FormData();
    for (const key in data) {
        formData.append(key, data[key]);
    }
    const res = await fetch(`${CONFIG_CTRL}?option=${option}`, {
        method: 'POST',
        body: formData
    });
    return res.json();
}

// Utilidad para peticiones GET
async function getConfig(option) {
    const res = await fetch(`${CONFIG_CTRL}?option=${option}`);
    return res.json();
}

// ================= FACULTAD =================
async function listarFacultades() {
    const data = await getConfig('facultad_listar');
    // Aquí deberías renderizar la tabla con los datos recibidos
    // Ejemplo: renderFacultadesTable(data);
}

async function guardarFacultad(facultad) {
    return await postConfig('facultad_guardar', facultad);
}

async function actualizarFacultad(facultad) {
    return await postConfig('facultad_actualizar', facultad);
}

async function eliminarFacultad(id) {
    return await postConfig('facultad_eliminar', { id });
}

// ================= CARRERA =================
async function listarCarreras() {
    const data = await getConfig('carrera_listar');
    // renderCarrerasTable(data);
}

async function guardarCarrera(carrera) {
    return await postConfig('carrera_guardar', carrera);
}

async function actualizarCarrera(carrera) {
    return await postConfig('carrera_actualizar', carrera);
}

async function eliminarCarrera(id) {
    return await postConfig('carrera_eliminar', { id });
}

// ================= TIPO EVENTO =================
async function listarTiposEvento() {
    const data = await getConfig('tipo_evento_listar');
    // renderTiposEventoTable(data);
}

async function guardarTipoEvento(tipo) {
    return await postConfig('tipo_evento_guardar', tipo);
}

async function actualizarTipoEvento(tipo) {
    return await postConfig('tipo_evento_actualizar', tipo);
}

async function eliminarTipoEvento(codigo) {
    return await postConfig('tipo_evento_eliminar', { codigo });
}

// ================= CATEGORIA EVENTO =================
async function listarCategoriasEvento() {
    const data = await getConfig('categoria_evento_listar');
    // renderCategoriasEventoTable(data);
}

async function guardarCategoriaEvento(categoria) {
    return await postConfig('categoria_evento_guardar', categoria);
}

async function actualizarCategoriaEvento(categoria) {
    return await postConfig('categoria_evento_actualizar', categoria);
}

async function eliminarCategoriaEvento(id) {
    return await postConfig('categoria_evento_eliminar', { id });
}

// ================= MODALIDAD EVENTO =================
async function listarModalidadesEvento() {
    const data = await getConfig('modalidad_evento_listar');
    // renderModalidadesEventoTable(data);
}

async function guardarModalidadEvento(modalidad) {
    return await postConfig('modalidad_evento_guardar', modalidad);
}

async function actualizarModalidadEvento(modalidad) {
    return await postConfig('modalidad_evento_actualizar', modalidad);
}

async function eliminarModalidadEvento(codigo) {
    return await postConfig('modalidad_evento_eliminar', { codigo });
}

// ================= REQUISITO EVENTO =================
async function listarRequisitosEvento() {
    const data = await getConfig('requisito_evento_listar');
    // renderRequisitosEventoTable(data);
}

async function guardarRequisitoEvento(requisito) {
    return await postConfig('requisito_evento_guardar', requisito);
}

async function actualizarRequisitoEvento(requisito) {
    return await postConfig('requisito_evento_actualizar', requisito);
}

async function eliminarRequisitoEvento(id) {
    return await postConfig('requisito_evento_eliminar', { id });
}

// ================= FORMA DE PAGO =================
async function listarFormasPago() {
    const data = await getConfig('forma_pago_listar');
    // renderFormasPagoTable(data);
}

async function guardarFormaPago(forma) {
    return await postConfig('forma_pago_guardar', forma);
}

async function actualizarFormaPago(forma) {
    return await postConfig('forma_pago_actualizar', forma);
}

async function eliminarFormaPago(codigo) {
    return await postConfig('forma_pago_eliminar', { codigo });
}

// ================= ROL USUARIO =================
async function listarRolesUsuario() {
    const data = await getConfig('rol_usuario_listar');
    // renderRolesUsuarioTable(data);
}

async function guardarRolUsuario(rol) {
    return await postConfig('rol_usuario_guardar', rol);
}

async function actualizarRolUsuario(rol) {
    return await postConfig('rol_usuario_actualizar', rol);
}

async function eliminarRolUsuario(codigo) {
    return await postConfig('rol_usuario_eliminar', { codigo });
}

// ================= Ejemplo de uso =================
// Puedes llamar a las funciones desde tus eventos de formulario, por ejemplo:
// document.getElementById('btnGuardarFacultad').onclick = async () => {
//     const facultad = { nombre: ..., mision: ..., vision: ..., ubicacion: ... };
//     const res = await guardarFacultad(facultad);
//     alert(res.mensaje);
//     listarFacultades();
// }