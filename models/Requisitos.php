<?php
require_once '../core/Conexion.php';

class Requisitos {
    /**
     * Desasociar (eliminar) un requisito específico de un evento
     */
    public function desasociarRequisitoDeEvento($idEvento, $idRequisito) {
        $stmt = $this->pdo->prepare("DELETE FROM REQUISITO_EVENTO WHERE SECUENCIALEVENTO = ? AND SECUENCIAL = ?");
        $stmt->execute([$idEvento, $idRequisito]);
    }
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

    /**
     * Obtener requisitos generales (no asociados a un evento específico)
     */
    public function getRequisitosGenerales() {
        $stmt = $this->pdo->prepare("SELECT SECUENCIAL, DESCRIPCION FROM REQUISITO_EVENTO WHERE SECUENCIALEVENTO IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Obtener los IDs de requisitos asociados a un evento específico
     */
    /**
     * Obtener los requisitos asociados a un evento específico (ID y DESCRIPCION)
     */
    public function getRequisitosPorEvento($idEvento) {
        $stmt = $this->pdo->prepare("SELECT SECUENCIAL, DESCRIPCION FROM REQUISITO_EVENTO WHERE SECUENCIALEVENTO = ?");
        $stmt->execute([$idEvento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve array de ['SECUENCIAL', 'DESCRIPCION']
    }
}

