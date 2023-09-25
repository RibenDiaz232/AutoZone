<?php

// Tu contraseña
$tuPassword = "Ribendiaz232";

// Contraseña de tu compañero
$companeroPassword = "Winsome1";

// Contraseña que se utilizará
$contrasenaUtilizar = "";

if ($tuPassword === "Ribendiaz232") {
    $contrasenaUtilizar = $tuPassword;
} else {
    $contrasenaUtilizar = $companeroPassword;
}

// Luego, puedes usar $contrasenaUtilizar para crear la instancia de conexión
$conn = new mysqli("localhost", "root", "Winsome1", "autozone");

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Ahora puedes usar $conexion para realizar consultas a la base de datos
?>
