<?php
require_once '../controllers/CertificadoController.php';

// Incluir el header de admin inmediatamente después de abrir PHP
include("partials/header_Admin.php");

$controller = new CertificadoController();
$eventos = $controller->listarEventos();
$certificados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])) {
    $idEvento = intval($_POST['evento']);
    $certificados = $controller->obtenerReporte($idEvento);
}
?>

<style>
    
        html, body {
            font-family: Arial, sans-serif;
            background: var(--uta-blanco);
            font-size: 14px;
        }
    :root {
        --uta-rojo:rgb(185, 19, 33);
        --uta-negro: #000000;
        --uta-blanco: #ffffff;
        --uta-amarillo:rgb(241, 231, 187);
    }

    h2 {
        text-align: center;
        color: var(--uta-rojo);
        margin-bottom: 30px;
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
        justify-content: flex-start;
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
    }

    .btn-primary:hover, button[type="submit"]:hover {
        background: var(--uta-negro);
        color: var(--uta-amarillo);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 14px;
        background: var(--uta-blanco);
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px 15px;
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

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
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
        <h2>Reporte de Certificados Emitidos</h2>

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

                <?php if (!empty($certificados)): ?>
                    <form method="post" action="generar_reporte_certificados.php" target="_blank" style="margin-top: 10px;">
                        <input type="hidden" name="evento" value="<?= $_POST['evento'] ?>">
                        <label style="visibility:hidden;">.</label> <button type="submit" class="btn-primary">Descargar PDF</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($certificados)): ?>
            <div class="card">
                <h3>Certificados Emitidos</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>Tipo</th>
                            <th>URL Certificado</th>
                            <th>Fecha Emisión</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($certificados as $cert): ?>
                            <tr>
                                <td><?= htmlspecialchars($cert['NOMBRE_EVENTO']) ?></td>
                                <td><?= htmlspecialchars($cert['NOMBRE_COMPLETO']) ?></td>
                                <td><?= htmlspecialchars($cert['CORREO']) ?></td>
                                <td><?= htmlspecialchars($cert['TIPO_CERTIFICADO']) ?></td>
                                <td><?= htmlspecialchars($cert['URL_CERTIFICADO']) ?></td>
                                <td><?= htmlspecialchars($cert['FECHA_EMISION']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])): ?>
                <p style="color: red; font-weight: bold; text-align: center;">No hay certificados emitidos para este evento.</p>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</div>

<?php include("partials/footer_Admin.php"); ?>