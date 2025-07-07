<?php
require_once '../controllers/EventoAsistenciaController.php';
$controller = new EventoAsistenciaController();
$eventos = $controller->listarEventos();
$reporte = ['responsables' => [], 'asistentes' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])) {
    $reporte = $controller->obtenerReporte(intval($_POST['evento']));
}
?>

<?php include("partials/header_Admin.php"); ?>
    <style>
        /* Definición de colores principales para asegurar consistencia */
        :root {
            --uta-rojo: #b10024; /* Rojo principal de UTA */
            --uta-rojo-oscuro: #92001c; /* Tono más oscuro de rojo */
            --uta-negro: #000000;
            --uta-blanco: #ffffff;
            --uta-gris-claro: #f5f5f5; /* Para fondos sutiles */
            --uta-gris-medio: #e0e0e0; /* Para bordes */
            --uta-gris-oscuro: #333; /* Para texto principal */
        }

        /* Títulos */
        h2, h3, h4 {
            color: var(--uta-rojo); /* Cambiado de azul a rojo */
            font-weight: bold; /* Asegurar negrita */
            margin-bottom: 15px; /* Espaciado uniforme */
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: var(--uta-negro); /* Título principal en negro */
        }

        h2 i {
            color: var(--uta-rojo); /* Icono en rojo */
            margin-right: 10px;
        }

        /* Contenedores de tarjetas/paneles */
        .card {
            background: var(--uta-blanco);
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* Sombra mejorada */
            border: 1px solid var(--uta-gris-medio); /* Borde sutil */
        }

        /* Grupos de formulario */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            color: var(--uta-gris-oscuro); /* Color de etiqueta */
        }

        /* Selectores de formulario */
        select {
            width: 100%;
            padding: 12px; /* Aumentar padding */
            font-size: 16px; /* Tamaño de fuente legible */
            border: 1px solid var(--uta-gris-medio); /* Borde en gris */
            border-radius: 6px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.06); /* Sombra interna sutil */
            appearance: none; /* Eliminar estilo nativo del select */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23b10024'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E"); /* Icono de flecha personalizado en rojo */
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 20px;
            cursor: pointer;
        }

        /* Botones de acción */
        .action-buttons {
            display: flex;
            gap: 15px; /* Aumentar espacio entre botones */
            margin-top: 20px;
            flex-wrap: wrap;
        }

        button[type="submit"], button { /* Aplicar a ambos tipos de botones */
            background-color: var(--uta-rojo); /* Cambiado de azul a rojo */
            color: var(--uta-blanco);
            padding: 12px 25px; /* Aumentar padding */
            font-size: 16px; /* Tamaño de fuente legible */
            border: none;
            border-radius: 8px; /* Bordes más redondeados */
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            font-weight: 600; /* Negrita para el texto del botón */
        }

        button[type="submit"]:hover, button:hover {
            background-color: var(--uta-rojo-oscuro); /* Cambiado de azul oscuro a rojo oscuro */
            box-shadow: 0 6px 15px rgba(var(--uta-rojo), 0.3); /* Sombra al pasar el ratón */
        }

        /* Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px; /* Más espacio superior */
            box-shadow: 0 2px 10px rgba(0,0,0,0.08); /* Sombra para la tabla */
            border-radius: 8px; /* Bordes redondeados para la tabla */
            overflow: hidden; /* Para que los bordes redondeados se apliquen al contenido */
        }

        th, td {
            padding: 15px; /* Aumentar padding */
            border: 1px solid var(--uta-gris-medio); /* Bordes en gris */
            text-align: left;
            color: var(--uta-gris-oscuro); /* Color de texto para celdas */
        }

        th {
            background-color: var(--uta-gris-claro); /* Fondo gris claro para cabecera (antes azul claro) */
            color: var(--uta-negro); /* Texto de cabecera en negro */
            font-weight: 700; /* Negrita para cabeceras */
            text-transform: uppercase; /* Mayúsculas para cabeceras */
            font-size: 0.95rem; /* Tamaño de fuente ligeramente menor para cabeceras */
        }

        /* Estilos para filas impares/pares si se desea */
        tbody tr:nth-child(odd) {
            background-color: var(--uta-blanco);
        }
        tbody tr:nth-child(even) {
            background-color: var(--uta-gris-claro); /* Fondo ligeramente gris para filas pares */
        }

        /* Responsividad */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }
            button[type="submit"], button {
                width: 100%; /* Botones ocupan todo el ancho en móviles */
            }
            table, thead, tbody, th, td, tr {
                display: block; /* Convertir tabla a bloques para móviles */
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr { border: 1px solid var(--uta-gris-medio); margin-bottom: 15px; border-radius: 8px; } /* Borde y margen para filas en móviles */
            td {
                border: none;
                border-bottom: 1px solid var(--uta-gris-medio);
                position: relative;
                padding-left: 50%; /* Espacio para la etiqueta */
                text-align: right;
            }
            td:before {
                position: absolute;
                top: 0;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
                color: var(--uta-rojo); /* Etiqueta en rojo */
            }
            /* Etiquetas para celdas en móvil (ejemplo, necesitarías añadir data-label en tu HTML) */
            td:nth-of-type(1):before { content: "Nombre:"; }
            td:nth-of-type(2):before { content: "Correo:"; }
            td:nth-of-type(3):before { content: "Facultad:"; }
            td:nth-of-type(4):before { content: "Carrera:"; }
            td:nth-of-type(5):before { content: "Estado:"; }
            td:nth-of-type(6):before { content: "Ponderación:"; }
        }
    </style>

<div id="page-wrapper">
    <div id="page-inner">
        <h2><i class="fa fa-file-alt"></i> Reporte de Evento y Asistentes</h2> <!-- Cambiado icono a file-alt -->

        <div class="card">
            <form method="POST">
                <div class="form-group">
                    <label for="evento">Seleccionar Evento:</label>
                    <select name="evento" id="evento" required>
                        <option value="">-- Seleccione --</option>
                        <?php foreach ($eventos as $evento): ?>
                            <option value="<?= $evento['SECUENCIAL'] ?>" <?= (isset($_POST['evento']) && $_POST['evento'] == $evento['SECUENCIAL']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($evento['TITULO']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="action-buttons">
                    <button type="submit">Ver Reporte</button>
                </div>
            </form>

            <?php if (!empty($reporte['responsables'])): ?>
                <div class="action-buttons" style="margin-top: 10px;">
                    <form method="post" action="generar_reporte_asistentes.php" target="_blank">
                        <input type="hidden" name="evento" value="<?= $_POST['evento'] ?>">
                        <button type="submit">Descargar PDF</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($reporte['responsables'])): ?>
            <div class="card evento-detalle">
                <h3>Detalles del Evento</h3>
                <p><strong>Evento:</strong> <?= htmlspecialchars($reporte['responsables'][0]['EVENTO']) ?></p>
                <p><strong>Fechas:</strong>
                    <?= $reporte['responsables'][0]['FECHAINICIO']->format('Y-m-d') ?> al
                    <?= $reporte['responsables'][0]['FECHAFIN']->format('Y-m-d') ?>
                </p>

                <h4>Responsables:</h4>
                <ul>
                    <?php foreach ($reporte['responsables'] as $r): ?>
                        <li>
                            <strong>Nombre:</strong> <?= htmlspecialchars($r['RESPONSABLE']) ?>
                            (<?= htmlspecialchars($r['CARGO']) ?>) -
                            <strong>Correo:</strong> <?= htmlspecialchars($r['CORREO']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card">
                <h3>Lista de Asistentes</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Facultad</th>
                            <th>Carrera</th>
                            <th>Estado</th>
                            <th>Ponderación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reporte['asistentes'] as $a): ?>
                            <tr>
                                <td><?= htmlspecialchars($a['NOMBRE_COMPLETO']) ?></td>
                                <td><?= htmlspecialchars($a['CORREO']) ?></td>
                                <td><?= htmlspecialchars($a['FACULTAD']) ?></td>
                                <td><?= htmlspecialchars($a['CARRERA']) ?></td>
                                <td><?= htmlspecialchars($a['ESTADO_PARTICIPACION']) ?></td>
                                <td><?= is_numeric($a['PONDERACION']) ? $a['PONDERACION'] : '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include("partials/footer_Admin.php"); ?>
