<?php include("partials/header_Admin.php"); ?>
<?php 
$rolesPermitidos = ['DOCENTE', 'ESTUDIANTE', 'INVITADO'];
include("../core/auth.php"); 
?>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="inscripciones-wrapper">
      <h2 class="titulo-inscripcion">INSCRIPCIONES</h2>

      <table id="tablaInscripciones" class="table table-bordered" style="width: 100%;">

        <thead>
          <tr>
            <th>Curso</th>
            <th>Factura</th>
            <th>Estado Inscripción</th>
            <th>Fecha Inscripción</th>
            <th>Documentos</th>
          </tr>
        </thead>
      </table>
    </div>

    <!-- ✅ Modal Subida Requisitos -->
    <div class="modal fade" id="modalRequisitos" tabindex="-1" role="dialog" aria-labelledby="modalRequisitosLabel">
      <div class="modal-dialog modal-lg" role="document">
        <form id="formRequisitos" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header" style="background:#c0392b;color:white;">
              <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
              <h4 class="modal-title" id="modalRequisitosLabel">Subir Documentos del Evento</h4>
            </div>
            <div class="modal-body">

              <!-- Hidden Inputs -->
              <input type="hidden" name="id_inscripcion" id="inputIdInscripcion">
              <input type="hidden" name="id_evento" id="inputIdEvento">
              <input type="hidden" name="es_pagado" id="inputEsPagado">

              <!-- Contenedor de requisitos -->
               <label>Requisitos del Evento: </label>
              <div id="contenedorRequisitos">
                <p class="text-muted">Cargando requisitos...</p>
              </div>

              <hr>

              <!-- Grupo de pago (visible solo si es pagado) -->
               <!-- Grupo de pago -->
<div id="grupoPago" style="display: none;">
  <div class="form-group">
    <label>Forma de pago</label>
    <select class="form-control" name="forma_pago" id="inputFormaPago">
      <option value="">Seleccione...</option>
      <option value="TRANS">Transferencia</option>
      <option value="EFEC">Efectivo</option>
    </select>
  </div>
<hr/>

  <!-- Si ya existe comprobante -->
  <div class="form-group">
    <label>Comprobante de pago</label>

    <div id="wrapperComprobantePago" style="display: none;">
      <a id="linkComprobante" href="#" target="_blank" class="nombre-archivo text-success mr-2"></a>
      <button type="button" id="btnCambiarComprobante" class="btn btn-sm btn-outline-primary">Cambiar</button>
      <input type="file" name="comprobante_pago" id="inputComprobante" class="form-control-file mt-2" style="display:none;" accept=".pdf,.jpg,.jpeg,.png">
    </div>

    <!-- Si no existe comprobante -->
    <div id="wrapperNuevoComprobante" style="display: none;">
      <input type="file" name="comprobante_pago" class="form-control-file" accept=".pdf,.jpg,.jpeg,.png">
    </div>
  </div>
</div>

  

            <div class="modal-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<style>
/* Colores base */
body {
  background-color: #fff;
  color: #000;
  font-family: Arial, sans-serif;
}

/* Encabezado */
.titulo-inscripcion {
  text-align: center;
  color:rgb(0, 0, 0);
  font-weight: bold;
  font-size: 24px;
  margin-bottom: 15px;
}

/* Tabla */
#tablaInscripciones th {
  background-color:rgb(180, 34, 34);
  color: white;
  text-align: center;
}
#tablaInscripciones td {
  color: #000;
  text-align: center;
  vertical-align: middle;
}

/* Botón de subir */
.btn-dark {
  background-color: #000;
  color: #fff;
  border: none;
}
.btn-dark:hover {
  background-color:rgb(56, 54, 54);
  color: #fff;
}

/* Botones del modal */
.modal-footer .btn-success {
  background-color: #c0392b;
  border: none;
}
.modal-footer .btn-success:hover {
  background-color: #a93226;
}
.modal-footer .btn-default:hover {
  background-color: #ddd;
}

/* Buscador y selector */
.dataTables_filter input,
.dataTables_length select {
  border: 1px solid #c0392b;
  border-radius: 4px;
}

/* Forzar botón activo (Bootstrap 3 usa <li class="active"><a>...) */
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: #c0392b !important;
  border-color: #c0392b !important;
  color: white !important;
  box-shadow: none !important;
  outline: none !important;
}

.dataTables_length label,
.dataTables_length select {
  font-size: 14px !important;
}


</style>


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="../public/js/misInscripciones.js"></script>

<?php include("partials/footer_Admin.php"); ?>
