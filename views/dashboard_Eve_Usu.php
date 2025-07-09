<?php include("partials/header_Admin.php"); ?>
<?php 
$rolesPermitidos = ['DOCENTE', 'ESTUDIANTE', 'INVITADO'];
include("../core/auth.php");
?>

<div id="page-wrapper">
  <div id="page-inner">
    <div class="eventos-container">

      <!-- 🔍 Buscador -->
      <div class="buscador-evento">
        <label><i class="fa fa-search"></i> Buscar evento:</label>
        <input type="text" id="buscarEvento" placeholder="Escribe para filtrar...">
        <button class="btn-buscar"><i class="fa fa-search"></i></button>
      </div>

      <!-- 🧩 Contenedor de tarjetas -->
      <div class="eventos-grid">
        <!-- Las tarjetas se cargarán dinámicamente por JS -->
      </div>

      <!-- 📄 Paginación (opcional) -->
      <div class="paginacion">
        <button>&laquo;</button>
        <button class="activo">1</button>
        <button>2</button>
        <button>3</button>
        <button>&raquo;</button>
        <span>Página 1 de 3</span>
      </div>

    </div>
  </div>
</div>

<!-- ✅ ESTILOS -->
<style>
.eventos-container {
  font-family: 'Segoe UI', sans-serif;
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  color: #000;
}

.buscador-evento {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 25px;
}

.buscador-evento input {
  flex: 1;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.btn-buscar {
  background-color: #c0392b;
  color: white;
  padding: 7px 14px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.eventos-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
}

.tarjeta-evento {
  flex: 1 1 calc(33.33% - 20px);
  max-width: calc(33.33% - 20px);
  min-width: 260px;
  background: white;
  border: 2px solid #c0392b;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  padding: 15px;
  box-sizing: border-box;
  transition: transform 0.3s ease;
}

.tarjeta-evento:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(192, 57, 43, 0.4);
}

.tarjeta-evento h4 {
  margin-bottom: 10px;
  color: #c0392b;
}

.tarjeta-evento p {
  margin: 5px 0;
  font-size: 14px;
}

.evento-img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 5px;
  margin-bottom: 10px;
  border: 2px solid #000;
}

.tarjeta-evento.activo {
  border-left: 5px solid #c0392b;
}

.inscrito {
  color: green;
  font-weight: bold;
}

.paginacion {
  text-align: center;
  margin-top: 25px;
}

.paginacion button {
  padding: 6px 12px;
  margin: 0 2px;
  border: none;
  background: #eee;
  border-radius: 4px;
  cursor: pointer;
}

.paginacion button.activo {
  background-color: #c0392b;
  color: white;
}

@media (max-width: 992px) {
  .tarjeta-evento {
    flex: 1 1 calc(50% - 20px);
    max-width: calc(50% - 20px);
  }
}

@media (max-width: 600px) {
  .tarjeta-evento {
    flex: 1 1 100%;
    max-width: 100%;
  }
}
</style>

<!-- ✅ SCRIPTS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="../public/js/misEventos.js"></script>

<?php include("partials/footer_Admin.php"); ?>
