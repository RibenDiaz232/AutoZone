<?php
include "conexionpwd.php";

// Verificar la conexión
if (!$conn) {
    die("La conexión a la base de datos falló.");
}

// Obtener datos de ventas por día
$sqlDia = "SELECT DATE(fecha) as dia, SUM(TotalConIVA) as totalDia FROM ventas GROUP BY dia";
$resultDia = $conn->query($sqlDia);

$ventasDia = array();
$fechasDia = array();

if ($resultDia->num_rows > 0) {
    while ($row = $resultDia->fetch_assoc()) {
        $ventasDia[] = $row["totalDia"];
        $fechasDia[] = $row["dia"];
    }
}

// Obtener datos de ventas por semana
$sqlSemana = "SELECT YEARWEEK(fecha, 1) as semana, SUM(TotalConIVA) as totalSemana FROM ventas GROUP BY semana";
$resultSemana = $conn->query($sqlSemana);

$ventasSemana = array();
$fechasSemana = array();

if ($resultSemana->num_rows > 0) {
    while ($row = $resultSemana->fetch_assoc()) {
        $ventasSemana[] = $row["totalSemana"];
        $fechasSemana[] = "Semana " . $row["semana"];
    }
}

// Obtener datos de ventas por mes
$sqlMes = "SELECT DATE_FORMAT(fecha, '%Y-%m') as mes, SUM(TotalConIVA) as totalMes FROM ventas GROUP BY mes";
$resultMes = $conn->query($sqlMes);

$ventasMes = array();
$fechasMes = array();

if ($resultMes->num_rows > 0) {
    while ($row = $resultMes->fetch_assoc()) {
        $ventasMes[] = $row["totalMes"];
        $fechasMes[] = $row["mes"];
    }
}

// Obtener datos de ventas por año
$sqlAnio = "SELECT YEAR(fecha) as anio, SUM(TotalConIVA) as totalAnio FROM ventas GROUP BY anio";
$resultAnio = $conn->query($sqlAnio);

$ventasAnio = array();
$fechasAnio = array();

if ($resultAnio->num_rows > 0) {
    while ($row = $resultAnio->fetch_assoc()) {
        $ventasAnio[] = $row["totalAnio"];
        $fechasAnio[] = $row["anio"];
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

    <!-- Tabla de ventas por día -->
    <h3>Ventas por Día</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Día</th>
                <th>Total con IVA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($ventasDia)) {
                foreach ($ventasDia as $index => $venta) {
                    echo "<tr>
                            <td>{$fechasDia[$index]}</td>
                            <td>{$venta} USD</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No se encontraron ventas por día.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Gráfica de ventas por día -->
    <h3>Gráfica de Ventas por Día</h3>
    <canvas id="graficaVentasDia"></canvas>

    <!-- Tabla de ventas por semana -->
    <h3>Ventas por Semana</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Semana</th>
                <th>Total con IVA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($ventasSemana)) {
                foreach ($ventasSemana as $index => $venta) {
                    echo "<tr>
                            <td>{$fechasSemana[$index]}</td>
                            <td>{$venta} USD</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No se encontraron ventas por semana.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Gráfica de ventas por semana -->
    <h3>Gráfica de Ventas por Semana</h3>
    <canvas id="graficaVentasSemana"></canvas>

    <!-- Tabla de ventas por mes -->
    <h3>Ventas por Mes</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Mes</th>
                <th>Total con IVA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($ventasMes)) {
                foreach ($ventasMes as $index => $venta) {
                    echo "<tr>
                            <td>{$fechasMes[$index]}</td>
                            <td>{$venta} USD</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No se encontraron ventas por mes.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Gráfica de ventas por mes -->
    <h3>Gráfica de Ventas por Mes</h3>
    <canvas id="graficaVentasMes"></canvas>

    <!-- Tabla de ventas por año -->
    <h3>Ventas por Año</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Año</th>
                <th>Total con IVA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($ventasAnio)) {
                foreach ($ventasAnio as $index => $venta) {
                    echo "<tr>
                            <td>{$fechasAnio[$index]}</td>
                            <td>{$venta} USD</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No se encontraron ventas por año.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Gráfica de ventas por año -->
    <h3>Gráfica de Ventas por Año</h3>
    <canvas id="graficaVentasAnio"></canvas>

    <!-- Script para crear la gráfica de ventas por día -->
    <script>
        var ctxDia = document.getElementById("graficaVentasDia").getContext("2d");
        var graficaVentasDia = new Chart(ctxDia, {
            type: "bar",
            data: {
                labels: <?php echo json_encode($fechasDia); ?>,
                datasets: [{
                    label: "Total con IVA",
                    data: <?php echo json_encode($ventasDia); ?>,
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>

    <!-- Script para crear la gráfica de ventas por semana -->
    <script>
        var ctxSemana = document.getElementById("graficaVentasSemana").getContext("2d");
        var graficaVentasSemana = new Chart(ctxSemana, {
            type: "bar",
            data: {
                labels: <?php echo json_encode($fechasSemana); ?>,
                datasets: [{
                    label: "Total con IVA",
                    data: <?php echo json_encode($ventasSemana); ?>,
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- Script para crear la gráfica de ventas por mes -->
    <script>
        var ctxMes = document.getElementById("graficaVentasMes").getContext("2d");
        var graficaVentasMes = new Chart(ctxMes, {
            type: "bar",
            data: {
                labels: <?php echo json_encode($fechasMes); ?>,
                datasets: [{
                    label: "Total con IVA",
                    data: <?php echo json_encode($ventasMes); ?>,
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- Script para crear la gráfica de ventas por año -->
    <script>
        var ctxAnio = document.getElementById("graficaVentasAnio").getContext("2d");
        var graficaVentasAnio = new Chart(ctxAnio, {
            type: "bar",
            data: {
                labels: <?php echo json_encode($fechasAnio); ?>,
                datasets: [{
                    label: "Total con IVA",
                    data: <?php echo json_encode($ventasAnio); ?>,
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
        <!-- Botón de salida -->
    <a href="index.php">Volver al Índice</a>
</body>
</html>
