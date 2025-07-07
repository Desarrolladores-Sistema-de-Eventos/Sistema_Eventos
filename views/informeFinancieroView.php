<?php
require_once '../controllers/FinancieroController.php';

$controller = new FinancieroController();
$eventos = $controller->listarEventos();
$reporte = ['montos' => [], 'pendientes' => [], 'comprobantes' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])) {
    $idEvento = intval($_POST['evento']);
    $reporte = $controller->obtenerReporte($idEvento);
}
?>

<?php include("partials/header_Admin.php"); ?>

<style>
    
        html, body {
            font-family: Arial, sans-serif;
            background: var(--uta-blanco);
            font-size: 14px;
        }
    :root {
        --uta-rojo:rgb(143, 15, 25);
        --uta-negro: #000000;
        --uta-blanco: #ffffff;
        --uta-amarillo:rgb(243, 236, 202);
    }

    h2, h3 {
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
        margin-bottom: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: flex-end;
        margin-top: 20px;
    }

    .action-buttons form {
        margin: 0;
        flex-grow: 1;
    }

    .btn-primary, button[type="submit"] {
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
        min-width: 140px;
        text-align: center;
        width: auto;
    }

    .btn-primary:hover, button[type="submit"]:hover {
        background: var(--uta-negro);
        color: var(--uta-amarillo);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        margin-bottom: 30px;
        background: var(--uta-blanco);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    th, td {
        padding: 12px 15px;
        border: 1px solid var(--uta-negro);
        text-align: left;
        font-size: 14px;
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

    p.no-data {
        color: red;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        .action-buttons form {
            width: 100%;
        }
        .btn-primary {
            width: 100%;
        }
        select {
            font-size: 14px;
        }
        table, th, td {
            font-size: 13px;
        }
    }
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <h2>Reporte Financiero por Evento</h2>

        <div class="card">
            <div class="action-buttons">
                <form method="POST" style="flex-grow: 1;"> <div class="form-group">
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
                    <button type="submit" class="btn-primary">Ver Reporte</button>
                </form>

                <?php if (!empty($reporte['montos']) || !empty($reporte['pendientes']) || !empty($reporte['comprobantes'])): ?>
                    <form method="post" action="generar_reporte_financiero.php" target="_blank" style="margin-top: 0;">
                        <input type="hidden" name="evento" value="<?= $_POST['evento'] ?>">
                        <label style="visibility:hidden;">.</label> <button type="submit" class="btn-primary">Descargar PDF</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])): ?>
            <?php if (!empty($reporte['montos']) || !empty($reporte['pendientes']) || !empty($reporte['comprobantes'])): ?>
                <div class="card">
                    <h3>1. Recaudación por Forma de Pago</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Forma de Pago</th>
                                <th>Total Recaudado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reporte['montos'] as $monto): ?>
                                <tr>
                                    <td><?= htmlspecialchars($monto['FORMA_PAGO']) ?></td>
                                    <td>$<?= number_format($monto['TOTAL_RECAUDADO'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <h3>2. Pagos Pendientes</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Forma de Pago</th>
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
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
                        </tbody>
                    </table>

                    <h3>3. Comprobantes Subidos</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Monto</th>
                                <th>Comprobante</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reporte['comprobantes'] as $c): ?>
                                <tr>
                                    <td><?= htmlspecialchars($c['NOMBRE_COMPLETO']) ?></td>
                                    <td><?= htmlspecialchars($c['CORREO']) ?></td>
                                    <td>$<?= number_format($c['MONTO'], 2) ?></td>
                                    <td><a href="../documents/comprobantes/<?= htmlspecialchars($c['COMPROBANTE_URL']) ?>" target="_blank">Ver Comprobante</a></td>
                                    <td><?= htmlspecialchars($c['ESTADO']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="no-data">No hay registros financieros en este evento.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include("partials/footer_Admin.php"); ?>