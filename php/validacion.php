<?php
session_start(); // Iniciar la sesión

// Verificar si se enviaron los datos del formulario
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Aquí debes realizar la validación de las credenciales en la base de datos.
    // Consulta la base de datos para verificar si el usuario y la contraseña son correctos.

    // Si las credenciales son válidas, establece la sesión
    $_SESSION['usuario'] = $_POST['email'];

    // Redirige al usuario al index.php
    header("Location: index.php");
    exit();
} else {
    // Si no se enviaron los datos del formulario, muestra un mensaje de error o redirige a la página de inicio de sesión nuevamente.
    header("Location: login.php");
    exit();
}
?>
