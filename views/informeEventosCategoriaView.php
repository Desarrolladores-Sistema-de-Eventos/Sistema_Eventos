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
        --uta-negro: #1a1a1a; /* CAMBIADO: Negro secundario, como en el reporte de certificados */
        --uta-blanco: #ffffff; /* Blanco de complemento */
        --line-color: #666666; /* AGREGADO: Color gris para las líneas menos visibles */
        --uta-gris-claro: #f5f5f5; /* Mantenido para compatibilidad si se usa en otro lado */
        --uta-gris-medio: #e0e0e0; /* Mantenido para compatibilidad si se usa en otro lado */
        --uta-gris-oscuro: #333; /* Mantenido para compatibilidad si se usa en otro lado */
    }

    body {
        font-family: 'Poppins', sans-serif; /* Usar Poppins si está enlazado en header_Admin */
        background-color: var(--uta-blanco); /* Fondo general de la página en blanco */
        color: var(--uta-negro); /* CAMBIADO: Texto general en negro */
    }

    /* Contenedor principal para centrar el contenido */
    #page-inner {
        padding: 25px; /* Espaciado interno */
        max-width: 1200px; /* Ancho máximo para el contenido principal */
        margin: 0 auto; /* Centrar el contenido en la página */
    }

    /* Títulos */
    h2, h3, h4 {
        color: var(--uta-rojo); /* Títulos en rojo principal */
        font-weight: bold;
        margin-bottom: 15px;
        text-align: left; /* Alineación por defecto para subtítulos */
    }

    h2 {
        text-align: center; /* Título principal centrado */
        margin-bottom: 25px; /* Más espacio debajo del título principal */
        font-size: 18px; /* CAMBIADO: Tamaño de fuente como en el PDF */
        color: var(--uta-negro); /* Título principal en negro */
    }

    h2 i {
        color: var(--uta-rojo); /* Icono del título en rojo */
        margin-right: 10px; /* Espaciado adecuado para el icono */
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
    select:focus {
        border-color: var(--uta-rojo);
        box-shadow: 0 0 0 0.25rem rgba(177, 0, 36, 0.2); /* Usa el valor RGB del rojo para la sombra */
        outline: none;
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
        margin-top: 25px; /* Mantenido el tamaño de margin-top original */
        margin-bottom: 30px; /* Mantenido el tamaño de margin-bottom original */
        background-color: var(--uta-blanco);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08); /* Sombra con negro */
    }

    th, td {
        padding: 15px;
        border: 1px solid var(--line-color); /* CAMBIADO: Bordes en gris como en el PDF */
        text-align: left;
        color: var(--uta-negro); /* Color de texto en negro */
    }

    th {
        background-color: var(--uta-rojo); /* CAMBIADO: Fondo de encabezado en rojo como en el PDF */
        color: var(--uta-blanco); /* Texto de encabezado en blanco */
        font-weight: 700;
        text-transform: uppercase;
        font-size: 10px; /* CAMBIADO: Tamaño de fuente como en el PDF */
        padding: 8px 10px; /* CAMBIADO: Padding como en el PDF */
    }

    /* Estilos para filas impares/pares */
    tbody tr:nth-child(odd) {
        background-color: var(--uta-blanco); /* CAMBIADO: Todas las filas en blanco */
    }
    tbody tr:nth-child(even) {
        background-color: var(--uta-blanco); /* CAMBIADO: Todas las filas en blanco */
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
