<?php include("partials/header_Admin.php"); ?>
<?php
$rolesPermitidos = ['DOCENTE', 'ESTUDIANTE', 'INVITADO'];
include("../core/auth.php");
?>

<div id="page-wrapper">
  <div id="page-inner">
    <h2>📄 DATOS PERSONALES</h2>

<div class="documentos-section">
  <!-- FOTO PERFIL -->
  <div class="foto-perfil">
    <img id="img-perfil-preview" src="../public/img/user.jpg" alt="Foto de perfil">
    
    <div id="foto-actions">
      <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*" style="display: block;">
      <button type="button" id="btn-foto-editar" style="display: none;">Editar</button>
    </div>
  </div>

  <!-- CÉDULA PDF -->
  <div class="cedula-upload">
    <div id="pdf-preview" style="display: none; text-align: center;">
      <img src="../public/img/pdf.png" alt="PDF" class="pdf-icon" style="width: 80px; margin-bottom: 10px;">
      <div>
        <a id="btn-abrir-pdf" href="#" target="_blank" class="btn-secondary">Abrir archivo</a>
        <button type="button" id="btn-pdf-editar" class="btn-secondary">Editar</button>
      </div>
    </div>
    <input type="file" id="cedula_pdf" name="cedula_pdf" accept="application/pdf" style="display: block;">
  </div>
</div>


    <p class="nota">Para continuar con el ingreso de sus datos personales verifique que su fotografía se visualice en la pantalla y que su cédula esté almacenada.</p>

    <h3>🆔 INFORMACIÓN PERSONAL</h3>
    <form id="form-perfil" method="post" enctype="multipart/form-data">
      <div class="grid-form">
        <div>
          <label for="identificacion">Identificación (Cédula)</label>
          <input type="text" id="identificacion" name="identificacion" required>
        </div>
        <div>
          <label for="nombres">Nombres</label>
          <input type="text" id="nombres" name="nombres" required>
        </div>
        <div>
          <label for="apellidos">Apellidos</label>
          <input type="text" id="apellidos" name="apellidos" required>
        </div>
        <div>
          <label for="correo">Correo institucional</label>
          <input type="email" id="correo" name="correo" disabled>
        </div>
        <div>
          <label for="telefono">Teléfono</label>
          <input type="text" id="telefono" name="telefono">
        </div>
        <div>
          <label for="direccion">Dirección</label>
          <input type="text" id="direccion" name="direccion">
        </div>
        <div>
          <label for="fecha_nacimiento">Fecha de Nacimiento</label>
          <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
        </div>
        <div>
           <label for="carrera">Carrera</label>
           <select id="carrera" name="carrera">
             <option value="">Seleccione una carrera</option>
              <!-- Las opciones se cargarán por JavaScript -->
            </select>
          </div>
        <div>
          <label for="rol">Rol</label>
          <input type="text" id="rol" disabled>
        </div>
        <div>
          <label for="estado_usuario">Estado Usuario</label>
          <input type="text" id="estado_usuario" disabled>
        </div>

      </div>
      <div class="action-buttons" style="margin-top: 30px; justify-content: center;">
  <button type="submit" class="btn-primary" title="Guardar"><i class="fa fa-save"></i></button>
</div>
    <hr/>
    </form>
  </div>
</div>
<style>
/* El perfil-container ahora usa la clase card para unificar estilos */
.card.perfil-container {
    background: #fff; /* Fondo blanco consistente con .card */
    border-radius: 10px; /* Bordes redondeados consistentes */
    padding: 25px; /* Padding consistente */
    box-shadow: 0 2px 8px rgba(0,0,0,0.05); /* Sombra consistente */
    font-family: 'Segoe UI', sans-serif;
    max-width: 1100px; /* Ancho máximo para el contenido, si es necesario */
    margin: 0 auto; /* Centrar dentro de #page-inner, si #page-inner no es flex/grid */
    color: #333;
    margin-bottom: 30px; /* Margen inferior para separar de otros elementos */
}

/* Ajustes para encabezados */
.perfil-container h2,
.perfil-container h3 {
    color:rgb(128, 0, 0); /* Color azul para encabezados */
    border-bottom: 1px solid #e6f0ff; /* Línea inferior más suave */
    padding-bottom: 10px;
    margin-top: 25px; /* Espacio superior para h3 */
    margin-bottom: 20px; /* Espacio inferior */
}

/* Sección de documentos (foto y cédula) */
.documentos-section {
    display: flex;
    flex-wrap: wrap; /* Permite que los elementos se envuelvan en pantallas pequeñas */
    gap: 40px;
    margin-top: 20px;
    justify-content: center; /* Centrar elementos en línea */
}

.foto-perfil,
.cedula-upload {
    flex: 1; /* Permite que cada sección ocupe espacio equitativamente */
    min-width: 280px; /* Ancho mínimo para evitar que se pongan demasiado pequeños */
    display: flex;
    flex-direction: column;
    align-items: center; /* Centrar contenido dentro de su columna */
}

.foto-perfil img {
    width: 140px;
    height: 160px;
    object-fit: cover;
    border: 2px solidrgb(128, 0, 0); /* Borde más oscuro */
    border-radius: 5px; /* Ligeramente redondeado */
    margin-bottom: 15px;
    box-shadow: 0 2px 5px rgba(170, 4, 4, 0.1); /* Sombra para la imagen */
}

.foto-perfil form,
.cedula-upload form {
    display: flex;
    flex-direction: column;
    gap: 8px;
    width: 100%; /* Ajustar al ancho del contenedor flex */
    max-width: 250px; /* Ancho máximo para los formularios de archivo */
}

.foto-perfil input[type="file"],
.cedula-upload input[type="file"] {
    font-size: 14px;
    padding: 8px; /* Más padding para los inputs de archivo */
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

/* Botones de acción */
.btn-primary {
    background:rgb(128, 0, 0); /* Color primario */
    color: white;
    border: 2px solidrgb(128, 0, 0); /* Borde sólido */
    padding: 10px 20px; /* Padding ajustado */
    border-radius: 6px; /* Bordes redondeados */
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    min-width: 150px; /* Ancho mínimo para todos los botones primarios */
    text-align: center;
}

.btn-primary:hover {
    background-color: #fff;
    color:rgb(128, 9, 0);
}

.cedula-upload .pdf-icon {
    width: 80px; /* Icono PDF más grande */
    margin-bottom: 15px;
}

/* Nota de información */
.nota {
    margin-top: 25px;
    margin-bottom: 30px; /* Más espacio inferior */
    font-size: 14px;
    color: #555;
    font-style: italic;
    text-align: center; /* Centrar la nota */
    border-top: 1px dashed #eee; /* Separador sutil */
    padding-top: 15px;
}

/* Formulario en cuadrícula */
.grid-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Columnas más grandes y flexibles */
    gap: 20px; /* Espacio entre campos */
    margin-top: 20px;
}

.grid-form label {
    font-weight: bold;
    font-size: 14px;
    color: #555; /* Color de label más suave */
    margin-bottom: 5px; /* Espacio entre label e input */
}

.grid-form input[type="text"],
.grid-form input[type="email"],
.grid-form input[type="date"],
.grid-form select {
    width: 100%;
    padding: 10px; /* Más padding para los inputs */
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: #fff;
    font-size: 15px;
    box-sizing: border-box; /* Incluir padding y borde en el width */
}

.grid-form input:disabled,
.grid-form select:disabled {
    background-color: #e9ecef; /* Color de fondo para campos deshabilitados */
    color: #6c757d; /* Color de texto para campos deshabilitados */
}

/* Botones de acción del formulario principal */
.action-buttons {
    display: flex;
    gap: 15px; /* Espacio entre botones */
    margin-top: 30px;
    justify-content: flex-start; /* Alinear a la izquierda */
}

/* Media queries existentes, ajustados para la nueva estructura */
@media (max-width: 768px) {
    .documentos-section {
        flex-direction: column; /* Apilar secciones de documentos */
        align-items: center; /* Centrar en columna */
        gap: 30px; /* Espacio entre secciones apiladas */
    }
    .action-buttons {
        flex-direction: column;
        align-items: center; /* Centrar botones en columna */
    }
    .btn-primary {
        width: 100%; /* Botones de ancho completo en móviles */
    }
    .grid-form {
        grid-template-columns: 1fr; /* Una sola columna en móviles */
    }
    .card.perfil-container {
        padding: 15px; /* Menos padding en pantallas pequeñas */
    }
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="../public/js/perfil_usuario.js"></script>

<?php include("partials/footer_Admin.php"); ?>
