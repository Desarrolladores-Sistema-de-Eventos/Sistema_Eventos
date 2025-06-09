<!DOCTYPE html>
<html lang="es">
<head>
  <title>Registro</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../public/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <style>
    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('../public/img/background.png') no-repeat center center fixed;
      background-size: cover;
    }

  
    .main-content {
      display: flex;
      justify-content: center;
      align-items: center;
      padding-top: 40px; /* espacio para topbar */
      padding-bottom: 40px;
      min-height: 100vh;
    }


    

    .register-container {
      background: rgba(253, 253, 253, 0.49);
      border-radius: 20px;
      padding: 40px;
      width: 100%;
      max-width: 750px;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
      border: 1px solid rgba(255, 255, 255, 0.87);
    }

    .form-title {
      text-align: center;
      color: rgba(0, 0, 0, 0.5);
      font-weight: bold;
      margin-bottom: 30px;
    }

    .form-label {
      color:rgb(0, 0, 0);
      font-weight: 500;
    }

 
   

    button[type="submit"] {
      background-color: #660000;
      border: none;
      font-weight: bold;
    }

    .text-center a {
      color: #fff;
      text-decoration: underline;
    }
  </style>
</head>

<body>

  	<!-- Topbar Start -->
	<div class="container-fluid py-2 border-bottom" style="background-color:rgb(255, 255, 255);">
		<div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center">
			<div class="d-flex align-items-center mb-2 mb-lg-0">
				<img src="../public/img/sello_UTA.jpg" alt="Logo Facultad" style="height: 60px; margin-right: 10px;">
				<div>
					<h6 class="mb-0 text-uppercase font-weight-bold" style="color: #660000;">FACULTAD DE INGENIERÍA EN</h6>
					<h5 class="mb-0 font-weight-bold" style="color: #660000;">SISTEMAS, ELECTRÓNICA E INDUSTRIAL</h5>
					<span class="badge badge-danger">CTT - TALLERES TECNOLÓGICOS</span>
				</div>
			</div>
			<div class="d-flex align-items-center">
				<div class="text-center mx-3">
					<i class="fa fa-graduation-cap text-danger fa-2x"></i>
					<div><a href="#" class="text-dark font-weight-bold"></a></div>
				</div>
			</div>
		</div>
	</div>
	<!-- Topbar End -->

  <!-- ✅ Formulario -->
  <div class="main-content">
    <div class="register-container">
      <h2 class="form-title">Registro de Usuario</h2>
      <form id="formRegistroUsuario" method="POST" action="#" autocomplete="off">
        <div class="row">
          <div class="col-md-6">
            <!-- Nombres -->
            <div class="mb-3">
              <label for="nombres" class="form-label"><i class="fas fa-user text-primary"></i> Nombres</label>
              <input type="text" class="form-control" id="nombres" name="nombres" required maxlength="100">
            </div>

            <!-- Apellidos -->
            <div class="mb-3">
              <label for="apellidos" class="form-label"><i class="fas fa-user-tag text-primary"></i> Apellidos</label>
              <input type="text" class="form-control" id="apellidos" name="apellidos" required maxlength="100">
            </div>

            <!-- Teléfono -->
            <div class="mb-3">
              <label for="telefono" class="form-label"><i class="fas fa-phone-alt text-success"></i> Teléfono</label>
              <input type="text" class="form-control" id="telefono" name="telefono" required maxlength="20">
            </div>

            <!-- Dirección -->
            <div class="mb-3">
              <label for="direccion" class="form-label"><i class="fas fa-map-marker-alt text-danger"></i> Dirección</label>
              <input type="text" class="form-control" id="direccion" name="direccion" maxlength="255">
            </div>

            <!-- Fecha nacimiento -->
            <div class="mb-3">
              <label for="fecha_nacimiento" class="form-label"><i class="fas fa-calendar-alt text-warning"></i> Fecha de nacimiento</label>
              <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
          </div>

          <div class="col-md-6">
            <!-- Correo -->
            <div class="mb-3">
              <label for="correo" class="form-label"><i class="fas fa-envelope text-danger"></i> Correo electrónico</label>
              <input type="email" class="form-control" id="correo" name="correo" required maxlength="100">
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
              <label for="contrasena" class="form-label"><i class="fas fa-lock text-purple"></i> Contraseña</label>
              <input type="password" class="form-control" id="contrasena" name="contrasena" required minlength="6" maxlength="255">
            </div>

            <!-- Barra de fuerza -->
            <div class="progress mb-2" style="height: 6px;">
              <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <!-- Confirmar contraseña -->
            <div class="mb-3">
              <label for="confirmar_contrasena" class="form-label"><i class="fas fa-lock text-purple"></i> Confirmar contraseña</label>
              <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" required minlength="6" maxlength="255">
            </div>

          </div>
        </div>

        <button type="submit" class="btn w-100 mt-2 text-white">
          <i class="fas fa-user-plus me-2"></i> Registrarse
        </button>
      </form>

      <div class="text-center mt-3" style="color: #000;">
        ¿Ya tienes cuenta? <a href="login.php" style="color: #000; text-decoration: underline;">Inicia sesión</a>
      </div>
    </div>
  </div>

  <!-- JS scripts -->
  <script src="../public/js/jquery.min.js"></script>
  <script src="../public/js/popper.js"></script>
  <script src="../public/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="../public/js/usuario.js"></script>
<?php include('partials/footer.php'); ?>

