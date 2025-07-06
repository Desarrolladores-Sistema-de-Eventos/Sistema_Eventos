<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción al Evento - UTA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="../public/css/style.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5;
        }
        .form-card {
            border-radius: 15px;
            border: 1px solid #8B0000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .form-title {
            color: #8B0000;
            font-weight: bold;
            border-bottom: 2px solid #8B0000;
            padding-bottom: 10px;
            margin-bottom: 2rem;
        }
        .section-title {
            color: #8B0000;
            font-weight: bold;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }
        .requirements-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .btn-uta {
            background-color: #8B0000;
            border-color: #600000;
            color: white;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-uta:hover {
            background-color: #A30000;
            border-color: #800000;
            transform: scale(1.03);
        }
        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #8B0000;
            margin-bottom: 15px;
        }
        .message-box {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }
        .message-box.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .message-box.info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .message-box.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .swal2-popup {
            border-left: 6px solid #8B0000 !important;
            border-right: 6px solid #8B0000 !important;
            border-radius: 10px !important;
            font-family: 'Segoe UI', sans-serif;
        }
        .swal2-title {
            font-weight: bold;
            color: #8B0000;
        }
        .swal2-confirm {
            background-color: #000 !important;
            color: #fff !important;
            border-radius: 5px !important;
            padding: 10px 20px !important;
            font-weight: bold;
        }
    </style>
</head>
<body>
   <!-- Topbar -->
      <div class="container-fluid py-2 border-bottom" style="background-color:#fff;">
      <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center">
        <div class="d-flex align-items-center mb-2 mb-lg-0">
          <img src="../public/img/uta/logo.png" alt="Logo Facultad" style="height: 60px; margin-right: 10px;">
          <div>
            <h6 class="mb-0 text-uppercase font-weight-bold" style="color: rgb(134, 17, 17);">UNIVERSIDAD</h6>
            <h5 class="mb-0 font-weight-bold" style="color: rgb(134, 17, 17);">TÉCNICA DE AMBATO</h5>
      <span class="badge" style="background-color:rgb(49, 49, 49); color: white;">CAMPUS-HUACHI</span>
          </div>
        </div>
<div class="d-flex align-items-center">
            <div class="text-center d-flex flex-column flex-md-row align-items-center mx-3">
                <i class="fas fa-user-circle text-danger fa-2x mb-2 mb-md-0 mr-md-2"></i>
                <div class="d-flex flex-column flex-md-row gap-2">
                    <a href="../views/dashboard_Pri_Usu.php" class="btn btn-outline-dark btn-sm mx-1">Dashboard</a>
                    <a href="../controllers/logout.php" class="btn btn-outline-danger btn-sm mx-1">Cerrar Sesión</a>
                </div>
            </div>
        </div>
  </div>
</div>
 </div>

<div class="container my-5">
    <div class="card shadow-lg form-card">
        <div class="card-body p-4 p-md-5">
            <h2 class="card-title text-center mb-4 pb-2 form-title">
                <i class="fas fa-edit me-2"></i> Formulario de Inscripción
            </h2>

            <div id="mensajeValidacion" class="message-box" style="display: none;"></div>
            <div id="yaInscritoInfo" class="message-box info" style="display: none;"></div>

            <form id="formInscripcion">
                <input type="hidden" id="idEvento" name="idEvento">

                <div class="text-center mb-4">
                    <img src="" alt="Foto de perfil" id="fotoPerfil" class="profile-img d-none">
                </div>

                <h4 class="section-title"><i class="fas fa-user me-2"></i> Información del Participante</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="nombreUsuario" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control form-control-lg" id="nombreUsuario" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="cedulaUsuario" class="form-label">Cédula</label>
                        <input type="text" class="form-control form-control-lg" id="cedulaUsuario" disabled>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="correoUsuario" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control form-control-lg" id="correoUsuario" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="telefonoUsuario" class="form-label">Teléfono</label>
                        <input type="text" class="form-control form-control-lg" id="telefonoUsuario" disabled>
                    </div>
                </div>

                <h4 class="section-title"><i class="fas fa-info-circle me-2"></i> Información del Evento</h4>
                <div class="mb-3">
                    <label for="tituloEvento" class="form-label">Título del Evento</label>
                    <input type="text" class="form-control form-control-lg" id="tituloEvento" disabled>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Duración (Horas)</label>
                        <input type="text" class="form-control form-control-lg" id="horasEvento" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Modalidad</label>
                        <input type="text" class="form-control form-control-lg" id="modalidadEvento" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Estado del Evento</label>
                        <input type="text" class="form-control form-control-lg" id="estadoEvento" disabled>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Inicio</label>
                        <input type="text" class="form-control form-control-lg" id="fechaInicioEvento" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Fin</label>
                        <input type="text" class="form-control form-control-lg" id="fechaFinEvento" disabled>
                    </div>
                </div>

                <h4 class="section-title"><i class="fas fa-clipboard-list me-2"></i> Requisitos del Evento</h4>
                <div class="requirements-box p-3 mb-4">
                    <ul id="requisitosList" class="list-group mb-0">
                        <li>Cargando requisitos...</li>
                    </ul>
                </div>
                
<!-- NUEVA SECCIÓN DE PAGO AÑADIDA AQUÍ -->
<h4 class="section-title"><i class="fas fa-university me-2"></i> Información de Pago</h4>
<div class="requirements-box p-4 mb-4">
    <p class="mb-3"><strong>Por favor realice el depósito a la siguiente cuenta:</strong></p>
    <ul class="list-unstyled">
        <li><i class="fas fa-building me-2 text-danger"></i><strong>Banco:</strong> Banco del Austro</li>
        <li><i class="fas fa-hashtag me-2 text-danger"></i><strong>Número de Cuenta:</strong> 012345678900</li>
        <li><i class="fas fa-user-tie me-2 text-danger"></i><strong>Nombre del Titular:</strong> Universidad Técnica de Ambato</li>
        <li><i class="fas fa-money-check-alt me-2 text-danger"></i><strong>Tipo de Cuenta:</strong> Corriente</li>
        <li><i class="fas fa-id-card me-2 text-danger"></i><strong>RUC:</strong> 0690001234001</li>
    </ul>
    <div class="alert alert-info mt-3" role="alert">
         Una vez realizado el depósito, deberá subir el comprobante de pago en la sección de inscripciones desde su panel de usuario
    </div>
</div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3">
                    <button type="submit" class="btn btn-uta btn-lg" id="btnInscribirse">
                        <i class="fas fa-check-circle me-2"></i> Confirmar Inscripción
                    </button>
                    <a href="../index.php" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../public/js/inscribirse.js"></script>
<?php include('partials/footer.php'); ?>

</body>
</html>