<?php
if (!isset($_COOKIE['Idioma']) || $_COOKIE['Idioma'] == "ES") {
    $archivo = "categorias_es.txt";
} else {
    $archivo = "categorias_en.txt";
}
// Lectura del archivo de productos
$contenido = file_get_contents($archivo);
// Separar por comas o saltos de línea
$categorias = preg_split("/[\s,]+/", trim($contenido));
?> 

<html>
<head>
</head>
<body>
    <h1>Bienvenido a el Panel Principal de Productos</h1>
    <h1>Bienvenido <?php echo $nombre; ?></h1>
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
    foreach ($categorias as $categoria) {
    if (!empty($categoria)) {
        $categoria_url = urlencode($categoria);
        echo "<li><a href='producto.php?categoria=$categoria_url'>" . htmlspecialchars($categoria) . "</a></li>";
        }
    }
    ?>
</ul>
</body>
</html>