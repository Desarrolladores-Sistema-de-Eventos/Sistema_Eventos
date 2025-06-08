<?php
// restablacer_contraseña.php
// Vista para restablecer contraseña con token
$token = $_GET['token'] ?? '';
if (!$token) {
    echo '<div style="color:red;">Token inválido o faltante.</div>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
    html, body {
        height: 100%;
        font-family: 'Lato', Arial, sans-serif;
        background: #f7f7f7;
    }
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .main-content {
        flex: 1 0 auto;
    }
    footer {
        flex-shrink: 0;
    }
    .reset-container {
        max-width: 420px;
        margin: 60px auto;
        background: #fff;
        padding: 36px 32px 32px 32px;
        border-radius: 14px;
        box-shadow: 0 6px 32px rgba(183,28,28,0.10), 0 1.5px 6px rgba(0,0,0,0.04);
        border-top: 6px solid #B71C1C;
        position: relative;
        transition: box-shadow 0.2s;
    }
    .reset-container h2 {
        text-align: center;
        font-size: 26px;
        margin-bottom: 28px;
        color: #B71C1C;
        font-weight: 700;
        letter-spacing: 1px;
    }
    .reset-container label {
        font-weight: 600;
        color: #B71C1C;
        letter-spacing: 0.5px;
        margin-bottom: 0.3rem;
    }
    .reset-container input {
        width: 100%;
        padding: 12px 14px;
        margin-bottom: 18px;
        border-radius: 6px;
        border: 1.5px solid #B71C1C;
        background: #fafafa;
        font-size: 16px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .reset-container input:focus {
        border-color: #880e4f;
        box-shadow: 0 0 0 0.15rem rgba(183,28,28,0.10);
        background: #fff;
    }
    .reset-container button[type="submit"] {
        width: 100%;
        background: linear-gradient(90deg, #B71C1C 60%, #880e4f 100%);
        color: #fff;
        padding: 13px 0;
        border: none;
        border-radius: 6px;
        font-size: 17px;
        font-weight: 700;
        letter-spacing: 1px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(183,28,28,0.08);
        transition: background 0.2s, box-shadow 0.2s;
        display: block;
        margin-top: 10px;
        margin-bottom: 0;
    }
    .reset-container button[type="submit"]:hover, .reset-container button[type="submit"]:focus {
        background: linear-gradient(90deg, #880e4f 60%, #B71C1C 100%);
        box-shadow: 0 4px 16px rgba(183,28,28,0.13);
    }
    .reset-container .msg {
        margin-top: 18px;
        font-size: 15.5px;
        text-align: center;
        min-height: 32px;
    }
    .reset-container .msg button, .reset-container .msg a {
        margin-top: 12px;
        background: linear-gradient(90deg, #B71C1C 60%, #880e4f 100%);
        color: #fff !important;
        padding: 9px 22px;
        border: none;
        border-radius: 6px;
        font-size: 15.5px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 1.5px 6px rgba(183,28,28,0.10);
        transition: background 0.2s, box-shadow 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .reset-container .msg button:hover, .reset-container .msg button:focus,
    .reset-container .msg a:hover, .reset-container .msg a:focus {
        background: linear-gradient(90deg, #880e4f 60%, #B71C1C 100%);
        box-shadow: 0 3px 12px rgba(183,28,28,0.13);
        color: #fff !important;
    }
    @media (max-width: 600px) {
        .reset-container {
            padding: 18px 6vw 22px 6vw;
            margin: 30px 0;
        }
        .reset-container h2 {
            font-size: 20px;
        }
    }
    </style>
</head>
<body>
    <div class="main-content">
    <!-- Topbar Start -->
    <div class="container-fluid py-2 border-bottom" style="background-color:rgb(255, 255, 255);">
        <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center">
            <div class="d-flex align-items-center mb-2 mb-lg-0">
                <img src="../public/img/sello_UTA.jpg" alt="Logo Facultad" style="height: 60px; margin-right: 10px;">
                <div>
                    <h6 class="mb-0 text-uppercase font-weight-bold" style="color: #660000;">FACULTAD DE INGENIERÍA EN</h6>
                    <h5 class="mb-0 font-weight-bold" style="color: #660000;">SISTEMAS, ELECTRÓNICA E INDUSTRIAL</h5>
                    <span class="badge badge-danger">CTT - TALLERES TECNOLÓGICOS</span>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="text-center mx-3">
                    <i class="fa fa-graduation-cap text-danger fa-2x"></i>
                    <div><a href="#" class="text-dark font-weight-bold"></a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    <div class="reset-container">
        <h2>Restablecer Contraseña</h2>
        <form id="resetForm" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="nueva_contrasena">Nueva contraseña</label>
            <input type="password" name="nueva_contrasena" id="nueva_contrasena" required minlength="6">
            <label for="confirmar_contrasena">Confirmar contraseña</label>
            <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" required minlength="6">
            <button type="submit" id="restablecerBtn">Restablecer</button>
            <div class="msg" id="msg"></div>
        </form>
    </div>
    </div>
    <footer style="background: #B71C1C; color: #fff; padding: 30px 0 0 0; margin-top: 40px;">
      <div class="container">
        <div class="row">
          <!-- Contacto -->
          <div class="col-md-4 mb-4">
            <h5 style="color:#fff; letter-spacing:2px; font-weight:bold;">CONTACTO</h5>
            <ul style="list-style:none; padding-left:0; line-height:1.8;">
              <li><i class="fa fa-envelope"></i> ctt.fisei@uta.edu.ec</li>
              <li><i class="fa fa-clock-o"></i> Lun-Vie: 08:00 - 18:00</li>
              <li><i class="fa fa-phone"></i>(03)3700090</li>
              <li><i class="fa fa-desktop"></i> <a href="#" style="color:#ffc107;">Plataforma Educativa</a></li>
            </ul>
          </div>
         <div class="col-md-4 mb-4">
        <h5 style="color:#fff; letter-spacing:2px; font-weight:bold;">UBICACIÓN</h5>
        <ul style="list-style:none; padding-left:0; line-height:1.8;">
            <li><i class="fa fa-map-marker"></i> Av. Los Chasquis y Río Guayllabamba</li>
            <li><i class="fa fa-map"></i> <a href="https://maps.app.goo.gl/3Gffknn2nbLt13g47" target="_blank" style="color:#fff; text-decoration:underline;">Ver en Google Maps</a></li>
        </ul>
    </div>
          <!-- Información -->
          <div class="col-md-4 mb-4">
            <h5 style="color:#fff; letter-spacing:2px; font-weight:bold;">INFORMACIÓN</h5>
            <p>Cuéntanos tus inquietudes o dudas.</p>
            <button style="background:#880e4f; color:#fff; border:none; padding:10px 20px; border-radius:4px; font-weight:bold;">Solicitar Información – CTT</button>
          </div>
        </div>

        <div class="row" style="border-top:1px solid #e0e0e0; margin-top:20px; padding-top:10px;">
          <div class="col-md-8">
            <small>© Universidad Técnica de Ambato – Todos los derechos reservados</small>
          </div>
          <div class="col-md-4 text-right">
            <small>
              <a href="#" style="color:#fff; margin-right:15px;">Autores</a>
              <a href="#" style="color:#fff;">FAQ</a>
            </small>
          </div>
        </div>

        <!-- Botón flotante -->
        <button onclick="window.scrollTo({top:0,behavior:'smooth'});"
          style="position:fixed; bottom:20px; right:30px; background:#880e4f; color:#fff; border:none; border-radius:6px; width:40px; height:40px; font-size:22px; z-index:999;">
          <i class="fa fa-angle-up"></i>
        </button>
      </div>
    </footer>
<script>
// Validación y envío AJAX
const form = document.getElementById('resetForm');
const msg = document.getElementById('msg');
form.addEventListener('submit', async function(e) {
    e.preventDefault();
    const pass1 = form.nueva_contrasena.value;
    const pass2 = form.confirmar_contrasena.value;
    if (pass1 !== pass2) {
        msg.style.color = 'red';
        msg.textContent = 'Las contraseñas no coinciden.';
        return;
    }
    msg.textContent = '';
    const data = {
        token: form.token.value,
        nueva_contrasena: pass1
    };
    try {
        const res = await fetch('../controllers/RecuperaContrasenaController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const json = await res.json();
        if (json.ok) {
            msg.style.color = 'green';
            msg.textContent = 'Contraseña restablecida correctamente. Redirigiendo...';
            setTimeout(() => window.location.href = 'login.php', 2000);
        } else {
            msg.style.color = 'red';
            msg.textContent = json.error || 'Error al restablecer la contraseña.';
        }
    } catch (err) {
        msg.style.color = 'red';
        msg.textContent = 'Error de red o del servidor.';
    }
});
</script>
</body>
</html>
