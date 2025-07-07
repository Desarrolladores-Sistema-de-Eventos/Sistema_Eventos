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

    <!-- SELECT EVENTO EN FILA -->
    <div class="evento-select-row" style="display: flex; align-items: center; gap: 10px; margin-bottom: 40px; justify-content: center;">
      <label for="selectEvento" class="evento-label">
        <i class="fa fa-search"></i> Evento:
      </label>
      <select id="selectEvento" class="selectEvento"></select>
    </div>
    <hr/>

    <div class="titulo-linea"></div>

    <!-- TABLA -->
    <div class="table-responsive mt-4">
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

  .evento-select-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
  }

  .evento-label {
    font-weight: normal;
  font-size: 16px;
  
}

 hr {
    border-top: 2px solid rgb(185, 51, 51);
    opacity: 1;
  }

  #tabla-certificados {
    font-size: 14px;
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
    font-weight: normal;
  font-size: 14px;

  }

  .btn-primary:hover {
    background-color: rgb(185, 51, 51);
    border-color: #000;
  }

  .btn-secondary {
    background-color: #888;
    border-color: #444;
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

  @media (max-width: 600px) {
    .titulo-barra {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
    }
    .evento-select-row {
      flex-direction: column;
      align-items: flex-start;
      gap: 6px;
    }
    .select2-container, .select2-dropdown {
      max-width: 100% !important;
      min-width: 140px;
    }
    
  }

  div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: #9b2e2e !important;
  border-color: #9b2e2e !important;
  color: white !important;
  box-shadow: none !important;
  outline: none !important;
}
.dataTables_length label,
.dataTables_length select {
  font-size: 14px !important;
}
#selectEvento {
  max-height: 90px; 
  overflow-y: auto;
  min-width: 220px;
  max-width: 350px;
  font-size: 14px;
  padding: 4px 8px;
  border: 2px solid #9b2e2e; 
  border-radius: 6px;
}

#selectEvento option {
  padding: 4px 8px;
  height: 28px;
  font-size: 14px;
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

