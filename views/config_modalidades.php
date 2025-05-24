<?php include("partials/header_Admin.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<div id="page-wrapper" style="margin-left: 260px; padding: 30px; min-height: 100vh;">
  <div class="container-fluid">
    <h3 class="text-danger mb-4"><i class="fa fa-sitemap"></i> Gestión de Modalidades de Evento</h3>
    <p class="text-muted">Administra las modalidades de participación como presencial, virtual o híbrido.</p>

    <button class="btn btn-success mb-3">
      <i class="fa fa-plus"></i> Nueva Modalidad
    </button>
    <br>
    <br>
    <div class="table-responsive">
      <table class="table table-dark table-bordered table-hover text-light">
        <thead class="thead-light text-center">
          <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <!-- Ejemplo de fila -->
          <tr>
            <td>PRES</td>
            <td>Presencial</td>
            <td>
              <button class="btn btn-primary btn-sm me-1" title="Editar">
                <i class="fa fa-pen-to-square"></i>
              </button>
              <button class="btn btn-danger btn-sm" title="Eliminar">
                <i class="fa fa-trash"></i>
              </button>
            </td>
          </tr>
          <tr>
            <td>VIRT</td>
            <td>Virtual</td>
            <td>
              <button class="btn btn-primary btn-sm me-1" title="Editar">
                <i class="fa fa-pen-to-square"></i>
              </button>
              <button class="btn btn-danger btn-sm" title="Eliminar">
                <i class="fa fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
    </table>
        <h1>Se cargarán dinamicamente desde la BD</h1>
    </div>
  </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
