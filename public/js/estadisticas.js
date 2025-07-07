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
                    backgroundColor: '#8B0000', // Rojo UTA
                    borderColor: '#222', // Negro UTA
                    borderWidth: 2,
                    hoverBackgroundColor: '#600000',
                    hoverBorderColor: '#8B0000'
                }]
            },
            options: {
                indexAxis: 'y', // Barras horizontales
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#222',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#8B0000',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { color: '#222', precision:0 },
                        grid: { color: '#e0e0e0' }
                    },
                    y: {
                        ticks: { color: '#222', font: { weight: 'bold' } },
                        grid: { color: '#e0e0e0' }
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
                colors: ['#8B0000', '#222', '#FFD600', '#600000', '#b22222'], // Rojo, negro, amarillo UTA, variantes
                resize: true,
                labelColor: '#222',
                formatter: function (y) { return y; }
            });
            // Cambia el color del texto de las leyendas (Morris no lo hace por defecto)
            setTimeout(function() {
                $('#usuarios-donut-chart text').attr('fill', '#8B0000').css('font-weight','bold');
            }, 300);
        });
    }

    // Inicializar todo
    cargarIconos();
    cargarBarChart();
    cargarDonutChart();
});