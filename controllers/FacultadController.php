<?php
require_once '../models/FacultadFISEI.php';

header('Content-Type: application/json');

$facultadModel = new Facultad();
$id = isset($_GET['id']) ? intval($_GET['id']) : 9; 
echo json_encode($facultadModel->getFacultad($id));