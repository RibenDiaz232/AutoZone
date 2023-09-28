<?php
// Conecta a la base de datos (ajusta las credenciales)
$conn = new mysqli("localhost", "root", "Winsome1", "Autozone");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener las ventas desde la base de datos
$sql = "SELECT * FROM ventas";
$result = $conn->query($sql);

$ventas = array();
$fechas = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row["TotalConIVA"]; // Asumiendo que deseas graficar los totales con IVA
        $fechas[] = $row["fecha"]; // Añade las fechas correspondientes
    }
}

// Cierra la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <!-- Incluye la biblioteca Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Reporte de Ventas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Total sin IVA</th>
                <th>IVA (16%)</th>
                <th>Total con IVA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Tu código PHP para obtener las ventas aquí (ya lo tienes)
            if (!empty($ventas)) {
                foreach ($ventas as $index => $venta) {
                    echo "<tr>
                            <td>" . ($index + 1) . "</td>
                            <td>" . ($venta - ($venta * 0.16)) . "</td>
                            <td>" . ($venta * 0.16) . "</td>
                            <td>$venta</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No se encontraron ventas.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Agrega un contenedor para la gráfica de ventas -->
    <div style="width: 80%; margin: auto;">
        <canvas id="graficaVentas"></canvas>
    </div>

    <!-- Botón de regreso -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php"><button>Volver al Index</button></a>
    </div>

    <script>
        // Obtén el contexto del lienzo de la gráfica
        var ctx = document.getElementById("graficaVentas").getContext("2d");

        // Datos de ejemplo (reemplaza esto con tus datos reales)
        var fechas = <?php echo json_encode($fechas); ?>;
        var ventas = <?php echo json_encode($ventas); ?>;

        // Crea una instancia de la gráfica de barras con datos de ejemplo
        var graficaVentas = new Chart(ctx, {
            type: "bar", // Tipo de gráfica de barras
            data: {
                labels: fechas, // Etiquetas para el eje X (fechas)
                datasets: [{
                    label: "Total con IVA",
                    data: ventas, // Datos de ventas
                    backgroundColor: "rgba(75, 192, 192, 0.2)", // Color de fondo
                    borderColor: "rgba(75, 192, 192, 1)", // Color del borde
                    borderWidth: 1 // Ancho del borde
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Comienza el eje Y en cero
                    }
                }
            }
        });
    </script>
</body>
</html>
<p>Venta registrada el 2023-09-28 02:08:02:</p>
<ul>
<li> - 75 USD</li>
<li> - 400 USD</li>
<li> - 7000 USD</li>
</ul>
<p>Total de la venta: 7475 USD</p>

