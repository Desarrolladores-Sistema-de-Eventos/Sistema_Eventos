<?php
require_once '../vendor/autoload.php';
require_once '../controllers/CertificadoController.php';

use Dompdf\Dompdf;

if (!isset($_POST['evento'])) {
    die("Evento no especificado.");
}

$eventoId = intval($_POST['evento']);
$controller = new CertificadoController();
$certificados = $controller->obtenerReporte($eventoId);

if (empty($certificados)) {
    die("No hay certificados para este evento.");
}

$eventoNombre = htmlspecialchars($certificados[0]['NOMBRE_EVENTO']);
$fechaGeneracion = date('Y-m-d H:i:s');

$html = '
<style>
<style>
    body {
    font-family: Arial, sans-serif; font-size: 12px;
    }
    h2 {
        text-align: center;
        margin-top: 10px;
    }
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
        background-color: #004080
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
    }
    p {
        margin: 4px 0;
    }
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

<h2>Reporte de Certificados Emitidos</h2>
<p><strong>Evento:</strong> ' . $eventoNombre . '</p>
<p><strong>Fecha de Generación:</strong> ' . $fechaGeneracion . '</p>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Tipo</th>
            <th>URL Certificado</th>
            <th>Fecha Emisión</th>
        </tr>
    </thead>
    <tbody>';

foreach ($certificados as $cert) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($cert['NOMBREUNIDO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($cert['CORREO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($cert['TIPO_CERTIFICADO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($cert['URL_CERTIFICADO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($cert['FECHA_EMISION']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Descargar
$nombreArchivoEvento = preg_replace('/[^a-zA-Z0-9_-]/', '_', $eventoNombre);
$filename = "reporte_certificados_" . $nombreArchivoEvento . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);
exit;
