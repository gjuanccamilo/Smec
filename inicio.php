<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Punto De Venta</title>

    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="normalize.css">
    
    <style>
    /* =========================================================
       GLOWSMEC - NUEVA IDENTIDAD VISUAL (Paleta Oficial)
       ========================================================= */

    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;1,400&display=swap');

    :root {
        /* Paleta Oficial GlowSmec */
        --color-primary: #D45B7A;       /* Rosa Principal - Botones y acentos */
        --color-primary-light: #FBE2E8; /* Rosa Suave / Blush - Fondos secundarios */
        --color-dark: #0B0B0C;          /* Negro Profundo - Header, footer */
        --color-text: #1C1C1C;          /* Texto Oscuro - Títulos y descripciones */
        --color-bg-card: #F8F8F9;       /* Gris Neutro Claro - Tarjetas */
        --color-white: #FFFFFF;         /* Blanco Puro - Fondos generales */
        
        --color-border: rgba(212, 91, 122, 0.15); /* Borde elegante usando el rosa */
        --color-gray: #4A4A4A;          /* Gris oscuro para textos largos */

        --shadow-small: 0 4px 15px rgba(0, 0, 0, 0.05);
        --shadow-medium: 0 10px 25px rgba(0, 0, 0, 0.08);
        --shadow-large: 0 15px 30px rgba(212, 91, 122, 0.15);

        --radius-small: 4px;
        --radius-medium: 12px;
        --radius-large: 16px;
        
        --font-heading: 'Playfair Display', 'Didot', serif;
        --font-body: 'Montserrat', 'Helvetica Neue', sans-serif;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        width: 100%;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        font-family: var(--font-body);
        color: var(--color-text);
        background-color: var(--color-white);
        overflow-x: hidden;
        overflow-y: auto;
        letter-spacing: 0.3px;
    }

    h1, h2, h3 {
        font-family: var(--font-heading);
        letter-spacing: 0.5px;
        color: var(--color-text);
    }

    h1 { font-size: 32px; }
    h2 { font-size: 26px; }
    h3 { font-size: 20px; }

    p {
        font-size: 14px;
        line-height: 1.7;
        color: var(--color-gray);
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    /* ================= HEADER Y NAVEGACIÓN ================= */
    header {
        position: sticky;
        top: 0;
        width: 100%;
        padding: 12px 40px;
        background-color: var(--color-dark);
        color: var(--color-white);
        z-index: 1000;
        border-bottom: 2px solid var(--color-primary);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: space-between;
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

    /* Navegación y tamaño reducido de botones */
    nav {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 6px;
    }

    nav > a {
        position: relative;
        padding: 6px 10px;
        color: var(--color-white);
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        transition: all 0.3s ease;
        border-radius: var(--radius-small);
    }

    nav > a:hover {
        color: var(--color-primary);
        background-color: rgba(255, 255, 255, 0.05);
    }

    /* Botón de Carrito Mermado */
    nav > a:last-child {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-left: 8px;
        border: 1px solid var(--color-primary);
        background: transparent;
        border-radius: 20px;
        padding: 5px 14px;
        font-size: 11px;
        transition: all 0.3s ease;
    }

    nav > a:last-child:hover {
        background-color: var(--color-primary);
        box-shadow: 0 0 10px rgba(212, 91, 122, 0.5);
        color: var(--color-white) !important;
    }

    /* ================= CARRUSEL Y FONDO ================= */
    .foto_fondo {
        width: 100%;
        height: auto;
    }

    .carousel {
        position: relative;
        width: 100%;
        height: 450px;
        overflow: hidden;
        background-color: var(--color-dark);
    }

    .slides {
        display: flex;
        width: 100%;
        height: 100%;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .slides a {
        min-width: 100%;
        height: 450px;
        display: block;
    }

    .slides img {
        display: block;
        width: 100%;
        height: 450px;
        object-fit: cover;
        object-position: center;
        filter: brightness(0.85);
        transition: transform 0.8s ease;
    }

    .slides a:hover img {
        transform: scale(1.03);
    }

    .navigation {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        padding: 0 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .navigation button {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        background-color: var(--color-primary-light);
        color: var(--color-primary);
        font-size: 18px;
        cursor: pointer;
        pointer-events: auto;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-small);
    }

    .navigation button:hover {
        background-color: var(--color-primary);
        color: var(--color-white);
        transform: scale(1.1);
    }

    /* ================= PRODUCTOS/SERVICIOS ================= */
    .contenedor_productos {
        width: 100%;
        padding: 70px 8%;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        background-color: var(--color-white);
    }

    .servicio {
        width: 100%;
        min-height: 270px;
        padding: 35px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        background-color: var(--color-bg-card);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-medium);
        box-shadow: var(--shadow-small);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .servicio:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-large);
        border-color: var(--color-primary);
    }

    .servicio p {
        font-family: var(--font-heading);
        margin: 0 0 15px 0;
        color: var(--color-text);
        font-size: 20px;
        font-weight: 600;
        line-height: 1.3;
    }

    .imagen {
        margin: 10px 0 20px 0;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, var(--color-primary-light), var(--color-primary));
        box-shadow: var(--shadow-small);
    }

    .imagen img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--color-bg-card);
        transition: all 0.4s ease;
    }

    .servicio:hover .imagen img {
        transform: scale(1.05);
    }

    button.boton1 {
        padding: 8px 20px;
        margin-top: 10px;
        border: none;
        border-radius: 20px;
        background-color: var(--color-primary);
        color: var(--color-white);
        font-family: var(--font-body);
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button.boton1:hover {
        background-color: var(--color-dark);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* ================= SECCIÓN DE INFORMACIÓN Y MAPA ================= */
    section.info-glowsmec {
        width: 100%;
        padding: 70px 8%;
        background-color: var(--color-primary-light);
        text-align: center;
        border-top: 1px solid var(--color-border);
    }

    section.info-glowsmec h2 {
        margin-bottom: 20px;
        color: var(--color-text);
        font-size: 30px;
    }

    section.info-glowsmec p {
        max-width: 800px;
        margin: 0 auto;
        color: var(--color-text);
        font-size: 15px;
        line-height: 1.8;
    }

    section.info-glowsmec a {
        color: var(--color-primary);
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px solid var(--color-primary);
        padding-bottom: 2px;
        transition: color 0.3s ease, border-color 0.3s ease;
    }

    section.info-glowsmec a:hover {
        color: var(--color-dark);
        border-color: var(--color-dark);
    }

    section iframe {
        width: 100%;
        height: 400px;
        margin-top: 35px;
        border: none !important;
        border-radius: var(--radius-medium);
        box-shadow: var(--shadow-medium);
    }

    /* ================= FOOTER ================= */
    footer {
        width: 100%;
        padding: 35px 8%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        background-color: var(--color-dark);
        color: var(--color-white);
        border-top: 4px solid var(--color-primary);
    }

    footer a {
        color: var(--color-white);
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 12px;
        margin: 0 5px;
    }

    footer a:hover {
        color: var(--color-primary);
    }

    .social {
        display: inline-flex;
        align-items: center;
        margin: 5px 10px;
        color: var(--color-white);
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .social img {
        width: 18px;
        height: 18px;
        margin-right: 8px;
        filter: brightness(0) invert(1);
        transition: transform 0.3s ease;
    }

    .social:hover img {
        transform: scale(1.1);
    }

    /* ================= MEDIA QUERIES (RESPONSIVE) ================= */
    @media (max-width: 1100px) {
        header { padding: 12px 20px; }
        .contenedor_productos { padding: 50px 5%; gap: 20px; }
        .carousel, .slides a, .slides img { height: 380px; }
    }

    @media (max-width: 900px) {
        header { flex-direction: column; gap: 12px; padding: 15px; position: relative; }
        nav { flex-wrap: wrap; justify-content: center; gap: 4px; }
        nav > a { padding: 5px 8px; font-size: 10px; }
        .contenedor_productos { grid-template-columns: repeat(2, 1fr); }
        footer { flex-direction: column; text-align: center; }
    }

    @media (max-width: 600px) {
        .contenedor_productos { grid-template-columns: 1fr; }
        .carousel, .slides a, .slides img { height: 280px; }
        section.info-glowsmec { padding: 40px 20px; }
        section.info-glowsmec h2 { font-size: 24px; }
        section iframe { height: 280px; }
    }
    </style>
    
</head>

<body>
 <?php
      try {
          // Interfaz de conexion
          $conexion = new PDO('mysql:host=localhost;port=3306;dbname=bd_glow_smec;', 'root', ''); 
      } catch (PDOException $e) {
          echo "Fallo la conexion ".$e->getMessage();
      }

      if(!empty($_SESSION) && isset($_SESSION['id'])){
          // Consulta SELECT
          $consulta = "SELECT a.identificacion, a.nombres, a.tipo_persona, b.descripcion 
                       FROM persona a, tipo_persona b 
                       WHERE a.tipo_persona = b.cod_tipo_persona AND a.identificacion='".$_SESSION['id']."';";
      
          $row = $conexion->prepare($consulta);
          $row->execute();
          $resultados = $row->fetchAll(PDO::FETCH_ASSOC);

          foreach ($resultados as $persona){
              // Guardamos el tipo de persona en la sesión para validaciones globales
              $_SESSION['tipo_persona'] = $persona['tipo_persona'];
              echo "BIENVENIDO   ".$_SESSION['usuario']." Usted es: ".$persona['descripcion'];
          }
      }
 ?>

<header>
    <!-- Logo/Texto a la izquierda -->
    <div class="logo-glowsmec">
        <a href="inicio.php">GLOW<span>SMEC</span></a>
    </div>
    <nav>
        <a href="inicio.php">Inicio</a>
        <a href="sobre_nosotros.php">Sobre Nosotros</a>
        <a href="carrito1_kitty.php">Productos y Servicios</a>
        <a href="contactenos2.php">Contáctenos</a>
        <a href="usuypass2.php">Login/Regístrese</a>

        <?php 
        // Solo muestra el Dashboard si la sesión está activa y es Administrador ('01')
        if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === '01') { 
        ?>
            <a href="dashboard_smec_2026.php">Dashboard</a>
        <?php 
        } 
        ?>

        <a href="cerrar.php">Cerrar Sesión</a>

        <!-- Carrito de compras al final -->
        <a href="carrito1_kitty.php" style="display: inline-flex; align-items: center; gap: 8px; color: white; text-decoration: none; margin-left:15px;">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.75"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
              <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
              <path d="M17 17h-11v-14h-2" />
              <path d="M6 5l14 1l-1 7h-13" />
            </svg>
            Carrito
        </a>
    </nav>
</header>

<div class="foto_fondo">
    <section>
        <div class="carousel">
            <div class="slides">
                <a href="https://www.lorealprofessionnel.es/consejos-profesionales-beneficios-masaje-capilar">
                    <img class="media" src="https://www.gammabross.com/Gallery/salonimg-frkqkj-181.webp" alt="Imagen 1">
                </a>
                <a href="https://www.lorealprofessionnel.es/consejos-profesionales-beneficios-masaje-capilar">
                    <img class="media" src="https://www.gammabross.com/Gallery/salonimg-bioyoj-186.webp" alt="Imagen 2">
                </a>
                <a href="https://www.lorealprofessionnel.es/consejos-profesionales-beneficios-masaje-capilar">
                    <img class="media" src="https://blog.valquer.com/hubfs/peluqueria%20sostenible.jpg" alt="Imagen 3">
                </a>
            </div>
            <div class="navigation">
                <button id="prev">&lt;</button>
                <button id="next">&gt;</button>
            </div>
        </div>

        <script>
            let slideIndex = 0;
            const slides = document.querySelector('.slides');
            const totalSlides = slides.children.length;
            
            document.getElementById('next').addEventListener('click', () => {
                slideIndex = (slideIndex + 1) % totalSlides;
                updateSlidePosition();
            });

            document.getElementById('prev').addEventListener('click', () => {
                slideIndex = (slideIndex - 1 + totalSlides) % totalSlides;
                updateSlidePosition();
            });

            function updateSlidePosition() {
                const slideWidth = slides.children[0].clientWidth;
                slides.style.transform = `translateX(-${slideIndex * slideWidth}px)`;
            }
        </script>
    </section>
</div>

<div class="contenedor_productos">
    <div class="servicio">
        <br>
        <p>Ofrecemos productos de belleza</p>
        <div class="imagen">
            <img src="./imagenes/maquillaje.jpg" alt="">
        </div>
        <button class="boton1"><a href="carrito1_kitty.php"> Ver </a></button>
    </div> 
    
    <div class="servicio">
        <br>
        <p>Ofrecemos Corte y Cepillado</p>
        <div class="imagen">
            <img src="./imagenes/servicio2.webp" alt="">
        </div>
        <button class="boton1"><a href="agenda.php"> Ver </a></button>
    </div>

    <div class="servicio">
        <br>
        <p>Ofrecemos Corte y Cepillado a Domicilio</p>
        <div class="imagen">
            <img src="./imagenes/domicilio.jpg" alt="">
        </div>
        <button class="boton1"><a href="carrito1_kitty.php"> Ver </a></button>
    </div>
</div>    

<section style="background:#F4F4F4; padding: 30px 20px; text-align:center; color:#333;">
    <h2>GlowSmec</h2>
    <p style="max-width: 800px; margin: 0 auto; font-size:16px;">
        GlowSmec radica en la incorporación de tecnología y técnicas avanzadas dentro del sector de la belleza, como el uso de herramientas digitales para agendamiento en línea, asesorías virtuales de estilo y tratamientos basados en productos sostenibles y de la mejor calidad. Además, se promueve un enfoque de belleza consciente, donde el cuidado estético va de la mano con la salud y la autoestima.
    </p>
    <p style="margin-top:20px;">
        <a href="inicio.php" target="_blank" style="color: #D45B7A; font-weight: bold; text-decoration: underline;">
            Visitar sitio web oficial
        </a>
    </p>

    <div style="margin-top:30px;">
        <iframe 
            src="https://www.google.com/maps?q=Carrera%2027%20%2347-45%20Medell%C3%ADn%20Colombia&output=embed"
            width="100%" 
            height="400" 
            style="border:0; border-radius:10px;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>
</section>

<footer>
    <div>
        <a href="https://web.facebook.com/?locale=es_LA&_rdc=1&_rdr#" class="social"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/facebook.svg" alt="Facebook" style="filter: invert(1);"> Facebook </a>
        <a href="https://x.com/?lang=es" class="social"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/x.svg" alt="Twitter" style="filter: invert(1);"> Twitter</a>
        <a href="https://www.instagram.com/" class="social"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/instagram.svg" alt="Instagram" style="filter: invert(1);"> Instagram</a>
        <a href="https://wa.me/3007764482" class="social"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/whatsapp.svg" alt="WhatsApp" style="filter: invert(1);"> WhatsApp</a>
    </div>
    <div>
        <p>&copy;GlowSmec</p>
        <a href="contactenos2.php">Contactenos |</a>
        <a href="#">Política de Privacidad |</a>
        <a href="#">Términos</a>
    </div>
</footer>
</body>
</html>