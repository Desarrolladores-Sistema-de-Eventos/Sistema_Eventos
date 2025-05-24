<?php include("partials/header_Admin.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<div id="page-wrapper" style="margin-left: 260px; padding: 30px;">
  <h3 class="text-danger"><i class="fa fa-university"></i> Gestión de Facultades</h3>
  <p class="text-muted">Administra la información de las facultades disponibles en la institución.</p>

  <div class="mb-3">
    <button class="btn btn-success"><i class="fa fa-plus"></i> Agregar Facultad</button>
  </div>
    <br>
    <br>
  <div class="table-responsive">
    <table class="table table-dark table-bordered table-hover">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Misión</th>
          <th>Visión</th>
          <th>Ubicación</th>
          <th style="width: 120px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Datos simulados para vista previa -->
        <tr>
          <td>Facultad de Ingeniería</td>
          <td>Formar profesionales en áreas técnicas</td>
          <td>Ser líder en innovación tecnológica</td>
          <td>Bloque A, Campus Central</td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
        <tr>
          <td>Facultad de Humanidades</td>
          <td>Fomentar el pensamiento crítico y social</td>
          <td>Ser referente en ciencias sociales</td>
          <td>Bloque C, Campus Norte</td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
    <h1>Se cargaran dinamicamente desde la BD</h1>
  </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
