<?php
$host = "localhost";
$db   = "bd_glow_smec"; // Reemplaza por el nombre de tu base de datos
$user = "root";             // Reemplaza por tu usuario de base de datos
$pass = "";                 // Reemplaza por tu contraseña

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>