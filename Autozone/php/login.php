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

    // Realiza la verificación de las credenciales aquí (consulta a la base de datos)
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Si las credenciales son válidas, establece la sesión y redirige a index.php
        $_SESSION['usuario'] = $usuario;
        header("Location: index.php");
        exit();
    } else {
        // Si las credenciales no son válidas, muestra un mensaje de error
        $error_message = "Inicio de sesión fallido. Por favor, inténtalo de nuevo.";
    }
}
?>
//prueba

<!DOCTYPE html>
<html lang="es">
<head>
  <title>Login</title>
  <!-- Agrega tus etiquetas meta y enlaces a CSS aquí -->
</head>
<body>
    <!-- Tu formulario de inicio de sesión existente debe estar aquí -->
    <form method="post">
        <div class="form-group">
            <label for="usuario">Usuario:</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary" action="validacion.php">Iniciar Sesión</button>
    </form>

    <?php
    // Asegúrate de mostrar $error_message si existe algún error
    if (isset($error_message)) {
        echo '<div class="alert alert-danger">' . $error_message . '</div>';
    }
    ?>
</body>
</html>
