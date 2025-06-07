<?php
require_once 'Conexion.php';

$conn = Conexion::conectar();

if ($conn) {
    echo "✅ Conexión exitosa a la base de datos.";
} else {
    echo "❌ Error al conectar con la base de datos.";
}
