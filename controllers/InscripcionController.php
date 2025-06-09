<?php
require_once '../models/Inscripcion.php';

class InscripcionController {
    private $model;

    public function __construct() {
        $this->model = new Inscripcion();
    }

    public function listarEventos() {
        return $this->model->obtenerEventos();
    }

    public function obtenerReporte($idEvento) {
        return $this->model->obtenerInscripciones($idEvento);
    }
    public function obtenerNombreEvento($idEvento) {
    return $this->model->obtenerTituloEvento($idEvento);
}
}
