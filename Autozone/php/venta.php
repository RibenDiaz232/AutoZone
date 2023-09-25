<?php
include "conexionpwd.php";
// Verificar la conexión
if (!$conn) {
    die("La conexión a la base de datos falló.");
}

// Inicializar variables
$productos = array();
$subtotal = 0;
$iva = 0.16; // 16% de IVA

// Manejar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST["codigo"];

    // Consultar la base de datos para obtener información del producto
    $sql = "SELECT * FROM productos WHERE codigo = '$codigo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        
        if ($producto["CantidadStock"] > 0) {
            // Agregar el producto al carrito de compras
            $productos[] = $producto;
            $subtotal += $producto["Precio"];

            // Actualizar la cantidad de productos en stock
            $nuevaCantidad = $producto["CantidadStock"] - 1;
            $sql = "UPDATE productos SET CantidadStock = $nuevaCantidad WHERE codigo = '$codigo'";
            $conn->query($sql);
        } else {
            echo "<p>Producto agotado.</p>";
        }
    } else {
        echo "<p>Producto no encontrado.</p>";
    }
}

// Función para obtener información de un producto por su código (reemplaza esto con tu lógica)
function obtenerProductoPorCodigo($codigo) {
    // Tu lógica para obtener productos
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta</title>
    <link rel="stylesheet" href="/AutoZone/Autozone/css/venta.css">
</head>
<body>
    <h1>Punto de Venta</h1>
    <div>
        <!-- Formulario para escanear productos -->
        <form method="post" action="">
            <label for="codigo">Código de Producto:</label>
            <input type="text" id="codigo" name="codigo">
            <input type="submit" value="Escanear">
        </form>
    </div>

    <div>
        <!-- Lista de productos y cálculos -->
        <h2>Carrito de Compras</h2>
        <ul>
            <?php foreach ($productos as $producto) : ?>
                <li><?php echo $producto["Nombre"]; ?> - $<?php echo $producto["Precio"]; ?></li>
            <?php endforeach; ?>
        </ul>
        <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
        <p>IVA (16%): $<?php echo number_format($subtotal * $iva, 2); ?></p>
        <p>Total: $<?php echo number_format($subtotal + ($subtotal * $iva), 2); ?></p>
    </div>

    <!-- Botón para volver al menú -->
    <a href="/AutoZone/Autozone/php/index.php">Volver al Menú</a>
</body>
</html>
