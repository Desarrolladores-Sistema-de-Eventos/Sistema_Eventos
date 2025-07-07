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
        $mail->CharSet = 'UTF-8';
        $mail->Subject = '¡Inscripción validada para el evento: ' . $nombreEvento . '!';
        $mail->Body =
            '<div style="font-family: Segoe UI, Arial, Helvetica, sans-serif; background: #faf9f6; border-radius: 12px; border: 1px solid #e0e0e0; max-width: 540px; margin: 0 auto; box-shadow: 0 4px 16px #0002;">'
            . '<div style="background-color: #1e88e5; padding: 22px 28px 14px 28px; border-radius: 12px 12px 0 0; display: table; width: 100%;">'
            . '<span style="font-size: 2.2em; margin-right: 16px; display: table-cell; vertical-align: middle;">🎉</span>'
            . '<div style="display: table-cell; vertical-align: middle;">'
            . '<h2 style="margin:0; font-size: 1.35em; font-weight: bold; letter-spacing: 1px; color: #fff;">¡Inscripción validada!</h2>'
            . '<div style="font-size: 1em; opacity: 0.92; color: #fff;">Sistema de Eventos UTA</div>'
            . '</div>'
            . '</div>'
            . '<div style="padding: 26px 28px 18px 28px; color: #222;">'
            . '<p style="font-size: 1.13em; margin-bottom: 12px;">¡Felicidades, <b style="color:#1e88e5;">' . htmlspecialchars($nombreUsuario) . '</b>!</p>'
            . '<p style="margin-bottom: 10px;">Tus documentos han sido validados y ya estás inscrito al evento:</p>'
            . '<div style="background: #fff; border-radius: 8px; border: 1px solid #eee; padding: 16px 18px; margin-bottom: 16px;">'
            . '<p style="margin: 0 0 8px 0;"><b style="color:#1e88e5;">Evento:</b> ' . htmlspecialchars($nombreEvento) . '</p>'
            . '</div>'
            . '<div style="margin: 18px 0 0 0; color: #b42222; font-weight: bold; font-size: 1.05em;">'
            . '¡Te esperamos!'
            . '</div>'
            . '</div>'
            . '<div style="background: #222; color: #fff; padding: 12px 28px; border-radius: 0 0 12px 12px; font-size: 0.98em; text-align: right;">'
            . '<span style="font-weight: bold; letter-spacing: 1px;">Universidad Técnica de Ambato</span>'
            . '</div>'
            . '</div>';
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
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Documentos rechazados para el evento: ' . $nombreEvento;
        $mail->Body =
            '<div style="font-family: Segoe UI, Arial, Helvetica, sans-serif; background: #faf9f6; border-radius: 12px; border: 1px solid #e0e0e0; max-width: 540px; margin: 0 auto; box-shadow: 0 4px 16px #0002;">'
            . '<div style="background-color: #b42222; padding: 22px 28px 14px 28px; border-radius: 12px 12px 0 0; display: table; width: 100%;">'
            . '<span style="font-size: 2.2em; margin-right: 16px; display: table-cell; vertical-align: middle;">❌</span>'
            . '<div style="display: table-cell; vertical-align: middle;">'
            . '<h2 style="margin:0; font-size: 1.35em; font-weight: bold; letter-spacing: 1px; color: #fff;">Documentos rechazados</h2>'
            . '<div style="font-size: 1em; opacity: 0.92; color: #fff;">Sistema de Eventos UTA</div>'
            . '</div>'
            . '</div>'
            . '<div style="padding: 26px 28px 18px 28px; color: #222;">'
            . '<p style="font-size: 1.13em; margin-bottom: 12px;">Hola, <b style="color:#b42222;">' . htmlspecialchars($nombreUsuario) . '</b>.</p>'
            . '<p style="margin-bottom: 10px;">La información o documentos que subiste para el evento:</p>'
            . '<div style="background: #fff; border-radius: 8px; border: 1px solid #eee; padding: 16px 18px; margin-bottom: 16px;">'
            . '<p style="margin: 0 0 8px 0;"><b style="color:#b42222;">Evento:</b> ' . htmlspecialchars($nombreEvento) . '</p>'
            . '</div>'
            . '<div style="margin: 0 0 18px 0; color: #b42222; font-weight: bold; font-size: 1.05em;">'
            . 'han sido <span style="color:#b42222;">rechazados</span>.'
            . '</div>'
            . '<div style="margin: 0 0 0 0; color: #1e88e5; font-size: 1.05em;">'
            . 'Por favor, revisa y vuelve a subir los requisitos correctamente para poder completar tu inscripción.'
            . '</div>'
            . '</div>'
            . '<div style="background: #222; color: #fff; padding: 12px 28px; border-radius: 0 0 12px 12px; font-size: 0.98em; text-align: right;">'
            . '<span style="font-weight: bold; letter-spacing: 1px;">Universidad Técnica de Ambato</span>'
            . '</div>'
            . '</div>';
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
        $mail->CharSet = 'UTF-8';
        $mail->Subject = '¡Certificado en proceso para: ' . $nombreEvento . '!';

        $cuerpoCorreo = '
        <div style="font-family: Arial, sans-serif; background: #f4f8fb; border-radius: 12px; border: 1px solid #e0e0e0; max-width: 540px; margin: 0 auto; box-shadow: 0 4px 16px #0002;">
            <div style="background-color: #1e88e5; color: #fff; padding: 22px 28px 14px 28px; border-radius: 12px 12px 0 0; display: table; width: 100%;">
                <span style="font-size: 2.2em; margin-right: 16px; display: table-cell; vertical-align: middle;">⏳</span>
                <div style="display: table-cell; vertical-align: middle;">
                    <h2 style="margin:0; font-size: 1.35em; font-weight: bold; letter-spacing: 1px; color: #fff;">¡Tu certificado está en proceso!</h2>
                    <div style="font-size: 1em; opacity: 0.92; color: #fff;">Sistema de Eventos UTA</div>
                </div>
            </div>
            <div style="padding: 26px 28px 18px 28px; color: #222;">
                <p style="font-size: 1.13em; margin-bottom: 12px;">¡Felicidades, <b style=\"color:#1e88e5;\">' . htmlspecialchars($nombreUsuario) . '</b>!</p>
                <p>Has cumplido con todos los requisitos del evento <b>' . htmlspecialchars($nombreEvento) . '</b>.</p>
                <p>Tu certificado de <b>' . htmlspecialchars($tipoCertificado) . '</b> está siendo generado. Te avisaremos cuando esté listo.</p>';

        // Detalles adicionales (nota, porcentaje, etc.)
        if (!empty($detallesAdicionales)) {
            $cuerpoCorreo .= '<div style="background: #e3f2fd; border-radius: 8px; border: 1px solid #90caf9; padding: 16px 18px; margin: 18px 0 16px 0;">
                <b>📊 Detalles de tu participación:</b><ul style="margin: 8px 0 0 18px;">';
            foreach ($detallesAdicionales as $detalle) {
                $cuerpoCorreo .= '<li>' . htmlspecialchars($detalle) . '</li>';
            }
            $cuerpoCorreo .= '</ul></div>';
        }

        $cuerpoCorreo .= '
                <div style="margin: 18px 0 0 0;">
                    <b>📋 ¿Cómo descargar tu certificado?</b>
                    <ol>
                        <li>Ingresa a tu dashboard en el sistema</li>
                        <li>Ve a la sección "Mis Certificados"</li>
                        <li>Descarga tu certificado</li>
                    </ol>
                </div>
                <div style="margin: 18px 0 0 0; color: #1e88e5; font-weight: bold; font-size: 1.05em;">
                    ¡Enhorabuena por tu logro!
                </div>
            </div>
            <div style="background: #222; color: #fff; padding: 12px 28px; border-radius: 0 0 12px 12px; font-size: 0.98em; text-align: right;">
                <span style="font-weight: bold; letter-spacing: 1px;">Universidad Técnica de Ambato</span>
            </div>
        </div>';

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
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Información sobre certificado - ' . $nombreEvento;
        
        $cuerpoCorreo = '
        <div style="font-family: Arial, sans-serif; background: #f4f8fb; border-radius: 12px; border: 1px solid #e0e0e0; max-width: 540px; margin: 0 auto; box-shadow: 0 4px 16px #0002;">
            <div style="background-color: #b42222; color: #fff; padding: 22px 28px 14px 28px; border-radius: 12px 12px 0 0; display: table; width: 100%;">
                <span style="font-size: 2.2em; margin-right: 16px; display: table-cell; vertical-align: middle;">ℹ️</span>
                <div style="display: table-cell; vertical-align: middle;">
                    <h2 style="margin:0; font-size: 1.25em; font-weight: bold; letter-spacing: 1px; color: #fff;">Información sobre tu certificado</h2>
                    <div style="font-size: 1em; opacity: 0.92; color: #fff;">Sistema de Eventos UTA</div>
                </div>
            </div>
            <div style="padding: 26px 28px 18px 28px; color: #222;">
                <p style="font-size: 1.13em; margin-bottom: 12px;">Hola, <b style=\"color:#b42222;\">' . htmlspecialchars($nombreUsuario) . '</b>.</p>
                <p>Te informamos sobre el estado de tu certificado para el evento <b>' . htmlspecialchars($nombreEvento) . '</b>.</p>
                <div style="background: #fff3e0; border-radius: 8px; border: 1px solid #ffcc80; padding: 14px 18px; margin: 18px 0 16px 0;">
                    <b>📋 Razón:</b> ' . htmlspecialchars($razon) . '
                </div>';

        // Agregar detalles específicos si existen
        if (!empty($detallesAdicionales)) {
            $cuerpoCorreo .= '<div style="background: #e3f2fd; border-radius: 8px; border: 1px solid #90caf9; padding: 16px 18px; margin: 18px 0 16px 0;">
                <b>📊 Detalles de tu participación:</b><ul style="margin: 8px 0 0 18px;">';
            foreach ($detallesAdicionales as $detalle) {
                $cuerpoCorreo .= '<li>' . htmlspecialchars($detalle) . '</li>';
            }
            $cuerpoCorreo .= '</ul></div>';
        }

        $cuerpoCorreo .= '
                <div style="margin: 18px 0 0 0; color: #1e88e5; font-size: 1.05em;">
                    Si tienes alguna consulta, por favor contacta con el responsable del evento.
                </div>
                <div style="margin: 10px 0 0 0; color: #222; font-size: 1em;">
                    <em>Gracias por tu participación.</em>
                </div>
            </div>
            <div style="background: #222; color: #fff; padding: 12px 28px; border-radius: 0 0 12px 12px; font-size: 0.98em; text-align: right;">
                <span style="font-weight: bold; letter-spacing: 1px;">Universidad Técnica de Ambato</span>
            </div>
        </div>';
        
        $mail->Body = $cuerpoCorreo;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo de certificado no generado: ' . $mail->ErrorInfo);
        return false;
    }
}

function enviarCorreoCertificadoPDFDisponible($correoDestino, $nombreUsuario, $nombreEvento, $tipoCertificado) {
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
        $mail->CharSet = 'UTF-8';
        $mail->Subject = '📄 ¡Tu certificado PDF ya está listo! - ' . $nombreEvento;

        $cuerpoCorreo = '
        <div style="font-family: Arial, sans-serif; background: #f4f8fb; border-radius: 12px; border: 1px solid #e0e0e0; max-width: 540px; margin: 0 auto; box-shadow: 0 4px 16px #0002;">
            <div style="background-color: #1e88e5; color: #fff; padding: 22px 28px 14px 28px; border-radius: 12px 12px 0 0; display: table; width: 100%;">
                <span style="font-size: 2.2em; margin-right: 16px; display: table-cell; vertical-align: middle;">🎉</span>
                <div style="display: table-cell; vertical-align: middle;">
                    <h2 style="margin:0; font-size: 1.35em; font-weight: bold; letter-spacing: 1px; color: #fff;">¡Tu certificado está listo!</h2>
                    <div style="font-size: 1em; opacity: 0.92; color: #fff;">Sistema de Eventos UTA</div>
                </div>
            </div>
            <div style="padding: 26px 28px 18px 28px; color: #222;">
                <p style="font-size: 1.13em; margin-bottom: 12px;">Hola, <b style=\"color:#1e88e5;\">' . htmlspecialchars($nombreUsuario) . '</b>.</p>
                <p style="font-size: 16px; line-height: 1.6;">¡Excelentes noticias! Tu certificado de <strong>' . htmlspecialchars($tipoCertificado) . '</strong> para el evento <strong>' . htmlspecialchars($nombreEvento) . '</strong> ya ha sido generado y está disponible para descarga.</p>';

        // Si en el futuro se quieren mostrar detalles adicionales, aquí se puede agregar el bloque:
        // if (!empty($detallesAdicionales)) { ... }

        $cuerpoCorreo .= '
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;">
                    <h4 style="color: #0066cc; margin-top: 0;">📋 ¿Cómo descargar tu certificado?</h4>
                    <ol style="margin: 0; padding-left: 20px;">
                        <li style="margin-bottom: 8px;">Ingresa a tu dashboard en el sistema de eventos</li>
                        <li style="margin-bottom: 8px;">Dirígete a la sección <strong>\"Mis Certificados\"</strong></li>
                        <li style="margin-bottom: 8px;">Encuentra el evento <strong>' . htmlspecialchars($nombreEvento) . '</strong></li>
                        <li style="margin-bottom: 8px;">Haz clic en <strong>\"Ver PDF\"</strong> para descargar tu certificado</li>
                    </ol>
                </div>
                <div style="background: #e8f5e8; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #28a745;">
                    <p style="margin: 0; color: #155724; font-weight: bold;">💡 Tip: Guarda tu certificado en un lugar seguro. Puedes descargarlo las veces que necesites desde tu cuenta.</p>
                </div>
                <div style="text-align: center; margin-top: 30px; color: #0066cc; font-size: 18px; font-weight: bold;">¡Felicidades por tu logro! 🎊</div>
            </div>
            <div style="background: #222; color: #fff; padding: 12px 28px; border-radius: 0 0 12px 12px; font-size: 0.98em; text-align: right;">
                <span style="font-weight: bold; letter-spacing: 1px;">Universidad Técnica de Ambato</span>
            </div>
            <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 20px 0;">
            <p style="font-size: 14px; color: #666; text-align: center; margin-bottom: 0;"><em>Este correo fue enviado automáticamente por el Sistema de Eventos.</em></p>
        </div>';
        
        $mail->Body = $cuerpoCorreo;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo de certificado PDF disponible: ' . $mail->ErrorInfo);
        return false;
    }
}

?>