<?php
function conectarBaseDatos($contrasena) {
    $conn = @new mysqli("localhost", "root", $contrasena, "autozone");
    
    if ($conn->connect_error) {
        // Devuelve false si la conexión falla
        return false;
    }
    
    return $conn;
}

$passwords = array("Winsome1", "Ribendiaz232");
$conn = null;

// Intentar conectar con las contraseñas
foreach ($passwords as $password) {
    $conn = conectarBaseDatos($password);
    
    // Si la conexión es exitosa, sal del bucle
    if ($conn) {
        break;
    }
}

// Verificar si se estableció una conexión
if (!$conn) {
    die("No se pudo conectar a la base de datos.");
}
?>
