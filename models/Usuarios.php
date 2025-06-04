<?php
require_once '../core/Conexion.php';

class Usuario {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }
    public static function login($correo, $contrasena) {
    $db = Conexion::getConexion();

    $stmt = $db->prepare("
        SELECT u.*, r.NOMBRE AS ROL
        FROM USUARIO u
        JOIN ROL_USUARIO r ON u.CODIGOROL = r.CODIGO
        WHERE u.CORREO = ?
    ");

    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasena, $usuario['CONTRASENA'])) {
    unset($usuario['CONTRASENA']);
    return $usuario;
    }

    return null;
   }

    public function correoExiste($correo) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM usuario WHERE CORREO = ?");
        $stmt->execute([$correo]);
        return $stmt->fetchColumn() > 0;
    }

    public function insertar($nombres, $apellidos, $telefono, $direccion, $correo, $contrasena, $codigorol, $es_interno = 1) {
        if ($this->correoExiste($correo)) {
            return ['success' => false, 'mensaje' => 'El correo ya está registrado.'];
        }
        
        if ($codigorol === 'EST' || $codigorol === 'DOC') {
            if (!preg_match('/@uta\.edu\.ec$/', $correo)) {
                return ['success' => false, 'mensaje' => 'El correo debe ser institucional (@uta.edu.ec) para estudiantes y docentes.'];
            }
        } elseif ($codigorol === 'INV') {
            if (!preg_match('/@gmail\.com$/', $correo)) {
                return ['success' => false, 'mensaje' => 'El correo debe ser @gmail.com para invitados.'];
            }
        }
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO usuario (NOMBRES, APELLIDOS, TELEFONO, DIRECCION, CORREO, CONTRASENA, CODIGOROL, CODIGOESTADO, ES_INTERNO) VALUES (?, ?, ?, ?, ?, ?, ?, 'ACTIVO', ?)");
        $ok = $stmt->execute([$nombres, $apellidos, $telefono, $direccion, $correo, $hash, $codigorol, $es_interno]);
        return $ok ? ['success' => true] : ['success' => false, 'mensaje' => 'Error al registrar usuario.'];
    }

    public function editar($id, $nombres, $apellidos, $telefono, $direccion, $correo, $codigorol, $estado, $es_interno, $contrasena = '') {
        // No permitir cambiar a un correo ya existente (excepto el propio)
        $stmt = $this->pdo->prepare("SELECT SECUENCIAL FROM usuario WHERE CORREO = ? AND SECUENCIAL != ?");
        $stmt->execute([$correo, $id]);
        if ($stmt->fetch()) {
            return ['success' => false, 'mensaje' => 'El correo ya está registrado por otro usuario.'];
        }
        // Validación de dominio de correo
        if ($codigorol === 'EST' || $codigorol === 'DOC') {
            if (!preg_match('/@uta\.edu\.ec$/', $correo)) {
                return ['success' => false, 'mensaje' => 'El correo debe ser institucional (@uta.edu.ec) para estudiantes y docentes.'];
            }
        } elseif ($codigorol === 'INV') {
            if (!preg_match('/@gmail\.com$/', $correo)) {
                return ['success' => false, 'mensaje' => 'El correo debe ser @gmail.com para invitados.'];
            }
        }

        // Si se proporciona una nueva contraseña, actualizarla encriptada
        if (!empty($contrasena)) {
            $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE usuario SET NOMBRES=?, APELLIDOS=?, TELEFONO=?, DIRECCION=?, CORREO=?, CODIGOROL=?, CODIGOESTADO=?, ES_INTERNO=?, CONTRASENA=? WHERE SECUENCIAL=?";
            $params = [$nombres, $apellidos, $telefono, $direccion, $correo, $codigorol, $estado, $es_interno, $contrasenaHash, $id];
        } else {
            $sql = "UPDATE usuario SET NOMBRES=?, APELLIDOS=?, TELEFONO=?, DIRECCION=?, CORREO=?, CODIGOROL=?, CODIGOESTADO=?, ES_INTERNO=? WHERE SECUENCIAL=?";
            $params = [$nombres, $apellidos, $telefono, $direccion, $correo, $codigorol, $estado, $es_interno, $id];
        }

        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute($params);
        return $ok ? ['success' => true] : ['success' => false, 'mensaje' => 'Error al actualizar usuario.'];
    }

   public function eliminar($id) {
    try {
        // 1. Eliminar asistencia_nota relacionadas al usuario
        $stmtAsist = $this->pdo->prepare("DELETE FROM asistencia_nota WHERE SECUENCIALUSUARIO=?");
        $stmtAsist->execute([$id]);

        // 2. Eliminar certificados asociados al usuario
        $stmtCert = $this->pdo->prepare("DELETE FROM certificado WHERE SECUENCIALUSUARIO=?");
        $stmtCert->execute([$id]);

        // 3. Eliminar inscripciones del usuario
        // Antes, eliminar archivo_requisito y pago relacionados a inscripciones de este usuario
        $stmt = $this->pdo->prepare("SELECT SECUENCIAL FROM inscripcion WHERE SECUENCIALUSUARIO=?");
        $stmt->execute([$id]);
        $inscripciones = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($inscripciones) {
            // Eliminar archivos de requisito de todas las inscripciones de este usuario
            $in = implode(',', array_fill(0, count($inscripciones), '?'));
            $delArchivos = $this->pdo->prepare("DELETE FROM archivo_requisito WHERE SECUENCIALINSCRIPCION IN ($in)");
            $delArchivos->execute($inscripciones);

            // Eliminar pagos relacionados a inscripciones de este usuario
            $delPagos = $this->pdo->prepare("DELETE FROM pago WHERE SECUENCIALINSCRIPCION IN ($in)");
            $delPagos->execute($inscripciones);
        }

        // Eliminar inscripciones
        $delInscripciones = $this->pdo->prepare("DELETE FROM inscripcion WHERE SECUENCIALUSUARIO=?");
        $delInscripciones->execute([$id]);

        // 4. Eliminar pagos donde el usuario es aprobador
        $delPagosAprobador = $this->pdo->prepare("DELETE FROM pago WHERE SECUENCIAL_USUARIO_APROBADOR=?");
        $delPagosAprobador->execute([$id]);

        // 5. Eliminar organizador_evento donde el usuario es organizador
        // Antes, eliminar imagen_organizador_evento asociadas a estos organizadores
        $stmtOrg = $this->pdo->prepare("SELECT SECUENCIAL FROM organizador_evento WHERE SECUENCIALUSUARIO=?");
        $stmtOrg->execute([$id]);
        $organizadores = $stmtOrg->fetchAll(PDO::FETCH_COLUMN);

        if ($organizadores) {
            $in = implode(',', array_fill(0, count($organizadores), '?'));
            $delImgOrg = $this->pdo->prepare("DELETE FROM imagen_organizador_evento WHERE SECUENCIAL_ORGANIZADOR_EVENTO IN ($in)");
            $delImgOrg->execute($organizadores);
        }

        $delOrg = $this->pdo->prepare("DELETE FROM organizador_evento WHERE SECUENCIALUSUARIO=?");
        $delOrg->execute([$id]);

        // 6. Eliminar usuario_carrera
        $delUC = $this->pdo->prepare("DELETE FROM usuario_carrera WHERE SECUENCIALUSUARIO=?");
        $delUC->execute([$id]);

        // 7. Finalmente elimina el usuario
        $stmt = $this->pdo->prepare("DELETE FROM usuario WHERE SECUENCIAL=?");
        $ok = $stmt->execute([$id]);
        return $ok ? ['success' => true] : ['success' => false, 'mensaje' => 'Error al eliminar usuario.'];
    } catch (PDOException $e) {
        return ['success' => false, 'mensaje' => 'No se pudo eliminar el usuario: ' . $e->getMessage()];
    }
}

    public function ponerEstadoInactivo($id) {
        $stmt = $this->pdo->prepare("UPDATE usuario SET CODIGOESTADO='INACTIVO' WHERE SECUENCIAL=?");
        $ok = $stmt->execute([$id]);
        return $ok ? ['success' => true] : ['success' => false, 'mensaje' => 'No se pudo inactivar el usuario.'];
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuario WHERE SECUENCIAL=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM usuario");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>