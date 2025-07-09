<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>404 - Página no encontrada</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --uta-rojo: #b10024; /* Color primario: Rojo */
            --uta-negro: #1a1a1a; /* Color secundario: Negro */
            --uta-blanco: #ffffff; /* Color de complemento: Blanco */
            --uta-gris-claro: #f0f2f5; /* Un gris claro para el fondo */
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--uta-gris-claro);
            color: var(--uta-negro); /* Texto principal en negro */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            max-width: 500px;
        }
        h1 {
            font-size: 6rem;
            margin: 0;
            color: var(--uta-rojo); /* El número 404 en rojo primario */
        }
        p {
            font-size: 1.2rem;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: var(--uta-rojo); /* Botón de enlace en rojo primario */
            color: var(--uta-blanco); /* Texto del botón en blanco */
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #a0001f; /* Un rojo ligeramente más oscuro al pasar el ratón */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>La página que buscas no existe o no tienes permiso para verla.</p>
        <a href="../views/login.php">Volver al login</a>
    </div>
</body>
</html>