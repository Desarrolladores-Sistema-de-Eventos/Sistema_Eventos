<?php include("partials/header_Admin.php"); ?>
<?php 
$requiereResponsable = true;
include("../core/auth.php"); ?>
<div id="page-wrapper">
  <div id="page-inner">
    <!-- TÍTULO -->
    <div class="titulo-barra">
      <h2><i class="fa fa-certificate"></i> Gestión de Certificados</h2>
      <button id="btnGenerarTodos" class="btn btn-primary">
        <i class="fa fa-file-pdf-o"></i> Generar Certificados
      </button>
    </div>
    <div class="titulo-linea"></div>

    <div class="row" style="margin-top: 30px;">
      <!-- Sidebar: Selector de eventos -->
      <div class="col-md-4 col-lg-3" id="sidebar-evento">
        <div class="evento-select-sidebar" style="background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(155,46,46,0.08); padding: 24px 18px; margin-bottom: 20px;">
          <label for="selectEvento" class="evento-label" style="font-size: 16px; font-weight: 600; color: #9b2e2e;">
            <i class="fa fa-search"></i> Seleccione Evento:
          </label>
          <select id="selectEvento" class="selectEvento" style="width: 100%; margin-top: 10px;"></select>
        </div>
      </div>
      <!-- Contenido principal: Tabla -->
      <div class="col-md-8 col-lg-9">
        <div class="table-responsive mt-2">
          <table id="tabla-certificados" class="table table-bordered">
            <thead>
              <tr>
                <th>Cédula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              <!-- JS llenará esta parte -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
body {
  background-color: #fff;
  color: #000;
  font-family: Arial, sans-serif;
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

.titulo-linea {
  border-bottom: 2px solid rgb(185, 51, 51);
  margin-top: 6px;
  margin-bottom: 20px;
}

.evento-select-sidebar {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(155,46,46,0.08);
  padding: 24px 18px;
  margin-bottom: 20px;
}

.evento-label {
  font-weight: 600;
  font-size: 16px;
  color: #9b2e2e;
}

#selectEvento {
  max-height: 160px;
  overflow-y: auto;
  min-width: 180px;
  max-width: 100%;
  font-size: 15px;
  padding: 6px 10px;
  border: 2px solid #9b2e2e;
  border-radius: 6px;
  margin-top: 10px;
  width: 100%;
  background: #fff;
  box-sizing: border-box;
}

#selectEvento option {
  padding: 8px 8px;
  height: 38px;
  font-size: 15px;
  display: flex;
  align-items: center;
  border-bottom: 1px solid #eee;
  background: #fff;
}

#selectEvento option:last-child {
  border-bottom: none;
}

.table-responsive {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(155,46,46,0.08);
  padding: 18px 12px;
  max-height: 370px;
  overflow-y: auto;
  overflow-x: hidden; /* Oculta scroll horizontal */
}

#tabla-certificados {
  font-size: 14px;
  margin-bottom: 0;
  width: 100%;
  table-layout: auto;
  min-width: 0;
}

#tabla-certificados {
  font-size: 14px;
  margin-bottom: 0;
}

#tabla-certificados thead th {
  background-color:rgb(185, 51, 51);
  color: white;
  text-align: center;
  vertical-align: middle;
  font-size: 14px;
  font-weight: normal;
}

#tabla-certificados td,
#tabla-certificados th {
  text-align: center;
  vertical-align: middle;
}

.btn-primary {
  background-color: rgb(185, 51, 51);
  border-color: #000;
  font-weight: 600;
  transition: 0.2s ease-in-out;
  font-size: 14px;
}

.btn-primary:hover {
  background-color: rgb(185, 51, 51);
  border-color: #000;
}

.titulo-barra {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0;
  margin-top: 10px;
}
label{
  font-weight: normal;
  font-size: 14px;
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
    border-color: #9b2e2e!important;
    color: #fff !important;
    box-shadow: none !important;
    outline: none !important;
  }
  .select2-container--default .select2-results__option--highlighted[aria-selected] {
  background-color:rgb(184, 46, 46) !important; /* Rojo institucional */
  color: #fff !important;
}
#btnGenerarTodos:disabled,
#btnGenerarTodos[disabled] {
  background-color: #b93333 !important;
  border-color: #b93333 !important;
  color: #fff !important;
  opacity: 0.7;
  cursor: not-allowed;
}
</style>

<!-- LIBRERÍAS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script src="../public/js/certificado.js"></script>

<?php include("partials/footer_Admin.php"); ?>

