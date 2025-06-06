<?php include("partials/header_Admin.php");?>
<?php 
$requiereResponsable = true;
include("../core/auth.php")?>
<div id="page-wrapper">
  <div id="page-inner">
<div class="container">
    <h2 class="text-center" style="margin-top:30px; color:#002856;">
        <i class="fa fa-bar-chart"></i> Reportes de Eventos a Cargo
    </h2>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label for="select-evento"><b>Selecciona un evento:</b></label>
            <select id="select-evento" class="form-control"></select>
        </div>
        <div class="col-md-6">
            <div id="estadisticas-evento" class="estadisticas-box"></div>
        </div>
    </div>
    <hr>

    <!-- Inscritos -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-users"></i> Inscritos al Evento
            <button id="btn-descargar-inscritos" class="btn btn-success btn-xs pull-right descargar-btn">
                <i class="fa fa-download"></i> CSV
            </button>
            <button id="btn-descargar-inscritos-pdf" class="btn btn-danger btn-xs pull-right descargar-btn">
                <i class="fa fa-file-pdf-o"></i> PDF
            </button>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="tabla-inscritos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Carrera</th>
                            <th>Estado</th>
                            <th>Fecha Inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- JS llenará aquí -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Asistencia y Notas -->
    <div class="panel panel-info">
        <div class="panel-heading">
            <i class="fa fa-check-square-o"></i> Asistencia y Notas
            <button id="btn-descargar-asistencia" class="btn btn-success btn-xs pull-right descargar-btn">
                <i class="fa fa-download"></i> CSV
            </button>
            <button id="btn-descargar-asistencia-pdf" class="btn btn-danger btn-xs pull-right descargar-btn">
                <i class="fa fa-file-pdf-o"></i> PDF
            </button>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="tabla-asistencia" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Asistencia</th>
                            <th>Nota Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- JS llenará aquí -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Certificados emitidos -->
    <div class="panel panel-success">
        <div class="panel-heading">
            <i class="fa fa-certificate"></i> Certificados Emitidos
            <button id="btn-descargar-certificados" class="btn btn-success btn-xs pull-right descargar-btn">
                <i class="fa fa-download"></i> CSV
            </button>
            <button id="btn-descargar-certificados-pdf" class="btn btn-danger btn-xs pull-right descargar-btn">
                <i class="fa fa-file-pdf-o"></i> PDF
            </button>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="tabla-certificados" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>URL Certificado</th>
                            <th>Fecha Emisión</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- JS llenará aquí -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<style>
        body {
            background: #f5f6fa;
        }
        .panel-primary {
            border-color:rgb(8, 8, 8);
        }
        .panel-primary > .panel-heading {
            background-color:rgb(0, 0, 0);
            color: #fff;
        }
        .panel-info {
            border-color: #002856;
        }
        .panel-info > .panel-heading {
            background-color: #002856;
            color: #fff;
        }
        .panel-success {
            border-color: #ffb300;
        }
        .panel-success > .panel-heading {
            background-color: #ffb300;
            color: #fff;
        }
        .panel-footer { background: #f5f5f5; }
        .table th, .table td { vertical-align: middle !important; }
        .descargar-btn { margin-bottom: 10px; margin-left: 5px; }
        .estadisticas-box {
            background: #fffde7;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 6px solid #d32f2f;
        }
        .btn-danger {
            background-color: #d32f2f;
            border-color: #d32f2f;
        }
        .btn-danger:hover, .btn-danger:focus {
            background-color: #b71c1c;
            border-color: #b71c1c;
        }
    </style>

<!-- JS y dependencias -->

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.0/jspdf.plugin.autotable.min.js"></script>
<!-- Tu JS de reportes -->
<script src="../public/js/reportes_responsable.js"></script>
<?php include("partials/footer_Admin.php"); ?>