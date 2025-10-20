<?php
// Iniciar sesión
session_start();
$nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';

// Verificar autenticación (protege la página)
require_once __DIR__ . '/inc/auth.php';

// Determinar el archivo de categorías según el idioma
if (!isset($_COOKIE['Idioma']) || $_COOKIE['Idioma'] == "ES") {
    $idioma = "ES";
    $archivo = "categorias_es.txt";
} else {
    $idioma = "EN";
    $archivo = "categorias_en.txt";
}

// Textos traducidos
$textos = [
    'ES' => [
        'bienvenida' => 'Bienvenido Usuario:',
        'titulo' => 'Panel Principal de Productos',
        'listaProductos' => 'Lista de Productos',
        'carrito' => 'Carrito de Compra',
        'cerrarSesion' => 'Cerrar Sesión'
    ],
    'EN' => [
        'bienvenida' => 'Welcome User:',
        'titulo' => 'Main Product Panel',
        'listaProductos' => 'Product List',
        'carrito' => 'Shopping Cart',
        'cerrarSesion' => 'Log Out'
    ]
];

// Leer el archivo de productos
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

<!DOCTYPE html>
<html lang="<?= strtolower($idioma) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($textos[$idioma]['titulo']) ?></title>
</head>
<body>
    <!-- Encabezado -->
    <header>
        <table width="100%" cellpadding="5">
            <tr>
                <td align="left">
                    <h2><?= htmlspecialchars($textos[$idioma]['bienvenida']) ?> <?= htmlspecialchars($nombreUsuario) ?></h2>
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
                <td width="50%"><a href="carrito.php"><b><?= htmlspecialchars($textos[$idioma]['carrito']) ?></b></a></td>
                <td width="50%"><a href="cerrarSesion.php"><b><?= htmlspecialchars($textos[$idioma]['cerrarSesion']) ?></b></a></td>
            </tr>
        </table>
    </nav>
    <br>

    <!-- Contenido principal -->
    <main>
        <h2 align="center"><?= htmlspecialchars($textos[$idioma]['listaProductos']) ?></h2>
        <table width="80%" align="center" cellpadding="8" cellspacing="0" border="1">
            <?php foreach ($productos as $producto): ?>
            <tr>
                <td align="center">
                    <a href="producto.php?categoria=<?= urlencode($producto['nombre']) ?>">
                        <b><?= htmlspecialchars($producto['nombre']) ?></b>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>