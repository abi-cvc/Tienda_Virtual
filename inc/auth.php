<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si ya hay sesión con usuario, permitir
if (!empty($_SESSION['usuario'])) {
    return;
}

// Si existe cookie "usuario" y "clave" (Recordarme) restauramos sesión
if (!empty($_COOKIE['usuario']) && !empty($_COOKIE['clave'])) {
    // Atención: esto asume que las cookies contienen datos permitidos por la práctica.
    $_SESSION['usuario'] = $_COOKIE['usuario'];
    session_regenerate_id(true);
    return;
}

// Si no hay sesión ni cookies válidas, redirigir al login
header('Location: /Tienda_Virtual/index.php');
exit;
?>