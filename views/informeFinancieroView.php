<?php
session_start();
$_SESSION['rol'] = 'admin';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<h3>Acceso denegado.</h3>";
    exit;
}

require_once '../controllers/FinancieroController.php';

$controller = new FinancieroController();
$eventos = $controller->listarEventos();
$reporte = ['montos' => [], 'pendientes' => [], 'comprobantes' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])) {
    $idEvento = intval($_POST['evento']);
    $reporte = $controller->obtenerReporte($idEvento);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Financiero</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            color: #333;
            padding: 40px;
        }

        h2, h3 {
            color: #004080;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .card {
            background: #fff;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
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
            margin-bottom: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .action-buttons form {
            margin: 0;
        }

        .btn-primary {
            background-color: #004080;
            color: #fff;
            padding: 10px 20px;
            font-size: 14px;
            border: 2px solid #004080;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 140px;
            text-align: center;
        }

        .btn-primary:hover {
            background-color: #fff;
            color: #004080;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #e6f0ff;
            color: #004080;
        }

        p.no-data {
            color: red;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }

            select {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Reporte Financiero por Evento</h2>

    <div class="card">
        <div class="action-buttons">
            <!-- Formulario Ver Reporte -->
            <form method="POST">
                <label for="evento">Seleccionar Evento:</label>
                <select name="evento" id="evento" required>
                    <option value="">-- Seleccione --</option>
                    <?php foreach ($eventos as $evento): ?>
                        <option value="<?= $evento['SECUENCIAL'] ?>" <?= (isset($_POST['evento']) && $_POST['evento'] == $evento['SECUENCIAL']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($evento['TITULO']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn-primary">Ver Reporte</button>
            </form>

            <!-- Formulario Descargar PDF -->
            <?php if (!empty($reporte['montos']) || !empty($reporte['pendientes']) || !empty($reporte['comprobantes'])): ?>
                <form method="post" action="generar_reporte_financiero.php" target="_blank">
                    <input type="hidden" name="evento" value="<?= $_POST['evento'] ?>">
                    <label style="visibility:hidden;">.</label>
                    <button type="submit" class="btn-primary">Descargar PDF</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])): ?>
        <?php if (!empty($reporte['montos']) || !empty($reporte['pendientes']) || !empty($reporte['comprobantes'])): ?>
            <div class="card">
                <h3>1. Recaudación por Forma de Pago</h3>
                <table>
                    <tr><th>Forma de Pago</th><th>Total Recaudado</th></tr>
                    <?php foreach ($reporte['montos'] as $monto): ?>
                        <tr>
                            <td><?= htmlspecialchars($monto['FORMA_PAGO']) ?></td>
                            <td>$<?= number_format($monto['TOTAL_RECAUDADO'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <h3>2. Pagos Pendientes</h3>
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Forma de Pago</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                    <?php foreach ($reporte['pendientes'] as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['NOMBRE_COMPLETO']) ?></td>
                            <td><?= htmlspecialchars($p['CORREO']) ?></td>
                            <td><?= htmlspecialchars($p['FORMA_PAGO']) ?></td>
                            <td>$<?= number_format($p['MONTO'], 2) ?></td>
                            <td><?= $p['ESTADO'] ?></td>
                            <td><?= $p['FECHA_PAGO'] ? $p['FECHA_PAGO']->format('Y-m-d') : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <h3>3. Comprobantes Subidos</h3>
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Monto</th>
                        <th>Comprobante</th>
                        <th>Estado</th>
                    </tr>
                    <?php foreach ($reporte['comprobantes'] as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c['NOMBRE_COMPLETO']) ?></td>
                            <td><?= htmlspecialchars($c['CORREO']) ?></td>
                            <td>$<?= number_format($c['MONTO'], 2) ?></td>
                            <td><?= htmlspecialchars($c['COMPROBANTE_URL']) ?></td>
                            <td><?= htmlspecialchars($c['ESTADO']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php else: ?>
            <p class="no-data">No hay registros financieros en este evento.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>
