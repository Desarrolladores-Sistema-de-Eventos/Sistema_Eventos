<?php
$token = $_GET['token'] ?? '';
if (!$token) {
    echo '<div style="color:red;">Token inválido o faltante.</div>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Restablecer Contraseña</title>
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Lato', sans-serif;
      background-color: #f6f7f9;
    }

    .banner-uta img {
      width: 100%;
      height: auto;
      display: block;
    }

    .main-content {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 0;
      min-height: 80vh;
    }

    .reset-container {
      background: #fff;
      border-top: 5px solid #8B0000;
      border-radius: 16px;
      padding: 40px;
      max-width: 420px;
      width: 100%;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
      animation: fadeInDown 0.5s ease;
    }

    .reset-container h2 {
      text-align: center;
      color: #8B0000;
      font-weight: bold;
      margin-bottom: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
    }

    .reset-container label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #8B0000;
    }

    .reset-container input[type="password"] {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      border: 1.5px solid #ccc;
      border-radius: 6px;
      margin-bottom: 20px;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .reset-container input:focus {
      border-color: #8B0000;
      box-shadow: 0 0 0 0.15rem rgba(139, 0, 0, 0.25);
      outline: none;
    }

    .reset-container button {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      font-weight: bold;
      background: linear-gradient(90deg, #8B0000, #660033);
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .reset-container button:hover {
      background: linear-gradient(90deg, #660033, #8B0000);
    }

    .msg {
      margin-top: 15px;
      font-size: 15px;
      text-align: center;
      min-height: 30px;
    }

    footer {
      background: #B71C1C;
      color: #fff;
      text-align: center;
      padding: 20px 10px;
      font-size: 14px;
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
  </style>
</head>
<body>

  <!-- Banner -->
  <div class="banner-uta">
    <img src="../public/img/uta/header.png" alt="Banner UTA">
  </div>

  <!-- Formulario -->
  <div class="main-content">
    <div class="reset-container">
      <h2><i class="fa fa-refresh"></i> Restablecer Contraseña</h2>
      <form id="resetForm" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <label for="nueva_contrasena">Nueva Contraseña</label>
        <input type="password" name="nueva_contrasena" id="nueva_contrasena" required minlength="6">
        <label for="confirmar_contrasena">Confirmar Contraseña</label>
        <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" required minlength="6">
        <button type="submit" id="restablecerBtn">Restablecer</button>
        <div class="msg" id="msg"></div>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    © Universidad Técnica de Ambato – Todos los derechos reservados
  </footer>

  <script>
    const form = document.getElementById('resetForm');
    const msg = document.getElementById('msg');

    form.addEventListener('submit', async function (e) {
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
