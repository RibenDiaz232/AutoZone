<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="/AutoZone/Autozone/css/inventario.css">

    <script src="/ruta/a/jsbarcode-master.all.min.js"></script>
</head>
<body>
    <h1>Inventario</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre del Producto</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Categoria</th>
            <th>Cantidad</th>
            <th>Fabricante</th>
            <th>Código de Barras</th> <!-- Agregamos una nueva columna para el código de barras -->
        </tr>
        <!-- Aquí obtenemos y mostramos los datos de tu inventario desde la base de datos -->
        <?php
        function conectarBaseDatos($contrasena) {
            $conn = new mysqli("localhost", "root", $contrasena, "autozone");
            
            if ($conn->connect_error) {
                return null; // Devuelve null si la conexión falla
            }
            
            return $conn;
        }

        $password1 = "Winsome1";
        $password2 = "Ribendiaz232";

        // Si la contraseña es Winsome1, no intentar la conexión y mostrar un mensaje personalizado
        if ($password2 === "Winsome1") {
            die("No tienes permiso para usar esta contraseña.");
        }

        // Intentar conectar con la contraseña Ribendiaz232
        $conn = conectarBaseDatos($password2);

        if (!$conn) {
            die("La conexión a la base de datos falló.");
        }
        // Paso 2: Obtener datos del inventario desde la base de datos
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);

        // Mostrar los datos del inventario en la tabla
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["IDproductos"] . "</td>";
                echo "<td>" . $row["Nombre"] . "</td>";
                echo "<td>" . $row["Descripcion"] . "</td>";
                echo "<td>" . $row["Precio"] . "</td>";
                echo "<td>" . $row["Categoria"] . "</td>";
                echo "<td>$" . $row["CantidadStock"] . "</td>";
                echo "<td>" . $row["Fabricante"] . "</td>";
    
                // Agregar una etiqueta para mostrar el código de barras
                echo "<td><div class='barcode' data-code='" . $row["CodigoBarras"] . "'></div></td>";
    
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No se encontraron productos en el inventario.</td></tr>";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </table>
    
    <!-- Botón de regreso -->
    <a href="/AutoZone/Autozone/php/index.php">Regresar</a>

    <!-- Script JavaScript para generar códigos de barras -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var barcodeElements = document.querySelectorAll('.barcode');
            barcodeElements.forEach(function (element) {
                JsBarcode(element, element.dataset.code, {
                    format: "CODE128" // Puedes cambiar el formato del código de barras según tus necesidades
                });
            });
        });
    </script>
</body>
</html>
