<?php include("partials/header_Admin.php"); ?>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
                    <div class="col-md-12">
                      <h2><i class="fa fa-dashboard fa"></i>Panel Principal</h2>
                        <h5>Welcome Pepe </h5>
                     </div> 
                    </div>
                      <hr />
                <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <i class="fa fa-edit"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">20</p>
                    <p class="text-muted">Inscritos</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-calendar"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">30</p>
                    <p class="text-muted">Eventos</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-user"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">40</p>
                    <p class="text-muted"> Pendientes</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-brown set-icon">
                    <i class="fa fa-bar-chart-o"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">2 </p>
                    <p class="text-muted">Reportes</p>
                </div>
             </div>
		     </div>
			</div>
       <hr />
   <!-- /. ROW  -->
<div class="row">
      <!-- Gráfico de barras -->
    <div class="col-md-6 col-sm-12 col-xs-12">                     
        <div class="panel panel-default">
            <div class="panel-heading">
                Inscripciones por Evento.
            </div>
            <div class="panel-body">
                <div id="eventos-morris-bar-chart"></div>
            </div>
        </div>            
    </div> 
    <!-- Nuevo gráfico donut al lado derecho -->
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Estado de Inscripciones
            </div>
            <div class="panel-body text-center">
                <div id="inscripciones-donut-chart" style="height: 200px; margin: auto;"></div>
            </div>
        </div>
    </div>
</div>
<hr/>
<!-- /. ROW -->
<!-- /. ROW  -->
             <div class="row"> 
    <!-- Gráfico area -->
    <div class="col-md-6 col-sm-12 col-xs-12">                     
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Certificados emitidos por Evento.
                        </div>
                        <div class="panel-body">
                            <div id="morris-area-chart"></div>
                        </div>
                    </div>            
                </div> 
<!-- /. ROW  -->
  </div>
</div>

<?php include("partials/footer_Admin.php"); ?>
