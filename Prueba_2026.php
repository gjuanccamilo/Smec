<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
$servidor = 'localhost';
$usuario = 'root';
$contrasena = '';
$basedatos = mysqli_connect($servidor, $usuario, $contrasena) or die ('Problemas de conexión con BD');
$seleccione_base_de_datos = mysqli_select_db($basededatos, 'world') or die ("No se encontró el esquema");

// traer la info de las tablas

$sql = "SELECT Identificacion, Nombre, Apellidos, Telefono, Direccion, Correo From Persona";
$matriz = mysqli_query($basededatos, $sql);

            echo "<table>
            <thead>
                <tr>
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>";
while ($fila = mysqli_fetch_array($matriz, MYSQLI_ASSOC)) {
    echo "<tr>";
            echo "<td>".$fila['Identificacion']."</td>";
            echo "<td>".$fila['Nombres']."</td>";
            echo "<td>".$fila['Apellidos']."</td>";
            echo "<td>".$fila['Telefono']."</td>";
            echo "<td>".$fila['Direccion']."</td>";
            echo "<td>".$fila['Correo']."</td>";
            echo "<td><a href='Editar_forma_2025.php?"
}
?>
</body>
</html>