# Tienda Virtual

Este proyecto es una tienda virtual sencilla desarrollada en PHP. Permite a los usuarios iniciar sesión, navegar por productos, agregar productos al carrito y gestionar el idioma de la interfaz (Español/Inglés).

## Estructura de archivos

- `index.php`: Página de inicio de sesión con selector de idioma.
- `panel.php`: Panel principal donde se listan los productos disponibles.
- `producto.php`: Muestra los detalles de un producto y permite agregarlo al carrito.
- `carrito.php`: Visualiza y gestiona los productos agregados al carrito.
- `cerrarsesion.php`: Cierra la sesión y elimina las cookies.
- `cambiarIdioma.php`: Cambia el idioma de la interfaz mediante cookies.
- `categorias_es.txt` / `categorias_en.txt`: Listados de productos en español e inglés.
- `inc/auth.php`: Control de autenticación y restauración de sesión.

## Funcionalidades

- **Autenticación**: Inicio de sesión con opción "Recordarme".
- **Gestión de productos**: Visualización y selección de productos por categoría.
- **Carrito de compras**: Añadir, eliminar y vaciar productos del carrito.
- **Soporte multilenguaje**: Español e Inglés, configurable por cookie.
- **Persistencia**: Uso de sesiones y cookies para mantener el estado del usuario y preferencias.

## Uso

1. Accede a `index.php` para iniciar sesión.
2. Selecciona el idioma preferido.
3. Navega por los productos en el panel principal.
4. Visualiza detalles y agrega productos al carrito.
5. Gestiona el carrito desde la página correspondiente.
6. Cierra sesión cuando lo desees.

## Requisitos

- PHP 7.x o superior
- Servidor web (XAMPP)
