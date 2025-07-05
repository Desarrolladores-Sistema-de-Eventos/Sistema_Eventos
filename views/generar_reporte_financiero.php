<?php
// Habilitar la visualización de errores para depuración.
// ¡Recuerda eliminar o comentar estas líneas en un entorno de producción!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once '../controllers/FinancieroController.php';

use Dompdf\Dompdf;

if (!isset($_POST['evento'])) {
    die("Evento no definido.");
}

$eventoId = intval($_POST['evento']);
$controller = new FinancieroController();
$reporte = $controller->obtenerReporte($eventoId);
$nombreEvento = $controller->obtenerNombreEvento($eventoId); // Asumo que esto devuelve el nombre directamente
$fechaGeneracion = date('d/m/Y H:i');

$montos = $reporte['montos'];
$pendientes = $reporte['pendientes'];
$comprobantes = $reporte['comprobantes'];

// Iniciar HTML
$html = '
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }
    h2 {
        text-align: center;
        margin-top: 25px; /* Un poco más de margen para que no se pegue al encabezado */
        margin-bottom: 15px;
        color: #B71C1C; /* Color rojo */
        font-size: 18px;
    }
    .main-header { /* Nuevo contenedor para la cabecera principal */
        background-color: #B71C1C; /* Fondo rojo para la cabecera */
        color: white; /* Texto blanco en la cabecera */
        padding: 10px 20px; /* Padding interno */
        display: flex;
        align-items: center;
        justify-content: center; /* Centrar el contenido */
        width: 100%;
        box-sizing: border-box; /* Incluye padding en el ancho total */
    }
    .main-header-text {
        text-align: center; /* Centrar el texto */
    }
    .main-header-text h3, .main-header-text h4, .main-header-text p {
        margin: 0;
        line-height: 1.2;
        color: white; /* Texto blanco */
    }
    .section-title { /* Para "Recaudación por Forma de Pago", etc. */
        background-color: #f2f2f2; /* Color de fondo gris claro */
        color: #333; /* Texto oscuro */
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
        border-bottom: 1px solid #ccc; /* Línea debajo */
    }
    .stats-table { /* Para el resumen general del reporte */
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
        font-size: 11px;
    }
    .stats-table td {
        padding: 4px;
        border: none; /* Sin bordes en esta tabla de resumen */
        background-color: #f2f2f2;
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
        margin-top: 10px;
        font-size: 11px;
    }
    th {
        background-color: #B71C1C; /* Color rojo para los encabezados de tabla */
        color: white;
        padding: 6px;
        border: 1px solid #B71C1C; /* Borde rojo para celdas */
        text-align: left;
    }
    td {
        border: 1px solid #ccc;
        padding: 5px;
        background-color: #fff;
    }
    tbody tr:nth-child(even) {
        background-color: #f8d7da; /* Color para filas pares (similar al rojo claro) */
    }
    tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    .total-row {
        font-weight: bold;
        background-color: #e0e0e0 !important; /* Un gris más oscuro para el total */
    }
</style>

<div class="main-header">
    <div class="main-header-text">
        <h3>UNIVERSIDAD TÉCNICA DE AMBATO</h3>
        <h4>FACULTAD DE INGENIERÍA EN SISTEMAS</h4>
        <p>SISTEMA DE GESTIÓN ESTUDIANTIL</p>
    </div>
</div>

<h2>Reporte Financiero del Evento</h2>

<div class="section-title">RESUMEN DEL REPORTE</div>
<table class="stats-table">
    <tr>
        <td><strong>Evento:</strong></td>
        <td>' . htmlspecialchars($nombreEvento) . '</td>
    </tr>
    <tr>
        <td><strong>Fecha de Generación:</strong></td>
        <td>' . $fechaGeneracion . '</td>
    </tr>
</table>

<br>
<div class="section-title">1. Recaudación por Forma de Pago</div>
<table>
    <thead>
        <tr><th>Forma de Pago</th><th>Total Recaudado</th></tr>
    </thead>
    <tbody>';
$totalRecaudadoGeneral = 0;
foreach ($montos as $m) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($m['FORMA_PAGO']) . '</td>';
    $html .= '<td>$' . number_format($m['TOTAL_RECAUDADO'], 2) . '</td>';
    $html .= '</tr>';
    $totalRecaudadoGeneral += $m['TOTAL_RECAUDADO'];
}
// Fila para el total recaudado
$html .= '<tr class="total-row">';
$html .= '<td><strong>TOTAL RECAUDADO:</strong></td>';
$html .= '<td><strong>$' . number_format($totalRecaudadoGeneral, 2) . '</strong></td>';
$html .= '</tr>';
$html .= '</tbody></table>';

$html .= '<div class="section-title">2. Pagos Pendientes</div>
<table>
    <thead>
        <tr>
            <th>Nombre</th><th>Correo</th><th>Forma de Pago</th>
            <th>Monto</th><th>Estado</th><th>Fecha</th>
        </tr>
    </thead>
    <tbody>';
$totalPendiente = 0;
foreach ($pendientes as $p) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($p['NOMBRE_COMPLETO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($p['CORREO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($p['FORMA_PAGO']) . '</td>';
    $html .= '<td>$' . number_format($p['MONTO'], 2) . '</td>';
    $html .= '<td>' . htmlspecialchars($p['ESTADO']) . '</td>';
    $html .= '<td>' . ($p['FECHA_PAGO'] ? $p['FECHA_PAGO']->format('Y-m-d') : '-') . '</td>';
    $html .= '</tr>';
    $totalPendiente += $p['MONTO'];
}
// Fila para el total pendiente
$html .= '<tr class="total-row">';
$html .= '<td colspan="3"><strong>TOTAL PENDIENTE:</strong></td>';
$html .= '<td><strong>$' . number_format($totalPendiente, 2) . '</strong></td>';
$html .= '<td colspan="2"></td>'; // Celdas vacías para completar la fila
$html .= '</tr>';
$html .= '</tbody></table>';

$html .= '<div class="section-title">3. Comprobantes Subidos</div>
<table>
    <thead>
        <tr><th>Nombre</th><th>Correo</th><th>Monto</th><th>Comprobante</th><th>Estado</th></tr>
    </thead>
    <tbody>';
$totalComprobantes = 0;
foreach ($comprobantes as $c) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($c['NOMBRE_COMPLETO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($c['CORREO']) . '</td>';
    $html .= '<td>$' . number_format($c['MONTO'], 2) . '</td>';
    $html .= '<td>' . htmlspecialchars($c['COMPROBANTE_URL']) . '</td>';
    $html .= '<td>' . htmlspecialchars($c['ESTADO']) . '</td>';
    $html .= '</tr>';
    $totalComprobantes += $c['MONTO'];
}
// Fila para el total de comprobantes subidos
$html .= '<tr class="total-row">';
$html .= '<td colspan="2"><strong>TOTAL COMPROBANTES:</strong></td>';
$html .= '<td><strong>$' . number_format($totalComprobantes, 2) . '</strong></td>';
$html .= '<td colspan="2"></td>'; // Celdas vacías para completar la fila
$html .= '</tr>';
$html .= '</tbody></table>';

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Manteniendo portrait como en tu código original
$dompdf->render();

$nombreLimpio = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nombreEvento);
$filename = "reporte_financiero_" . $nombreLimpio . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);
exit;

?>