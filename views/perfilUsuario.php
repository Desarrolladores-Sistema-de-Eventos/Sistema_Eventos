<?php
session_start();
$usuario_id = '202012345'; // Reemplazar por $_SESSION['usuario_id'] si está disponible

$directorio_foto = 'uploads/perfiles/';
$directorio_pdf = 'uploads/documentos/';
$foto_perfil = $directorio_foto . $usuario_id . '.jpg';
$cedula_pdf = $directorio_pdf . $usuario_id . '.pdf';

// Procesar subida de imagen JPG
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    if (!file_exists($directorio_foto)) {
        mkdir($directorio_foto, 0777, true);
    }
    if ($_FILES['foto_perfil']['size'] <= 51200 && mime_content_type($_FILES['foto_perfil']['tmp_name']) === 'image/jpeg') {
        move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);
    }
}

// Procesar subida de PDF
if (isset($_FILES['cedula_pdf']) && $_FILES['cedula_pdf']['error'] === UPLOAD_ERR_OK) {
    if (!file_exists($directorio_pdf)) {
        mkdir($directorio_pdf, 0777, true);
    }
    if (mime_content_type($_FILES['cedula_pdf']['tmp_name']) === 'application/pdf') {
        move_uploaded_file($_FILES['cedula_pdf']['tmp_name'], $cedula_pdf);
    }
}

$foto_mostrar = file_exists($foto_perfil) ? $foto_perfil : 'assets/img/default-user.png';
$cedula_mostrar = file_exists($cedula_pdf);
?>

<?php include("partials/header_Admin.php"); ?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
<div class="perfil-container">
    <h2>📄 DATOS PERSONALES</h2>

    <div class="documentos-section">
        <div class="foto-perfil">
            <img src="<?php echo $foto_mostrar; ?>" alt="Foto de perfil">
            <form method="post" enctype="multipart/form-data">
                <label>Fotografía (.jpg - Máximo 50KB)</label>
                <input type="file" name="foto_perfil" accept="image/jpeg" required>
                <button type="submit">Guardar Foto</button>
            </form>
        </div>

        <div class="cedula-upload">
            <?php if ($cedula_mostrar): ?>
                <a href="<?php echo $cedula_pdf; ?>" target="_blank">
                    <img src="assets/img/pdf-icon.png" alt="PDF" class="pdf-icon">
                </a>
            <?php else: ?>
                <img src="assets/img/pdf-icon.png" alt="PDF" class="pdf-icon">
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data">
                <label>Cédula y papeleta de votación (PDF)</label>
                <input type="file" name="cedula_pdf" accept="application/pdf" required>
                <button type="submit">Guardar Cédula</button>
            </form>
        </div>
    </div>

    <p class="nota">Para continuar con el ingreso de sus datos personales verifique que su fotografía se visualice en la pantalla y que su cédula esté almacenada.</p>

    <h3>🆔 INFORMACIÓN PERSONAL</h3>
    <div class="grid-form">
        <div>
            <label>Nombre completo</label>
            <input type="text" value="Juan Pérez García" disabled>
        </div>
        <div>
            <label>Matrícula</label>
            <input type="text" value="202012345" disabled>
        </div>
        <div>
            <label>Correo institucional</label>
            <input type="email" value="juan.perez@universidad.edu" disabled>
        </div>
        <div>
            <label>Teléfono</label>
            <input type="text" value="0991234567" disabled>
        </div>
        <div>
            <label>Carrera</label>
            <input type="text" value="Ingeniería en Sistemas" disabled>
        </div>
        <div>
            <label>Fecha de ingreso</label>
            <input type="text" value="01/05/2021" disabled>
        </div>
    </div>
</div>

<!-- ESTILOS -->
<style>
.perfil-container {
    background: #f5f5f5;
    border-radius: 8px;
    padding: 25px;
    font-family: 'Segoe UI', sans-serif;
    max-width: 960px;
    margin: 30px auto;
    box-shadow: 0 0 10px rgba(0,0,0,0.15);
    color: #333;
}
.perfil-container h2, .perfil-container h3 {
    border-bottom: 1px solid #ccc;
    padding-bottom: 5px;
    margin-top: 20px;
}
.documentos-section {
    display: flex;
    gap: 40px;
    margin-top: 20px;
}
.foto-perfil img {
    width: 140px;
    height: 160px;
    object-fit: cover;
    border: 2px solid #ccc;
    margin-bottom: 10px;
}
.foto-perfil form,
.cedula-upload form {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.foto-perfil input[type="file"],
.cedula-upload input[type="file"] {
    font-size: 14px;
}
.foto-perfil button,
.cedula-upload button {
    background: #007BFF;
    color: white;
    border: none;
    padding: 6px;
    border-radius: 4px;
    cursor: pointer;
}
.cedula-upload {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.pdf-icon {
    width: 60px;
    margin-bottom: 8px;
}
.grid-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-top: 20px;
}
.grid-form label {
    font-weight: bold;
    font-size: 14px;
}
.grid-form input {
    width: 100%;
    padding: 6px;
    border-radius: 4px;
    border: 1px solid #aaa;
    background-color: #fff;
}
.nota {
    margin-top: 10px;
    font-size: 13px;
    color: #555;
    font-style: italic;
}
</style>
<?php include("partials/footer_Admin.php"); ?>
