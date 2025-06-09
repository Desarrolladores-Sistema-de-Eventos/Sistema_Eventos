<?php
require_once '../core/Conexion.php';

class Requisitos {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    /**
     * Duplica requisitos plantilla a un evento específico
     */
    public function asociarAEvento($idEvento, array $idsRequisitos) {
        $stmt = $this->pdo->prepare("
            INSERT INTO REQUISITO_EVENTO (SECUENCIALEVENTO, DESCRIPCION, ES_OBLIGATORIO)
            SELECT ?, DESCRIPCION, ES_OBLIGATORIO FROM REQUISITO_EVENTO WHERE SECUENCIAL = ?
        ");

        foreach ($idsRequisitos as $id) {
            $stmt->execute([$idEvento, $id]);
        }
    }
    public function eliminarPorEvento($idEvento) {
    $stmt = $this->pdo->prepare("DELETE FROM REQUISITO_EVENTO WHERE SECUENCIALEVENTO = ?");
    $stmt->execute([$idEvento]);
}

}
