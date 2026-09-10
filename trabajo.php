<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Tabla</title>
</head>
<link rel="stylesheet" href="tablilla.css">
<body>
    <?php 
    echo "<table>";
    
    echo "<tr>";
    echo "<th>cedula</th>";
    echo "<th>nombre</th>";
    echo "<th>apellido</th>";
    echo "<th>telefono</th>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>1025766123</td>";
    echo "<td>Emanuel</td>";
    echo "<td>Salazar</td>";
    echo "<td>3216317804</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>1025666974</td>";
    echo "<td>Emiliano</td>";
    echo "<td>Salazar</td>";
    echo "<td>3216977285</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>43270299</td>";
    echo "<td>Andrea</td>";
    echo "<td>Vasquez</td>";
    echo "<td>3127445610</td>";
    echo "</tr>";


    
    echo "</table>";
    ?>
</body>
</html>