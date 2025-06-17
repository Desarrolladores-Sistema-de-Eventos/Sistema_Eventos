<?php 
// Vista para solicitar recuperación de contraseña
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
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
    .recuperar-container {
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
    .recuperar-container h2 {
        text-align: center;
        font-size: 26px;
        margin-bottom: 28px;
        color: #B71C1C;
        font-weight: 700;
        letter-spacing: 1px;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    label {
        display: block;
        margin-bottom: .5rem;
        font-weight: 600;
        color: #B71C1C;
        letter-spacing: 0.5px;
    }
    .form-control {
        width: 100%;
        padding: 12px 14px;
        font-size: 16px;
        border: 1.5px solid #B71C1C;
        border-radius: 6px;
        outline: none;
        background: #fafafa;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color: #880e4f;
        box-shadow: 0 0 0 0.15rem rgba(183,28,28,0.10);
        background: #fff;
    }
    .btn-submit {
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
    }
    .btn-submit:hover, .btn-submit:focus {
        background: linear-gradient(90deg, #880e4f 60%, #B71C1C 100%);
        box-shadow: 0 4px 16px rgba(183,28,28,0.13);
    }
    .msg {
        margin-top: 18px;
        font-size: 15.5px;
        text-align: center;
        min-height: 32px;
    }
    .msg button {
        margin-top: 12px;
        background: linear-gradient(90deg, #B71C1C 60%, #880e4f 100%);
        color: #fff;
        padding: 9px 22px;
        border: none;
        border-radius: 6px;
        font-size: 15.5px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 1.5px 6px rgba(183,28,28,0.10);
        transition: background 0.2s, box-shadow 0.2s;
    }
    .msg button:hover, .msg button:focus {
        background: linear-gradient(90deg, #880e4f 60%, #B71C1C 100%);
        box-shadow: 0 3px 12px rgba(183,28,28,0.13);
    }
    @media (max-width: 600px) {
        .recuperar-container {
            padding: 18px 6vw 22px 6vw;
            margin: 30px 0;
        }
        .recuperar-container h2 {
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
<div class="recuperar-container">
    <h2>Recuperar Contraseña</h2>
    <form id="recuperarForm" method="post">
        <div class="form-group">
            <label for="correo">Correo electrónico</label>
            <input type="email" name="correo" id="correo" class="form-control" placeholder="Ej: ejemplo@uta.edu.ec" required>
        </div>
        <div class="form-group">
            <button type="submit" id="enviarBtn" class="btn-submit">Enviar enlace</button>
        </div>
        <div class="msg" id="msg"></div>
    </form>
</div>

<script>
const form = document.getElementById('recuperarForm');
const enviarBtn = document.getElementById('enviarBtn');
const msg = document.getElementById('msg');
let timerInterval, timerTimeout;
let intentoReenvio = false;

// Inicia el temporizador y oculta el botón
function startCountdown() {
    let seconds = 120;
    enviarBtn.style.display = 'none';
    msg.style.color = 'green';
    msg.textContent = `Revisa tu correo para el enlace de recuperación. (02:00)`;

    timerInterval = setInterval(() => {
        seconds--;
        const min = String(Math.floor(seconds / 60)).padStart(2, '0');
        const sec = String(seconds % 60).padStart(2, '0');
        msg.textContent = `Revisa tu correo para el enlace de recuperación. (${min}:${sec})`;
        if (seconds <= 0) clearInterval(timerInterval);
    }, 1000);

    timerTimeout = setTimeout(() => {
        clearInterval(timerInterval);
        msg.style.color = 'red';
        msg.innerHTML = `
            No has recibido el correo. ¿Quieres intentarlo de nuevo?<br>
            <button id="reenviarBtn">Volver a enviar</button>
        `;
        const reenviarBtn = document.getElementById('reenviarBtn');
        reenviarBtn.addEventListener('click', function() {
            msg.textContent = '';
            enviarBtn.textContent = 'Volver a enviar';
            enviarBtn.style.display = 'none'; // Oculta el botón principal hasta que termine el reenvío
            intentoReenvio = true;
            enviarSolicitud(); // Hace lo mismo que el botón principal
        });
    }, 120000);
}

// Envía la solicitud y gestiona el flujo
async function enviarSolicitud() {
    const correo = form.correo.value.trim();

    if (!(correo.endsWith('@uta.edu.ec') || correo.endsWith('@gmail.com'))) {
        msg.style.color = 'red';
        msg.textContent = 'Solo se permiten correos @uta.edu.ec o @gmail.com';
        return;
    }

    msg.textContent = '';
    enviarBtn.disabled = true;

    try {
        const res = await fetch('../controllers/SolicitaRecuperaController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ correo })
        });

        const text = await res.text();
        let json;

        try {
            json = JSON.parse(text);
        } catch {
            msg.style.color = 'red';
            msg.textContent = 'Respuesta inválida del servidor.';
            enviarBtn.disabled = false;
            return;
        }

        if (json.ok) {
            startCountdown();
        } else {
            msg.style.color = 'red';
            msg.textContent = json.error || 'No se pudo enviar el enlace.';
            enviarBtn.disabled = false;
        }
    } catch (error) {
        msg.style.color = 'red';
        msg.textContent = 'Error de red o del servidor.';
        enviarBtn.disabled = false;
    }
}

// Evento de envío del formulario
form.addEventListener('submit', function(e) {
    e.preventDefault();
    intentoReenvio = false;
    enviarSolicitud();
});
</script>
<script type="module" src="../public/js/login.js"></script>
 <script src="../public/mail/jqBootstrapValidation.min.js"></script>
    <script src="../public/mail/contact.js"></script>

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
</body>
</html>
