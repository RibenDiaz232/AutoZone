<?php
session_start();

// Verifica si se ha enviado un formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["CodigoBarras"])) {
    include "conexionpwd.php";
    // Verificar la conexión
    if (!$conn) {
        die("La conexión a la base de datos falló.");
    }

    $CodigoBarras = $_POST["CodigoBarras"];

    $sql = "SELECT Nombre, Precio FROM Productos WHERE CodigoBarras = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $CodigoBarras);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $nombre = $row["Nombre"];
        $precio = $row["Precio"];

        // Inicializa o recupera el carrito de compras de la sesión
        if (!isset($_SESSION["carrito"])) {
            $_SESSION["carrito"] = array();
        }

        // Agrega el producto y su precio al carrito
        $_SESSION["carrito"][] = array(
            "CodigoBarras" => $CodigoBarras,
            "nombre" => $nombre,
            "precio" => $precio
        );

        header("Location: carrito.php");
    } else {
        echo "Producto no encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Producto</title>
</head>
<body>
    <h2>Buscar Producto</h2>
    <form method="post" action="buscar_producto.php">
        <label for="CodigoBarras">Código de Barras:</label>
        <input type="text" name="CodigoBarras" required>
        <button type="submit">Buscar</button>
    </form>
            <!-- Botón de salida -->
            <a href="index.php">Volver al Índice</a>
</body>
</html>
