<?php
require_once '../vendor/autoload.php';
require_once '../controllers/InscripcionController.php';

use Dompdf\Dompdf;

if (!isset($_POST['evento'])) {
    die("Evento no definido.");
}

$eventoId = intval($_POST['evento']);
$controller = new InscripcionController();
$reporte = $controller->obtenerReporte($eventoId);
$inscritos = $reporte['datos'];
$total = $reporte['total'];

if (empty($inscritos)) {
    die("No hay inscritos para este evento.");
}

$fechaGeneracion = date('Y-m-d H:i:s');

// Construcción del HTML
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

<h2>Reporte de Inscripciones</h2>
<p><strong>ID del Evento:</strong> ' . $eventoId . '</p>
<p><strong>Total Inscritos:</strong> ' . $total . '</p>
<p><strong>Fecha de Generación:</strong> ' . $fechaGeneracion . '</p>

<div class="section-title">Listado de Inscritos</div>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Carrera</th>
            <th>Facultad</th>
        </tr>
    </thead>
    <tbody>';

foreach ($inscritos as $ins) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($ins['NOMBRE COMPLETO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($ins['CORREO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($ins['CARRERA']) . '</td>';
    $html .= '<td>' . htmlspecialchars($ins['FACULTAD']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$filename = "reporte_inscripciones_evento_" . $eventoId . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);
exit;
