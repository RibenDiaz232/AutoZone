<?php
function conectarBaseDatos($contrasena) {
    $conn = @new mysqli("localhost", "root", $contrasena, "autozone");
    
    if ($conn->connect_error) {
        return null; // Devuelve null si la conexión falla
    }
    
    return $conn;
}

$password1 = "Winsome1";
$password2 = "Ribendiaz232";
$conn = null;

// Intentar conectar con la contraseña de tu compañero
$conn = conectarBaseDatos($password1);

// Si la conexión falla, intentar con tu contraseña
if (!$conn) {
    $conn = conectarBaseDatos($password2);
}
?>