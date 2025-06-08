<?php
// 1. Configuración básica
$directorioComprobantes = __DIR__ . '/comprobantes/';
$directorioRequisitos = __DIR__ . '/requisitos/';
$destinatarioEmail = "inscripciones@uta.edu.ec";

// 2. Crear directorios si no existen
if (!is_dir($directorioComprobantes)) {
    mkdir($directorioComprobantes, 0755, true);
}
if (!is_dir($directorioRequisitos)) {
    mkdir($directorioRequisitos, 0755, true);
}

// 3. Recoger datos del formulario
$nombre = $_POST['nombre'] ?? '';
$matricula = $_POST['matricula'] ?? '';
$correo = $_POST['correo'] ?? '';
$carrera = $_POST['carrera'] ?? '';
$tipoPago = $_POST['tipoPago'] ?? '';
$comentarios = $_POST['comentarios'] ?? '';

// 4. Validar campos obligatorios
$camposObligatorios = ['nombre', 'matricula', 'correo', 'carrera', 'tipoPago'];
foreach ($camposObligatorios as $campo) {
    if (empty($_POST[$campo])) {
        die("Error: El campo $campo es obligatorio");
    }
}

// 5. Validar y procesar archivos de requisitos
$archivosRequisitos = [];
if (isset($_FILES['requisitos'])) {
    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'pdf'];
    
    foreach ($_FILES['requisitos']['name'] as $key => $name) {
        // Verificar si hay error en la subida
        if ($_FILES['requisitos']['error'][$key] !== UPLOAD_ERR_OK) {
            die("Error en la carga del archivo: $name");
        }
        
        // Validar tipo de archivo
        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (!in_array($extension, $extensionesPermitidas)) {
            die("Tipo de archivo no permitido: $name. Use JPG, PNG o PDF");
        }
        
        // Validar tamaño (5MB máximo)
        if ($_FILES['requisitos']['size'][$key] > 5 * 1024 * 1024) {
            die("Archivo demasiado grande: $name (máximo 5MB)");
        }
        
        // Generar nombre único y mover archivo
        $nombreArchivo = uniqid() . '_' . $matricula . '_' . $name;
        $rutaArchivo = $directorioRequisitos . $nombreArchivo;
        
        if (!move_uploaded_file($_FILES['requisitos']['tmp_name'][$key], $rutaArchivo)) {
            die("Error al guardar el requisito: $name");
        }
        
        $archivosRequisitos[] = $nombreArchivo;
    }
}

// Validar que se subió al menos un requisito
if (empty($archivosRequisitos)) {
    die("Error: Debe subir al menos un requisito");
}

// 6. Procesar comprobante de pago
if (isset($_FILES['comprobantePago']) && $_FILES['comprobantePago']['error'] === UPLOAD_ERR_OK) {
    // Validar tipo de archivo
    $extension = strtolower(pathinfo($_FILES['comprobantePago']['name'], PATHINFO_EXTENSION));
    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'pdf'];
    
    if (!in_array($extension, $extensionesPermitidas)) {
        die("Tipo de archivo no permitido para comprobante. Use JPG, PNG o PDF");
    }
    
    // Validar tamaño (5MB máximo)
    if ($_FILES['comprobantePago']['size'] > 5 * 1024 * 1024) {
        die("Comprobante demasiado grande (máximo 5MB)");
    }
    
    // Generar nombre único y mover archivo
    $nombreArchivoComprobante = uniqid() . '_' . $matricula . '_' . basename($_FILES['comprobantePago']['name']);
    $rutaArchivoComprobante = $directorioComprobantes . $nombreArchivoComprobante;
    
    if (!move_uploaded_file($_FILES['comprobantePago']['tmp_name'], $rutaArchivoComprobante)) {
        die("Error al guardar el comprobante de pago");
    }
} else {
    die("Error: Debe subir un comprobante de pago válido");
}

// 7. Construir mensaje de correo
$asunto = "Nueva Inscripción: $nombre";
$mensaje = "
    <h2>Nueva Inscripción Registrada</h2>
    <p><strong>Nombre:</strong> $nombre</p>
    <p><strong>Matrícula:</strong> $matricula</p>
    <p><strong>Correo:</strong> $correo</p>
    <p><strong>Carrera:</strong> $carrera</p>
    <p><strong>Método de Pago:</strong> " . ucfirst($tipoPago) . "</p>
    <p><strong>Comentarios:</strong> " . ($comentarios ?: 'Ninguno') . "</p>
    
    <h3>Archivos Subidos</h3>
    <p><strong>Comprobante de Pago:</strong> $nombreArchivoComprobante</p>
    <p><strong>Requisitos:</strong></p>
    <ul>
";

foreach ($archivosRequisitos as $requisito) {
    $mensaje .= "<li>$requisito</li>";
}

$mensaje .= "</ul>";

// 8. Configurar cabeceras para correo HTML
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: sistema-inscripciones@uta.edu.ec" . "\r\n";
$headers .= "Reply-To: $correo" . "\r\n";

// 9. Enviar correo (en producción descomentar)
/*
if (mail($destinatarioEmail, $asunto, $mensaje, $headers)) {
    // Todo bien, redirigir
} else {
    die("Error al enviar el formulario");
}
*/

// 10. Redirigir a página de confirmación
header("Location: confirmacion_inscripcion.php?nombre=" . urlencode($nombre) . "&correo=" . urlencode($correo));
exit;