<?php



$conexion = mysqli_connect("localhost", "root", "", "bd_glow_smec");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}




$mensaje="";

if(isset($_POST["buscar"])){

$correo=$_POST["correo"];

$sql="SELECT * FROM persona WHERE correo='$correo'";

$resultado=mysqli_query($conexion,$sql);

if(mysqli_num_rows($resultado)>0){

header("Location:nueva_password.php?correo=".$correo);

}else{

$mensaje="El correo no existe.";

}

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Recuperar contraseña</title>

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
    h2 {
    font-family: var(--font-heading); /* Cambia la fuente a Playfair Display */
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 1.5rem;
    color: var(--color-dark);
    margin-bottom: 20px;
    text-align: center;
}
        .nav-buttons {
            grid-column: 3;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
        }

        .nav-buttons a {
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

        .nav-buttons a:hover {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: var(--color-white);
        }

        /* ================= FORMULARIO ANCHO ================= */
        form {
            background-color: var(--color-white);
            border: var(--border-elegant);
            padding: 45px 40px;
            width: 500px;
            max-width: 650px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(4, 4, 10, 0.05);
            margin: 10px auto 0;
            display: flex;
            flex-direction: column;
        }
        #letra{
            font-family: var(--font-heading);
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
        input[type="email"] {
            width: 100%;
            padding: 12px 16px;
            margin-top: 8px;
            border: var(--border-elegant);
            border-radius: 20px;
            font-family: var(--font-body);
            font-size: 14px;
            outline: none;
            background-color: var(--color-white);
            color: var(--color-text);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="email"]:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 8px rgba(212, 91, 122, 0.25);
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
            font-size: 12px;
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

        .mensaje-error {
            margin-top: 15px;
            color: #d9534f;
            font-size: 13px;
            font-weight: 500;
            text-align: center;
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
</head>



<body>
<header>
    <!-- Logo/Texto a la izquierda -->
    <div class="logo-glowsmec">
        <a href="inicio.php">GLOW<span>SMEC</span></a>
    </div>
    <div class="nav-buttons">
        <a href="inicio.php" class="header-btn">Inicio</a>
    </div>
</header>
<h2>Recuperar contraseña</h2>

<form id=letra method="POST">

Correo electrónico

<input
type="email"
name="correo"
required>

<br><br>

<input
type="submit"
name="buscar"
value="Continuar">

</form>

<br>

<?php

echo $mensaje;

?>

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
