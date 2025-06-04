// ==== LOGIN ====
const formLogin = document.getElementById('formLogin');
if (formLogin) {
  formLogin.addEventListener('submit', async function (e) {
    e.preventDefault();
    const correo = document.getElementById('correo').value;
    const contrasena = document.getElementById('contrasena').value;

    try {
      const res = await fetch('../controllers/LoginController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ correo, contrasena })
      });

      const data = await res.json();

      if (res.ok && data.ok) {
        Swal.fire({
          icon: 'success',
          title: 'Bienvenido',
          text:  data.usuario.NOMBRES,
          timer: 1500,
          showConfirmButton: false
        });

        setTimeout(() => {
          window.location.href = '../public/index.php';
        }, 1600);
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: data.error || 'No se pudo iniciar sesión'
        });
      }
    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Error de red',
        text: 'Intenta nuevamente más tarde.'
      });
      console.error(error);
    }
  });
}