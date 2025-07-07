<style>
    .navbar-modern {
        background-color: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        transition: background-color 0.3s ease;
    }

    .navbar-modern .nav-link {
        font-weight: 600;
        color: #1a1a1a !important;
        transition: color 0.3s ease;
    }

    .navbar-modern .nav-link:hover {
        color: var(--uta-rojo) !important;
    }

    .navbar-modern .navbar-brand h2 {
        color: var(--uta-rojo);
        font-weight: bold;
    }

    .navbar-modern .navbar-brand h2 span {
        color: #000;
    }

    .navbar-modern.sticky-top {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container-fluid p-0 sticky-top">
    <div class="container-lg px-0">
        <nav class="navbar navbar-expand-lg navbar-light navbar-modern py-3 px-3 px-lg-4 rounded-bottom shadow-sm">
            <a href="../public/index.php" class="navbar-brand d-flex align-items-center">
                <i class="fas fa-laptop-code me-2 text-danger fs-4"></i>
                <h2 class="mb-0">MY<span>CS</span></h2>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
                <div class="navbar-nav gap-2">
                    <a href="../public/index.php" class="nav-item nav-link active">Inicio</a>
                    <a href="../views/Eventos_Publico.php" class="nav-item nav-link">Eventos Académicos</a>
                    <a href="../views/about.php" class="nav-item nav-link">Nosotros</a>
                    <a href="../views/contact.php" class="nav-item nav-link">Contáctanos</a>
                </div>
            </div>
        </nav>
    </div>
</div>
