<?php
session_start();

$_SESSION ['id'] = '12345';   #Dato caracter, varchar, textoo
$_SESSION ['usuario'] = 'Juan perez'; #Dato caracter, varchar, textoo
$_SESSION ['tipo_persona'] = '01'; #Dato caracter, varchar, textoo
$_SESSION ['edad'] = 18; #Dato numerico
$_SESSION ['direccion'] = '';


echo '<a href="mostrar_sesion.php">Mostrar variables de sesion </a>';
?>