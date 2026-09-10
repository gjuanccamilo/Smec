<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tabla producto_servicio</title>
</head>
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

    body {
        padding-top: 100px !important;
        font-family: var(--font-body);
        background-color: var(--color-bg-card);
        color: var(--color-text);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        padding-bottom: 120px;
    }

    /* ================= HEADER GLOWSMEC ================= */
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
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        border-bottom: 2px solid var(--color-primary);
        
    }

    .logo-glowsmec {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .logo-glowsmec a {
        font-family: var(--font-heading);
        font-size: 1.6rem;
        font-weight: bold;
        color: var(--color-white);
        text-decoration: none;
        letter-spacing: 2px;
        text-transform: uppercase;
        white-space: nowrap;
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
        font-size: 1.6rem;
        color: var(--color-white);
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        white-space: nowrap;
    }

    .header-buttons {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }

    .header-buttons button {
        padding: 8px 16px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 20px;
        background-color: transparent;
        color: var(--color-white);
        cursor: pointer;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: var(--font-body);
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    .header-buttons button:hover {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: var(--color-white);
    }

    /* ================= BUSCADOR ALINEADO ================= */
    .search-container {
        display: flex;
        justify-content: center;
        align-items: center; /* Alineación vertical perfecta */
        gap: 12px;
        margin: 40px auto 80px; /* <--- Aumenta el 3er valor (de 25px/20px a 60px o lo que desees) */
        padding: 0 20px;
        flex-wrap: wrap;
    }

    .search-container label {
        font-family: var(--font-heading);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 13px;
        color: var(--color-dark);
        line-height: 1; /* Alinea la altura del texto con los botones */
        display: inline-flex;
        align-items: center;
       
    }

    .search-container input[type="text"] {
        padding: 10px 16px;
        width: 300px;
        border: var(--border-elegant);
        border-radius: 20px;
        font-family: var(--font-body);
        font-size: 13px;
        outline: none;
        background-color: var(--color-white);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .search-container input[type="text"]:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 8px rgba(212, 91, 122, 0.25);
    }

    .search-container button {
        padding: 10px 20px;
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

    .search-container button:hover {
        background-color: var(--color-dark);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

   /* ================= TABLA COMO CONTENEDOR ALINEADO ================= */
    table {
        display: table;
        width: 100%;
        max-width: 1100px; /* Ancho máximo delimitado */
        margin: 0 auto 40px; /* Centrado en pantalla */
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px; /* Esquinas redondeadas */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: var(--border-elegant);
        background-color: var(--color-white);
        white-space: nowrap;
        table-layout: auto;
    }

    /* Para mantener las esquinas redondeadas impecables en el encabezado */
    thead tr:first-child th:first-child {
        border-top-left-radius: 11px;
    }
    thead tr:first-child th:last-child {
        border-top-right-radius: 11px;
    }

    thead {
        background-color: var(--color-dark);
        color: var(--color-white);
    }

    th {
        padding: 16px 14px;
        text-align: center;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        border-bottom: 2px solid var(--color-primary);
    }

    td {
        padding: 14px 14px;
        text-align: center;
        font-size: 13px;
        border-bottom: 1px solid #F0F0F0;
        vertical-align: middle;
    }

    tbody tr:last-child td:first-child {
        border-bottom-left-radius: 11px;
    }
    tbody tr:last-child td:last-child {
        border-bottom-right-radius: 11px;
    }

    tbody tr:nth-child(even) {
        background-color: #FAFAFA;
    }

    tbody tr:hover {
        background-color: var(--color-primary-light);
        transition: background-color 0.3s ease;
    }

    table img {
        border-radius: 4px;
        object-fit: cover;
        border: 1px solid #E0E0E0;
        width: 50px;
        height: 50px;
    }

    /* ACCIONES TABLA */
    td a {
        color: var(--color-primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: color 0.2s ease, border-bottom 0.2s ease;
        border-bottom: 1px solid transparent;
    }

    td a:hover {
        color: var(--color-dark);
        border-bottom: 1px solid var(--color-dark);
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
        text-align: center;
        border-top: 4px solid var(--color-primary);
        box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    .footer-title {
        display: block;
        margin-bottom: 8px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, 0.8);
    }

    .footer-button button {
        padding: 8px 20px;
        border: 1px solid var(--color-primary);
        border-radius: 20px;
        background-color: var(--color-primary);
        color: var(--color-white);
        cursor: pointer;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        font-family: var(--font-body);
        transition: all 0.3s ease;
    }

    .footer-button button:hover {
        background-color: transparent;
        color: var(--color-white);
    }

    @media (max-width: 850px) {
        header {
            grid-template-columns: 1fr;
            justify-items: center;
            padding: 15px;
            position: relative;
        }
        body {
            padding-top: 20px !important;
        }
        .header-buttons {
            justify-content: center;
            width: 100%;
        }
        .search-container input[type="text"] {
            width: 100%;
        }
    }
</style>
<body>
    <header>
        <!-- Logo/Texto a la izquierda -->
        <div class="logo-glowsmec">
            <a href="inicio.php">GLOW<span>SMEC</span></a>
        </div>
        <h2>Producto Y Servicio</h2>
        <div class="header-buttons">
            <button onclick="location.href='inicio.php'">Volver al Inicio</button>
            <button onclick="cerrarSesion()">Cerrar Sesión</button>
        </div>
    </header>
    <script>
        function preguntar(valor){
            eliminar=confirm("¿Deseas eliminar este registro?");
            if (eliminar)
            window.location.href="eliminarproducto_servicio.php?code="+valor;
        }
</script>

<!-- BUSCADOR -->
<br>
<br>
<form class="search-container" action="producto_servicio.php" method="GET">
            <label name ="busqueda">Buscar</label>
            <input type="text" name="busqueda" placeholder="Buscar por el nombre de codigo producto_servicio.." value="">
            <button type="submit">Buscar</button>
            <a href="insert_producto_servicio.php">
                <button type="button">Insertar</button>
            </a>
            
        </form>
<body>
    <?php
    //codigo para la base de datos conectame
    //1-conectarme a la base de datos
    // 2 maneras de hacerlo mysqli y pdo
    //1.mysqli
    $servidor='localhost';
    $usuario='root';
    $contrasena='';
    $basededatos=mysqli_connect($servidor,$usuario,$contrasena) or die('problemas de conexion con BD');
    $seleccione_base_de_datos=mysqli_select_db($basededatos,'bd_glow_smec') or die("no se encontro el esquema");
    //traer la informacion de las tablas
   $catica = isset($_GET['busqueda']) ? mysqli_real_escape_string($basededatos, $_GET['busqueda']) : '';
if($catica){
    $sql = "SELECT cod_prod_ser,descripcion,tipo_prod_ser, fecha_creacion, genero_servicio, precio, clasificacion,foto FROM producto_servicio where cod_prod_ser LIKE '%$catica%'"; 
}
else{
    $sql = "SELECT cod_prod_ser,descripcion,tipo_prod_ser, fecha_creacion, genero_servicio, precio, clasificacion,foto FROM producto_servicio"; 
}
    $matriz=mysqli_query($basededatos,$sql);
        echo"<table>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>descripcion</th>
                    <th>Tipo </th>
                    <th>Fecha Creacion</th>
                    <th>Genero Servicio</th>
                    <th>Precio</th>
                    <th>Clasificacion</th>
                    <th>Foto</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>";
            while ($fila=mysqli_fetch_array($matriz,MYSQLI_ASSOC)){
                    echo "<tr>";
                        echo"<td>".$fila['cod_prod_ser']."</td>";
                        echo"<td>".$fila['descripcion']."</td>";
                        echo"<td>".$fila['tipo_prod_ser']."</td>";
                        echo"<td>".$fila['fecha_creacion']."</td>";
                        echo"<td>".$fila['genero_servicio']."</td>";	
                        echo"<td>".$fila['precio']."</td>";
                        echo"<td>".$fila['clasificacion']."</td>";
                        echo"<td>";echo"<img src='".$fila['foto']."'width='150'>";
                        echo "<td><a href='conexion_editarproducto_servicio.php?catica=" . $fila['cod_prod_ser'] . "'>Editar</a></td>";
                        echo "<td><a href='javascript:preguntar(\"".$fila['cod_prod_ser']."\")'>Eliminar</a></td>";
                    echo "</tr>";
                }
                echo"
            </tbody>
        </table>";
    ?>
    <footer>
        <span class="footer-title">Derechos Reservados I.E. Asamblea Departamental</span>
        <div class="footer-button">
            <button onclick="location.href='dashboard_smec_2026.php'">Volver a Dashboard</button>
        </div>
    </footer>
</body>
</html>