<?php include("partials/header_Admin.php"); ?>
<?php 
$requiereResponsable = true;
include("../core/auth.php")?>
<div id="page-wrapper">
  <div id="page-inner">
        <div class="row">
          <div class="col-md-12">
            <h2 class="titulo-notas"><i class="fa fa-graduation-cap"></i> Registro de Calificaciones</h2>
          </div>
        </div><hr/>
              <div class="row">
                <div class="col-md-3"><b>Evento:</b> <span id="titulo-evento"></span></div>
                <div class="col-md-3"><b>Fecha:</b> <span id="fecha-evento"></span></div>
                <div class="col-md-3"><b>Tipo:</b> <span id="tipo-evento"></span></div>
                <div class="col-md-3"><b>Total Inscritos:</b> <span id="total-inscritos"></span></div>
              </div><hr/>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="tablas-notas">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre y Apellido</th>
                                <th>Asistencia</th>
                                <th>Nota Final</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se llenarán las filas con JavaScript -->
                        </tbody>
                    </table>
              </div><hr/>
        <div>
        <a href="dashboard_NotasAsistencia_Res.php" class="btn btn-secondary mt-2"><i class="fa fa-arrow-left"></i> Volver a eventos</a>
      </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/asi_Not_Res.js"></script>
<?php include("partials/footer_Admin.php"); ?>