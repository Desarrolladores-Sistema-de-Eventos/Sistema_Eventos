$(document).ready(function() {
    $('#formRegistro').on('submit', function(e) {
        e.preventDefault();

        var form = $(this)[0];
        var formData = new FormData(form);

        $.ajax({
            url: '../controllers/RegisterController.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registro exitoso!',
                        text: res.success,
                        confirmButtonColor: '#660000'
                    }).then(() => {
                        window.location.href = '../views/login.php';
                    });
                } else if (res.errores) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: res.errores.join('<br>'),
                        confirmButtonColor: '#660000'
                    });
                } else if (res.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.error,
                        confirmButtonColor: '#660000'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error inesperado.',
                        confirmButtonColor: '#660000'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo procesar el registro.',
                    confirmButtonColor: '#660000'
                });
            }
        });
    });
});