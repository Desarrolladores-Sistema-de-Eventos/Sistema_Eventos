$(document).ready(function() {
    // Actualizar iconos
    function cargarIconos() {
        $.getJSON('../controllers/EstadisticasController.php?option=totalUsuariosActivos', function(data) {
            $('#iconoTotalUsuarios').text(data.total);
        });
        $.getJSON('../controllers/EstadisticasController.php?option=totalEventosDisponibles', function(data) {
            $('#iconoTotalEventos').text(data.total);
        });
        $.getJSON('../controllers/EstadisticasController.php?option=usuariosInactivos', function(data) {
            $('#iconoUsuariosInactivos').text(data.total);
        });
        $.getJSON('../controllers/EstadisticasController.php?option=eventosCanceladosCerrados', function(data) {
            $('#iconoEventosCanceladosCerrados').text(data.total);
        });
    }

    // Gráfico de barras: Inscripciones activas y completadas por evento
   function cargarBarChart() {
    $.getJSON('../controllers/EstadisticasController.php?option=inscripcionesActivasCompletadasPorEvento', function(data) {
        // Extrae etiquetas y valores
        const labels = data.map(item => item.y);
        const values = data.map(item => item.total);

        // Limpia el canvas si ya existe un gráfico
        if (window.barChartInstance) {
            window.barChartInstance.destroy();
        }

        // Crea el gráfico horizontal
        const ctx = document.getElementById('eventos-bar-horizontal').getContext('2d');
        window.barChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Inscripciones',
                    data: values,
                    backgroundColor: '#0b62a4'
                }]
            },
            options: {
                indexAxis: 'y', // Barras horizontales
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { precision:0 }
                    }
                }
            }
        });
    });
}

    // Gráfico de pastel: Usuarios por tipo
    function cargarDonutChart() {
        $.getJSON('../controllers/EstadisticasController.php?option=usuariosPorTipo', function(data) {
            Morris.Donut({
                element: 'usuarios-donut-chart',
                data: data,
                colors: ['#1abc9c', '#3498db', '#e67e22'],
                resize: true
            });
        });
    }

    // Inicializar todo
    cargarIconos();
    cargarBarChart();
    cargarDonutChart();
});