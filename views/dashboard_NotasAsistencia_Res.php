<?php include("partials/header_Admin.php"); ?>
<?php 
$requiereResponsable = true;
include("../core/auth.php")?>


<div id="page-wrapper">
  <div id="page-inner">
    <div class="container">
      <div class="row">
      <h2 class="titulo-notas">
  <i class="fa fa-check-square-o"></i> Gestión de Notas/Asistencia
</h2>
<div class="titulo-linea"></div> 
    </div> 
    <hr />
    <div class="eventos-grid" id="contenedor-eventos"></div>
    </div>
  </div>
</div>
<style>
  h2 {
    font-size: 24px;
    color: rgb(23, 23, 23);
    font-weight: bold;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }


.titulo-linea {
  border-bottom: 2px solid rgb(185, 51, 51);
  margin-top: 6px;
  margin-bottom: 20px;
  font-size: 14px;
  font-weight: normal;
}

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
}

.btn-buscar:hover {
  background-color: var(--uta-rojo-hover);
}

.eventos-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 32px 32px; /* Más espacio entre filas y columnas */
  justify-content: flex-start;
  margin-bottom: 32px;
}

/* TARJETA EVENTO */
.tarjeta-evento {
  position: relative;
  width: 300px;
  margin-bottom: 20px;
  background: #fff;
  border: 1px solid var(--gris-borde);
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  overflow: hidden;
  transition: transform 0.3s;
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
  font-size: 13px;
  color: #555;
}

.inscrito {
  color: var(--verde-inscrito);
  font-weight: bold;
  margin-left: 10px;
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../public/js/asi_Not_Res.js"></script>
<?php include("partials/footer_Admin.php"); ?>

