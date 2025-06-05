<html lang="es">
<head>
    <title>Registro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        html, body { height: 100%; }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: rgb(241, 241, 241);
            background-size: cover;
        }
        .main-content { flex: 1 0 auto; }
        .register-container {
            max-width: 700px;
            margin: 40px auto;
            background: rgb(255, 255, 255);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 30px 40px;
        }
        .form-title {
            font-weight: bold;
            margin-bottom: 25px;
            color: #2d3436;
        }
        .form-login, .form-register {
    font-family: 'Poppins', Arial, sans-serif;
}
.form-title {
    font-size: 1.8rem; 
}
    </style>
</head>
<body>
<div class="main-content">
    <!-- Topbar Start -->
    <div class="container-fluid py-2 border-bottom" style="background-color:rgb(253, 253, 253);">
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
    <div class="register-container">
        <h2 class="form-title text-center">Registro de Usuario</h2>
        <form id="formRegistroUsuario" method="POST" autocomplete="off">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" maxlength="255">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required maxlength="100">
                        <small id="correoHelp" class="form-text text-muted">
                            - Estudiantes y Docentes: debe terminar en <b>@uta.edu.ec</b><br>
                            - Invitados: debe terminar en <b>@gmail.com</b>
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" required minlength="6" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label for="codigorol" class="form-label">Rol de Participante: </label>
                        <select class="form-select" id="codigorol" name="codigorol" required>
                            <option value="">Seleccione...</option>
                            <option value="EST">Estudiante</option>
                            <option value="DOC">Docente</option>
                            <option value="INV">Invitado</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn w-100" style="background-color: #660000; color: #fff;">Registrarse</button>
        </form>
        <div class="text-center mt-3">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
        </div>
    </div>
</div>
<!-- JS (orden importa) -->
<script src="../public/js/jquery.min.js"></script>
<script src="../public/js/popper.js"></script>
<script src="../public/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/usuario.js"></script>
<script src="../public/js/registro.js"></script>

<?php include('partials/footer.php'); ?>