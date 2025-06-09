<?php
// Asegúrate de que esta página maneje la sesión y la autenticación si es necesario
session_start();
// Si necesitas incluir algún archivo de configuración o seguridad aquí, hazlo.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción al Evento - UTA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
    </style>
</head>
<body>
<div class="container my-5">
    <div class="card shadow-lg form-card">
        <div class="card-body p-4 p-md-5">
            <h2 class="card-title text-center mb-4 pb-2 form-title">
                <i class="fas fa-edit me-2"></i> Formulario de Inscripción
            </h2>

            <div id="mensajeValidacion" class="message-box" style="display: none;">
                </div>
            <div id="yaInscritoInfo" class="message-box info" style="display: none;">
                </div>

            <form id="formInscripcion" enctype="multipart/form-data">
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

                <div id="cuposInfo" class="message-box info mb-4" style="display: none;">
                    </div>


                <h4 class="section-title"><i class="fas fa-clipboard-list me-2"></i> Requisitos del Evento</h4>
                <div class="requirements-box p-3 mb-4">
                    <ul id="requisitosList" class="list-unstyled mb-0">
                        <li>Cargando requisitos...</li>
                    </ul>
                </div>

                <h4 class="section-title"><i class="fas fa-money-check-alt me-2"></i> Comprobante de Pago</h4>
                <div class="mb-4">
                    <label for="tipoPago" class="form-label">Tipo de Pago</label>
                    <select id="tipoPago" name="forma_pago" class="form-control" required>
  <option value="EFEC">Efectivo</option>
  <option value="PYP">PayPal</option>
  <option value="TARJ">Tarjeta de Crédito</option>
  <option value="TRANS">Transferencia</option>
</select>

                </div>
                <div class="mb-4">
                    <label for="archivoPago" class="form-label">Subir Comprobante</label>
                    <input type="file" class="form-control form-control-lg" name="archivoPago" id="archivoPago" accept=".pdf,.jpg,.jpeg,.png">
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../public/js/inscribirse.js"></script>
</body>
</html>