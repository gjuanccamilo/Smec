<?php
$conexion = mysqli_connect("localhost", "root", "", "bd_glow_smec");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

include("conexion.php");

$correo = isset($_GET["correo"]) ? $_GET["correo"] : '';
$mensaje = "";

if (isset($_POST["guardar"])) {
    $password = $_POST["password"];
    $confirmar = $_POST["confirmar"];

    if ($password == $confirmar) {
        $sql = "UPDATE persona SET password ='$password' WHERE correo ='$correo'";
        mysqli_query($conexion, $sql);

        echo "<script>
        alert('Contraseña actualizada');
        window.location='usuypass2.php';
        </script>";
    } else {
        $mensaje = "Las contraseñas no coinciden.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña | GlowSmec</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;1,400&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Paleta Oficial GlowSmec */
            --color-primary: #D45B7A;       /* Rosa Principal */
            --color-primary-light: #FBE2E8; /* Rosa Suave */
            --color-dark: #0B0B0C;          /* Negro Profundo Header/Footer */
            --color-text: #1C1C1C;          /* Texto Oscuro */
            --color-bg: #F8F8F9;            /* Fondo General */
            --color-white: #FFFFFF;         /* Blanco */
            
            --font-heading: 'Playfair Display', 'Didot', serif;
            --font-body: 'Montserrat', 'Helvetica Neue', sans-serif;
            
            --shadow-card: 0 10px 30px rgba(11, 11, 12, 0.08);
            --shadow-focus: 0 0 12px rgba(212, 91, 122, 0.25);
            --shadow-btn: 0 4px 15px rgba(212, 91, 122, 0.3);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body, html {
            min-height: 100vh;
            font-family: var(--font-body);
            background-color: var(--color-bg);
            color: var(--color-text);
        }

        /* ================= HEADER IDÉNTICO ================= */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background-color: var(--color-dark);
            color: var(--color-white);
            padding: 0 30px;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid var(--color-primary);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        /* 1. Logo a la izquierda */
        .logo-glowsmec {
            display: flex;
            align-items: center;
        }

        .logo-glowsmec a {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--color-white);
            text-decoration: none;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .logo-glowsmec a span {
            color: var(--color-primary);
        }

        /* 2. Título centrado absoluto */
        header h1 {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-family: var(--font-heading);
            font-weight: 400;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 1.4rem;
            color: var(--color-white);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            white-space: nowrap;
            margin: 0;
        }

        /* 3. Botones a la derecha */
        .nav-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-buttons a {
            text-decoration: none;
            padding: 8px 18px;
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

        /* ================= CONTENEDOR PRINCIPAL ================= */
        main {
            padding-top: 70px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-left: 20px;
            padding-right: 20px;
            box-sizing: border-box;
        }

        /* ================= FORMULARIO ================= */
        form {
            width: 100%;
            max-width: 500px;
            background-color: var(--color-white);
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: var(--shadow-card);
        }

        label {
            display: block;
            margin-top: 16px;
            margin-bottom: 6px;
            font-family: var(--font-body);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-size: 11px;
            color: var(--color-text);
        }

        input[type="password"] {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #E2E2E5;
            border-radius: 10px;
            font-family: var(--font-body);
            font-size: 13px;
            color: var(--color-text);
            background-color: var(--color-white);
            outline: none;
            transition: all 0.3s ease;
        }

        input[type="password"]:focus {
            border-color: var(--color-primary);
            box-shadow: var(--shadow-focus);
        }

        /* Botón Principal (Guardar) */
        input[type="submit"] {
            margin-top: 30px;
            width: 100%;
            padding: 13px 20px;
            background-color: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-btn);
        }

        input[type="submit"]:hover {
            background-color: var(--color-dark);
            box-shadow: 0 6px 18px rgba(11, 11, 12, 0.3);
        }

        /* Botón Secundario */
        .btn-secondary {
            display: block;
            margin-top: 12px;
            width: 100%;
            padding: 13px 20px;
            background-color: transparent;
            color: var(--color-text);
            border: 1px solid #E2E2E5;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: var(--color-primary-light);
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        /* Alerta de Error */
        .error-message {
            margin-top: 15px;
            padding: 12px;
            background-color: #FEE2E2;
            color: #DC2626;
            border-radius: 10px;
            font-size: 12px;
            text-align: center;
            font-weight: 500;
        }

        /* ================= ADAPTABILIDAD ================= */
        @media (max-width: 850px) {
            header {
                height: auto;
                padding: 15px;
                flex-direction: column;
                gap: 12px;
                position: relative;
            }
            header h1 {
                position: static;
                transform: none;
            }
            main {
                padding-top: 20px;
                min-height: calc(100vh - 120px);
            }
            .nav-buttons {
                justify-content: center;
                width: 100%;
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>

<header>
    <!-- Logo a la izquierda -->
    <div class="logo-glowsmec">
        <a href="inicio.php">GLOW<span>SMEC</span></a>
    </div>

    <!-- Título al centro -->
    <h1>Nueva Contraseña</h1>

    <!-- Botones a la derecha -->
    <div class="nav-buttons">
        <a href="javascript:history.back()">Regresar</a>
        <a href="usuypass2.php">Inicio</a>
    </div>
</header>

<main>
    <form method="POST">
        <label for="password">Nueva contraseña</label>
        <input type="password" id="password" name="password" required>

        <label for="confirmar">Confirmar contraseña</label>
        <input type="password" id="confirmar" name="confirmar" required>

        <input type="submit" name="guardar" value="Guardar">
        <a href="usuypass2.php" class="btn-secondary">Volver al login</a>

        <?php if (!empty($mensaje)): ?>
            <div class="error-message">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
    </form>
</main>

</body>
</html>