<?php
// Iniciar sesión
session_start();
$nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';

// Verificar autenticación (protege la página)
require_once __DIR__ . '/inc/auth.php';
$nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';

// Idioma desde la cookie
if (!isset($_COOKIE['Idioma']) || $_COOKIE['Idioma'] == "ES") {
    $idioma = "ES";
} else {
    $idioma = "EN";
}

// Textos traducidos
if ($idioma == "ES") {
    $bienvenida = "Bienvenido Usuario:";
    $titulo = "Carrito de Compras";
    $columnaNombre = "Nombre";
    $columnaDescripcion = "Descripción";
    $columnaPrecio = "Precio";
    $columnaCantidad = "Cantidad";
    $columnaTotal = "Total";
    $btnVaciar = "Vaciar Carrito";
    $btnVolver = "Volver al Panel";
    $btnEliminar = "Eliminar";
    $mensajeVacio = "Tu carrito está vacío.";
    $mensajeEliminado = "Producto eliminado del carrito.";
    $mensajeVaciado = "Carrito vaciado correctamente.";
} else {
    $bienvenida = "Welcome User:";
    $titulo = "Shopping Cart";
    $columnaNombre = "Name";
    $columnaDescripcion = "Description";
    $columnaPrecio = "Price";
    $columnaCantidad = "Quantity";
    $columnaTotal = "Total";
    $btnVaciar = "Empty Cart";
    $btnVolver = "Return to Panel";
    $btnEliminar = "Remove";
    $mensajeVacio = "Your cart is empty.";
    $mensajeEliminado = "Product removed from cart.";
    $mensajeVaciado = "Cart successfully emptied.";
}

// Vaciar carrito
if (isset($_POST['vaciar'])) {
    unset($_SESSION['carrito']);
    $mensaje = $mensajeVaciado;
}

// Eliminar un producto específico
if (isset($_POST['eliminar'])) {
    $idEliminar = $_POST['eliminar'];
    foreach ($_SESSION['carrito'] as $indice => $item) {
        if ($item['id'] === $idEliminar) {
            unset($_SESSION['carrito'][$indice]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
            $mensaje = $mensajeEliminado;
            break;
        }
    }
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
                <td width="50%"><a href="panel.php"><b><?= htmlspecialchars($btnVolver) ?></b></a></td>
                <td width="50%"><a href="cerrarSesion.php"><b>Cerrar Sesión</b></a></td>
            </tr>
        </table>
    </nav>
    <br>

    <!-- Contenido principal -->
    <main>
        <h2 align="center"><?= htmlspecialchars($titulo) ?></h2>

        <?php if (isset($mensaje)): ?>
            <table width="80%" align="center">
                <tr>
                    <td align="center">
                        <div style="color: green;"><b><?= htmlspecialchars($mensaje) ?></b></div>
                    </td>
                </tr>
            </table>
            <br>
        <?php endif; ?>

        <?php if (empty($_SESSION['carrito'])): ?>
            <table width="80%" align="center">
                <tr>
                    <td align="center">
                        <p><b><?= htmlspecialchars($mensajeVacio) ?></b></p>
                    </td>
                </tr>
            </table>
        <?php else: ?>
            <form method="POST">
                <table width="90%" align="center" cellpadding="8" cellspacing="0" border="1">
                    <tr align="center" bgcolor="#f2f2f2">
                        <th><?= htmlspecialchars($columnaNombre) ?></th>
                        <th><?= htmlspecialchars($columnaDescripcion) ?></th>
                        <th><?= htmlspecialchars($columnaPrecio) ?></th>
                        <th><?= htmlspecialchars($columnaCantidad) ?></th>
                        <th><?= htmlspecialchars($columnaTotal) ?></th>
                        <th>Acciones</th>
                    </tr>

                    <?php
                    $totalGeneral = 0;
                    foreach ($_SESSION['carrito'] as $item):
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $totalGeneral += $subtotal;
                    ?>
                        <tr align="center">
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td><?= htmlspecialchars($item['descripcion']) ?></td>
                            <td>$<?= htmlspecialchars($item['precio']) ?></td>
                            <td><b><?= htmlspecialchars($item['cantidad']) ?></b></td>
                            <td><b>$<?= number_format($subtotal, 2) ?></b></td>
                            <td>
                                <button type="submit" name="eliminar" value="<?= htmlspecialchars($item['id']) ?>">
                                    <b><?= htmlspecialchars($btnEliminar) ?></b>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" align="right" bgcolor="#f2f2f2">
                            <strong><?= htmlspecialchars($columnaTotal) ?>:</strong>
                        </td>
                        <td align="center" bgcolor="#f2f2f2" colspan="2">
                            <strong>$<?= number_format($totalGeneral, 2) ?></strong>
                        </td>
                    </tr>
                </table>
                <br>
                <table width="90%" align="center">
                    <tr>
                        <td align="center">
                            <button type="submit" name="vaciar">
                                <b><?= htmlspecialchars($btnVaciar) ?></b>
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>
