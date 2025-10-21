<?php
// Iniciar sesión para poder destruirla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpiar variables de sesión
$_SESSION = [];

// Borrar cookie de sesión (si existe)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params['path'], 
        $params['domain'],
        isset($params['secure']) ? $params['secure'] : false,
        isset($params['httponly']) ? $params['httponly'] : false
    );
}

// Destruir la sesión en el servidor
session_destroy();

// Borrar cookies propias (recordarme, csrf, etc.) si existen
if (isset($_COOKIE['recordarme'])) {
    setcookie('usuario', '', time() - 3600, '/');
    setcookie('clave', '', time() - 3600, '/');
    setcookie('recordarme', '', time() - 3600, '/');
    setcookie('Idioma', '', time() - 3600, '/');
}

// Redirigir a la página de login
header('Location: index.php');
exit;
?>