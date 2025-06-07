<?php
require_once '../models/Certificado.php';

class CertificadoController {
    private $model;

    public function __construct() {
        $this->model = new Certificado();
    }

    public function listarEventos() {
        return $this->model->obtenerEventos();
    }

    public function obtenerReporte($idEvento) {
        return $this->model->obtenerCertificadosPorEvento($idEvento);
    }
}
