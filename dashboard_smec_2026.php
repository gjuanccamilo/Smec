<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Opciones</title>
    <style>
       /* =========================================================
   OPCIÓN 1: EDITORIAL LUXURY
   Mantiene exactos todos tus selectores y media queries
   ========================================================= */

@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

:root {
    --color-primary: #D45B7A;
    --color-primary-light: #FBF0F3;
    --color-dark: #0F0F11;
    --color-text: #222225;
    --color-bg-card: #FAFAFB;
    --color-white: #FFFFFF;
    
    --shadow-sm: 0 4px 14px rgba(15, 15, 17, 0.03);
    --shadow-md: 0 8px 24px rgba(15, 15, 17, 0.06);
    --shadow-hover: 0 12px 28px rgba(212, 91, 122, 0.18);
    --border-radius: 10px;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background-color: var(--color-bg-card);
    color: var(--color-text);
    text-align: center;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    letter-spacing: 0.2px;
}

.banner {
    background-color: var(--color-dark);
    color: var(--color-white);
    padding: 24px 15px;
    font-family: 'Cormorant Garamond', serif;
    font-size: 26px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-bottom: 3px solid var(--color-primary);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

header {
    background-color: var(--color-white);
    padding: 18px 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    box-shadow: var(--shadow-sm);
    flex-wrap: wrap;
    border-bottom: 1px solid rgba(212, 91, 122, 0.12);
}

.header-btn {
    text-decoration: none;
    background-color: var(--color-primary-light);
    color: var(--color-primary);
    padding: 10px 22px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 0.5px;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    border: 1px solid rgba(212, 91, 122, 0.2);
}

.header-btn:hover {
    background-color: var(--color-primary);
    color: var(--color-white);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(212, 91, 122, 0.25);
}

.container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
}

.button-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    max-width: 950px;
    gap: 22px;
}

.row {
    display: flex;
    justify-content: center;
    width: 100%;
    gap: 20px;
}

.button {
    flex: 1;
    min-width: 0;
    padding: 26px 16px;
    background-color: var(--color-white);
    color: var(--color-text);
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    border-radius: var(--border-radius);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: var(--shadow-sm);
    text-align: center;
    border: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    justify-content: center;
    word-break: break-word;
}

.button:hover {
    background-color: var(--color-white);
    color: var(--color-primary);
    border-color: var(--color-primary);
    transform: translateY(-50px 0 0 0); /* Mantiene la animación limpia */
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

footer {
    background-color: var(--color-dark);
    padding: 22px 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    border-top: 3px solid var(--color-primary);
    flex-wrap: wrap;
    margin-top: auto;
}

.social {
    text-decoration: none;
    color: var(--color-white);
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.social:hover {
    color: var(--color-primary);
}

.social img {
    width: 20px;
    height: 20px;
    vertical-align: middle;
    filter: brightness(0) invert(1);
    transition: transform 0.3s ease;
}

.social:hover img {
    transform: scale(1.15);
}

.cata {
    font-size: 13px;
    color: var(--color-primary);
    font-weight: 700;
    letter-spacing: 0.5px;
}

/* Responsive Media Queries Preservadas */
@media (max-width: 768px) {
    .row {
        flex-wrap: wrap;
        gap: 12px;
    }

    .button {
        flex: 1 1 calc(50% - 12px);
        padding: 20px 12px;
        font-size: 14px;
    }

    .banner {
        font-size: 20px;
        padding: 18px 10px;
    }
}

@media (max-width: 480px) {
    header {
        flex-direction: column;
        width: 100%;
        gap: 10px;
    }

    .header-btn {
        width: 90%;
        text-align: center;
    }

    .row {
        flex-direction: column;
        gap: 12px;
    }

    .button {
        width: 100%;
        flex: 1 1 100%;
        padding: 18px;
    }

    footer {
        flex-direction: column;
        gap: 14px;
    }

    .social img {
        width: 22px;
        height: 22px;
        object-fit: contain;
        vertical-align: middle;
    }
}
        
    </style>
</head>
<body>
    <?php
        session_start();
    
      try {
          //Interfaz de conexion
          $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', ''); 
          
      } catch (PDOException $e) {
          //Casa de que ocurra algun error
          echo "Fallo la conexion ".$e->getMessage();
      }
      // Consulta SELECT
      if(empty($_SESSION)){
        $_SESSION['id']=1;
      }
    $consulta = "SELECT a.identificacion, a.nombres, a.tipo_persona, b.descripcion FROM persona a, tipo_persona b where a.tipo_persona = b.cod_tipo_persona and a.identificacion='".$_SESSION['id']."';";
    //$consulta = "SELECT a.id_persona, a.nombre, a.tipo_persona, b.descripcion FROM persona a, tipo_persona b where a.tipo_persona = b.tipo_persona and a.id_persona='01';";
  
      // Preparar la consulta
      $row = $conexion -> prepare($consulta);
  
      // Ejecutar la consulta
      $row->execute();
              // Obtener los resultados en un array asociativo
      $resultados = $row->fetchAll(PDO::FETCH_ASSOC);

      foreach ($resultados as $fila) {
        echo "BIENVENIDO".$_SESSION['usuario']." Usted es: ".$fila['descripcion'];
      }
     
        ?>
    <div class="banner">DASHBOARD SMEC</div>
    <header>
        <a href="usuypass2.php" class="header-btn">Login</a>
         <a href="registrese.php" class="header-btn">Regístrese</a>
        <a href="inicio.php" class="header-btn">Regresar a Inicio</a>
        
        
       

    </header>
    <div class="container">
        <div class="button-container">
            <div class="row">
                <a href="http://localhost/persona_smec.php" class="button">Persona</a>
                <a href="http://localhost/tipo_persona.php" class="button">Tipo de persona</a>
                <a href="http://localhost/ciudadsmec.php" class="button">Ciudad</a>
            </div>
            <div class="row">
             <a href="http://localhost/producto_servicio.php" class="button">Producto y Servicio</a>
             <a href="http://localhost/genero_smec.php" class="button">Genero</a>   
             <a href="http://localhost/agenda.php" class="button">Agenda</a>   
            </div>  
            <div class="row">
                <a href="http://localhost/factura_kitty2.php" class="button">Factura</a>
                <a href="http://localhost/tipo_producto_servicio.php" class="button">Tipo Producto y Servicio</a>
                <a href="http://localhost/clasificacion.php" class="button">Clasificación</a>
            </div>
            

        </div>
    </div>
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



