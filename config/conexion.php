<?php
class Conexion {
    public static function conectar() {
        $serverName = "LAPTOP-I4EDRO6C\\SQL2017"; // Doble backslash para escapar correctamente
        $connectionInfo = array(
            "Database" => "UTA_FISEI_EventosConfig",
            "UID" => "sa",
            "PWD" => "123456",
            "CharacterSet" => "UTF-8"
        );

        $conn = sqlsrv_connect($serverName, $connectionInfo);

        if ($conn === false) {
            error_log(print_r(sqlsrv_errors(), true)); // Guardar error en logs del servidor
            die("Error en la conexión con la base de datos.");
        }

        return $conn;
    }
}
