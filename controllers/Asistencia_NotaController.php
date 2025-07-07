<?php
session_start();
require_once '../models/Asistencia_Nota.php';


class Asistencia_NotaController {
    private $modelo;
    private $idUsuario;

    public function __construct() {
        $this->modelo = new Asistencia_Nota();
        $this->idUsuario = $_SESSION['usuario']['SECUENCIAL'] ?? null;

        if (!$this->idUsuario) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Sesión expirada']);
            exit;
        }
    }

    public function handleRequest() {
        $option = $_GET['option'] ?? '';
        switch ($option) {
            case 'eventosResponsable':
                $this->eventosResponsable();
                break;
            case 'inscritosEvento':
                $this->inscritosEvento();
                break;
            case 'guardarAsistenciaNota':
                $this->guardarAsistenciaNota();
                break;
            case 'finalizarEvento':
  $this->finalizarEvento();
  break;
 case 'guardarNotasYFinalizar':
    $this->guardarNotasYFinalizar();
    break;

            default:
                $this->json(['error' => 'Opción no válida']);
        }
    }

private function guardarNotasYFinalizar() {
    $idEvento = $_POST['idEvento'] ?? null;
    $datos = json_decode($_POST['datos'] ?? '[]', true);

    if (!$idEvento || empty($datos)) {
        $this->json(['success' => false, 'mensaje' => 'Datos incompletos.']);
        return;
    }
    $resultado = $this->modelo->guardarNotasYFinalizarEvento($idEvento, $datos);

    $this->json($resultado);
}



    // Listar eventos donde el usuario es responsabl
private function eventosResponsable() {
    $data = $this->modelo->eventosPorResponsable($this->idUsuario);
    $this->json($data);
}

private function inscritosEvento()
{
    $idEvento = $_GET['idEvento'] ?? null;
    if (!$idEvento) {
        echo json_encode([]);
        return;
    }
    $inscritos = $this->modelo->getInscritosAceptadosEvento($idEvento);
    $this->json($inscritos);
}

private function guardarAsistenciaNota()
{
    $idInscripcion = $_POST['idInscripcion'] ?? null;
    $asistencia = $_POST['asistencia'] ?? null;
    $nota = $_POST['nota'] ?? null;
    $porcentajeAsistencia = $_POST['porcentaje'] ?? null;
    $observacion = $_POST['observacion'] ?? null;

    if (!$idInscripcion || $asistencia === null) {
        $this->json(['success' => false, 'mensaje' => 'Datos incompletos']);
        return;
    }

    $resultado = $this->modelo->guardarAsistenciaNota(
        $idInscripcion,
        $asistencia,
        $nota,
        $porcentajeAsistencia,
        $observacion
    );

    $this->json($resultado);
}

    private function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

$controller = new Asistencia_NotaController();
$controller->handleRequest();

?>