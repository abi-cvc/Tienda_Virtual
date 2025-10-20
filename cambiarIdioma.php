<?php
$idioma = $_GET['idioma'];
if ($idioma == "ES") {
    setcookie("Idioma", "ES", time() + 3600, "/");
} elseif ($idioma == "EN") {
    setcookie("Idioma", "EN", time() + 3600, "/");
}
$previous_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'panel.php';
header("Location: " . $previous_page);
exit();
?>