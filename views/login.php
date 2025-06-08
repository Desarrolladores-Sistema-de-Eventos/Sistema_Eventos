<!doctype html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../public/css/style.css">

	<style>
		html, body {
			height: 100%;
		}
		body {
			min-height: 100vh;
			display: flex;
			flex-direction: column;
		}
		.main-content {
			flex: 1 0 auto;
		}
		footer {
			flex-shrink: 0;
		}
	</style>
</head>
<body>
<div class="main-content">
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

	<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
		<div class="col-md-7 col-lg-5">
			<div class="wrap">
				<div class="img"></div>
				<div class="login-wrap p-4 p-md-5">
					<div class="d-flex">
						<div class="w-100">
							<h3 class="mb-4">Inicio de Sesión</h3>
						</div>
						<div class="w-100">
							<p class="social-media d-flex justify-content-end">
								<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
							</p>
						</div>
					</div>
					<form id="formLogin" class="signin-form">
						<div class="form-group mt-3">
							<input type="email" name="correo" id="correo" class="form-control" required>
							<label class="form-control-placeholder" for="correo">Correo</label>
						</div>
						<div class="form-group">
							<input type="password" name="contrasena" id="contrasena" class="form-control" required>
							<label class="form-control-placeholder" for="contrasena">Contraseña</label>
							<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						</div>
						<div class="form-group">
							<button type="submit" class="form-control btn btn-primary rounded submit px-3">Iniciar Sesión</button>
						</div>
						<div class="form-group d-md-flex">
							<div class="w-50 text-left">
							</div>
							<div class="w-50 text-md-right">
								<a href="#">¿Olvidaste tu contraseña?</a>
							</div>
						</div>
					</form>
					<p class="text-center">¿No tienes cuenta? <a href="../views/register.php">Regístrate</a></p>
					<p id="login-error" class="text-danger text-center mt-2"></p>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="module" src="../public/js/login.js"></script>
<!-- JS (orden importa) -->
<script src="../public/js/jquery.min.js"></script>
<script src="../public/js/popper.js"></script>
<script src="../public/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>


