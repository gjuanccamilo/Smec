<?php
    ob_start();
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registrese</title>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;1,400&display=swap');

    :root {
        --color-primary: #D45B7A;
        --color-primary-light: #FBE2E8;
        --color-dark: #0B0B0C;
        --color-text: #1C1C1C;
        --color-bg-card: #F8F8F9;
        --color-white: #FFFFFF;
        --font-heading: 'Playfair Display', 'Didot', serif;
        --font-body: 'Montserrat', 'Helvetica Neue', sans-serif;
        --border-elegant: 1px solid rgba(212, 91, 122, 0.15);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body, html {
        min-height: 100vh;
        font-family: var(--font-body);
        background-color: var(--color-bg-card);
        color: var(--color-text);
        display: flex;
        flex-direction: column;
    }

    /* ================= HEADER Y NAVEGACIÓN ================= */
    header {
        background-color: var(--color-dark);
        color: var(--color-white);
        padding: 10px 30px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        border-bottom: 2px solid var(--color-primary);
    }

    .logo-glowsmec {
        display: flex;
        align-items: center;
    }

    .logo-glowsmec a {
        font-family: var(--font-heading);
        font-size: 1.6rem;
        font-weight: bold;
        color: var(--color-white);
        text-decoration: none;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .logo-glowsmec a span {
        color: var(--color-primary);
    }

    header h1 {
        grid-column: 2;
        font-family: var(--font-heading);
        font-weight: normal;
        letter-spacing: 2px;
        margin: 0 auto;
        text-align: center;
        text-transform: uppercase;
        font-size: 1.6rem;
        color: var(--color-white);
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        white-space: nowrap;
    }

    .nav-buttons {
        grid-column: 3;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }

    .nav-buttons a, .header-btn {
        text-decoration: none;
        padding: 8px 16px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 20px;
        background-color: transparent;
        color: var(--color-white);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 500;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .nav-buttons a:hover, .header-btn:hover {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: var(--color-white);
    }

    /* ================= CONTENEDOR PRINCIPAL ================= */
    main {
        padding: 80px 20px 100px 20px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }

    /* ================= FORMULARIO ================= */
    form {
        background-color: var(--color-white);
        border: var(--border-elegant);
        padding: 40px 35px;
        width: 100%;
        max-width: 580px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(11, 11, 12, 0.05);
        margin-top: 10px;
    }

    label {
        display: block;
        margin-top: 14px;
        font-family: var(--font-heading);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 11px;
        color: var(--color-dark);
    }
    
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="date"],
    select,
    textarea {
        width: 100%;
        padding: 10px 14px;
        margin-top: 5px;
        border: var(--border-elegant);
        border-radius: 15px;
        font-family: var(--font-body);
        font-size: 13px;
        outline: none;
        background-color: var(--color-white);
        color: var(--color-text);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 8px rgba(212, 91, 122, 0.25);
    }

    input[type="file"] {
        width: 100%;
        padding: 10px;
        font-size: 12px;
        border: 1px dashed var(--color-primary);
        border-radius: 10px;
        background-color: var(--color-primary-light);
        color: var(--color-text);
        cursor: pointer;
        transition: background 0.3s ease;
    }

    input[type="file"]:hover {
        background-color: #f7d0db;
    }

    input[type="submit"], .boton[type="submit"] {
        margin-top: 30px;
        width: 100%;
        padding: 12px 20px;
        background-color: var(--color-primary);
        color: var(--color-white);
        border: none;
        cursor: pointer;
        border-radius: 20px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        font-family: var(--font-body);
        transition: all 0.3s ease;
    }

    input[type="submit"]:hover, .boton[type="submit"]:hover {
        background-color: var(--color-dark);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Sección inferior de Login */
    .login {
        margin-top: 25px;
        text-align: center;
    }

    .login p {
        font-size: 13px;
        color: var(--color-text);
        margin-bottom: 8px;
    }

    .login a.boton {
        display: inline-block;
        padding: 8px 24px;
        background-color: transparent;
        color: var(--color-dark);
        border: 1px solid var(--color-dark);
        text-decoration: none;
        border-radius: 20px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .login a.boton:hover {
        background-color: var(--color-dark);
        color: var(--color-white);
    }

    /* ================= FOOTER GLOWSMEC ================= */
    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 15px;
        background-color: var(--color-dark);
        color: var(--color-white);
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 25px;
        border-top: 4px solid var(--color-primary);
        box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    .social {
        text-decoration: none;
        color: var(--color-white);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.3s ease;
    }

    .social:hover {
        color: var(--color-primary);
    }

    .social img {
        width: 20px;
        height: 20px;
        filter: brightness(0) invert(1);
    }

    @media (max-width: 850px) {
        header {
            grid-template-columns: 1fr;
            justify-items: center;
            padding: 15px;
            position: relative;
        }
        main {
            padding-top: 20px;
        }
        .nav-buttons {
            grid-column: 1;
            justify-content: center;
            width: 100%;
            flex-wrap: wrap;
        }
    }
</style>

</head>
<body>

<header>
    <div class="logo-glowsmec">
        <a href="inicio.php">GLOW<span>SMEC</span></a>
    </div>
    <div class="nav-buttons">
        <a href="usuypass2.php" class="header-btn">Logín</a>
        <a href="inicio.php" class="header-btn">Inicio</a>
        <a href="cerrar.php" class="header-btn">Cerrar Sesión</a>
    </div>
    <h1>Regístrese</h1>
</header>

    <main>
    
        <?php
        try {
            // Interfaz de conexion
            $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', ''); 
        } catch (PDOException $e) {
            echo "Fallo la conexion ".$e->getMessage();
        }

        // --- NOTA: Se eliminó el session_unset() para mantener la sesión del administrador activa ---

        echo '<form action="insertar_registrese.php" method="POST">';
        echo "<label for='identificacion'>Identificacion:</label>";
        echo "<input type='text' id='identificacion' name='identificacion' value=''><br><br>";
        echo "<br>";
        echo "<label for='nombres'>Nombre:</label>";
        echo "<input type='text' id='nombres' name='nombres' value=''><br><br>";
        echo "<br>";
        echo "<label for='apellidos'>Apellidos:</label>";
        echo "<input type='text' id='apellidos' name='apellidos' value=''><br><br>";
        echo "<br>";
        echo '<label for="correo">Correo:</label>';
        echo "<input type='email' id='correo' name='correo' value=''><br><br>";
        echo "<br>";
        echo "<label for='fecha_nacimiento'>Fecha de nacimiento:</label>";
        echo "<input type='date' id='fecha_nacimiento' name='fecha_nacimiento' value=''><br><br>";
        echo "<br>";
        echo "<label for='fecha_creacion_usuario'>Fecha de creacion del usuario:</label>";
        echo "<input type='date' id='fecha_creacion_usuario' name='fecha_creacion_usuario' value=''><br><br>";
        echo "<br>";
        echo "<label for='telefono'>Telefono:</label>";
        echo "<input type='text' id='telefono' name='telefono' value=''><br><br>";
        echo "<br>";
        echo "<label for='direccion'>Direccion:</label>";
        echo "<input type='text' id='direccion' name='direccion' value=''><br><br>";
        echo "<br>";
        echo "<label for='ciudad_nacimiento'>Ciudad de nacimiento:</label>";
        
        try {
            $matriz1 = $conexion->query("select cod_ciudad, descripcion from ciudad Order by cod_ciudad");
            
            echo "<select id='ciudad_nacimiento' name='ciudad_nacimiento'>";        
            while ($row = $matriz1->fetch()) {
                echo "<option value=".$row['cod_ciudad'].">".$row['cod_ciudad']." - ".$row['descripcion']."</option>";
            }
            echo "</select>";
        } catch (PDOException $e) {
            echo "Fallo el select ".$e->getMessage();
        }

        echo "<br><br>";
        echo "<label for='password'>Password:</label>";
        echo "<input type='password' id='password' name='password' value=''><br><br>";
        echo "<br>";
        echo "<label for='foto'>Foto:</label>";
        echo "<br>";
        echo "<input type='file' id='foto' name='foto' value=''><br><br>";
        echo "<br>";
        echo "<label for='fecha_actualizacion'>Fecha de actualizacion:</label>";
        echo "<br>";
        echo "<input type='date' id='fecha_actualizacion' name='fecha_actualizacion' value=''><br><br>";
        echo "<br>";
        echo "<label>Género:</label>";
        echo "<select name='genero'>
                <option value='02'>Masculino</option>
                <option value='01'>Femenino</option>
                <option value='03'>Otros</option>
              </select><br><br>";
        
        // =========================================================================
        // CONDICIÓN PARA MOSTRAR EL ROL
        // =========================================================================
        // Verifica si hay sesión y si el usuario logueado es Administrador ('01')
        if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === '01') {
            echo "<label for='tipo_persona'>Tipo de Persona :</label>";
            echo '<select id="tipo_persona" name="tipo_persona">
                    <option value="01">Administrador</option>
                    <option value="02">Trabajador</option>
                    <option value="03">Cliente</option>
                  </select>';
        } else {
            // Para el público general, se asigna automáticamente '03' (Cliente) de manera oculta
            echo '<input type="hidden" id="tipo_persona" name="tipo_persona" value="03">';
        }
        
        echo "<br>";
        echo '<input class="boton" type="submit" value="Registrarse">'; 
        echo '</form>';

        echo '<div class="login">';
        echo '<p> Si tiene usuario Ingrese </p>';
        echo '<a class="boton" href="usuypass2.php"> Login </a>';
        echo '</div>';
        ?>

<footer>
    <a href="https://web.facebook.com/?locale=es_LA&_rdc=1&_rdr#" class="social">
        <img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/facebook.svg" alt="Facebook" style="filter: invert(1);"> Facebook
    </a>
    <a href="https://x.com/?lang=es" class="social">
        <img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/x.svg" alt="Twitter" style="filter: invert(1);"> Twitter
    </a>
    <a href="https://www.instagram.com/" class="social">
        <img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/instagram.svg" alt="Instagram" style="filter: invert(1);"> Instagram
    </a>
    <a href="https://wa.me/3007764482" class="social">
        <img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/whatsapp.svg" alt="WhatsApp" style="filter: invert(1);"> WhatsApp
    </a>
</footer>
    </main>
</body>
</html>