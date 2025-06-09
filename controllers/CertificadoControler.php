<?php
session_start();
require_once '../models/Certificados.php';

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
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
        }
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

    private function json($data)
    {
        echo json_encode($data);
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
    // Puedes enriquecer con más datos si lo necesitas
    $this->json($data);
}
private function subirCertificado()
{
    if (!isset($_FILES['certificado']) || !isset($_POST['idUsuario']) || !isset($_POST['idEvento'])) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Datos incompletos para subir certificado.']);
        return;
    }

    $file = $_FILES['certificado'];
    $idUsuario = $_POST['idUsuario'];
    $idEvento = $_POST['idEvento'];

    $nombreArchivo = 'certificado_' . $idUsuario . '_' . $idEvento . '_' . time() . '.pdf';
    $rutaDestino = '../documents/' . $nombreArchivo;

    if (move_uploaded_file($file['tmp_name'], $rutaDestino)) {
        $certExistente = $this->certificadoModelo->buscarCertificadoPorUsuarioEvento($idUsuario, $idEvento);
        if ($certExistente) {
            $ok = $this->certificadoModelo->editarCertificado($certExistente['SECUENCIAL'], $nombreArchivo);
        } else {
            $ok = $this->certificadoModelo->crearCertificado($idUsuario, $idEvento, $nombreArchivo);
        }
        $this->json([
            'tipo' => $ok ? 'success' : 'error',
            'mensaje' => $ok ? 'Certificado subido y guardado' : 'Error al guardar en BD',
            'url_certificado' => $ok ? $nombreArchivo : null
        ]);
    } else {
        $this->json(['tipo' => 'error', 'mensaje' => 'Error al subir el archivo']);
    }
}
}

// Instancia y ejecución
$controller = new CertificadoController();
$controller->handleRequest();