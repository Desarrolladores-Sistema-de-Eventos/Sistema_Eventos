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
    /* Eliminamos body y el max-width/margin de .container si ya están en header_Admin.php */
    /* font-family, background-color, y color del body deberían venir del CSS global */
    /* margin: 40px auto; y max-width: 1000px; en body ya no son necesarios aquí */
    /* ya que el layout lo maneja #page-inner y el wrapper principal. */

    h2 {
        text-align: center;
        color: #004080; /* Usamos el color de los otros reportes para consistencia */
        margin-bottom: 30px;
    }

    /* Usamos .card para los formularios de selección y botones como en el reporte de asistencia */
    .card {
        background: #fff;
        padding: 25px;
        margin-bottom: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .form-group {
        margin-bottom: 20px; /* Separación debajo del grupo de formulario */
    }

    label {
        font-weight: bold;
        display: block; /* Para que el label ocupe su propia línea */
        margin-bottom: 8px; /* Espacio entre label y select */
    }

    select {
        width: 100%; /* Ocupa el ancho completo de su contenedor */
        padding: 10px; /* Padding interno */
        font-size: 15px; /* Tamaño de fuente consistente */
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .action-buttons {
        display: flex;
        gap: 10px; /* Espacio entre botones */
        margin-top: 20px; /* Espacio sobre los botones */
        flex-wrap: wrap; /* Permite que los botones se envuelvan en pantallas pequeñas */
        justify-content: flex-start; /* Alinea los botones a la izquierda en su contenedor */
    }

    /* Estilos para los botones consistentes con los otros reportes */
    .btn-primary { /* Nueva clase para consistencia, o puedes usar 'button' directamente */
        background-color: #004080;
        color: #fff;
        padding: 10px 20px;
        font-size: 14px;
        border: 2px solid #004080; /* Agregado para hover effect */
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 140px; /* Asegura un ancho mínimo para los botones */
        text-align: center;
    }

    .btn-primary:hover {
        background-color: #fff;
        color: #004080;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 14px;
        background-color: white;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05); /* Sombra consistente con .card */
        border-radius: 8px; /* Bordes redondeados para la tabla */
        overflow: hidden; /* Asegura que los bordes redondeados se vean bien con el contenido */
    }

    th, td {
        padding: 12px 15px; /* Padding ajustado */
        border: 1px solid #ddd; /* Borde más suave */
        text-align: left;
    }

    th {
        background-color: #e6f0ff; /* Fondo de encabezado consistente */
        color: #004080; /* Color de texto de encabezado consistente */
    }

    tr:nth-child(even) {
        background-color: #f8f8f8; /* Un poco más claro que #f2f6fa para consistencia */
    }

    /* Removido .top-buttons y adaptado su funcionalidad */
    /* La descarga del PDF ahora irá en el mismo .action-buttons si se desea */

    /* Estilos responsivos (ya estaban, pero se ajustan a la nueva estructura) */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column; /* Apila los botones en pantallas pequeñas */
        }
        select {
            font-size: 14px;
        }
    }
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <h2>Reporte de Certificados Emitidos</h2>

        <div class="card">
            <div class="action-buttons">
                <form method="POST" style="flex-grow: 1;"> <div class="form-group">
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

                <?php if (!empty($certificados)): ?>
                    <form method="post" action="generar_reporte_certificados.php" target="_blank" style="margin-top: 10px;">
                        <input type="hidden" name="evento" value="<?= $_POST['evento'] ?>">
                        <label style="visibility:hidden;">.</label> <button type="submit" class="btn-primary">Descargar PDF</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($certificados)): ?>
            <div class="card">
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
                <p style="color: red; font-weight: bold; text-align: center;">No hay certificados emitidos para este evento.</p>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</div>

<?php include("partials/footer_Admin.php"); ?>

