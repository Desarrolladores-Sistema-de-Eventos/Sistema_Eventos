<?php include("partials/header_Admin.php"); ?>

<div id="page-wrapper">
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h2><i class="fa fa-users"></i> Gestión de Usuarios</h2>
        </div>
    </div> 
    <hr /> 
    <div class="panel panel-default">
        <div class="panel-heading">
            Lista de Usuarios
        </div>
        <div class="panel-body">
            <a href="#" class="btn btn-custom" data-toggle="modal" data-target="#myModal"><span class="icon-circle"><i class="fa fa-plus"></i></span> NUEVO</a>
            <br><br>
            <!-- Tabla de usuarios -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-users">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUsuarios">
                        <!-- Filas dinámicas aquí -->
                    </tbody>
                </table>
            </div>
            <!-- Fin de la tabla -->
        </div>
    </div>

    <!-- Modal para registro/edición de usuario -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Dentro de tu modal, antes de <form ...> -->
<div id="userFormError" class="alert alert-danger" style="display:none;"></div>
                <form role="form" id="userForm" autocomplete="off">
<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Registro de Usuario</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" name="nombre" placeholder="Ingrese nombre" required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo letras y espacios">
          </div>
          <div class="form-group">
            <label>Apellido</label>
            <input type="text" class="form-control" name="apellido" placeholder="Ingrese apellido" required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo letras y espacios">
          </div>
          <div class="form-group">
            <label>Fecha de Nacimiento</label>
            <input type="date" class="form-control" name="fecha_nacimiento" required max="<?php echo date('Y-m-d'); ?>">
          </div>
          <div class="form-group">
            <label>Teléfono</label>
            <input type="text" class="form-control" name="telefono" placeholder="Ingrese número de teléfono" required pattern="^\d{10}$" maxlength="10" title="Ingrese 10 números">
          </div>
          <div class="form-group">
            <label>Dirección</label>
            <input type="text" class="form-control" name="direccion" placeholder="Ingrese dirección" required pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s\.,#\-]+$" title="Solo letras, números y algunos símbolos">
          </div>
          <div class="form-group">
            <label>Correo electrónico</label>
            <input type="email" class="form-control" name="correo" placeholder="Ingrese correo electrónico" required>
          </div>
          <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" name="contrasena" placeholder="Ingrese contraseña" required>
          </div>
          <div class="form-group">
            <label>Rol</label>
            <select class="form-control" name="rol" required>
              <option value="ADM">Administrador</option>
              <option value="AUT">Autoridad</option>
              <option value="DOC">Docente</option>
              <option value="EST">Estudiante</option>
              <option value="INV">Invitado</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
<button type="submit" class="btn btn-success" id="btnActualizar" style="display:none;">Actualizar</button>
        </div>                     
                </form>
            </div>
        </div>
    </div>
    <!-- Fin del Modal -->

</div> <!-- Cierre de page-inner -->
</div> <!-- Cierre de page-wrapper -->

<!-- IMPORTANTE: Carga de scripts en el orden correcto -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>



<!-- Tu script de usuarios (ÚLTIMO) -->
<script src="../public/js/usuario.js"></script>

<?php include("partials/footer_Admin.php"); ?>