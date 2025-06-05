<?php
require_once '../models/Financiero.php';

class FinancieroController {
    private $model;

    public function __construct() {
        $this->model = new Financiero();
    }

    public function listarEventos() {
        return $this->model->obtenerEventos();
    }

    public function obtenerReporte($idEvento) {
        return $this->model->obtenerReporteFinanciero($idEvento);
    }

    public function obtenerNombreEvento($idEvento) {
        return $this->model->obtenerTituloEvento($idEvento);
    }
}
