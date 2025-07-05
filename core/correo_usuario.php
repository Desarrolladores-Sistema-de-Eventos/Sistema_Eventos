<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';

function enviarCorreoInscripcionAceptada($correoDestino, $nombreUsuario, $nombreEvento) {
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
        $mail->addAddress($correoDestino, $nombreUsuario);
        $mail->isHTML(true);
        $mail->Subject = '¡Inscripción validada para el evento: ' . $nombreEvento . '!';
        $mail->Body = '<h3>¡Felicidades, ' . htmlspecialchars($nombreUsuario) . '!</h3>' .
            '<p>Tus documentos han sido validados y ya estás inscrito al evento <b>' . htmlspecialchars($nombreEvento) . '</b>.</p>' .
            '<p>¡Te esperamos!</p>';
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo al usuario (ACE): ' . $mail->ErrorInfo);
        return false;
    }
}

function enviarCorreoInscripcionRechazada($correoDestino, $nombreUsuario, $nombreEvento) {
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
        $mail->addAddress($correoDestino, $nombreUsuario);
        $mail->isHTML(true);
        $mail->Subject = 'Documentos rechazados para el evento: ' . $nombreEvento;
        $mail->Body = '<h3>Hola, ' . htmlspecialchars($nombreUsuario) . '.</h3>' .
            '<p>La información o documentos que subiste para el evento <b>' . htmlspecialchars($nombreEvento) . '</b> han sido <b>rechazados</b>.</p>' .
            '<p>Por favor, revisa y vuelve a subir los requisitos correctamente para poder completar tu inscripción.</p>';
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo al usuario (REC): ' . $mail->ErrorInfo);
        return false;
    }
}

function enviarCorreoCertificadoGenerado($correoDestino, $nombreUsuario, $nombreEvento, $tipoCertificado, $detallesAdicionales = []) {
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
        $mail->addAddress($correoDestino, $nombreUsuario);
        $mail->isHTML(true);
        $mail->Subject = '¡Certificado disponible para: ' . $nombreEvento . '!';
        
        $cuerpoCorreo = '<h3>¡Felicidades, ' . htmlspecialchars($nombreUsuario) . '!</h3>' .
            '<p>Has cumplido con todos los requisitos del evento <b>' . htmlspecialchars($nombreEvento) . '</b>.</p>' .
            '<p>Tu certificado de <b>' . htmlspecialchars($tipoCertificado) . '</b> ya estará disponible en unos 30 minutos.</p>' .
            '<p><strong>📋 Para descargar tu certificado:</strong></p>' .
            '<ol>' .
            '<li>Ingresa a tu dashboard en el sistema</li>' .
            '<li>Ve a la sección "Mis Certificados"</li>' .
            '<li>Descarga tu certificado</li>' .
            '</ol>';
        
        // Agregar detalles específicos si existen
        if (!empty($detallesAdicionales)) {
            $cuerpoCorreo .= '<p><strong>📊 Detalles de tu participación:</strong></p><ul>';
            foreach ($detallesAdicionales as $detalle) {
                $cuerpoCorreo .= '<li>' . htmlspecialchars($detalle) . '</li>';
            }
            $cuerpoCorreo .= '</ul>';
        }
        
        $cuerpoCorreo .= '<p style="color: #0066cc;"><strong>¡Enhorabuena por tu logro!</strong></p>';
        
        $mail->Body = $cuerpoCorreo;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo de certificado generado: ' . $mail->ErrorInfo);
        return false;
    }
}

function enviarCorreoCertificadoNoGenerado($correoDestino, $nombreUsuario, $nombreEvento, $razon, $detallesAdicionales = []) {
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
        $mail->addAddress($correoDestino, $nombreUsuario);
        $mail->isHTML(true);
        $mail->Subject = 'Información sobre certificado - ' . $nombreEvento;
        
        $cuerpoCorreo = '<h3>Hola, ' . htmlspecialchars($nombreUsuario) . '</h3>' .
            '<p>Te informamos sobre el estado de tu certificado para el evento <b>' . htmlspecialchars($nombreEvento) . '</b>.</p>' .
            '<p><strong>📋 Razón:</strong> ' . htmlspecialchars($razon) . '</p>';
        
        // Agregar detalles específicos si existen
        if (!empty($detallesAdicionales)) {
            $cuerpoCorreo .= '<p><strong>📊 Detalles de tu participación:</strong></p><ul>';
            foreach ($detallesAdicionales as $detalle) {
                $cuerpoCorreo .= '<li>' . htmlspecialchars($detalle) . '</li>';
            }
            $cuerpoCorreo .= '</ul>';
        }
        
        $cuerpoCorreo .= '<p>Si tienes alguna consulta, por favor contacta con el responsable del evento.</p>' .
            '<p><em>Gracias por tu participación.</em></p>';
        
        $mail->Body = $cuerpoCorreo;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo de certificado no generado: ' . $mail->ErrorInfo);
        return false;
    }
}

function enviarCorreoCertificadoPDFDisponible($correoDestino, $nombreUsuario, $nombreEvento, $tipoCertificado = 'Participación') {
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
        $mail->addAddress($correoDestino, $nombreUsuario);
        $mail->isHTML(true);
        $mail->Subject = '📄 ¡Tu certificado PDF ya está listo! - ' . $nombreEvento;
        
        $cuerpoCorreo = '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;">' .
            '<div style="text-align: center; margin-bottom: 20px;">' .
            '<h2 style="color: #0066cc; margin-bottom: 10px;">🎉 ¡Tu certificado está listo!</h2>' .
            '</div>' .
            '<h3>Hola, ' . htmlspecialchars($nombreUsuario) . '</h3>' .
            '<p style="font-size: 16px; line-height: 1.6;">¡Excelentes noticias! Tu certificado de <strong>' . htmlspecialchars($tipoCertificado) . '</strong> para el evento <strong>' . htmlspecialchars($nombreEvento) . '</strong> ya ha sido generado y está disponible para descarga.</p>' .
            
            '<div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;">' .
            '<h4 style="color: #0066cc; margin-top: 0;">📋 Cómo descargar tu certificado:</h4>' .
            '<ol style="margin: 0; padding-left: 20px;">' .
            '<li style="margin-bottom: 8px;">Ingresa a tu dashboard en el sistema de eventos</li>' .
            '<li style="margin-bottom: 8px;">Dirígete a la sección <strong>"Mis Certificados"</strong></li>' .
            '<li style="margin-bottom: 8px;">Encuentra el evento <strong>' . htmlspecialchars($nombreEvento) . '</strong></li>' .
            '<li style="margin-bottom: 8px;">Haz clic en <strong>"Ver PDF"</strong> para descargar tu certificado</li>' .
            '</ol>' .
            '</div>' .
            
            '<div style="background-color: #e8f5e8; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #28a745;">' .
            '<p style="margin: 0; color: #155724; font-weight: bold;">💡 Tip: Guarda tu certificado en un lugar seguro. Puedes descargarlo las veces que necesites desde tu cuenta.</p>' .
            '</div>' .
            
            '<p style="text-align: center; margin-top: 30px; color: #0066cc; font-size: 18px; font-weight: bold;">¡Felicidades por tu logro! 🎊</p>' .
            
            '<hr style="border: none; border-top: 1px solid #e0e0e0; margin: 20px 0;">' .
            '<p style="font-size: 14px; color: #666; text-align: center; margin-bottom: 0;"><em>Este correo fue enviado automáticamente por el Sistema de Eventos.</em></p>' .
            '</div>';
        
        $mail->Body = $cuerpoCorreo;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo de certificado PDF disponible: ' . $mail->ErrorInfo);
        return false;
    }
}

?>