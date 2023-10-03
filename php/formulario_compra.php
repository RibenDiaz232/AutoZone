<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Compra</title>
</head>
<body>
    <h2>Formulario de Compra</h2>
    <form method="post" action="procesar_compra.php">
        <label for="CodigoBarras">Código de Barras:</label>
        <input type="text" name="CodigoBarras" required>
        <br>
        <label for="Cantidad">Cantidad:</label>
        <input type="number" name="Cantidad" value="1" required>
        <br>
        <label for="PrecioUnitario">Precio Unitario (USD):</label>
        <input type="number" name="PrecioUnitario" step="0.01" required>
        <br>
        <button type="submit">Agregar al Carrito</button>
        <br>
        <hr>
        <h3>Carrito de Compras</h3>
        <?php
        session_start();
        if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"]) > 0) {
            $totalCarrito = array_sum(array_column($_SESSION["carrito"], "TotalConIVA"));
            echo "<ul>";
            foreach ($_SESSION["carrito"] as $item) {
                echo "<li>Código de Barras: {$item['CodigoBarras']} - Cantidad: {$item['Cantidad']} - Precio Unitario: {$item['PrecioUnitario']} USD - Total con IVA: {$item['TotalConIVA']} USD</li>";
            }
            echo "</ul>";
            echo "<p>Total del Carrito: $totalCarrito USD</p>";
            echo '<input type="submit" name="terminarCompra" value="Terminar Compra">';
        } else {
            echo "<p>El carrito de compras está vacío.</p>";
        }
        ?>
    </form>
    <br>
    <a href="reporte_ventas.php">Ver Reporte de Ventas</a>
</body>
</html>
