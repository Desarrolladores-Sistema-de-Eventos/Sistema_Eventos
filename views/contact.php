<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contáctanos | UTA</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='black' d='M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.32.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z'/></svg>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../public/img/favicon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --uta-rojo: #b10024; /* Primario: Rojo */
            --uta-negro: #1a1a1a; /* Secundario: Negro */
            --uta-blanco: #ffffff; /* Complemento: Blanco */
            --uta-gris: #f8f9fa; /* Gris claro para fondos, manteniendo consistencia */
            --uta-texto-claro: #6c757d; /* Color para texto secundario o "muted" */
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--uta-gris); /* Fondo general de la página */
            color: var(--uta-negro); /* Color de texto por defecto */
        }
        .uta-header {
            background-color: var(--uta-rojo); /* Fondo del encabezado en rojo primario */
            color: var(--uta-blanco); /* Texto del encabezado en blanco */
        }
        .uta-card-icon {
            font-size: 2.5rem;
            color: var(--uta-rojo); /* Iconos de las tarjetas en rojo primario */
        }
        .form-control:focus {
            border-color: var(--uta-rojo);
            box-shadow: 0 0 0 0.25rem rgba(177, 0, 36, 0.2);
        }
        .btn-uta {
            background-color: var(--uta-rojo); /* Botón principal en rojo primario */
            color: var(--uta-blanco); /* Texto del botón en blanco */
            font-weight: 600;
        }
        .btn-uta:hover {
            background-color: #94001d; /* Rojo más oscuro al pasar el ratón */
        }
        .social-icons i {
            font-size: 1.3rem;
            margin-right: 10px;
            color: var(--uta-negro); /* Iconos de redes sociales en negro secundario */
            transition: color 0.3s ease;
        }
        .social-icons i:hover {
            color: var(--uta-rojo); /* Iconos de redes sociales en rojo al pasar el ratón */
        }

        .card {
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid transparent; /* Define el borde base */
        }

        .card:hover {
            transform: scale(1.03);
            border-color: var(--uta-rojo); /* Borde de la tarjeta en rojo al pasar el ratón */
            box-shadow: 0 10px 20px rgba(177, 0, 36, 0.3); /* Sombra suave en rojo */
        }

        /* Estilos específicos para texto */
        .text-secondary {
            color: var(--uta-negro) !important; /* Texto secundario en negro */
        }
        .text-muted {
            color: var(--uta-texto-claro) !important; /* Texto "muted" en gris claro */
        }
        .text-danger {
            color: var(--uta-rojo) !important; /* Texto de peligro/importancia en rojo */
        }
    </style>
</head>
<body>
<?php include('partials/header.php'); ?>

<section class="uta-header text-center py-5">
    <div class="container">
        <h1 class="display-5 fw-bold">Contáctanos</h1>
        <p class="mb-0 text-uppercase"><a class="text-white text-decoration-none" href="index.php">Inicio</a> <i class="fa fa-angle-double-right mx-2"></i> Contacto</p>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-uppercase text-secondary fw-semibold" style="letter-spacing: 2px;">Soporte y Ayuda</h6>
        <h2 class="fw-bold">¿Tienes dudas o sugerencias?</h2>
        <p class="text-muted">Estamos aquí para ayudarte. Contáctanos por cualquiera de los siguientes medios.</p>
    </div>

    <div class="row text-center g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="fa fa-envelope uta-card-icon mb-3"></i>
                    <h5>Correo</h5>
                    <p>soporte@uta.edu.ec</p>
                    <small class="text-muted">Respuesta en menos de 24h</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="fa fa-phone uta-card-icon mb-3"></i>
                    <h5>Teléfono</h5>
                    <p>+593 3 299-8000</p>
                    <small class="text-muted">Lunes a Viernes, 8:00 - 17:00</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="fa fa-map-marker-alt uta-card-icon mb-3"></i>
                    <h5>Dirección</h5>
                    <p>Av. Los Chasquis y Río Guayllabamba, Ambato</p>
                    <small class="text-muted">Edificio Central, Planta Baja</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="text-danger mb-4"><i class="fa fa-headset me-2"></i> Envíanos un mensaje</h4>
                <form id="contactForm" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" placeholder="Tu nombre" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" placeholder="Tu correo" required>
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control" name="subject" placeholder="Asunto" required>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control" name="message" rows="5" placeholder="Mensaje" required></textarea>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-uta px-5 py-2">
                                <i class="fa fa-paper-plane me-2"></i>Enviar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <div class="ratio ratio-16x9 shadow-sm border rounded">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.72667822941!2d-78.61868352467389!3d-1.2464731355447155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d38201a4f0b2f5%3A0xc3f8e5d0f6b3e9a7!2sUniversidad%20T%C3%A9cnica%20de%20Ambato!5e0!3m2!1ses-419!2sec!4v1700000000000!5m2!1ses-419!2sec" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <p class="mb-1 fw-semibold">Síguenos en redes sociales:</p>
        <div class="social-icons">
            <a href="https://www.facebook.com/search/top?q=universidad%20t%C3%A9cnica%20de%20ambato%20-%20oficial" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://x.com/UTecnicaAmbato?ref_src=twsrc%55Egoogle%7Ctwcamp%55Eserp%7Ctwgr%55Eauthor" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com/utecnicaambato/?hl=es" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/@UTecnicaAmbato" target="_blank"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</section>

<?php include('partials/footer.php'); ?>

<a href="#" class="btn btn-uta btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('contactForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    try {
        const response = await fetch('../controllers/ContactoController.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if (result.success) {
            alert('Mensaje enviado con éxito. ¡Gracias por contactarnos!');
            this.reset();
        } else {
            alert('Hubo un error al enviar tu mensaje: ' + result.message);
        }
    } catch (error) {
        console.error('Error al enviar el formulario:', error);
        alert('Hubo un problema de conexión al enviar el mensaje. Inténtalo de nuevo más tarde.');
    }
});
</script>
</body>
</html>