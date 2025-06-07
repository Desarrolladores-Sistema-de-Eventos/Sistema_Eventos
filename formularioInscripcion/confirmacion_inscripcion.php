<?php
$nombre = htmlspecialchars($_GET['nombre'] ?? '');
$correo = htmlspecialchars($_GET['correo'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Inscripción - UTA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .confirmation-card {
            border-radius: 15px;
            border: 2px solid #8B0000;
        }
        .confirmation-icon {
            font-size: 5rem;
            color: #28a745;
        }
        .btn-uta {
            background-color: #8B0000;
            border-color: #600000;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-lg confirmation-card">
            <div class="card-body p-5 text-center">
                <i class="fas fa-check-circle confirmation-icon mb-4"></i>
                <h1 class="card-title text-success">¡Inscripción Exitosa!</h1>
                <p class="lead">Gracias <strong><?= $nombre ?></strong>, tu inscripción ha sido recibida.</p>
                
                <div class="alert alert-info text-start mt-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Próximos pasos:</h5>
                    <ul>
                        <li>Hemos enviado un correo de confirmación a <strong><?= $correo ?></strong></li>
                        <li>El equipo verificará tu comprobante en un plazo de 24-48 horas</li>
                        <li>Recibirás las credenciales de acceso al curso vía email</li>
                    </ul>
                </div>
                
                <div class="mt-5">
                    <a href="formulario_inscripcion.php" class="btn btn-outline-secondary btn-lg me-2">
                        <i class="fas fa-arrow-left me-2"></i>Volver al inicio
                    </a>
                    <a href="https://www.uta.edu.ec" class="btn btn-uta btn-lg">
                        <i class="fas fa-university me-2"></i>Web UTA
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>