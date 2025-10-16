<?php
$idioma = $_GET['idioma'];
if ($idioma == "ES") {
    setcookie("Idioma", "ES", time() + 3600, "/");
} elseif ($idioma == "EN") {
    setcookie("Idioma", "EN", time() + 3600, "/");
}
header("Location: panel.php");
exit();
?>