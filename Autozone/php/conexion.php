<?php
// Datos de conexión a la base de datos
$host = "localhost"; // Cambia esto si tu base de datos está en un servidor remoto
$usuario = "root";
$contrasena = "Winsome1";
$base_de_datos = "autozone";

// Crear una conexión a la base de datos
$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar si hay errores en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Ahora puedes usar $conexion para realizar consultas a la base de datos
?>
