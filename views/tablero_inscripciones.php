<?php include("partials/head_Admin.php"); ?>

<style>
    

html, body {
    height: 100%;
    margin: 0;
    overflow: hidden; /* esto bloquea el scroll global */
}




/* Barra superior */
.navbar-cls-top {
    position: fixed;
    top: 0;
    width: 100%;
    height: 50px;
    z-index: 1001;
}

/* Contenedor del contenido */
#page-wrapper {
    margin-left: 250px;
    margin-top: 50px;
    height: calc(100vh - 50px);
    overflow-y: auto;
    padding: 20px;
    background-color: #f8f9fa;
}
</style>

<div id="page-wrapper">
    <div id="page-inner">

        <h2 style="color: #007bff;">Gestión de Inscripciones</h2>
        <h5>Revisa y administra las solicitudes de inscripción a eventos.</h5>
        <hr />

        <!-- Filtros -->
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Buscar por evento">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Buscar por usuario">
            </div>
        </div>

        <!-- Tabs por estado -->
        <ul class="nav nav-tabs mb-3" id="estadoTabs">
    <li class="nav-item">
        <a class="nav-link active text-warning font-weight-bold" data-toggle="tab" href="#pendiente">Pendientes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-success font-weight-bold" data-toggle="tab" href="#aprobado">Aprobados</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger font-weight-bold" data-toggle="tab" href="#rechazado">Rechazados</a>
    </li>
</ul>


        <div class="tab-content">
            <!-- Pendientes -->
            <div class="tab-pane fade show active" id="pendiente">
                <div class="table-responsive">
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
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detalleModal">Ver</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Paginación mock -->
                <nav>
                    <ul class="pagination justify-content-center mt-2">
                        <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                    </ul>
                </nav>
            </div>

            <!-- Aprobados -->
            <div class="tab-pane fade" id="aprobado">
                <div class="table-responsive">
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
                                <td>Expo Ciencia 2025</td>
                                <td>Carlos Ruiz</td>
                                <td>2025-04-18</td>
                                <td><span class="badge badge-success">Aprobado</span></td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detalleModal">Ver</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rechazados -->
            <div class="tab-pane fade" id="rechazado">
                <div class="table-responsive">
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
                                <td>Foro Innovación</td>
                                <td>Ana Torres</td>
                                <td>2025-03-10</td>
                                <td><span class="badge badge-danger">Rechazado</span></td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detalleModal">Ver</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal detalle -->
        <div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="detalleLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detalleLabel">Detalle de Inscripción</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de visualización -->
                        <form>
                            <div class="form-group">
                                <label>Nombre completo</label>
                                <input type="text" class="form-control" readonly value="Lucía Gómez">
                            </div>
                            <div class="form-group">
                                <label>Evento</label>
                                <input type="text" class="form-control" readonly value="Conferencia Web 2025">
                            </div>
                            <div class="form-group">
                                <label>Fecha de inscripción</label>
                                <input type="text" class="form-control" readonly value="2025-05-21">
                            </div>
                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" class="form-control" readonly value="Pendiente">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- Cierre page-inner -->
</div> <!-- Cierre page-wrapper -->

<?php include("partials/footer_Admin.php"); ?>
