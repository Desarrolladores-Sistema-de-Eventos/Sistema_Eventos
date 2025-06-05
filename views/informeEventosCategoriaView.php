<?php
session_start();
$_SESSION['rol'] = 'admin';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<h3>Acceso denegado.</h3>";
    exit;
}

require_once '../controllers/EventoCategoriaController.php';

$controller = new EventoCategoriaController();
$categorias = $controller->listarCategorias();
$eventos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
    $eventos = $controller->listarEventos(intval($_POST['categoria']));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Eventos por Categoría</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            color: #333;
            padding: 40px;
        }

        h2 {
            color: #004080;
            margin-bottom: 20px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

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
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
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
            overflow: hidden;
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

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }

            select {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Reporte de Eventos por Categoría</h2>

    <div class="card">
        <form method="POST">
            <label for="categoria">Seleccionar Categoría:</label>
            <select name="categoria" id="categoria" required>
                <option value="">-- Seleccione --</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['SECUENCIAL'] ?>" <?= (isset($_POST['categoria']) && $_POST['categoria'] == $cat['SECUENCIAL']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['NOMBRE']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="action-buttons">
                <button type="submit" class="btn-primary">Ver Reporte</button>
            </div>
        </form>

        <?php if (!empty($eventos)): ?>
            <!-- Formulario separado para Descargar PDF -->
            <div class="action-buttons" style="margin-top: 10px;">
                <form method="POST" action="generar_reporte_eventos_categoria.php" target="_blank">
                    <input type="hidden" name="categoria" value="<?= $_POST['categoria'] ?>">
                    <button type="submit" class="btn-primary">Descargar PDF</button>
                </form>
            </div>
        <?php endif; ?>
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
    <?php endif; ?>
</div>
</body>
</html>
