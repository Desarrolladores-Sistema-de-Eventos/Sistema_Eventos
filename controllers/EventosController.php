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
            $ruta = "../documents/requisitos/$nombreArchivo";
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
        $ruta = "../documents/comprobantes/$nombreComprobante";
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
        $logPath = __DIR__ . '/../correo.log';
        file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] Actualización exitosa, preparando correo\n", FILE_APPEND);
        // Enviar correo al responsable notificando subida de requisitos y comprobante
        require_once '../models/Usuarios.php';
        require_once '../core/correo_responsable.php';
        $usuarioModelo = new Usuario();
        $datosInscrito = $usuarioModelo->getById2($this->idUsuario);
        file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] Datos inscrito: " . json_encode($datosInscrito) . "\n", FILE_APPEND);
        $evento = $this->eventoModelo->getEvento($idEvento);
        file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] Datos evento: " . json_encode($evento) . "\n", FILE_APPEND);
        $responsable = null;
        if (isset($evento['ORGANIZADORES']) && is_array($evento['ORGANIZADORES'])) {
            file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] ORGANIZADORES es array, count: " . count($evento['ORGANIZADORES']) . "\n", FILE_APPEND);
            foreach ($evento['ORGANIZADORES'] as $org) {
                file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] Recorriendo ORGANIZADOR: " . json_encode($org) . "\n", FILE_APPEND);
                if (isset($org['ROL_ORGANIZADOR']) && $org['ROL_ORGANIZADOR'] === 'RESPONSABLE') {
                    $responsable = $org;
                    file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] Encontrado RESPONSABLE\n", FILE_APPEND);
                    break;
                }
            }
        } else {
            file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] ORGANIZADORES no es array o no existe\n", FILE_APPEND);
        }
        if ($responsable) {
            $responsableData = $usuarioModelo->getById2($responsable['SECUENCIALUSUARIO'] ?? null);
            file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] Datos responsable: " . json_encode($responsableData) . "\n", FILE_APPEND);
            $correoResponsable = $responsableData['CORREO'] ?? null;
            $nombreResponsable = $responsableData['NOMBRES'] . ' ' . $responsableData['APELLIDOS'];
            $nombreInscrito = $datosInscrito['NOMBRES'] . ' ' . $datosInscrito['APELLIDOS'];
            $datosHtml = '<ul>';
            foreach ([
                'Cédula' => $datosInscrito['CEDULA'] ?? '',
                'Correo' => $datosInscrito['CORREO'] ?? '',
                'Teléfono' => $datosInscrito['TELEFONO'] ?? '',
                'Dirección' => $datosInscrito['DIRECCION'] ?? ''
            ] as $k => $v) {
                $datosHtml .= '<li><b>' . htmlspecialchars($k) . ':</b> ' . htmlspecialchars($v) . '</li>';
            }
            $datosHtml .= '</ul>';
            if ($correoResponsable) {
                file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] Enviando correo a $correoResponsable\n", FILE_APPEND);
                enviarCorreoRequisitosSubidos(
                    $correoResponsable,
                    $nombreResponsable,
                    $nombreInscrito,
                    $datosHtml,
                    $evento['TITULO'] ?? ''
                );
            } else {
                file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] No hay correoResponsable\n", FILE_APPEND);
            }
        } else {
            file_put_contents($logPath, date('Y-m-d H:i:s') . " - [actualizarInscripcion] NO se encontró responsable\n", FILE_APPEND);
        }
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
            $ruta = "../documents/requisitos/$nombre";
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
        $ruta = "../documents/comprobantes/$nombre";
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
        $logPath = __DIR__ . '/../log_carreras.txt';
        file_put_contents($logPath, date('Y-m-d H:i:s') . " [editar] ID recibido: " . var_export($id, true) . "\n", FILE_APPEND);
        if (!$id) {
            file_put_contents($logPath, date('Y-m-d H:i:s') . " [editar] ID faltante\n", FILE_APPEND);
            $this->json(['tipo' => 'error', 'mensaje' => 'ID faltante']);
            return;
        }
        $evento = $this->eventoModelo->getEvento($id);
        file_put_contents($logPath, date('Y-m-d H:i:s') . " [editar] getEvento devuelve: " . var_export($evento, true) . "\n", FILE_APPEND);
        if (!$evento) {
            file_put_contents($logPath, date('Y-m-d H:i:s') . " [editar] No se pudo cargar el evento para ID $id\n", FILE_APPEND);
            $this->json(['tipo' => 'error', 'mensaje' => 'No se pudo cargar el evento.']);
            return;
        }
        $this->json($evento);
    }

    private function guardar()
    {
        // Validación condicional de notaAprobacion solo para cursos
        $required = ['titulo', 'descripcion', 'horas', 'fechaInicio', 'fechaFin', 'modalidad', 'categoria', 'tipoEvento', 'carrera', 'estado', 'capacidad'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        // Si es curso, notaAprobacion es obligatoria
        $tipoEventoTexto = strtolower(trim($_POST['tipoEvento'] ?? ''));
        if (strpos($tipoEventoTexto, 'curso') !== false) {
            if (!isset($_POST['notaAprobacion']) || $_POST['notaAprobacion'] === '' || $_POST['notaAprobacion'] === null) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo 'notaAprobacion' es obligatorio para cursos."]);
                return;
            }
        }
        // Siempre definir el índice para evitar warnings
        if (!isset($_POST['notaAprobacion'])) {
            $_POST['notaAprobacion'] = null;
        }


        try {
            // Leer el valor del checkbox destacado
            $esDestacado = isset($_POST['esDestacado']) ? 1 : 0;
            // Procesar archivo de portada
            $urlPortada = null;
            if (isset($_FILES['urlPortada']) && $_FILES['urlPortada']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = uniqid('portada_') . '_' . basename($_FILES['urlPortada']['name']);
                $rutaDestino = '../public/img/eventos/portadas/' . $nombreArchivo;
                if (move_uploaded_file($_FILES['urlPortada']['tmp_name'], $rutaDestino)) {
                    $urlPortada = $nombreArchivo;
                }
            }

            // Procesar archivo de galería
            $urlGaleria = null;
            if (isset($_FILES['urlGaleria']) && $_FILES['urlGaleria']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = uniqid('galeria_') . '_' . basename($_FILES['urlGaleria']['name']);
                $rutaDestino = '../public/img/eventos/galerias/' . $nombreArchivo;
                if (move_uploaded_file($_FILES['urlGaleria']['tmp_name'], $rutaDestino)) {
                    $urlGaleria = $nombreArchivo;
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
                $esPagado,
                $_POST['categoria'],
                $_POST['tipoEvento'],
                is_array($_POST['carrera']) ? $_POST['carrera'] : (array)$_POST['carrera'],
                $_POST['estado'],
                $this->idUsuario,
                $urlPortada,
                $urlGaleria,
                $capacidad,
                $_POST['contenido'] ?? '',
                $_POST['asistenciaMinima'] ?? null,
                $esDestacado
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
            // Leer el valor del checkbox destacado
            $esDestacado = isset($_POST['esDestacado']) ? 1 : 0;
            // Procesar archivo de portada
            $urlPortada = null;
            if (isset($_FILES['urlPortada']) && $_FILES['urlPortada']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = uniqid('portada_') . '_' . basename($_FILES['urlPortada']['name']);
                $rutaDestino = '../public/img/eventos/portadas/' . $nombreArchivo;
                if (move_uploaded_file($_FILES['urlPortada']['tmp_name'], $rutaDestino)) {
                    $urlPortada = $nombreArchivo;
                }
            }

            // Procesar archivo de galería
            $urlGaleria = null;
            if (isset($_FILES['urlGaleria']) && $_FILES['urlGaleria']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = uniqid('galeria_') . '_' . basename($_FILES['urlGaleria']['name']);
                $rutaDestino = '../public/img/eventos/galerias/' . $nombreArchivo;
                if (move_uploaded_file($_FILES['urlGaleria']['tmp_name'], $rutaDestino)) {
                    $urlGaleria = $nombreArchivo;
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

            // Validación condicional de notaAprobacion solo para cursos
            $tipoEventoTexto = strtolower(trim($_POST['tipoEvento'] ?? ''));
            if (strpos($tipoEventoTexto, 'curso') !== false) {
                if (!isset($_POST['notaAprobacion']) || $_POST['notaAprobacion'] === '' || $_POST['notaAprobacion'] === null) {
                    $this->json(['tipo' => 'error', 'mensaje' => "El campo 'notaAprobacion' es obligatorio para cursos."]);
                    return;
                }
            }
            // Siempre definir el índice para evitar warnings
            if (!isset($_POST['notaAprobacion'])) {
                $_POST['notaAprobacion'] = null;
            }
            $requisitosSeleccionados = $_POST['requisitos'] ?? [];
            $resultado = $this->eventoModelo->actualizarEvento(
                $_POST['titulo'],
                $_POST['descripcion'],
                $_POST['horas'],
                $_POST['fechaInicio'],
                $_POST['fechaFin'],
                $_POST['modalidad'],
                $_POST['notaAprobacion'],
                $costo,
                $esPagado,
                $_POST['categoria'],
                $_POST['tipoEvento'],
                is_array($_POST['carrera']) ? $_POST['carrera'] : (array)$_POST['carrera'],
                $_POST['estado'],
                $idEvento,
                $this->idUsuario,
                $urlPortada,
                $urlGaleria,
                $capacidad,
                $_POST['contenido'] ?? '',
                $_POST['asistenciaMinima'] ?? null,
                $esDestacado,
                $requisitosSeleccionados
            );

            if ($resultado) {
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
        // Forzar UTF-8 y detectar errores de codificación
        header('Content-Type: application/json; charset=utf-8');
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            $error = json_last_error_msg();
            http_response_code(500);
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error al codificar JSON',
                'debug' => $error,
                'data' => $data
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo $json;
        }
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
    $motivacion = $_POST['motivacion'] ?? null;


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

    // Prueba de log fuera de cualquier condición
    file_put_contents(__DIR__ . '/../correo.log', date('Y-m-d H:i:s') . " - PRUEBA DE ESCRITURA LOG (inicio metodo)\n", FILE_APPEND);
    // Log antes de llamar a registrarInscripcionBasica
    file_put_contents(__DIR__ . '/../correo.log', date('Y-m-d H:i:s') . " - Antes de registrarInscripcionBasica\n", FILE_APPEND);
    try {
        // Este método ahora también guarda automáticamente los archivos ya existentes (cédula, matrícula)
        $ok = $this->eventoModelo->registrarInscripcionBasica($this->idUsuario, $idEvento, $motivacion);
        // Log después de llamar a registrarInscripcionBasica
        file_put_contents(__DIR__ . '/../correo.log', date('Y-m-d H:i:s') . " - Después de registrarInscripcionBasica, valor de ok: " . var_export($ok, true) . "\n", FILE_APPEND);
        if ($ok) {
            $logPath = __DIR__ . '/../correo.log';
            file_put_contents($logPath, date('Y-m-d H:i:s') . " - Entrando a bloque ok==true\n", FILE_APPEND);
            // Enviar correo al RESPONSABLE del evento
            require_once '../models/Usuarios.php';
            require_once '../core/correo_responsable.php';
            $usuarioModelo = new Usuario();
            file_put_contents($logPath, date('Y-m-d H:i:s') . " - Antes de getById2 usuario inscrito\n", FILE_APPEND);
            $datosInscrito = $usuarioModelo->getById2($this->idUsuario);
            file_put_contents($logPath, date('Y-m-d H:i:s') . " - Antes de getEvento\n", FILE_APPEND);
            $evento = $this->eventoModelo->getEvento($idEvento);
            file_put_contents($logPath, date('Y-m-d H:i:s') . " - Después de getEvento\n", FILE_APPEND);
            // Buscar responsable del evento (no organizador)
            $responsable = null;
            if (isset($evento['ORGANIZADORES'])) {
                file_put_contents($logPath, date('Y-m-d H:i:s') . " - ORGANIZADORES existe\n", FILE_APPEND);
            } else {
                file_put_contents($logPath, date('Y-m-d H:i:s') . " - ORGANIZADORES NO existe\n", FILE_APPEND);
            }
            if (isset($evento['ORGANIZADORES']) && is_array($evento['ORGANIZADORES'])) {
                file_put_contents($logPath, date('Y-m-d H:i:s') . " - ORGANIZADORES es array, count: " . count($evento['ORGANIZADORES']) . "\n", FILE_APPEND);
                foreach ($evento['ORGANIZADORES'] as $org) {
                    file_put_contents($logPath, date('Y-m-d H:i:s') . " - Recorriendo ORGANIZADOR: " . json_encode($org) . "\n", FILE_APPEND);
                    if (isset($org['ROL_ORGANIZADOR']) && $org['ROL_ORGANIZADOR'] === 'RESPONSABLE') {
                        $responsable = $org;
                        file_put_contents($logPath, date('Y-m-d H:i:s') . " - Encontrado RESPONSABLE\n", FILE_APPEND);
                        break;
                    }
                }
            } else {
                file_put_contents($logPath, date('Y-m-d H:i:s') . " - ORGANIZADORES no es array o está vacío\n", FILE_APPEND);
            }
            if ($responsable) {
                file_put_contents($logPath, date('Y-m-d H:i:s') . " - Entró al if (responsable)\n", FILE_APPEND);
                $responsableData = $usuarioModelo->getById2($responsable['SECUENCIALUSUARIO'] ?? null);
                file_put_contents($logPath, date('Y-m-d H:i:s') . " - Después de getById2 responsable\n", FILE_APPEND);
                $correoResponsable = $responsableData['CORREO'] ?? null;
                $nombreResponsable = $responsableData['NOMBRES'] . ' ' . $responsableData['APELLIDOS'];
                $nombreInscrito = $datosInscrito['NOMBRES'] . ' ' . $datosInscrito['APELLIDOS'];
                $datosHtml = '<ul>';
                foreach ([
                    'Cédula' => $datosInscrito['CEDULA'] ?? '',
                    'Correo' => $datosInscrito['CORREO'] ?? '',
                    'Teléfono' => $datosInscrito['TELEFONO'] ?? '',
                    'Dirección' => $datosInscrito['DIRECCION'] ?? ''
                ] as $k => $v) {
                    $datosHtml .= '<li><b>' . htmlspecialchars($k) . ':</b> ' . htmlspecialchars($v) . '</li>';
                }
                $datosHtml .= '</ul>';
                $logMsg = date('Y-m-d H:i:s') . " - Datos responsable: correo=$correoResponsable, nombre=$nombreResponsable\n";
                file_put_contents($logPath, $logMsg, FILE_APPEND);
                if ($correoResponsable) {
                    $logMsg = date('Y-m-d H:i:s') . " - Intentando enviar correo a responsable: $correoResponsable, Nombre: $nombreResponsable\n";
                    file_put_contents($logPath, $logMsg, FILE_APPEND);
                    $resultadoCorreo = enviarCorreoResponsable(
                        $correoResponsable,
                        $nombreResponsable,
                        $nombreInscrito,
                        $datosHtml,
                        $evento['TITULO'] ?? ''
                    );
                    $logMsg = date('Y-m-d H:i:s') . " - Resultado de enviarCorreoResponsable: " . ($resultadoCorreo ? "ÉXITO" : "FALLÓ") . "\n";
                    file_put_contents($logPath, $logMsg, FILE_APPEND);
                } else {
                    file_put_contents($logPath, date('Y-m-d H:i:s') . " - No hay correoResponsable\n", FILE_APPEND);
                }
            } else {
                file_put_contents($logPath, date('Y-m-d H:i:s') . " - NO se encontró responsable\n", FILE_APPEND);
            }
            $this->json([
                'tipo' => 'success',
                'mensaje' => 'Se ha inscrito de manera correcta al evento'
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



}

// Instancia y ejecución
$controller = new EventosController();
$controller->handleRequest();
