<?php include("partials/header_Admin.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<div id="page-wrapper" style="margin-left: 260px; padding: 30px;">
  <h3 class="text-success"><i class="fa fa-credit-card"></i> Gestión de Formas de Pago</h3>
  <p class="text-muted">Administra los métodos disponibles para realizar pagos de inscripción.</p>

  <div class="mb-3">
    <button class="btn btn-success"><i class="fa fa-plus"></i> Agregar Forma de Pago</button>
  </div>
    <br>
  <div class="table-responsive">
    <table class="table table-dark table-bordered table-hover">
      <thead>
        <tr>
          <th>Código</th>
          <th>Nombre</th>
          <th style="width: 120px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Ejemplos simulados -->
        <tr>
          <td>TRF</td>
          <td>Transferencia Bancaria</td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
        <tr>
          <td>EFE</td>
          <td>Efectivo</td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
        <tr>
          <td>CRD</td>
          <td>Tarjeta de Crédito</td>
          <td>
            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
    <h1>Se cargaran dinamicamente desde la base de datos</h1>
  </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
