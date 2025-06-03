<?php include("partials/header_Admin.php"); ?>

<style>
  .password-wrapper {
    position: relative;
  }

  .password-wrapper input {
    padding-right: 35px;
  }

  .password-wrapper .toggle-password {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #333;
    cursor: pointer;
  }
</style>

<div id="page-wrapper">
  <div id="page-inner">
  <h3 class="text-info"><i class="fa fa-users"></i> Gestión de Usuarios</h3>
  <p class="text-muted">Administra la información de los usuarios del sistema.</p>

  <div class="mb-3">
    <button class="btn btn-success"><i class="fa fa-user-plus"></i> Nuevo Usuario</button>
  </div>
  <br>

  <div class="table-responsive">
    <table class="table table-dark table-bordered table-hover">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Rol</th>
          <th>Interno</th>
          <th>Contraseña</th>
          <th style="width: 120px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Juan Pérez</td>
          <td>juan@instituto.edu</td>
          <td>Administrador</td>
          <td><i class="fa fa-check text-success"></i></td>
          <td>
            <div class="password-wrapper">
              <input type="password" id="pass1" class="form-control form-control-sm" value="Jp2024Xyz" readonly>
              <button class="toggle-password" onclick="togglePassword('pass1', this)">
                <i class="fa fa-eye"></i>
              </button>
            </div>
          </td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>

        <tr>
          <td>Ana Torres</td>
          <td>ana@instituto.edu</td>
          <td>Coordinador</td>
          <td><i class="fa fa-times text-danger"></i></td>
          <td>
            <div class="password-wrapper">
              <input type="password" id="pass2" class="form-control form-control-sm" value="AnaT!789" readonly>
              <button class="toggle-password" onclick="togglePassword('pass2', this)">
                <i class="fa fa-eye"></i>
              </button>
            </div>
          </td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div>
      <a href="configuracion_datos_base.php" class="btn btn-secondary mt-2"><i class="fa fa-arrow-left"></i> Volver a configuración</a>
    </div>
</div>
</div>

<script>
  function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector("i");
    const type = input.type === "password" ? "text" : "password";
    input.type = type;
    icon.classList.toggle("fa-eye");
    icon.classList.toggle("fa-eye-slash");
  }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php include("partials/footer_Admin.php"); ?>
