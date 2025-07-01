<?php include("partials/header_Admin.php"); ?>
<?php include("../core/auth.php"); ?>
<style>
/* Estilo contenedor con scroll */
.table-responsive {
  max-height: 550px;
  overflow-y: auto;
  background: white;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  padding: 8px;
}

/* Tabla estilizada */
#tablaFacultades {
  border-collapse: collapse;
  width: 100%;
  font-family: 'Segoe UI', sans-serif;
}

/* Cabecera sticky con fondo rojo UTA */
#tablaFacultades thead th {
  position: sticky;
  top: 0;
  background-color: #8B0000;
  color: white;
  text-align: center;
  padding: 12px;
  font-size: 15px;
  border-bottom: 3px solid #DAA520;
  box-shadow: inset 0 -2px 0 #DAA520;
  z-index: 2;
}

/* Celdas cuerpo */
#tablaFacultades tbody td {
  padding: 12px;
  font-size: 14px;
  vertical-align: middle;
  background-color: #fff;
  transition: background 0.3s ease;
  border-bottom: 1px solid #eee;
}

/* Alternar colores filas */
#tablaFacultades tbody tr:nth-child(even) td {
  background-color: #f5f5f5;
}

/* Hover fila */
#tablaFacultades tbody tr:hover td {
  background-color: #fffbe6;
  cursor: pointer;
}

/* Línea lateral izquierda animada */
#tablaFacultades tbody tr {
  border-left: 6px solid transparent;
  transition: border-color 0.3s ease;
}

#tablaFacultades tbody tr:hover {
  border-left: 6px solid #DAA520;
}

/* Botones pequeños */
.btn-sm {
  border-radius: 5px;
  font-size: 12px;
  padding: 5px 9px;
  margin: 0 2px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Botones color UTA */
.btn-primary {
  background-color: #006699;
  border: none;
}

.btn-primary:hover {
  background-color: #004466;
}

.btn-danger {
  background-color: #cc0000;
  border: none;
}

.btn-danger:hover {
  background-color: #a80000;
}

/* Scroll personalizado */
.table-responsive::-webkit-scrollbar {
  width: 10px;
}

.table-responsive::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
  background: #8B0000;
  border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
  background: #a80000;
}
 
</style>


<div id="page-wrapper">
  <div id="page-inner">
    <h3 class="text-uta"><i class="fa fa-university"></i> Gestión de Facultades</h3>
    <p class="text-muted">Administra las facultades disponibles en el sistema.</p>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-success" id="btnAgregarFacultad"><i class="fa fa-plus"></i> Agregar Facultad</button>
      <a href="configuracion_datos_base.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Volver a configuración</a>
    </div>

    <br>

    <div class="table-responsive">
      <table class="table table-dark table-bordered table-hover" id="tablaFacultades">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Misión</th>
            <th>Visión</th>
            <th>Ubicación</th>
            <th style="width: 120px;">Acciones</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>


  </div>
</div>

<!-- Modal para agregar/editar facultad -->
<div class="modal fade" id="modalFacultad" tabindex="-1" role="dialog" aria-labelledby="modalFacultadLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formFacultad" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFacultadLabel">Agregar Facultad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="facultadId" name="id">

          <div class="form-group">
            <label for="nombreFacultad">Nombre</label>
            <input type="text" class="form-control" id="nombreFacultad" name="nombre" maxlength="100" required>
          </div>

          <div class="form-group">
            <label for="misionFacultad">Misión</label>
            <textarea class="form-control" id="misionFacultad" name="mision" maxlength="500" required></textarea>
          </div>

          <div class="form-group">
            <label for="visionFacultad">Visión</label>
            <textarea class="form-control" id="visionFacultad" name="vision" maxlength="500" required></textarea>
          </div>

          <div class="form-group">
            <label for="ubicacionFacultad">Ubicación</label>
            <input type="text" class="form-control" id="ubicacionFacultad" name="ubicacion" maxlength="255" required>
          </div>

          <!-- Campos extendidos -->
          <div class="form-group">
            <label for="siglaFacultad">Sigla</label>
            <input type="text" class="form-control" id="siglaFacultad" name="sigla" maxlength="20">
          </div>

          <div class="form-group">
            <label for="aboutFacultad">Acerca de (Descripción)</label>
            <textarea class="form-control" id="aboutFacultad" name="about" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="urlLogoFacultad">URL del Logo</label>
            <input type="file" class="form-control" id="urlLogoFacultad" name="urlLogo" accept="image/*">
          </div>

          <div class="form-group">
            <label for="urlPortadaFacultad">URL de la Portada</label>
             <input type="file" class="form-control" id="urlPortadaFacultad" name="urlPortada" accept="image/*">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnGuardarFacultad">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts y plugins -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/facultades.js"></script>


<?php include("partials/footer_Admin.php"); ?>

