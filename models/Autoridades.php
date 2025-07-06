<?php
require_once '../core/Conexion.php';

class Autoridades {
    private $pdo;
    private $FACULTAD_SECUENCIAL = 9;

    public function __construct() {
        $this->pdo = Conexion::getConexion();
    }

    public function getAutoridades() {
        $sql = "SELECT 
                    SECUENCIAL AS identificador, 
                    NOMBRE AS nombre, 
                    CARGO AS cargo, 
                    CORREO AS correo, 
                    TELEFONO AS telefono, 
                    FOTO_URL AS imagen
                FROM autoridades 
                WHERE FACULTAD_SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->FACULTAD_SECUENCIAL]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($data) {
        $sql = "INSERT INTO autoridades 
                (FACULTAD_SECUENCIAL, NOMBRE, CARGO, FOTO_URL, CORREO, TELEFONO) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $this->FACULTAD_SECUENCIAL,
            $data['NOMBRE'],
            $data['CARGO'],
            $data['FOTO_URL'],
            $data['CORREO'],
            $data['TELEFONO']
        ]);
    }

    public function actualizar($id, $data) {
        $campos = [
            'FACULTAD_SECUENCIAL' => $this->FACULTAD_SECUENCIAL,
            'NOMBRE' => $data['NOMBRE'],
            'CARGO' => $data['CARGO'],
            'CORREO' => $data['CORREO'],
            'TELEFONO' => $data['TELEFONO'],
        ];

        $sql = "UPDATE autoridades SET 
                    FACULTAD_SECUENCIAL = :FACULTAD_SECUENCIAL,
                    NOMBRE = :NOMBRE, 
                    CARGO = :CARGO, 
                    CORREO = :CORREO, 
                    TELEFONO = :TELEFONO";

        if (!empty($data['FOTO_URL'])) {
            $sql .= ", FOTO_URL = :FOTO_URL";
            $campos['FOTO_URL'] = $data['FOTO_URL'];
        }

        $sql .= " WHERE SECUENCIAL = :ID";
        $campos['ID'] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($campos);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM autoridades WHERE SECUENCIAL = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
