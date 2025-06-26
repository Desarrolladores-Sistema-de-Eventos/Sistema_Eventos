/**
 * JavaScript para el carrusel de eventos destacados
 * Inicializa Owl Carousel con configuración responsive y controles dinámicos
 */
$(document).ready(function() {
    // Verificar si existe el carrusel antes de inicializarlo
    if ($('.eventos-carousel').length > 0) {
        var owl = $('.eventos-carousel').owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            smartSpeed: 800,
            mouseDrag: true,
            touchDrag: true,
            pullDrag: true,
            freeDrag: false,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    dots: true
                },
                600: {
                    items: 2,
                    nav: false,
                    dots: true
                },
                1000: {
                    items: 3,
                    nav: false,
                    dots: true
                }
            },
           
            onChanged: function(event) {
                // Carrusel cambiado
            }
        });
      
        // Agregar controles adicionales si se necesitan
        $('.eventos-carousel').on('mouseenter', function() {
            owl.trigger('stop.owl.autoplay');
        });
        
        $('.eventos-carousel').on('mouseleave', function() {
            owl.trigger('play.owl.autoplay', [5000]);
        });
    }
    
    // Efecto hover para las tarjetas de eventos (mejorado)
    $('.evento-card').hover(
        function() {
            $(this).find('.evento-overlay').fadeIn(300);
        },
        function() {
            $(this).find('.evento-overlay').fadeOut(300);
        }
    );
});
