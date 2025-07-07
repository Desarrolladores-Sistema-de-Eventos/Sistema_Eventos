<?php
require_once '../controllers/InscripcionController.php';

$controller = new InscripcionController();
$eventos = $controller->listarEventos();
$reporte = ['total' => 0, 'datos' => []];

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
        --uta-rojo:rgb(122, 10, 19);
        --uta-negro: #000000;
        --uta-blanco: #ffffff;
        --uta-amarillo:rgb(233, 228, 205);
    }

    h2 {
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

    .total-count {
        font-weight: bold;
        margin: 20px 0;
        font-size: 16px;
        text-align: center;
        color: var(--uta-rojo);
    }

    .no-data-message {
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
        <h2>Reporte de Inscripciones</h2>

        <div class="card">
            <div class="action-buttons">
                <form method="POST" style="flex-grow: 1;">
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
                    <button type="submit" class="btn-primary">Ver Reporte</button>
                </form>

                <?php if (!empty($reporte['datos'])): ?>
                    <form method="post" action="generar_reporte_inscripciones.php" target="_blank" style="margin-top: 0;">
                        <input type="hidden" name="evento" value="<?= htmlspecialchars($_POST['evento']) ?>">
                        <label style="visibility:hidden;">Descargar</label> <button type="submit" class="btn-primary">Descargar PDF</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])): ?>
            <?php if (!empty($reporte['datos'])): ?>
                <div class="card">
                    <p class="total-count">Total inscritos: <?= $reporte['total'] ?></p>

                    <table>
                        <thead>
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Correo</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reporte['datos'] as $ins): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ins['NOMBRE COMPLETO']) ?></td>
                                    <td><?= htmlspecialchars($ins['CORREO']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="no-data-message">No hay inscripciones para este evento.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include("partials/footer_Admin.php"); ?>