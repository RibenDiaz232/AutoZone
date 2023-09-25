<?php
session_start(); // Inicia la sesión

if (!isset($_SESSION['usuario'])) {
    // Si el usuario no ha iniciado sesión, redirige a login.php
    header("Location: login.php");
    exit();
}
// Contraseña de tu compañero
$companeroPassword = "Winsome1";

// Tu contraseña
$tuPassword = "Ribendiaz232";

// Contraseña que se utilizará
$contrasenaUtilizar = "";

if ($tuPassword === "Ribendiaz232") {
    $contrasenaUtilizar = $tuPassword;
} else {
    $contrasenaUtilizar = $companeroPassword;
}

// Luego, puedes usar $contrasenaUtilizar para crear la instancia de conexión
$conn = new mysqli("localhost", "root", "Winsome1", "autozone");


// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}
// Aquí puedes mostrar el contenido del punto de venta
// Calcular los ingresos totales
$sqlTotalIngresos = "SELECT SUM(precio) as total FROM ventas";
$resultTotalIngresos = $conn->query($sqlTotalIngresos);
$rowTotalIngresos = $resultTotalIngresos->fetch_assoc();
$totalIngresos = $rowTotalIngresos['total'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta de AutoZone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/AutoZone/Autozone/css/index.css">
</head>
<body>
<header>
        <!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="/Autozone/Autozone/imagenes/az-logo-full.svg" alt="logo" width="150px">
        </a> <!-- Logo de la página -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
                <!-- Menú de navegación -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/Autozone/AutoZone/php/inventario.php">Inventario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Marca y Categoría</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Compar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/AutoZone/Autozone/php/venta.php">Vender</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Reporte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/AutoZone/Autozone/php/graficasventas.php">Graficas de Ventas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Configurar</a>
                        </li>
                    </ul>
                    <?php
                    // Verificar si el usuario ha iniciado sesión
                    if (isset($_SESSION['usuario'])) {
                        // Si ha iniciado sesión, muestra el enlace "Cerrar Sesión" que redirige a la página de logout.php para cerrar la sesión
                        echo '<ul class="navbar-nav ml-auto">';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="/AutoZone/Autozone/php/login.php">Cerrar Sesión</a>';
                        echo '</li>';
                        echo '</ul>';
                    }
                    ?>
                </div>
        </div>
</nav>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="ingresos">
                    <h2>Total de ingresos</h2>
                    <?php
                    if ($totalIngresos !== null) {
                        echo '<p>$' . number_format($totalIngresos, 2) . '</p>';
                    } else {
                        echo '<p>No se encontraron datos de ingresos.</p>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ingresos">
                    <h2>Ingresos mensuales</h2>
                    <p>Precio: <?php echo isset($row['Precio']) ? '$' . number_format($row['Precio'], 2) : 'Precio no disponible'; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ingresos">
                    <h2>Ingresos pendientes</h2>
                    <p>Total de ingresos: <?php echo $totalIngresos !== null ? '$' . number_format($totalIngresos, 2) : 'N/A'; ?></p>
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
                $result = $conn->query($sql);

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

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-12 col-md-4 mb-4">';
                        echo '<div class="producto">';
                        echo '<h2>' . $row['Nombre'] . '</h2>';
                        echo '<p>' . $row['Descripcion'] . '</p>';
                        echo '<p>Precio: $' . $row['Precio'] . '</p>';
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
