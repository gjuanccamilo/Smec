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
        $matriz1 = $connec->query("SELECT foto FROM producto_servicio WHERE cod_prod_ser ='".$_POST['cod_prod_ser']."'");
        $row = $matriz1->fetch();
        $vfoto = $row['foto'];
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


$update = $connec->prepare("UPDATE producto_servicio SET descripcion =:A,tipo_prod_ser=:B, fecha_creacion=:C, genero_servicio=:D, precio=:E, clasificacion=:F, foto=:G
WHERE cod_prod_ser = :claveprimaria");



    $update->bindParam(':A', $vdescripcion);
    $update->bindParam(':B', $vtipo_prod_ser);
    $update->bindParam(':C', $vfecha_creacion);
    $update->bindParam(':D', $vgenero_servicio);
    $update->bindParam(':E', $vprecio);
    $update->bindParam(':F', $vclasificacion);
    $update->bindParam(':G', $vfoto);
$update->bindParam(':claveprimaria', $vcod_prod_ser);


$update->execute();

if($update->rowCount()>0){
    echo "Registro actualizado correctamente";
}else{
    echo "No se actualizó ningún registro";
}

header("location: producto_servicio.php");
exit();

} catch (PDOException $e) {
    //Error;
    echo 'Error' . $e->getMessage();
}
}