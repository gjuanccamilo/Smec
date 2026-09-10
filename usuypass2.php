<?php
            session_start();
            
            echo "<h2>Usuario y Password</h2>";
            
            
            echo "<form id ='miforma' action='usuypass2.php'>";
            echo "<label for='username'>Identificacion:</label><br>";
            echo "<input type='text' id='username' name='username'><br>";
            echo "<label for='pwd'>Password:</label><br>";
            echo "<input type='password' id='pwd' name='pwd'><br><br>";
            echo "<a href='olvide_password.php'>¿Olvidaste tu contraseña?</a>";
            echo "<input type='submit' value='Submit'>";


            
            
            echo "</form>";
            echo  "<br>";
            echo  "<br>";
            echo  "<br>";
            
            
            
            if (empty($_GET['username'])){ 
              $vusuario='';
            }     
            else{
              $vusuario= $_GET['username'];
            }    




            if (empty($_GET['pwd'])){ 
              $vclave='';
            }     
            else{
              $vclave= $_GET['pwd'];
            }    
               
         


            if (empty($_GET['pwd']) && empty($_GET['username'])){ 
             

            }     
            else{
            
            

            // Este script es para conectarme a la BD
            $mysql_host = 'localhost';
            // user name es root
            $mysql_user = 'root';
            $password = '';
            // Esta es la función para conectarse usando el usuario y el password
            $dbhandle = mysqli_connect ($mysql_host, $mysql_user, $password) or die('Problemas de conexión con BD');
            $selected = mysqli_select_db($dbhandle, 'bd_glow_smec') or die("No se encontró el esquema");

            // Los datos se traen del servidor local

          

            //========================================================================================================

              //esta instruccion es para seleccionar todos los registros de la tabla y llevarlos
                      //a una matriz en la variable "result"
                      $result = mysqli_query($dbhandle,"select identificacion, nombres, tipo_persona, password clave from persona where identificacion = '".$vusuario."' and password = '".$vclave."';"); 

                      $vregistros=mysqli_num_rows($result);
                      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            
                      

              if ($vregistros>0){
                
                $_SESSION['id']=$row['identificacion'];
                $_SESSION['usuario']=$row['nombres'];
                $_SESSION['tipo_persona']=$row['tipo_persona'];
                
                if($row['tipo_persona']=='01'){
                header("location:dashboard_smec_2026.php");
                exit;
                }
                
                else{
                  header("location: inicio.php");
                exit;
                }
                
              }
              else{
                echo "<script>alert('usuario ó password no encontrado')</script>";
              }

                      
                  
            }               

?>

<html>
  <head>
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
        align-items: center;
        padding-top: 70px;
        padding-bottom: 80px;
    }

    /* ================= HEADER Y NAVEGACIÓN ================= */
    header {
    background-color: var(--color-dark);
    color: var(--color-white);
    padding: 15px 30px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    display: grid;
    grid-template-columns: 1fr auto 1fr; /* Distribuye Logo (Izq), Título (Centro), Botones (Der) */
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    border-bottom: 2px solid var(--color-primary);
}

    /* Logo a la izquierda */
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

    .nav-buttons, .header-buttons {
    position: absolute;
    right: 30px;
    display: flex;
    gap: 15px;
}

.nav-buttons a, .header-buttons button {
    text-decoration: none;
    background-color: transparent;
    color: var(--color-white);
    padding: 8px 18px;
    border: 1px solid var(--color-primary);
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    font-family: var(--font-body);
    transition: all 0.3s ease;
}

.nav-buttons a:hover, .header-buttons button:hover {
    background-color: var(--color-primary);
    color: var(--color-white);
    box-shadow: 0 0 12px rgba(212, 91, 122, 0.6);
}

    .nav-buttons {
        grid-column: 1;
        display: flex;
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

    /* ================= TÍTULOS DE LA PÁGINA ================= */
    h2 {
        font-family: var(--font-heading);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 1.5rem;
        color: var(--color-dark);
        margin: 20px 0 15px 0;
        text-align: center;
    }

    /* ================= FORMULARIO DE LOGIN ================= */
    form#miforma, form {
    background-color: var(--color-white);
    border: var(--border-elegant);
    padding: 45px 40px;
    width: 500px;
    max-width: 520px; /* <--- AUMENTA ESTE VALOR */
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(11, 11, 12, 0.05);
    margin: 10px auto 0;
    display: flex;
    flex-direction: column;
}

    label {
        display: block;
        margin-top: 15px;
        font-family: var(--font-heading);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 11px;
        color: var(--color-dark);
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px 14px;
        margin-top: 6px;
        border: var(--border-elegant);
        border-radius: 15px;
        font-family: var(--font-body);
        font-size: 13px;
        outline: none;
        background-color: var(--color-white);
        color: var(--color-text);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 8px rgba(212, 91, 122, 0.25);
    }

    /* Enlace de Olvidó Contraseña */
    form a {
        display: inline-block;
        margin-top: 15px;
        color: var(--color-primary);
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        text-align: center;
        transition: color 0.2s ease;
    }

    form a:hover {
        color: var(--color-dark);
        text-decoration: underline;
    }

    /* Botón Submit */
    input[type="submit"] {
        margin-top: 25px;
        width: 100%;
        padding: 12px 20px;
        background-color: var(--color-primary);
        color: var(--color-white);
        border: none;
        cursor: pointer;
        border-radius: 20px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        font-family: var(--font-body);
        transition: all 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: var(--color-dark);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Botón auxiliar inferior */
    input[type="button"] {
        margin: 15px auto 0;
        display: block;
        padding: 10px 20px;
        background-color: transparent;
        color: var(--color-dark);
        border: 1px solid var(--color-dark);
        cursor: pointer;
        border-radius: 20px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        font-family: var(--font-body);
        transition: all 0.3s ease;
    }

    input[type="button"]:hover {
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
        body {
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
<body>
  <header>
    <!-- Logo/Texto a la izquierda -->
    <div class="logo-glowsmec">
        <a href="inicio.php">GLOW<span>SMEC</span></a>
    </div>
    <div class="nav-buttons">
        <a href="registrese.php" class="header-btn">Regístrese</a>
        <a href="inicio.php" class="header-btn">Inicio</a>
        <a href="cerrar.php" class="header-btn">Cerrar Sesión</a>
    </div>
    <h1>Logín</h1>
</header>


<br>
<input type="button" onclick="location.href='registrese.php'" value="Volver al Registrese">

</body>

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
</html>