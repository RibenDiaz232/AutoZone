
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "conexion.php";

if (isset($_POST["login"])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['password'];
    session_start();
    $_SESSION['usuario'] = $usuario; // Corregido aquí

    $host = "localhost";
    $usuario_db = "root";
    $contrasena_db = "Winsome1";
    $base_de_datos = "Autozone";
    
    $conexion = mysqli_connect($host, $usuario_db, $contrasena_db, $base_de_datos);

    // Consulta preparada para evitar la inyección de SQL
    $consulta = "SELECT * FROM usuarios WHERE correo=? AND password=?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "ss", $usuario, $password);
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado de la consulta preparada
    $resultado = mysqli_stmt_get_result($stmt);

    // Verifica si se encontraron filas en el resultado
    if (mysqli_num_rows($resultado) > 0) {
        // Inicio de sesión exitoso
        // Redirige al usuario al index o a la página deseada
header("Location: Autozone/php/index.php");
exit();

        exit();
    } else {
        // Inicio de sesión fallido
        echo "Inicio de sesión fallido. Por favor, inténtalo de nuevo.";
    }
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
