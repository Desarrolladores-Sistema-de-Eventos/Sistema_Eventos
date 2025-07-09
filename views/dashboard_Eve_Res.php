<?php include("partials/header_Admin.php"); ?>
<?php
$requiereResponsable = true;
include("../core/auth.php")
  ?>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
        <div class="col-md-12">
        <h2><i class="fa fa-calendar"></i> Gestión de Eventos del Responsable</h2>
                <div class="linea-roja-uta"></div>
        </div>
    </div> 
        <div class="text-right" style="margin-bottom: 15px;">
            <button class="btn mb-3" id="btn-nuevo" data-toggle="modal" data-target="#modalEvento" style="background-color: #e0e0e0; color: #222; border: 1px solid #b0b0b0;">
            <i class="fa fa-plus"></i> Nuevo Evento
            </button>
        </div>

        <!-- Nav tabs para filtrar por estado -->
        <ul class="nav nav-tabs" id="navEstadosEventos" style="margin-bottom: 15px;">
          <li class="active"><a href="#" data-estado="CREADO">Creado</a></li>
          <li><a href="#" data-estado="DISPONIBLE">Disponible</a></li>
          <li><a href="#" data-estado="EN CURSO">En Curso</a></li>
          <li><a href="#" data-estado="FINALIZADO">Finalizado</a></li>
          <li><a href="#" data-estado="CANCELADO">Cancelado</a></li>
        </ul>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tabla-eventos">
            <thead class="thead-dark">
              <tr>
                <th>Foto</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Inicio</th>
                <th>Finalización</th>
                <th>Modalidad</th>
                <th>Horas</th>
                <th>Costo</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- Aquí se cargan dinámicamente los eventos con JS -->
            </tbody>
          </table>
        </div>
        <div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="modalEventoLabel" aria-hidden="true">
          <div class="modal-dialog" style="max-width:800px;width:98vw; height: 90vh;">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalEventoLabel"><i class="fa fa-edit"></i> Crear/Editar Evento</h4>
              </div>
              <div class="modal-body">
                <form id="formEvento" role="form" enctype="multipart/form-data">
    <input type="hidden" id="idEvento" name="idEvento">
    <div class="row" style="margin-bottom:10px; align-items: flex-end;">
      <div class="col-md-6">
        <label for="titulo"><i class="fa fa-book"></i> Título del Evento</label>
        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Congreso de Tecnología" required>
      </div>
      <div class="col-md-2">
        <label for="fechaInicio"><i class="fa fa-calendar"></i> Inicio</label>
        <input type="date" class="form-control input-sm" id="fechaInicio" name="fechaInicio" required style="min-width: 120px;">
      </div>
      <div class="col-md-2">
        <label for="fechaFin"><i class="fa fa-calendar"></i> Fin</label>
        <input type="date" class="form-control input-sm" id="fechaFin" name="fechaFin" style="min-width: 120px;">
      </div>
      <div class="col-md-2 text-center">
        <div class="custom-checkbox-vertical">
          <label for="esDestacado" class="label-checkbox-vertical">¿Destacado?</label>
          <input type="checkbox" id="esDestacado" name="esDestacado">
        </div>
      </div>
    </div>
    <div class="row" style="margin-bottom:10px; align-items: flex-end;">
      <div class="col-md-2">
        <label for="horas"><i class="fa fa-clock-o"></i> Horas</label>
        <input type="number" class="form-control input-sm" id="horas" name="horas" min="1" step="0.1" required>
      </div>
      <div class="col-md-2 text-center">
        <div class="custom-checkbox-vertical">
          <label for="esPagado" class="label-checkbox-vertical">¿Pagado?</label>
          <input type="checkbox" id="esPagado" name="esPagado">
        </div>
      </div>
      <div class="col-md-2" id="grupoCosto">
        <label for="costo"><i class="fa fa-dollar"></i> Costo</label>
        <input type="number" class="form-control input-sm" id="costo" name="costo" min="0" step="0.01" value="0" disabled>
      </div>
      <div class="col-md-2" id="notaAprobacionGroup">
        <label for="notaAprobacion"><i class="fa fa-check-circle"></i> Nota mín.</label>
        <input type="number" class="form-control input-sm" id="notaAprobacion" name="notaAprobacion" min="0" step="0.1">
      </div>
      <div class="col-md-2">
        <label for="asistenciaMinima"><i class=""></i> % Por. Mín.</label>
        <input type="number" class="form-control input-sm" id="asistenciaMinima" name="asistenciaMinima" min="0" max="100" step="0.1">
      </div>
      <div class="col-md-2">
        <label for="capacidad"><i class="fa fa-users"></i> Capacidad</label>
        <input type="number" class="form-control input-sm" id="capacidad" name="capacidad" min="1" step="1" required>
      </div>
      <div class="col-md-2" style="display:flex; align-items:center; gap:12px; margin-top:18px;">
        
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <label for="tipoEvento"><i class="fa fa-folder-open"></i> Tipo de Evento</label>
        <select class="form-control input-sm" id="tipoEvento" name="tipoEvento" required style="max-width: 220px;">
          <option value="">Seleccione</option>
        </select>
      </div>
      <div class="col-md-3">
        <label for="modalidad"><i class="fa fa-random"></i> Modalidad</label>
        <select class="form-control input-sm" id="modalidad" name="modalidad" required style="max-width: 220px;">
          <option value="">Seleccione</option>
        </select>
      </div>
      <div class="col-md-3">
        <label for="categoria"><i class="fa fa-tags"></i> Categoría</label>
        <select class="form-control input-sm" id="categoria" name="categoria" required style="max-width: 220px;">
          <option value="">Seleccione</option>
        </select>
      </div>
      <div class="col-md-3">
        <label for="estado"><i class="fa fa-info-circle"></i> Estado</label>
        <select class="form-control input-sm" id="estado" name="estado" required style="max-width: 180px;">
          <option value="DISPONIBLE">Disponible</option>
          <option value="EN CURSO">En Curso</option>
          <option value="FINALIZADO">Finalizado</option>
          <option value="CANCELADO">Cancelado</option>
          <option value="CREADO">Creado</option>
        </select>
      </div>
    </div><br>
    <!-- Campo Inscripción eliminado por no ser necesario -->
        <div class="row" style="margin-bottom:10px; align-items: flex-end;">
      <div class="col-md-12">
        <label for="carrera"><i class="fa fa-graduation-cap"></i> Carreras</label>
        <select class="form-control select2 input-sm" id="carrera" name="carrera[]" multiple required style="width:100%; max-width: 700px;">
          <!-- Opciones generadas dinámicamente -->
        </select>
        <div style="margin-top:4px;">
          <span class="label label-info" style="background:#b32d2d;color:#fff;padding:3px 8px;border-radius:4px;font-size:13px;">
            <i class="fa fa-info-circle"></i> Puede buscar y seleccionar varias carreras. Escriba para filtrar.
          </span>
        </div>
        <small class="text-muted">Use Ctrl o Shift para seleccionar varias, o haga clic en cada una.</small>
      </div>
    </div>
    <div class="form-group">
      <label for="descripcion"><i class="fa fa-align-left"></i> Descripción</label>
      <textarea class="form-control" id="descripcion" name="descripcion" rows="4"></textarea>
    </div>
    <div class="form-group">
      <label for="contenido"><i class="fa fa-list-alt"></i> Contenido del Evento</label>
      <textarea class="form-control" id="contenido" name="contenido" rows="4"></textarea>
    </div>
    <!-- Eliminado campo de asistencia mínima aquí, ahora está junto a nota mínima -->
    <!-- Requisitos movidos al final del formulario -->
    <div class="row">
      <div class="col-md-6">
        <label for="urlPortada"><i class="fa fa-image"></i> Imagen de Portada</label>
        <input type="file" class="form-control" id="urlPortada" name="urlPortada" accept="image/*">
        <div id="nombrePortada" class="text-muted" style="font-size:13px;margin-top:4px;"></div>
        <div id="miniaturaPortada" style="margin-top:6px;"></div>
      </div>
      <div class="col-md-6">
        <label for="urlGaleria"><i class="fa fa-picture-o"></i> Imagen de Galería</label>
        <input type="file" class="form-control" id="urlGaleria" name="urlGaleria" accept="image/*">
        <div id="nombreGaleria" class="text-muted" style="font-size:13px;margin-top:4px;"></div>
        <div id="miniaturaGaleria" style="margin-top:6px;"></div>
      </div>
    </div>
    <!-- Requisitos movidos después de las imágenes -->
    <div class="row" style="margin-top:10px;">
      <div class="col-md-12">
        <div id="listaRequisitos" class="form-check"></div>
      </div>
    </div>
    <!-- Footer del modal dentro del form -->
    <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 8px;">
      <button type="submit" id="btn-save" class="btn" style="background-color:rgb(211, 211, 211); color: #222; border: 1px solid #b0b0b0;">
        <i class="fa fa-save" style="color: #222;"></i> Guardar Evento
      </button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">
        Cerrar
      </button>
    </div>
        <!-- Fin modal -->
      </div>
    </div>
  </div>
</div>
<!-- Mostrar nombre de archivos seleccionados o ya existentes -->
<script>
  // Mostrar nombre de archivo al seleccionar
  document.addEventListener('DOMContentLoaded', function() {
    const portadaInput = document.getElementById('urlPortada');
    const galeriaInput = document.getElementById('urlGaleria');
    const nombrePortada = document.getElementById('nombrePortada');
    const nombreGaleria = document.getElementById('nombreGaleria');

    if (portadaInput) {
      portadaInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
          nombrePortada.textContent = this.files[0].name;
        } else {
          nombrePortada.textContent = '';
        }
      });
    }
    if (galeriaInput) {
      galeriaInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
          nombreGaleria.textContent = this.files[0].name;
        } else {
          nombreGaleria.textContent = '';
        }
      });
    }
    // Cuando se edita un evento, mostrar el nombre y miniatura del archivo ya existente si lo hay
    window.mostrarNombresImagenesEvento = function(portada, galeria) {
      nombrePortada.textContent = portada ? portada : '';
      nombreGaleria.textContent = galeria ? galeria : '';
      // Mostrar solo la URL debajo del input si hay nombre
      const miniaturaPortada = document.getElementById('miniaturaPortada');
      const miniaturaGaleria = document.getElementById('miniaturaGaleria');
      if (portada) {
        miniaturaPortada.innerHTML = '';
      } else {
        miniaturaPortada.innerHTML = '';
      }
      if (galeria) {
        miniaturaGaleria.innerHTML = '';
      } else {
        miniaturaGaleria.innerHTML = '';
      }
    };
  });
</script>



<style>
  body {
    background-color: #fff;
    color: #000;
    font-family: Arial, sans-serif;
  }
  .alert-info {
  background-color: #ffd6d6 !important; /* Rojo claro */
  color: #222 !important;               /* Letra negra */
  border-color: #ffb3b3 !important;     /* Borde rojo suave */
}

  .panel-heading {
    background: rgb(27, 26, 26) !important;
    color: #fff !important;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    border-bottom: 2px solid #7b2020;
     font-weight: normal;
     font-size: 14px;

  }/* Estilo para checkboxes verticales */
.custom-checkbox-vertical {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  min-height: 54px;
}
.label-checkbox-vertical {
  font-size: 14px;
  margin-bottom: 4px;
  font-weight: normal;
}
.custom-checkbox-vertical input[type="checkbox"] {
  margin: 10px auto 0 auto; /* Baja el checkbox y lo centra */
  width: 15px;
  height: 15px;
  accent-color: #ae0c22; /* Rojo institucional */
}
   h2 {
    font-size: 24px;
    color: rgb(23, 23, 23);
    font-weight: bold;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  

  .panel-heading {
    background:rgb(185, 51, 51);
    color: #fff;
    
  }
 select.form-control {
    border: 1.5px solid #9b2e2e;
    border-radius: 6px;
    font-size: 14px;
    background: #f9fafb;
    color: #222;
    transition: border-color 0.2s;
  }
   th.nombre-columna, td.nombre-columna {
  max-width: 100px;
  width: 100px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.linea-roja-uta {
  width: 100%;
  height: 2px;
  background: #ae0c22;
  border-radius: 3px;
  margin-top: 0px;
  margin-bottom: 18px;
}

/* Botón PDF estilo claro con icono */
.btn-primary {
  background: #f3f3f3;
  color: #222;
  border: none;
  border-radius: 8px;
  padding: 6px 16px;
  font-size: 15px;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: none;
  transition: background 0.2s;
  font-weight: normal;
  font-size: 14px;

}
.btn-primary:hover {
  background: #e0e0e0;
  color: #b32d2d;
}

.btn-secundary {
  background: #f3f3f3;
  color: #222;
  border: none;
  border-radius: 8px;
  padding: 6px 16px;
  font-size: 15px;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: none;
  transition: background 0.2s;
}
.btn-secundary:hover {
  background: #e0e0e0;
  color: #b32d2d;
}
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:focus,
div.dataTables_wrapper .dataTables_paginate ul.pagination > li.active > a:hover {
  background-color: #c0392b !important;
  border-color: #c0392b !important;
  color: white !important;
  box-shadow: none !important;
  outline: none !important;
}
thead {
  background-color: rgb(180, 34, 34);
  color: white;
  font-size: 14px;
  font-weight: normal;
}
.table {
  width: 100% !important;
  max-width: 90vw !important;
  margin: 0 auto;
}
.table th, .table td {
  padding: 12px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ddd;
  font-size: 14px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.table th {
  background-color: rgb(180, 34, 34);
  color: #fff;
  font-weight: normal;
}
h4 {
  font-size: 14px;
  
}
label{
  font-weight: normal;
  font-size: 14px;
}
p{
  font-size: 14px;
  font-weight: normal;
}
hr{
  border-top: 2px solid #9b2e2e;
  opacity: 1;
}
.dataTables_length label,
.dataTables_length select {
  font-size: 14px !important;
}
 .titulo-linea {
    border-bottom: 2px solid rgb(185, 51, 51);
    margin-top: 6px;
    margin-bottom: 20px;
  }
  /* Tabs UTA institucional */
.nav-tabs > li > a {
  color: #222 !important; /* Negro para inactivos */
}
.nav-tabs > li > a:hover {
  background: #c0392b !important;
  color: #fff !important;
}

</style>
<!-- Scripts necesarios -->
 <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
// Ejecutar la inicialización de CKEditor y asegurar que el filtrado de tabs funcione al cargar la página
document.addEventListener('DOMContentLoaded', function() {
  if (window.initCKEditor) window.initCKEditor();
  // Seleccionar el tab activo al cargar y filtrar
  var $activeTab = document.querySelector('#navEstadosEventos li.active a');
  if ($activeTab && typeof filtrarEventosPorEstado === 'function') {
    filtrarEventosPorEstado($activeTab.getAttribute('data-estado'));
  }
});
</script>
<script src="../public/js/eve_Res.js"></script>
<?php include("partials/footer_Admin.php"); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
      var tipoEvento = document.getElementById('tipoEvento');
      var notaAprobacion = document.getElementById('notaAprobacion');
      var notaAprobacionGroup = document.getElementById('notaAprobacionGroup');
      if (tipoEvento && notaAprobacion && notaAprobacionGroup) {
        function toggleNotaAprobacion() {
          var selected = tipoEvento.options[tipoEvento.selectedIndex]?.text?.toLowerCase() || '';
          if (selected.includes('curso')) {
            notaAprobacionGroup.style.display = '';
            notaAprobacion.disabled = false;
          } else {
            notaAprobacionGroup.style.display = 'none';
            notaAprobacion.disabled = true;
            notaAprobacion.value = '';
          }
        }
        tipoEvento.addEventListener('change', toggleNotaAprobacion);
        toggleNotaAprobacion();
      }
    });
    </script>


</body>
</html>
