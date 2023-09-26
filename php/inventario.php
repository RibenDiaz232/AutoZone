<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="/AutoZone/Autozone/css/inventario.css">

    <script src="/ruta/a/jsbarcode-master.all.min.js"></script>
</head>
<body>
    <div class="container mt-5 animate__animated animate__enter">
        <h1 class="text-center">Inventario</h1>
        <div class="rounded p-3 bg-light">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Producto</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Fabricante</th>
                        <th>Código de Barras</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "conexionpwd.php";
                    // Verificar la conexión
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

                            // Acciones de editar y eliminar
                            echo "<td>";
                            echo "<a href='/Autozone/Autozone/conexion/editar.php?ID=" . $row["IDproductos"] . "' class='btn btn-warning btn-sm'>Editar</a>";
                            echo " ";
                            echo "<a href='/Autozone/conexion/eliminar.php?ID=" . $row["IDproductos"] . "' class='btn btn-danger btn-sm'>Eliminar</a>";
                            echo "</td>";

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No se encontraron productos en el inventario.</td></tr>";
                    }

                    // Cerrar la conexión a la base de datos
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    
        <!-- Botón de regreso -->
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-primary">Regresar</a>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
