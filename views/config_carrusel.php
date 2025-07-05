<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>

<style>
 
  .card {
    background: #ffffff;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
  }


  .table thead {
    background-color: #ae0c22;
    color: white;
  }

  .modal-header {
    background-color: #ae0c22;
    color: white;
  }

  body {
  background-color: #fff;
  color: #000;
  font-family: Arial, sans-serif;
}
label,p{
  color: #000;
  font-family: Arial, sans-serif;
  font-size: 14px;

}


  h2 {
    font-size: 24px;
    color: rgb(23, 23, 23);
    font-weight: bold;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
thead {
  background-color: rgb(180, 34, 34);
  color: white;
  font-size: 14px;
  font-weight: normal;
}
  th {
    padding: 12px;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #ddd;
    background-color: rgb(180, 34, 34); 
    font-size: 14px;
    font-weight: normal;
  }
td {
  padding: 12px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ddd;
  font-size: 14px;
}

/* Hover plomito bajito para filas de la tabla */
table#tabla-carrusel tbody tr:hover {
  background-color: #f2f2f2 !important;
  transition: background 0.2s;
}

#tablaCarrusel img {
  max-width: 120px;
  max-height: 100px;
  object-fit: cover;
  border-radius: 5px;
}

.btn-carrusel-upload {
  background-color: #e0e0e0 !important; 
  color: #111 !important;
  border: none;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  transition: background 0.2s, color 0.2s;
}
.btn-carrusel-upload:hover, .btn-carrusel-upload:focus {
  background-color: #cccccc !important;
  color: #000 !important;
}
.btn-carrusel-upload i.fa {
  color: #111 !important;
  margin-right: 6px;
}
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a:focus,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li > a:hover {
    color: #111 !important;
    background: #fff !important;
    border: 1px solid #ddd !important;
    box-shadow: none !important;
    outline: none !important;
  }
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
    background-color: #9b2e2e !important;
    border-color: #9b2e2e !important;
    color: #fff !important;
    box-shadow: none !important;
    outline: none !important;
  }

</style>

<!-- Contenedor general -->
<div id="page-wrapper">
  <div id="page-inner">


    <!-- Título y botón volver en la esquina superior derecha -->
    <div class="d-flex align-items-center justify-content-between mb-3" style="min-height: 48px; gap: 16px;">
      <h2 class="mb-0">Gestión del Carrusel Institucional</h2>
      <a href="configuracion_datos_base.php" class="btn btn-secondary" style="min-width: 200px; z-index: 10; position: relative; cursor: pointer;">
        <i class="fa fa-arrow-left"></i> Volver a configuración
      </a>
    </div>
    <p class="text-center text-muted mb-4">
      Sube imágenes que aparecerán en la página de inicio del sistema.
    </p>

    <!-- Formulario a la izquierda y tabla a la derecha -->
    <div class="row" style="display: flex; gap: 24px; align-items: flex-start;">
      <div class="col-md-4 d-flex flex-column" style="min-width: 340px; max-width: 400px; flex: 1;">
        <div class="card mt-4 p-4 h-100" id="form-card-carrusel">
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
            <button type="submit" class="btn btn-carrusel-upload btn-block mt-4">
              <i class="fa fa-upload"></i> Subir al Carrusel
            </button>
          </form>
        </div>
      </div>
      <div class="col-md-8 d-flex flex-column" style="flex: 3.2; min-width: 650px;">
        <div class="card p-4 h-100" id="tabla-card-carrusel">
          <div class="table-responsive mt-4" id="tabla-scroll-carrusel" style="overflow-y: auto;">
            <table class="table table-bordered text-center w-100" id="tabla-carrusel">
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
              <button type="submit" class="btn btn-carrusel-upload">
              <i class="fa fa-save"></i> Guardar Cambios
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Scripts -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/carrusel_admin.js"></script>
<script>
// Ajustar la altura del contenedor de la tabla para igualar la del formulario
window.addEventListener('DOMContentLoaded', function() {
  function igualarAlturaCarrusel() {
    var formCard = document.getElementById('form-card-carrusel');
    var tablaCard = document.getElementById('tabla-card-carrusel');
    var tablaScroll = document.getElementById('tabla-scroll-carrusel');
    if (formCard && tablaCard && tablaScroll) {
      var altura = formCard.offsetHeight;
      tablaCard.style.height = altura + 'px';
      tablaScroll.style.maxHeight = (altura - 80) + 'px'; // 80px para padding y título
    }
  }
  igualarAlturaCarrusel();
  window.addEventListener('resize', igualarAlturaCarrusel);
});
</script>
<?php include("partials/footer_Admin.php"); ?>
