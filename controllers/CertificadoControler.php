<?php

session_start();
require_once '../models/Certificados.php';
require_once '../core/correo_usuario.php';

header('Content-Type: application/json');

class CertificadoController
{
    private $certificadoModelo;
    private $idUsuario;

    public function __construct()
    {
        $this->certificadoModelo = new Certificado();
        $this->idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;

        if (!$this->idUsuario) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Sesión expirada']);
            exit;
        }
    }

    public function handleRequest()
    {
        $option = $_GET['option'] ?? '';

        switch ($option) {
            case 'listarPorEvento':
                $this->listarPorEvento();
                break;
            case 'listarPorUsuario':
                $this->listarPorUsuario();
                break;
            case 'crear':
                $this->crear();
                break;
            case 'editar':
                $this->editar();
                break;
            case 'obtener':
                $this->obtener();
                break;
            case 'datosParaGenerar':
                $this->datosParaGenerar();
                break;
            case 'subirCertificado':
                $this->subirCertificado();
                break;
            case 'emitidosPorEvento':
                $this->emitidosPorEvento();
                break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
        }
    }

    private function emitidosPorEvento()
    {
        $idEvento = $_GET['idEvento'] ?? null;
        if (!$idEvento) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID del evento requerido']);
            return;
        }

        $certificados = $this->certificadoModelo->getCertificadosEmitidos($idEvento);
        $this->json(['tipo' => 'success', 'data' => $certificados]);
    }

    private function listarPorEvento()
    {
        $idEvento = $_GET['idEvento'] ?? null;
        if (!$idEvento) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID de evento requerido.']);
            return;
        }
        $data = $this->certificadoModelo->getCertificadosPorEvento($idEvento);
        $this->json($data);
    }

    private function listarPorUsuario()
    {
        $idUsuario = $_GET['idUsuario'] ?? $this->idUsuario;
        $data = $this->certificadoModelo->getCertificadosPorUsuario($idUsuario);
        $this->json($data);
    }

    private function crear()
    {
        $idUsuario = $_POST['idUsuario'] ?? null;
        $idEvento = $_POST['idEvento'] ?? null;
        $urlCertificado = $_POST['urlCertificado'] ?? null;

        if (!$idUsuario || !$idEvento || !$urlCertificado) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Datos incompletos para crear certificado.']);
            return;
        }

        $ok = $this->certificadoModelo->crearCertificado($idUsuario, $idEvento, $urlCertificado);
        $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Certificado creado' : 'No se pudo crear el certificado']);
    }

    private function editar()
    {
        $idCertificado = $_POST['idCertificado'] ?? null;
        $urlCertificado = $_POST['urlCertificado'] ?? null;

        if (!$idCertificado || !$urlCertificado) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Datos incompletos para editar certificado.']);
            return;
        }

        $ok = $this->certificadoModelo->editarCertificado($idCertificado, $urlCertificado);
        $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Certificado actualizado' : 'No se pudo actualizar el certificado']);
    }

    private function obtener()
    {
        $idCertificado = $_GET['idCertificado'] ?? null;
        if (!$idCertificado) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID de certificado requerido.']);
            return;
        }
        $data = $this->certificadoModelo->getCertificado($idCertificado);
        $this->json($data);
    }

    private function datosParaGenerar()
    {
        $idCertificado = $_GET['idCertificado'] ?? null;
        if (!$idCertificado) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID de certificado requerido.']);
            return;
        }
        $data = $this->certificadoModelo->getCertificado($idCertificado);
        if (!$data) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Certificado no encontrado.']);
            return;
        }
        $this->json($data);
    }


private function subirCertificado()
{
    $base64 = $_POST['base64'] ?? null;
    $idUsuario = $_POST['idUsuario'] ?? null;
    $idEvento = $_POST['idEvento'] ?? null;

    if (!$base64 || !$idUsuario || !$idEvento) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Datos incompletos para subir certificado.']);
        return;
    }

    // Validar existencia de usuario y evento antes de continuar
    if (!$this->certificadoModelo->usuarioYEventoExisten($idUsuario, $idEvento)) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Usuario o evento no existe.']);
        return;
    }

    $pdfData = base64_decode($base64);
    if (!$pdfData || strlen($pdfData) < 1000) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Base64 inválido o PDF demasiado pequeño']);
        return;
    }

    $nombreArchivo = 'certificado_' . intval($idUsuario) . '_' . intval($idEvento) . '_' . time() . '.pdf';
    $directorio = '../documents/';
    $rutaDestino = $directorio . $nombreArchivo;

    if (!is_dir($directorio) || !is_writable($directorio)) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Directorio de destino no disponible o no escribible']);
        return;
    }

    $guardado = @file_put_contents($rutaDestino, $pdfData);
    if ($guardado === false) {
        $this->json(['tipo' => 'error', 'mensaje' => 'No se pudo guardar el archivo PDF']);
        return;
    }

    try {
        $certExistente = $this->certificadoModelo->buscarCertificadoPorUsuarioEvento($idUsuario, $idEvento);

        if ($certExistente) {
            $resultado = $this->certificadoModelo->editarCertificado($certExistente['SECUENCIAL'], $nombreArchivo);
        } else {
            $resultado = $this->certificadoModelo->crearCertificado($idUsuario, $idEvento, $nombreArchivo);
        }

        // Si $resultado es un array, úsalo directamente
        if (is_array($resultado)) {
            $success = $resultado['success'];
            $mensaje = $resultado['mensaje'];
        } else {
            $success = $resultado;
            $mensaje = $resultado ? 'Certificado guardado correctamente' : 'Error al guardar en la base de datos';
        }

        $this->json([
            'tipo' => $success ? 'success' : 'error',
            'mensaje' => $mensaje,
            'url_certificado' => $success ? $nombreArchivo : null
        ]);

        // Si se guardó exitosamente, enviar notificación por correo
        if ($success) {
            try {
                // Obtener datos del usuario y evento para el correo
                $pdo = $this->certificadoModelo->getPDO();
                $stmt = $pdo->prepare("
                    SELECT 
                        u.NOMBRES, 
                        u.APELLIDOS, 
                        u.CORREO,
                        e.TITULO AS NOMBRE_EVENTO,
                        e.CODIGOTIPOEVENTO
                    FROM usuario u, evento e 
                    WHERE u.SECUENCIAL = ? AND e.SECUENCIAL = ?
                ");
                $stmt->execute([$idUsuario, $idEvento]);
                $datos = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($datos) {
                    $nombreCompleto = $datos['NOMBRES'] . ' ' . $datos['APELLIDOS'];
                    $tipoCertificado = ($datos['CODIGOTIPOEVENTO'] === 'CUR') ? 'Aprobación' : 'Participación';
                    
                    enviarCorreoCertificadoPDFDisponible(
                        $datos['CORREO'],
                        $nombreCompleto,
                        $datos['NOMBRE_EVENTO'],
                        $tipoCertificado
                    );
                }
            } catch (Exception $e) {
                // Si hay error en el correo, no afectar la respuesta principal
                error_log('Error enviando notificación de certificado PDF: ' . $e->getMessage());
            }
        }
    } catch (Exception $e) {
        if (file_exists($rutaDestino)) {
            unlink($rutaDestino);
        }
        $this->json(['tipo' => 'error', 'mensaje' => 'Excepción al guardar: ' . $e->getMessage()]);
    }
}



    private function json($data)
    {
        echo json_encode($data);
    }
}

// Instancia y ejecución
$controller = new CertificadoController();
$controller->handleRequest();