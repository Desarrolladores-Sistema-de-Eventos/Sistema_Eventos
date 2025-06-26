<?php
require_once '../models/EventoPublico.php';

class EventosDestacadosController {
    private $eventoModelo;

    public function __construct() {
        $this->eventoModelo = new EventoPublico();
    }

    public function obtenerEventosDestacados() {
        try {
            $eventos = $this->eventoModelo->obtenerEventosDestacados();
            return $eventos;
        } catch (Exception $e) {
            error_log("Error al obtener eventos destacados: " . $e->getMessage());
            return [];
        }
    }
}
?>