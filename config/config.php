<?php // Configuración de base de datos para Docker 
define ('DB_HOST', getenv('DB_HOST') ?: 'db'); 
define('DB_NAME', getenv('DB_NAME') ?: 'uta_fisei_eventosconfig'); 
define('DB_USER', getenv('DB_USER') ?: 'root'); 
define('DB_PASS', getenv('DB_PASS') ?: 'eventos2024');