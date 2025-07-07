<!-- === ENCABEZADO UTA MODERNO === -->
<style>
    :root {
        --uta-rojo: #ae0c22;
        --uta-oscuro: #1a1a1a;
        --uta-gris: #f5f5f5;
        --uta-blanco: #ffffff;
    }

    .encabezado-uta {
        background: var(--uta-blanco);
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
    }

    .encabezado-uta h6,
    .encabezado-uta h5 {
        margin: 0;
        line-height: 1;
        letter-spacing: 1px;
    }

    .encabezado-uta h6 {
        font-size: 0.8rem;
        color: var(--uta-rojo);
        font-weight: 700;
    }

    .encabezado-uta h5 {
        font-size: 1.2rem;
        color: var(--uta-rojo);
        font-weight: 700;
    }

    .encabezado-uta .campus-label {
        background-color: var(--uta-rojo);
        color: #fff;
        font-size: 0.75rem;
        padding: 0.2rem 0.8rem;
        border-radius: 1rem;
        display: inline-block;
        margin-top: 0.3rem;
        font-weight: 600;
    }

    .encabezado-uta .educativa-link {
        color: var(--uta-oscuro);
        font-weight: 600;
        text-decoration: none;
    }

    .encabezado-uta .educativa-link:hover {
        color: var(--uta-rojo);
        text-decoration: underline;
    }
</style>

<div class="container-fluid encabezado-uta shadow-sm">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center">
            <img src="../public/img/logo.png" alt="Logo UTA" style="height: 60px; margin-right: 15px;">
            <div>
                <h6 class="text-uppercase">UNIVERSIDAD</h6>
                <h5 class="text-uppercase">TÉCNICA DE AMBATO</h5>
                <span class="campus-label">CAMPUS HUACHI</span>
            </div>
        </div>
        <div class="text-center">
            <i class="fas fa-graduation-cap fa-2x text-danger mb-2"></i><br>
            <a href="../views/login.php" class="educativa-link">Plataforma Educativa</a>
        </div>
    </div>
</div>

<?php include('navbar.php'); ?>
