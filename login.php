<?php
// -----------------------------
// 1️⃣ Redirección para evitar problemas de mayúsculas/minúsculas
// Ignora los parámetros GET (como ?lang=en)
$actualPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$correctPath = '/Tienda_Virtual/login.php';

if (strcasecmp($actualPath, $correctPath) !== 0) {
    header("Location: $correctPath");
    exit();
}

// -----------------------------
// 2️⃣ Configurar idioma
$idioma = "es"; // idioma por defecto: español
if (isset($_GET['lang'])) {
    $idioma = $_GET['lang'];
}

// -----------------------------
// 3️⃣ Textos en español e inglés
$textos = [
    "es" => [
        "titulo" => "Inicio de sesión",
        "usuario" => "Usuario:",
        "clave" => "Clave:",
        "boton" => "Ingresar",
        "idioma" => "Idioma"
    ],
    "en" => [
        "titulo" => "Login",
        "usuario" => "Username:",
        "clave" => "Password:",
        "boton" => "Sign in",
        "idioma" => "Language"
    ]
];
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
    <form action="login.php?lang=<?= $idioma ?>" method="POST">
        <fieldset>
            <label><?= $textos[$idioma]["usuario"] ?></label><br>
            <input type="text" name="nombre" /><br><br>

            <label><?= $textos[$idioma]["clave"] ?></label><br>
            <input type="password" name="clave" /><br><br>

            <input type="submit" value="<?= $textos[$idioma]["boton"] ?>" />
        </fieldset>
    </form>

</body>
</html>
