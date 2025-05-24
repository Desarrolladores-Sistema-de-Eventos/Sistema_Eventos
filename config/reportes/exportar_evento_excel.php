<?php
require '../../vendor/autoload.php';
include("../../conexion.php"); // Cambiar la URL de conexión del proyecto

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$sheet->setCellValue('A1', 'Título');
$sheet->setCellValue('B1', 'Tipo');
$sheet->setCellValue('C1', 'Categoría');
$sheet->setCellValue('D1', 'Modalidad');
$sheet->setCellValue('E1', 'Fecha Inicio');
$sheet->setCellValue('F1', 'Fecha Fin');
$sheet->setCellValue('G1', 'Horas');
$sheet->setCellValue('H1', 'Nota Aprobación');
$sheet->setCellValue('I1', '¿Es Pagado?');
$sheet->setCellValue('J1', 'Costo');
$sheet->setCellValue('K1', 'Solo Internos');
$sheet->setCellValue('L1', 'Carrera');

// Consulta a la BD con JOINs 
$sql = "SELECT 
            e.TITULO,
            t.NOMBRE AS TIPO,
            c.NOMBRE AS CATEGORIA,
            m.NOMBRE AS MODALIDAD,
            e.FECHAINICIO,
            e.FECHAFIN,
            e.HORAS,
            e.NOTAAPROBACION,
            e.ES_PAGADO,
            e.COSTO,
            e.ES_SOLO_INTERNOS,
            ca.NOMBRE_CARRERA
        FROM EVENTO e
        JOIN TIPO_EVENTO t ON e.CODIGOTIPOEVENTO = t.CODIGO
        JOIN CATEGORIA_EVENTO c ON e.SECUENCIALCATEGORIA = c.SECUENCIAL
        JOIN MODALIDAD_EVENTO m ON e.CODIGOMODALIDAD = m.CODIGO
        JOIN CARRERA ca ON e.SECUENCIALCARRERA = ca.SECUENCIAL";

$result = $conn->query($sql);
$fila = 2;

while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue("A$fila", $row['TITULO']);
    $sheet->setCellValue("B$fila", $row['TIPO']);
    $sheet->setCellValue("C$fila", $row['CATEGORIA']);
    $sheet->setCellValue("D$fila", $row['MODALIDAD']);
    $sheet->setCellValue("E$fila", $row['FECHAINICIO']);
    $sheet->setCellValue("F$fila", $row['FECHAFIN']);
    $sheet->setCellValue("G$fila", $row['HORAS']);
    $sheet->setCellValue("H$fila", $row['NOTAAPROBACION']);
    $sheet->setCellValue("I$fila", $row['ES_PAGADO'] ? 'Sí' : 'No');
    $sheet->setCellValue("J$fila", $row['COSTO']);
    $sheet->setCellValue("K$fila", $row['ES_SOLO_INTERNOS'] ? 'Sí' : 'No');
    $sheet->setCellValue("L$fila", $row['NOMBRE_CARRERA']);
    $fila++;
}

// Enviar archivo para descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_completo_eventos.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
