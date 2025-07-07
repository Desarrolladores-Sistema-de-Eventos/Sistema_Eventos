<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contáctanos | UTA</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='black' d='M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.32.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z'/></svg>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../public/img/favicon.ico">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --uta-rojo: #b10024;
            --uta-gris: #f8f9fa;
        }
        body {
            font-family: 'Poppins', sans-serif;
        }
        .uta-header {
            background-color: var(--uta-rojo);
            color: white;
        }
        .uta-card-icon {
            font-size: 2.5rem;
            color: var(--uta-rojo);
        }
        .form-control:focus {
            border-color: var(--uta-rojo);
            box-shadow: 0 0 0 0.25rem rgba(177, 0, 36, 0.2);
        }
        .btn-uta {
            background-color: var(--uta-rojo);
            color: white;
            font-weight: 600;
        }
        .btn-uta:hover {
            background-color: #94001d;
        }
        .social-icons i {
            font-size: 1.3rem;
            margin-right: 10px;
            color: var(--uta-rojo);
        }

.card {
    transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid transparent; /* Define el borde base */
}

.card:hover {
    transform: scale(1.03);
    border-color: #b10024; /* Rojo institucional UTA */
    box-shadow: 0 10px 20px rgba(177, 0, 36, 0.3); /* Sombra suave en rojo */
}




    </style>
</head>
<body>
<?php include('partials/header.php'); ?>

<!-- HEADER -->
<section class="uta-header text-center py-5">
    <div class="container">
        <h1 class="display-5 fw-bold">Contáctanos</h1>
        <p class="mb-0 text-uppercase"><a class="text-white text-decoration-none" href="index.php">Inicio</a> <i class="fa fa-angle-double-right mx-2"></i> Contacto</p>
    </div>
</section>

<!-- INFORMACIÓN DE CONTACTO -->
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

    <!-- FORMULARIO -->
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

    <!-- MAPA DE UBICACIÓN -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <div class="ratio ratio-16x9 shadow-sm border rounded">
                <iframe src="https://www.google.com/maps?q=Universidad+T%C3%A9cnica+de+Ambato&output=embed" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- REDES SOCIALES -->
    <div class="text-center mt-4">
        <p class="mb-1 fw-semibold">Síguenos en redes sociales:</p>
        <div class="social-icons">
            <a href="https://www.facebook.com/search/top?q=universidad%20t%C3%A9cnica%20de%20ambato%20-%20oficial" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://x.com/UTecnicaAmbato?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com/utecnicaambato/?hl=es" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/@utecnicaambato" target="_blank"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</section>

<?php include('partials/footer.php'); ?>

<a href="#" class="btn btn-uta btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('contactForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    await fetch('../controllers/ContactoController.php', {
        method: 'POST',
        body: formData
    });
    this.reset();
});
</script>
</body>
</html>
