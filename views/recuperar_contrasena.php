<?php 
// Vista para solicitar recuperación de contraseña
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar Contraseña</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Fuentes e íconos -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="../public/css/style.css">

  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Lato', sans-serif;
      background-color: #f4f4f4;
    }

    .main-content {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 15px;
      min-height: 100vh;
    }

    .recuperar-container {
      background-color: #fff;
      border: 2px solid #8B0000;
      border-top: 6px solid #8B0000;
      border-radius: 14px;
      padding: 35px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      animation: fadeInDown 0.5s ease;
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .form-title {
      text-align: center;
      color: #8B0000;
      font-weight: bold;
      font-size: 22px;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: #111;
      display: block;
    }

    .form-control {
      width: 100%;
      padding: 12px 14px;
      font-size: 16px;
      border: 1.5px solid #ccc;
      border-radius: 6px;
      background: #fafafa;
      transition: border-color 0.3s;
    }

    .form-control:focus {
      border-color: #8B0000;
      box-shadow: 0 0 0 0.15rem rgba(139, 0, 0, 0.25);
      background-color: #fff;
      outline: none;
    }

    .btn-submit {
      width: 100%;
      background-color: #8B0000;
      color: #fff;
      padding: 12px;
      font-weight: bold;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn-submit:hover {
      background-color: #600000;
    }

    .msg {
      margin-top: 18px;
      font-size: 15px;
      text-align: center;
      min-height: 32px;
    }

    .msg button {
      margin-top: 12px;
      background-color: #8B0000;
      color: #fff;
      padding: 9px 22px;
      border: none;
      border-radius: 6px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
    }

    .msg button:hover {
      background-color: #600000;
    }
  </style>
</head>
<body>

<!-- Banner institucional -->
<div class="banner-uta">
  <img src="../public/img/uta/header.png" alt="Banner UTA" style="width: 100%; height: auto; display: block;">
</div>

<!-- Contenido -->
<div class="main-content">
  <div class="recuperar-container">
    <div class="text-center mb-3">
      <i class="fas fa-unlock-alt" style="font-size: 40px; color: #8B0000;"></i>
    </div>
    <h2 class="form-title d-flex align-items-center justify-content-center gap-2">
      <i class="fas fa-envelope-open-text" style="color: #8B0000;"></i>
      Recuperar Contraseña
    </h2>

    <form id="recuperarForm" method="post">
      <div class="form-group">
        <label for="correo" class="form-label">
          <i class="fas fa-envelope"></i> Correo institucional
        </label>
        <input type="email" name="correo" id="correo" class="form-control" placeholder="ejemplo@uta.edu.ec" required>
      </div>

      <div class="form-group">
        <button type="submit" id="enviarBtn" class="btn-submit">
          <i class="fas fa-paper-plane"></i> Enviar enlace
        </button>
      </div>

      <div class="msg" id="msg"></div>
    </form>
  </div>
</div>

<!-- JS para recuperación -->
<script>
const form = document.getElementById('recuperarForm');
const enviarBtn = document.getElementById('enviarBtn');
const msg = document.getElementById('msg');
let timerInterval, timerTimeout;
let intentoReenvio = false;

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
    reenviarBtn.addEventListener('click', function () {
      msg.textContent = '';
      enviarBtn.textContent = 'Volver a enviar';
      enviarBtn.style.display = 'none';
      intentoReenvio = true;
      enviarSolicitud();
    });
  }, 120000);
}

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

form.addEventListener('submit', function (e) {
  e.preventDefault();
  intentoReenvio = false;
  enviarSolicitud();
});
</script>

<!-- JS extra -->
<script src="../public/js/jquery.min.js"></script>
<script src="../public/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="module" src="../public/js/login.js"></script>
<script src="../public/mail/jqBootstrapValidation.min.js"></script>
<script src="../public/mail/contact.js"></script>

<?php include('partials/footer.php'); ?>
</body>
</html>
