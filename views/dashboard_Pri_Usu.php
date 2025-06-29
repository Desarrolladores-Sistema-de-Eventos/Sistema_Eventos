<?php include("partials/header_Admin.php"); ?>
<?php
$rolesPermitidos = ['DOCENTE', 'ESTUDIANTE', 'INVITADO'];
include("../core/auth.php");
?>

<div id="page-wrapper">
  <div id="page-inner">
    <h2>DATOS PERSONALES</h2>
    <div class="documentos-section">
  <!-- FOTO PERFIL -->
  <div class="foto-perfil">
    <p class="etiqueta-doc">Foto de perfil</p>
    <img id="img-perfil-preview" src="../public/img/user.jpg" alt="Foto de perfil">
    <div id="foto-actions">
      <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*" style="display: block;">
      <button type="button" id="btn-foto-editar" style="display: none;">Editar</button>
    </div>
  </div>

  <!-- CÉDULA -->
  <div class="cedula-upload">
    <p class="etiqueta-doc">Copia de cédula</p>
    <div id="pdf-preview" style="display: none; text-align: center;">
      <img src="../public/img/pdf.png" alt="PDF" class="pdf-icon">
      <div>
        <a id="btn-abrir-pdf" href="#" target="_blank" class="btn-secondary">Abrir archivo</a>
        <button type="button" id="btn-pdf-editar" class="btn-secondary">Editar</button>
      </div>
    </div>
    <input type="file" id="cedula_pdf" name="cedula_pdf" accept="application/pdf" style="display: block;">
  </div>

  <!-- MATRÍCULA -->
  <div class="matricula-upload">
    <p class="etiqueta-doc">Matrícula</p>
    <div id="matricula-preview" style="display: none; text-align: center;">
      <img src="../public/img/pdf.png" alt="PDF" class="pdf-icon">
      <div>
        <a id="btn-abrir-matricula" href="#" target="_blank" class="btn-secondary">Abrir archivo</a>
        <button type="button" id="btn-matricula-editar" class="btn-secondary">Editar</button>
      </div>
    </div>
    <input type="file" id="matricula_pdf" name="matricula_pdf" accept="application/pdf" style="display: block;">
  </div>
</div>

    <p class="nota">
      Para continuar con el ingreso de sus datos personales verifique que su fotografía se visualice en la pantalla y que su cédula esté almacenada.
    </p>

    <h3>INFORMACIÓN PERSONAL</h3>
    <form id="form-perfil" method="post" enctype="multipart/form-data">
      <div class="grid-form">
        <div>
          <label for="identificacion">Cédula o Pasaporte</label>
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
        <div class="hidden">
  <label for="rol">Rol</label>
  <input type="text" id="rol" disabled>
</div>

<div class="hidden">
  <label for="estado_usuario">Estado Usuario</label>
  <input type="text" id="estado_usuario" disabled>
</div>

      </div>

      <!-- Botón -->
      <div class="action-buttons">
        <button type="submit" class="btn-primary" title="Guardar">
          <i class="fa fa-save"></i>
        </button>
      </div>
      <hr />

      <!-- Hidden inputs para mantener los archivos si no se modifican -->
      <input type="hidden" id="foto_perfil_actual" name="foto_perfil_actual">
      <input type="hidden" id="cedula_pdf_actual" name="cedula_pdf_actual">
      <input type="hidden" id="matricula_pdf_actual" name="matricula_pdf_actual">
    </form>
  </div>
</div>
<style>

  body {
  background-color: #fff;
  color: #000;
  font-family: Arial, sans-serif;
}

  .hidden {
  display: none !important;
}

  :root {
  --rojo-uta: #800000;
  --gris-claro: #f9f9f9;
  --gris-borde: #ccc;
  --texto-gris: #444;
  --hover-rojo: #a10000;
}

/* Encabezados */
h2, h3 {
  color: var(--rojo-uta);
  margin-bottom: 20px;
  font-weight: 600;
  border-bottom: 2px solid var(--gris-borde);
  padding-bottom: 5px;
  font-size: 20px;
}

/* Sección de documentos */
.documentos-section {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 40px;
  margin-bottom: 30px;
}
.etiqueta-doc {
  font-weight: bold;
  color: #333;
  margin-bottom: 8px;
  font-size: 14px;
  text-align: center;
  width: 100%;
}
.foto-perfil,
.cedula-upload,
.matricula-upload {
  display: flex;
  flex-direction: column;
  align-items: center;
  min-width: 240px;
}

.foto-perfil img {
  width: 130px;
  height: 160px;
  object-fit: cover;
  border: 2px solid var(--rojo-uta);
  border-radius: 6px;
  margin-bottom: 12px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

/* Inputs de archivo */
input[type="file"] {
  border: 1px solid var(--gris-borde);
  border-radius: 5px;
  padding: 6px;
  background: white;
  font-size: 14px;
  width: 100%;
}

/* PDF */
.pdf-icon {
  width: 70px;
  margin-bottom: 10px;
}

.btn-secondary {
  border: 1px solid var(--rojo-uta);
  color: var(--rojo-uta);
  background-color: white;
  padding: 6px 12px;
  font-size: 14px;
  border-radius: 4px;
  cursor: pointer;
  margin: 3px;
  transition: 0.2s ease;
}
.btn-secondary:hover {
  background-color: var(--rojo-uta);
  color: white;
}

/* Nota */
.nota {
  font-size: 14px;
  text-align: center;
  color: #666;
  font-style: italic;
  margin-top: 15px;
  margin-bottom: 25px;
  border-top: 1px dashed #ccc;
  padding-top: 10px;
}

/* Formulario tipo grid */
.grid-form {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

.grid-form label {
  font-weight: bold;
  color: var(--texto-gris);
  font-size: 14px;
  display: block;
  margin-bottom: 5px;
}

.grid-form input,
.grid-form select {
  padding: 10px;
  font-size: 15px;
  border: 1px solid var(--gris-borde);
  border-radius: 5px;
  background-color: white;
  width: 100%;
  box-sizing: border-box;
}

.grid-form input:disabled,
.grid-form select:disabled {
  background-color: #eee;
  color: #666;
}

/* Botón principal */
.action-buttons {
  display: flex;
  justify-content: center;
  margin-top: 30px;
}

.btn-primary {
  background-color: var(--rojo-uta);
  color: white;
  border: none;
  padding: 12px 25px;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.btn-primary:hover {
  background-color: var(--hover-rojo);
}
.btn-primary:focus,
.btn-primary:active {
  background-color: var(--rojo-uta) !important;
  outline: none;
  box-shadow: none;
}

/* Responsive */
@media (max-width: 768px) {
  .documentos-section {
    flex-direction: column;
    align-items: center;
    gap: 30px;
  }

  .action-buttons {
    flex-direction: column;
    gap: 10px;
  }

  .btn-primary {
    width: 100%;
  }
}
</style>

<!-- CSS y scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../public/js/perfil_usuario.js"></script>

<?php include("partials/footer_Admin.php"); ?>
