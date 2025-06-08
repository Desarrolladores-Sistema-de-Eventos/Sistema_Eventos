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
    /* Eliminamos body y .container con max-width/margin de aquí,
       asumiendo que #page-inner o tu CSS global ya los maneja */
    /* font-family, background-color, y color del body deberían venir del CSS global */
    /* padding: 40px; en body ya no es necesario aquí */

    h2 {
        color: #004080; /* Color consistente con otros reportes */
    }

    /* .container no es necesario aquí ya que #page-inner es el contenedor principal */

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

    .form-group { /* Añadido para agrupar label y select */
        margin-bottom: 20px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: flex-end;
        margin-top: 20px; /* Ajuste del margen superior */
    }

    .action-buttons form {
        margin: 0;
        flex-grow: 1; /* Permite que el formulario de selección crezca */
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
        width: auto; /* Asegura que el botón no ocupe todo el ancho sin necesidad */
    }

    .btn-primary:hover {
        background-color: #fff;
        color: #004080;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    th, td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        text-align: left;
        font-size: 14px; /* Tamaño de fuente para tablas consistente */
    }

    th {
        background-color: #e6f0ff;
        color: #004080;
    }

    .total-count {
        font-weight: bold;
        margin: 20px 0; /* Ajuste del margen para centrar verticalmente */
        font-size: 16px;
        text-align: center; /* Centrar el texto */
        color: #004080; /* Color consistente */
    }

    .no-data-message { /* Nueva clase para el mensaje de "no hay datos" */
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
            width: 100%; /* Ocupa todo el ancho en pantallas pequeñas */
        }
        .btn-primary {
            width: 100%; /* Botones de ancho completo en móviles */
        }
        select {
            font-size: 14px;
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
                                <th>Carrera</th>
                                <th>Facultad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reporte['datos'] as $ins): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ins['NOMBRE COMPLETO']) ?></td>
                                    <td><?= htmlspecialchars($ins['CORREO']) ?></td>
                                    <td><?= htmlspecialchars($ins['CARRERA']) ?></td>
                                    <td><?= htmlspecialchars($ins['FACULTAD']) ?></td>
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