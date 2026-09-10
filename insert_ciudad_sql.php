<?php
try {
    $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', '');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fallo la conexión: " . $e->getMessage());
}
try {
    //Variables...
    $vcod_ciudad = $_POST['cod_ciudad'];
    $vdescripcion_ciudad = $_POST['descripcion'];


$insertar = $conexion->prepare("insert into ciudad(
        cod_ciudad,
        descripcion)
        values (:A,:B)");
        

    $insertar->bindParam(':A', $vcod_ciudad);
    $insertar->bindParam(':B', $vdescripcion_ciudad);

    $insertar->execute();
    header("location:ciudadsmec.php");//al read de ciudad
    }

catch (PDOException $e) {
            //Error;
            $error= $e->getCode();
        
            if ($error==23000){
              echo '<script>confirmar=confirm("Ese codigo de persona ya existe");
                      if (confirmar)
                        window.location.href="ciudadsmec.php";</script>';
                      echo "<a href=ciudadsmec.php>Volver</a>";
            }else{
              echo 'Error' . $e->getMessage();
              echo 'Error' . $e->getCode();
              echo "<a href=ciudadsmec.php>Volver</a>";// AL READ DE PERSONA
            }  
        }
?>