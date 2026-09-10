<?php
try {
    $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', '');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fallo la conexión: " . $e->getMessage());
}
try {
    //Variables...
    $vcod_tipo_persona = $_POST['cod_tipo_persona'];
    $vdescripcion = $_POST['descripcion'];


$insertar = $conexion->prepare("insert into tipo_persona(
        cod_tipo_persona,
        descripcion)
        values (:A,:B)");
        

    $insertar->bindParam(':A', $vcod_tipo_persona);
    $insertar->bindParam(':B', $vdescripcion);

    $insertar->execute();
    header("location:tipo_persona.php");//al read de perso
    }

catch (PDOException $e) {
            //Error;
            $error= $e->getCode();
        
            if ($error==23000){
              echo '<script>confirmar=confirm("Ese codigo de persona ya existe");
                      if (confirmar)
                        window.location.href="tipo_persona.php";</script>';
                      echo "<a href=tipo_persona.php>Volver</a>";
            }else{
              echo 'Error' . $e->getMessage();
              echo 'Error' . $e->getCode();
              echo "<a href=tipo_persona.php>Volver</a>";// AL READ DE PERSONA
            }  
        }
?>