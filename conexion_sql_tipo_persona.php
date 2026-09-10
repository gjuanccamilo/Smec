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
$vcod_tipo_persona = filter_var($_POST['cod_tipo_persona']);
$vdescripcion = filter_var($_POST['descripcion']);


$update = $connec->prepare("UPDATE tipo_persona SET descripcion = :A
WHERE cod_tipo_persona = :claveprimaria");



$update->bindParam(':A', $vdescripcion);
$update->bindParam(':claveprimaria', $vcod_tipo_persona);


$update->execute();

header("location: tipo_persona.php");
exit();

} catch (PDOException $e) {
    //Error;
    echo 'Error' . $e->getMessage();
}