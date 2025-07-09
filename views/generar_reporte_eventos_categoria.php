<?php
require_once '../controllers/InscripcionController.php';

$controller = new InscripcionController();
$eventos = $controller->listarEventos();
$reporte = ['total' => 0, 'datos' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])) {
    $idEvento = intval($_POST['evento']);
    $reporte = $controller->obtenerReporte($idEvento);
}
?>

<?php include("partials/header_Admin.php"); ?>

<style>
    /* Definición de colores principales para asegurar consistencia */
    :root {
        --uta-rojo: #b10024; /* Rojo principal de UTA */
        --uta-rojo-oscuro: #92001c; /* Tono más oscuro de rojo */
        --uta-negro: #000000;
        --uta-blanco: #ffffff;
        --uta-gris-claro: #f5f5f5; /* Para fondos sutiles */
        --uta-gris-medio: #e0e0e0; /* Para bordes */
        --uta-gris-oscuro: #333; /* Para texto principal */
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
        color: var(--uta-rojo); /* Cambiado de azul a rojo */
        font-weight: bold; /* Asegurar negrita */
        margin-bottom: 15px; /* Espaciado uniforme */
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: var(--uta-negro); /* Título principal en negro */
    }

    h2 i {
        color: var(--uta-rojo); /* Icono en rojo */
        margin-right: 10px;
    }

    /* Contenedores de tarjetas/paneles */
    .card {
        background: var(--uta-blanco);
        padding: 25px;
        margin-bottom: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* Sombra mejorada */
        border: 1px solid var(--uta-negro); /* CAMBIADO: Borde en negro */
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
        border: 1px solid var(--uta-negro); /* CAMBIADO: Borde en negro */
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

    .btn-primary { /* Aplicar a ambos tipos de botones */
        background-color: var(--uta-rojo); /* Cambiado de azul a rojo */
        color: var(--uta-blanco);
        padding: 12px 25px; /* Mantenido el tamaño de padding original */
        font-size: 16px; /* Mantenido el tamaño de fuente original */
        border: none; /* Eliminado borde, ya que el background es el color principal */
        border-radius: 8px; /* Bordes más redondeados */
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        font-weight: 600; /* Negrita para el texto del botón */
        min-width: 140px; /* Asegura un ancho mínimo para los botones */
        text-align: center;
    }

    .btn-primary:hover {
        background-color: var(--uta-rojo-oscuro); /* Cambiado de azul oscuro a rojo oscuro */
        box-shadow: 0 6px 15px rgba(var(--uta-rojo), 0.3); /* Sombra al pasar el ratón */
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
        border: 1px solid var(--uta-negro); /* CAMBIADO: Bordes en negro */
        text-align: left;
        color: var(--uta-negro); /* Color de texto en negro */
    }

    th {
        background-color: var(--uta-negro); /* CAMBIADO: Fondo de encabezado en negro */
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
        background-color: var(--uta-gris-claro); /* Mantenido el color original para filas pares */
    }

    /* Conteo total */
    .total-count {
        font-weight: bold;
        margin: 20px 0;
        font-size: 1.2rem; /* Mantenido el tamaño de fuente original */
        text-align: center;
        color: var(--uta-blanco); /* CAMBIADO: Texto blanco */
        padding: 10px;
        background-color: var(--uta-negro); /* CAMBIADO: Fondo negro */
        border-radius: 8px;
        border: 1px solid var(--uta-negro); /* CAMBIADO: Borde en negro */
    }

    /* Mensaje sin datos */
    .no-data-message {
        color: var(--uta-rojo); /* Color en rojo */
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        padding: 10px;
        background-color: var(--uta-blanco); /* CAMBIADO: Fondo blanco */
        border-radius: 8px;
        border: 1px solid var(--uta-negro); /* CAMBIADO: Borde en negro */
    }

    /* Responsividad */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column; /* Apila los botones en pantallas pequeñas */
            align-items: stretch; /* Estira los elementos para ocupar el ancho completo */
            gap: 10px; /* Mantenido el tamaño de gap original */
        }
        .action-buttons form {
            width: 100%; /* Las formas ocupan todo el ancho */
        }
        .btn-primary {
            width: 100%; /* Botones ocupan todo el ancho en móviles */
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
        tr { border: 1px solid var(--uta-negro); margin-bottom: 15px; border-radius: 8px; } /* CAMBIADO: Borde negro para filas en móviles */
        td {
            border: none;
            border-bottom: 1px solid var(--uta-negro); /* CAMBIADO: Borde inferior negro */
            position: relative;
            padding-left: 50%; /* Espacio para la etiqueta */
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
        /* Etiquetas para celdas en móvil (ejemplo, necesitarías añadir data-label en tu HTML) */
        td:nth-of-type(1):before { content: "Nombre Completo:"; }
        td:nth-of-type(2):before { content: "Correo:"; }
        td:nth-of-type(3):before { content: "Carrera:"; }
        td:nth-of-type(4):before { content: "Facultad:"; }
    }
</style>

<div id="page-wrapper">
    <div id="page-inner">
        <h2><i class="fa fa-users"></i> Reporte de Inscripciones</h2> <!-- Icono de usuarios para inscripciones -->

        <div class="card">
            <div class="action-buttons">
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

                <?php if (!empty($reporte['datos'])): ?>
                    <form method="post" action="generar_reporte_inscripciones.php" target="_blank">
                        <!-- La etiqueta label con el punto oculto es para alinear el botón con el select -->
                        <label style="visibility:hidden; height: 0; margin: 0; padding: 0;">.</label>
                        <input type="hidden" name="evento" value="<?= htmlspecialchars($_POST['evento']) ?>">
                        <button type="submit" class="btn-primary">Descargar PDF</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])): ?>
            <?php if (!empty($reporte['datos'])): ?>
                <div class="card">
                    <p class="total-count">Total inscritos: <?= $reporte['total'] ?></p>

                    <table>
                        <thead>
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Correo</th>
                                <th>Carrera</th>
                                <th>Facultad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reporte['datos'] as $ins): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ins['NOMBRE COMPLETO']) ?></td>
                                    <td><?= htmlspecialchars($ins['CORREO']) ?></td>
                                    <td><?= htmlspecialchars($ins['CARRERA']) ?></td>
                                    <td><?= htmlspecialchars($ins['FACULTAD']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="no-data-message">No hay inscripciones para este evento.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
