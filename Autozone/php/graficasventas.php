<?php
// Paso 2: Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "Winsome1";
$database = "Autozone";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Obtener datos de ventas diarias
$ventasDiarias = array();
for ($i = 1; $i <= 7; $i++) {
    // Consulta para obtener las ventas de cada día de la última semana
    $date = date('Y-m-d', strtotime("-$i days"));
    $sql = "SELECT SUM(monto) as total FROM ventas WHERE fecha = '$date'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $ventasDiarias[] = (int)$row['total'];
}

// Obtener datos de ventas semanales
$ventasSemanales = array();
for ($i = 1; $i <= 7; $i++) {
    // Consulta para obtener las ventas de cada semana de las últimas 7 semanas
    $startOfWeek = date('Y-m-d', strtotime("-$i weeks", strtotime("this week Monday")));
    $endOfWeek = date('Y-m-d', strtotime("-$i weeks", strtotime("this week Sunday")));
    $sql = "SELECT SUM(monto) as total FROM ventas WHERE fecha BETWEEN '$startOfWeek' AND '$endOfWeek'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $ventasSemanales[] = (int)$row['total'];
}

// Obtener datos de ventas mensuales (por ejemplo, los últimos 7 meses)
$ventasMensuales = array();
for ($i = 1; $i <= 7; $i++) {
    // Consulta para obtener las ventas de cada mes de los últimos 7 meses
    $startOfMonth = date('Y-m-01', strtotime("-$i months"));
    $endOfMonth = date('Y-m-t', strtotime("-$i months"));
    $sql = "SELECT SUM(monto) as total FROM ventas WHERE fecha BETWEEN '$startOfMonth' AND '$endOfMonth'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $ventasMensuales[] = (int)$row['total'];
}

// Obtener datos de ventas anuales (por ejemplo, los últimos 7 años)
$ventasAnuales = array();
for ($i = 1; $i <= 7; $i++) {
    // Consulta para obtener las ventas de cada año de los últimos 7 años
    $startOfYear = date('Y-01-01', strtotime("-$i years"));
    $endOfYear = date('Y-12-31', strtotime("-$i years"));
    $sql = "SELECT SUM(monto) as total FROM ventas WHERE fecha BETWEEN '$startOfYear' AND '$endOfYear'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $ventasAnuales[] = (int)$row['total'];
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Título Aquí</title>
    
    <!-- Agrega el enlace a la biblioteca Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Agrega un estilo CSS personalizado -->
    <link rel="stylesheet" href="/Autozone/css/graficasventas.css">
</head>
<body>
    <h1>Graficas de Ventas</h1>
 
    <!-- Gráfica de Ventas Diarias -->
    <h2>Ventas Diarias</h2>
    <div id="graficaVentasDiarias" style="width: 400px; height: 200px;"></div>

    <!-- Gráfica de Ventas Semanales -->
    <h2>Ventas Semanales</h2>
    <div id="graficaVentasSemanales" style="width: 400px; height: 200px;"></div>

    <!-- Gráfica de Ventas Mensuales -->
    <h2>Ventas Mensuales</h2>
    <div id="graficaVentasMensuales" style="width: 400px; height: 200px;"></div>

    <!-- Gráfica de Ventas Anuales -->
    <h2>Ventas Anuales</h2>
    <div id="graficaVentasAnuales" style="width: 400px; height: 200px;"></div>
    
    <!-- Paso 3: Agregar scripts de JavaScript para crear las gráficas -->
    <script>
        // Gráfica de Ventas Diarias
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVentasDiarias);

        function drawVentasDiarias() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Día');
            data.addColumn('number', 'Ventas');
            data.addRows([
                ['Día 1', <?php echo $ventasDiarias[6]; ?>],
                ['Día 2', <?php echo $ventasDiarias[5]; ?>],
                ['Día 3', <?php echo $ventasDiarias[4]; ?>],
                ['Día 4', <?php echo $ventasDiarias[3]; ?>],
                ['Día 5', <?php echo $ventasDiarias[2]; ?>],
                ['Día 6', <?php echo $ventasDiarias[1]; ?>],
                ['Día 7', <?php echo $ventasDiarias[0]; ?>]
            ]);

            var options = {
                title: 'Ventas Diarias',
                width: 400,
                height: 200
            };

            var chart = new google.visualization.LineChart(document.getElementById('graficaVentasDiarias'));
            chart.draw(data, options);
        }

        // Gráfica de Ventas Semanales (repite el proceso para las otras gráficas)
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVentasSemanales);

        function drawVentasSemanales() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Semana');
            data.addColumn('number', 'Ventas');
            data.addRows([
                ['Semana 1', <?php echo $ventasSemanales[6]; ?>],
                ['Semana 2', <?php echo $ventasSemanales[5]; ?>],
                ['Semana 3', <?php echo $ventasSemanales[4]; ?>],
                ['Semana 4', <?php echo $ventasSemanales[3]; ?>],
                ['Semana 5', <?php echo $ventasSemanales[2]; ?>],
                ['Semana 6', <?php echo $ventasSemanales[1]; ?>],
                ['Semana 7', <?php echo $ventasSemanales[0]; ?>]
            ]);

            var options = {
                title: 'Ventas Semanales',
                width: 400,
                height: 200
            };

            var chart = new google.visualization.LineChart(document.getElementById('graficaVentasSemanales'));
            chart.draw(data, options);
        }

        // Repite el proceso para las otras gráficas (Mensuales y Anuales)
    </script>
</body>
</html>
