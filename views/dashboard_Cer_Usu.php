<?php include("partials/header_Admin.php"); ?>
<?php 
$rolesPermitidos = ['DOCENTE', 'ESTUDIANTE', 'INVITADO'];
include("../core/auth.php")?>

<div id="page-wrapper">
  <div id="page-inner">
    
    <div class="certificados-wrapper">
      <h2 class="titulo-cert">📄 CERTIFICADOS</h2>

    
     <table id="tablaCertificados" class="display" style="width:100%">
  <thead>
    <tr>
      <th>Orden</th>
      <th>Curso</th>
      <th>Correo</th>
      <th>Certificado</th>
      <th>Tipo</th>
      <th>Fecha Registro</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>
 
    </div>

  </div>
</div>

<style>
.certificados-wrapper {
  padding: 20px;
  font-family: Arial, sans-serif;
}
#tablaCertificados td,
#tablaCertificados th {
  text-align: center;
  vertical-align: middle;
}


.titulo-cert {
  font-size: 20px;
  text-align: center;
  margin-bottom: 20px;
}

.tabla-certificados {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.tabla-certificados th,
.tabla-certificados td {
  border: 1px solid #ccc;
  padding: 10px;
  vertical-align: middle;
  text-align: center;
}

.tabla-certificados th {
  background: #f3f3f3;
  font-weight: bold;
}

.btn-factura {
  display: inline-block;
  text-decoration: none;
  padding: 6px 10px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: bold;
  color: #fff;
}

.btn-factura.pdf {
  background: #d9534f;
}

.btn-factura.pdf span {
  display: block;
  font-size: 10px;
}

.btn-factura.xml {
  background: #f0ad4e;
}

.badge {
  padding: 5px 10px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: bold;
  display: inline-block;
  color: white;
}

.badge.blue {
  background: #17a2b8;
}

.badge.orange {
  background: #f36f21;
}

@media screen and (max-width: 768px) {
  .tabla-certificados {
    font-size: 12px;
  }

  .btn-factura {
    padding: 4px 8px;
  }
}
</style>

<!-- Scripts necesarios -->
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
<script src="../public/js/misCertificados.js"></script>

<?php include("partials/footer_Admin.php"); ?>
