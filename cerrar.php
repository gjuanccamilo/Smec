<?php


session_start();
if (empty($_SESSION)) {
   // La variable de sesión no está definida, es decir, la sesión no ha sido iniciada
    //echo "La sesión no ha sido iniciada";
    
    header("location: usuypass2.php");
   
    exit;
   
    } else {
   // La variable de sesión está definida, es decir, la sesión ha sido iniciada
   //echo "La sesión ha sido iniciada con el usuario: ".$_SESSION['id']." refresque para borrar";
   session_unset();
   session_destroy();
   header("location: usuypass2.php");
   exit;
   }






?>