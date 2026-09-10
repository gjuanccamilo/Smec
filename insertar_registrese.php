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

    // Fechas automáticas

    
    $vfecha_actualizacion =  $_POST['fecha_actualizacion'];
    // date('Y-m-d H:i:s');

    $vfecha_creacion=$_POST['fecha_creacion_usuario'];
    
    //= date('Y-m-d H:i:s');

    // Foto por defecto
    $vfoto = 'foto';

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