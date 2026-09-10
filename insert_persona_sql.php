<?php
include_once "conexionpdo.php";

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
    $videntificacion = filter_var( $_POST['identificacion']);
    $vnombres = filter_var( $_POST['nombres']);
    $vapellidos = filter_var( $_POST['apellidos']);
    $vcorreo = filter_var( $_POST['correo']);
    $vfecha_nacimiento = filter_var( $_POST['fecha_nacimiento']);
    $vfecha_creacion_usuario = filter_var( $_POST['fecha_creacion_usuario']);
    $vtelefono = filter_var( $_POST['telefono']);
    $vdireccion = filter_var( $_POST['direccion']);
    $vtipo_persona = filter_var( $_POST['tipo_persona']);
    $vciudad_nacimiento = filter_var( $_POST['ciudad_nacimiento']);
    $vpassword = filter_var( $_POST['password']);
    $vfoto = $target_file1;
    $vfecha_actualizacion = filter_var( $_POST['fecha_actualizacion']);
    $vgenero = filter_var( $_POST['genero']);

$insertar = $conexion->prepare("insert into persona(
        identificacion,
        nombres,
        apellidos,
        correo,
        fecha_nacimiento, 
        fecha_creacion_usuario,
        telefono,
        direccion,
        tipo_persona,
        ciudad_nacimiento,
        password,
        foto,
        fecha_actualizacion,
        genero)
        values (:A,:B,:C,:D,:E,:F,:G,:H,:I,:J,:K,:L,:M,:N)");
        

    $insertar->bindParam(':A', $videntificacion);
    $insertar->bindParam(':B', $vnombres);
    $insertar->bindParam(':C', $vapellidos);
    $insertar->bindParam(':D', $vcorreo);
    $insertar->bindParam(':E', $vfecha_nacimiento);
    $insertar->bindParam(':F', $vfecha_creacion_usuario);
    $insertar->bindParam(':G', $vtelefono);
    $insertar->bindParam(':H', $vdireccion);
    $insertar->bindParam(':I', $vtipo_persona);
    $insertar->bindParam(':J', $vciudad_nacimiento);
    $insertar->bindParam(':K', $vpassword);
    $insertar->bindParam(':L', $vfoto);
    $insertar->bindParam(':M', $vfecha_actualizacion);
    $insertar->bindParam(':N', $vgenero);
    $insertar->execute();
    header("location:persona_smec.php");//al read de persona
    }

catch (PDOException $e) {
            //Error;
            $error= $e->getCode();
        
            if ($error==23000){
              echo '<script>confirmar=confirm("Ese codigo de persona ya existe");
                      if (confirmar)
                        window.location.href="persona_smec.php";</script>';
                      echo "<a href=persona_smec.php>Volver</a>";
            }else{
              echo 'Error' . $e->getMessage();
              echo 'Error' . $e->getCode();
              echo "<a href=persona_smec.php>Volver</a>";// AL READ DE PERSONA
            }  
        }

    
}

else{
  echo "llene el campo foto";
}
?>