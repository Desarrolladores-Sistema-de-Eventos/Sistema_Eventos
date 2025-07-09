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
  background-color: var(--uta-blanco); /* Changed to white */
  color: var(--uta-negro); /* Changed to black */
  font-family: Arial, sans-serif;
}

:root {
  --uta-rojo: #b10024; /* Primary Red */
  --uta-negro: #1a1a1a; /* Secondary Black */
  --uta-blanco: #ffffff; /* Complementary White */
  --uta-gris-claro: #f8f9fa; /* Light gray for background details */
  --azul-profesional: #0066cc; /* Kept for specific badge if needed, but consider aligning with new palette */
}

/* Título */
.titulo-cert {
  font-size: 26px;
  text-align: center;
  color: var(--uta-negro); /* Title in black */
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
  background-color: var(--uta-blanco); /* Table background in white */
  border: 1px solid #ddd; /* Light gray border for table */
}

#tablaCertificados thead {
  background-color: var(--uta-rojo); /* Table header in primary red */
  color: var(--uta-blanco); /* Header text in white */
}

#tablaCertificados th,
#tablaCertificados td {
  padding: 12px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ddd;
  /* background-color property removed from here, as it's set for tbody td or thead */
  font-size: 14px;
}

/* Badge tipo certificado */
.badge {
  display: inline-block;
  padding: 6px 14px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: bold;
  color: var(--uta-blanco); /* Badge text in white */
  background-color: var(--uta-rojo); /* Badge background in primary red */
}

.btn-certificado i {
  margin-right: 5px;
}

/* Paginador personalizado */
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: var(--uta-rojo) !important; /* Paginator active state in primary red */
  border-color: var(--uta-rojo) !important;
  color: var(--uta-blanco) !important; /* Paginator text in white */
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
  background-color: var(--uta-blanco) !important; /* Table body cells in white */
  color: var(--uta-negro); /* Table body text in black */
}

.btn-primary {
  background: var(--uta-rojo); /* Primary button in primary red */
  border: none;
  font-weight: 600;
  border-radius: 6px;
  transition: background 0.2s;
  color: var(--uta-blanco); /* Button text in white */
}

.btn-primary:hover {
  background: #a0001f; /* Slightly darker red on hover */
}

/* Redundant rule, already covered above but kept for specificity if needed */
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: var(--uta-rojo) !important;
  border-color: var(--uta-rojo) !important;
  color: var(--uta-blanco) !important;
  box-shadow: none !important;
  outline: none !important;
}

thead {
  background-color: var(--uta-rojo); /* Header background in primary red */
  color: var(--uta-blanco); /* Header text in white */
  font-size: 14px;
  font-weight: normal;
}

th {
  padding: 12px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ddd;
  background-color: var(--uta-rojo); /* Table header cells in primary red */
  font-size: 14px;
  font-weight: normal;
}

td {
  padding: 12px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ddd;
  /* background-color property removed, handled by tbody td */
  font-size: 14px;
  color: var(--uta-negro); /* Table body cells text in black */
}

h4 {
  font-size: 14px;
}

label{
  font-weight: normal;
  font-size: 16px;
  color: var(--uta-negro); /* Labels in black */
}

p{
  font-size: 14px;
  font-weight: normal;
  color: var(--uta-negro); /* Paragraphs in black */
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