<?php
session_start();
$nombre = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';

/* Para que funcione al abrir en el navegador de forma independiente.
if (!isset($_SESSION["nombre"]) && !isset($_SESSION["clave"])) {
    header("Location: index.php");
    exit();
}
$nombreUsuario = $_SESSION['usuario'];
*/

// Idioma desde la cookie
if (!isset($_COOKIE['Idioma']) || $_COOKIE['Idioma'] == "ES") {
    $archivo = "categorias_es.txt";
    $idioma = "ES";
} else {
    $archivo = "categorias_en.txt";
    $idioma = "EN";
}

// Verificar que haya categoría en GET
if (!isset($_GET['categoria'])) {
    echo "<h2>No se seleccionó ningún producto.</h2>";
    echo "<a href='panel.php'>Volver al Panel</a>";
    exit();
}

$categoria = urldecode($_GET['categoria']);

// Leer productos del archivo (formato: id|nombre|descripcion|precio)
$lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$productoEncontrado = null;

foreach ($lineas as $linea) {
    if (strpos($linea, '|') !== false) {
        list($id, $nombre, $descripcion, $precio) = explode('|', $linea);
        if (trim($nombre) === $categoria) {
            $productoEncontrado = [
                'id' => trim($id),
                'nombre' => trim($nombre),
                'descripcion' => trim($descripcion),
                'precio' => trim($precio)
            ];
            break;
        }
    }
}

// Si el usuario hace clic en "Agregar al carrito"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $idProducto = $productoEncontrado['id'];
    $encontrado = false;

    // Verificar si el producto ya existe en el carrito
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] === $idProducto) {
            $item['cantidad'] += 1;
            $encontrado = true;
            break;
        }
    }

    // Si no existe, lo agregamos como nuevo
    if (!$encontrado) {
        $productoEncontrado['cantidad'] = 1;
        $_SESSION['carrito'][] = $productoEncontrado;
    }

    $mensaje = ($idioma == "ES")
        ? "Producto agregado al carrito correctamente."
        : "Product successfully added to cart.";
}

// Textos traducidos
if ($idioma == "ES") {
    $titulo = "Detalles del Producto";
    $bienvenida = "Bienvenido Usuario:";
    $labelId = "ID";
    $labelNombre = "Nombre";
    $labelDescripcion = "Descripción";
    $labelPrecio = "Precio";
    $btnAgregar = "Agregar al carrito";
} else {
    $titulo = "Product Details";
    $bienvenida = "Welcome User:";
    $labelId = "ID";
    $labelNombre = "Name";
    $labelDescripcion = "Description";
    $labelPrecio = "Price";
    $btnAgregar = "Add to cart";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($bienvenida) ?> <?= isset($nombreUsuario) ? htmlspecialchars($nombreUsuario) : "Usuario" ?></h1>
    <hr>
    <a href="cambiarIdioma.php?idioma=ES">ES/(Español)│</a>
    <a href="cambiarIdioma.php?idioma=EN">EN/(English)</a>
    <br>
    <a href="panel.php">Panel Principal</a> |
    <a href="carrito.php">Carrito de Compra</a> |
    <a href="cerrarSesion.php">Cerrar Sesión</a>

    <h1><?= htmlspecialchars($titulo) ?></h1>
    <hr>

    <p><strong><?= $labelId ?>:</strong> <?= htmlspecialchars($productoEncontrado['id']) ?></p>
    <p><strong><?= $labelNombre ?>:</strong> <?= htmlspecialchars($productoEncontrado['nombre']) ?></p>
    <p><strong><?= $labelDescripcion ?>:</strong> <?= htmlspecialchars($productoEncontrado['descripcion']) ?></p>
    <p><strong><?= $labelPrecio ?>:</strong> $<?= htmlspecialchars($productoEncontrado['precio']) ?></p>

    <form method="POST">
        <button type="submit"><?= htmlspecialchars($btnAgregar) ?></button>
    </form>

    <?php if (isset($mensaje)): ?>
        <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
</body>
</html>
