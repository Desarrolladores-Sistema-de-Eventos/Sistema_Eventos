<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Comprobante -  FISEI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap 4.4.1 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        .topbar {
            background-color: #941c1c;
            color: white;
            font-size: 0.95rem;
            padding: 7px 15px;
            letter-spacing: 0.5px;
        }
        .btn-verificar {
            background: linear-gradient(90deg, #941c1c 60%, #c0392b 100%);
            color: white;
            font-weight: 600;
            border-radius: 25px;
            padding: 10px 35px;
            box-shadow: 0 2px 8px rgba(148,28,28,0.08);
            transition: background 0.3s;
        }
        .btn-verificar:hover {
            background: linear-gradient(90deg, #7c1616 60%, #a93226 100%);
            color: #fff;
        }
        .form-control:focus {
            border-color: #941c1c;
            box-shadow: 0 0 0 0.2rem rgba(148,28,28,.15);
        }
        .verificacion-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(148,28,28,0.08);
            padding: 32px 28px 24px 28px;
            max-width: 520px;
            margin: 0 auto;
        }
        #resultado .alert-success {
            background: #eafaf1;
            color: #186a3b;
            border: 1px solid #b7e1cd;
            font-size: 1.1rem;
            border-radius: 12px;
        }
        #resultado .alert-danger {
            background: #fbeaea;
            color: #a93226;
            border: 1px solid #f5b7b1;
            font-size: 1.1rem;
            border-radius: 12px;
        }
        .footer-logo {
            max-height: 70px;
        }
        footer {
            background-color: #222;
            color: white;
            padding: 40px 20px;
            margin-top: 60px;
            border-radius: 0 0 18px 18px;
        }
        footer a {
            color: #f8d7da;
            text-decoration: underline;
        }
        @media (max-width: 576px) {
            .verificacion-card {
                padding: 18px 8px 16px 8px;
            }
            .footer-logo {
                max-height: 50px;
            }
        }
    </style>
</head>
<body>

    <!-- Topbar -->
    <div class="topbar">
        📧 Correo electrónico : <b>fisei@uta.edu.ec</b> ; <b>universidad_tecnica@uta.edu.ec</b>
    </div>

    <!-- Header -->
    <div class="container my-4">
        <div class="d-flex align-items-center mb-4">
            <img src="../public/img/sello_UTA.jpg" alt="Logo" class="mr-3" style="height: 70px;">
            <div>
                <h6 class="mb-0 text-uppercase font-weight-bold text-danger">FACULTAD DE INGENIERÍA EN</h6>
                <h4 class="mb-1 font-weight-bold text-danger">SISTEMAS, ELECTRÓNICA E INDUSTRIAL</h4>
            </div>
        </div>

        <div class="verificacion-card shadow-sm">
            <h3 class="font-weight-bold text-center mb-2" style="color:#941c1c;">CERTIFICADO DE APROBACIÓN</h3>
            <p class="lead text-center mb-4" style="color:#444;">Ingrese el código de su comprobante</p>

            <!-- Formulario -->
            <form id="verificacionForm" class="mt-2">
                <div class="form-group row justify-content-center">
                    <label for="codigo" class="col-sm-2 col-form-label font-weight-bold" style="color:#941c1c;">Código</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="codigo" placeholder="Ej. CTT2024-001" required autocomplete="off">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-verificar mt-2">Verificar</button>
                </div>
            </form>
            <div id="resultado" class="mt-4"></div>
        </div>
    </div>

<!-- Footer -->
 <?php include('partials/footer.php'); ?>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>    
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/js/all.min.js"></script>

</body>
</html>
