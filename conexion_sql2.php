<?php
//include_once "conexionpais.php";
$connec = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', ''); 
try {
  //Interfaz de conexion
  $connec = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', ''); 
 
} catch (PDOException $e) {
  //Caso de que ocurra algun error
   echo "Fallo la conexión ".$e->getMessage();
}

try {
    //Variables...
$vcod_ciudad = filter_var($_POST['cod_ciudad']);
$vdescripcion = filter_var($_POST['descripcion']);



$update = $connec->prepare("UPDATE ciudad SET descripcion = :A
WHERE cod_ciudad = :claveprimaria");



$update->bindParam(':A', $vdescripcion);
$update->bindParam(':claveprimaria', $vcod_ciudad);


$update->execute();

header("location: ciudadsmec.php");
exit();

} catch (PDOException $e) {
    //Error;
    echo 'Error' . $e->getMessage();
}