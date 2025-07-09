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
$fechaGeneracion = date('Y-m-d H:i:s'); // Obtener fecha y hora actual

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

    h2 { /* Título "Reporte de Certificados Emitidos" */
        text-align: center;
        margin-top: 25px;
        margin-bottom: 20px; /* Espacio debajo del título */
        color: var(--uta-negro); /* Título principal en negro */
        font-size: 18px; /* Tamaño de fuente para el título del reporte */
        font-weight: bold;
    }

    /* Sección de Título para "RESUMEN DEL EVENTO" y "DETALLE DE CERTIFICADOS" */
    .section-title {
        background-color: var(--uta-rojo); /* Fondo rojo */
        color: var(--uta-blanco); /* Texto blanco */
        padding: 6px 10px;
        font-weight: bold;
        margin-top: 20px; /* Espacio encima de cada sección */
        margin-bottom: 0; /* Eliminar margen inferior */
        border-bottom: 1px solid var(--line-color); /* CAMBIADO: Línea debajo en gris */
    }

    /* Tabla de resumen estadístico */
    .stats-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0; /* Pegado a la section-title */
        font-size: 10px; /* Tamaño de fuente */
    }
    .stats-table td {
        padding: 6px 8px; /* Padding ajustado */
        border: 1px solid var(--line-color); /* CAMBIADO: Bordes grises */
        background-color: var(--uta-blanco); /* Fondo blanco */
        color: var(--uta-negro); /* Texto en negro */
    }
    .stats-table td:first-child {
        font-weight: bold;
        width: 150px; /* Ancho fijo para la primera columna */
    }

    /* Tabla de datos principal */
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 0; /* Pegado a la section-title */
        font-size: 10px; /* Tamaño de fuente */
    }
    th {
        background-color: var(--uta-rojo); /* Color rojo para los encabezados de tabla */
        color: var(--uta-blanco); /* Texto blanco */
        padding: 8px 10px; /* Padding ajustado */
        border: 1px solid var(--line-color); /* CAMBIADO: Borde gris */
        text-align: left;
        font-weight: bold;
        text-transform: uppercase; /* Mayúsculas para los encabezados */
    }
    td {
        border: 1px solid var(--line-color); /* CAMBIADO: Borde gris */
        padding: 7px 10px; /* Padding ajustado */
        background-color: var(--uta-blanco); /* Fondo blanco */
        color: var(--uta-negro); /* Texto en negro */
    }
    /* Asegurarse de que todas las filas de la tabla principal sean blancas */
    tbody tr {
        background-color: var(--uta-blanco) !important;
    }
    a {
        color: var(--uta-rojo); /* Enlaces en rojo */
        text-decoration: underline;
    }
</style>

<div class="main-header">
    <h3>UNIVERSIDAD TÉCNICA DE AMBATO</h3>
    <h4>FACULTAD DE INGENIERÍA EN SISTEMAS</h4>
    <p>SISTEMA DE GESTIÓN ESTUDIANTIL</p>
</div>

<div class="report-container">
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
    // Asegurarse de que la URL del certificado sea un enlace clicable
    $html .= '<td><a href="' . htmlspecialchars($cert['URL_CERTIFICADO']) . '" target="_blank">' . htmlspecialchars($cert['FECHA_EMISION']) . '</a></td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>
</div>'; // Cierre del report-container

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape'); // Orientación horizontal
$dompdf->render();

// Descargar
$nombreArchivoEvento = preg_replace('/[^a-zA-Z0-9_-]/', '_', $eventoNombre);
$filename = "reporte_certificados_" . $nombreArchivoEvento . "_" . date('Ymd_His') . ".pdf"; // Añadir fecha y hora al nombre del archivo
$dompdf->stream($filename, ["Attachment" => true]);
exit;

?>
