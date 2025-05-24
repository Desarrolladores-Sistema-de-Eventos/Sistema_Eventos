<?php include("partials/header_Admin.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<div id="page-wrapper" style="margin-left: 260px; padding: 30px;">
  <h3 class="text-danger"><i class="fa fa-list-alt"></i> Gestión de Requisitos de Evento</h3>
  <p class="text-muted">Define los requisitos que deben cumplir los participantes por evento.</p>

  <div class="mb-3">
    <button class="btn btn-success"><i class="fa fa-plus"></i> Agregar Requisito</button>
  </div>
    <br>
  <div class="table-responsive">
    <table class="table table-dark table-bordered table-hover">
      <thead>
        <tr>
          <th>Evento</th>
          <th>Descripción</th>
          <th>Obligatorio</th>
          <th style="width: 120px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Datos simulados -->
        <tr>
          <td>Congreso de Tecnología</td>
          <td>Subir copia de cédula</td>
          <td><span class="badge bg-danger">Sí</span></td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
        <tr>
          <td>Taller de Emprendimiento</td>
          <td>Formulario de inscripción firmado</td>
          <td><span class="badge bg-secondary">No</span></td>
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
