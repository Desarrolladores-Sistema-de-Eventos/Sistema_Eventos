<?php
session_start();
require_once '../models/Configuraciones.php';

header('Content-Type: application/json');

class ConfiguracionesController
{
    private $configuracionesModelo;
    private $idUsuario;

    public function __construct()
    {
        $this->configuracionesModelo = new Configuraciones();
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
            // FACULTAD
            case 'facultad_listar': $this->listarFacultades(); break;
            case 'facultad_guardar': $this->guardarFacultad(); break;
            case 'facultad_actualizar': $this->actualizarFacultad(); break;
            case 'facultad_eliminar': $this->eliminarFacultad(); break;
            // CARRERA
            case 'carrera_listar': $this->listarCarreras(); break;
            case 'carrera_guardar': $this->guardarCarrera(); break;
            case 'carrera_actualizar': $this->actualizarCarrera(); break;
            case 'carrera_eliminar': $this->eliminarCarrera(); break;
            // TIPO EVENTO
            case 'tipo_evento_listar': $this->listarTiposEvento(); break;
            case 'tipo_evento_guardar': $this->guardarTipoEvento(); break;
            case 'tipo_evento_actualizar': $this->actualizarTipoEvento(); break;
            case 'tipo_evento_eliminar': $this->eliminarTipoEvento(); break;
            // CATEGORIA EVENTO
            case 'categoria_evento_listar': $this->listarCategoriasEvento(); break;
            case 'categoria_evento_guardar': $this->guardarCategoriaEvento(); break;
            case 'categoria_evento_actualizar': $this->actualizarCategoriaEvento(); break;
            case 'categoria_evento_eliminar': $this->eliminarCategoriaEvento(); break;
            // MODALIDAD EVENTO
            case 'modalidad_evento_listar': $this->listarModalidadesEvento(); break;
            case 'modalidad_evento_guardar': $this->guardarModalidadEvento(); break;
            case 'modalidad_evento_actualizar': $this->actualizarModalidadEvento(); break;
            case 'modalidad_evento_eliminar': $this->eliminarModalidadEvento(); break;
            // REQUISITO EVENTO
            case 'requisito_evento_listar': $this->listarRequisitosEvento(); break;
            case 'requisito_evento_guardar': $this->guardarRequisitoEvento(); break;
            case 'requisito_evento_actualizar': $this->actualizarRequisitoEvento(); break;
            case 'requisito_evento_eliminar': $this->eliminarRequisitoEvento(); break;
            // FORMA DE PAGO
            case 'forma_pago_listar': $this->listarFormasPago(); break;
            case 'forma_pago_guardar': $this->guardarFormaPago(); break;
            case 'forma_pago_actualizar': $this->actualizarFormaPago(); break;
            case 'forma_pago_eliminar': $this->eliminarFormaPago(); break;
            // ROL USUARIO
            case 'rol_usuario_listar': $this->listarRolesUsuario(); break;
            case 'rol_usuario_guardar': $this->guardarRolUsuario(); break;
            case 'rol_usuario_actualizar': $this->actualizarRolUsuario(); break;
            case 'rol_usuario_eliminar': $this->eliminarRolUsuario(); break;
            default:
                $this->json(['tipo' => 'error', 'mensaje' => 'Acción no válida']);
        }
    }

    // ================= FACULTAD =================
    private function listarFacultades() {
        $data = $this->configuracionesModelo->obtenerFacultades();
        $this->json($data);
    }
    private function guardarFacultad() {
        $required = ['nombre', 'mision', 'vision', 'ubicacion'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $id = $this->configuracionesModelo->crearFacultad(
                $_POST['nombre'], $_POST['mision'], $_POST['vision'], $_POST['ubicacion']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Facultad creada', 'id' => $id]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear facultad', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarFacultad() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarFacultad(
                $id, $_POST['nombre'], $_POST['mision'], $_POST['vision'], $_POST['ubicacion']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Facultad actualizada' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar facultad', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarFacultad() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarFacultad($id);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Facultad eliminada' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar facultad', 'debug' => $e->getMessage()]);
        }
    }

    // ================= CARRERA =================
    private function listarCarreras() {
        $data = $this->configuracionesModelo->obtenerCarreras();
        $this->json($data);
    }
    private function guardarCarrera() {
        $required = ['nombre', 'idFacultad'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $id = $this->configuracionesModelo->crearCarrera(
                $_POST['nombre'], $_POST['idFacultad']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Carrera creada', 'id' => $id]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear carrera', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarCarrera() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarCarrera(
                $id, $_POST['nombre'], $_POST['idFacultad']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Carrera actualizada' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar carrera', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarCarrera() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarCarrera($id);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Carrera eliminada' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar carrera', 'debug' => $e->getMessage()]);
        }
    }

    // ================= TIPO EVENTO =================
    private function listarTiposEvento() {
        $data = $this->configuracionesModelo->obtenerTiposEvento();
        $this->json($data);
    }
    private function guardarTipoEvento() {
        $required = ['codigo', 'nombre', 'descripcion'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $codigo = $this->configuracionesModelo->crearTipoEvento(
                $_POST['codigo'], $_POST['nombre'], $_POST['descripcion']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Tipo de evento creado', 'codigo' => $codigo]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear tipo de evento', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarTipoEvento() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarTipoEvento(
                $codigo, $_POST['nombre'], $_POST['descripcion']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Tipo de evento actualizado' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar tipo de evento', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarTipoEvento() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarTipoEvento($codigo);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Tipo de evento eliminado' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar tipo de evento', 'debug' => $e->getMessage()]);
        }
    }

    // ================= CATEGORIA EVENTO =================
    private function listarCategoriasEvento() {
        $data = $this->configuracionesModelo->obtenerCategoriasEvento();
        $this->json($data);
    }
    private function guardarCategoriaEvento() {
        $required = ['nombre', 'descripcion'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $id = $this->configuracionesModelo->crearCategoriaEvento(
                $_POST['nombre'], $_POST['descripcion']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Categoría creada', 'id' => $id]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear categoría', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarCategoriaEvento() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarCategoriaEvento(
                $id, $_POST['nombre'], $_POST['descripcion']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Categoría actualizada' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar categoría', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarCategoriaEvento() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarCategoriaEvento($id);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Categoría eliminada' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar categoría', 'debug' => $e->getMessage()]);
        }
    }

    // ================= MODALIDAD EVENTO =================
    private function listarModalidadesEvento() {
        $data = $this->configuracionesModelo->obtenerModalidadesEvento();
        $this->json($data);
    }
    private function guardarModalidadEvento() {
        $required = ['codigo', 'nombre'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $codigo = $this->configuracionesModelo->crearModalidadEvento(
                $_POST['codigo'], $_POST['nombre']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Modalidad creada', 'codigo' => $codigo]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear modalidad', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarModalidadEvento() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarModalidadEvento(
                $codigo, $_POST['nombre']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Modalidad actualizada' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar modalidad', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarModalidadEvento() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarModalidadEvento($codigo);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Modalidad eliminada' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar modalidad', 'debug' => $e->getMessage()]);
        }
    }

    // ================= REQUISITO EVENTO =================
    private function listarRequisitosEvento() {
        $data = $this->configuracionesModelo->obtenerRequisitosEvento();
        $this->json($data);
    }
    private function guardarRequisitoEvento() {
        $descripcion = $_POST['descripcion'] ?? null;
        if (!$descripcion) {
            $this->json(['tipo' => 'error', 'mensaje' => 'El campo "descripcion" es obligatorio.']);
            return;
        }
        // Solo permite guardar requisitos generales (idEvento debe ser null)
        $idEvento = $_POST['idEvento'] ?? null;
        if ($idEvento !== null && $idEvento !== '' && strtolower($idEvento) !== 'null') {
            $this->json(['tipo' => 'error', 'mensaje' => 'Solo se pueden crear requisitos generales (sin evento asociado).']);
            return;
        }
        $esObligatorio = $_POST['esObligatorio'] ?? null;
        try {
            $id = $this->configuracionesModelo->crearRequisitoEvento($descripcion, null, $esObligatorio);
            if ($id === false) {
                $this->json(['tipo' => 'error', 'mensaje' => 'No se pudo crear el requisito.']);
            } else {
                $this->json(['tipo' => 'success', 'mensaje' => 'Requisito creado', 'id' => $id]);
            }
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear requisito', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarRequisitoEvento() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        $descripcion = $_POST['descripcion'] ?? null;
        $idEvento = $_POST['idEvento'] ?? null;
        $esObligatorio = $_POST['esObligatorio'] ?? null;
        try {
            $ok = $this->configuracionesModelo->actualizarRequisitoEvento($id, $descripcion, $idEvento, $esObligatorio);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Requisito actualizado' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar requisito', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarRequisitoEvento() {
        $id = $_POST['id'] ?? null;
        if (!$id) { $this->json(['tipo' => 'error', 'mensaje' => 'ID requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarRequisitoEvento($id);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Requisito eliminado' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar requisito', 'debug' => $e->getMessage()]);
        }
    }

    // ================= FORMA DE PAGO =================
    private function listarFormasPago() {
        $data = $this->configuracionesModelo->obtenerFormasPago();
        $this->json($data);
    }
    private function guardarFormaPago() {
        $required = ['codigo', 'nombre'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $codigo = $this->configuracionesModelo->crearFormaPago(
                $_POST['codigo'], $_POST['nombre']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Forma de pago creada', 'codigo' => $codigo]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear forma de pago', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarFormaPago() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarFormaPago(
                $codigo, $_POST['nombre']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Forma de pago actualizada' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar forma de pago', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarFormaPago() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarFormaPago($codigo);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Forma de pago eliminada' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar forma de pago', 'debug' => $e->getMessage()]);
        }
    }

    // ================= ROL USUARIO =================
    private function listarRolesUsuario() {
        $data = $this->configuracionesModelo->obtenerRolesUsuario();
        $this->json($data);
    }
    private function guardarRolUsuario() {
        $required = ['codigo', 'nombre'];
        foreach ($required as $campo) {
            if (empty($_POST[$campo])) {
                $this->json(['tipo' => 'error', 'mensaje' => "El campo '$campo' es obligatorio."]);
                return;
            }
        }
        try {
            $codigo = $this->configuracionesModelo->crearRolUsuario(
                $_POST['codigo'], $_POST['nombre']
            );
            $this->json(['tipo' => 'success', 'mensaje' => 'Rol creado', 'codigo' => $codigo]);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al crear rol', 'debug' => $e->getMessage()]);
        }
    }
    private function actualizarRolUsuario() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->actualizarRolUsuario(
                $codigo, $_POST['nombre']
            );
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Rol actualizado' : 'No se pudo actualizar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al actualizar rol', 'debug' => $e->getMessage()]);
        }
    }
    private function eliminarRolUsuario() {
        $codigo = $_POST['codigo'] ?? null;
        if (!$codigo) { $this->json(['tipo' => 'error', 'mensaje' => 'Código requerido.']); return; }
        try {
            $ok = $this->configuracionesModelo->eliminarRolUsuario($codigo);
            $this->json(['tipo' => $ok ? 'success' : 'error', 'mensaje' => $ok ? 'Rol eliminado' : 'No se pudo eliminar']);
        } catch (Exception $e) {
            $this->json(['tipo' => 'error', 'mensaje' => 'Error al eliminar rol', 'debug' => $e->getMessage()]);
        }
    }

    private function json($data)
    {
        echo json_encode($data);
    }
}

$controller = new ConfiguracionesController();
$controller->handleRequest();
