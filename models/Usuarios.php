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
    public function cedulaExiste($cedula, $excluirId = null) {
        $sql = "SELECT COUNT(*) FROM usuario WHERE CEDULA = ?";
        $params = [$cedula];
        if ($excluirId) {
            $sql .= " AND SECUENCIAL != ?";
            $params[] = $excluirId;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function insertar($nombres, $apellidos, $telefono, $direccion, $correo, $contrasena, $codigorol, $es_interno = 1, $foto_perfil = null, $cedula = '', $fecha_nacimiento = '', $url_cedula = null) {
    if ($this->correoExiste($correo)) {
        return ['success' => false, 'mensaje' => 'El correo ya está registrado.'];
    }
    if ($cedula && $this->cedulaExiste($cedula)) {
        return ['success' => false, 'mensaje' => 'La cédula ya está registrada.'];
    }
    if ($codigorol === 'EST' || $codigorol === 'DOC') {
        if (!preg_match('/@uta\\.edu\\.ec$/', $correo)) {
            return ['success' => false, 'mensaje' => 'El correo debe ser institucional (@uta.edu.ec) para estudiantes y docentes.'];
        }
    } elseif ($codigorol === 'INV') {
        if (!preg_match('/@gmail\\.com$/', $correo)) {
            return ['success' => false, 'mensaje' => 'El correo debe ser @gmail.com para invitados.'];
        }
    }
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $stmt = $this->pdo->prepare("INSERT INTO usuario (NOMBRES, APELLIDOS, TELEFONO, DIRECCION, CORREO, CONTRASENA, CODIGOROL, CODIGOESTADO, ES_INTERNO, FOTO_PERFIL, CEDULA, FECHA_NACIMIENTO, URL_CEDULA) VALUES (?, ?, ?, ?, ?, ?, ?, 'ACTIVO', ?, ?, ?, ?, ?)");
    $ok = $stmt->execute([$nombres, $apellidos, $telefono, $direccion, $correo, $hash, $codigorol, $es_interno, $foto_perfil, $cedula, $fecha_nacimiento, $url_cedula]);
    return $ok ? ['success' => true] : ['success' => false, 'mensaje' => 'Error al registrar usuario.'];
}
public function editar($id, $nombres, $apellidos, $telefono, $direccion, $correo, $codigorol, $estado, $es_interno, $contrasena = '', $foto_perfil = null, $cedula = '', $fecha_nacimiento = '', $url_cedula = null) {
    if ($cedula && $this->cedulaExiste($cedula, $id)) {
        return ['success' => false, 'mensaje' => 'La cédula ya está registrada.'];
    }
    // Obtener la foto actual si no se sube una nueva
    if ($foto_perfil === null) {
        $stmtFoto = $this->pdo->prepare("SELECT FOTO_PERFIL FROM usuario WHERE SECUENCIAL=?");
        $stmtFoto->execute([$id]);
        $foto_perfil = $stmtFoto->fetchColumn();
    }

    if (!empty($contrasena)) {
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET NOMBRES=?, APELLIDOS=?, TELEFONO=?, DIRECCION=?, CORREO=?, CODIGOROL=?, CODIGOESTADO=?, ES_INTERNO=?, CONTRASENA=?, FOTO_PERFIL=?, CEDULA=?, FECHA_NACIMIENTO=?, URL_CEDULA=? WHERE SECUENCIAL=?";
        $params = [$nombres, $apellidos, $telefono, $direccion, $correo, $codigorol, $estado, $es_interno, $contrasenaHash, $foto_perfil, $cedula, $fecha_nacimiento, $url_cedula, $id];
    } else {
        $sql = "UPDATE usuario SET NOMBRES=?, APELLIDOS=?, TELEFONO=?, DIRECCION=?, CORREO=?, CODIGOROL=?, CODIGOESTADO=?, ES_INTERNO=?, FOTO_PERFIL=?, CEDULA=?, FECHA_NACIMIENTO=?, URL_CEDULA=? WHERE SECUENCIAL=?";
        $params = [$nombres, $apellidos, $telefono, $direccion, $correo, $codigorol, $estado, $es_interno, $foto_perfil, $cedula, $fecha_nacimiento, $url_cedula, $id];
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
    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM usuario");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public function getById($id) {
    $stmt = $this->pdo->prepare("
        SELECT u.*, uc.SECUENCIALCARRERA
        FROM usuario u
        LEFT JOIN usuario_carrera uc ON u.SECUENCIAL = uc.SECUENCIALUSUARIO
        WHERE u.SECUENCIAL = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

 public function obtenerCarreras() {
    $stmt = $this->pdo->query("SELECT SECUENCIAL, NOMBRE_CARRERA FROM carrera");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



  public function actualizarDatosPerfil(
    $id,
    $nombres,
    $apellidos,
    $cedula,
    $fecha_nacimiento,
    $telefono,
    $direccion,
    $fotoNombre = null,
    $cedulaNombre = null,
    $carreraId = null
) {
    try {
    
        // Actualizar tabla usuario
        $update = $this->pdo->prepare("UPDATE usuario SET 
            NOMBRES = ?, APELLIDOS = ?, CEDULA = ?, FECHA_NACIMIENTO = ?, 
            TELEFONO = ?, DIRECCION = ?, FOTO_PERFIL = ?, URL_CEDULA = ?
            WHERE SECUENCIAL = ?
        ");

        $ok = $update->execute([
            $nombres,
            $apellidos,
            $cedula,
            $fecha_nacimiento,
            $telefono,
            $direccion,
            $fotoNombre,
            $cedulaNombre,
            $id
        ]);

        // Actualizar o insertar carrera
        if ($carreraId) {
            $check = $this->pdo->prepare("SELECT COUNT(*) FROM usuario_carrera WHERE SECUENCIALUSUARIO = ?");
            $check->execute([$id]);
            $exists = $check->fetchColumn();

            if ($exists) {
                $stmtCarrera = $this->pdo->prepare("UPDATE usuario_carrera SET SECUENCIALCARRERA = ? WHERE SECUENCIALUSUARIO = ?");
                $stmtCarrera->execute([$carreraId, $id]);
            } else {
                $stmtCarrera = $this->pdo->prepare("INSERT INTO usuario_carrera (SECUENCIALUSUARIO, SECUENCIALCARRERA) VALUES (?, ?)");
                $stmtCarrera->execute([$id, $carreraId]);
            }
        }

        return $ok
            ? ['success' => true, 'foto' => $fotoNombre, 'cedula' => $cedulaNombre]
            : ['success' => false, 'mensaje' => 'No se pudo actualizar los datos.'];

    } catch (PDOException $e) {
        return ['success' => false, 'mensaje' => 'Error: ' . $e->getMessage()];
    }
}
// ================= RECUPERACIÓN DE CONTRASEÑA =================
public static function buscarPorCorreo($correo) {
    $db = Conexion::getConexion();
    $stmt = $db->prepare("SELECT * FROM usuario WHERE CORREO = ? LIMIT 1");
    $stmt->execute([$correo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public static function guardarTokenRecuperacion($id, $token, $expiracion) {
    $db = Conexion::getConexion();
    $stmt = $db->prepare("UPDATE usuario SET token_recupera=?, token_expiracion=? WHERE SECUENCIAL=?");
    return $stmt->execute([$token, $expiracion, $id]);
}

public static function buscarPorTokenRecuperacion($token) {
    $db = Conexion::getConexion();
    $stmt = $db->prepare("SELECT * FROM usuario WHERE token_recupera=? AND token_expiracion > NOW() LIMIT 1");
    $stmt->execute([$token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public static function actualizarContrasenaYLimpiarToken($id, $nuevaContrasena) {
    $db = Conexion::getConexion();
    $hash = password_hash($nuevaContrasena, PASSWORD_DEFAULT); // Aquí se encripta
    $stmt = $db->prepare("UPDATE usuario SET CONTRASENA=?, token_recupera=NULL, token_expiracion=NULL WHERE SECUENCIAL=?");
    return $stmt->execute([$hash, $id]);
}

}
?>