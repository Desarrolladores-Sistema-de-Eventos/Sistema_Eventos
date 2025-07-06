
    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-light navbar-light shadow-lg py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="" class="navbar-brand">
                    <h1 class="m-0 text-primary">
                    <i class="fas fa-laptop-code me-2"></i> 
                    <span class="text-dark">EVENTS</span>SOFT
                    </h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <?php
                        $current = basename($_SERVER['PHP_SELF']);
                        ?>
                        <a href="../public/index.php" class="nav-item nav-link<?= ($current == 'index.php') ? ' active' : '' ?>">Home</a>
                        <a href="../views/Eventos_Publico.php" class="nav-item nav-link<?= ($current == 'Eventos_Publico.php') ? ' active' : '' ?>">Eventos Académicos</a>
                        <a href="../views/about.php" class="nav-item nav-link<?= ($current == 'about.php') ? ' active' : '' ?>">Nosotros</a>
                        <a href="../views/contact.php" class="nav-item nav-link<?= ($current == 'contact.php') ? ' active' : '' ?>">Contáctanos</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->