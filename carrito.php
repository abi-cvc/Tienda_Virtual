<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    // Redirigir al login si el usuario no ha iniciado sesión
    header("Location: login.php");
    exit;
}

$nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';

// Idioma desde la cookie
if (!isset($_COOKIE['Idioma']) || $_COOKIE['Idioma'] == "ES") {
    $idioma = "ES";
} else {
    $idioma = "EN";
}

// Textos traducidos
if ($idioma == "ES") {
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($titulo) ?></h1>
    <a href="cambiarIdioma.php?idioma=ES">ES/(Español)│</a>
    <a href="cambiarIdioma.php?idioma=EN">EN/(English)</a>
    <br><br>
    <a href="panel.php"><?= htmlspecialchars($btnVolver) ?></a> |
    <a href="cerrarSesion.php">Cerrar Sesión</a>
    <hr>

    <?php if (isset($mensaje)): ?>
        <div style="color: green;"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if (empty($_SESSION['carrito'])): ?>
        <p><?= htmlspecialchars($mensajeVacio) ?></p>
    <?php else: ?>
        <form method="POST">
            <table border="1" cellpadding="8">
                <tr>
                    <th><?= htmlspecialchars($columnaNombre) ?></th>
                    <th><?= htmlspecialchars($columnaDescripcion) ?></th>
                    <th><?= htmlspecialchars($columnaPrecio) ?></th>
                    <th><?= htmlspecialchars($columnaCantidad) ?></th>
                    <th><?= htmlspecialchars($columnaTotal) ?></th>
                    <th></th>
                </tr>

                <?php
                $totalGeneral = 0;
                foreach ($_SESSION['carrito'] as $item):
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $totalGeneral += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nombre']) ?></td>
                        <td><?= htmlspecialchars($item['descripcion']) ?></td>
                        <td>$<?= htmlspecialchars($item['precio']) ?></td>
                        <td><?= htmlspecialchars($item['cantidad']) ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                        <td>
                            <button type="submit" name="eliminar" value="<?= htmlspecialchars($item['id']) ?>">
                                <?= htmlspecialchars($btnEliminar) ?>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" align="right"><strong><?= htmlspecialchars($columnaTotal) ?>:</strong></td>
                    <td colspan="2"><strong>$<?= number_format($totalGeneral, 2) ?></strong></td>
                </tr>
            </table>
            <br>
            <button type="submit" name="vaciar"><?= htmlspecialchars($btnVaciar) ?></button>
        </form>
    <?php endif; ?>
</body>
</html>
