
<footer class="footer-uta text-light pt-5 pb-4 mt-5">
  <div class="container">
    <div class="row">

      <!-- Institucional -->
      <div class="col-md-4 mb-4">
        <h5 class="text-uppercase fw-bold mb-3 text-uta">Universidad Técnica de Ambato</h5>
        <p class="small footer-text">
          Educación superior con excelencia académica, compromiso social e innovación científica para el desarrollo del Ecuador.
        </p>
      </div>

      <!-- Navegación -->
      <div class="col-md-4 mb-4">
        <h6 class="text-uppercase fw-bold mb-3 text-uta">Accesos Rápidos</h6>
        <ul class="list-unstyled small">
          <li><a href="../public/index.php" class="footer-link">Inicio</a></li>
          <li><a href="../views/about.php" class="footer-link">Nuestra Facultad</a></li>
          <li><a href="../views/eventos.php" class="footer-link">Eventos Académicos</a></li>
          <li><a href="../views/contacto.php" class="footer-link">Contáctanos</a></li>
        </ul>
      </div>

      <!-- Contacto -->
      <div class="col-md-4 mb-4">
        <h6 class="text-uppercase fw-bold mb-3 text-uta">Contacto</h6>
        <p class="small footer-text"><i class="fas fa-map-marker-alt me-2"></i> Ambato, Tungurahua - Ecuador</p>
        <p class="small footer-text"><i class="fas fa-phone me-2"></i> +593 3 2520 411</p>
        <p class="small footer-text"><i class="fas fa-envelope me-2"></i> info@uta.edu.ec</p>
        <p class="small footer-text"><i class="fas fa-globe me-2"></i> <a href="https://www.uta.edu.ec" class="footer-link">www.uta.edu.ec</a></p>
      </div>
    </div>

    <hr class="border-secondary mt-4" style="opacity: 0.15;">

    <!-- Pie -->
    <div class="text-center small text-light">
      &copy; <?= date("Y") ?> Universidad Técnica de Ambato - Facultad de Ingeniería en Sistemas, Electrónica e Industrial.
    </div>
  </div>
</footer>

<style>
  .footer-uta {
    background: linear-gradient(to right, rgb(56, 57, 59), #212529);
  }

  .text-uta {
    color: #b10024;
  }

  .text-uta:hover {
    color: #e32e2e;
  }

  .footer-link {
    color: #ccc;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .footer-link:hover {
    color: #ff4d4d;
    padding-left: 3px;
  }

  .footer-text {
    color: #ddd;
  }

  footer i {
    color: #dc3545;
    margin-right: 6px;
  }

  footer img {
    transition: transform 0.3s ease;
  }

  footer img:hover {
    transform: scale(1.05);
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
  