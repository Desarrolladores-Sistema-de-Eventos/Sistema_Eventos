<?php
require_once '../controllers/EventoCategoriaController.php';

$controller = new EventoCategoriaController();
$categorias = $controller->listarCategorias();
$eventos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['categoria'])) {
    $idCategoria = intval($_POST['categoria']);
    $eventos = $controller->listarEventos($idCategoria);
}
?>

<?php include("partials/header_Admin.php"); ?>

<style>
    /* Eliminamos el body y el .container con max-width/margin de aquí,
       asumiendo que #page-inner o tu CSS global ya los maneja */
    /* font-family, background-color, y color del body deberían venir del CSS global */
    /* padding: 40px; en body ya no es necesario aquí */

    h2 {
        color: #004080; /* Color consistente con otros reportes */
        margin-bottom: 20px;
    }

    /* .container no es necesario aquí ya que #page-inner es el contenedor principal */
    /* Si necesitas un max-width específico para el contenido interno de #page-inner,
       podrías definirlo directamente en #page-inner si no lo tienes globalmente. */

    .card {
        background: #fff;
        padding: 25px;
        margin-bottom: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
    }

    select {
        width: 100%;
        padding: 10px;
        font-size: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        /* margin-bottom: 20px; si el select está solo antes de los botones, dejarlo aquí */
        /* Si está dentro de form-group y luego action-buttons, lo gestiona el form-group */
    }

    .form-group { /* Añadido para mejor agrupación */
        margin-bottom: 20px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px; /* Separación desde el select o el card anterior */
        flex-wrap: wrap;
        justify-content: flex-start; /* Alinea los botones a la izquierda */
    }

    .btn-primary {
        background-color: #004080;
        color: #fff;
        padding: 10px 20px;
        font-size: 14px;
        border: 2px solid #004080;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 140px;
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
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden; /* Para que los bordes redondeados se vean bien */
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    th, td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #e6f0ff;
        color: #004080;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f8f8f8; /* Color de fila par, consistente */
    }

    /* Estilos responsivos */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        select {
            font-size: 14px;
        }
    }
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <h2>Reporte de Eventos por Categoría</h2>

        <div class="card">
            <form method="POST">
                <div class="form-group">
                    <label for="categoria">Seleccionar Categoría:</label>
                    <select name="categoria" id="categoria" required>
                        <option value="">-- Seleccione --</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['SECUENCIAL'] ?>" <?= (isset($_POST['categoria']) && $_POST['categoria'] == $cat['SECUENCIAL']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['NOMBRE']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="action-buttons">
                    <button type="submit" class="btn-primary">Ver Reporte</button>

                    <?php if (!empty($eventos) && isset($_POST['categoria'])): ?>
                        <form method="POST" action="generar_reporte_eventos_categoria.php" target="_blank" style="margin-top: 0; margin-left: 10px;">
                            <input type="hidden" name="categoria" value="<?= htmlspecialchars($_POST['categoria']) ?>">
                            <label style="visibility:hidden;">.</label> <button type="submit" class="btn-primary">Descargar PDF</button>
                        </form>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <?php if (!empty($eventos)): ?>
            <div class="card">
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
                            <th>Organizador(es)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($eventos as $e): ?>
                            <tr>
                                <td><?= htmlspecialchars($e['EVENTO']) ?></td>
                                <td><?= htmlspecialchars($e['CARRERA'] ?? 'Todas') ?></td>
                                <td><?= is_a($e['FECHAINICIO'], 'DateTime') ? $e['FECHAINICIO']->format('Y-m-d') : '-' ?></td>
                                <td><?= is_a($e['FECHAFIN'], 'DateTime') ? $e['FECHAFIN']->format('Y-m-d') : '-' ?></td>
                                <td><?= htmlspecialchars($e['ESTADO']) ?></td>
                                <td><?= htmlspecialchars($e['PAGADO']) ?></td>
                                <td><?= htmlspecialchars($e['INSCRITOS']) ?></td>
                                <td><?= htmlspecialchars($e['CAPACIDAD']) ?></td>
                                <td><?= htmlspecialchars($e['ORGANIZADORES']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['categoria'])): ?>
                <p style="color: red; font-weight: bold; text-align: center;">No hay eventos para la categoría seleccionada.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include("partials/footer_Admin.php"); ?>