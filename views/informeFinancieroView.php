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
    /* Definición de colores principales: ÚNICAMENTE ROJO, BLANCO Y NEGRO */
    :root {
        --uta-rojo: #b10024; /* Rojo principal de UTA */
        --uta-rojo-oscuro: #92001c; /* Tono más oscuro de rojo */
        --uta-negro: #1a1a1a; /* CAMBIADO: Negro secundario, como en el reporte de certificados */
        --uta-blanco: #ffffff; /* Blanco de complemento */
        --line-color: #666666; /* AGREGADO: Color gris para las líneas menos visibles */
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 10px; /* CAMBIADO: Tamaño de fuente ligeramente reducido para PDF */
        margin: 0;
        padding: 0;
        color: var(--uta-negro); /* Texto general en negro */
        /* Para centrar el contenido en la página de Dompdf */
        text-align: center; /* Centra los elementos de bloque */
    }

    /* Contenedor principal para el contenido del reporte */
    .report-container {
        width: 95%; /* Ajusta el ancho para que el contenido no toque los bordes */
        margin: 20px auto; /* Centra el contenedor en la página */
        text-align: left; /* Restablece la alineación de texto para el contenido interno */
    }

    /* Estilos para el encabezado principal (como se ve en la imagen) */
    .main-header {
        background-color: var(--uta-rojo); /* Fondo rojo para la cabecera */
        color: var(--uta-blanco); /* Texto blanco en la cabecera */
        padding: 15px 0; /* CAMBIADO: Padding vertical para el encabezado */
        text-align: center; /* Centrar el texto dentro del encabezado */
        width: 100%;
        box-sizing: border-box;
    }
    .main-header-text {
        text-align: center; /* Centrar el texto */
    }
    .main-header-text h3, .main-header-text h4, .main-header-text p {
        margin: 0;
        line-height: 1.2;
        color: var(--uta-blanco); /* Texto blanco */
        font-weight: normal; /* AGREGADO: Asegura que no sea negrita excesiva */
    }
    .main-header-text h3 {
        font-size: 16px; /* CAMBIADO: Ajusta el tamaño de la fuente para el PDF */
        font-weight: bold; /* AGREGADO: Nombre de la universidad en negrita */
    }
    .main-header-text h4 {
        font-size: 14px; /* CAMBIADO: Tamaño de fuente para la facultad */
    }
    .main-header-text p {
        font-size: 12px; /* CAMBIADO: Tamaño de fuente para el sistema */
    }

    h2 { /* Título "Reporte Financiero por Evento" */
        text-align: center;
        margin-top: 25px;
        margin-bottom: 20px; /* CAMBIADO: Espacio debajo del título */
        color: var(--uta-negro); /* Título principal en negro */
        font-size: 18px; /* Mantenido el tamaño de fuente original */
        font-weight: bold; /* AGREGADO: Asegura que sea negrita */
    }

    /* Contenedores de tarjetas/paneles */
    .card {
        background: var(--uta-blanco);
        padding: 25px;
        margin-bottom: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* Sombra con negro */
        border: 1px solid var(--uta-negro); /* Borde en negro */
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
        color: var(--uta-negro); /* Color de etiqueta en negro */
    }

    select {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid var(--uta-negro); /* Borde en negro */
        border-radius: 6px;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.06); /* Sombra interna con negro */
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23b10024'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E"); /* Icono de flecha en rojo */
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 20px;
        cursor: pointer;
    }
    select:focus {
        border-color: var(--uta-rojo);
        box-shadow: 0 0 0 0.25rem rgba(177, 0, 36, 0.2); /* Usa el valor RGB del rojo para la sombra */
        outline: none;
    }

    .form-group {
        margin-bottom: 20px;
    }

    /* Botones de acción */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
        flex-wrap: wrap;
        align-items: flex-end; /* Alinea los elementos al final (parte inferior) */
    }

    .action-buttons form {
        margin: 0;
        flex-grow: 1;
        display: flex; /* Añadido para apilar label y select/button */
        flex-direction: column;
        gap: 8px;
    }

    .btn-primary {
        background-color: var(--uta-rojo); /* Fondo rojo */
        color: var(--uta-blanco);
        padding: 12px 25px;
        font-size: 16px;
        border: none; /* Sin borde, el fondo es el color principal */
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        font-weight: 600;
        min-width: 140px;
        text-align: center;
    }

    .btn-primary:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al pasar el ratón */
        box-shadow: 0 6px 15px rgba(var(--uta-rojo), 0.3); /* Sombra con rojo */
    }

    /* Sección de Título para "Recaudación por Forma de Pago", etc. */
    .section-title {
        background-color: var(--uta-rojo); /* CAMBIADO: Fondo rojo */
        color: var(--uta-blanco); /* Texto blanco */
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
        border-bottom: 1px solid var(--line-color); /* CAMBIADO: Línea debajo en gris */
    }
    .stats-table { /* Para el resumen general del reporte */
        width: 100%;
        border-collapse: collapse;
        margin-top: 0; /* CAMBIADO: Pegado a la section-title */
        font-size: 10px; /* CAMBIADO: Tamaño de fuente */
    }
    .stats-table td {
        padding: 6px 8px; /* CAMBIADO: Padding ajustado */
        border: 1px solid var(--line-color); /* CAMBIADO: Bordes grises */
        background-color: var(--uta-blanco); /* Fondo blanco */
        color: var(--uta-negro); /* Texto en negro */
    }
    .stats-table td:first-child {
        font-weight: bold;
        width: 150px; /* Ancho fijo para las etiquetas */
    }

    p {
        margin: 4px 0;
    }
    table { /* Tablas de datos principales */
        border-collapse: collapse;
        width: 100%;
        margin-top: 0; /* CAMBIADO: Pegado a la section-title */
        font-size: 10px; /* CAMBIADO: Tamaño de fuente */
    }
    th {
        background-color: var(--uta-rojo); /* CAMBIADO: Color rojo para los encabezados de tabla */
        color: var(--uta-blanco);
        padding: 8px 10px; /* CAMBIADO: Padding ajustado */
        border: 1px solid var(--line-color); /* CAMBIADO: Borde gris para celdas */
        text-align: left;
        font-weight: bold; /* AGREGADO: Asegura que sea negrita */
        text-transform: uppercase; /* AGREGADO: Mayúsculas para los encabezados */
    }
    td {
        border: 1px solid var(--line-color); /* CAMBIADO: Borde gris */
        padding: 7px 10px; /* CAMBIADO: Padding ajustado */
        background-color: var(--uta-blanco);
        color: var(--uta-negro); /* Texto en negro */
    }
    tbody tr:nth-child(even) {
        background-color: var(--uta-blanco); /* Todas las filas en blanco */
    }
    tbody tr:nth-child(odd) {
        background-color: var(--uta-blanco); /* Todas las filas en blanco */
    }
    .total-row {
        font-weight: bold;
        background-color: var(--uta-negro) !important; /* Fondo negro para el total */
        color: var(--uta-blanco) !important; /* Texto blanco para el total */
    }
    .total-row td {
        border: 1px solid var(--uta-negro) !important; /* Asegurar bordes negros */
        color: var(--uta-blanco) !important; /* Asegurar texto blanco */
    }
    a {
        color: var(--uta-rojo); /* Enlaces en rojo */
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
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
        table, thead, tbody, th, td, tr {
            display: block;
        }
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        tr { border: 1px solid var(--uta-negro); margin-bottom: 15px; border-radius: 8px; }
        td {
            border: none;
            border-bottom: 1px solid var(--uta-negro);
            position: relative;
            padding-left: 50%;
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
        /* Etiquetas para celdas en móvil */
        /* Recaudación por Forma de Pago */
        td:nth-of-type(1):before { content: "Forma de Pago:"; }
        td:nth-of-type(2):before { content: "Total Recaudado:"; }
        /* Pagos Pendientes */
        td:nth-of-type(1):before { content: "Nombre:"; }
        td:nth-of-type(2):before { content: "Correo:"; }
        td:nth-of-type(3):before { content: "Forma de Pago:"; }
        td:nth-of-type(4):before { content: "Monto:"; }
        td:nth-of-type(5):before { content: "Estado:"; }
        td:nth-of-type(6):before { content: "Fecha:"; }
        /* Comprobantes Subidos */
        td:nth-of-type(1):before { content: "Nombre:"; }
        td:nth-of-type(2):before { content: "Correo:"; }
        td:nth-of-type(3):before { content: "Monto:"; }
        td:nth-of-type(4):before { content: "Comprobante:"; }
        td:nth-of-type(5):before { content: "Estado:"; }
    }
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <h2><i class="fa fa-money-bill-wave"></i> Reporte Financiero por Evento</h2>

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

                <?php if (!empty($reporte['montos']) || !empty($reporte['pendientes']) || !empty($reporte['comprobantes'])): ?>
                    <form method="post" action="generar_reporte_financiero.php" target="_blank">
                        <label style="visibility:hidden; height: 0; margin: 0; padding: 0;">.</label>
                        <input type="hidden" name="evento" value="<?= $_POST['evento'] ?>">
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
                        <thead>
                            <tr>
                                <th>Forma de Pago</th>
                                <th>Total Recaudado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalRecaudadoGeneral = 0;
                            foreach ($reporte['montos'] as $monto):
                                $totalRecaudadoGeneral += $monto['TOTAL_RECAUDADO'];
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($monto['FORMA_PAGO']) ?></td>
                                    <td>$<?= number_format($monto['TOTAL_RECAUDADO'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="total-monto">Total General:</td>
                                <td class="total-monto">$<?= number_format($totalRecaudadoGeneral, 2) ?></td>
                            </tr>
                        </tfoot>
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
                                    <td><a href="<?= htmlspecialchars($c['COMPROBANTE_URL']) ?>" target="_blank" style="color: var(--uta-rojo); text-decoration: underline;">Ver Comprobante</a></td>
                                    <td><?= htmlspecialchars($c['ESTADO']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="no-data">No hay registros financieros para este evento.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
