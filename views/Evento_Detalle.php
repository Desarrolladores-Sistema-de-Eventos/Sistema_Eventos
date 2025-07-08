<?php
  if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Descripcion del Evento</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="../public/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../public/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../public/css/style.css" rel="stylesheet">
    <!-- AOS Animate On Scroll CSS -->
    <style>
    #galeriaEvento {
      max-height: 300px;
      object-fit: cover;
    }
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
    <?php
    if (!isset($_SESSION['usuario'])) {
        include 'partials/header.php';
    }

    ?>
    <?php if (isset($_SESSION['usuario'])): ?>
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
    <?php endif; ?>
    <!-- Blog Start -->
     <div class="container-fluid pt-4 pb-4" style="background-color: #fcfbe7;">
        <div class="container pt-3 pb-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="bg-white p-4 rounded shadow-sm" data-aos="fade-up">
        <h2 class="mb-3 text-dark font-weight-bold" id="tituloEvento" data-aos="fade-up" data-aos-delay="100"></h2>
        <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
            <img class="img-fluid rounded w-100" id="galeriaEvento" alt="Imagen del evento" data-aos="zoom-in" data-aos-delay="250">
        </div>
        <p id="descripcionEvento" class="mb-4 text-muted" data-aos="fade-up" data-aos-delay="300"></p>
        <div class="row mb-3" data-aos="fade-up" data-aos-delay="350">
            <div class="col-md-6" data-aos="fade-right" data-aos-delay="400">
                <h6><i class="fas fa-calendar-alt text-danger"></i> Fecha de Inicio:</h6>
                <p id="fechaInicio"></p>
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-delay="450">
                <h6><i class="fas fa-calendar-check text-danger"></i> Fecha de Finalización:</h6>
                <p id="fechaFin"></p>
            </div>
        </div>
        <div class="row mb-3" data-aos="fade-up" data-aos-delay="500">
            <div class="col-md-6" data-aos="fade-right" data-aos-delay="550">
                <h6><i class="fas fa-clock text-danger"></i> Horas:</h6>
                <p id="horasEvento"></p>
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-delay="600">
                <h6><i class="fas fa-graduation-cap text-danger"></i> Carrera:</h6>
                <ul id="carrera"></ul>
            </div>
        </div>
        <div class="row mb-3" data-aos="fade-up" data-aos-delay="650">
            <div class="col-md-6" data-aos="fade-right" data-aos-delay="700">
                <h6><i class="fas fa-laptop text-danger"></i> Modalidad:</h6>
                <p id="modalidad"></p>
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-delay="750">
                <h6><i class="fas fa-dollar-sign text-danger"></i> Costo:</h6>
                <p id="costoEvento"></p>
            </div>
        </div>
        <h6 data-aos="fade-up" data-aos-delay="800"><i class="fas fa-check-circle text-danger"></i> Nota de Aprobación:</h6>
        <p id="notaAprobacion" data-aos="fade-up" data-aos-delay="850"></p>
        <h6 data-aos="fade-up" data-aos-delay="900"><i class="fas fa-users text-danger"></i> Tipo de Público:</h6>
        <p id="publicoObjetivo" data-aos="fade-up" data-aos-delay="950"></p>
        <div class="text-center mt-4" data-aos="zoom-in" data-aos-delay="1000">
            <button id="btnInscribirse" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#modalInscribirse">Inscribirse</button>
        </div>
    <!-- Modal para Formulario de Inscripción (contenido embebido) -->
    <div class="modal fade" id="modalInscribirse" tabindex="-1" aria-labelledby="modalInscribirseLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalInscribirseLabel">Inscripción</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="background: none; border: none; font-size: 2rem; line-height: 1; color: #8B0000; opacity: 1; position: absolute; right: 1.5rem; top: 1.2rem; z-index: 1051;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="modalInscribirseBody">
            <div class="container my-2">
              <div class="card shadow-lg form-card">
                <div class="card-body p-4 p-md-5">
                  <h2 class="card-title text-center mb-4 pb-2 form-title">
                  </h2>
                  <div id="mensajeValidacion" class="message-box" style="display: none;"></div>
                  <div id="yaInscritoInfo" class="message-box info" style="display: none;"></div>
                  <form id="formInscripcion">
                    <input type="hidden" id="idEvento" name="idEvento">
                    <div class="text-center mb-4">
                      <img src="" alt="Foto de perfil" id="fotoPerfil" class="profile-img d-none">
                    </div>
                    <h4 class="section-title"><i class="fas fa-user me-2"></i> Tu Información</h4>
                    <div class="row g-3 mb-4">
                      <div class="col-md-6">
                        <label for="nombreUsuario" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control form-control-lg" id="nombreUsuario" disabled style="font-size:16px;">
                      </div>
                      <div class="col-md-6">
                        <label for="cedulaUsuario" class="form-label">Cédula</label>
                        <input type="text" class="form-control form-control-lg" id="cedulaUsuario" disabled style="font-size:16px;">
                      </div>
                    </div>
                    <div class="row g-3 mb-4">
                      <div class="col-md-6">
                        <label for="correoUsuario" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control form-control-lg" id="correoUsuario" disabled style="font-size:16px;">
                      </div>
                      <div class="col-md-6">
                        <label for="telefonoUsuario" class="form-label">Teléfono</label>
                        <input type="text" class="form-control form-control-lg" id="telefonoUsuario" disabled style="font-size:16px;">
                      </div>
                    </div>
                    <h4 class="section-title"><i class="fas fa-info-circle me-2"></i> Información del Evento</h4>
                    <div class="mb-3">
                      <label for="tituloEventoModal" class="form-label">Título del Evento</label>
                      <input type="text" class="form-control form-control-lg" id="tituloEventoModal" disabled style="font-size:16px;">
                    </div>
                    <div class="row g-3 mb-4">
                      <div class="col-md-4">
                        <label class="form-label">Duración (Horas)</label>
                        <input type="text" class="form-control form-control-lg" id="horasEventoModal" disabled style="font-size:16px;">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Modalidad</label>
                        <input type="text" class="form-control form-control-lg" id="modalidadEvento" disabled style="font-size:16px;">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Estado del Evento</label>
                        <input type="text" class="form-control form-control-lg" id="estadoEvento" disabled style="font-size:16px;">
                      </div>
                    </div>
                    <div class="row g-3 mb-4">
                      <div class="col-md-6">
                        <label class="form-label">Fecha de Inicio</label>
                        <input type="text" class="form-control form-control-lg" id="fechaInicioEvento" disabled style="font-size:16px;">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Fecha de Fin</label>
                        <input type="text" class="form-control form-control-lg" id="fechaFinEvento" disabled style="font-size:16px;">
                      </div>
                    </div>
                    <h4 class="section-title"><i class="fas fa-clipboard-list me-2"></i> Requisitos del Evento</h4>
                    <div class="requirements-box p-3 mb-4">
                      <ul id="requisitosList" class="list-group mb-0">
                        <li>Cargando requisitos...</li>
                      </ul>
                    </div>
                    <h4 class="section-title"><i class="fas fa-comment-dots me-2"></i> Motivación para Inscribirse</h4>
                    <div class="mb-4">
                      <label for="motivacionUsuario" class="form-label">¿Por qué deseas participar en este evento? <span class="text-danger">*</span></label>
                      <textarea class="form-control form-control-lg" id="motivacionUsuario" name="motivacionUsuario" rows="3" required placeholder="Escribe aquí tu motivación..." style="font-size:16px;"></textarea>
                    </div>
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
                      <button type="submit" class="btn btn-uta btn-lg" id="btnInscribirseModal">
                        <i class="fas fa-check-circle me-2"></i> Confirmar Inscripción
                      </button>
                      <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left me-2"></i> Cancelar
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="card text-center shadow-sm mb-4" data-aos="fade-left" data-aos-delay="1100">
        <div class="card-body">
            <img id="fotoOrganizador" src="" class="img-fluid rounded-circle mb-3" style="width: 100px;" data-aos="zoom-in" data-aos-delay="1150">
            <h5 class="text-danger font-weight-bold" data-aos="fade-up" data-aos-delay="1200">Organizador</h5>
            <p id="nombreOrganizador" class="mb-1" data-aos="fade-up" data-aos-delay="1250"></p>
            <p id="correoOrganizador" class="text-muted small" data-aos="fade-up" data-aos-delay="1300"></p>
            <div class="d-flex justify-content-center mt-2" data-aos="fade-up" data-aos-delay="1350">
                <a class="text-danger px-2" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="text-danger px-2" href="#"><i class="fab fa-instagram"></i></a>
                <a class="text-danger px-2" href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="card shadow-sm" data-aos="fade-left" data-aos-delay="1400">
        <div class="card-header bg-danger text-white">
            <h6 class="mb-0">Requisitos</h6>
        </div>
        <div class="card-body">
            <div id="requisitosEvento"></div>
        </div>
    </div>
    <div class="card shadow-sm mt-4" data-aos="fade-left" data-aos-delay="1500">
        <div class="card-header text-white">
            <h6 class="mb-0">Contenido</h6>
        </div>
        <div class="card-body">
            <div id="contenidoEvento" class="text-justify"></div>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
    <!-- Blog End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../public/lib/easing/easing.min.js"></script>
    <script src="../public/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../public/lib/tempusdominus/js/moment.min.js"></script>
    <script src="../public/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../public/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="../public/mail/jqBootstrapValidation.min.js"></script>
    <script src="../public/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../public/js/detalle.js"></script>
    <!-- AOS Animate On Scroll JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    once: true,
    duration: 700,
    offset: 60
  });
</script>
</body>

</html>
