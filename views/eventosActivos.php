<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2><i class="fa fa-calendar"></i>Eventos Activos</h2>
            </div>
        </div>
        <hr />
        <div class="panel panel-default">
            <div class="panel-heading">Lista de Eventos</div>
            <div class="panel-body">
                <br><br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-eventos">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Evento</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Lugar</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Aquí iría tu lógica PHP para obtener los eventos de la base de datos
                            // (Ejemplo con datos estáticos para la demostración)
                            $eventos = [
                                [
                                    'id' => 1,
                                    'titulo' => 'Taller de Liderazgo Universitario',
                                    'horas' => 30,
                                    'descripcion' => 'Un taller intensivo para desarrollar habilidades de liderazgo en estudiantes universitarios, enfocado en trabajo en equipo y toma de decisiones. Incluye simulaciones prácticas.',
                                    'tipo_evento' => 'Taller',
                                    'modalidad' => 'Presencial',
                                    'categoria' => 'Desarrollo Personal',
                                    'fecha_inicio' => '2025-07-12',
                                    'fecha_fin' => '2025-07-15',
                                    'hora_inicio' => '10:00 AM',
                                    'lugar' => 'Auditorio Central',
                                    'nota_aprobacion' => 70,
                                    'es_pagado' => false,
                                    'costo' => 0,
                                    'facultad' => 'Ingenierías',
                                    'carrera' => 'Sistemas',
                                    'publico_destino' => 'Internos', // Ajustado para mejor visualización
                                    'otorga_certificado' => true,
                                    'estado' => 'Inscrito'
                                ],
                                [
                                    'id' => 2,
                                    'titulo' => 'Feria de Emprendimiento 2025',
                                    'horas' => 20,
                                    'descripcion' => 'Exposición de proyectos innovadores creados por estudiantes, con charlas de expertos en emprendimiento y oportunidades de networking. Evento imperdible para futuros empresarios.',
                                    'tipo_evento' => 'Feria',
                                    'modalidad' => 'Virtual',
                                    'categoria' => 'Emprendimiento',
                                    'fecha_inicio' => '2025-07-25',
                                    'fecha_fin' => '2025-07-26',
                                    'hora_inicio' => '02:00 PM',
                                    'lugar' => 'Plataforma Virtual (Zoom)',
                                    'nota_aprobacion' => 0,
                                    'es_pagado' => false,
                                    'costo' => 0,
                                    'facultad' => 'Ciencias Administrativas',
                                    'carrera' => 'Marketing',
                                    'publico_destino' => 'Internos y Externos', // Ajustado para mejor visualización
                                    'otorga_certificado' => false,
                                    'estado' => 'Inscrito'
                                ]
                            ];
                            // FIN DE EJEMPLO DE DATOS ESTATICOS

                            foreach ($eventos as $evento) { // Reemplaza esto con tu bucle de base de datos
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($evento['id']); ?></td>
                                    <td><?php echo htmlspecialchars($evento['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($evento['fecha_inicio']))); ?></td>
                                    <td><?php echo htmlspecialchars($evento['hora_inicio']); ?></td>
                                    <td><?php echo htmlspecialchars($evento['lugar']); ?></td>
                                    <td><?php echo htmlspecialchars($evento['estado']); ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm view-details-btn"
                                            data-toggle="modal" data-target="#modalVerDetallesEvento"
                                            data-id="<?php echo htmlspecialchars($evento['id']); ?>"
                                            data-titulo="<?php echo htmlspecialchars($evento['titulo']); ?>"
                                            data-horas="<?php echo htmlspecialchars($evento['horas']); ?>"
                                            data-descripcion="<?php echo htmlspecialchars($evento['descripcion']); ?>"
                                            data-tipo="<?php echo htmlspecialchars($evento['tipo_evento']); ?>"
                                            data-modalidad="<?php echo htmlspecialchars($evento['modalidad']); ?>"
                                            data-categoria="<?php echo htmlspecialchars($evento['categoria']); ?>"
                                            data-fechainicio="<?php echo htmlspecialchars($evento['fecha_inicio']); ?>"
                                            data-fechafin="<?php echo htmlspecialchars($evento['fecha_fin']); ?>"
                                            data-horainicio="<?php echo htmlspecialchars($evento['hora_inicio']); ?>"
                                            data-lugar="<?php echo htmlspecialchars($evento['lugar']); ?>"
                                            data-notaaprobacion="<?php echo htmlspecialchars($evento['nota_aprobacion']); ?>"
                                            data-espagado="<?php echo $evento['es_pagado'] ? 'Sí' : 'No'; ?>"
                                            data-costo="<?php echo htmlspecialchars($evento['costo']); ?>"
                                            data-facultad="<?php echo htmlspecialchars($evento['facultad']); ?>"
                                            data-carrera="<?php echo htmlspecialchars($evento['carrera']); ?>"
                                            data-publicodestino="<?php echo htmlspecialchars($evento['publico_destino']); ?>"
                                            data-otorgacertificado="<?php echo $evento['otorga_certificado'] ? 'Sí' : 'No'; ?>"
                                            >
                                            <i class="fa fa-info-circle"></i> Ver detalles
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            } // Fin del bucle
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVerDetallesEvento" tabindex="-1" role="dialog" aria-labelledby="modalVerDetallesEventoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modalVerDetallesEventoLabel"><i class="fa fa-info-circle"></i> Detalles del Evento: <span id="detalleTituloModal"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Título:</strong> <span id="detalleTitulo"></span></p>
                            <p><strong>Horas:</strong> <span id="detalleHoras"></span></p>
                            <p><strong>Tipo de Evento:</strong> <span id="detalleTipoEvento"></span></p>
                            <p><strong>Modalidad:</strong> <span id="detalleModalidad"></span></p>
                            <p><strong>Categoría:</strong> <span id="detalleCategoria"></span></p>
                            <p><strong>Fecha Inicio:</strong> <span id="detalleFechaInicio"></span></p>
                            <p><strong>Fecha Fin:</strong> <span id="detalleFechaFin"></span></p>
                            <p><strong>Hora:</strong> <span id="detalleHora"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Lugar:</strong> <span id="detalleLugar"></span></p>
                            <p><strong>Nota Mínima de Aprobación:</strong> <span id="detalleNotaAprobacion"></span></p>
                            <p><strong>Es Pagado:</strong> <span id="detalleEsPagado"></span></p>
                            <p><strong>Costo:</strong> <span id="detalleCosto"></span></p>
                            <p><strong>Facultad:</strong> <span id="detalleFacultad"></span></p>
                            <p><strong>Carrera:</strong> <span id="detalleCarrera"></span></p>
                            <p><strong>Público Destino:</strong> <span id="detallePublicoDestino"></span></p>
                            <p><strong>Otorga Certificado:</strong> <span id="detalleOtorgaCertificado"></span></p>
                        </div>
                    </div>
                    <hr> <p><strong>Descripción:</strong></p>
                    <p><span id="detalleDescripcion"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="modalEventoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modalEventoLabel"><i class="fa fa-edit"></i> Crear/Editar Evento</h4>
                </div>
                <div class="modal-body">
                    <form id="formEvento" role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="titulo"><i class="fa fa-book"></i> Título del Evento</label>
                                <input type="text" class="form-control" id="titulo" placeholder="Ej: Congreso de Tecnología">
                            </div>
                            <div class="col-md-6">
                                <label for="horas"><i class="fa fa-clock-o"></i> Horas del Evento</label>
                                <input type="number" class="form-control" id="horas" min="20" step="0.1">
                            </div>
                        </div><br>
                        <div class="form-group">
                            <label for="descripcion"><i class="fa fa-align-left"></i> Descripción del Evento</label>
                            <textarea class="form-control" id="descripcion" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="tipoEvento"><i class="fa fa-folder-open"></i> Tipo de Evento</label>
                                <select class="form-control" id="tipoEvento"><option value="">Seleccione</option></select>
                            </div>
                            <div class="col-md-4">
                                <label for="modalidad"><i class="fa fa-random"></i> Modalidad</label>
                                <select class="form-control" id="modalidad"><option value="">Seleccione</option></select>
                            </div>
                            <div class="col-md-4">
                                <label for="categoria"><i class="fa fa-tags"></i> Categoría</label>
                                <select class="form-control" id="categoria"><option value="">Seleccione</option></select>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fechaInicio"><i class="fa fa-calendar"></i> Fecha de Inicio</label>
                                <input type="date" class="form-control" id="fechaInicio">
                            </div>
                            <div class="col-md-6">
                                <label for="fechaFin"><i class="fa fa-calendar"></i> Fecha de Fin</label>
                                <input type="date" class="form-control" id="fechaFin">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="notaAprobacion"><i class="fa fa-check-circle"></i> Nota mínima de aprobación</label>
                                <input type="number" class="form-control" id="notaAprobacion" min="0" step="0.1">
                            </div>
                            <div class="col-md-6">
                                <label><i class="fa fa-money"></i> ¿El evento es pagado?</label><br>
                                <input type="checkbox" id="esPagado"> Sí
                            </div>
                        </div><br>
                        <div class="row" id="costoContainer" style="display: none;">
                            <div class="col-md-6">
                                <label for="costo">Costo ($)</label>
                                <input type="number" class="form-control" id="costo">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="facultad"><i class="fa fa-university"></i> Facultad</label>
                                <select class="form-control" id="facultad"><option value="">Seleccione</option></select>
                            </div>
                            <div class="col-md-6">
                                <label for="carrera"><i class="fa fa-graduation-cap"></i> Carrera</label>
                                <select class="form-control" id="carrera" disabled><option>Seleccione una facultad primero</option></select>
                            </div>
                        </div><br>
                        <div class="form-group">
                            <label for="publicoDestino"><i class="fa fa-users"></i> ¿Quiénes pueden inscribirse?</label>
                            <select id="publicoDestino" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="internos">Solo internos</option>
                                <option value="externos">Solo externos</option>
                                <option value="ambos">Internos y externos</option>
                            </select>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="otorgaCertificado"> <i class="fa fa-certificate"></i> Este evento otorga certificado
                            </label>
                        </div><br>
                        <h5><i class="fa fa-tasks"></i> Requisitos del Evento</h5>
                        <p class="text-muted">Seleccione al menos 2 requisitos necesarios para participar.</p>
                        <select id="requisitosSelect" class="form-control" multiple="multiple"></select><br>
                        <h5><i class="fa fa-user"></i> Organizadores del Evento</h5>
                        <p class="text-muted">Seleccione al menos 2 organizadores.</p>
                        <select id="organizadoresSelect" class="form-control" multiple="multiple"></select><br>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Guardar Evento
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    </div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        // Inicialización de Select2 y otros listeners existentes
        $('#requisitosSelect, #organizadoresSelect').select2({
            placeholder: "Seleccione una o más opciones",
            width: '100%'
        });

        $('#esPagado').change(function () {
            $('#costoContainer').toggle(this.checked);
        });

        $('#facultad').change(function () {
            const carrera = $('#carrera');
            carrera.html("<option>Cargando...</option>");
            carrera.prop("disabled", false);
            // Lógica AJAX aquí
        });

        // --- Script para el botón "Ver detalles" y el modal de visualización ---
        $('.view-details-btn').on('click', function() {
            var button = $(this); // El botón que fue presionado

            // Obtener los datos del evento de los atributos 'data-' del botón
            var titulo = button.data('titulo');
            var descripcion = button.data('descripcion');
            var horas = button.data('horas');
            var tipoEvento = button.data('tipo');
            var modalidad = button.data('modalidad');
            var categoria = button.data('categoria');
            var fechaInicio = button.data('fechainicio');
            var fechaFin = button.data('fechafin');
            var horaInicio = button.data('horainicio');
            var lugar = button.data('lugar');
            var notaAprobacion = button.data('notaaprobacion');
            var esPagado = button.data('espagado');
            var costo = button.data('costo');
            var facultad = button.data('facultad');
            var carrera = button.data('carrera');
            var publicoDestino = button.data('publicodestino');
            var otorgaCertificado = button.data('otorgacertificado');

            // Formatear fechas si es necesario (ej: de YYYY-MM-DD a DD/MM/YYYY)
            if (fechaInicio) fechaInicio = new Date(fechaInicio).toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' });
            if (fechaFin) fechaFin = new Date(fechaFin).toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' });

            // Rellenar el modal de SOLO visualización con los datos
            $('#detalleTituloModal').text(titulo); // Título en el encabezado del modal de detalles
            $('#detalleTitulo').text(titulo);
            $('#detalleHoras').text(horas + ' horas');
            $('#detalleTipoEvento').text(tipoEvento);
            $('#detalleModalidad').text(modalidad);
            $('#detalleCategoria').text(categoria);
            $('#detalleFechaInicio').text(fechaInicio);
            $('#detalleFechaFin').text(fechaFin);
            $('#detalleHora').text(horaInicio);
            $('#detalleLugar').text(lugar);
            $('#detalleNotaAprobacion').text(notaAprobacion > 0 ? notaAprobacion : 'N/A');
            $('#detalleEsPagado').text(esPagado);
            $('#detalleCosto').text(costo > 0 ? '$' + parseFloat(costo).toFixed(2) : 'Gratuito'); // Formateo de costo
            $('#detalleFacultad').text(facultad);
            $('#detalleCarrera').text(carrera);
            $('#detallePublicoDestino').text(publicoDestino);
            $('#detalleOtorgaCertificado').text(otorgaCertificado);
            $('#detalleDescripcion').text(descripcion); // La descripción la dejamos en su propia sección

            // Mostrar el modal de detalles
            $('#modalVerDetallesEvento').modal('show');
        });
        // --- Fin del script para ver detalles ---
    });
</script>

<?php include("partials/footer_Admin.php"); ?>