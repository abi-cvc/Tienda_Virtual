<?php
// Iniciar sesión
session_start();
$nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';

// Verificar autenticación (protege la página)
require_once __DIR__ . '/inc/auth.php';
$nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';

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
<html lang="<?= strtolower($idioma) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
</head>
<body>
    <!-- Encabezado -->
    <header>
        <table width="100%" cellpadding="5">
            <tr>
                <td align="left">
                    <h2><?= htmlspecialchars($bienvenida) ?> <?= isset($nombreUsuario) ? htmlspecialchars($nombreUsuario) : "Usuario" ?></h2>
                </td>
                <td align="right">
                    <a href="cambiarIdioma.php?idioma=ES">ES/(Español)</a> │
                    <a href="cambiarIdioma.php?idioma=EN">EN/(English)</a>
                </td>
            </tr>
        </table>
    </header>
    <hr>

    <!-- Menú de navegación -->
    <nav>
        <table width="100%" cellpadding="10" cellspacing="0" border="1">
            <tr align="center">
                <td width="33%"><a href="panel.php"><b>Panel Principal</b></a></td>
                <td width="33%"><a href="carrito.php"><b>Carrito de Compra</b></a></td>
                <td width="34%"><a href="cerrarSesion.php"><b>Cerrar Sesión</b></a></td>
            </tr>
        </table>
    </nav>
    <br>

    <!-- Contenido principal -->
    <main>
        <h2 align="center"><?= htmlspecialchars($titulo) ?></h2>
        
        <!-- Detalles del producto -->
        <table width="80%" align="center" cellpadding="8" cellspacing="0" border="1">
            <tr>
                <td width="30%" align="right"><strong><?= $labelId ?>:</strong></td>
                <td width="70%" align="left"><?= htmlspecialchars($productoEncontrado['id']) ?></td>
            </tr>
            <tr>
                <td align="right"><strong><?= $labelNombre ?>:</strong></td>
                <td align="left"><?= htmlspecialchars($productoEncontrado['nombre']) ?></td>
            </tr>
            <tr>
                <td align="right"><strong><?= $labelDescripcion ?>:</strong></td>
                <td align="left"><?= htmlspecialchars($productoEncontrado['descripcion']) ?></td>
            </tr>
            <tr>
                <td align="right"><strong><?= $labelPrecio ?>:</strong></td>
                <td align="left">$<?= htmlspecialchars($productoEncontrado['precio']) ?></td>
            </tr>
        </table>
        
        <!-- Formulario de agregar al carrito -->
        <table width="80%" align="center" cellpadding="15">
            <tr>
                <td align="center">
                    <form method="POST">
                        <button type="submit"><b><?= htmlspecialchars($btnAgregar) ?></b></button>
                    </form>
                </td>
            </tr>
            <?php if (isset($mensaje)): ?>
            <tr>
                <td align="center">
                    <div style="color: green;"><b><?= htmlspecialchars($mensaje) ?></b></div>
                </td>
            </tr>
            <?php endif; ?>
        </table>
    </main>
</body>
</html>
