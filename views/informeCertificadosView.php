<?php
session_start();
$_SESSION['rol'] = 'admin'; // para pruebas

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<h3>Acceso denegado. Solo administradores.</h3>";
    exit;
}

require_once '../controllers/CertificadoController.php';

$controller = new CertificadoController();
$eventos = $controller->listarEventos();
$certificados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento'])) {
    $idEvento = intval($_POST['evento']);
    $certificados = $controller->obtenerReporte($idEvento);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Certificados Emitidos</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 40px auto;
            max-width: 1000px;
            background-color: #f9f9f9;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 30px;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        select {
            padding: 6px 10px;
            font-size: 14px;
            width: 300px;
        }

        button {
            background-color: #003366;
            color: white;
            padding: 7px 15px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            margin-left: 10px;
            border-radius: 4px;
        }

        button:hover {
            background-color: #002244;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            font-size: 14px;
            background-color: white;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        th {
            background-color: #003366;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f6fa;
        }

        .top-buttons {
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h2>Reporte de Certificados Emitidos</h2>

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
    <button type="submit">Ver Reporte</button>
</form>

<?php if (!empty($certificados)): ?>
    <form method="post" action="generar_reporte_certificados.php" target="_blank" class="top-buttons">
        <input type="hidden" name="evento" value="<?= $_POST['evento'] ?>">
        <button type="submit">Descargar PDF</button>
    </form>

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
                    <td><?= htmlspecialchars($cert['NOMBREUNIDO']) ?></td>
                    <td><?= htmlspecialchars($cert['CORREO']) ?></td>
                    <td><?= htmlspecialchars($cert['TIPO_CERTIFICADO']) ?></td>
                    <td><?= htmlspecialchars($cert['URL_CERTIFICADO']) ?></td>
                    <td><?= htmlspecialchars($cert['FECHA_EMISION']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
