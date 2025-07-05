<?php
// Habilitar la visualización de errores para depuración.
// ¡Recuerda eliminar o comentar estas líneas en un entorno de producción!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// --- SE ELIMINÓ TODO EL CÓDIGO RELACIONADO CON LA IMAGEN DEL LOGO AQUÍ ---


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
        display: flex; /* Mantenemos flex para centrar o alinear el texto si no hay logo */
        align-items: center;
        justify-content: center; /* CAMBIO: Centrar el contenido si no hay logo */
        width: 100%;
        box-sizing: border-box; /* Incluye padding en el ancho total */
    }
    /* SE ELIMINÓ EL CSS DE main-header img */
    .main-header-text {
        text-align: center; /* CAMBIO: Centrar el texto ya que no hay logo a su lado */
        /* margin-left: auto; -- ESTO YA NO ES NECESARIO SI EL CONTENIDO ESTÁ CENTRADO */
    }
    .main-header-text h3, .main-header-text h4, .main-header-text p {
        margin: 0;
        line-height: 1.2;
        color: white; /* Texto blanco */
    }
    .section-title { /* Para "RESUMEN ESTADÍSTICO" en el ejemplo */
        background-color: #f2f2f2; /* Color de fondo gris claro */
        color: #333; /* Texto oscuro */
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px;
        border-bottom: 1px solid #ccc; /* Línea debajo */
    }
    .stats-table { /* Para el resumen estadístico */
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
    table { /* Tabla de datos principal */
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
</style>

<div class="main-header">
    <div class="main-header-text">
        <h3>UNIVERSIDAD TÉCNICA DE AMBATO</h3>
        <h4>FACULTAD DE INGENIERÍA EN SISTEMAS</h4>
        <p>SISTEMA DE GESTIÓN ESTUDIANTIL</p>
    </div>
</div>

<h2>Reporte de Certificados Emitidos</h2>

<div class="section-title">RESUMEN DEL EVENTO</div>
<table class="stats-table">
    <tr>
        <td><strong>Evento:</strong></td>
        <td>' . $eventoNombre . '</td>
    </tr>
    <tr>
        <td><strong>Fecha de Generación:</strong></td>
        <td>' . $fechaGeneracion . '</td>
    </tr>
    <tr>
        <td><strong>Total de Certificados:</strong></td>
        <td>' . count($certificados) . '</td>
    </tr>
</table>

<br>
<div class="section-title">DETALLE DE CERTIFICADOS</div>

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
    $html .= '<td>' . htmlspecialchars($cert['NOMBRE_COMPLETO']) . '</td>';
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

?>