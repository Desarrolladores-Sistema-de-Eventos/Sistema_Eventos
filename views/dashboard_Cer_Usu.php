<?php include("partials/header_Admin.php"); ?>
<?php 
$rolesPermitidos = ['DOCENTE', 'ESTUDIANTE', 'INVITADO'];
include("../core/auth.php")?>

<div id="page-wrapper">
  <div id="page-inner">
    
    <div class="certificados-wrapper">
      <h2 class="titulo-cert">CERTIFICADOS</h2>

    
     <table id="tablaCertificados">
  <thead>
    <tr>
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
body {
  background-color: #fff;
  color: #000;
  font-family: Arial, sans-serif;
}

:root {
  --uta-rojo: #c0392b;
  --uta-negro: #000;
  --uta-blanco: #fff;
  --azul-profesional: #0066cc;
}

/* Título */
.titulo-cert {
  font-size: 26px;
  text-align: center;
  color: var(--uta-negro);
  font-weight: bold;
  margin-bottom: 30px;
  letter-spacing: 0.5px;
  text-transform: uppercase;
}

/* Tabla */
#tablaCertificados {
  width: 100%;
  border-collapse: collapse;
  font-size: 15px;
  background-color: var(--uta-blanco);
  border: 1px solid #ddd;
}

#tablaCertificados thead {
  background-color: rgb(180, 34, 34);
  color: white;
}
#tablaCertificados th,
#tablaCertificados td {
  padding: 12px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ddd;
  background-color::rgb(180, 34, 34); 
  font-size: 14px;
}


/* Badge tipo certificado */
.badge {
  display: inline-block;
  padding: 6px 14px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: bold;
  color: #fff;
  background-color: var(--azul-profesional);
}



.btn-certificado i {
  margin-right: 5px;
}

/* Paginador personalizado */
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: #c0392b !important;
  border-color: #c0392b !important;
  color: white !important;
  box-shadow: none !important;
  outline: none !important;
}


/* Filtro y cantidad de registros */
.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
  padding: 6px 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 14px;
}
#tablaCertificados tbody td {
  background-color: #fff !important;
}

  .btn-primary {
    background: #9b2e2e;
    border: none;
    font-weight: 600;
    border-radius: 6px;
    transition: background 0.2s;
  }
  .btn-primary:hover {
    background: #7b2020;
  }
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: #c0392b !important;
  border-color: #c0392b !important;
  color: white !important;
  box-shadow: none !important;
  outline: none !important;
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
  background-color::rgb(180, 34, 34); 
  font-size: 14px;
}
h4 {
  font-size: 14px;
  
}
label{
  font-weight: normal;
  font-size: 16px;
}
p{
  font-size: 14px;
  font-weight: normal;
}
.dataTables_length label,
.dataTables_length select {
  font-size: 14px !important;
}

/* Responsive */
@media (max-width: 768px) {
  #tablaCertificados {
    font-size: 13px;
  }

  .titulo-cert {
    font-size: 20px;
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
