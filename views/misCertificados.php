<?php include("partials/header_User.php"); ?>

<div class="container mt-4">
    <h2><i class="fa fa-certificate"></i> Mis Certificados</h2>
    <div class="table-responsive">
        <table id="tabla-certificados-usuario" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Evento</th>
                    <th>Certificado</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                <!-- JS llena aquí -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/certificado.js"></script>
<script>
    // Cambia el ID del usuario según corresponda (puedes obtenerlo de la sesión en PHP)
    const idUsuario = <?php echo $_SESSION['usuario']['SECUENCIAL']; ?>;
    listarCertificadosPorUsuario(idUsuario);
</script>
<?php include("partials/footer_User.php"); ?>