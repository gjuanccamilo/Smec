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

//Se verifica que la solicitud sea POST y que el archivo haya sido subido.
if ($_SERVER['REQUEST_METHOD'] = 'POST' ) {

    if (!empty($_FILES['foto']['name'])) {
        // Ruta para guardar el archivo de foto física
        $target_dir = "C:/xampp/htdocs/img/";
        // Concateno con el nombre del archivo para guardar en el servidor el archivo físico
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);

        // Ruta para guardar en el registro de la base de datos
        $foto_guardar = "http://localhost/img/";
        // Concateno con el nombre para guardar en la base de datos
        $target_file1 = $foto_guardar . basename($_FILES["foto"]["name"]);

        // Verifica el tipo de archivo (por ejemplo, solo imágenes)
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check === false) {
            echo "El archivo no es una imagen.";
            exit();
        }

        // Verifica el tamaño del archivo (por ejemplo, máximo 5MB)
        if ($_FILES["foto"]["size"] > 5000000) {
            echo "El archivo es demasiado grande.";
            exit();
        }

        // Mueve el archivo a la ruta de destino
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $vfoto = $target_file1;
            echo "El archivo se ha subido correctamente: " . $target_file1;
        } else {
            echo "Hubo un error al subir el archivo.";
            exit();
        }
    } else {
        // Si no se subió una nueva foto, obtén la foto actual de la base de datos
        $matriz1 = $connec->query("SELECT foto FROM persona WHERE identificacion ='".$_POST['identificacion']."'");
        $row = $matriz1->fetch();
        $vfoto = $row['foto'];
    }

try {
    //Variables...
$videntificacion = filter_var($_POST['identificacion']);
$vnombres = filter_var($_POST['nombres']);
$vapellidos = filter_var($_POST['apellidos']);
$vcorreo = filter_var($_POST['correo']);
$vfecha_nacimiento = filter_var($_POST['fecha_nacimiento']);
$vfecha_creacion_usuario = filter_var($_POST['fecha_creacion_usuario']);
$vtelefono = filter_var($_POST['telefono']);
$vdireccion = filter_var($_POST['direccion']);
$vtipo_persona = filter_var($_POST['tipo_persona']);
$vciudad_nacimiento = filter_var($_POST['ciudad_nacimiento']);
$vpassword = filter_var($_POST['password']);
$vfecha_actualizacion = filter_var($_POST['fecha_actualizacion']);
$vgenero = filter_var($_POST['genero']);


$update = $connec->prepare("UPDATE persona SET nombres = :A, apellidos =:B, correo =:C, fecha_nacimiento=:D, fecha_creacion_usuario=:E, telefono=:F, direccion=:G, tipo_persona=:H, ciudad_nacimiento=:I, password=:J, foto=:K, fecha_actualizacion=:L, genero=:M
WHERE identificacion = :claveprimaria");



$update->bindParam(':A', $vnombres);
$update->bindParam(':B', $vapellidos);
$update->bindParam(':C', $vcorreo);
$update->bindParam(':D', $vfecha_nacimiento);
$update->bindParam(':E', $vfecha_creacion_usuario);
$update->bindParam(':F', $vtelefono);
$update->bindParam(':G', $vdireccion);
$update->bindParam(':H', $vtipo_persona);
$update->bindParam(':I', $vciudad_nacimiento);
$update->bindParam(':J', $vpassword);
$update->bindParam(':K', $vfoto);
$update->bindParam(':L', $vfecha_actualizacion);
$update->bindParam(':M', $vgenero);
$update->bindParam(':claveprimaria', $videntificacion);


$update->execute();

header("location: persona_smec.php");
exit();

} catch (PDOException $e) {
    //Error;
    echo 'Error' . $e->getMessage();
}
}