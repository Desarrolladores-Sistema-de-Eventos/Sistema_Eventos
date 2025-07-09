<?php
require_once '../vendor/autoload.php';
require_once '../controllers/EventoCategoriaController.php';

use Dompdf\Dompdf;

if (!isset($_POST['categoria']) || empty($_POST['categoria'])) {
    die("Categoría no especificada.");
}

$categoriaId = intval($_POST['categoria']);
$controller = new EventoCategoriaController();
$eventos = $controller->listarEventos($categoriaId);
$categorias = $controller->listarCategorias();

$categoriaNombre = 'Desconocida';
foreach ($categorias as $cat) {
    if ($cat['SECUENCIAL'] == $categoriaId) {
        $categoriaNombre = $cat['NOMBRE'];
        break;
    }
}

$fechaGeneracion = date('Y-m-d H:i:s');

if (empty($eventos)) {
    die("No hay eventos para esta categoría.");
}

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

<h2>Reporte de Eventos por Categoría</h2>
<p><strong>Categoría:</strong> ' . htmlspecialchars($categoriaNombre) . '</p>
<p><strong>Fecha de Generación:</strong> ' . $fechaGeneracion . '</p>

<div class="section-title">Listado de Eventos</div>
<table>
    <thead>
        <tr>
            <th>Evento</th>
            <th>Carrera</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Estado</th>
            <th>Pagado</th>
            <th>Inscritos</th>
            <th>Capacidad</th>
            <th>Organizadores</th>
        </tr>
    </thead>
    <tbody>';

foreach ($eventos as $e) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($e['EVENTO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($e['CARRERA'] ?? 'Todas') . '</td>';
    $html .= '<td>' . (is_a($e['FECHAINICIO'], 'DateTime') ? $e['FECHAINICIO']->format('Y-m-d') : '-') . '</td>';
    $html .= '<td>' . (is_a($e['FECHAFIN'], 'DateTime') ? $e['FECHAFIN']->format('Y-m-d') : '-') . '</td>';
    $html .= '<td>' . htmlspecialchars($e['ESTADO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($e['PAGADO']) . '</td>';
    $html .= '<td>' . htmlspecialchars($e['INSCRITOS']) . '</td>';
    $html .= '<td>' . htmlspecialchars($e['CAPACIDAD']) . '</td>';
    $html .= '<td>' . htmlspecialchars($e['ORGANIZADORES']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$nombreArchivo = preg_replace('/[^a-zA-Z0-9_-]/', '_', $categoriaNombre);
$dompdf->stream("reporte_eventos_" . $nombreArchivo . ".pdf", ["Attachment" => true]);
exit;
