
<?php include("partials/header_Admin.php"); ?>
<?php 
$requiereResponsable = true;
include("../core/auth.php")?>


<div id="page-wrapper">
  <div id="page-inner">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        <h2><i class="fa fa-check-square-o fa"></i> Gestión de Notas</h2>
        </div>
    </div> 
    <hr />
    <div class="row" id="contenedor-eventos" style="display: flex; flex-wrap: wrap;">   
        </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/asi_Not_Res.js"></script>
<?php include("partials/footer_Admin.php"); ?>

