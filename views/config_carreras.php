<?php include("partials/header_Admin.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<div id="page-wrapper" style="margin-left: 260px; padding: 30px;">
  <h3 class="text-danger"><i class="fa fa-graduation-cap"></i> Gestión de Carreras</h3>
  <p class="text-muted">Administra las carreras disponibles en cada facultad.</p>

  <div class="mb-3">
    <button class="btn btn-success"><i class="fa fa-plus"></i> Agregar Carrera</button>
  </div>
    <br>
    <br>
  <div class="table-responsive">
    <table class="table table-dark table-bordered table-hover">
      <thead>
        <tr>
          <th>Nombre de Carrera</th>
          <th>Facultad</th>
          <th style="width: 120px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Datos simulados -->
        <tr>
          <td>Ingeniería de Sistemas</td>
          <td>Facultad de Ingeniería</td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
        <tr>
          <td>Psicología</td>
          <td>Facultad de Humanidades</td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
    <h1>Se cargaran dinamicante desde la base de datos</h1>
  </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
