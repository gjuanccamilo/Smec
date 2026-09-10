<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registrese</title>
    <link rel="stylesheet"= href="MA_estilo1.css">

  
</head>
<body>
    <main>
    <div class="contenedor">
        <section class="encabezado">
        <h1> Registrese </h1>
        </section>

        <section class="forma">
        <?php
            session_start();
         if (empty($_SESSION)) {
            // La variable de sesión no está definida, es decir, la sesión no ha sido iniciada
             //echo "La sesión no ha sido iniciada";
            
             } else {
            // La variable de sesión está definida, es decir, la sesión ha sido iniciada
            //echo "La sesión ha sido iniciada con el usuario: ".$_SESSION['id']." refresque para borrar";
           
            session_unset();
            
            }

            echo'<form action="insertar_registrese.php" method="POST">';
           
            echo "<br>";
        echo "<label>Identificacion:</label>";
        echo "<input type='text' id='identificacion' name='identificacion' value=''><br><br>";
        echo "<br>";
        echo "<label for='nombres'>Nombre:</label>";
        echo "<input type='text' id='nombres' name='nombres' value=''><br><br>";
        echo "<br>";
        echo "<label for='apellidos'>Apellidos:</label>";
        echo "<input type='text' id='apellidos' name='apellidos' value=''><br><br>";
        echo "<br>";
        echo '<label for="correo">Correo:</label>';
        echo"<input type='email' id='correo' name='correo'value=''><br><br>";
        echo "<br>";
        echo "<label for='fecha_nacimiento'>Fecha de nacimiento:</label>";
        echo "<input type='date' id='fecha_nacimiento' name='fecha_nacimiento' value=''><br><br>";
        echo "<br>";
        echo "<label for='fecha_creacion_usuario'>Fecha de creacion del usuario:</label>";
        echo "<input type='date' id='fecha_creacion_usuario' name='fecha_creacion_usuario' value=''><br><br>";
        echo "<br>";
        echo "<label for='telefono'>Telefono:</label>";
        echo "<input type='text' id='telefono' name='telefono'  value=''><br><br>";
        echo "<br>";
        echo "<label for='direccion'>Direccion:</label>";
        echo "<input type='text' id='direccion' name='direccion'  value=''><br><br>";
        echo "<br>";
        echo "<label for='tipo_persona'>Tipo persona:</label>";
        echo "<input type='text' id='tipo_persona' name='tipo_persona'  value=''><br><br>";
        echo "<br>";
        echo "<label for='ciudad_nacimiento'>Ciudad de nacimiento:</label>";
        echo "<input type='text' id='ciudad_nacimiento' name='ciudad_nacimiento'  value=''><br><br>";
        echo "<br>";
        echo "<label for='password'>Password:</label>";
        echo "<input type='text' id='password' name='password'  value=''><br><br>";
        echo "<br>";
        echo "<label for='foto'>Foto:</label>";
        echo "<input type='text' id='foto' name='foto'  value=''><br><br>";
        echo "<br>";
        echo "<label for='fecha_actualizacion'>Fecha de actualizacion:</label>";
        echo "<input type='date' id='fecha_actualizacion' name='fecha_actualizacion'  value=''><br><br>";
        echo "<br>";
        echo "<label for='genero'>Genero:</label>";
        echo "<input type='text' id='genero' name='genero'  value=''><br><br>";
        
            echo "<label for='tipo_persona'>Tipo de Persona :</label>";
        
            echo '<select id="tipo_per" name="tipo_per">
            <option value="01">barbero</option>
            <option value="02">estilista</option>
            <option value="03">manicurista</option>
            <option value="04">pedicurista</option>
            
            
            
          </select>';
         
            echo "<br>";

             echo'<input class="boton" type="submit" value="Registrarse">'; 
            echo '</form>';
            echo '<div class="login">';
                echo'<p> Si tiene usuario Ingrese </p>';
                       
                echo '<a class="boton" href="usuypass2.php"> Login </a>
                </a>';
            echo '</div>';
        ?>
        

        
        </section>
    </div>
    </main>
</body>
</html>