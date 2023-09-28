<!-- Gráfica de Ventas Diarias -->
<h2>Ventas Diarias</h2>
<div id="graficaVentasDiarias" style="width: 400px; height: 200px; cursor: pointer;"></div>

<!-- Gráfica de Ventas Semanales -->
<h2>Ventas Semanales</h2>
<div id="graficaVentasSemanales" style="width: 400px; height: 200px; cursor: pointer;"></div>

<!-- Gráfica de Ventas Mensuales -->
<h2>Ventas Mensuales</h2>
<div id="graficaVentasMensuales" style="width: 400px; height: 200px; cursor: pointer;"></div>

<!-- Gráfica de Ventas Anuales -->
<h2>Ventas Anuales</h2>
<div id="graficaVentasAnuales" style="width: 400px; height: 200px; cursor: pointer;"></div>

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

        // Agrega un evento de clic a la gráfica para redirigir al informe de ventas
        google.visualization.events.addListener(chart, 'select', function () {
            var selection = chart.getSelection();
            if (selection.length > 0) {
                var fechaSeleccionada = data.getValue(selection[0].row, 0); // Obtiene la fecha seleccionada
                // Redirige al informe de ventas con la fecha seleccionada
                window.location.href = 'reporte_ventas.php?fecha=' + fechaSeleccionada;
            }
        });

        chart.draw(data, options);
    }

    // Repite el proceso para las otras gráficas (Semanales, Mensuales y Anuales)
</script>
