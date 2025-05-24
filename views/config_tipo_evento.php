<?php include("partials/header_Admin.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<div id="page-wrapper" style="margin-left: 260px; padding: 30px;">
  <h3 class="text-danger"><i class="fa fa-tags"></i> Gestión de Tipos de Evento</h3>
  <p class="text-muted">Administra los diferentes tipos de eventos disponibles en el sistema.</p>

  <div class="mb-3">
    <button class="btn btn-success"><i class="fa fa-plus"></i> Agregar Tipo de Evento</button>
  </div>
    <br>
    <br>
  <div class="table-responsive">
    <table class="table table-dark table-striped table-bordered">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Descripción</th>
          <th style="width: 120px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- FILAS DE EJEMPLO (estas se reemplazan por las que vengan desde la BD) -->
        <tr>
          <td>Congreso</td>
          <td>Evento académico de gran escala</td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
        <tr>
          <td>Taller</td>
          <td>Actividad práctica con participación activa</td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
    <h1>Se cargran dimanicamente desde la BD</h1>
  </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
