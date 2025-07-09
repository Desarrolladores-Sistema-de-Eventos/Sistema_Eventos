<?php
// Habilitar la visualización de errores para depuración.
// ¡Recuerda eliminar o comentar estas líneas en un entorno de producción!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$eventoNombre = htmlspecialchars($responsables[0]['EVENTO']);
$fechaInicio = $responsables[0]['FECHAINICIO']->format('Y-m-d');
$fechaFin = $responsables[0]['FECHAFIN']->format('Y-m-d');
$fechaGeneracion = date('Y-m-d H:i:s');

// Comenzar HTML
$html = '
<style>
    /* Definición de colores principales: ÚNICAMENTE ROJO, BLANCO Y NEGRO */
    :root {
        --uta-rojo: #b10024; /* Rojo principal de UTA */
        --uta-negro: #1a1a1a; /* Negro secundario */
        --uta-blanco: #ffffff; /* Blanco de complemento */
        --line-color: #666666; /* Color gris para las líneas menos visibles */
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 10px; /* Tamaño de fuente ligeramente reducido para PDF */
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
        padding: 15px 0; /* Padding vertical para el encabezado */
        text-align: center; /* Centrar el texto dentro del encabezado */
        width: 100%;
        box-sizing: border-box;
    }
    .main-header h3, .main-header h4, .main-header p {
        margin: 0;
        line-height: 1.2;
        color: var(--uta-blanco); /* Texto blanco */
        font-weight: normal; /* Asegura que no sea negrita excesiva */
    }
    .main-header h3 {
        font-size: 16px; /* Ajusta el tamaño de la fuente para el PDF */
        font-weight: bold; /* Nombre de la universidad en negrita */
    }
    .main-header h4 {
        font-size: 14px; /* Tamaño de fuente para la facultad */
    }
    .main-header p {
        font-size: 12px; /* Tamaño de fuente para el sistema */
    }

    h2 { /* Título "Reporte de Evento y Asistentes" */
        text-align: center;
        margin-top: 25px;
        margin-bottom: 20px; /* Espacio debajo del título */
        color: var(--uta-negro); /* Título principal en negro */
        font-size: 18px; /* Tamaño de fuente para el título del reporte */
        font-weight: bold;
    }

    /* Sección de Título para "RESUMEN DEL EVENTO" o "Listado de Asistentes" */
    .section-title {
        background-color: var(--uta-rojo); /* CAMBIADO: Fondo rojo */
        color: var(--uta-blanco); /* Texto blanco */
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 5px; /* Más margen inferior para separar del contenido */
        border-bottom: 1px solid var(--line-color); /* CAMBIADO: Línea debajo en gris */
    }
    .stats-table { /* Para el resumen del evento */
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
        font-size: 11px;
    }
    .stats-table td {
        padding: 4px;
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
    table { /* Tabla de datos principal (responsables y asistentes) */
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
        font-size: 11px;
    }
    th {
        background-color: var(--uta-rojo); /* CAMBIADO: Color rojo para los encabezados de tabla */
        color: var(--uta-blanco); /* Texto blanco */
        padding: 6px;
        border: 1px solid var(--line-color); /* CAMBIADO: Borde gris */
        text-align: left;
    }
    td {
        border: 1px solid var(--line-color); /* CAMBIADO: Borde gris */
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
    ul {
        list-style: none; /* Eliminar viñetas predeterminadas */
        padding: 0;
        margin: 10px 0;
    }
    ul li {
        margin-bottom: 5px;
        background-color: var(--uta-blanco); /* Fondo blanco para los ítems de la lista */
        padding: 4px 8px;
        border-left: 3px solid var(--uta-rojo); /* Barra lateral roja para los ítems de la lista */
        color: var(--uta-negro); /* Texto en negro */
    }
    ul li strong {
        color: var(--uta-negro); /* Asegurar que el texto fuerte sea negro */
    }
</style>

<div class="main-header">
    <h3>UNIVERSIDAD TÉCNICA DE AMBATO</h3>
    <h4>FACULTAD DE INGENIERÍA EN SISTEMAS</h4>
    <p>SISTEMA DE GESTIÓN ESTUDIANTIL</p>
</div>

<div class="report-container">
    <h2>Reporte de Evento y Asistentes</h2>

    <div class="section-title">RESUMEN DEL EVENTO</div>
    <table class="stats-table">
        <tr>
            <td><strong>Evento:</strong></td>
            <td>' . htmlspecialchars($eventoNombre) . '</td>
        </tr>
        <tr>
            <td><strong>Fechas:</strong></td>
            <td>' . $fechaInicio . ' al ' . $fechaFin . '</td>
        </tr>
        <tr>
            <td><strong>Fecha de Generación:</strong></td>
            <td>' . $fechaGeneracion . '</td>
        </tr>
        <tr>
            <td><strong>Total de Asistentes:</strong></td>
            <td>' . count($asistentes) . '</td>
        </tr>
    </table>

    <br>
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

$html .= '</tbody></table>
</div>'; // Cierre del report-container

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Manteniendo portrait como estaba en tu código original
$dompdf->render();

$nombreArchivoEvento = preg_replace('/[^a-zA-Z0-9_-]/', '_', $eventoNombre);
$filename = "reporte_asistentes_" . $nombreArchivoEvento . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);
exit;

?>
