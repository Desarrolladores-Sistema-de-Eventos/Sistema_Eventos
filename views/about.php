
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - FISEI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --uta-rojo: #ae0c22;
            --uta-negro: #1a1a1a;
            --uta-gris: #f9f9f9;
            --uta-blanco: #ffffff;
        }

        body {
            background: linear-gradient(135deg, #8e0b1c, #ae0c22);
            font-family: 'Poppins', sans-serif;
            color: var(--uta-blanco);
            overflow-x: hidden;
            position: relative;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            color: var(--uta-blanco);
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2rem;
            font-weight: 700;
            text-transform: uppercase;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            width: 60px;
            height: 4px;
            background-color: var(--uta-rojo);
            display: block;
            margin: 8px auto 0;
        }

        .page-header {
            padding: 4rem 0 2rem;
            text-align: center;
            position: relative;
        }

        .page-header h3 {
            font-size: 2.5rem;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        /* === CARRERAS === */
        .card-carrera {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            height: 300px;
            background-color: #000;
            transition: transform 0.3s ease;
        }

        .card-carrera:hover {
            transform: translateY(-6px);
        }

        .img-carrera {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(65%);
            transition: 0.3s;
        }

        .card-carrera:hover .img-carrera {
            filter: brightness(85%);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            color: #fff;
            font-weight: 700;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1rem;
            font-size: 1.2rem;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.8);
        }

        .overlay i {
            font-size: 2.2rem;
            color:#f1f1f1; /* antes era var(--uta-rojo) */
            margin-bottom: 0.5rem;
        }


        /* === AUTORIDADES === */
        .card-autoridad {
            position: relative;
            border-radius: 15px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
            background-color: var(--uta-blanco);
            overflow: hidden;
            transition: transform 0.3s ease;
            color: var(--uta-negro);
        }

        .card-autoridad:hover {
            transform: translateY(-5px);
        }

        .card-autoridad .team-img img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .card-autoridad .text-center {
            padding: 1.2rem;
        }

        .card-autoridad h5 {
            color: var(--uta-rojo);
            font-weight: 600;
        }

        .card-autoridad p {
            color: var(--uta-negro);
            margin: 0.3rem 0;
            font-weight: 500;
        }

        .card-autoridad small {
            color: #555;
            font-size: 0.85rem;
        }

        /* === BUBBLES ANIMATION === */
        .bubbles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            margin: 0;
            padding: 0;
            pointer-events: none;
            list-style: none;
        }

        .bubbles li {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.15);
            animation: rise 25s infinite;
            bottom: -150px;
            border-radius: 50%;
        }

        .bubbles li:nth-child(1) { left: 10%; width: 40px; height: 40px; animation-duration: 20s; }
        .bubbles li:nth-child(2) { left: 20%; width: 20px; height: 20px; animation-duration: 22s; }
        .bubbles li:nth-child(3) { left: 25%; width: 30px; height: 30px; animation-duration: 18s; }
        .bubbles li:nth-child(4) { left: 40%; width: 50px; height: 50px; animation-duration: 30s; }
        .bubbles li:nth-child(5) { left: 70%; width: 25px; height: 25px; animation-duration: 26s; }
        .bubbles li:nth-child(6) { left: 80%; width: 15px; height: 15px; animation-duration: 24s; }
        .bubbles li:nth-child(7) { left: 90%; width: 30px; height: 30px; animation-duration: 28s; }
        .bubbles li:nth-child(8) { left: 50%; width: 40px; height: 40px; animation-duration: 22s; }
        .bubbles li:nth-child(9) { left: 60%; width: 20px; height: 20px; animation-duration: 20s; }
        .bubbles li:nth-child(10) { left: 30%; width: 35px; height: 35px; animation-duration: 25s; }

        @keyframes rise {
            0% { transform: translateY(0) scale(1); opacity: 0; }
            50% { opacity: 0.6; }
            100% { transform: translateY(-1000px) scale(1.5); opacity: 0; }
        }
    </style>
</head>
<body>
<?php include('partials/header.php'); ?>

<ul class="bubbles">
  <li></li><li></li><li></li><li></li><li></li>
  <li></li><li></li><li></li><li></li><li></li>
</ul>
<div class="container my-5 py-4">
    <div class="text-center mb-5">
        <h2 class="section-title">Nuestra Facultad</h2>
    </div>
    <div class="row g-4 align-items-center">
        <div class="col-lg-6">
            <div class="ratio ratio-4x3 rounded shadow-sm overflow-hidden">
                <img src="../public/img/about.png" alt="Imagen Facultad" class="w-100 h-100 object-fit-cover">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="bg-white rounded shadow p-4">
                <div class="mb-4">
                    <h2 id="facultad-nombre" class="text-uppercase fw-bold" style="color: var(--uta-rojo);"></h2>
                </div>

                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold text-uppercase" style="color: var(--uta-rojo);"><i class="fas fa-bullseye me-2"></i>Misión</h5>
                        <p id="facultad-mision" class="mb-0 text-muted"></p>
                    </div>
                </div>

                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold text-uppercase" style="color: var(--uta-rojo);"><i class="fas fa-eye me-2"></i>Visión</h5>
                        <p id="facultad-vision" class="mb-0 text-muted"></p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold text-uppercase" style="color: var(--uta-rojo);"><i class="fas fa-map-marker-alt me-2"></i>Ubicación</h5>
                        <p id="facultad-ubicacion" class="mb-0 text-muted"></p>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>


<main class="container position-relative z-1">
    <div class="section-title">
        <h2>Nuestro Equipo</h2>
    </div>
    <div class="row" id="autoridades-row">
        <!-- Autoridades se cargan dinámicamente -->
    </div>

    <div class="section-title mt-5">
        <h2>Carreras</h2>
    </div>
    <div class="row" id="carreras-row">
        <!-- Carreras se cargan dinámicamente -->
    </div>
</main>

   <!-- Footer Start -->
     <script src="../public/js/fisei.js"></script>
    <!-- Footer End -->

<script src="../public/js/autoridades.js"></script>
<script src="../public/js/carreras.js"></script>
</body>
</html>
