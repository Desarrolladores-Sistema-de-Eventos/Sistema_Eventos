<?php
require_once '../models/EventoCategoria.php';

class EventoCategoriaController {
    private $model;

    public function __construct() {
        $this->model = new EventoCategoria();
    }

    public function listarCategorias() {
        return $this->model->obtenerCategorias();
    }

    public function listarEventos($idCategoria) {
        return $this->model->obtenerEventosPorCategoria($idCategoria);
    }
}
