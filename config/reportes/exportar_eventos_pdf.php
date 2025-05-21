<?php
require_once("../../lib/fpdf/fpdf.php");
include("../../conexion.php"); // Cambiar la URL de conexión del proyecto

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Reporte de Eventos',0,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,10,'Titulo',1);
$pdf->Cell(40,10,'Tipo',1);
$pdf->Cell(40,10,'Categoria',1);
$pdf->Cell(50,10,'Fechas',1);
$pdf->Ln();

$sql = "SELECT e.TITULO, e.FECHAINICIO, e.FECHAFIN,
               t.NOMBRE AS TIPO, c.NOMBRE AS CATEGORIA
        FROM EVENTO e
        JOIN TIPO_EVENTO t ON e.CODIGOTIPOEVENTO = t.CODIGO
        JOIN CATEGORIA_EVENTO c ON e.SECUENCIALCATEGORIA = c.CODIGO";

$result = $conn->query($sql);
$pdf->SetFont('Arial','',10);

while ($row = $result->fetch_assoc()) {
    $titulo = $row['TITULO'];
    $tipo = $row['TIPO'];
    $categoria = $row['CATEGORIA'];
    $fechas = $row['FECHAINICIO'] . ' - ' . $row['FECHAFIN'];

    $pdf->Cell(50,10,utf8_decode($titulo),1);
    $pdf->Cell(40,10,utf8_decode($tipo),1);
    $pdf->Cell(40,10,utf8_decode($categoria),1);
    $pdf->Cell(50,10,utf8_decode($fechas),1);
    $pdf->Ln();
}

$pdf->Output();
