<?php
session_start();
$_SESSION['rol'] = 'admin'; // solo para pruebas

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<h3>Acceso denegado.</h3>";
    exit;
}

require_once '../controllers/InscripcionController.php';

$controller = new InscripcionController();
$eventos = $controller->listarEventos();
$reporte = ['total' => 0, 'datos' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])) {
    $idEvento = intval($_POST['evento']);
    $reporte = $controller->obtenerReporte($idEvento);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inscripciones</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            color: #333;
            padding: 40px;
        }

        h2 {
            color: #004080;
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
            margin-bottom: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: flex-end;
            margin-top: 10px;
        }

        .action-buttons form {
            margin: 0;
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
            border-radius: 8px;
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
        }

        .total-count {
            font-weight: bold;
            margin: 20px 0 0;
            font-size: 16px;
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
    <h2>Reporte de Inscripciones</h2>

    <div class="card">
        <div class="action-buttons">
            <!-- Formulario Ver Reporte -->
            <form method="POST">
                <label for="evento">Seleccionar Evento:</label>
                <select name="evento" id="evento" required>
                    <option value="">-- Seleccione --</option>
                    <?php foreach ($eventos as $evento): ?>
                        <option value="<?= $evento['SECUENCIAL'] ?>" <?= (isset($_POST['evento']) && $_POST['evento'] == $evento['SECUENCIAL']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($evento['TITULO']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn-primary">Ver Reporte</button>
            </form>

            <!-- Formulario Descargar PDF -->
            <?php if (!empty($reporte['datos'])): ?>
                <form method="post" action="generar_reporte_inscripciones.php" target="_blank">
                    <input type="hidden" name="evento" value="<?= $_POST['evento'] ?>">
                    <label style="visibility:hidden;">Descargar</label>
                    <button type="submit" class="btn-primary">Descargar PDF</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

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
    <?php endif; ?>
</div>
</body>
</html>
