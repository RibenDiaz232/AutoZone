error_reporting(E_ALL);
ini_set('display_errors', 1);
<?php
// Incluye tus archivos de conexión y funciones de inicio de sesión aquí
include "conexion.php";

// Verifica si se ha enviado el formulario de inicio de sesión
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Realiza la verificación del inicio de sesión en tu base de datos
    $usuarioValido = verificarUsuario($email, $password); // Debes implementar esta función

    if ($usuarioValido) {
        // El inicio de sesión fue exitoso
        // Establece una variable de sesión o cookie para indicar que el usuario ha iniciado sesión
        $_SESSION['usuario'] = $email; // Esto es solo un ejemplo, debes personalizarlo según tu lógica

        // Redirige al usuario al index o a la página deseada
        header("Location: /autozone/php/index.php"); // Cambia "index.php" al archivo deseado
        exit(); // Asegúrate de salir del script después de redirigir
    } else {
        // El inicio de sesión falló, puedes mostrar un mensaje de error
        echo "Inicio de sesión fallido. Verifica tus credenciales.";
    }
} else {
    // Si no se envió el formulario de inicio de sesión, redirige a la página de inicio de sesión
    header("Location: /Autozone/php/login.php"); // Cambia "login.php" al archivo de inicio de sesión
    exit(); // Asegúrate de salir del script después de redirigir
}
?>
