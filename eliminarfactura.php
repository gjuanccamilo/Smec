<?php
//include_once "conexionpais.php";

//CONECTARME CON PDO

try {
    //Interfaz de conexion
    $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', ''); 
   
  } catch (PDOException $e) {
    //Casa de que ocurra algun error
     echo "Fallo la conexión ".$e->getMessage();
  }



try {
    //Variables...
$vcodigo = filter_var($_GET['code']);


$delete = $conexion->prepare("DELETE FROM factura WHERE no_factura = :codiguito");
$delete->bindParam(':codiguito', $vcodigo);
$delete->execute();

header("location: factura_smec.php");

} catch (PDOException $e) {
    //Error;
    $error = $e->getCode();
 
    
    if ($error==23000){
      echo '<script>confirmar=confirm("Ese tiene asociado registros no puede borrarse");
              if (confirmar)
                window.location.href="factura_smec.php";</script>';
              echo "<a href=factura_smec.php>Volver</a>";
    }else{
      echo 'Error' . $e->getMessage();
      echo 'Error' . $e->getCode();
      echo "<a href=factura_smec.php>Volver</a>";
    }


}
?>