<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
<style>
  html, body {
    height: 100%;
    overflow-y: auto;
  }

  body {
    background-color: #f7f7f7;
    font-family: 'Poppins', sans-serif;
  }

  h2, h4 {
    color: #ae0c22;
    font-weight: 700;
  }

  .card {
    background: #ffffff;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
  }

  .btn {
    border-radius: 10px;
    font-weight: 600;
    letter-spacing: 0.5px;
  }

  .btn-success {
    background-color: #ae0c22;
    border-color: #ae0c22;
  }

  .btn-success:hover {
    background-color: #8c0a1b;
    border-color: #8c0a1b;
  }

  .btn-warning {
    background-color: #f0ad4e;
    border-color: #f0ad4e;
  }

  .btn-danger {
    background-color: #d9534f;
    border-color: #d43f3a;
  }

  .btn-primary {
    background-color: #004a98;
    border-color: #004a98;
  }

  .table thead {
    background-color: #ae0c22;
    color: white;
  }

  .modal-header {
    background-color: #ae0c22;
    color: white;
  }

  .form-control {
    border-radius: 10px;
  }

  .btn-secondary {
    margin-top: 10px;
  }

#tablaCarrusel img {
  max-width: 120px;
  max-height: 100px;
  object-fit: cover;
  border-radius: 5px;
}

.card table td, .card table th {
  vertical-align: middle;
}

</style>

<!-- Contenedor general -->
<div id="page-wrapper">
  <div id="page-inner">

    <!-- Título -->
    <h2 class="text-center mb-3">Gestión del Carrusel Institucional</h2>
    <p class="text-center text-muted mb-4">
      Sube imágenes que aparecerán en la página de inicio del sistema.
    </p>

    <!-- Formulario centrado -->
    <div class="row justify-content-center">
      <div style="margin-left: 350px; width: 600px;">
        <div class="card mt-4 p-4">
          <form id="formCarrusel" enctype="multipart/form-data">
            <div class="form-group">
              <label for="titulo">Título:</label>
              <input type="text" class="form-control" name="titulo" required>
            </div>

            <div class="form-group mt-3">
              <label for="descripcion">Descripción (opcional):</label>
              <textarea class="form-control" name="descripcion" rows="3"></textarea>
            </div>

            <div class="form-group mt-3">
              <label for="imagen">Imagen:</label>
              <input type="file" class="form-control" name="imagen" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-success btn-block mt-4">
              <i class="fa fa-upload"></i> Subir al Carrusel
            </button>
            <a href="configuracion_datos_base.php" class="btn btn-secondary mt-2">
              <i class="fa fa-arrow-left"></i> Volver a configuración
            </a>
          </form>
        </div>
      </div>
    </div>

    <div style="margin-left: 100px; width: 1000px;">
      <div class="card p-4">
        <h4 class="text-center mb-3">Imágenes Actuales del Carrusel</h4>
        <div class="table-responsive">
          <table class="table table-bordered text-center w-100" id="tablaCarrusel">
            <thead class="bg-danger text-white sticky-top">
              <tr>
                <th>#</th>
                <th>Imagen</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="contenedorCarrusel">
              <!-- Contenido dinámico cargado por JS -->
            </tbody>
          </table>
        </div>
      </div>
    </div>


    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditarCarrusel" tabindex="-1">
      <div class="modal-dialog">
        <form id="formEditarCarrusel" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title">Editar Imagen</h5>
              <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id" id="editId">
              <div class="form-group">
                <label>Título</label>
                <input type="text" class="form-control" name="titulo" id="editTitulo" required>
              </div>
              <div class="form-group mt-3">
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion" id="editDescripcion"></textarea>
              </div>
              <div class="form-group mt-3">
                <label>Nueva Imagen (opcional)</label>
                <input type="file" class="form-control" name="imagen" accept="image/*">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Scripts -->
<script src="../public/js/carrusel_admin.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php include("partials/footer_Admin.php"); ?>
