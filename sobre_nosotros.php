<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctenos</title>

    <style>
       /* =========================================
   VARIABLES DE ESTILO (Paleta proporcionada)
   ========================================= */
:root {
    --color-primary: #D45B7A;
    --color-primary-light: #FBE2E8;
    --color-dark: #0B0B0C;
    --color-text: #1C1C1C;
    --color-bg-card: #F8F8F9;
    --color-white: #FFFFFF;
    --font-heading: 'Didot', 'Bodoni MT', 'Cinzel', 'Georgia', serif;
    --font-body: 'Montserrat', 'Helvetica Neue', sans-serif;
    --border-elegant: 1px solid rgba(212, 91, 122, 0.15);
}

/* =========================================
   RESETEO BÁSICO
   ========================================= */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body, html {
    height: 100%;
    font-family: var(--font-body);
    background-color: var(--color-white);
    color: var(--color-text);
    line-height: 1.6;
}

/* ================= HEADER (Estilo Anterior) ================= */

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

/* Ajuste responsive para celulares */
@media (max-width: 768px) {
    header {
        flex-direction: column;
        padding: 15px;
        position: relative;
    }

    .nav-buttons, .header-buttons {
        position: static;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        width: 100%;
        margin-bottom: 15px;
        gap: 10px;
    }

    header h1, header h2 {
        font-size: 1.5rem;
    }

}
/* =========================================
   MAIN Y CONTENEDOR DE EQUIPO
   ========================================= */
main {
    padding: 120px 20px 80px 20px;
    min-height: 100vh;
    background-color: var(--color-white);
}

.contenedor_personas {
    display: grid;
    /* CSS Grid intermedio: se adapta automáticamente al ancho de la pantalla */
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* =========================================
   TARJETAS (Cards de presentación)
   ========================================= */
.contenedor_personas {
    display: flex !important;
    flex-wrap: wrap !important;
    justify-content: center !important; /* Esto garantiza que las tarjetas de abajo queden en el centro */
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.persona {
    background-color: var(--color-bg-card);
    border: var(--border-elegant);
    border-radius: 12px;
    padding: 30px 20px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center; 
    
    /* Le damos un ancho fijo a las tarjetas para que no se estiren y se centren en bloque */
    width: 280px; 
    flex-grow: 0;
    
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
}

.persona:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(212, 91, 122, 0.15); /* Sombra difuminada de color primario al pasar el mouse */
}

.persona p:first-of-type {
    font-family: var(--font-heading);
    font-size: 1.3rem;
    font-weight: bold;
    color: var(--color-dark);
    margin-bottom: 15px;
}

.persona p:last-of-type {
    font-size: 0.95rem;
    color: #4A4A4A;
    margin-top: 15px;
    line-height: 1.6;
    width: 100%; /* Asegura que ocupe el ancho de la tarjeta, no de la imagen */
    text-align: center; 
    /* Si prefieres que el texto esté justificado, cambia "center" por "justify" */
}

/* Imágenes dentro de las tarjetas */
.imagen {
    margin: 10px 0;
    width: 130px;
    height: 130px;
    border-radius: 50%;
    padding: 4px;
    /* Aro de color elegante alrededor de la foto */
    background: linear-gradient(135deg, var(--color-primary-light), var(--color-primary));
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.imagen img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid var(--color-bg-card);
}

/* =========================================
   FOOTER
   ========================================= */
footer {
    background-color: var(--color-dark);
    color: var(--color-white);
    padding: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 30px;
    box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
}

.social {
    text-decoration: none;
    color: var(--color-white);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    transition: color 0.3s ease;
    font-weight: 300;
}

.social:hover {
    color: var(--color-primary);
}

.social img {
    width: 22px;
    height: 22px;
    margin-right: 8px;
    border-radius: 50%;
    /* Filtro intermedio para volver blancos los iconos negros originales */
    filter: brightness(0) invert(1);
    transition: filter 0.3s ease;
}

.social:hover img {
    filter: none; /* Regresa al color original o se le puede aplicar un filtro rosado */
}

/* =========================================
   MEDIA QUERIES (Responsive Celular)
   ========================================= */
@media (max-width: 768px) {
    header {
        flex-direction: column;
        padding: 15px;
        position: relative; /* En celular es mejor evitar el fixed para que no cubra el contenido */
    }

    .nav-buttons {
        position: static;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        width: 100%;
        margin-bottom: 15px;
        gap: 10px;
    }

    header h1 {
        font-size: 1.5rem;
    }

    main {
        padding-top: 30px; /* Reducimos el padding superior porque el header ya no es fixed */
    }
    footer {
        flex-direction: column;
        gap: 15px;
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
        <a href="inicio.php" class="header-btn">Regresar a Página Principal</a>
    </div>
    <h1>Sobre Nosotros</h1>
</header>

<main>

</section>
    <!--Hasta aquí es un carrusel-->
</div>  <!--div para imagen de fondo-->
<div class="contenedor_personas">
    
        
        <!-- Tarjeta 2 (Corregida) -->
    <div class="persona">
        <p>Juan Camilo Giraldo Gómez</p>
        <div class="imagen">
            <img src="./imagenes/milo.jpeg" alt="">
        </div> <!-- EL CIERRE DEL DIV DEBE IR AQUÍ -->
        <p>Soy una persona inteligente e interesada sobre el mundo de la belleza y el autoestima de los demas.</p>
    </div>

    
   <!-- Tarjeta 2 (Corregida) -->
    <div class="persona">
        <p>Salome Montoya Vasquez</p>
        <div class="imagen">
            <img src="./imagenes/salo.jpeg" alt="">
        </div> <!-- EL CIERRE DEL DIV DEBE IR AQUÍ -->
        <p>Soy una persona muy activa y con muchos conocimientos y habilidades en el tema del maquillaje.</p>
    </div>

    <!-- Tarjeta 3 (Corregida) -->
    <div class="persona">
        <p>Emanuel Salazar Sepulveda</p>
        <div class="imagen">
            <img src="./imagenes/estapinta.jpeg" alt="">
        </div> <!-- EL CIERRE DEL DIV DEBE IR AQUÍ -->
        <p>Soy una persona comprometida con mi trabajo, brindando el apoyo y acompañamiento hacia nuestros clientes en cada sesión.</p>
    </div>

    <!-- Tarjeta 4 (Corregida) -->
    <div class="persona">
        <p>Miguel Angel Veléz Muñoz</p>
        <div class="imagen">
            <img src="./imagenes/velez.jpeg" alt="">
        </div> <!-- EL CIERRE DEL DIV DEBE IR AQUÍ -->
        <p>Soy una persona muy comprometida en esta rama laboral, buscando estética profesional en nuestros usuarios, para que tengan una excelente experiencia con nosotros.</p>
    </div>


</div>    



    
 



</body>





</main>

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

</html>