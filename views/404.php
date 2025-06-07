<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>404 - Página no encontrada</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f2f5;
      color: #333;
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
      color: #d9534f;
    }
    p {
      font-size: 1.2rem;
    }
    a {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #0275d8;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }
    a:hover {
      background-color: #025aa5;
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
