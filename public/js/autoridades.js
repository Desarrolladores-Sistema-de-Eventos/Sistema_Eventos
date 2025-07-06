document.addEventListener('DOMContentLoaded', function () {
    const tabla = document.querySelector('#tablaAutoridades tbody');
    const form = document.getElementById('formAutoridad');
    const btnAgregar = document.getElementById('btnAgregarAutoridad');
    const publicContainer = document.getElementById('autoridades-row');

    // Modal solo si existe (admin)
    const modal = typeof $ === 'function' && $('#modalAutoridad').length ? $('#modalAutoridad') : null;

    let cacheAutoridades = [];

    async function fetchAutoridades() {
        try {
            const res = await fetch('../controllers/AutoridadesController.php?option=listar');
            const data = await res.json();
            if (data.tipo === 'success' && Array.isArray(data.autoridades)) {
                cacheAutoridades = data.autoridades;
                renderAutoridadesAdmin();
                renderAutoridadesPublic();
            } else {
                console.warn('Respuesta inesperada:', data);
            }
        } catch (error) {
            console.error('Error al obtener autoridades:', error);
        }
    }

    function renderAutoridadesAdmin() {
        if (!tabla) return;
        tabla.innerHTML = '';

        if (cacheAutoridades.length === 0) {
            tabla.innerHTML = '<tr><td colspan="5" class="text-center">No hay autoridades registradas.</td></tr>';
            return;
        }

        cacheAutoridades.forEach(a => {
            tabla.innerHTML += `
                <tr>
                    <td>${a.nombre}</td>
                    <td>${a.cargo}</td>
                    <td>${a.correo}</td>
                    <td>${a.telefono}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary btnEditar" data-id='${JSON.stringify(a)}'>
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btnEliminar" data-id="${a.identificador}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        document.querySelectorAll('.btnEditar').forEach(btn => {
            btn.addEventListener('click', () => {
                const data = JSON.parse(btn.getAttribute('data-id'));

                form.querySelector('[name="SECUENCIAL"]').value = data.identificador || '';
                form.querySelector('[name="NOMBRE"]').value = data.nombre || '';
                form.querySelector('[name="CARGO"]').value = data.cargo || '';
                form.querySelector('[name="CORREO"]').value = data.correo || '';
                form.querySelector('[name="TELEFONO"]').value = data.telefono || '';

                document.getElementById('modalAutoridadLabel').textContent = 'Editar Autoridad';
                modal?.modal('show');
            });
        });

        document.querySelectorAll('.btnEliminar').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                eliminarAutoridad(id);
            });
        });
    }

    function renderAutoridadesPublic() {
        if (!publicContainer) return;
        publicContainer.innerHTML = '';

        if (cacheAutoridades.length === 0) {
            publicContainer.innerHTML = '<div class="col-12 text-center text-white">No hay autoridades registradas.</div>';
            return;
        }

        cacheAutoridades.forEach(a => {
            publicContainer.innerHTML += `
                <div class="col-md-4">
                    <div class="card-autoridad">
                        <div class="team-img">
                            <img src="../public/img/autoridades/${a.imagen}" alt="${a.nombre}" onerror="this.src='../public/img/default.png'">
                        </div>
                        <div class="text-center">
                            <h5 class="text-uppercase">${a.nombre}</h5>
                            <p>${a.cargo}</p>
                            <small><i class="fa fa-envelope me-1"></i>${a.correo}</small><br>
                            <small><i class="fa fa-phone me-1"></i>${a.telefono}</small>
                        </div>
                    </div>
                </div>
            `;
        });
    }

    function eliminarAutoridad(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b10024',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar'
        }).then(result => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('SECUENCIAL', id);

                fetch('../controllers/AutoridadesController.php?option=eliminar', {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire(data.mensaje, '', data.tipo);
                        fetchAutoridades();
                    })
                    .catch(error => {
                        console.error('Error al eliminar:', error);
                    });
            }
        });
    }

    form?.addEventListener('submit', function (e) {
        e.preventDefault();

        const correo = form.CORREO.value.trim();
        const telefono = form.TELEFONO.value.trim();

        const correoValido = /^[a-zA-Z0-9._%+-]+@uta\.edu\.ec$/.test(correo);
        if (!correoValido) {
            Swal.fire('Error', 'El correo debe ser institucional (terminar en @uta.edu.ec)', 'error');
            return;
        }

        const telefonoValido = /^09\d{8}$/.test(telefono);
        if (!telefonoValido) {
            Swal.fire('Error', 'El número de teléfono debe comenzar con 09 y tener 10 dígitos.', 'error');
            return;
        }

        const formData = new FormData(form);
        const isUpdate = form.SECUENCIAL.value !== '';
        const option = isUpdate ? 'actualizar' : 'crear';

        axios.post(`../controllers/AutoridadesController.php?option=${option}`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
            .then(res => {
                if (res.data.tipo === 'success') {
                    modal?.modal('hide');
                    fetchAutoridades();
                    Swal.fire('Éxito', res.data.mensaje, 'success');
                } else {
                    Swal.fire('Error', res.data.mensaje, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Ocurrió un problema', 'error');
                console.error(error);
            });
    });

    btnAgregar?.addEventListener('click', () => {
        form?.reset();
        if (form) form.querySelector('[name="SECUENCIAL"]').value = '';
        document.getElementById('modalAutoridadLabel').textContent = 'Agregar Autoridad';
        modal?.modal('show');
    });

    fetchAutoridades();
});
