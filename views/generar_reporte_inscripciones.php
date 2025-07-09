<?php
// Habilitar la visualización de errores para depuración.
// ¡Recuerda eliminar o comentar estas líneas en un entorno de producción!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$totalInscritos = $reporte['total']; // Renombrado a $totalInscritos para mayor claridad

if (empty($inscritos)) {
    die("No hay inscritos para este evento.");
}

$fechaGeneracion = date('Y-m-d H:i:s');

// Construcción del HTML
$html = '
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
        text-align: center; /* AGREGADO: Para centrar el contenido en la página de Dompdf */
    }

    /* Contenedor principal para el contenido del reporte */
    .report-container {
        width: 95%; /* Ajusta el ancho para que el contenido no toque los bordes */
        margin: 20px auto; /* Centra el contenedor en la página */
        text-align: left; /* Restablece la alineación de texto para el contenido interno */
    }

    /* Estilos para el encabezado principal (como se ve en la imagen) */
    .main-header { /* Nuevo contenedor para la cabecera principal */
        background-color: var(--uta-rojo); /* Fondo rojo para la cabecera */
        color: var(--uta-blanco); /* Texto blanco en la cabecera */
        padding: 15px 0; /* CAMBIADO: Padding vertical para el encabezado */
        text-align: center; /* Centrar el texto dentro del encabezado */
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

    h2 { /* Título "Reporte de Inscripciones" */
        text-align: center;
        margin-top: 25px; /* Un poco más de margen para que no se pegue al encabezado */
        margin-bottom: 20px; /* CAMBIADO: Espacio debajo del título */
        color: var(--uta-negro); /* Título principal en negro */
        font-size: 18px; /* Mantenido el tamaño de fuente original */
        font-weight: bold; /* AGREGADO: Asegura que sea negrita */
    }

    .section-title { /* Para "RESUMEN DEL REPORTE" o "Listado de Inscritos" */
        background-color: var(--uta-rojo); /* CAMBIADO: Fondo rojo */
        color: var(--uta-blanco); /* Texto blanco */
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
        border-bottom: 1px solid var(--line-color); /* CAMBIADO: Línea debajo en gris */
    }
    .stats-table { /* Para el resumen del reporte */
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
    table { /* Tabla de datos principal (Listado de Inscritos) */
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
    /* Estilos para el total y mensajes de no data, similares al reporte financiero */
    .total-count {
        font-weight: bold;
        margin: 20px 0;
        font-size: 1.2rem; /* Mantenido el tamaño de fuente original */
        text-align: center;
        color: var(--uta-blanco); /* Mantenido: Texto blanco */
        padding: 10px;
        background-color: var(--uta-negro); /* Mantenido: Fondo negro */
        border-radius: 8px;
        border: 1px solid var(--uta-negro); /* Mantenido: Borde negro */
    }
    .no-data-message {
        color: var(--uta-rojo); /* Mantenido: Color en rojo */
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        padding: 10px;
        background-color: var(--uta-blanco); /* Mantenido: Fondo blanco */
        border-radius: 8px;
        border: 1px solid var(--uta-negro); /* Mantenido: Borde negro */
    }
</style>

<div class="main-header">
    <div class="main-header-text">
        <h3>UNIVERSIDAD TÉCNICA DE AMBATO</h3>
        <h4>FACULTAD DE INGENIERÍA EN SISTEMAS</h4>
        <p>SISTEMA DE GESTIÓN ESTUDIANTIL</p>
    </div>
</div>

<div class="report-container">
    <h2>Reporte de Inscripciones</h2>

    <div class="section-title">RESUMEN DEL REPORTE</div>
    <table class="stats-table">
        <tr>
            <td><strong>ID del Evento:</strong></td>
            <td>' . htmlspecialchars($eventoId) . '</td>
        </tr>
        <tr>
            <td><strong>Total de Inscritos:</strong></td>
            <td>' . htmlspecialchars($totalInscritos) . '</td>
        </tr>
        <tr>
            <td><strong>Fecha de Generación:</strong></td>
            <td>' . $fechaGeneracion . '</td>
        </tr>
    </table>

    <br>
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

$html .= '</tbody></table>
</div>'; // Cierre del report-container

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Manteniendo portrait como en tu código original
$dompdf->render();

$filename = "reporte_inscripciones_evento_" . $eventoId . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);
exit;

?>
