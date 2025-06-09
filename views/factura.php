<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Factura UTA</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 11px; margin: 20px; }
    .header { text-align: center; border-bottom: 2px solid black; margin-bottom: 10px; }
    .logo { float: left; width: 120px; }
    .institution { text-align: left; font-weight: bold; }
    .section { margin-bottom: 10px; }
    .table { width: 100%; border-collapse: collapse; }
    .table, .table td, .table th { border: 1px solid black; }
    .table th, .table td { padding: 5px; text-align: left; }
    .title { text-align: center; font-weight: bold; font-size: 14px; }
    .right { text-align: right; }
    .small { font-size: 10px; }
    .borderless td { border: none; }
    #factura-html { background: #fff; padding: 20px; color: #000; }
    button { margin-top: 15px; }
  </style>
</head>
<body>
  <div style="display: flex; justify-content: center; align-items: flex-start; gap: 20px; padding: 20px;">
    <!-- Contenedor de la factura -->
    <div id="factura-container"></div>

    <!-- Botón al lado derecho -->
    <div>
      <button onclick="descargarPDF('factura.pdf')">Descargar Factura en PDF</button>
    </div>
  </div>

  <!-- Librerías necesarias -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="../public/js/factura.js"></script>

  <script>
    var idInscripcion = <?php echo json_encode($_GET['id'] ?? null); ?>;
    if (idInscripcion) {
      obtenerFactura(idInscripcion);
    } else {
      document.getElementById('factura-container').innerHTML = '<p>ID de inscripción no especificado.</p>';
    }
  </script>
</body>

</body>

</html>
