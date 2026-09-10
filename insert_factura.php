<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Datos</title>
    <style>

   @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;1,400&display=swap');

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
    display: flex;
    flex-direction: column;
}

/* ================= HEADER (Alineación exacta en una sola línea) ================= */
header {
    background-color: var(--color-dark);
    color: var(--color-white);
    padding: 0 30px;
    height: 70px; /* Altura fija compacta */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: space-between; /* Logo a la izq, Botones a la der */
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

/* 2. Título centrado absoluto (evita saltos de línea) */
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

/* 3. Botones alineados a la derecha */
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
    padding: 100px 20px 60px 20px;
    width: 100%;
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ================= FORMULARIO ================= */
form {
    background-color: var(--color-white);
    border: 1px solid rgba(212, 91, 122, 0.15);
    padding: 40px 35px;
    width: 100%;
    max-width: 560px;
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

input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"],
select {
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

input:focus, select:focus {
    border-color: var(--color-primary);
    box-shadow: var(--shadow-focus);
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
}

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

/* ================= ADAPTABILIDAD ================= */
@media (max-width: 850px) {
    header {
        height: auto;
        padding: 15px;
        flex-direction: column;
        gap: 12px;
    }
    header h1 {
        position: static;
        transform: none;
    }
    main {
        padding-top: 20px;
    }
    .nav-buttons {
        justify-content: center;
        width: 100%;
        flex-wrap: wrap;
    }
}
</style>

<body>
<header>
    <header>
    <!-- Logo/Texto a la izquierda -->
    <div class="logo-glowsmec">
        <a href="inicio.php">GLOW<span>SMEC</span></a>
    </div>
    <div class="nav-buttons">
        <a href="javascript:history.back()">Regresar</a>
        <a href="dashboard_smec_2026.php">Inicio</a>
    </div>
    <h1>Insertar Factura</h1>
</header>
<main>
<form action= "insert_factura_sql.php" method="POST">

<?php

             try {
          //Interfaz de conexion
          $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', ''); 
          
      } catch (PDOException $e) {
          //Casa de que ocurra algun error
          echo "Fallo la conexion ".$e->getMessage();
      }

        echo "<label>Numero Factura:</label>";
        echo "<input type='text' id='no_factura' name='no_factura' value=''><br><br>";

        echo "<label for='cliente'>Identificación de cliente:</label>";
        //echo "<input type='text' id='cliente' name='cliente' value=''><br><br>";

         try {
            // Ejecutando sql
           
            $matriz1 = $conexion->query("select cliente from factura Order by cliente");
            
                    echo "<select id=cliente name=cliente>";        
                    while ($row = $matriz1->fetch()) {
                      echo "<option value=".$row['cliente'].">".$row['cliente']."</option>";
                      }
                    }
                  
                  catch (PDOException $e) {
                    //Casa de que ocurra algun error
                     echo "Fallo el select ".$e->getMessage();
                  }

                  echo "</select>";

        echo "<label for='fecha'>Fecha:</label>";
        echo "<input type='date' id='fecha' name='fecha' value=''><br><br>";

        echo "<label for='notas'>Notas:</label>";
        echo "<input type='text' id='notas' name='notas' value=''><br><br>";

        ?>

    <input type="submit" value="Insertar Factura">
    
    </form>
</main>
</body>
