
<?php

session_start();
$_SESSION['rol'] = 'admin';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<h3 class='text-center text-danger mt-5'>Acceso denegado.</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-light">

<main class="container py-5">
    <div class="text-center mb-5">
        <h2><i class="fa fa-chart-bar text-primary"></i> Panel de Reportes</h2>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <!-- Tarjeta 1 -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-certificate text-success"></i> Certificados Emitidos</h5>
                    <p class="card-text">Consulta y descarga los certificados emitidos por evento.</p>
                    <a href="informeCertificadosView.php" class="btn btn-outline-primary">Ver Reporte</a>
                </div>
            </div>
        </div>
        <!-- Tarjeta 2 -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-user-check text-info"></i> Inscripciones por Evento</h5>
                    <p class="card-text">Revisa cuántos estudiantes se han inscrito por evento.</p>
                    <a href="informeInscripcionesView.php" class="btn btn-outline-primary">Ver Reporte</a>
                </div>
            </div>
        </div>
        <!-- Tarjeta 3 -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-money-bill-wave text-warning"></i> Reporte Financiero</h5>
                    <p class="card-text">Pagos realizados, pendientes y comprobantes por evento.</p>
                    <a href="informeFinancieroView.php" class="btn btn-outline-primary">Ver Reporte</a>
                </div>
            </div>
        </div>
        <!-- Tarjeta 4 -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-users text-secondary"></i> Evento y Asistentes</h5>
                    <p class="card-text">Listado de asistentes con detalles por evento.</p>
                    <a href="informeAsistentesView.php" class="btn btn-outline-primary">Ver Reporte</a>
                </div>
            </div>
        </div>
        <!-- Tarjeta 5 -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-tags text-danger"></i> Eventos por Categoría</h5>
                    <p class="card-text">Listado y estado de eventos por categoría.</p>
                    <a href="informeEventosCategoriaView.php" class="btn btn-outline-primary">Ver Reporte</a>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
