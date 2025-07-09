<?php
require_once '../vendor/autoload.php';
require_once '../controllers/FinancieroController.php';

use Dompdf\Dompdf;

if (!isset($_POST['evento'])) {
    die("Evento no definido.");
}

$eventoId = intval($_POST['evento']);
$controller = new FinancieroController();
$reporte = $controller->obtenerReporte($eventoId);
$nombreEvento = $controller->obtenerNombreEvento($eventoId);
$fechaGeneracion = date('d/m/Y H:i');

$montos = $reporte['montos'];
$pendientes = $reporte['pendientes'];
$comprobantes = $reporte['comprobantes'];

// Iniciar HTML
$html = '
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h2 { text-align: center; margin-top: 10px; }
    .header {
        text-align: center;
        margin-bottom: 20px;
    }
    .uta-header {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
    .header img {
        height: 70px;
    }
    .section-title {
        background-color: #004080;
        color: white;
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
    }
    p { margin: 4px 0; }
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
        font-size: 11px;
    }
    th {
        background-color: #004080;
        color: white;
        padding: 6px;
        border: 1px solid #ccc;
        text-align: left;
    }
    td {
        border: 1px solid #ccc;
        padding: 5px;
    }
    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style>

<div class="header">
    <div class="uta-header">
        <div>
            <h3>UNIVERSIDAD TÉCNICA DE AMBATO</h3>
            <h4>Facultad de Ingeniería en Sistemas, Electrónica e Industrial - FISEI</h4>
        </div>
    </div>
</div>

<h2>Reporte Financiero</h2>
<p><strong>Evento:</strong> ' . htmlspecialchars($nombreEvento) . '</p>
<p><strong>Fecha de generación:</strong> ' . $fechaGeneracion . '</p>

<div class="section-title">1. Recaudación por Forma de Pago</div>
<table>
    <thead>
        <tr><th>Forma de Pago</th><th>Total Recaudado</th></tr>
    </thead>
    <tbody>';
foreach ($montos as $m) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($m['FORMA_PAGO']) . '</td>';
    $html .= '<td>$' . number_format($m['TOTAL_RECAUDADO'], 2) . '</td>';
    $html .= '</tr>';
}
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
foreach ($pendientes as $p) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($p['NOMBRE_COMPLETO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($p['CORREO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($p['FORMA_PAGO']) . '</td>';
    $html .= '<td>$' . number_format($p['MONTO'], 2) . '</td>';
    $html .= '<td>' . htmlspecialchars($p['ESTADO']) . '</td>';
    $html .= '<td>' . ($p['FECHA_PAGO'] ? $p['FECHA_PAGO']->format('Y-m-d') : '-') . '</td>';
    $html .= '</tr>';
}
$html .= '</tbody></table>';

$html .= '<div class="section-title">3. Comprobantes Subidos</div>
<table>
    <thead>
        <tr><th>Nombre</th><th>Correo</th><th>Monto</th><th>Comprobante</th><th>Estado</th></tr>
    </thead>
    <tbody>';
foreach ($comprobantes as $c) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($c['NOMBRE_COMPLETO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($c['CORREO']) . '</td>';
    $html .= '<td>$' . number_format($c['MONTO'], 2) . '</td>';
    $html .= '<td>' . htmlspecialchars($c['COMPROBANTE_URL']) . '</td>';
    $html .= '<td>' . htmlspecialchars($c['ESTADO']) . '</td>';
    $html .= '</tr>';
}
$html .= '</tbody></table>';

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$nombreLimpio = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nombreEvento);
$filename = "reporte_financiero_" . $nombreLimpio . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);
exit;
