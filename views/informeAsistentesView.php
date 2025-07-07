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
        /* Colores UTA: Rojo, Negro, Blanco, Amarillo */
        :root {
            /* Rojo UTA institucional más claro */
            --uta-rojo:rgb(167, 18, 30);
            --uta-negro: #000000;
            --uta-blanco: #ffffff;
            --uta-amarillo:rgb(241, 234, 200);
        }

        html, body {
            font-family: Arial, sans-serif;
            background: var(--uta-blanco);
            font-size: 14px;
        }

        h2, h3, h4 {
            color: var(--uta-rojo);
            font-weight: bold;
        }

        .card {
            background: var(--uta-blanco);
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
            border: 2px solid var(--uta-rojo);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            color: var(--uta-negro);
        }

        select {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 2px solid var(--uta-rojo);
            border-radius: 6px;
            background: var(--uta-blanco);
            color: var(--uta-negro);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        button {
            background: var(--uta-rojo);
            color: var(--uta-blanco);
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0,0,0,0.10);
            transition: background 0.3s, color 0.3s;
        }

        button:hover {
            background: var(--uta-negro);
            color: var(--uta-amarillo);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: var(--uta-blanco);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px;
            border: 1px solid var(--uta-negro);
            text-align: left;
        }

        th {
            background: var(--uta-rojo);
            color: var(--uta-blanco);
            font-weight: bold;
            border-bottom: 3px solid var(--uta-negro);
        }

        tr:nth-child(even) td {
            background: #f9f9f9;
        }

        tr:hover td {
            background: var(--uta-amarillo);
            color: var(--uta-negro);
        }

        .evento-detalle {
            border-left: 8px solid var(--uta-rojo);
            background: #fffbe6;
        }

        ul {
            color: var(--uta-negro);
        }

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
            table, th, td {
                font-size: 13px;
            }
        }
    </style>

<div id="page-wrapper">
    <div id="page-inner" >
        <h2>Reporte de Evento y Asistentes</h2>

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
                            <th>Estado</th>
                            <th>Ponderación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reporte['asistentes'] as $a): ?>
                            <tr>
                                <td><?= htmlspecialchars($a['NOMBRE_COMPLETO']) ?></td>
                                <td><?= htmlspecialchars($a['CORREO']) ?></td>
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