<?php
include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['SECUENCIAL'];
    $titulo = $_POST['TITULO'];
    $descripcion = $_POST['DESCRIPCION'];
    $tipo = $_POST['CODIGOTIPOEVENTO'];
    $categoria = $_POST['SECUENCIALCATEGORIA'];
    $modalidad = $_POST['CODIGOMODALIDAD'];
    $fechaInicio = $_POST['FECHAINICIO'];
    $fechaFin = $_POST['FECHAFIN'];
    $horas = $_POST['HORAS'];
    $nota = $_POST['NOTAAPROBACION'];
    $es_pagado = $_POST['ES_PAGADO'];
    $costo = $_POST['COSTO'];
    $carrera = $_POST['SECUENCIALCARRERA'];
    $solo_internos = $_POST['ES_SOLO_INTERNOS'];

    // Validación básica
    if (!empty($titulo) && !empty($tipo) && !empty($categoria)) {
        $sql = "UPDATE EVENTO SET
                    TITULO = ?, DESCRIPCION = ?, CODIGOTIPOEVENTO = ?, FECHAINICIO = ?, FECHAFIN = ?,
                    CODIGOMODALIDAD = ?, HORAS = ?, NOTAAPROBACION = ?, ES_PAGADO = ?, COSTO = ?,
                    SECUENCIALCARRERA = ?, ES_SOLO_INTERNOS = ?, SECUENCIALCATEGORIA = ?
                WHERE SECUENCIAL = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssidddiiiiii",
            $titulo,
            $descripcion,
            $tipo,
            $fechaInicio,
            $fechaFin,
            $modalidad,
            $horas,
            $nota,
            $es_pagado,
            $costo,
            $carrera,
            $solo_internos,
            $categoria,
            $id
        );

        if ($stmt->execute()) {
            header("Location: config_eventos.php?updated=1");
            exit();
        } else {
            echo "Error al actualizar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Faltan campos obligatorios.";
    }

    $conn->close();
} else {
    echo "Acceso denegado.";
}
