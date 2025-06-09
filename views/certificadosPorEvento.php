<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2><i class="fa fa-certificate"></i> Mis Certificados</h2>
            </div>
        </div>
        <hr />
        <div class="panel panel-default">
            <div class="panel-heading">Lista de Certificados</div>
            <div class="panel-body">
                <br><br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-certificados">
                        <thead>
                            <tr>
                                <th>Orden</th>
                                <th>Curso</th>
                                <th>Correo</th>
                                <th>Certificados y Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Aquí iría tu lógica PHP para obtener los certificados de la base de datos
                            // (Ejemplo con datos estáticos para la demostración, basados en la imagen)
                            $certificados = [
                                [
                                    'orden' => '6656',
                                    'curso' => 'VI CONGRESO INTERNACIONAL DE CIENCIA DE LA COMPUTACIÓN, ELECTRÓNICA E INGENIERÍA INDUSTRIAL CESI 2024',
                                    'correo' => 'CUIRADO5796@...',
                                    'certificado_participacion_link' => 'certificates/participacion_6656.pdf', // Placeholder
                                    'certificado_aprobacion_link' => 'certificates/aprobacion_6656.pdf', // Placeholder
                                    'registro_fecha' => '2023-10-16 17:24:46'
                                ],
                                [
                                    'orden' => 'Z446',
                                    'curso' => 'V CONGRESO INTERNACIONAL DE CIENCIA DE LA COMPUTACIÓN, ELECTRÓNICA E INGENIERÍA INDUSTRIAL',
                                    'correo' => 'CUIRADO5796@...',
                                    'certificado_participacion_link' => 'certificates/participacion_Z446.pdf', // Placeholder
                                    'certificado_aprobacion_link' => 'certificates/aprobacion_Z446.pdf', // Placeholder
                                    'registro_fecha' => '2023-10-16 17:24:46'
                                ]
                            ];
                            // FIN DE EJEMPLO DE DATOS ESTATICOS

                            foreach ($certificados as $certificado) {
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($certificado['orden']); ?></td>
                                    <td><?php echo htmlspecialchars($certificado['curso']); ?></td>
                                    <td><?php echo htmlspecialchars($certificado['correo']); ?></td>
                                    <td>
                                        <p>
                                            Certificado 1: Participación
                                            <a href="<?php echo htmlspecialchars($certificado['certificado_participacion_link']); ?>" target="_blank" class="btn btn-xs btn-default"><i class="fa fa-download"></i></a>
                                        </p>
                                        <p>
                                            Certificado 2: Aprobación
                                            <a href="<?php echo htmlspecialchars($certificado['certificado_aprobacion_link']); ?>" target="_blank" class="btn btn-xs btn-default"><i class="fa fa-download"></i></a>
                                        </p>
                                        <p>Registro: <?php echo htmlspecialchars($certificado['registro_fecha']); ?></p>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTables if you are using it (uncomment if you add the CDN links)
        // $('#dataTables-facturas').DataTable();
        // $('#dataTables-certificados').DataTable();
    });
</script>

<?php include("partials/footer_Admin.php"); ?>