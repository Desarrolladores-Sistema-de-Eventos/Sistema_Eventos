// Función para simular obtención de datos filtrados
async function fetchChartData(filters) {
  console.log("Filtros recibidos para datos:", filters);

  // Aquí puedes reemplazar con llamada AJAX real, enviando 'filters' al backend PHP

  // Datos simulados que podrían cambiar según filtros
  const dataPorTipo = {
    labels: ["Cursos", "Congresos", "Conferencias", "Webinars"],
    data: [12, 7, 9, 10]
  };
  const dataModalidad = {
    labels: ["Gratuitos", "Pagados"],
    data: [60, 40]
  };
  const dataInscripciones = {
    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo"],
    data: [50, 75, 120, 90, 130]
  };

  // Simula filtrado: si tipo es 'curso', solo muestra Cursos y cambia números
  if (filters.tipo === "curso") {
    dataPorTipo.labels = ["Cursos"];
    dataPorTipo.data = [15];
  } else if (filters.tipo === "congreso") {
    dataPorTipo.labels = ["Congresos"];
    dataPorTipo.data = [10];
  }

  // Si modalidad es gratuito o pagado, ajusta números (simulado)
  if (filters.modalidad === "gratuito") {
    dataModalidad.data = [80, 20];
  } else if (filters.modalidad === "pagado") {
    dataModalidad.data = [25, 75];
  }

  // Si filtras por mes (por ejemplo "05" mayo), simula que solo hay datos en mayo
  if (filters.mes !== "todos") {
    dataInscripciones.labels = [filters.mes];
    dataInscripciones.data = [Math.floor(Math.random() * 100) + 20];
  }

  return {
    eventosPorTipo: dataPorTipo,
    cursosGratVsPag: dataModalidad,
    inscripcionesPorMes: dataInscripciones
  };
}

let barChartInstance = null;
let pieChartInstance = null;
let lineChartInstance = null;

function actualizarTablaResumen(data, tablaBody) {
  tablaBody.innerHTML = '';
  data.eventosPorTipo.labels.forEach((label, idx) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${label}</td><td>${data.eventosPorTipo.data[idx]}</td>`;
    tablaBody.appendChild(tr);
  });
}

async function renderCharts(searchText, tipo, mes, modalidad, tablaResumenBody) {
  const filters = { searchText, tipo, mes, modalidad };
  const chartData = await fetchChartData(filters);

  // Actualizar o crear gráfico de barras
  const barCtx = document.getElementById("barChart").getContext("2d");
  if (barChartInstance) {
    barChartInstance.data.labels = chartData.eventosPorTipo.labels;
    barChartInstance.data.datasets[0].data = chartData.eventosPorTipo.data;
    barChartInstance.update();
  } else {
    barChartInstance = new Chart(barCtx, {
      type: "bar",
      data: {
        labels: chartData.eventosPorTipo.labels,
        datasets: [{
          label: "Eventos",
          data: chartData.eventosPorTipo.data,
          backgroundColor: ["#007bff", "#28a745", "#ffc107", "#dc3545"]
        }]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
      }
    });
  }

  // Actualizar o crear gráfico de pastel
  const pieCtx = document.getElementById("pieChart").getContext("2d");
  if (pieChartInstance) {
    pieChartInstance.data.labels = chartData.cursosGratVsPag.labels;
    pieChartInstance.data.datasets[0].data = chartData.cursosGratVsPag.data;
    pieChartInstance.update();
  } else {
    pieChartInstance = new Chart(pieCtx, {
      type: "pie",
      data: {
        labels: chartData.cursosGratVsPag.labels,
        datasets: [{
          data: chartData.cursosGratVsPag.data,
          backgroundColor: ["#17a2b8", "#6f42c1"]
        }]
      },
      options: {
        responsive: true
      }
    });
  }

  // Actualizar o crear gráfico de línea
  const lineCtx = document.getElementById("lineChart").getContext("2d");
  if (lineChartInstance) {
    lineChartInstance.data.labels = chartData.inscripcionesPorMes.labels;
    lineChartInstance.data.datasets[0].data = chartData.inscripcionesPorMes.data;
    lineChartInstance.update();
  } else {
    lineChartInstance = new Chart(lineCtx, {
      type: "line",
      data: {
        labels: chartData.inscripcionesPorMes.labels,
        datasets: [{
          label: "Inscripciones",
          data: chartData.inscripcionesPorMes.data,
          fill: true,
          borderColor: "#007bff",
          backgroundColor: "rgba(0, 123, 255, 0.2)",
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
      }
    });
  }

  // Actualizar tabla resumen
  if (tablaResumenBody) {
    actualizarTablaResumen(chartData, tablaResumenBody);
  }
}
