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
            case 'registrarInscripcionIncompleta':
                $this->registrarInscripcionIncompleta(); 
                break; 
            case 'requisitosUsuarioEvento': 
                $this->requisitosUsuarioEvento(); 
                break; 
            case 'actualizarInscripcion':
    $this->actualizarInscripcion();
    break;
    case 'comprobantePago':
  $this->obtenerComprobantePago();
  break;
            case 'eliminarResponsable':
                $this->eliminarResponsable();
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
private function obtenerComprobantePago()
{
    $idInscripcion = $_GET['idInscripcion'] ?? null;
    if (!$idInscripcion) {
        $this->json(['tipo' => 'error', 'mensaje' => 'ID de inscripción no proporcionado.']);
        return;
    }

    $comprobante = $this->eventoModelo->getComprobantePago($idInscripcion); // Asegúrate de tener esto en el modelo
    if ($comprobante) {
        $this->json(['comprobante' => $comprobante['COMPROBANTE_URL']]);
    } else {
        $this->json(['comprobante' => null]);
    }
}


private function actualizarInscripcion()
{
    $idInscripcion = $_POST['id_inscripcion'] ?? null;
    $idEvento = $_POST['id_evento'] ?? null;
    $formaPago = $_POST['forma_pago'] ?? null;
    $monto = $_POST['monto'] ?? 0;
    $esPagado = $_POST['es_pagado'] ?? 0;

    // Validación mínima
    if (!$idInscripcion || !$idEvento) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Datos incompletos.']);
        return;
    }

    // Procesar archivos de requisitos
    $requisitos = json_decode($_POST['requisitos'] ?? '[]', true);
    $archivosSubidos = [];

    foreach ($requisitos as $idReq) {
        $campo = "requisito_$idReq";
        if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] === UPLOAD_ERR_OK) {
            $archivo = $_FILES[$campo];
            $nombreArchivo = uniqid("req_") . '_' . basename($archivo['name']);
            $ruta = "../documents/$nombreArchivo";
            if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
                $archivosSubidos[$idReq] = $nombreArchivo;
            }
        }
    }

    // Procesar comprobante de pago
    $nombreComprobante = null;
    if ($esPagado && isset($_FILES['comprobante_pago']) && $_FILES['comprobante_pago']['error'] === UPLOAD_ERR_OK) {
        $archivo = $_FILES['comprobante_pago'];
        $nombreComprobante = uniqid("comprobante_") . '_' . basename($archivo['name']);
        $ruta = "../documents/$nombreComprobante";
        move_uploaded_file($archivo['tmp_name'], $ruta);
    }

    // Llama al modelo para actualizar
    $ok = $this->eventoModelo->actualizarArchivosInscripcion(
        $idInscripcion,
        $archivosSubidos,
        $esPagado,
        $formaPago,
        $monto,
        $nombreComprobante
    );

    if ($ok) {
        $this->json(['tipo' => 'success', 'mensaje' => 'Le llegará una notificación cuando su inscripción haya sido aprobada']);
    } else {
        $this->json([
    'tipo' => 'error',
    'mensaje' => $this->eventoModelo->ultimoError ?: 'No se pudo actualizar la inscripción.'
]);
    }
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
        // Permitir editar cualquier evento que aparece en el listado
        $evento = $this->eventoModelo->getEvento($id);
        if (!$evento) {
            $this->json(['tipo' => 'error', 'mensaje' => 'No se encontró el evento.']);
            return;
        }
        $this->json($evento);
    }

    private function guardar()
    {
        // Verificar si es una actualización o creación
        $idEvento = $_POST['idEvento'] ?? null;
        $esActualizacion = !empty($idEvento);
        
        // Obtener si el tipo de evento requiere nota o asistencia
        $tipoEvento = $_POST['tipoEvento'] ?? null;
        $requiereNota = false;
        $requiereAsistencia = false;
        if ($tipoEvento) {
            // Buscar en la base de datos si el tipo de evento requiere nota o asistencia
            require_once '../models/EventoCategoria.php';
            require_once '../models/EventoPublico.php';
            $db = \Conexion::getConexion();
            $stmt = $db->prepare("SELECT REQUIERENOTA, REQUIEREASISTENCIA FROM tipo_evento WHERE CODIGO = ?");
            $stmt->execute([$tipoEvento]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $requiereNota = $row['REQUIERENOTA'] == 1;
                $requiereAsistencia = $row['REQUIEREASISTENCIA'] == 1;
            }
        }
        // Quitar notaAprobacion y asistenciaMinima del array $required
        $required = ['titulo', 'descripcion', 'horas', 'fechaInicio', 'fechaFin', 'modalidad', 'categoria', 'tipoEvento', 'carrera', 'estado', 'capacidad'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        if ($requiereNota && empty($_POST['notaAprobacion'])) {
            $this->json(['tipo' => 'error', 'mensaje' => "El campo 'notaAprobacion' es obligatorio para este tipo de evento."]);
            return;
        }
        if ($requiereAsistencia && empty($_POST['asistenciaMinima'])) {
            $this->json(['tipo' => 'error', 'mensaje' => "El campo 'asistenciaMinima' es obligatorio para este tipo de evento."]);
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

            if ($esActualizacion) {
                // Actualizar evento existente
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
                    // Actualizar requisitos
                    $requisitosSeleccionados = $_POST['requisitos'] ?? [];
                    require_once '../models/Requisitos.php';
                    $reqModel = new Requisitos();
                    $reqModel->eliminarPorEvento($idEvento);
                    if (!empty($requisitosSeleccionados)) {
                        $reqModel->asociarAEvento($idEvento, $requisitosSeleccionados);
                    }
                    $this->json(['tipo' => 'success', 'mensaje' => 'Evento actualizado correctamente']);
                } else {
                    $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar el evento']);
                }
            } else {
                // Crear nuevo evento
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

                $this->json(['tipo' => 'success', 'mensaje' => 'Evento creado correctamente']);
            }
        } catch (Exception $e) {
            $this->json([
                'tipo' => 'error',
                'mensaje' => $esActualizacion ? 'Error al actualizar evento' : 'Error al crear evento',
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
        $id = $_GET['id'] ?? $_POST['id'] ?? null;
        if (!$id) {
            $this->json(['success' => false, 'mensaje' => 'ID requerido.']);
            return;
        }

        $ok = $this->eventoModelo->cancelarEvento($id);
        $this->json([
            'success' => $ok,
            'mensaje' => $ok ? 'Evento cancelado' : 'No se pudo cancelar el evento'
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
    private function registrarInscripcionIncompleta()
{
    if (!$this->idUsuario) {
        $this->json(['tipo' => 'error', 'mensaje' => 'Usuario no autenticado']);
        return;
    }

    $idEvento = $_POST['id_evento'] ?? null;

    if (!$idEvento) {
        $this->json(['tipo' => 'error', 'mensaje' => 'ID del evento faltante']);
        return;
    }

    // Verificar si ya está inscrito
    $verifica = $this->eventoModelo->validarDisponibilidadInscripcion($idEvento, $this->idUsuario);
    if (!$verifica['disponible']) {
        $this->json(['tipo' => 'error', 'mensaje' => $verifica['mensaje']]);
        return;
    }

    try {
        // Este método ahora también guarda automáticamente los archivos ya existentes (cédula, matrícula)
        $ok = $this->eventoModelo->registrarInscripcionBasica($this->idUsuario, $idEvento);

        if ($ok) {
            $this->json([
                'tipo' => 'success',
                'mensaje' => 'Inscripción registrada exitosamente.'
            ]);
        } else {
            $this->json([
                'tipo' => 'error',
                'mensaje' => 'Error al registrar la inscripción.'
            ]);
        }
    } catch (Exception $e) {
        $this->json([
            'tipo' => 'error',
            'mensaje' => 'Error inesperado al registrar la inscripción.',
            'debug' => $e->getMessage()
        ]);
    }
}

private function requisitosUsuarioEvento()
{
    $idEvento = $_GET['idEvento'] ?? null;
    if (!$idEvento || !$this->idUsuario) {
        $this->json([]);
        return;
    }

    $requisitos = $this->eventoModelo->getRequisitosEventoDetallado($idEvento);
    if (!is_array($requisitos)) {
        $this->json([]);
        return;
    }

    require_once '../models/Usuarios.php';
    $usuarioModelo = new Usuario();
    $usuario = $usuarioModelo->getById2($this->idUsuario);

    $resultado = [];

    foreach ($requisitos as $req) {
    $cumple = false;
    $archivo = null;

    $nombre = strtolower($req['DESCRIPCION']);

    if (str_contains($nombre, 'cédula') && !empty($usuario['URL_CEDULA'])) {
        $cumple = true;
        $archivo = basename($usuario['URL_CEDULA']);
    } elseif (str_contains($nombre, 'matrícula') && !empty($usuario['URL_MATRICULA'])) {
        $cumple = true;
        $archivo = basename($usuario['URL_MATRICULA']);
    } else {
        $archivoData = $this->eventoModelo->getArchivoRequisito($this->idUsuario, $req['SECUENCIAL'], $idEvento);
        if ($archivoData) {
            $cumple = true;
            $archivo = $archivoData['URLARCHIVO'];
        }
    }

    $resultado[] = [
        'id' => $req['SECUENCIAL'],
        'descripcion' => $req['DESCRIPCION'],
        'cumplido' => $cumple,
        'archivo' => $archivo
    ];
}


    $this->json($resultado);
}

    // Nueva función para eliminar evento por responsable
    private function eliminarResponsable()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->json(['success' => false, 'mensaje' => 'ID requerido']);
            return;
        }
        $ok = $this->eventoModelo->eliminarEvento($id, $this->idUsuario);
        if ($ok) {
            $this->json(['success' => true, 'mensaje' => 'Evento eliminado correctamente']);
        } else {
            $this->json(['success' => false, 'mensaje' => 'No se pudo eliminar el evento']);
        }
    }


}

// Instancia y ejecución
$controller = new EventosController();
$controller->handleRequest();
