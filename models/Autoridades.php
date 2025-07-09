<?php
require_once '../core/Conexion.php';

class Autoridades {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

public function getAutoridades() {
    $sql = "SELECT 
                u.CODIGOROL AS identificador, 
                u.NOMBRES AS nombre, 
                u.APELLIDOS AS apellido, 
                u.CORREO AS correo,
                'Autoridad' AS tipo, 
                u.FOTO_PERFIL as foto_perfil
            FROM usuario u
            JOIN rol_usuario r ON u.CODIGOROL = r.CODIGO
            WHERE r.NOMBRE = 'AUTORIDAD'";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
