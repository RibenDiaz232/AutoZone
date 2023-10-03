<?php
session_start();

// Verifica si se ha enviado un formulario de venta
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["terminarVenta"])) {
    if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"]) > 0) {
        $ventas = $_SESSION["carrito"];
        $fecha = date("Y-m-d H:i:s");
        $totalVenta = array_sum(array_column($ventas, "precio"));

        // Abre el archivo reporte_ventas.php en modo escritura
        $archivoVentas = fopen("reporte_ventas.php", "a");

        // Escribe la información de la venta en el archivo
        fwrite($archivoVentas, "<p>Venta registrada el $fecha:</p>\n");
        fwrite($archivoVentas, "<ul>\n");
        foreach ($ventas as $venta) {
            fwrite($archivoVentas, "<li>Código de Barras: {$venta['CodigoBarras']} - Nombre: {$venta['nombre']} - Precio: {$venta['precio']} USD</li>\n");
        }
        fwrite($archivoVentas, "</ul>\n");
        fwrite($archivoVentas, "<p>Total de la venta: $totalVenta USD</p>\n\n");

        // Cierra el archivo
        fclose($archivoVentas);

        // Limpia el carrito de compras
        $_SESSION["carrito"] = array();

        echo "Venta exitosa. Total: $totalVenta USD";
    } else {
        echo "El carrito de compras está vacío.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
</head>
<body>
    <h2>Carrito de Compras</h2>
    <?php
    if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"]) > 0) {
        $totalCarrito = array_sum(array_column($_SESSION["carrito"], "precio"));
        echo "<ul>";
        foreach ($_SESSION["carrito"] as $item) {
            echo "<li>Código de Barras: {$item['CodigoBarras']} - Nombre: {$item['nombre']} - Precio: {$item['precio']} USD</li>";
        }
        echo "</ul>";
        echo "<p>Total del Carrito: $totalCarrito USD</p>";
        echo '<form method="post"><input type="submit" name="terminarVenta" value="Terminar Venta"></form>';
    } else {
        echo "<p>El carrito de compras está vacío.</p>";
    }
    ?>
            <!-- Botón de salida -->
            <a href="index.php">Volver al Índice</a>
</body>
</html>
