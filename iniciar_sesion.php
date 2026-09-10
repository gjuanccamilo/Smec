<?php
session_start();

if (empty($_SESSION)) {
    echo "No hay sesion";
}
else {
    echo "Usuario conectado";
}
echo '<a href="cerrar_sesion.php">Cerrar sesion </a>';
?>