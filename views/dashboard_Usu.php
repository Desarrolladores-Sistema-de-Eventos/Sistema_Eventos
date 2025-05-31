<?php include("partials/header_Admin.php"); ?>
<div id="page-wrapper">
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
        <h2><i class="fa fa-users"></i>Gestion Usuarios</h2>
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
            <!--  Table-->
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
            <!-- Fin de la tabla -->
        </div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" id="userForm">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Registro Usuario</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" name="nombre" placeholder="Ingrese nombre" required>
          </div>
            <div class="form-group">
            <label>Apellido</label>
            <input type="text" class="form-control" name="apellido" placeholder="Ingrese apellido" required>
          </div>
            <div class="form-group">
                <label>Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="fecha_nacimiento" required>
          </div>
            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" class="form-control" name="telefono" placeholder="Ingrese número de teléfono" required>
          </div>
            <div class="form-group">
                <label>Dirección</label>
                <input type="text" class="form-control" name="direccion" placeholder="Ingrese dirección" required>
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
              <option value="ADM">Admin</option>
                <option value="AUT">Autoridad</option>
              <option value="DOC">Docente</option>
              <option value="EST">Estudiante</option>
              <option value="INV">Invitado</option>
            </select>
          </div>
        </div>
      <!-- ... -->
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
  <button type="button" class="btn btn-success" id="btnActualizar" style="display:none;">Actualizar</button>
</div>
<!-- ... -->
      </form>
    </div>
  </div>
</div>
<!-- Fin del Modal -->

        </div> <!-- Cierre de page-inner -->
</div> <!-- Cierre de page-wrapper -->
</div> <!-- Cierre de wrapper -->

<!-- Scripts necesarios -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="../public/js/usuario.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTables-users').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por pagina",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ total registros)",
                "search": "Buscar:",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Ultimo",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            }
        });
    });
</script>
<?php include("partials/footer_Admin.php"); ?>