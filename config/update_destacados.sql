-- Script para añadir la columna ES_DESTACADO a la tabla evento
-- Ejecutar este script en phpMyAdmin o consola MySQL

USE uta_fisei_eventosconfig;

-- Añadir la columna ES_DESTACADO si no existe
ALTER TABLE evento 
ADD COLUMN IF NOT EXISTS ES_DESTACADO TINYINT(1) NOT NULL DEFAULT 0 
COMMENT 'Indica si el evento es destacado (1) o no (0)' 
AFTER CAPACIDAD;

-- Marcar algunos eventos como destacados para testing
UPDATE evento 
SET ES_DESTACADO = 1 
WHERE SECUENCIAL IN (152, 155, 156) 
AND ESTADO = 'DISPONIBLE';

-- Verificar que se han actualizado correctamente
SELECT SECUENCIAL, TITULO, ES_DESTACADO, ESTADO 
FROM evento 
WHERE ES_DESTACADO = 1;
