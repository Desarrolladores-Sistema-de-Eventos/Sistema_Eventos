<?php
session_start();
$_SESSION['rol'] = 'admin';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<h3>Acceso denegado.</h3>";
    exit;
}

require_once '../controllers/EventoAsistenciaController.php';

$controller = new EventoAsistenciaController();
$eventos = $controller->listarEventos();
$reporte = ['responsables' => [], 'asistentes' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])) {
    $reporte = $controller->obtenerReporte(intval($_POST['evento']));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Evento y Asistentes</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            color: #333;
            padding: 40px;
        }

        h2, h3, h4 {
            color: #004080;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            background: #fff;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        select {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        button {
            background-color: #004080;
            color: #fff;
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #003060;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #e6f0ff;
        }

        ul {
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 10px;
        }

        .evento-detalle p {
            margin: 6px 0;
        }

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container">
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
</body>
</html>
