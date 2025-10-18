<?php
// -----------------------------
// Iniciar sesión
session_start();

// -----------------------------
// Redirección para evitar problemas de mayúsculas/minúsculas
$actualPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$correctPath = '/Tienda_Virtual/index.php';

if (strcasecmp($actualPath, $correctPath) !== 0) {
    header("Location: $correctPath");
    exit();
}

// -----------------------------
// Configurar idioma
$idioma = "es"; // idioma por defecto: español
if (isset($_GET['lang'])) {
    $idioma = $_GET['lang'];
}

// -----------------------------
// Textos en español e inglés
$textos = [
    "es" => [
        "titulo" => "Inicio de sesión",
        "usuario" => "Usuario:",
        "clave" => "Clave:",
        "boton" => "Ingresar",
        "idioma" => "Idioma",
        "recordarme" => "Recordarme",
        "error" => "Debe ingresar su Usuario y Clave."
    ],
    "en" => [
        "titulo" => "Login",
        "usuario" => "Username:",
        "clave" => "Password:",
        "boton" => "Sign in",
        "idioma" => "Language",
        "recordarme" => "Remember me",
        "error" => "You must enter your Username and Password."
    ]
];

// -----------------------------
// Manejar cookies si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreUsuario = $_POST['nombre'];
    $claveUsuario = $_POST['clave'];

    // Verificar que ambos campos fueron llenados
    if (empty($nombreUsuario) || empty($claveUsuario)) {
        echo "<script>alert('{$textos[$idioma]['error']}');</script>";
    } else {
        // Guardar en sesión
        $_SESSION['usuario'] = $nombreUsuario;

        // Manejo de cookies (Recordarme)
        if (isset($_POST['recordarme'])) {
            // Guardar cookies por 30 días
            setcookie('usuario', $nombreUsuario, time() + 30*24*60*60, "/");
            setcookie('clave', $claveUsuario, time() + 30*24*60*60, "/");
        } else {
            // Borrar cookies si existen
            setcookie('usuario', '', time() - 3600, "/");
            setcookie('clave', '', time() - 3600, "/");
        }

        // Redirigir al panel solo si ambos campos son válidos
        header("Location: panel.php?lang=$idioma");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $textos[$idioma]["titulo"] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            text-align: center;
        }
        fieldset {
            border-radius: 10px;
            padding: 20px;
        }
        select {
            margin-bottom: 20px;
            padding: 5px;
        }
        label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1><?= $textos[$idioma]["titulo"] ?></h1>

<!-- Selector de idioma -->
<form method="get" action="">
    <label><?= $textos[$idioma]["idioma"] ?>:</label>
    <select name="lang" onchange="this.form.submit()">
        <option value="es" <?= $idioma === "es" ? "selected" : "" ?>>Español</option>
        <option value="en" <?= $idioma === "en" ? "selected" : "" ?>>English</option>
    </select>
</form>

<!-- Formulario de login -->
<form action="index.php?lang=<?= $idioma ?>" method="POST">
    <fieldset>
        <label><?= $textos[$idioma]["usuario"] ?></label><br>
        <input type="text" name="nombre" value="<?= isset($_COOKIE['usuario']) ? $_COOKIE['usuario'] : '' ?>" /><br><br>

        <label><?= $textos[$idioma]["clave"] ?></label><br>
        <input type="password" name="clave" value="<?= isset($_COOKIE['clave']) ? $_COOKIE['clave'] : '' ?>" /><br><br>

        <label>
            <input type="checkbox" name="recordarme" /> <?= $textos[$idioma]["recordarme"] ?>
        </label><br><br>

        <input type="submit" value="<?= $textos[$idioma]["boton"] ?>" />
    </fieldset>
</form>

</body>
</html>
