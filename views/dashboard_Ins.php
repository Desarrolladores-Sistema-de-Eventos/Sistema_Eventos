<?php include("partials/header_Admin.php"); ?>

<div id="page-wrapper">
  <div id="page-inner">

    <div class="row">
      <div class="col-md-12">
        <h2 class="text-danger"><i class="fa fa-edit"></i> Gestión Inscripciones</h2>
      </div>
    </div>

    <hr />

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

    <hr />

    <!-- Advanced Tables -->
    <div class="panel panel-default">
      <div class="panel-heading">
        Inscripciones Pendientes
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover mb-0" id="dataTables-inscripciones">
            <thead>
              <tr>
                <th>Rendering engine</th>
                <th>Browser</th>
                <th>Platform(s)</th>
                <th>Engine version</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr class="odd gradeX">
                <td>Trident</td>
                <td>Internet Explorer 4.0</td>
                <td>Win 95+</td>
                <td class="center">4</td>
                <td class="text-center">
                  <!-- ✅ Botón que abre modal -->
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-eye"></i> Ver detalle
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!--End Advanced Tables -->

    <!-- ✅ Modal Detalle -->
<!-- Modal Detalle Más Profesional -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md"> <!-- Más pequeño -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-user-circle"></i> Detalle de Inscripción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Nombre</label>
              <input type="text" class="form-control" placeholder="Ingrese nombre" />
            </div>
            <div class="form-group col-md-6">
              <label>Email</label>
              <input type="email" class="form-control" value="info@yourdomain.com" readonly />
            </div>

            <div class="form-group col-md-6">
               <label>Archivo adjunto</label><br>
               <a href="uploads/cedula_lucia.pdf" class="btn btn-outline-secondary btn-sm" download><i class="fa fa-download"></i> Descargar</a>
            </div>

            <div class="form-group col-md-6">
              <label>Descripción</label>
              <textarea class="form-control" rows="2"></textarea>
            </div>

            <div class="form-group col-md-6">
              <label>Checkboxes</label><br>
              <div class="form-check"><input type="checkbox" class="form-check-input" id="cb1"><label class="form-check-label" for="cb1">Opción 1</label></div>
              <div class="form-check"><input type="checkbox" class="form-check-input" id="cb2"><label class="form-check-label" for="cb2">Opción 2</label></div>
              <div class="form-check"><input type="checkbox" class="form-check-input" id="cb3"><label class="form-check-label" for="cb3">Opción 3</label></div>
            </div>

            <div class="form-group col-md-6">
              <label>Checkboxes Inline</label><br>
              <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" id="cbA">
                <label class="form-check-label" for="cbA">Uno</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" id="cbB">
                <label class="form-check-label" for="cbB">Dos</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" id="cbC">
                <label class="form-check-label" for="cbC">Tres</label>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label>Radio Buttons</label>
              <div class="form-check"><input type="radio" name="opciones" class="form-check-input" checked> Opción A</div>
              <div class="form-check"><input type="radio" name="opciones" class="form-check-input"> Opción B</div>
              <div class="form-check"><input type="radio" name="opciones" class="form-check-input"> Opción C</div>
            </div>

            <div class="form-group col-md-6">
              <label>Select simple</label>
              <select class="form-control">
                <option>Uno</option>
                <option>Dos</option>
                <option>Tres</option>
              </select>
            </div>

            <div class="form-group col-md-12">
              <label>Select múltiple</label>
              <select multiple class="form-control">
                <option>Opción 1</option>
                <option>Opción 2</option>
                <option>Opción 3</option>
              </select>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-success"><i class="fa fa-check"></i> Aprobar</button>
        <button class="btn btn-danger"><i class="fa fa-times"></i> Rechazar</button>
        <button class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-sign-out-alt"></i> Salir</button>
      </div>
    </div>
  </div>
</div>
    <!-- Fin Modal -->

  </div> <!-- Cierre page-inner -->
</div> <!-- Cierre page-wrapper -->
<?php include("partials/footer_Admin.php"); ?>


