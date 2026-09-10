<?php

//Se verifica que la solicitud sea POST y que el archivo haya sido subido.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
  //ruta para guardar el archivo de foto física
  $target_dir = "C:/xampp/htdocs/img/";
  //concateno con el nombre del archivo para guardar en el servidor el archivo fisico
  $target_file = $target_dir . basename($_FILES["foto"]["name"]);

  //ruta para guardar en el registro de la base de datos
  $foto_guardar="http://localhost/img/";
  //concateno con el nombre para guardar en la base de datos
  $target_file1 = $foto_guardar . basename($_FILES["foto"]["name"]);
 
  
// Verifica el tipo de archivo (por ejemplo, solo imágenes)
  $check = getimagesize($_FILES["foto"]["tmp_name"]);
  if ($check === false) {
  echo "El archivo no es una imagen.";
  exit;
  }

// Verifica el tamaño del archivo (por ejemplo, máximo 5MB)
if ($_FILES["foto"]["size"] > 5000000) {
  echo "El archivo es demasiado grande.";
  exit;
}

// Mueve el archivo a la ruta de destino
if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
$foto_path = $target_file;
echo "El archivo se ha subido correctamente: " . $foto_path;
} else {
echo "Hubo un error al subir el archivo.";
}
try {
    $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', '');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fallo la conexión: " . $e->getMessage());
}
try {
    //Variables...
    $vcod_prod_ser=filter_var($_POST['cod_prod_ser']);
    $vdescripcion=filter_var($_POST['descripcion']);
    $vtipo_prod_ser=filter_var($_POST['tipo_prod_ser']);
    $vfecha_creacion=filter_var($_POST['fecha_creacion']);
    $vgenero_servicio=filter_var($_POST['genero_servicio']);	
    $vprecio=filter_var($_POST['precio']);
    $vclasificacion=filter_var($_POST['clasificacion']);
    $vfoto=$target_file1;
    

$insertar = $conexion->prepare("insert into producto_servicio(
        cod_prod_ser,
        descripcion,
        tipo_prod_ser,
        fecha_creacion,
        genero_servicio,
        precio,
        clasificacion,
        foto )
        values (:A,:B,:C,:D,:E,:F,:G,:H)");
        

    $insertar->bindParam(':A', $vcod_prod_ser);
    $insertar->bindParam(':B', $vdescripcion);
    $insertar->bindParam(':C', $vtipo_prod_ser);
    $insertar->bindParam(':D', $vfecha_creacion);
    $insertar->bindParam(':E', $vgenero_servicio);
    $insertar->bindParam(':F', $vprecio);
    $insertar->bindParam(':G', $vclasificacion);
    $insertar->bindParam(':H', $vfoto);
    $insertar->execute();
    header("location:producto_servicio.php");//al read de persona
    }

catch (PDOException $e) {
            //Error;
            $error= $e->getCode();
        
            if ($error==23000){
              echo '<script>confirmar=confirm("Ese codigo de persona ya existe");
                      if (confirmar)
                        window.location.href="producto_servicio.php";</script>';
                      echo "<a href=producto_servicio.php>Volver</a>";
            }else{
              echo 'Error' . $e->getMessage();
              echo 'Error' . $e->getCode();
              echo "<a href=producto_servicio.php>Volver</a>";// AL READ DE PERSONA
            }  
        }
}
else{
    echo"llene el campo foto";
}
?>