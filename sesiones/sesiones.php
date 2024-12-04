<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define el tiempo máximo de inactividad permitido (en segundos)
define('TIEMPO_INACTIVIDAD', 1200); // 1200 segundos = 20 minutos

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../sesiones/login.php");
    exit();
}

// Verifica si existe la marca de tiempo de la última actividad
if (isset($_SESSION['ultimo_acceso'])) {
    $tiempo_inactivo = time() - $_SESSION['ultimo_acceso'];
    if ($tiempo_inactivo > TIEMPO_INACTIVIDAD) {
        session_unset(); // Elimina todas las variables de sesión
        session_destroy(); // Destruye la sesión
        header("Location: ../sesiones/login.php?mensaje=sesion_expirada");
        exit();
    }    
}

// Actualiza la marca de tiempo de la última actividad
$_SESSION['ultimo_acceso'] = time();
?>