<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctenos</title>

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

    header h1, header h2 {
    font-family: var(--font-heading);
    font-weight: normal;
    letter-spacing: 2px;
    margin: 0 auto;
    text-align: center;
    text-transform: uppercase;
    font-size: 1.8rem;
    color: var(--color-white);
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);

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

    /* ================= MAIN & FORMULARIO ================= */
    main {
        padding: 120px 20px 100px 20px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex: 1;
    }

    form {
        background-color: var(--color-white);
        border: var(--border-elegant);
        padding: 35px 30px;
        width: 100%;
        max-width: 500px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(11, 11, 12, 0.05);
    }

    label {
        display: block;
        margin-top: 15px;
        font-family: var(--font-heading);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 12px;
        color: var(--color-dark);
    }

    input[type="text"],
    input[type="email"],
    select,
    textarea {
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
    input[type="email"]:focus,
    select:focus,
    textarea:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 8px rgba(212, 91, 122, 0.25);
    }

    textarea {
        resize: vertical;
    }

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

    /* ================= FOOTER ================= */
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
        filter: brightness(0) invert(1); /* Cambia los íconos a blanco */
    }

    @media (max-width: 850px) {
        header {
            grid-template-columns: 1fr;
            justify-items: center;
            padding: 15px;
            position: relative;
        }
        main {
            padding-top: 30px;
        }
        .nav-buttons {
            grid-column: 1;
            justify-content: center;
            width: 100%;
        }
    }
</style>
</head>
<body>

<header>
    <!-- Logo/Texto a la izquierda -->
    <div class="logo-glowsmec">
        <a href="inicio.php">GLOW<span>SMEC</span></a>
    </div>
    <div class="nav-buttons">
        <a href="usuypass2.php" class="header-btn">Login / Regístrese</a>
        <a href="inicio.php" class="header-btn">Inicio</a>
    </div>
    <h1>Contáctenos</h1>
</header>

<main>

  <form id='miforma' action='contactenos2.php' METHOD='POST'>

     <label for='asunto'>Asunto:</label>
     <select id="asunto" name="asunto">
            <option value="A">Queja</option>
            <option value="B">Reclamo</option>
            <option value="C">Pregunta-Sugerencia</option>
            
          </select>
          <br><br>

     <label for='nombre'>Nombres Completos:</label>
     <input type='text' id='nombre' name='nombre' value='' required><br><br>

     <label for='tel'>Teléfono:</label>
     <input type='text' id='tel' name='tel' value='' required><br><br>


     <label for='correo'>Su Correo Electrónico:</label>
     <input type='email' id='correo' name='correo' value='' required><br><br>


    <label for='mensaje'>Mensaje:</label>
     <textarea  id='mensaje' name='mensaje' rows="10" cols="30" value='' required></textarea>
     <br><br>

     <input id='boton' type='submit' value='Enviar' ><br><br>

    
        
</form>



</main>





<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $mensaje = $_POST["mensaje"];
    $correo = $_POST["correo"];
    $tel = $_POST["tel"];
    $tipo = $_POST["asunto"];

    $recibe = $correo . ",emsalazar755@gmail.com";

    $asunto = "Contacto con la empresa";

    $cuerpo = "
    Tipo: $tipo

    Nombre: $nombre

    Teléfono: $tel

    Correo: $correo

    Mensaje:
    $mensaje
    ";

    $headers = "From:emsalazar755@gmail.com";

    if(mail($recibe, $asunto, $cuerpo, $headers)){

        echo "<script>alert('Correo enviado correctamente');</script>";

    } else {

        echo "Error enviando correo";

    }
}

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

</body>
</html>

