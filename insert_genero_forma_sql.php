<?php
try {
    $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', '');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fallo la conexión: " . $e->getMessage());
}
try {
    //Variables...
    $vcod_genero = $_POST['cod_genero'];
    $vdescripcion = $_POST['descripcion'];

$insertar = $conexion->prepare("insert into genero(
        cod_genero,
        descripcion)
        values (:A,:B)");
        

    $insertar->bindParam(':A', $vcod_genero);
    $insertar->bindParam(':B', $vdescripcion);
    $insertar->execute();
    header("location:genero_smec.php");//al read de persona
    }

catch (PDOException $e) {
            //Error;
            $error= $e->getCode();
        
            if ($error==23000){
              echo '<script>confirmar=confirm("Ese codigo de persona ya existe");
                      if (confirmar)
                        window.location.href="genero_smec.php";</script>';
                      echo "<a href=genero_smec.php>Volver</a>";
            }else{
              echo 'Error' . $e->getMessage();
              echo 'Error' . $e->getCode();
              echo "<a href=genero_smec.php>Volver</a>";// AL READ DE PERSONA
            }  
        }
?>