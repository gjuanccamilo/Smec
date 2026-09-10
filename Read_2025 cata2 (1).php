<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        /* ----- ESTRUCTURA GENERAL ----- */
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            padding-bottom: 60px;
        }

        /* ----- HEADER ----- */
        header {
            background-color: #444;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-buttons button {
            background-color: brown;
            color: white;
            border: none;
            padding: 10px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .header-buttons button:hover {
            background-color: coral;
        }

        /* ----- BUSCADOR ----- */
        .search-container {
            text-align: center;
            padding: 15px;
        }

        .search-container input {
            padding: 8px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-container button {
            padding: 8px 15px;
            background-color: brown;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

             .search-container button:hover {
            background-color: coral;
        }

        /* ----- TABLA ----- */
        .table-container {
            width: 100%;
            overflow-x: auto;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: auto;
            min-width: 600px;
            max-width: 100%;
            font-size: 12px;
            white-space: nowrap;
            display: block;
            max-height: 550px;
            overflow-x: auto;
            overflow-y: auto;
        }

        thead {
            position: sticky;
            top: 0;
            background-color: brown;
            color: white;
            z-index: 100;
        }

        td, th {
            padding: 6px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        td {
            background-color: rgb(187, 198, 146);
            border-color: rgb(65, 85, 85);
        }

        th {
            background-color: brown;
            color: aliceblue;
            position: sticky;
            top: 0;
            z-index: 101;
        }

        tr:hover {
            background-color: coral;
        }

        /* ----- FOOTER FIJO ----- */
        footer {
            background-color: #444;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-title {
            font-size: 14px;
        }

        .footer-button button {
            background-color: brown;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .footer-button button:hover {
            background-color: coral;
        }

    </style>
</head>
<body>




    <!-- HEADER -->
    <header>
        <h2>Gestión de Ciudades</h2>
        <div class="header-buttons">
            <button onclick="location.href='dashboard-2025.php'">Volver al Index</button>
            <button onclick="cerrarSesion()">Cerrar Sesión</button>
         
        </div>
    </header>

<script>
        function preguntar(valor){
            eliminar=confirm("¿Deseas eliminar este registro?");
            if (eliminar)
            window.location.href="eliminarciudad.php?code="+valor;
        }
</script>


    <!-- BUSCADOR -->

    <div class="search-container">
        <form action="Read_2025 cata2.php" method="GET">
            <label name ="busqueda">Buscar</label>
            <input type="text" name="busqueda" placeholder="Buscar por el nombre.." value="">
            <button type="submit">Buscar</button>
            <a href="Insertar_forma_2025.php">
                <button type="button">Insertar</button>
            </a>
            
        </form>
    </div>
    

    <!-- CONTENIDO PRINCIPAL -->
    <main>

    <script>
        function cerrarSesion() {
            alert("CATICA LA MEJOR");
            location.href = "dashboard-2025.php"; // Redirigir a la página de inicio de sesión
        }
    </script>
        <div class="table-container">
            <?php 
                // Conexión a la base de datos
                include_once "conexion_base_de_datos.php";

                // Búsqueda por nombre de región
                $catica = isset($_GET['busqueda']) ? mysqli_real_escape_string($basededatos, $_GET['busqueda']) : '';
                echo $catica;

                if ($catica) {
                    $sql = "SELECT a.ID, a.Name, a.CountryCode, a.District, a.Population,b.Name as pais, a.foto  FROM city a, country b where a.CountryCode = b.Code and a.Name LIKE '%$catica%' order by 1 desc"; 
                } else {
                    $sql = "SELECT a.ID, a.Name, a.CountryCode, a.District, a.Population,b.Name as pais, a.foto FROM city a, country b where a.CountryCode = b.Code order by 1 desc";
                }

                $matriz = mysqli_query($basededatos, $sql);

                echo "<table>
                   <thead>
                        <tr>
                            <th>Código de Ciudad</th>
                            <th>Nombre de Ciudad</th>
                            <th>Código de País</th>
                            <th>Nombre de País</th>
                            <th>Distrito</th>
                            <th>Población</th>
                            <th>Foto</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>";

                    while ($fila = mysqli_fetch_array($matriz, MYSQLI_ASSOC)) { 
                        echo "<tr>";

                        echo "<td>".$fila['ID']."</td>";
                        echo "<td>".$fila['Name']."</td>";
                        echo "<td>".$fila['CountryCode']."</td>";
                        echo "<td>".$fila['pais']."</td>";
                        echo "<td>".$fila['District']."</td>";
                        echo "<td>".$fila['Population']."</td>";
                        echo "<td>"; echo "<img src='".$fila['foto']."' width='50' >";echo"</td>"; 
                        echo "<td><a href='https://www.elcolombiano.com'>ejemplo</a></td>";
                        echo "<td><a href='Editar_forma_2025.php?catica=" . $fila['ID'] . "'>Editar</a></td>";
                        // CLAVES COMPUESTAS
                        //echo "<td><a href='edit.php?catica1=" . $fila['ID'] . "&catica2=" . $fila['Name'] . "'>Editar</a></td>";
                        //echo "<td><a href='#'>Eliminar</a></td>";
                     

                        echo "<td><a href='javascript:preguntar(\"".$fila['ID']."\")'>Eliminar</a></td>";
echo "</tr>";
                    }

                echo "
                    </tbody>
                </table>";
            ?>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <span class="footer-title">Derechos Reservados I.E. Asamblea Departamental</span>
        <div class="footer-button">
            <button onclick="location.href='dashboard-2025.php'">Volver a Index</button>
        </div>
    </footer>

    

</body>
</html>
