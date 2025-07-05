<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Corrección de rutas para los require_once
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';

function enviarCorreoResponsable($correoDestino, $nombreResponsable, $nombreInscrito, $datosInscrito, $nombreEvento) {
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        // Configuración para SendGrid
        $mail->Host = 'smtp.sendgrid.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'apikey'; 
        $mail->Password = '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'; // Tu API Key de SendGrid
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // El remitente debe ser un correo verificado en SendGrid
        $mail->setFrom('ernestojurado2004@gmail.com', 'Sistema de Eventos');
        $mail->addAddress($correoDestino, $nombreResponsable);

        $mail->isHTML(true);
        $mail->Subject = 'Nueva inscripción en tu evento: ' . $nombreEvento;
        $mail->Body = '<h3>Se ha inscrito una nueva persona a tu evento</h3>' .
            '<b>Evento:</b> ' . htmlspecialchars($nombreEvento) . '<br>' .
            '<b>Nombre del inscrito:</b> ' . htmlspecialchars($nombreInscrito) . '<br>' .
            '<b>Datos:</b><br>' . $datosInscrito;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo: ' . $mail->ErrorInfo);
        return false;
    }
}

// Nueva función para notificar subida de requisitos y comprobante
function enviarCorreoRequisitosSubidos($correoDestino, $nombreResponsable, $nombreInscrito, $datosInscrito, $nombreEvento) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.sendgrid.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'apikey';
        $mail->Password = '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';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('ernestojurado2004@gmail.com', 'Sistema de Eventos');
        $mail->addAddress($correoDestino, $nombreResponsable);
        $mail->isHTML(true);
        $mail->Subject = 'Requisitos y comprobante enviados para el evento: ' . $nombreEvento;
        $mail->Body = '<h3>Un inscrito ha enviado los requisitos y comprobante de pago</h3>' .
            '<b>Evento:</b> ' . htmlspecialchars($nombreEvento) . '<br>' .
            '<b>Nombre del inscrito:</b> ' . htmlspecialchars($nombreInscrito) . '<br>' .
            '<b>Datos:</b><br>' . $datosInscrito .
            '<br><b>Acción requerida:</b> Por favor, revisa los documentos y valida la inscripción.';
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo: ' . $mail->ErrorInfo);
        return false;
    }
}