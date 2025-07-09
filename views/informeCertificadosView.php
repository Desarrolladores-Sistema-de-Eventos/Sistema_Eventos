<?php
require_once '../controllers/CertificadoController.php';

$controller = new CertificadoController();
$eventos = $controller->listarEventos();
$certificados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])) {
    $idEvento = intval($_POST['evento']);
    $certificados = $controller->obtenerReporte($idEvento);
}
?>

<?php include("partials/header_Admin.php"); ?>

<style>
    /* Definición de colores principales para asegurar consistencia */
    :root {
        --uta-rojo: #b10024; /* Rojo principal de UTA */
        --uta-rojo-oscuro: #92001c; /* Tono más oscuro de rojo */
        --uta-negro: #000000; /* Negro para bordes y texto principal */
        --uta-blanco: #ffffff; /* Blanco para fondos y texto complementario */
        --uta-gris-claro: #f5f5f5; /* Para fondos sutiles de filas pares, etc. */
        --uta-gris-medio: #e0e0e0; /* Para bordes de formularios y elementos */
        --uta-gris-oscuro: #333; /* Para texto general que no es negro puro */
    }

    body {
        font-family: 'Poppins', sans-serif; /* Usar Poppins si está enlazado en header_Admin */
        background-color: var(--uta-blanco); /* Fondo general de la página en blanco */
        color: var(--uta-gris-oscuro); /* Color de texto por defecto */
    }

    /* Contenedor principal para centrar el contenido */
    #page-inner {
        padding: 25px; /* Espaciado interno */
        max-width: 1200px; /* Ancho máximo para el contenido principal */
        margin: 0 auto; /* Centrar el contenido en la página */
    }

    /* Títulos */
    h2, h3, h4 {
        color: var(--uta-rojo); /* Títulos de sección en rojo primario */
        font-weight: bold;
        margin-bottom: 15px;
        text-align: left; /* Alineación por defecto para subtítulos */
    }

    h2 {
        text-align: center; /* Título principal centrado */
        margin-bottom: 25px; /* Más espacio debajo del título principal */
        font-size: 2.2rem; /* Mantenido el tamaño de fuente original */
        color: var(--uta-negro); /* Título principal en negro secundario */
    }

    h2 i {
        color: var(--uta-rojo); /* Icono en rojo primario */
        margin-right: 10px; /* Espaciado adecuado para el icono */
    }

    /* Contenedores de tarjetas/paneles */
    .card {
        background: var(--uta-blanco);
        padding: 25px;
        margin-bottom: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* Sombra mejorada */
        border: 1px solid var(--uta-negro); /* Ambos cards ahora tienen borde negro */
    }

    /* Grupos de formulario */
    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
        color: var(--uta-gris-oscuro); /* Color de etiqueta */
    }

    /* Selectores de formulario */
    select {
        width: 100%;
        padding: 12px; /* Mantenido el tamaño de padding original */
        font-size: 16px; /* Mantenido el tamaño de fuente original */
        border: 1px solid var(--uta-negro); /* CAMBIADO: Borde en negro para el select */
        border-radius: 6px;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.06); /* Sombra interna sutil */
        appearance: none; /* Eliminar estilo nativo del select */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23b10024'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E"); /* Icono de flecha personalizado en rojo */
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 20px;
        cursor: pointer;
    }
    select:focus {
        border-color: var(--uta-rojo);
        box-shadow: 0 0 0 0.25rem rgba(177, 0, 36, 0.2); /* Usa el valor RGB del rojo para la sombra */
        outline: none;
    }

    /* Botones de acción */
    .action-buttons {
        display: flex;
        gap: 15px; /* Mantenido el tamaño de gap original */
        margin-top: 20px;
        flex-wrap: wrap;
        align-items: flex-end; /* Alinea los elementos al final (abajo) */
    }

    .action-buttons form {
        display: flex;
        flex-direction: column; /* Apila label y select/button */
        flex-grow: 1; /* Permite que el formulario crezca */
        gap: 8px; /* Mantenido el tamaño de gap original */
    }

    button[type="submit"], .btn-primary { /* Aplicar a ambos tipos de botones */
        background-color: var(--uta-rojo); /* Botón en rojo primario */
        color: var(--uta-blanco); /* Texto del botón en blanco */
        padding: 12px 25px; /* Mantenido el tamaño de padding original */
        font-size: 16px; /* Mantenido el tamaño de fuente original */
        border: none; /* Eliminado borde, ya que el background es el color principal */
        border-radius: 8px; /* Bordes más redondeados */
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        font-weight: 600;
        min-width: 140px; /* Mantenido el tamaño de min-width original */
        text-align: center;
        margin-top: auto; /* Empuja los botones hacia abajo para alinear con el select */
    }

    button[type="submit"]:hover, .btn-primary:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo más oscuro al pasar el ratón */
        box-shadow: 0 6px 15px rgba(177, 0, 36, 0.3); /* Sombra al pasar el ratón */
    }

    /* Tablas */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px; /* Mantenido el tamaño de margin-top original */
        margin-bottom: 30px; /* Mantenido el tamaño de margin-bottom original */
        background-color: var(--uta-blanco);
        border-radius: 8px;
        overflow: hidden; /* Para que los bordes redondeados se apliquen al contenido */
        box-shadow: 0 2px 10px rgba(0,0,0,0.08); /* Sombra con negro */
    }

    th, td {
        padding: 15px; /* Mantenido el tamaño de padding original */
        border: 1px solid var(--uta-negro); /* Bordes en negro */
        text-align: left;
        color: var(--uta-negro); /* Color de texto para celdas en negro */
    }

    th {
        background-color: var(--uta-negro); /* Fondo de encabezado en negro */
        color: var(--uta-blanco); /* Texto de encabezado en blanco */
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.95rem; /* Mantenido el tamaño de fuente original */
    }

    /* Estilos para filas impares/pares */
    tbody tr:nth-child(odd) {
        background-color: var(--uta-blanco);
    }
    tbody tr:nth-child(even) {
        background-color: var(--uta-gris-claro); /* Fondo ligeramente gris para filas pares */
    }

    /* Mensaje de no data */
    p.no-data {
        color: var(--uta-rojo); /* Mensaje sin datos en rojo */
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        padding: 10px;
        background-color: var(--uta-blanco);
        border-radius: 8px;
        border: 1px solid var(--uta-negro); /* Borde en negro */
    }

    /* Total de montos (si se aplica, aunque no está en este HTML) */
    .total-monto {
        font-weight: bold;
        text-align: right;
        padding: 15px;
        background-color: var(--uta-negro);
        color: var(--uta-blanco);
        border-top: 2px solid var(--uta-rojo); /* Borde superior en rojo */
        font-size: 1.1rem; /* Mantenido el tamaño de fuente original */
    }


    /* Responsive */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column; /* Apila los botones en pantallas pequeñas */
            align-items: stretch; /* Estira los elementos para ocupar el ancho completo */
            gap: 10px; /* Mantenido el tamaño de gap original */
        }
        .action-buttons form {
            width: 100%; /* Las formas ocupan todo el ancho */
            max-width: none; /* Eliminar restricción de ancho máximo en móvil */
        }
        button[type="submit"], .btn-primary {
            width: 100%; /* Botones ocupan todo el ancho en móviles */
            margin-top: 0; /* Eliminar margin-top auto en móvil */
        }
        select {
            font-size: 14px; /* Mantenido el tamaño de fuente original */
        }
        table, thead, tbody, th, td, tr {
            display: block; /* Convertir tabla a bloques para móviles */
        }
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        tr { border: 1px solid var(--uta-negro); margin-bottom: 15px; border-radius: 8px; } /* Borde negro para filas en móviles */
        td {
            border: none;
            border-bottom: 1px solid var(--uta-negro); /* Borde inferior negro */
            position: relative;
            padding-left: 50%; /* Espacio para la etiqueta */
            text-align: right;
        }
        td:last-child {
            border-bottom: none; /* Eliminar el borde inferior de la última celda */
        }
        td:before {
            position: absolute;
            top: 0;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
            text-align: left;
            font-weight: bold;
            color: var(--uta-rojo); /* Etiqueta en rojo */
        }
        /* Etiquetas para celdas en móvil (ejemplo, necesitarías añadir data-label en tu HTML) */
        td:nth-of-type(1):before { content: "Evento:"; }
        td:nth-of-type(2):before { content: "Nombre Completo:"; }
        td:nth-of-type(3):before { content: "Correo:"; }
        td:nth-of-type(4):before { content: "Tipo:"; }
        td:nth-of-type(5):before { content: "URL Certificado:"; }
        td:nth-of-type(6):before { content: "Fecha Emisión:"; }
    }
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <h2><i class="fa fa-certificate"></i> Reporte de Certificados Emitidos</h2>

        <div class="card"> <!-- Este card ahora tendrá borde negro -->
            <div class="action-buttons">
                <!-- Formulario de selección de evento y botón "Ver Reporte" -->
                <form method="POST" style="flex-grow: 1;">
                    <div class="form-group">
                        <label for="evento">Seleccionar Evento:</label>
                        <select name="evento" id="evento" required>
                            <option value="">-- Seleccione --</option>
                            <?php foreach ($eventos as $evento): ?>
                                <option value="<?= $evento['SECUENCIAL'] ?>" <?= (isset($_POST['evento']) && $_POST['evento'] == $evento['SECUENCIAL']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($evento['TITULO']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary">Ver Reporte</button>
                </form>

                <!-- Formulario de descarga de PDF (solo si hay certificados) -->
                <?php if (!empty($certificados)): ?>
                    <form method="post" action="generar_reporte_certificados.php" target="_blank">
                        <!-- La etiqueta label con el punto oculto es para alinear el botón con el select -->
                        <label style="visibility:hidden; height: 0; margin: 0; padding: 0;">.</label>
                        <input type="hidden" name="evento" value="<?= $_POST['evento'] ?>">
                        <button type="submit" class="btn-primary">Descargar PDF</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($certificados)): ?>
            <div class="card"> <!-- Este card también tendrá borde negro por la regla general de .card -->
                <h3>Certificados Emitidos</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>Tipo</th>
                            <th>URL Certificado</th>
                            <th>Fecha Emisión</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($certificados as $cert): ?>
                            <tr>
                                <td><?= htmlspecialchars($cert['NOMBRE_EVENTO']) ?></td>
                                <td><?= htmlspecialchars($cert['NOMBRE_COMPLETO']) ?></td>
                                <td><?= htmlspecialchars($cert['CORREO']) ?></td>
                                <td><?= htmlspecialchars($cert['TIPO_CERTIFICADO']) ?></td>
                                <td><?= htmlspecialchars($cert['URL_CERTIFICADO']) ?></td>
                                <td><?= htmlspecialchars($cert['FECHA_EMISION']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])): ?>
                <p class="no-data">No hay certificados emitidos para este evento.</p>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
