document.addEventListener('DOMContentLoaded', function () {
    cargarEventosPublicos();
    cargarCategorias();
    cargarEventosRecientes();
    cargarFiltros();
});

let paginaActual = 1;
const eventosPorPagina = 6;

function cargarEventosPublicos(page = 1) {
    axios.get(`../controllers/EventosPublicosController.php?option=listarPublicos&page=${page}&limit=${eventosPorPagina}`)
        .then(res => {
            const data = res.data;
            const contenedor = document.getElementById('contenedorEventos');
            contenedor.innerHTML = '';
            if (!data.eventos || data.eventos.length === 0) {
                contenedor.innerHTML = '<div class="col-12 text-center">No hay cursos disponibles.</div>';
                actualizarPaginador(1, 1);
                return;
            }
            data.eventos.forEach(ev => {
                contenedor.innerHTML += `
                <div class="col-md-6 mb-4">
                    <div class="package-item bg-white mb-2">
                        <div style="font-weight: bold; color: #d9534f; font-size: 14px; margin-bottom: 5px;">
                            ${ev.ESTADO}
                        </div>
                        <img class="img-fluid" src="../${ev.PORTADA || 'public/img/default-event.jpg'}" alt="${ev.TITULO}">
                        <div class="p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <small class="m-0"><i class="fas fa-book-open text-primary mr-2"></i>${ev.TIPO_EVENTO}</small>
                                <small class="m-0"><i class="fas fa-hourglass-half text-primary mr-2"></i>${ev.HORAS} horas</small>
                                <small class="m-0"><i class="fas fa-user-graduate text-primary mr-2"></i>&nbsp;</small>
                            </div>
                            <a class="h5 text-decoration-none" href="Evento_Detalle.php?id=${ev.SECUENCIAL}">${ev.TITULO}</a>
                            <div class="border-top mt-4 pt-4">
                                <div class="d-flex justify-content-between">
                                    <h6 class="m-0"><i class="fas fa-star text-primary mr-2"></i>4.5 <small>(250)</small></h6>
                                    <h5 class="m-0">$${parseFloat(ev.COSTO).toFixed(2)}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            });
            actualizarPaginador(data.page, Math.ceil(data.total / data.limit));
        })
        .catch(() => {
            document.getElementById('contenedorEventos').innerHTML = '<div class="col-12 text-danger">Error al cargar los cursos.</div>';
            actualizarPaginador(1, 1);
        });
}

function actualizarPaginador(pagina, totalPaginas, soloUno = false) {
    const paginador = document.querySelector('.pagination');
    if (!paginador) return;
    let html = '';

    html += `<li class="page-item${pagina === 1 ? ' disabled' : ''}">
                <a class="page-link" href="#" aria-label="Previous" data-page="${pagina - 1}">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;

    for (let i = 1; i <= totalPaginas; i++) {
        html += `<li class="page-item${i === pagina ? ' active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
    }

    html += `<li class="page-item${pagina === totalPaginas ? ' disabled' : ''}">
                <a class="page-link" href="#" aria-label="Next" data-page="${pagina + 1}">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;

    paginador.innerHTML = html;

    paginador.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const page = parseInt(this.getAttribute('data-page'));
            if (!isNaN(page) && page > 0 && page <= totalPaginas && page !== pagina) {
                // Si hay filtros activos, usa aplicarFiltros; si no, cargarEventosPublicos
                if (
                    document.getElementById('filtroTipo').value ||
                    document.getElementById('filtroCategoria').value ||
                    document.getElementById('filtroModalidad').value ||
                    document.getElementById('filtroCarrera').value ||
                    document.getElementById('filtroFecha').value ||
                    document.getElementById('filtroBusqueda').value
                ) {
                    aplicarFiltros(page);
                } else {
                    cargarEventosPublicos(page);
                }
            }
        });
    });
}

function cargarCategorias() {
    axios.get('../controllers/EventosPublicosController.php?option=listarCategorias')
        .then(res => {
            const ul = document.getElementById('listaCategorias');
            ul.innerHTML = '';
            if (!res.data || res.data.length === 0) {
                ul.innerHTML = '<li class="mb-3 text-center">Sin categorías</li>';
                return;
            }
            res.data.forEach(cat => {
                ul.innerHTML += `
                    <li class="mb-3 d-flex justify-content-between align-items-center">
                        <a class="text-dark" href="#"><i class="fa fa-angle-right text-primary mr-2"></i>${cat.NOMBRE}</a>
                        <span class="badge badge-primary badge-pill">${cat.TOTAL}</span>
                    </li>
                `;
            });
        })
        .catch(() => {
            document.getElementById('listaCategorias').innerHTML = '<li class="mb-3 text-danger">Error al cargar categorías</li>';
        });
}
document.getElementById('inputBusqueda').addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        buscarEventos(this.value);
    }
});

function buscarEventos(keyword) {
    axios.get('../controllers/EventosPublicosController.php?option=buscarEventos&keyword=' + encodeURIComponent(keyword))
        .then(res => {
            const contenedor = document.getElementById('contenedorEventos');
            contenedor.innerHTML = '';
            if (!res.data || res.data.length === 0) {
                contenedor.innerHTML = '<div class="col-12 text-center">No se encontraron eventos.</div>';
                return;
            }
            res.data.forEach(ev => {
                contenedor.innerHTML += `
                <div class="col-md-6 mb-4">
                    <div class="package-item bg-white mb-2">
                        <div style="font-weight: bold; color: #d9534f; font-size: 14px; margin-bottom: 5px;">
                            ${ev.ESTADO}
                        </div>
                        <img class="img-fluid" src="../${ev.PORTADA || 'public/img/default-event.jpg'}" alt="${ev.TITULO}">
                        <div class="p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <small class="m-0"><i class="fas fa-book-open text-primary mr-2"></i>${ev.TIPO_EVENTO}</small>
                                <small class="m-0"><i class="fas fa-hourglass-half text-primary mr-2"></i>${ev.HORAS} horas</small>
                                <small class="m-0"><i class="fas fa-user-graduate text-primary mr-2"></i>&nbsp;</small>
                            </div>
                            <a class="h5 text-decoration-none" href="Evento_Detalle.php?id=${ev.SECUENCIAL}">${ev.TITULO}</a>
                            <div class="border-top mt-4 pt-4">
                                <div class="d-flex justify-content-between">
                                    <h6 class="m-0"><i class="fas fa-star text-primary mr-2"></i>4.5 <small>(250)</small></h6>
                                    <h5 class="m-0">$${parseFloat(ev.COSTO).toFixed(2)}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            });
        })
        .catch(() => {
            document.getElementById('contenedorEventos').innerHTML = '<div class="col-12 text-danger">Error al buscar eventos.</div>';
        });
}
function cargarEventosRecientes() {
    axios.get('../controllers/EventosPublicosController.php?option=eventosRecientes&limite=3')
        .then(res => {
            const contenedor = document.getElementById('eventosRecientesSidebar');
            contenedor.innerHTML = '';
            if (!res.data || res.data.length === 0) {
                contenedor.innerHTML = '<div class="text-center">Sin eventos recientes</div>';
                return;
            }
            res.data.forEach(ev => {
                contenedor.innerHTML += `
                    <a class="d-flex align-items-center text-decoration-none bg-white mb-3" href="Evento_Detalle.php?id=${ev.SECUENCIAL}">
                        <img class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;" src="../${ev.PORTADA || 'public/img/default-event.jpg'}" alt="${ev.TITULO}">
                        <div class="pl-3">
                            <h6 class="m-1">${ev.TITULO}</h6>
                            <small>${ev.FECHAINICIO ? ev.FECHAINICIO : ''}</small>
                        </div>
                    </a>
                `;
            });
        })
        .catch(() => {
            document.getElementById('eventosRecientesSidebar').innerHTML = '<div class="text-danger">Error al cargar eventos recientes</div>';
        });
}

function cargarFiltros() {
    cargarFiltro('tipo', 'filtroTipo', 'Tipo');
    cargarFiltro('categoria', 'filtroCategoria', 'Categoría');
    cargarFiltro('modalidad', 'filtroModalidad', 'Modalidad');
    cargarFiltro('carrera', 'filtroCarrera', 'Carrera');
}

function cargarFiltro(tipo, idSelect, textoTodos) {
    axios.get(`../controllers/EventosPublicosController.php?option=listarFiltro&filtro=${tipo}`)
        .then(res => {
            const select = document.getElementById(idSelect);
            select.innerHTML = `<option value="">${textoTodos}</option>`;
            if (Array.isArray(res.data)) {
                res.data.forEach(item => {
                    // Para tipo y modalidad usa item.CODIGO, para categoria y carrera usa item.SECUENCIAL
                    select.innerHTML += `<option value="${item.CODIGO !== undefined ? item.CODIGO : item.SECUENCIAL}">${item.NOMBRE}</option>`;
                });
            }
        });
}

// Escuchar cambios en los filtros principales
['filtroTipo', 'filtroCategoria', 'filtroModalidad', 'filtroCarrera', 'filtroFecha'].forEach(id => {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('change', aplicarFiltros);
    }
});
const inputBusqueda = document.getElementById('filtroBusqueda');
if (inputBusqueda) {
    inputBusqueda.addEventListener('input', function() {
        aplicarFiltros();
    });
}

function aplicarFiltros(page = 1) {
     if (typeof page === 'object' && page !== null) {
        page = 1;
    }
    const tipo = document.getElementById('filtroTipo').value;
    const categoria = document.getElementById('filtroCategoria').value;
    const modalidad = document.getElementById('filtroModalidad').value;
    const carrera = document.getElementById('filtroCarrera').value;
    const fecha = document.getElementById('filtroFecha').value;
    const busqueda = document.getElementById('filtroBusqueda').value;
    console.log({tipo, categoria, modalidad, carrera, fecha, busqueda: '', page, limit: eventosPorPagina});


    // Si hay texto en búsqueda, buscar solo por nombre (ignorar los demás filtros)
    if (busqueda) {
        axios.get('../controllers/EventosPublicosController.php', {
            params: {
                option: 'buscarEventos',
                keyword: busqueda
            }
        })
        .then(res => {
            const contenedor = document.getElementById('contenedorEventos');
            contenedor.innerHTML = '';
            if (!res.data || res.data.length === 0) {
                contenedor.innerHTML = '<div class="col-12 text-center">No se encontraron eventos.</div>';
                actualizarPaginador(1, 1, true);
                return;
            }
            res.data.forEach(ev => {
                contenedor.innerHTML += `
                <div class="col-md-6 mb-4">
                    <div class="package-item bg-white mb-2">
                        <div style="font-weight: bold; color: #d9534f; font-size: 14px; margin-bottom: 5px;">
                            ${ev.ESTADO}
                        </div>
                        <img class="img-fluid" src="../${ev.PORTADA || 'public/img/default-event.jpg'}" alt="${ev.TITULO}">
                        <div class="p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <small class="m-0"><i class="fas fa-book-open text-primary mr-2"></i>${ev.TIPO_EVENTO}</small>
                                <small class="m-0"><i class="fas fa-hourglass-half text-primary mr-2"></i>${ev.HORAS} horas</small>
                                <small class="m-0"><i class="fas fa-user-graduate text-primary mr-2"></i>&nbsp;</small>
                            </div>
                            <a class="h5 text-decoration-none" href="Evento_Detalle.php?id=${ev.SECUENCIAL}">${ev.TITULO}</a>
                            <div class="border-top mt-4 pt-4">
                                <div class="d-flex justify-content-between">
                                    <h6 class="m-0"><i class="fas fa-star text-primary mr-2"></i>4.5 <small>(250)</small></h6>
                                    <h5 class="m-0">$${parseFloat(ev.COSTO).toFixed(2)}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            });
            actualizarPaginador(1, 1, true);
        })
        .catch(() => {
            document.getElementById('contenedorEventos').innerHTML = '<div class="col-12 text-danger">Error al buscar eventos.</div>';
            actualizarPaginador(1, 1, true);
        });
        return;
    }

    // Si todos los filtros están vacíos, mostrar todos los eventos
    if (!tipo && !categoria && !modalidad && !carrera && !fecha) {
        cargarEventosPublicos(page);
        return;
    }

    // Si hay filtros, aplicar filtros combinados
    axios.get('../controllers/EventosPublicosController.php', {
        params: {
            option: 'filtrarEventos',
            tipo,
            categoria,
            modalidad,
            carrera,
            fecha,
            busqueda: '', // vacío porque ya se manejó arriba
            page,
            limit: eventosPorPagina
        }
    })
    .then(res => {
        const data = res.data;
        const contenedor = document.getElementById('contenedorEventos');
        contenedor.innerHTML = '';
        if (!data.eventos || data.eventos.length === 0) {
            contenedor.innerHTML = '<div class="col-12 text-center">No hay eventos con esos filtros.</div>';
            actualizarPaginador(1, 1, true);
            return;
        }
        data.eventos.forEach(ev => {
            contenedor.innerHTML += `
            <div class="col-md-6 mb-4">
                <div class="package-item bg-white mb-2">
                    <div style="font-weight: bold; color: #d9534f; font-size: 14px; margin-bottom: 5px;">
                        ${ev.ESTADO}
                    </div>
                    <img class="img-fluid" src="../${ev.PORTADA || 'public/img/default-event.jpg'}" alt="${ev.TITULO}">
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0"><i class="fas fa-book-open text-primary mr-2"></i>${ev.TIPO_EVENTO}</small>
                            <small class="m-0"><i class="fas fa-hourglass-half text-primary mr-2"></i>${ev.HORAS} horas</small>
                            <small class="m-0"><i class="fas fa-user-graduate text-primary mr-2"></i>&nbsp;</small>
                        </div>
                        <a class="h5 text-decoration-none" href="Evento_Detalle.php?id=${ev.SECUENCIAL}">${ev.TITULO}</a>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <h6 class="m-0"><i class="fas fa-star text-primary mr-2"></i>4.5 <small>(250)</small></h6>
                                <h5 class="m-0">$${parseFloat(ev.COSTO).toFixed(2)}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        });
        actualizarPaginador(data.page, Math.ceil(data.total / data.limit), false);
    })
    .catch(() => {
        document.getElementById('contenedorEventos').innerHTML = '<div class="col-12 text-danger">Error al filtrar eventos.</div>';
        actualizarPaginador(1, 1, true);
    });
}

const inputBusquedaSidebar = document.getElementById('inputBusqueda');
if (inputBusquedaSidebar) {
    inputBusquedaSidebar.addEventListener('input', function() {
        document.getElementById('filtroBusqueda').value = this.value;
        aplicarFiltros();
    });
}


