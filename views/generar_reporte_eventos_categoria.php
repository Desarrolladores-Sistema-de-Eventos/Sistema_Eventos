<?php
// Habilitar la visualización de errores para depuración.
// ¡Recuerda eliminar o comentar estas líneas en un entorno de producción!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    /* Definición de colores principales: ÚNICAMENTE ROJO, BLANCO Y NEGRO */
    :root {
        --uta-rojo: #b10024; /* Rojo principal de UTA */
        --uta-rojo-oscuro: #92001c; /* Tono más oscuro de rojo */
        --uta-negro: #000000;
        --uta-blanco: #ffffff;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin: 0;
        padding: 0;
        color: var(--uta-negro); /* Texto general en negro */
    }
    h2 {
        text-align: center;
        margin-top: 25px; /* Un poco más de margen para que no se pegue al encabezado */
        margin-bottom: 15px;
        color: var(--uta-negro); /* Título principal en negro, como en el estilo anterior de certificados */
        font-size: 18px;
    }
    .main-header { /* Nuevo contenedor para la cabecera principal */
        background-color: var(--uta-rojo); /* Fondo rojo para la cabecera */
        color: var(--uta-blanco); /* Texto blanco en la cabecera */
        padding: 10px 20px;
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
        color: var(--uta-blanco); /* Texto blanco */
    }
    .section-title { /* Para "RESUMEN DEL REPORTE" o "Listado de Eventos" */
        background-color: var(--uta-negro); /* Fondo negro */
        color: var(--uta-blanco); /* Texto blanco */
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
        border-bottom: 1px solid var(--uta-negro); /* Línea debajo en negro */
    }
    .stats-table { /* Para el resumen del reporte */
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
        font-size: 11px;
    }
    .stats-table td {
        padding: 4px;
        border: 1px solid var(--uta-negro); /* Bordes en negro */
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
    table { /* Tabla de datos principal (Listado de Eventos) */
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
        font-size: 11px;
    }
    th {
        background-color: var(--uta-negro); /* Color negro para los encabezados de tabla */
        color: var(--uta-blanco);
        padding: 6px;
        border: 1px solid var(--uta-negro); /* Borde negro para celdas */
        text-align: left;
    }
    td {
        border: 1px solid var(--uta-negro); /* Borde negro */
        padding: 5px;
        background-color: var(--uta-blanco);
        color: var(--uta-negro); /* Texto en negro */
    }
    tbody tr:nth-child(even) {
        background-color: var(--uta-blanco); /* Todas las filas en blanco */
    }
    tbody tr:nth-child(odd) {
        background-color: var(--uta-blanco); /* Todas las filas en blanco */
    }
</style>

<div class="main-header">
    <div class="main-header-text">
        <h3>UNIVERSIDAD TÉCNICA DE AMBATO</h3>
        <h4>FACULTAD DE INGENIERÍA EN SISTEMAS</h4>
        <p>SISTEMA DE GESTIÓN ESTUDIANTIL</p>
    </div>
</div>

<h2>Reporte de Eventos por Categoría</h2>

<div class="section-title">RESUMEN DEL REPORTE</div>
<table class="stats-table">
    <tr>
        <td><strong>Categoría Seleccionada:</strong></td>
        <td>' . htmlspecialchars($categoriaNombre) . '</td>
    </tr>
    <tr>
        <td><strong>Fecha de Generación:</strong></td>
        <td>' . $fechaGeneracion . '</td>
    </tr>
    <tr>
        <td><strong>Total de Eventos:</strong></td>
        <td>' . count($eventos) . '</td>
    </tr>
</table>

<br>
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
$dompdf->setPaper('A4', 'landscape'); // Manteniendo landscape como en tu código original
$dompdf->render();

$nombreArchivo = preg_replace('/[^a-zA-Z0-9_-]/', '_', $categoriaNombre);
$dompdf->stream("reporte_eventos_" . $nombreArchivo . ".pdf", ["Attachment" => true]);
exit;

?>
