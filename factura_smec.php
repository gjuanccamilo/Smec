<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Factura</title>
</head>
<style>
table {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  margin: 20px 0;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

thead {
  background-color: #61a1ee;
  color: white;
}

th, td {
  padding: 12px 15px;
  text-align: center;
}

tbody tr:nth-child(even) {
  background-color: #f3f3f3;
}

tbody tr:hover {
  background-color: #e0f7e9;
  transition: 0.3s;
}

th {
  text-transform: uppercase;
  letter-spacing: 1px;
}

caption {
  margin: 10px;
  font-size: 18px;
  font-weight: bold;
}
  header {
        background-color: #5f8ce7;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    header h2 {
        margin: 0;
    }

    .header-buttons button {
        margin-left: 10px;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        background-color: #2b214f;
        color: white;
        cursor: pointer;
        font-size: 13px;
        transition: 0.3s;
    }

    .header-buttons button:hover {
        background-color: #2980b9;
    }

    /* FOOTER */
footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 15px;
        background-color: #5f8ce7;
        color: white;
        text-align: center;
        border-radius: 8px;
    }

    .footer-title {
        display: block;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .footer-button button {
        padding: 8px 14px;
        border: none;
        border-radius: 5px;
        background-color: #303875;
        color: white;
        cursor: pointer;
        transition: 0.3s;
    }

    .footer-button button:hover {
        background-color: #16a085;
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
            background-color: #4a3fc7;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

            .search-container button:hover {
            background-color:  #f28787;
        }
</style>
</style>
<body>
    <header>
        <h2>Factura</h2>
        <div class="header-buttons">
            <button onclick="location.href='dashboard_smec_2026.php'">Volver al Index</button>
            <button onclick="cerrarSesion()">Cerrar Sesión</button>
        </div>
    </header>
     <script>
        function preguntar(valor){
            eliminar=confirm("¿Deseas eliminar este registro?");
            if (eliminar)
            window.location.href="eliminarfactura.php?code="+valor;
        }
</script>

<!-- BUSCADOR -->
<br>
<br>
<form class="search-container" action="factura_smec.php" method="GET">
            <label name ="busqueda">Buscar</label>
            <input type="text" name="busqueda" placeholder="Buscar por el nombre.." value="">
            <button type="submit">Buscar</button>
            <a href="insert_factura.php">
                <button type="button">Insertar</button>
            </a>
            
        </form>




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
    $sql = "SELECT no_factura,cliente,fecha,notas FROM factura where no_factura LIKE '%$catica%'"; 
}
else{
    $sql = "SELECT no_factura,cliente,fecha,notas FROM factura"; 
}
$matriz = mysqli_query($basededatos, $sql);

    $matriz=mysqli_query($basededatos,$sql); 
        echo"<table>
            <thead>
                <tr>
                    <th>Numero Factura</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Notas</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>";
                while ($fila=mysqli_fetch_array($matriz,MYSQLI_ASSOC)){
                    echo "<tr>";
                        echo"<td>".$fila['no_factura']."</td>";
                        echo"<td>".$fila['cliente']."</td>";
                        echo"<td>".$fila['fecha']."</td>";
                        echo"<td>".$fila['notas']."</td>"; 
                        echo "<td><a href='conexion_editar_factura.php?sala=" . $fila['no_factura'] . "'>Editar</a></td>";
                        echo "<td><a href='javascript:preguntar(\"".$fila['no_factura']."\")'>Eliminar</a></td>";
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