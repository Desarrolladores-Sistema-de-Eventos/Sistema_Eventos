<?php include("partials/header_Admin.php"); ?>

<div id="page-wrapper">
  <div id="page-inner">
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
  </div>
  <div>
      <a href="configuracion_datos_base.php" class="btn btn-secondary mt-2"><i class="fa fa-arrow-left"></i> Volver a configuración</a>
    </div>
</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php include("partials/footer_Admin.php"); ?>
