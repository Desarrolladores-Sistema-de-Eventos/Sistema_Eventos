<!-- tablero_Inscripciones.php -->
<?php include("partials/head_Admin.php"); ?>

<div id="page-wrapper">
<div id="page-inner">

<h2 style="color: #007bff;">Gestión de Inscripciones</h2>
<h5>Revisa y administra las solicitudes de inscripción a eventos.</h5>
<hr />

<!-- Contenido principal -->
<div class="container mt-4">
    <!-- Filtros -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Buscar por evento">
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Buscar por usuario">
        </div>
    </div>

    <!-- Tabla de inscripciones -->
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Evento</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Conferencia Web 2025</td>
                <td>Lucía Gómez</td>
                <td>2025-05-21</td>
                <td><span class="badge badge-warning">Pendiente</span></td>
                <td>
                    <button class="btn btn-success btn-sm">Aprobar</button>
                    <button class="btn btn-danger btn-sm">Rechazar</button>
                </td>
            </tr>
            <!-- Puedes agregar más filas dinámicamente con PHP -->
        </tbody>
    </table>
</div>
<!-- Fin contenido -->

</div> <!-- Cierre de page-inner -->
</div> <!-- Cierre de page-wrapper -->

<?php include("partials/footer_Admin.php"); ?>
