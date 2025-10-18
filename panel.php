<?php
// Iniciar sesión
session_start();
$nombre = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';

// Determinar el archivo de categorías según el idioma
if (!isset($_COOKIE['Idioma']) || $_COOKIE['Idioma'] == "ES") {
    $archivo = "categorias_es.txt";
} else {
    $archivo = "categorias_en.txt";
}

// Modificacion de lectura de ficheros, por "|" en vez de ","
//Leer el archivo línea por línea
$lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$productos = [];

// Formato: id|nombre|descripcion|precio
foreach ($lineas as $linea) {
    list($id, $nombre, $descripcion, $precio) = explode('|', $linea);
    $productos[] = [
        'id' => trim($id),
        'nombre' => trim($nombre),
        'descripcion' => trim($descripcion),
        'precio' => trim($precio)
    ];
}

?>

<html>
<head>
</head>
<body>
    <h1>Bienvenido a el Panel Principal de Productos</h1>
    <h1>Bienvenido <?php echo htmlspecialchars($nombre); ?></h1>
    <hr>
    <a href="cambiarIdioma.php?idioma=ES">ES/(Español)│ </a>
    <a href="cambiarIdioma.php?idioma=EN">EN/(English)</a>
    <h1> <?php if (!isset($_COOKIE['Idioma']) || $_COOKIE['Idioma'] == "ES") {
            echo "Lista de Productos";
        } else {
            echo "Product List";
        } ?> </h1>
    <ul>
    <?php
        foreach ($productos as $producto) {
        $categoria_url = urlencode($producto['nombre']);
        echo "<li><a href='producto.php?categoria=$categoria_url'>" . htmlspecialchars($producto['nombre']) . "</a></li>";
        }
    ?>
    </ul>
</body>
</html>