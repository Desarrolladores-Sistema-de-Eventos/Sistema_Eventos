<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>

<style>
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

<div id="page-wrapper">
  <div id="page-inner">
    <h2 class=""><i class="fa fa-file-text"></i> Gestión de Requisitos de Evento</h2>
    <div class="mb-3">
      <button class="btn btn-carrusel-upload" id="btnAgregarRequisito"><i class="fa fa-plus"></i> Agregar Requisito</button>
    </div>
    <br>
    <div class="table-responsive">
      <table class="table table-dark table-bordered table-hover" id="tablaRequisitos">
        <thead>
          <tr>
            <th>Requisitos Generales</th>
            <th style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se cargan los requisitos dinámicamente -->
        </tbody>
      </table>
    </div>
    <div>
      <a href="configuracion_datos_base.php" class="btn btn-secondary mt-2"><i class="fa fa-arrow-left"></i> Volver a configuración</a>
    </div>
  </div>
</div>

<!-- Modal Requisito -->
<div class="modal fade" id="modalRequisito" tabindex="-1" role="dialog" aria-labelledby="modalRequisitoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formRequisito">
        <div class="modal-header">
          <h5 class="modal-title" id="modalRequisitoLabel">Agregar Requisito</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="requisitoId" name="id">
          <div class="form-group">
            <label for="descripcionRequisito">Descripción</label>
            <input type="text" class="form-control" id="descripcionRequisito" name="descripcion" maxlength="255" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-carrusel-upload" data-dismiss="modal">
            <i class="fa fa-times"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-carrusel-upload" id="btnGuardarRequisito">
            <i class="fa fa-save"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="../public/js/requisitos.js"></script>

<?php include("partials/footer_Admin.php"); ?>