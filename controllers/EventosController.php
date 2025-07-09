<?php
session_start();
require_once '../models/Eventos.php';

header('Content-Type: application/json');

class EventosController
{
    private $eventoModelo;
    private $idUsuario;

    public function __construct()
    {
        $this->eventoModelo = new Evento();
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
            case 'listarResponsable':
                $this->listarResponsable();
                break;
            case 'esResponsable':
                $this->verificarResponsable();
                break;
            case 'edit':
                $this->editar();
                break;
            case 'save':
                $this->guardar();
                break;
            case 'update':
                $this->actualizar();
                break;
            case 'delete':
                $this->cancelar();
                break;
            case 'listarTarjetas':
                $this->listarTarjetas();
                break;
            case 'listarPublicos':
                $this->listarPublicos();
                break;
            case 'detalleEvento':
                $this->detalleEvento();
                break;
            case 'eventosInscritoCurso':
                $this->listarEventosInscritoCurso();
                break;
            case 'validarInscripcion':
                $this->validarInscripcion();
                break;
            case 'registrarInscripcion':
                $this->registrarInscripcion();
                break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
        }
    }
 private function validarInscripcion()
{
    $idEvento = $_GET['id'] ?? null;

    if (!$idEvento) {
        $this->json(['disponible' => false, 'mensaje' => 'ID del evento no proporcionado.']);
        return;
    }

    $resultado = $this->eventoModelo->validarDisponibilidadInscripcion($idEvento, $this->idUsuario);
    $this->json($resultado);
}
public function registrarInscripcion()
{
    if (!$this->idUsuario) {
        echo json_encode(['tipo' => 'error', 'mensaje' => 'Usuario no autenticado']);
        return;
    }

    $idEvento = $_POST['id_evento'] ?? null;
    $formaPago = $_POST['forma_pago'] ?? null;
    $monto = $_POST['monto'] ?? 0;
    $esPagado = filter_var($_POST['es_pagado'] ?? false, FILTER_VALIDATE_BOOLEAN);

    if (!$idEvento) {
        echo json_encode(['tipo' => 'error', 'mensaje' => 'ID de evento faltante']);
        return;
    }

    // Procesar requisitos
    $requisitos = json_decode($_POST['requisitos'] ?? '[]', true);
    $requisitosArchivos = [];

    foreach ($requisitos as $idReq) {
        $campo = "requisito_$idReq";
        if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] === UPLOAD_ERR_OK) {
            $archivo = $_FILES[$campo];
            $nombre = uniqid("requisito_") . "_" . basename($archivo['name']);
            $ruta = "../documents/$nombre";
            if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
                $requisitosArchivos[$idReq] = $nombre;
            }
        }
    }

    // Procesar comprobante de pago
    $comprobanteRuta = null;
    if (isset($_FILES['comprobante_pago']) && $_FILES['comprobante_pago']['error'] === UPLOAD_ERR_OK) {
        $archivo = $_FILES['comprobante_pago'];
        $nombre = uniqid("comprobante_") . "_" . basename($archivo['name']);
        $ruta = "../documents/$nombre";
        if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
            $comprobanteRuta = $nombre;
        }
    }

    $ok = $this->eventoModelo->registrarInscripcion(
        $this->idUsuario,
        $idEvento,
        $monto,
        $formaPago,
        $esPagado,
        $requisitosArchivos,
        $comprobanteRuta
    );

    
// Si el modelo ya imprimió un error con json_encode (debug), no hacemos nada más
if ($ok === true) {
    echo json_encode([
        'tipo' => 'success',
        'mensaje' => 'Inscripción registrada exitosamente'
    ]);
} elseif ($ok === false) {
    echo json_encode([
        'tipo' => 'error',
        'mensaje' => 'Error al registrar la inscripción'
    ]);
}
}

    private function listarResponsable()
    {
        $data = $this->eventoModelo->getEventosPorResponsable($this->idUsuario);
        foreach ($data as &$e) {
            $e['accion'] = '
                <button onclick="edit(' . $e['SECUENCIAL'] . ')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></button> 
                <button onclick="eliminar(' . $e['SECUENCIAL'] . ')" class="btn btn-danger btn-sm"><i class="fa fa-close"></i></button>';
        }
        $this->json($data);
    }

    private function verificarResponsable()
    {
        $esResponsable = Evento::esResponsable($this->idUsuario);
        $this->json(['responsable' => $esResponsable]);
    }

    private function editar()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID faltante']);
            return;
        }
        $evento = $this->eventoModelo->getEvento($id);
        $this->json($evento);
    }

    private function guardar()
    {
        $required = ['titulo', 'descripcion', 'horas', 'fechaInicio', 'fechaFin', 'modalidad', 'notaAprobacion', 'categoria', 'tipoEvento', 'carrera', 'estado', 'capacidad'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }


        try {
            // Procesar archivo de portada
            $urlPortada = null;
            if (isset($_FILES['urlPortada']) && $_FILES['urlPortada']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = uniqid('portada_') . '_' . basename($_FILES['urlPortada']['name']);
                $rutaDestino = '../public/img/' . $nombreArchivo;
                if (move_uploaded_file($_FILES['urlPortada']['tmp_name'], $rutaDestino)) {
                    $urlPortada = 'public/img/' . $nombreArchivo;
                }
            }

            // Procesar archivo de galería
            $urlGaleria = null;
            if (isset($_FILES['urlGaleria']) && $_FILES['urlGaleria']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = uniqid('galeria_') . '_' . basename($_FILES['urlGaleria']['name']);
                $rutaDestino = '../public/img/' . $nombreArchivo;
                if (move_uploaded_file($_FILES['urlGaleria']['tmp_name'], $rutaDestino)) {
                    $urlGaleria = 'public/img/' . $nombreArchivo;
                }
            }
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFin = $_POST['fechaFin'];
            $hoy = date('Y-m-d');

            if ($fechaInicio < $hoy) {
                $this->json(['tipo' => 'error', 'mensaje' => 'La fecha de inicio no puede ser anterior a hoy.']);
                return;
            }

            if (!empty($fechaFin) && $fechaFin < $fechaInicio) {
                $this->json(['tipo' => 'error', 'mensaje' => 'La fecha de fin no puede ser anterior a la de inicio.']);
                return;
            }
            
            

            $esPagado = isset($_POST['esPagado']) ? 1 : 0;
            $costo = $esPagado ? ($_POST['costo'] ?? 0) : 0;
            
            $capacidad = $_POST['capacidad'] ?? 0;
            if ($capacidad <= 0) {
    $this->json(['tipo' => 'error', 'mensaje' => 'La capacidad debe ser mayor que cero.']);
    return;
           }



            $idEvento = $this->eventoModelo->crearEvento(
                $_POST['titulo'],
                $_POST['descripcion'],
                $_POST['horas'],
                $_POST['fechaInicio'],
                $_POST['fechaFin'],
                $_POST['modalidad'],
                $_POST['notaAprobacion'],
                $costo,
                $_POST['publicoDestino'],
                $esPagado,
                $_POST['categoria'],
                $_POST['tipoEvento'],
                $_POST['carrera'],
                $_POST['estado'],
                $this->idUsuario,
                $urlPortada,
                $urlGaleria,
                $capacidad
            );

            $requisitosSeleccionados = $_POST['requisitos'] ?? [];

            if (!empty($requisitosSeleccionados)) {
                require_once '../models/Requisitos.php';
                $reqModel = new Requisitos();
                $reqModel->asociarAEvento($idEvento, $requisitosSeleccionados);
            }

            $this->json(['tipo' => 'success', 'mensaje' => 'Evento creado']);
        } catch (Exception $e) {
            $this->json([
                'tipo' => 'error',
                'mensaje' => 'Error al crear evento',
                'debug' => $e->getMessage()
            ]);
        }
    }



    private function actualizar()
    {
        $idEvento = $_POST['idEvento'] ?? null;
        if (!$idEvento) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID del evento requerido.']);
            return;
        }

        try {
            // Procesar archivo de portada
            $urlPortada = null;
            if (isset($_FILES['urlPortada']) && $_FILES['urlPortada']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = uniqid('portada_') . '_' . basename($_FILES['urlPortada']['name']);
                $rutaDestino = '../public/img/' . $nombreArchivo;
                if (move_uploaded_file($_FILES['urlPortada']['tmp_name'], $rutaDestino)) {
                    $urlPortada = 'public/img/' . $nombreArchivo;
                }
            }

            // Procesar archivo de galería
            $urlGaleria = null;
            if (isset($_FILES['urlGaleria']) && $_FILES['urlGaleria']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = uniqid('galeria_') . '_' . basename($_FILES['urlGaleria']['name']);
                $rutaDestino = '../public/img/' . $nombreArchivo;
                if (move_uploaded_file($_FILES['urlGaleria']['tmp_name'], $rutaDestino)) {
                    $urlGaleria = 'public/img/' . $nombreArchivo;
                }
            }

            $fechaInicio = $_POST['fechaInicio'];
            $fechaFin = $_POST['fechaFin'];
            $hoy = date('Y-m-d');

            if ($fechaInicio < $hoy) {
                $this->json(['tipo' => 'error', 'mensaje' => 'La fecha de inicio no puede ser anterior a hoy.']);
                return;
            }

            if (!empty($fechaFin) && $fechaFin < $fechaInicio) {
                $this->json(['tipo' => 'error', 'mensaje' => 'La fecha de fin no puede ser anterior a la de inicio.']);
                return;
            }

            $esPagado = isset($_POST['esPagado']) ? 1 : 0;
            $costo = $esPagado ? ($_POST['costo'] ?? 0) : 0;

            $capacidad = $_POST['capacidad'] ?? 0;
            if ($capacidad <= 0) {
                $this->json(['tipo' => 'error', 'mensaje' => 'La capacidad debe ser mayor que cero.']);
                return;
            }

            $resultado = $this->eventoModelo->actualizarEvento(
                $_POST['titulo'],
                $_POST['descripcion'],
                $_POST['horas'],
                $_POST['fechaInicio'],
                $_POST['fechaFin'],
                $_POST['modalidad'],
                $_POST['notaAprobacion'],
                $costo,
                $_POST['publicoDestino'],
                $esPagado,
                $_POST['categoria'],
                $_POST['tipoEvento'],
                $_POST['carrera'],
                $_POST['estado'],
                $idEvento,
                $this->idUsuario,
                $urlPortada,
                $urlGaleria,
                $capacidad
            );

            if ($resultado) {
                $requisitosSeleccionados = $_POST['requisitos'] ?? [];

                require_once '../models/Requisitos.php';
                $reqModel = new Requisitos();

                $reqModel->eliminarPorEvento($idEvento);

                if (!empty($requisitosSeleccionados)) {
                    $reqModel->asociarAEvento($idEvento, $requisitosSeleccionados);
                }

                $this->json(['tipo' => 'success', 'mensaje' => 'Evento actualizado']);
            } else {
                $this->json(['tipo' => 'error', 'mensaje' => 'No tienes permisos para actualizar este evento']);
            }
        } catch (Exception $e) {
            $this->json([
                'tipo' => 'error',
                'mensaje' => 'Error al actualizar evento',
                'debug' => $e->getMessage()
            ]);
        }
    }

    private function cancelar()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']);
            return;
        }

        $ok = $this->eventoModelo->cancelarEvento($id, $this->idUsuario);
        $this->json([
            'tipo' => $ok ? 'success' : 'error',
            'mensaje' => $ok ? 'Evento cancelado' : 'No tienes permisos para cancelar el evento'
        ]);
    }

    private function json($data)
    {
        echo json_encode($data);
    }

    private function listarTarjetas()
    {
        $eventos = $this->eventoModelo->getEventosConPortadaPorResponsable($this->idUsuario);
        $this->json($eventos);
    }


    private function listarEventosInscritoCurso()
    {
        if (!$this->idUsuario) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Usuario no autenticado']);
            return;
        }

        $eventos = $this->eventoModelo->getEventosEnCursoInscrito($this->idUsuario);

        if (empty($eventos)) {
            $this->json(['tipo' => 'info', 'mensaje' => 'No hay eventos en curso para el usuario.']);
            return;
        }

        $this->json($eventos);
    }



}

// Instancia y ejecución
$controller = new EventosController();
$controller->handleRequest();
