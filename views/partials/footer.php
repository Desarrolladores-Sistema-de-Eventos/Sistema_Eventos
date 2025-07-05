<link rel="stylesheet" href="../public/css/style.css">
<style>
   .footer-uta {
    background: linear-gradient(to right, rgb(56, 57, 59), #212529);
    padding-top: 18px !important;
    padding-bottom: 10px !important;
    min-height: unset !important;
  }
  .footer-uta .mb-4 {
    margin-bottom: 10px !important;
  }
  .footer-uta .row {
    margin-bottom: 0 !important;
  }
  
</style>
<?php include "../views/solicitud_usuario.php"?>
<footer class="footer-uta" style="color: #fff; margin-top: 40px;">
  <div class="container">
    <div class="row">
      <!-- Contacto -->
      <div class="col-md-4 mb-4">
        <h5 style="color:#fff; letter-spacing:2px; font-weight:bold;">CONTACTO</h5>
        <ul style="list-style:none; padding-left:0; line-height:1.8;">
          <li><i class="fa fa-envelope"></i> ctt.fisei@uta.edu.ec</li>
          <li><i class="fa fa-clock-o"></i> Lun-Vie: 08:00 - 18:00</li>
          <li><i class="fa fa-phone"></i>(03)3700090</li>
          <li><i class="fa fa-desktop"></i> <a href="#" style="color:rgb(253, 251, 251);;">Plataforma Educativa</a></li>
        </ul>
      </div>
     <div class="col-md-4 mb-4">
    <h5 style="color:#fff; letter-spacing:2px; font-weight:bold;">UBICACIÓN</h5>
    <ul style="list-style:none; padding-left:0; line-height:1.8;">
        <li><i class="fa fa-map-marker"></i> Av. Los Chasquis y Río Guayllabamba</li>
        <li><i class="fa fa-map"></i> <a href="https://maps.app.goo.gl/3Gffknn2nbLt13g47" target="_blank" style="color:#fff; text-decoration:underline;">Ver en Google Maps</a></li>
    </ul>
</div>
      <!-- Información -->
      <div class="col-md-4 mb-4">
  <h5 style="color:#fff; letter-spacing:2px; font-weight:bold;">INFORMACIÓN</h5>
  <p>Cuéntanos tus inquietudes o dudas.</p>
  <a href="../views/contact.php">
    <button style="background:rgb(134, 17, 17); color:#fff; border:none; padding:10px 20px; border-radius:4px; font-weight:bold;">
      Solicitar Información – CTT
    </button>
  </a>
</div>
    <div class="row" style="border-top:1px solid #e0e0e0; margin-top:20px; padding-top:10px;">
      <div class="col-md-8">
        <small>© Universidad Técnica de Ambato – Todos los derechos reservados</small>
      </div>
      <div class="col-md-4 text-right">
        <small>
          <a href="#" style="color:#fff; margin-right:15px;">Autores</a>
          <a href="#" style="color:#fff;">FAQ</a>
        </small>
      </div>
    </div>


    <!-- Botón flotante -->
    <button onclick="window.scrollTo({top:0,behavior:'smooth'});"
      style="position:fixed; bottom:20px; right:30px; background: rgb(97, 5, 5); color:#fff; border:none; border-radius:6px; width:40px; height:40px; font-size:22px; z-index:999;">
      <i class="fa fa-angle-up"></i>
    </button>
  </div>
</footer>
