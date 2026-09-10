<?php
//include_once "conexionpais.php";

try {
  //Interfaz de conexion
  $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', ''); 
 
} catch (PDOException $e) {
  //Casa de que ocurra algun error
   echo "Fallo la conexión ".$e->getMessage();
}

try {
    //Variables...
$vcodigo = filter_var($_POST['codigo']);
$vpais = filter_var($_POST['pais']);
$vsurface = filter_var($_POST['surface']);
$vyear = filter_var($_POST['year']);
$vpob = filter_var($_POST['pob']);
$vgnp = filter_var($_POST['gnp']);
$vcapital = filter_var($_POST['cap']);
$vregion = filter_var($_POST['reg']);
$vcontinente = filter_var($_POST['cont']);


$update = $conexion->prepare("UPDATE country SET Name = :A, SurfaceArea = :B, Indepyear=:C, Population=:D, GNP=:E, Capital=:F, regionid=:G, continent=:H
  WHERE code = :claveprimaria");

//Code,Name,SurfaceArea,IndepYear,Population, GNP,Capital, regionid,continent

$update->bindParam(':A', $vpais);
$update->bindParam(':B', $vsurface);
$update->bindParam(':C', $vyear);
$update->bindParam(':D', $vpob);
$update->bindParam(':E', $vgnp);
$update->bindParam(':F', $vcapital);
$update->bindParam(':G', $vregion);
$update->bindParam(':H', $vcontinente);
$update->bindParam(':claveprimaria', $vcodigo);


$update->execute();

header("location: Conexion_2024_Read.php");
exit();

} catch (PDOException $e) {
    //Error;
    echo 'Error' . $e->getMessage();
}
