<?php include("partials/head_Admin.php"); ?>

<div id="page-wrapper">
  <div id="page-inner">
    <link rel="stylesheet" href="../public/css/panel.css">
    <link rel="stylesheet" href="https://unpkg.com/lucide@latest" />

    <h2 class="main-title">
      <i data-lucide="layout-dashboard"></i> Panel Principal - Gestión de Eventos Académicos
    </h2>
    <h5 class="main-subtitle">
      <i data-lucide="search-check"></i> Busca, filtra y consulta estadísticas de eventos y estudiantes inscritos
    </h5>
    <hr />

    <!-- Menú pequeño con botones tipo grupo -->
    <div id="btnMenu" class="btn-group mb-4" role="group" aria-label="Menu principal">
      <button type="button" class="btn btn-outline-primary" id="btnMenuUsuarios"><i data-lucide="user"></i> Usuarios</button>
      <button type="button" class="btn btn-outline-primary" id="btnMenuTablas"><i data-lucide="table"></i> Tablas</button>
      <button type="button" class="btn btn-outline-primary" id="btnMenuEstadisticas"><i data-lucide="bar-chart-3"></i> Estadísticas</button>
      <button type="button" class="btn btn-outline-primary" id="btnMenuEstudiantes"><i data-lucide="graduation-cap"></i> Estudiantes</button>
    </div>

    <!-- Filtros y búsqueda -->
    <div id="filtersContainer" class="filter-group mb-4">
      <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre de evento...">

      <select id="filterType" class="form-control" title="Tipo de evento">
        <option value="todos">Todos</option>
        <option value="curso">Cursos</option>
        <option value="congreso">Congresos</option>
      </select>

      <select id="filterMonth" class="form-control" title="Mes">
        <option value="todos">Todos los meses</option>
        <option value="01">Enero</option>
        <option value="02">Febrero</option>
        <option value="03">Marzo</option>
        <option value="04">Abril</option>
        <option value="05">Mayo</option>
        <option value="06">Junio</option>
        <option value="07">Julio</option>
        <option value="08">Agosto</option>
        <option value="09">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
      </select>

      <select id="filterModalidad" class="form-control" title="Modalidad">
        <option value="todos">Todos</option>
        <option value="gratuito">Gratuito</option>
        <option value="pagado">Pagado</option>
      </select>

      <button id="btnSearch" class="btn btn-primary"><i data-lucide="search"></i> Buscar</button>
    </div>

    <!-- Contenedores para secciones -->
    <div id="contentUsuarios" style="display:none;">
      <div class="card">
        <h4><i data-lucide="users"></i> Usuarios</h4>
        <hr />
        <p>Aquí se mostrarían tablas o información de usuarios.</p>
      </div>
    </div>

    <div id="contentTablas" style="display:none;">
      <div class="card">
        <h4><i data-lucide="database"></i> Tablas de eventos y datos</h4>
        <hr />
        <p>Aquí se mostrarían tablas completas con eventos, inscripciones, etc.</p>
      </div>
    </div>

    <div id="contentEstadisticas" style="display:none;">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <h5 class="stat-title"><i data-lucide="bar-chart-horizontal"></i> Eventos por Tipo</h5>
            <hr />
            <canvas id="barChart"></canvas>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <h5 class="stat-title"><i data-lucide="pie-chart"></i> Cursos Gratuitos vs Pagados</h5>
            <hr />
            <canvas id="pieChart"></canvas>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-6">
          <div class="card">
            <h5 class="stat-title"><i data-lucide="activity"></i> Inscripciones por Mes</h5>
            <hr />
            <canvas id="lineChart"></canvas>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <h5 class="stat-title"><i data-lucide="file-bar-chart-2"></i> Resumen Estadístico</h5>
            <hr />
            <table class="table table-striped" id="tablaResumen">
              <thead>
                <tr><th>Tipo</th><th>Total</th></tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div id="contentEstudiantes" style="display:none; margin-top:20px;">
      <div class="card">
        <h4><i data-lucide="users-round"></i> Lista de Estudiantes Inscritos</h4>
        <hr />
        <table class="table table-bordered">
          <thead>
            <tr><th>Nombre</th><th>Carrera</th><th>Estado</th></tr>
          </thead>
          <tbody id="studentsBody"></tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<?php include("partials/footer_Admin.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../public/js/panel_charts_dynamic.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>
  lucide.createIcons();

  const hideAll = () => {
    document.querySelectorAll('#contentUsuarios, #contentTablas, #contentEstadisticas, #contentEstudiantes')
      .forEach(div => div.style.display = 'none');
  };

  document.getElementById('btnMenuUsuarios').onclick = () => {
    hideAll();
    document.getElementById('contentUsuarios').style.display = 'block';
  };

  document.getElementById('btnMenuTablas').onclick = () => {
    hideAll();
    document.getElementById('contentTablas').style.display = 'block';
  };

  document.getElementById('btnMenuEstadisticas').onclick = () => {
    hideAll();
    document.getElementById('contentEstadisticas').style.display = 'block';
  };

  document.getElementById('btnMenuEstudiantes').onclick = () => {
    hideAll();
    document.getElementById('contentEstudiantes').style.display = 'block';
  };
</script>
