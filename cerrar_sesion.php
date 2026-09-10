<?php
session_start();
if (empty($_SESSION)) {
    // La variable de sesion no esta definida, es decir, la sesion no ha sido iniciada
    header ("location: usuypass2.php");  //pantalla de inicio de sesion

    exit;
    } else {
    // La variable de sesion esta definida, es decir, la sesion ha sido iniciada
    session_unset();
    session_destroy();
    header ("location: usuypass2.php");
    exit;

}

echo '<a href="iniciar_sesion.php">Verifique la sesion </a>';
?>