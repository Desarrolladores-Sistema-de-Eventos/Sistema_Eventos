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
    /* Definición de colores principales: ÚNICAMENTE ROJO, BLANCO Y NEGRO */
    :root {
        --uta-rojo: #b10024; /* Rojo principal de UTA */
        --uta-rojo-oscuro: #92001c; /* Tono más oscuro de rojo */
        --uta-negro: #000000;
        --uta-blanco: #ffffff;
    }

    /* Títulos */
    h2, h3 {
        color: var(--uta-rojo); /* Títulos en rojo principal */
        font-weight: bold;
        margin-bottom: 15px;
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: var(--uta-negro); /* Título principal en negro */
    }

    h2 i {
        color: var(--uta-rojo); /* Icono del título en rojo */
        margin-right: 10px;
    }

    /* Contenedores de tarjetas/paneles */
    .card {
        background: var(--uta-blanco);
        padding: 25px;
        margin-bottom: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* Sombra con negro */
        border: 1px solid var(--uta-negro); /* Borde en negro */
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
        color: var(--uta-negro); /* Color de etiqueta en negro */
    }

    select {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid var(--uta-negro); /* Borde en negro */
        border-radius: 6px;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.06); /* Sombra interna con negro */
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23b10024'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E"); /* Icono de flecha en rojo */
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 20px;
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 20px;
    }

    /* Botones de acción */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
        flex-wrap: wrap;
        align-items: flex-end; /* Alinea los elementos al final (parte inferior) */
    }

    .action-buttons form {
        margin: 0;
        flex-grow: 1;
        display: flex; /* Añadido para apilar label y select/button */
        flex-direction: column;
        gap: 8px;
    }

    .btn-primary {
        background-color: var(--uta-rojo); /* Fondo rojo */
        color: var(--uta-blanco);
        padding: 12px 25px;
        font-size: 16px;
        border: none; /* Sin borde, el fondo es el color principal */
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        font-weight: 600;
        min-width: 140px;
        text-align: center;
    }

    .btn-primary:hover {
        background-color: var(--uta-rojo-oscuro); /* Rojo oscuro al pasar el ratón */
        box-shadow: 0 6px 15px rgba(var(--uta-rojo), 0.3); /* Sombra con rojo */
    }

    /* Tablas */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        margin-bottom: 30px;
        background-color: var(--uta-blanco);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08); /* Sombra con negro */
    }

    th, td {
        padding: 15px;
        border: 1px solid var(--uta-negro); /* Bordes en negro */
        text-align: left;
        color: var(--uta-negro); /* Color de texto en negro */
    }

    th {
        background-color: var(--uta-negro); /* Fondo de encabezado en negro */
        color: var(--uta-blanco); /* Texto de encabezado en blanco */
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.95rem;
    }

    /* Estilos para filas impares/pares */
    tbody tr:nth-child(odd) {
        background-color: var(--uta-blanco);
    }
    tbody tr:nth-child(even) {
        background-color: var(--uta-blanco); /* Todas las filas en blanco para evitar grises */
    }

    p.no-data {
        color: var(--uta-rojo); /* Mensaje sin datos en rojo */
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        padding: 10px;
        background-color: var(--uta-blanco);
        border-radius: 8px;
        border: 1px solid var(--uta-negro);
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        .action-buttons form {
            width: 100%;
        }
        .btn-primary {
            width: 100%;
        }
        select {
            font-size: 14px;
        }
        table, thead, tbody, th, td, tr {
            display: block;
        }
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        tr { border: 1px solid var(--uta-negro); margin-bottom: 15px; border-radius: 8px; }
        td {
            border: none;
            border-bottom: 1px solid var(--uta-negro);
            position: relative;
            padding-left: 50%;
            text-align: right;
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
        /* Etiquetas para celdas en móvil */
        td:nth-of-type(1):before { content: "Evento:"; }
        td:nth-of-type(2):before { content: "Carrera:"; }
        td:nth-of-type(3):before { content: "Inicio:"; }
        td:nth-of-type(4):before { content: "Fin:"; }
        td:nth-of-type(5):before { content: "Estado:"; }
        td:nth-of-type(6):before { content: "Pagado:"; }
        td:nth-of-type(7):before { content: "Inscritos:"; }
        td:nth-of-type(8):before { content: "Capacidad:"; }
        td:nth-of-type(9):before { content: "Organizador(es):"; }
    }
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <h2><i class="fa fa-tags"></i> Reporte de Eventos por Categoría</h2>

        <div class="card">
            <div class="action-buttons">
                <form method="POST" style="flex-grow: 1;">
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
                    <button type="submit" class="btn-primary">Ver Reporte</button>
                </form>

                <?php if (!empty($eventos) && isset($_POST['categoria'])): ?>
                    <form method="POST" action="generar_reporte_eventos_categoria.php" target="_blank">
                        <label style="visibility:hidden; height: 0; margin: 0; padding: 0;">.</label>
                        <input type="hidden" name="categoria" value="<?= htmlspecialchars($_POST['categoria']) ?>">
                        <button type="submit" class="btn-primary">Descargar PDF</button>
                    </form>
                <?php endif; ?>
            </div>
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
                <p class="no-data">No hay eventos para la categoría seleccionada.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
