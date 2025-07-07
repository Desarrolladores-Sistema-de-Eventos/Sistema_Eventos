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
        $mail->Host = 'smtp.sendgrid.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'apikey'; 
        $mail->Password = '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';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('ernestojurado2004@gmail.com', 'Sistema de Eventos');
        $mail->addAddress($correoDestino, $nombreResponsable);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) {
            error_log("PHPMailer SMTP: $str");
        };
        $mail->Subject = 'Nueva inscripción en tu evento: ' . $nombreEvento;
        try {
            $mail->Body =
                '<div style="font-family: Segoe UI, Arial, Helvetica, sans-serif; background: #faf9f6; border-radius: 12px; border: 1px solid #e0e0e0; max-width: 540px; margin: 0 auto; box-shadow: 0 4px 16px #0002;">'
                . '<div style="background-color: #b42222; padding: 22px 28px 14px 28px; border-radius: 12px 12px 0 0; display: table; width: 100%;">'
                . '<span style="font-size: 2.2em; margin-right: 16px; display: table-cell; vertical-align: middle;">🎓</span>'
                . '<div style="display: table-cell; vertical-align: middle;">'
                . '<h2 style="margin:0; font-size: 1.35em; font-weight: bold; letter-spacing: 1px; color: #fff;">¡Nueva inscripción recibida!</h2>'
                . '<div style="font-size: 1em; opacity: 0.92; color: #fff;">Sistema de Eventos UTA</div>'
                . '</div>'
                . '</div>'
                . '<div style="padding: 26px 28px 18px 28px; color: #222;">'
                . '<p style="font-size: 1.13em; margin-bottom: 12px;">Hola <b style="color:#b42222;">' . htmlspecialchars($nombreResponsable) . '</b>,</p>'
                . '<p style="margin-bottom: 10px;">Te informamos que una persona se ha inscrito en tu evento. Aquí tienes los detalles:</p>'
                . '<div style="background: #fff; border-radius: 8px; border: 1px solid #eee; padding: 16px 18px; margin-bottom: 16px;">'
                . '<p style="margin: 0 0 8px 0;"><b style="color:#b42222;">Evento:</b> ' . htmlspecialchars($nombreEvento) . '</p>'
                . '<p style="margin: 0 0 8px 0;"><b style="color:#b42222;">Nombre del inscrito:</b> ' . htmlspecialchars($nombreInscrito) . '</p>'
                . '<div style="margin: 10px 0 0 0;">'
                . '<b style="color:#b42222;">Datos:</b>'
                . '<div style="margin: 8px 0 0 0; color: #333; font-size: 1em;">' . $datosInscrito . '</div>'
                . '</div>'
                . '</div>'
                . '<div style="margin: 18px 0 0 0; color: #1e88e5; font-weight: bold; font-size: 1.05em;">'
                . 'Acción requerida: Por favor, estar pendiente de la subida de los requisitos y del comprobante de pago.'
                . '</div>'
                . '</div>'
                . '<div style="background: #222; color: #fff; padding: 12px 28px; border-radius: 0 0 12px 12px; font-size: 0.98em; text-align: right;">'
                . '<span style="font-weight: bold; letter-spacing: 1px;">Universidad Técnica de Ambato</span>'
                . '</div>'
                . '</div>';
        } catch (Exception $e) {
            throw $e;
        }
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo: ' . $mail->ErrorInfo . ' | Exception: ' . $e->getMessage());
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
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Requisitos y comprobante enviados para el evento: ' . $nombreEvento;
        $mail->Body =
            '<div style="font-family: Segoe UI, Arial, Helvetica, sans-serif; background: #faf9f6; border-radius: 12px; border: 1px solid #e0e0e0; max-width: 540px; margin: 0 auto; box-shadow: 0 4px 16px #0002;">'
            . '<div style="background-color: #b42222; padding: 22px 28px 14px 28px; border-radius: 12px 12px 0 0; display: table; width: 100%;">'
            . '<span style="font-size: 2.2em; margin-right: 16px; display: table-cell; vertical-align: middle;">📄</span>'
            . '<div style="display: table-cell; vertical-align: middle;">'
            . '<h2 style="margin:0; font-size: 1.25em; font-weight: bold; letter-spacing: 1px; color: #fff;">Requisitos y comprobante enviados</h2>'
            . '<div style="font-size: 1em; opacity: 0.92; color: #fff;">Sistema de Eventos UTA</div>'
            . '</div>'
            . '</div>'
            . '<div style="padding: 26px 28px 18px 28px; color: #222;">'
            . '<p style="font-size: 1.13em; margin-bottom: 12px;">Hola <b style="color:#b42222;">' . htmlspecialchars($nombreResponsable) . '</b>,</p>'
            . '<p style="margin-bottom: 10px;">Un inscrito ha enviado los requisitos y comprobante de pago para tu evento. Aquí tienes los detalles:</p>'
            . '<div style="background: #fff; border-radius: 8px; border: 1px solid #eee; padding: 16px 18px; margin-bottom: 16px;">'
            . '<p style="margin: 0 0 8px 0;"><b style="color:#b42222;">Evento:</b> ' . htmlspecialchars($nombreEvento) . '</p>'
            . '<p style="margin: 0 0 8px 0;"><b style="color:#b42222;">Nombre del inscrito:</b> ' . htmlspecialchars($nombreInscrito) . '</p>'
            . '<div style="margin: 10px 0 0 0;">'
            . '<b style="color:#b42222;">Datos:</b>'
            . '<div style="margin: 8px 0 0 0; color: #333; font-size: 1em;">' . $datosInscrito . '</div>'
            . '</div>'
            . '</div>'
            . '<div style="margin: 18px 0 0 0; color: #1e88e5; font-weight: bold; font-size: 1.05em;">'
            . 'Acción requerida: Por favor, revisa los documentos y valida la inscripción.'
            . '</div>'
            . '</div>'
            . '<div style="background: #222; color: #fff; padding: 12px 28px; border-radius: 0 0 12px 12px; font-size: 0.98em; text-align: right;">'
            . '<span style="font-weight: bold; letter-spacing: 1px;">Universidad Técnica de Ambato</span>'
            . '</div>'
            . '</div>';
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error enviando correo: ' . $mail->ErrorInfo);
        return false;
    }
}