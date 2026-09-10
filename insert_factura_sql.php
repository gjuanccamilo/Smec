<?php
try {
    $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', '');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fallo la conexión: " . $e->getMessage());
}
try {
    //Variables...
    $vnofactura = $_POST['no_factura'];
    $vcliente = $_POST['cliente'];
    $vfecha = $_POST['fecha'];
    $vnotas = $_POST['notas'];

$insertar = $conexion->prepare("insert into factura(
        no_factura,
        cliente, 
        fecha,
        notas)
        values (:A,:B,:C,:D)");
        

    $insertar->bindParam(':A', $vnofactura);
    $insertar->bindParam(':B', $vcliente);
    $insertar->bindParam(':C', $vfecha);
    $insertar->bindParam(':D', $vnotas);
    $insertar->execute();
    header("location:factura_smec.php");//al read de persona
    }

catch (PDOException $e) {
            //Error;
            $error= $e->getCode();
        
            if ($error==23000){
              echo '<script>confirmar=confirm("Ese numer de factura ya existe");
                      if (confirmar)
                        window.location.href="factura_smec.php";</script>';
                      echo "<a href=factura_smec.php>Volver</a>";
            }else{
              echo 'Error' . $e->getMessage();
              echo 'Error' . $e->getCode();
              echo "<a href=factura_smec.php>Volver</a>";// AL READ DE PERSONA
            }  
        }
?>