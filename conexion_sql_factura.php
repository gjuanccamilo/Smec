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
$vno_factura = filter_var($_POST['no_factura']);
$vcliente = filter_var($_POST['cliente']);
$vfecha = filter_var($_POST['fecha']);
$vnotas = filter_var($_POST['notas']);


$update = $connec->prepare("UPDATE factura SET cliente = :A, fecha = :B, notas = :C
WHERE no_factura = :claveprimaria");



$update->bindParam(':A', $vcliente);
$update->bindParam(':B', $vfecha);
$update->bindParam(':C', $vnotas);
$update->bindParam(':claveprimaria', $vno_factura);


$update->execute();

header("location: factura_smec.php");
exit();

} catch (PDOException $e) {
    //Error;
    echo 'Error' . $e->getMessage();
}