<!DOCTYPE html>
<html lang="es">
<head>
  <title>Registro</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../public/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f4;
      overflow-x: hidden;
    }

    .main-content {
      display: flex;
      justify-content: center;
      align-items: center;
      padding-top: 30px;
      padding-bottom: 30px;
      min-height: 100vh;
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

  <!-- Banner institucional (opcional reemplazar con tu banner real) -->
  <div class="banner-uta">
    <img src="../public/img/header.png" alt="Banner UTA" style="width: 100%; height: auto; display: block;">
  </div>

  <!-- Formulario -->
  <div class="main-content">
    <div class="register-container">
      <h2 class="form-title d-flex align-items-center justify-content-center gap-2"><i class="fas fa-user-plus" style="color: #8B0000; font-size: 28px;"></i>Registro</h2>
      <form id="formRegistroUsuario" method="POST" action="#" autocomplete="off">
        <div class="row">
          <div class="col-md-6">
            <!-- Nombres -->
            <div class="mb-3">
              <label for="nombres" class="form-label">
                <i class="fas fa-user" style="color:#8B0000;"></i> Nombres
              </label>
              <input type="text" class="form-control" id="nombres" name="nombres" required maxlength="100">
            </div>

            <!-- Apellidos -->
            <div class="mb-3">
              <label for="apellidos" class="form-label">
                <i class="fas fa-user-tag" style="color:#8B0000;"></i> Apellidos
              </label>
              <input type="text" class="form-control" id="apellidos" name="apellidos" required maxlength="100">
            </div>

            <!-- Teléfono -->
            <div class="mb-3">
              <label for="telefono" class="form-label">
                <i class="fas fa-phone-alt" style="color:#8B0000;"></i> Teléfono
              </label>
              <input type="text" class="form-control" id="telefono" name="telefono" required maxlength="20">
            </div>

            <!-- Dirección -->
            <div class="mb-3">
              <label for="direccion" class="form-label">
                <i class="fas fa-map-marker-alt" style="color:#8B0000;"></i> Dirección
              </label>
              <input type="text" class="form-control" id="direccion" name="direccion" maxlength="255">
            </div>

            <!-- Fecha nacimiento -->
            <div class="mb-3">
              <label for="fecha_nacimiento" class="form-label">
                <i class="fas fa-calendar-alt" style="color:#8B0000;"></i> Fecha de nacimiento
              </label>
              <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
          </div>

          <div class="col-md-6">
            <!-- Correo -->
            <div class="mb-3">
              <label for="correo" class="form-label">
                <i class="fas fa-envelope" style="color:#8B0000;"></i> Correo electrónico
              </label>
              <input type="email" class="form-control" id="correo" name="correo" required maxlength="100">
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
              <label for="contrasena" class="form-label">
                <i class="fas fa-lock" style="color:#8B0000;"></i> Contraseña
              </label>
              <input type="password" class="form-control" id="contrasena" name="contrasena" required minlength="6" maxlength="255">
            </div>

            <!-- Barra de fuerza -->
            <div class="progress mb-2" style="height: 6px;">
              <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <!-- Confirmar contraseña -->
            <div class="mb-3">
              <label for="confirmar_contrasena" class="form-label">
                <i class="fas fa-lock" style="color:#8B0000;"></i> Confirmar contraseña
              </label>
              <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" required minlength="6" maxlength="255">
            </div>
          </div>
        </div>

        <button type="submit" class="btn w-100 mt-2">
          <i class="fas fa-user-plus me-2"></i> Registrarse
        </button>
      </form>

      <div class="text-center mt-3" style="color: #000;">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
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
  <?php include('partials/footer.php'); ?>
</body>
</html>
