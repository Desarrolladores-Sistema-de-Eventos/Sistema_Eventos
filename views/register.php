<!DOCTYPE html>
<html lang="es">
<head>
  <title>Registro</title>
  <meta charset="utf-8" />
      <link href="../public/img/uta/logo1.png" rel="icon">

  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../public/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    * { box-sizing: border-box; }
    html, body {
      overflow-x: hidden;
      width: 100%;
      font-family: 'Lato', 'Poppins', sans-serif;
      background: #f6f7f9 url('../public/img/uta/background.jpg') center center no-repeat;
      background-size: cover;
      margin: 0;
      height: 100%;
    }

    .main-content {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
    }

    .register-container {
      background-color: #fff;
      border: 2px solid #8B0000;
      border-radius: 16px;
      padding: 40px;
      width: 100%;
      max-width: 750px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }

    .form-title {
      text-align: center;
      color: #8B0000;
      font-weight: bold;
      margin-bottom: 30px;
    }

.form-control:focus {
  border-color: #8B0000;
  box-shadow: 0 0 0 0.15rem rgba(139, 0, 0, 0.25);
  outline: none;
}

.form-label i {
  color: #111111 !important;
}


    button[type="submit"] {
      background-color: #8B0000;
      color: white;
      border: none;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #600000;
    }

    .text-center a {
      color: #8B0000;
      font-weight: 600;
      text-decoration: underline;
    }

    .swal2-popup {
      border-left: 6px solid #8B0000 !important;
      border-right: 6px solid #8B0000 !important;
      border-radius: 10px !important;
      font-family: 'Open Sans', sans-serif;
    }

    .swal2-title {
      font-weight: bold;
      color: #8B0000;
    }

    .swal2-confirm, .swal2-cancel {
      background-color: #1a1919 !important;
      color: #fff !important;
      border-radius: 5px !important;
      padding: 10px 20px !important;
      font-weight: bold;
    }

    .swal2-icon.swal2-success { border-color: #141414 !important; color: #0f0f0f !important; }
    .swal2-success-ring { border: 4px solid #161616 !important; }
    .swal2-success-line-tip, .swal2-success-line-long { background-color: #131212 !important; }

    .swal2-icon.swal2-error { border-color: #111111 !important; color: #111111 !important; }
    .swal2-x-mark-line { background-color: #000 !important; }

    .swal2-icon.swal2-warning { border-color: #111111 !important; color: #141414 !important; }
    .swal2-icon.swal2-info { border-color: #1a1919 !important; color: #252525 !important; }
    .swal2-icon.swal2-question { border-color: #181818 !important; color: #161616 !important; }

    .swal2-image {
      margin-top: 10px;
      max-width: 80px;
    }
    .register-container {
  border-top: 5px solid #8B0000;
}
.register-container {
  animation: fadeInDown 0.5s ease;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

  </style>
</head>

<body>

  <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="d-flex justify-content-center align-items-center w-100" style="min-height:100vh;">
      <div class="d-flex flex-row shadow-lg flex-wrap" style="border-radius:18px; min-width:420px; max-width:1100px; min-height:480px; width:100%;">
        <!-- Columna izquierda: imágenes y textos institucionales -->
        <div class="d-flex flex-column align-items-center justify-content-center p-3" style="width:100%; max-width:440px; border-radius:18px 0 0 18px; background:rgba(255,255,255,0.97); min-height:480px; box-shadow:0 4px 24px rgba(0,0,0,0.07);">
          <div style="display:flex;gap:18px;align-items:center;justify-content:center;flex-wrap:wrap; margin-bottom:18px;">
            <img src="../public/img/uta/logo2020.png" alt="FISEI" style="height:100px;">
            <img src="../public/img/uta/fisei_logo.png" alt="FISEI" style="height:100px;">
          </div>
          <h4 style="font-weight:bold;color:#222; margin-bottom:8px; text-align:center;">PLATAFORMA EDUCATIVA INSTITUCIONAL</h4>
          <h5 style="color:#8B0000;font-weight:bold; text-align:center;">Facultad de Ingeniería en Sistemas, Electrónica e Industrial</h5>
          <img src="../public/img/uta/logo1.png" alt="Escudo UTA" style="height:100px;">
        </div>
        <!-- Columna derecha: formulario de registro -->
        <div class="d-flex flex-column align-items-center justify-content-center p-3" style="width:100%; max-width:540px; border-radius:0 18px 18px 0; background:rgba(255,255,255,0.97); min-height:480px; border-left:1px solid #eee; box-shadow:0 4px 24px rgba(0,0,0,0.07);">
          <div class="w-100" style="max-width:440px; margin:0 auto;">
            <form id="formRegistroUsuario" method="POST" action="#" autocomplete="off" class="text-start">
              <h3 class="mb-4 text-center" style="color:#8B0000;font-weight:bold;">Registro</h3>
              <div class="row g-2">
                <div class="col-6">
                  <div class="form-group mb-2">
                    <label for="nombres" class="form-label"><i class="fas fa-user" style="color:#8B0000;"></i> Nombres</label>
                    <input type="text" class="form-control form-control-sm" id="nombres" name="nombres" required maxlength="100" style="font-size:15px; padding:6px 10px;">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-2">
                    <label for="apellidos" class="form-label"><i class="fas fa-user-tag" style="color:#8B0000;"></i> Apellidos</label>
                    <input type="text" class="form-control form-control-sm" id="apellidos" name="apellidos" required maxlength="100" style="font-size:15px; padding:6px 10px;">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-2">
                    <label for="telefono" class="form-label"><i class="fas fa-phone-alt" style="color:#8B0000;"></i> Teléfono</label>
                    <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" required maxlength="20" style="font-size:15px; padding:6px 10px;">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-2">
                    <label for="direccion" class="form-label"><i class="fas fa-map-marker-alt" style="color:#8B0000;"></i> Dirección</label>
                    <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" maxlength="255" style="font-size:15px; padding:6px 10px;">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-2">
                    <label for="fecha_nacimiento" class="form-label"><i class="fas fa-calendar-alt" style="color:#8B0000;"></i> Fecha de nacimiento</label>
                    <input type="date" class="form-control form-control-sm" id="fecha_nacimiento" name="fecha_nacimiento" required style="font-size:15px; padding:6px 10px;">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-2">
                    <label for="correo" class="form-label"><i class="fas fa-envelope" style="color:#8B0000;"></i> Correo electrónico</label>
                    <input type="email" class="form-control form-control-sm" id="correo" name="correo" required maxlength="100" style="font-size:15px; padding:6px 10px;">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-2">
                    <label for="contrasena" class="form-label"><i class="fas fa-lock" style="color:#8B0000;"></i> Contraseña</label>
                    <input type="password" class="form-control form-control-sm" id="contrasena" name="contrasena" required minlength="6" maxlength="255" style="font-size:15px; padding:6px 10px;">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-2">
                    <label for="confirmar_contrasena" class="form-label"><i class="fas fa-lock" style="color:#8B0000;"></i> Confirmar contraseña</label>
                    <input type="password" class="form-control form-control-sm" id="confirmar_contrasena" name="confirmar_contrasena" required minlength="6" maxlength="255" style="font-size:15px; padding:6px 10px;">
                  </div>
                </div>
              </div>
              <div class="progress mb-2" style="height: 5px;">
                <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <button type="submit" class="btn btn-primary w-100 mt-2" style="font-size:16px; padding:7px 0;"><i class="fas fa-user-plus me-2"></i> Registrarse</button>
            </form>
            <div class="text-center mt-3" style="color: #000;">
              ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
            </div>
            <p id="register-error" class="text-danger text-center mt-2"></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="../public/js/jquery.min.js"></script>
  <script src="../public/js/popper.js"></script>
  <script src="../public/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="../public/js/usuario.js"></script>
</body>
</html>
