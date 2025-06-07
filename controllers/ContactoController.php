<?php
// Incluimos las clases directamente desde la carpeta src manual
require_once '../vendor/PHPMailer-master/src/PHPMailer.php';
require_once '../vendor/PHPMailer-master/src/SMTP.php';
require_once '../vendor/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

class ContactoController
{
    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $this->json(['error' => 'Método no permitido']);
            return;
        }

        $nombre  = trim($_POST['name'] ?? '');
        $correo  = trim($_POST['email'] ?? '');
        $asunto  = trim($_POST['subject'] ?? '');
        $mensaje = trim($_POST['message'] ?? '');

        if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
            http_response_code(400);
            $this->json(['error' => 'Todos los campos son obligatorios']);
            return;
        }

        $mail = new PHPMailer(true);

        try {
            // Debug opcional para pruebas
            // $mail->SMTPDebug = 2;
            // $mail->Debugoutput = 'html';

            // Configuración del servidor SMTP de Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'dennisquisaguanomolina@gmail.com';  // Tu correo Gmail
            $mail->Password = 'iswddolapmjfxdjp';                  // Tu contraseña de aplicación
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Remitente (debe coincidir con el correo autenticado)
            $mail->setFrom('dennisquisaguanomolina@gmail.com', 'Formulario de Contacto');

            // Responder a (correo del usuario que llena el formulario)
            $mail->addReplyTo($correo, $nombre);

            // Destinatario real
            $mail->addAddress('jllumitasig2280@uta.edu.ec', 'Soporte UTA');
             $mail->addAddress('dennisquisaguanomolina@gmail.com', 'Soporte UTA');
            // Puedes agregar más destinatarios para pruebas:
            // $mail->addAddress('tugmail@gmail.com');

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = "Consulta: $asunto";
            $mail->Body    = "
                <strong>Nombre:</strong> $nombre <br>
                <strong>Correo:</strong> $correo <br>
                <strong>Asunto:</strong> $asunto <br>
                <strong>Mensaje:</strong><br><p>$mensaje</p>
            ";

            $mail->send();
            $this->json(['ok' => true, 'message' => 'Mensaje enviado correctamente.']);
        } catch (Exception $e) {
            http_response_code(500);
            $this->json(['error' => 'Error al enviar el mensaje: ' . $mail->ErrorInfo]);
        }
    }

    private function json($data)
    {
        echo json_encode($data);
    }
}

$controller = new ContactoController();
$controller->handleRequest();
