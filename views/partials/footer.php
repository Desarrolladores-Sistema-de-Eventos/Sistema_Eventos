<footer class="footer-uta text-light pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row">

            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase fw-bold mb-3 text-uta">Universidad Técnica de Ambato</h5>
                <p class="small footer-text">
                    Educación superior con excelencia académica, compromiso social e innovación científica para el desarrollo del Ecuador.
                </p>
            </div>

            <div class="col-md-4 mb-4">
                <h6 class="text-uppercase fw-bold mb-3 text-uta">Accesos Rápidos</h6>
                <ul class="list-unstyled small">
                    <li><a href="../public/index.php" class="footer-link">Inicio</a></li>
                    <li><a href="../views/about.php" class="footer-link">Nuestra Facultad</a></li>
                    <li><a href="../views/eventos.php" class="footer-link">Eventos Académicos</a></li>
                    <li><a href="../views/contacto.php" class="footer-link">Contáctanos</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h6 class="text-uppercase fw-bold mb-3 text-uta">Contacto</h6>
                <p class="small footer-text"><i class="fas fa-map-marker-alt me-2"></i> Ambato, Tungurahua - Ecuador</p>
                <p class="small footer-text"><i class="fas fa-phone me-2"></i> +593 3 2520 411</p>
                <p class="small footer-text"><i class="fas fa-envelope me-2"></i> info@uta.edu.ec</p>
                <p class="small footer-text"><i class="fas fa-globe me-2"></i> <a href="https://www.uta.edu.ec" class="footer-link">www.uta.edu.ec</a></p>
            </div>
        </div>

        <hr class="border-secondary-color mt-4" style="opacity: 0.15;">

        <div class="text-center small text-light">
            &copy; <?= date("Y") ?> Universidad Técnica de Ambato - Facultad de Ingeniería en Sistemas, Electrónica e Industrial.
        </div>
    </div>
</footer>

<style>
    :root {
        --uta-rojo: #b10024; /* Color primario: Rojo */
        --uta-negro: #1a1a1a; /* Color secundario: Negro */
        --uta-blanco: #ffffff; /* Color de complemento: Blanco */
        --uta-gris: #f8f9fa; /* Manteniendo el gris claro para fondos */
    }

    .footer-uta {
        /* Degradado de negro para el fondo del footer */
        background: linear-gradient(to right, var(--uta-negro), #212529); 
    }

    .text-uta {
        color: var(--uta-rojo); /* El texto 'UTA' en rojo */
    }

    .text-uta:hover {
        color: #e32e2e; /* Un rojo un poco más claro al pasar el mouse */
    }

    .footer-link {
        color: var(--uta-blanco); /* Los enlaces del footer en blanco */
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .footer-link:hover {
        color: var(--uta-rojo); /* Los enlaces del footer en rojo al pasar el mouse */
        padding-left: 3px;
    }

    .footer-text {
        color: #ddd; /* Un gris claro para el texto general del footer */
    }

    footer i {
        color: var(--uta-rojo); /* Los iconos en rojo */
        margin-right: 6px;
    }

    footer img {
        transition: transform 0.3s ease;
    }

    footer img:hover {
        transform: scale(1.05);
    }

    /* Nuevas clases para la paleta de colores si no las habías incluido */
    .text-secondary-color { 
        color: var(--uta-negro) !important;
    }

    .bg-primary-color { 
        background-color: var(--uta-rojo) !important;
    }

    .bg-secondary-color { 
        background-color: var(--uta-negro) !important;
    }

    .border-primary-color { 
        border-color: var(--uta-rojo) !important;
    }

    .border-secondary-color { 
        border-color: var(--uta-negro) !important;
    }

    @media (max-width: 576px) {
        .footer-uta {
            text-align: center;
        }

        .footer-uta .col-md-4 {
            margin-bottom: 2rem;
        }
    }
</style>