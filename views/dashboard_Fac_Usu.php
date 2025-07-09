<?php include("partials/header_Admin.php"); ?>
<?php 
$rolesPermitidos = ['DOCENTE', 'ESTUDIANTE', 'INVITADO'];
include("../core/auth.php")?>


<div id="page-wrapper">
  <div id="page-inner">
  <div class="inscripciones-wrapper">
  <h2 class="titulo-inscripcion">📥 INSCRIPCIONES</h2>


  <table id="tablaInscripciones" class="table table-bordered table-striped" style="width: 100%; text-align: center;">
  <thead>
    <tr>
      <th>Orden</th>
      <th>Curso</th>
      <th>Factura</th>
      <th>Estado Inscripción</th>
      <th>Fecha Inscripción</th>
    </tr>
  </thead>
</table>

</div>
  </div>
</div>
<style>
.inscripciones-wrapper {
  font-family: Arial, sans-serif;
  padding: 20px;
}

.titulo-inscripcion {
  text-align: center;
  font-size: 20px;
  margin-bottom: 15px;
}

.acciones-inscripcion {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
  justify-content: center;
}

.btn-inscribir {
  background-color: #e74c3c;
  color: white;
  padding: 8px 16px;
  border: none;
  font-weight: bold;
  border-radius: 5px;
  cursor: pointer;
}

.btn-anular {
  background-color: #2ecc71;
  color: white;
  padding: 8px 16px;
  border: none;
  font-weight: bold;
  border-radius: 5px;
  cursor: pointer;
}

.tabla-inscripciones {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.tabla-inscripciones th,
.tabla-inscripciones td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: center;
  vertical-align: middle;
}

.tabla-inscripciones th {
  background-color: #f9f9f9;
}

.btn-ver-factura {
  background-color: #3498db;
  color: white;
  text-decoration: none;
  padding: 5px 10px;
  font-size: 13px;
  border-radius: 5px;
  display: inline-block;
}

.btn-ver-factura:hover {
  background-color: #2980b9;
}

.progreso.verde {
  background-color: #2ecc71;
  color: white;
  padding: 3px 10px;
  border-radius: 15px;
  font-weight: bold;
}

.estado-completo {
  color: green;
  font-weight: bold;
}
</style>

 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/misInscripciones.js"></script>

<?php include("partials/footer_Admin.php"); ?>
