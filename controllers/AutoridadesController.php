

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../models/Autoridades.php';

header('Content-Type: application/json');

class AutoridadesController
{
    private $autoridadesModelo;

    public function __construct()
    {
        $this->autoridadesModelo = new Autoridades();
    }

    public function handleRequest()
    {
        $option = $_GET['option'] ?? '';

        switch ($option) {
            case 'listar':
                $this->listar(); break;
            case 'crear':
                $this->crear(); break;
            case 'actualizar':
                $this->actualizar(); break;
            case 'eliminar':
                $this->eliminar(); break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
        }
    }

        private function listar()
        {
            try {
                $esAdmin = $_GET['admin'] ?? false;

                if ($esAdmin) {
                    $data = $this->autoridadesModelo->getTodasAutoridades();
                } else {
                    $data = $this->autoridadesModelo->getAutoridades(); // Solo activos
                }

                $this->json(['tipo' => 'success', 'autoridades' => $data]);
            } catch (Exception $e) {
                $this->json(['tipo' => 'error', 'mensaje' => $e->getMessage()]);
            }
        }


    private function crear()
    {
        $input = $_POST;

        // Validación de campos requeridos
        if (
            empty($input['NOMBRE']) ||
            empty($input['CARGO']) ||
            empty($input['CORREO']) ||
            empty($input['TELEFONO']) ||
            !isset($_FILES['FOTO_URL']) || $_FILES['FOTO_URL']['error'] !== UPLOAD_ERR_OK
        ) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Todos los campos, incluida la foto, son obligatorios']);
            return;
        }

        // Procesar imagen
        $origen = $_FILES['FOTO_URL']['tmp_name'];
        $nombreArchivo = basename($_FILES['FOTO_URL']['name']);
        $destino = '../public/img/autoridades/' . $nombreArchivo;

        if (!move_uploaded_file($origen, $destino)) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al subir la imagen']);
            return;
        }

        $input['FOTO_URL'] = $nombreArchivo;

        // Si no viene ESTADO del form, se asume 1
        if (!isset($input['ESTADO'])) {
            $input['ESTADO'] = 1;
        }

        $exito = $this->autoridadesModelo->crear($input);

        if ($exito) {
            $this->json(['tipo' => 'success', 'mensaje' => 'Autoridad creada correctamente']);
        } else {
            $this->json(['tipo' => 'error', 'mensaje' => 'No se pudo crear la autoridad']);
        }
    }

    private function actualizar()
    {
        $id = $_POST['SECUENCIAL'] ?? null;
        $input = $_POST;

        if (!$id || empty($input['NOMBRE'])) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID o campos obligatorios faltantes']);
            return;
        }

        if (isset($_FILES['FOTO_URL']) && $_FILES['FOTO_URL']['error'] === UPLOAD_ERR_OK) {
            $origen = $_FILES['FOTO_URL']['tmp_name'];
            $nombreArchivo = basename($_FILES['FOTO_URL']['name']);
            $destino = '../public/img/autoridades/' . $nombreArchivo;

            if (move_uploaded_file($origen, $destino)) {
                $input['FOTO_URL'] = $nombreArchivo;
            }
        }

        // Si no se envía estado (por ejemplo al editar sin tocarlo), asumir que se mantiene activo
        if (!isset($input['ESTADO'])) {
            $input['ESTADO'] = 1;
        }

        $exito = $this->autoridadesModelo->actualizar($id, $input);

        if ($exito) {
            $this->json(['tipo' => 'success', 'mensaje' => 'Autoridad actualizada']);
        } else {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar']);
        }
    }

    private function eliminar()
    {
        $id = $_POST['SECUENCIAL'] ?? null;

        if (!$id) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID no proporcionado']);
            return;
        }

        $exito = $this->autoridadesModelo->eliminar($id);

        if ($exito) {
            $this->json(['tipo' => 'success', 'mensaje' => 'Autoridad eliminada']);
        } else {
            $this->json(['tipo' => 'error', 'mensaje' => 'No se pudo eliminar']);
        }
    }

    private function json($data)
    {
        echo json_encode($data);
    }
}

$controller = new AutoridadesController();
$controller->handleRequest();
