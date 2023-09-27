<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Compras</title>
</head>
<body>
    <h1>Registro de Compras</h1>
    <div style="display: flex; justify-content: space-between;">
        <div style="flex: 1;">
            <!-- Formulario para ingresar datos -->
            <h2>Ingrese los datos del producto</h2>
            <form method="post" action="procesar_compra.php">
                <label for="CodigoBarras">Código de Barras:</label>
                <input type="text" id="CodigoBarras" name="CodigoBarras" required><br>
                
                <label for="Cantidad">Cantidad:</label>
                <input type="number" id="Cantidad" name="Cantidad" min="1" required><br>
                
                <label for="PrecioUnitario">Precio Unitario:</label>
                <input type="number" id="PrecioUnitario" name="PrecioUnitario" step="0.01" required><br>
                
                <button type="submit">Registrar Compra</button>
            </form>
        </div>
        <div style="flex: 1;">
            <!-- Lista de productos y cuenta -->
            <h2>Lista de Productos</h2>
            <?php
            // Aquí puedes mostrar la lista de productos y la cuenta usando PHP
            // Puedes utilizar un array para almacenar los productos y actualizarlo con cada registro de compra
            // Por ejemplo:
            $productos = array();

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $CodigoBarras = $_POST["CodigoBarras"];
                $Cantidad = $_POST["Cantidad"];
                $PrecioUnitario = $_POST["PrecioUnitario"];

                // Agregar el producto a la lista
                $productos[] = array(
                    "CodigoBarras" => $CodigoBarras,
                    "Cantidad" => $Cantidad,
                    "PrecioUnitario" => $PrecioUnitario
                );
            }

            // Mostrar la lista de productos
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Código de Barras</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>";

            $totalSinIVA = 0;
            foreach ($productos as $producto) {
                $subtotal = $producto["Cantidad"] * $producto["PrecioUnitario"];
                $totalSinIVA += $subtotal;

                echo "<tr>
                        <td>{$producto['CodigoBarras']}</td>
                        <td>{$producto['Cantidad']}</td>
                        <td>{$producto['PrecioUnitario']}</td>
                        <td>$subtotal</td>
                      </tr>";
            }

            echo "</tbody></table>";

            // Calcular el IVA y el total con IVA
            $IVA = $totalSinIVA * 0.16;
            $totalConIVA = $totalSinIVA + $IVA;

            echo "<br>Total sin IVA: $totalSinIVA";
            echo "<br>IVA (16%): $IVA";
            echo "<br>Total con IVA: $totalConIVA";
            ?>
        </div>
    </div>
</body>
</html>
