<?php
session_start();

echo $_SESSION ['id'];   #Dato caracter, varchar, textoo
echo "<br>";
echo $_SESSION ['usuario']; #Dato caracter, varchar, textoo
echo "<br>";
echo $_SESSION ['tipo_persona']; #Dato caracter, varchar, textoo
echo "<br>";
echo $_SESSION ['edad']; #Dato numerico
echo "<br>";
echo $_SESSION ['direccion'];

echo "Yo soy una piraña re seria";
echo "<br>";
$variable = "Salome si es cabezona";
echo $variable;

echo "<br>";
echo '<a href="iniciar_sesion.php">Verifique la sesion </a>';
?>