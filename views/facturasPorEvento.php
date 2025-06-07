<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php")?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2><i class="fa fa-file-text-o"></i> Mis Facturas por Eventos</h2>
            </div>
        </div>
        <hr />
        <div class="panel panel-default">
            <div class="panel-heading">Lista de Facturas</div>
            <div class="panel-body">
                <br><br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-facturas">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Evento</th>
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Aquí iría tu lógica PHP para obtener las facturas de la base de datos
                            // (Ejemplo con datos estáticos para la demostración, basados en la imagen)
                            $facturas = [
                                [
                                    'id' => '0001',
                                    'evento' => 'Taller de Liderazgo',
                                    'monto' => 20.00,
                                    'estado' => 'Pagada',
                                    'factura_path' => 'invoices/taller_liderazgo_0001.pdf' // Placeholder path
                                ],
                                [
                                    'id' => '0002',
                                    'evento' => 'Congreso de Ciencia',
                                    'monto' => 35.00,
                                    'estado' => 'Pendiente',
                                    'factura_path' => 'invoices/congreso_ciencia_0002.pdf' // Placeholder path
                                ]
                            ];
                            // FIN DE EJEMPLO DE DATOS ESTATICOS

                            foreach ($facturas as $factura) {
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($factura['id']); ?></td>
                                    <td><?php echo htmlspecialchars($factura['evento']); ?></td>
                                    <td>$<?php echo htmlspecialchars(number_format($factura['monto'], 2)); ?></td>
                                    <td><?php echo htmlspecialchars($factura['estado']); ?></td>
                                    <td class="text-center">
                                        <?php if ($factura['estado'] == 'Pagada') { // Only show download if paid ?>
                                            <a href="<?php echo htmlspecialchars($factura['factura_path']); ?>" class="btn btn-primary btn-sm" download>
                                                <i class="fa fa-download"></i> Descargar
                                            </a>
                                        <?php } else { ?>
                                            <span class="text-muted">No disponible</span>
                                        <?php } ?>
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