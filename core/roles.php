<?php
/**
 * Retorna el rol del usuario desde la sesión
 */
function obtenerRol()
{
    return isset($_SESSION['usuario']['ROL']) ? strtoupper($_SESSION['usuario']['ROL']) : null;
}

/**
 * Verifica si el usuario tiene un rol específico
 */
function esRol(string $rol)
{
    return obtenerRol() === strtoupper($rol);
}

/**
 * Verifica si el usuario tiene alguno de los roles dados
 */
function esUnoDe(array $roles)
{
    $rolActual = obtenerRol();
    return $rolActual && in_array($rolActual, array_map('strtoupper', $roles));
}

/**
 * Verifica si el usuario está marcado como RESPONSABLE (desde tabla ORGANIZADOR_EVENTO)
 */
function esResponsable()
{
    return !empty($_SESSION['usuario']['ES_RESPONSABLE']);
}

?>