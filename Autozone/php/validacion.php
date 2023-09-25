<?php
session_start(); // Inicia la sesión

if (isset($_SESSION['usuario'])) {
    // Si el usuario ya ha iniciado sesión, redirige a index.php o a la página principal
    header("Location: index.php");
    exit();
}

include "conexion.php"; // Incluye tu archivo de conexión a la base de datos

if (isset($_POST['login'])) {
    // Verifica si se envió el formulario de inicio de sesión
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Realiza la verificación de las credenciales en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Si las credenciales son válidas, establece la sesión y redirige a index.php
        $_SESSION['usuario'] = $usuario;
        header("Location: /AutoZone/Autozone/php/index.php");
        exit();
    } else {
        // Si las credenciales no son válidas, muestra un mensaje de error
        $error_message = "Inicio de sesión fallido. Por favor, inténtalo de nuevo.";
    }

    $stmt->close();
}

// Resto de tu código de validación aquí, si es necesario

?>
