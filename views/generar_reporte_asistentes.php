<?php
require_once '../vendor/autoload.php';
require_once '../controllers/EventoAsistenciaController.php';

use Dompdf\Dompdf;

if (!isset($_POST['evento'])) {
    die("Evento no definido.");
}

$eventoId = intval($_POST['evento']);
$controller = new EventoAsistenciaController();
$reporte = $controller->obtenerReporte($eventoId);
$responsables = $reporte['responsables'];
$asistentes = $reporte['asistentes'];

if (empty($responsables)) {
    die("No hay información disponible para este evento.");
}

$eventoNombre = $responsables[0]['EVENTO'];
$fechaInicio = $responsables[0]['FECHAINICIO']->format('Y-m-d');
$fechaFin = $responsables[0]['FECHAFIN']->format('Y-m-d');
$fechaGeneracion = date('Y-m-d H:i:s');

// Comenzar HTML
$html = '
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h2, h4 { text-align: center; }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }
    .header img {
        height: 70px;
        margin: 0 20px;
    }
    .uta-header {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
    .section-title {
        background-color: #004080;
        color: white;
        padding: 6px;
        margin-top: 20px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 6px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>

<div class="header">
    <div class="uta-header">
        <div>
            <h3>UNIVERSIDAD TÉCNICA DE AMBATO</h3>
            <h4>Facultad de Ingeniería en Sistemas, Electrónica e Industrial</h4>
        </div>
    </div>
</div>

<h2>Reporte de Evento y Asistentes</h2>
<p><strong>Evento:</strong> ' . htmlspecialchars($eventoNombre) . '</p>
<p><strong>Fecha del Evento:</strong> ' . $fechaInicio . ' al ' . $fechaFin . '</p>
<p><strong>Fecha de Generación:</strong> ' . $fechaGeneracion . '</p>

<div class="section-title">Responsables</div>
<ul>';
foreach ($responsables as $r) {
    $html .= '<li><strong>Nombre:</strong> ' . htmlspecialchars($r['RESPONSABLE']) .
             ' (' . htmlspecialchars($r['CARGO']) . ') - <strong>Correo:</strong> ' .
             htmlspecialchars($r['CORREO']) . '</li>';
}
$html .= '</ul>

<div class="section-title">Listado de Asistentes</div>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Facultad</th>
            <th>Carrera</th>
            <th>Estado</th>
            <th>Ponderación</th>
        </tr>
    </thead>
    <tbody>';

foreach ($asistentes as $a) {
    $html .= '<tr>
        <td>' . htmlspecialchars($a['NOMBRE_COMPLETO']) . '</td>
        <td>' . htmlspecialchars($a['CORREO']) . '</td>
        <td>' . htmlspecialchars($a['FACULTAD']) . '</td>
        <td>' . htmlspecialchars($a['CARRERA']) . '</td>
        <td>' . htmlspecialchars($a['ESTADO_PARTICIPACION']) . '</td>
        <td>' . (is_numeric($a['PONDERACION']) ? $a['PONDERACION'] : '-') . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$nombreArchivoEvento = preg_replace('/[^a-zA-Z0-9_-]/', '_', $eventoNombre);
$filename = "reporte_asistentes_" . $nombreArchivoEvento . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);
exit;
