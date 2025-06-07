<?php
require_once '../models/EventoAsistencia.php';

class EventoAsistenciaController {
    private $model;

    public function __construct() {
        $this->model = new EventoAsistencia();
    }

    public function listarEventos() {
        return $this->model->obtenerEventos();
    }

    public function obtenerReporte($idEvento) {
        return $this->model->obtenerReporte($idEvento);
    }
}
