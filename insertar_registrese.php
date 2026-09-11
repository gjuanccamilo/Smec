<?php
include_once "conexion.php";
session_start();

try {

    // Recibir datos del formulario
    $videntificacion = $_POST['identificacion'];
    $vnombre = $_POST['nombres'];
    $vapellidos = $_POST['apellidos'];
    $vcorreo = $_POST['correo'];
    $vclave = $_POST['password'];
    $vtipo_per = $_POST['tipo_persona'];
    $vfecha_nacimiento = $_POST['fecha_nacimiento'];
    $vtelefono = $_POST['telefono'];
    $vdireccion = $_POST['direccion'];
    $vciudad_nacimiento = $_POST['ciudad_nacimiento'] ?? '';
    
    if (empty($vciudad_nacimiento)) {
        die("Error: No se recibió una ciudad de nacimiento válida. Verifique que haya ciudades en la tabla 'ciudad' y que haya seleccionado una.");
    }
    $vgenero = $_POST['genero'];

    // Fechas automáticas (asignadas por el sistema)
    // Se usa 'Y-m-d H:i:s' para guardar Fecha y Hora. Si solo necesitas fecha usa 'Y-m-d'
    $vfecha_creacion = date('Y-m-d H:i:s');
    $vfecha_actualizacion = date('Y-m-d H:i:s');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {

        // Ruta para guardar el archivo de foto física
        $target_dir = "C:/xampp/htdocs/img/";

        // Concateno con el nombre del archivo
        // para guardar el archivo físico
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);


        // Ruta para guardar en el registro de la base de datos
        $foto_guardar = "http://localhost/img/";

        // Concateno con el nombre para guardar en la base de datos
        $target_file1 = $foto_guardar . basename($_FILES["foto"]["name"]);


        // ==========================================
        // VERIFICAR QUE SEA UNA IMAGEN
        // ==========================================

        $check = getimagesize($_FILES["foto"]["tmp_name"]);

        if ($check === false) {
            echo "El archivo no es una imagen.";
            exit;
        }


        // ==========================================
        // VERIFICAR TAMAÑO
        // ==========================================

        if ($_FILES["foto"]["size"] > 5000000) {
            echo "El archivo es demasiado grande.";
            exit;
        }


        // ==========================================
        // MOVER EL ARCHIVO
        // ==========================================

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {

            $foto_path = $target_file;

            echo "El archivo se ha subido correctamente: " . $foto_path;

        } else {

            echo "Hubo un error al subir el archivo.";
            exit;

        }

    } else {

        echo "No se seleccionó ninguna foto.";
        exit;

    }


    // ==========================================
    // FOTO QUE SE GUARDARÁ EN MYSQL
    // ==========================================

    $vfoto = $target_file1;

    // Iniciar sesión
    $_SESSION['usuario'] = $videntificacion;
    $_SESSION['tipo_persona'] = $vtipo_per;
    $_SESSION['id'] = $videntificacion;

    // Insertar en la tabla persona
    $insertar = $conexion->prepare("
        INSERT INTO persona(
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
            genero
        )
        VALUES (
            :identificacion,
            :nombres,
            :apellidos,
            :correo,
            :fecha_nacimiento,
            :fecha_creacion,
            :telefono,
            :direccion,
            :tipo_persona,
            :ciudad_nacimiento,
            :contrasena,
            :foto,
            :fecha_actualizacion,
            :genero
        )
    ");

    $insertar->bindParam(':identificacion', $videntificacion);
    $insertar->bindParam(':nombres', $vnombre);
    $insertar->bindParam(':apellidos', $vapellidos);
    $insertar->bindParam(':correo', $vcorreo);
    $insertar->bindParam(':fecha_nacimiento', $vfecha_nacimiento);
    $insertar->bindParam(':fecha_creacion', $vfecha_creacion);
    $insertar->bindParam(':telefono', $vtelefono);
    $insertar->bindParam(':direccion', $vdireccion);
    $insertar->bindParam(':tipo_persona', $vtipo_per);
    $insertar->bindParam(':ciudad_nacimiento', $vciudad_nacimiento);
    $insertar->bindParam(':contrasena', $vclave);
    $insertar->bindParam(':foto', $vfoto);
    $insertar->bindParam(':fecha_actualizacion', $vfecha_actualizacion);
    $insertar->bindParam(':genero', $vgenero);

    $insertar->execute();

    // Ir al login
    header("Location: usuypass2.php");
    exit();

} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();

}
?>