<?php
require_once 'core/Conexion.php';

class Evento {
    public static function esResponsableDelEvento($cedula, $idEvento) {
        $db = Conexion::getConexion();
        $stmt = $db->prepare("
            SELECT 1 FROM responsables_evento
            WHERE ID_USUARIO_PER = ? AND ID_EVENTO_PER = ?
        ");
        $stmt->execute([$cedula, $idEvento]);
        return $stmt->fetchColumn() !== false;
    }

    public static function actualizar($id, $data) {
        $db = Conexion::getConexion();
        $stmt = $db->prepare("
            UPDATE eventos SET TITULO = ?, DESCRIPCION = ?
            WHERE ID_EVENTO = ?
        ");
        return $stmt->execute([
            $data['TITULO'],
            $data['DESCRIPCION'],
            $id
        ]);
    }
}
