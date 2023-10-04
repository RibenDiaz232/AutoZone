<?php
session_start(); // Inicia la sesión
include "conexionpwd.php";

// Función para ejecutar una consulta SQL y manejar errores
function ejecutarConsulta($conn, $sql, $mensajeError) {
    $result = $conn->query($sql);

    if ($result) {
        return $result;
    } else {
        die($mensajeError . ": " . mysqli_error($conn));
    }
}

// Verificar la conexión
if (!$conn) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

// Obtener datos de ventas por día
$sqlDia = "SELECT DATE(fecha) as dia, SUM(TotalConIVA) as totalDia FROM ventas WHERE DATE(fecha) = CURDATE() GROUP BY DATE(fecha)";
$resultDia = ejecutarConsulta($conn, $sqlDia, "Error en la consulta de ventas por día");

$ventasDia = array();
$fechasDia = array();

if ($resultDia->num_rows > 0) {
    while ($row = $resultDia->fetch_assoc()) {
        $ventasDia[] = $row["totalDia"];
        $fechasDia[] = $row["dia"];
    }
} else {
    echo 'No se encontraron ventas hoy.';
}

// Obtener datos de ventas por semana
$sqlSemana = "SELECT YEARWEEK(fecha, 1) as semana, SUM(TotalConIVA) as totalSemana FROM ventas WHERE YEARWEEK(fecha, 1) = YEARWEEK(CURDATE(), 1) GROUP BY YEARWEEK(fecha, 1)";
$resultSemana = ejecutarConsulta($conn, $sqlSemana, "Error en la consulta de ventas por semana");

$ventasSemana = array();
$fechasSemana = array();

if ($resultSemana->num_rows > 0) {
    while ($row = $resultSemana->fetch_assoc()) {
        $ventasSemana[] = $row["totalSemana"];
        $fechasSemana[] = "Semana " . $row["semana"];
    }
} else {
    echo 'No se encontraron ventas esta semana.';
}

// Obtener datos de ventas por mes
$sqlMes = "SELECT DATE_FORMAT(fecha, '%Y-%m') as mes, SUM(TotalConIVA) as totalMes FROM ventas WHERE DATE_FORMAT(fecha, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m') GROUP BY DATE_FORMAT(fecha, '%Y-%m')";
$resultMes = ejecutarConsulta($conn, $sqlMes, "Error en la consulta de ventas por mes");

$ventasMes = array();
$fechasMes = array();

if ($resultMes->num_rows > 0) {
    while ($row = $resultMes->fetch_assoc()) {
        $ventasMes[] = $row["totalMes"];
        $fechasMes[] = $row["mes"];
    }
} else {
    echo 'No se encontraron ventas este mes.';
}

// Obtener datos de ventas por año
$sqlAnio = "SELECT YEAR(fecha) as anio, SUM(TotalConIVA) as totalAnio FROM ventas WHERE YEAR(fecha) = YEAR(CURDATE()) GROUP BY YEAR(fecha)";
$resultAnio = ejecutarConsulta($conn, $sqlAnio, "Error en la consulta de ventas por año");

$ventasAnio = array();
$fechasAnio = array();

if ($resultAnio->num_rows > 0) {
    while ($row = $resultAnio->fetch_assoc()) {
        $ventasAnio[] = $row["totalAnio"];
        $fechasAnio[] = $row["anio"];
    }
} else {
    echo 'No se encontraron ventas este año.';
}

// Cierra la conexión al final del script
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta de AutoZone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/AutoZone/css/index.css">
</head>
<body>
    <header>
        <!-- Barra de navegación -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="/Autozone/imagenes/az-logo-full.svg" alt="logo" width="150px">
                </a> <!-- Logo de la página -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Menú de navegación -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="inventario.php">Inventario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="buscar_producto.php">Vender</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reporte_ventas.php">Reporte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="usuarios.php">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="clientes.php">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Configurar</a>
                        </li>
                    </ul>
                </div>
                <?php
                // Verificar si el usuario ha iniciado sesión
                if (isset($_SESSION['usuario'])) {
                    // Si ha iniciado sesión, muestra el enlace "Cerrar Sesión" que redirige a la página de logout.php para cerrar la sesión
                    echo '<a class="btn btn-danger ml-auto" href="logout.php">Cerrar Sesión</a>';
                }
                ?>
            </div>
        </nav>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="ingresos">
                    <h2>Ventas del Día</h2>
                    <p><?php echo !empty($ventasDia) ? '$' . number_format(end($ventasDia), 2) : 'No se encontraron ventas hoy'; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ingresos">
                    <h2>Ventas de la Semana</h2>
                    <p><?php echo !empty($ventasSemana) ? '$' . number_format(end($ventasSemana), 2) : 'No se encontraron ventas esta semana'; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ingresos">
                    <h2>Ventas del Mes</h2>
                    <p><?php echo !empty($ventasMes) ? '$' . number_format(end($ventasMes), 2) : 'No se encontraron ventas este mes'; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ingresos">
                    <h2>Ventas del Año</h2>
                    <p><?php echo !empty($ventasAnio) ? '$' . number_format(end($ventasAnio), 2) : 'No se encontraron ventas este año'; ?></p>
                </div>
            </div>
        </div>
    </div>
    <main>
        <!-- Esta parte es para medir los ingresos -->
        <!-- Luego, en tu HTML, puedes mostrar estos valores en las áreas correspondientes -->
        <section>
            <!-- Para colocar los productos destacados o más vendidos -->
            <h2>Productos Destacados</h2>
            <div class="row">
                <?php
                // Consulta SQL para obtener productos destacados
                $sql = "SELECT * FROM productos WHERE destacado = 1";
                $result = ejecutarConsulta($conn, $sql, "Error en la consulta de productos destacados");

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-12 col-md-4 mb-4">';
                        echo '<div class="producto">';
                        echo '<h2>' . $row['nombre'] . '</h2>';
                        echo '<p>' . $row['descripcion'] . '</p>';
                        echo '<p>Precio: $' . $row['precio'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo 'No se encontraron productos destacados.';
                }
                ?>
            </div>
        </section>

        <section>
            <!-- Productos agregados recientemente -->
            <h2>Productos agregados</h2>
            <div class="row">
                <?php
                // Consulta SQL para obtener productos agregados recientemente
                $sql = "SELECT * FROM productos ORDER BY fecha_agregado DESC LIMIT 3"; // Limitamos a 3 productos, pero puedes ajustar esto según tus necesidades

                $result = ejecutarConsulta($conn, $sql, "Error en la consulta de productos agregados recientemente");

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-12 col-md-4 mb-4">';
                        echo '<div class="producto">';
                        echo '<h2>' . $row['nombre'] . '</h2>';
                        echo '<p>' . $row['descripcion'] . '</p>';
                        echo '<p>Precio: $' . $row['precio'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo 'No se encontraron productos agregados recientemente.';
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <!-- Pie de página -->
        <p>&copy; 2023 Punto de Venta de AutoZone</p>
    </footer>
    
    <!-- Agrega el enlace a la biblioteca Font Awesome para el icono del carrito -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Agrega el enlace a los archivos de Bootstrap JS (jQuery y Popper.js son necesarios) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
