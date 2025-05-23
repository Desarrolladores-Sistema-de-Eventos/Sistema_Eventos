<?php include("partials/header_Admin.php"); ?>


<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
                    <div class="col-md-12">
                      <h2><i class="fa fa-dashboard fa"></i>Panel Principal</h2>
                        <h5>Welcome Andrea </h5>
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
                    <p class="text-muted">Inscriptos</p>
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
    <!-- Tabla existente (sin modificar) -->
    <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
               Inscripciones Pendientes
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm"><i class="fa fa-eye" style="color: black;"></i> Ver Detalle</button>  
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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

<script>
Morris.Donut({
        element: 'inscripciones-donut-chart',
        data: [
            { label: "Pendientes", value: 12 },
            { label: "Aprobadas", value: 30 },
            { label: "Rechazadas", value: 5 }
        ],
        colors: ['#f0ad4e', '#5cb85c', '#d9534f'],
        resize: true
    });
Morris.Bar({
  element: 'eventos-morris-bar-chart',
  data: [
    { y: 'Congreso de Tecnología 2024', total: 120 },
    { y: 'Taller de Robótica', total: 85 },
    { y: 'Seminario de IA', total: 95 },
    { y: 'Curso de Python Avanzado', total: 110 },
    { y: 'Webinar Ciberseguridad', total: 70 }
  ],
  xkey: 'y',
  ykeys: ['total'],
  labels: ['Inscripciones'],
  barColors: ['#1abc9c'],
  hideHover: 'auto',
  resize: true
});

Morris.Area({
  element: 'morris-area-chart',
  data: [
    { y: '2020', congreso: 45, taller: 30, webinar: 20 },
    { y: '2021', congreso: 60, taller: 35, webinar: 28 },
    { y: '2022', congreso: 70, taller: 50, webinar: 40 },
    { y: '2023', congreso: 85, taller: 55, webinar: 45 },
    { y: '2024', congreso: 95, taller: 65, webinar: 58 }
  ],
  xkey: 'y',
  ykeys: ['congreso', 'taller', 'webinar'],
  labels: ['Congresos', 'Talleres', 'Webinars'],
  lineColors: ['#1abc9c', '#3498db', '#f39c12'],
  fillOpacity: 0.5,
  behaveLikeLine: true,
  hideHover: 'auto',
  resize: true,
  pointSize: 4,
  smooth: true
});

</script>

    
    
</script>
