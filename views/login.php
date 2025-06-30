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
      background-color: #f6f7f9;
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
	.btn-regresar {
  background-color: transparent;
  border: 2px solid #8B0000;
  color: #8B0000;
  font-weight: bold;
  border-radius: 6px;
  transition: background-color 0.3s ease, color 0.3s ease;
  padding: 6px 15px;
  display: inline-block;
  text-decoration: none;
}

.btn-regresar:hover {
  background-color: #8B0000;
  color: white;
  border-color: #660000;
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
   <div class="banner-uta">
  <img src="../public/img/header.png" alt="Banner UTA" class="img-banner">
</div>

  <div class="main-content">
    <!-- Botón de regreso -->
    <div class="container mt-3">
      <a href="../public" class="btn btn-regresar">
  <i class="fa fa-arrow-left"></i> Regresar
</a>
    </div>

    <!-- Formulario de login -->
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
      <div class="col-md-7 col-lg-5">
        <div class="login-wrap p-4 p-md-5 text-center">
          <img src="../public/img/logo_login.png" alt="Logo Universidad Técnica de Ambato" class="login-logo">
          <h3 class="mb-4">Inicio de sesión</h3>

          <form id="formLogin" class="signin-form text-start">
            <div class="form-group">
              <div class="icon-box">
                <i class="fa fa-user"></i>
              </div>
              <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo electrónico" required>
            </div>
            <div class="form-group">
              <div class="icon-box">
                <i class="fa fa-key"></i>
              </div>
              <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Contraseña" required>
            </div>
            <div class="form-group">
              <button type="submit" class="form-control btn btn-primary rounded submit px-3">Iniciar sesión</button>
            </div>
            <div class="form-group mt-2 text-start">
              <a href="../views/recuperar_contrasena.php">¿Olvidaste tu contraseña?</a>
            </div>
          </form>

          <p class="text-center mt-3">¿No tienes cuenta? <a href="../views/register.php">Regístrate</a></p>
          <p id="login-error" class="text-danger text-center mt-2"></p>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="../public/js/jquery.min.js"></script>
  <script src="../public/js/popper.js"></script>
  <script src="../public/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../public/js/login.js"></script>
   <?php include('partials/footer.php'); ?>

</body>
</html>
