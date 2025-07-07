<!doctype html>
<html lang="es">
<head>
  <title>Login - UTA</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fuentes e íconos -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../public/css/style.css">

  <style>
html, body {
    overflow-x: hidden;
    width: 100%;
    font-family: 'Lato', sans-serif;
    background: #f6f7f9 url('../public/img/uta/background.jpg') center center no-repeat;
    background-size: cover;
    margin: 0;
}

    .main-content {
      flex: 1 0 auto;
    }

    footer {
      flex-shrink: 0;
    }

    .login-wrap {
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      padding: 25px 40px;
      border-top: 5px solid #8B0000;
      animation: fadeInDown 0.5s ease-in-out;
    }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-wrap h3 {
      text-align: center;
      color: #8B0000;
      font-weight: bold;
      margin-bottom: 30px;
    }

    .login-logo {
      width: 100%;
      border-radius: 8px;
      margin-bottom: 25px;
    }

    .form-group {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .icon-box {
      background-color: #8B0000;
      color: white;
      padding: 10px 12px;
      border-radius: 8px 0 0 8px;
      font-size: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 45px;
    }

    .form-control {
      border-radius: 0 8px 8px 0;
      height: 45px;
      font-size: 16px;
      border: 1px solid #ccc;
      width: 100%;
      padding-left: 10px;
    }

    .form-control:focus {
      border-color: #8B0000;
      box-shadow: 0 0 0 0.15rem rgba(139, 0, 0, 0.25);
    }

    .btn-primary {
      background-color: #8B0000;
      border: none;
      font-weight: bold;
      height: 48px;
      font-size: 16px;
    }

    .btn-primary:hover {
      background-color: #600000;
    }

    a {
      color: #8B0000;
      font-weight: 600;
    }

    a:hover {
      text-decoration: underline;
    }

    /* SweetAlert personalizado */
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

    .swal2-icon.swal2-success {
      border-color: #141414 !important;
      color: #0f0f0f !important;
    }

    .swal2-success-ring {
      border: 4px solid #161616 !important;
    }

    .swal2-success-line-tip,
    .swal2-success-line-long {
      background-color: #131212 !important;
    }

    .swal2-icon.swal2-error {
      border-color: #111111 !important;
      color: #111111 !important;
    }

    .swal2-x-mark-line {
      background-color: #000 !important;
    }

    .swal2-icon.swal2-warning {
      border-color: #111111 !important;
      color: #141414 !important;
    }

    .swal2-icon.swal2-info {
      border-color: #1a1919 !important;
      color: #252525 !important;
    }

    .swal2-icon.swal2-question {
      border-color: #181818 !important;
      color: #161616 !important;
    }

    .swal2-image {
      margin-top: 10px;
      max-width: 80px;
    }
 
.banner-uta {
  width: 100vw;        
  overflow: hidden;
  margin: 0;
  padding: 0;
  display: block;
}

.img-banner {
  width: 100%;
  height: auto;
  display: block;
}


  </style>
</head>

<body>



<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height:100vh;">
  <div class="d-flex justify-content-center align-items-center w-100" style="min-height:100vh;">
    <div class="d-flex flex-row shadow-lg" style="border-radius:18px; min-width:900px; max-width:1100px; min-height:420px; max-height:480px; width:100%;">
      <!-- Columna izquierda: imágenes y textos institucionales -->
      <div class="d-flex flex-column align-items-center justify-content-center p-4 position-relative" style="width:50%; border-radius:18px 0 0 18px; background:rgba(255,255,255,0.97); min-height:420px; max-height:480px; box-shadow:0 4px 24px rgba(0,0,0,0.07);">
        <!-- Botón regresar al home -->
        <a href="../index.php" title="Volver al inicio" style="position:absolute; left:18px; top:18px; z-index:10; text-decoration:none;">
          <button type="button" style="background:#8B0000; color:#fff; border:none; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.10); transition:background 0.2s; font-size:20px;">
            <i class="fa fa-arrow-left"></i>
          </button>
        </a>
        <div style="display:flex;gap:18px;align-items:center;justify-content:center;flex-wrap:wrap; margin-bottom:18px;">
          <img src="../public/img/uta/logo2020.png" alt="FISEI" style="height:100px;">
          <img src="../public/img/uta/fisei_logo.png" alt="FISEI" style="height:100px;">

        </div>
        <h4 style="font-weight:bold;color:#222; margin-bottom:8px; text-align:center;">PLATAFORMA EDUCATIVA INSTITUCIONAL</h4>
        <h5 style="color:#8B0000;font-weight:bold; text-align:center;">Facultad de Ingeniería en Sistemas, Electrónica e Industrial</h5>
        <img src="../public/img/uta/logo1.png" alt="Escudo UTA" style="height:100px;">
      </div>
      <!-- Columna derecha: formulario de login -->
      <div class="d-flex flex-column align-items-center justify-content-center p-4" style="width:50%; border-radius:0 18px 18px 0; background:rgba(255,255,255,0.97); min-height:420px; max-height:480px; border-left:1px solid #eee; box-shadow:0 4px 24px rgba(0,0,0,0.07);">
        <div class="w-100" style="max-width:350px; margin:0 auto;">
          <form id="formLogin" class="signin-form text-start">
            <h3 class="mb-4 text-center" style="color:#8B0000;font-weight:bold;">Login</h3>
            <div class="form-group">
              <div class="icon-box">
                <i class="fa fa-user"></i>
              </div>
              <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo electrónico" required>
            </div>
            <div class="form-group" style="position:relative;">
              <div class="icon-box">
                <i class="fa fa-key"></i>
              </div>
              <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Contraseña" required style="padding-right:40px;">
              <button type="button" id="toggle-password" tabindex="-1" style="position:absolute; right:8px; top:8px; background:transparent; border:none; outline:none; color:#8B0000; font-size:18px; z-index:2;" aria-label="Mostrar/Ocultar contraseña">
                <i class="fa fa-eye" id="icon-eye"></i>
              </button>
            </div>
            <div class="form-group">
              <button type="submit" class="form-control btn btn-primary rounded submit px-3">Iniciar sesión</button>
            </div>
            <div class="form-group mt-2 text-start">
              <a href="../views/recuperar_contrasena.php">¿Olvidaste tu contraseña?</a>
            </div>
            <div class="form-group mt-2 text-center" style="font-size:14px; color:#8B0000;">
              Español · Internacional (es) <span style="color:#b00; font-size:16px; vertical-align:middle;">&#9660;</span> &nbsp; <i class="fa fa-info-circle"></i> Aviso de Cookies
            </div>
          </form>
          <p class="text-center mt-3">¿No tienes cuenta? <a href="../views/register.php">Regístrate</a></p>
          <p id="login-error" class="text-danger text-center mt-2"></p>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  // Mostrar/ocultar contraseña
  document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('toggle-password');
    var input = document.getElementById('contrasena');
    var icon = document.getElementById('icon-eye');
    if(btn && input && icon) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        if(input.type === 'password') {
          input.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          input.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    }
  });
</script>

  <!-- JS -->
  <script src="../public/js/jquery.min.js"></script>
  <script src="../public/js/popper.js"></script>
  <script src="../public/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../public/js/login.js"></script>
</body>
</html>
