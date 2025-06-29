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

      <!-- Modal para Contenido del Evento (compatible con Bootstrap 3) -->
<div class="modal fade" id="contenidoModal" tabindex="-1" role="dialog" aria-labelledby="contenidoModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white" style="background-color:rgb(155, 46, 46); color: white;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><i class="fa fa-book"></i> Contenido del Evento</h4>
      </div>
      <div class="modal-body" style="font-size: 15px; line-height: 1.7;"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
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


<style>
    body {
  background-color: #fff;
  color: #000;
  font-family: Arial, sans-serif;
}
:root {
  --uta-rojo: #9b2e2e;
  --uta-rojo-hover: #7c2323;
  --verde-inscrito: #27ae60;
  --gris-borde: #ddd;
  --gris-claro: #f8f8f8;
  --texto: #333;
}

.eventos-container {
  font-family: 'Segoe UI', sans-serif;
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  color: var(--texto);
}

.buscador-evento {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 25px;
}

.buscador-evento input {
  flex: 1;
  padding: 10px;
  border: 2px solid var(--uta-rojo);
  border-radius: 6px;
  font-size: 14px;
}

.btn-buscar {
  background-color: var(--uta-rojo);
  color: white;
  padding: 8px 14px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  font-size: 14px;
    font-weight: normal;
}
h4{
  font-size: 15px;
 font-weight: normal;
}

.btn-buscar:hover {
  background-color: var(--uta-rojo-hover);
}

.eventos-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 25px;
  justify-content: center;
}

/* TARJETA EVENTO */
.tarjeta-evento {
  position: relative;
  width: 300px;
  background: #fff;
  border: 1px solid var(--gris-borde);
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  overflow: hidden;
  transition: transform 0.3s;
  font-size: 14px;
  font-weight: normal;
}

.tarjeta-evento:hover {
  transform: translateY(-5px);
}

.evento-img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-bottom: 3px solid var(--uta-rojo);
}

/* CINTA DE ESTADO */
.estado-ribbon {
  position: absolute;
  top: 12px;
  left: -20px;
  background-color: var(--uta-rojo);
  color: white;
  font-size: 11px;
  font-weight: bold;
  padding: 4px 40px;
  transform: rotate(-45deg);
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  font-size: 14px;
    font-weight: normal;
}

/* CONTENIDO */
.tarjeta-evento h5 {
  font-size: 17px;
  font-weight: 600;
  margin: 15px 10px 8px;
  color: var(--uta-rojo);
}

.tarjeta-evento p {
  margin: 4px 10px;
  color: #555;
  font-size: 14px;
  font-weight: normal;
}

.inscrito {
  color: var(--verde-inscrito);
  font-weight: bold;
  margin-left: 10px;
  font-size: 14px;
  font-weight: normal;
}

.badge {
  background-color: #eee;
  padding: 2px 8px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: bold;
}

/* BOTÓN VER CONTENIDO */
.tarjeta-evento .btn {
  display: inline-block;
  margin: 15px auto 10px;
  background-color: var(--uta-rojo);
  color: white;
  border: none;
  padding: 8px 14px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  transition: background 0.3s;
  font-size: 14px;
  font-weight: normal;

}

.tarjeta-evento .btn:hover {
  background-color: var(--uta-rojo-hover);
}

.paginacion {
  text-align: center;
  margin-top: 25px;
}

.paginacion button {
  padding: 6px 12px;
  margin: 0 4px;
  border: none;
  background: #eee;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

.paginacion button.activo {
  background-color: var(--uta-rojo);
  color: white;
}

@media (max-width: 992px) {
  .tarjeta-evento {
    max-width: 90%;
  }
}
.info-line {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  color: #444;
  margin: 6px 10px;
}

.text-curso {
  color:rgb(185, 41, 41);
}
.text-estado {
  color:rgb(185, 41, 41);
}
.text-inscrito {
  color: #0066cc;
  font-size: 16px;
}

.estado-label {
  font-size: 12px;
  font-weight: bold;
  padding: 2px 8px;
  border-radius: 12px;
  background-color: #eee;
  color: #555;
  text-transform: uppercase;
}

.estado-label.disponible {
  background-color: #d5f5e3;
  color: #2ecc71;
}
.estado-label.finalizado {
  background-color: #fdebd0;
  color: #e67e22;
}
.estado-label.cancelado {
  background-color: #f5b7b1;
  color: #e74c3c;
}

.inscrito-texto {
  font-weight: 600;
  color: #0066cc;
}

.btn-ver {
  background-color: #9b2e2e;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.btn-ver:hover {
  background-color: #7c2323;
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
