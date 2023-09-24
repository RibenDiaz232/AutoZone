<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Registro</title>
    <link rel="stylesheet" href="/autozone/css/styles.css"> <!-- Ruta al archivo CSS -->
</head>
<body>
<div class="container text-center">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tabla"]) && isset($_POST["ID"])) {
        $tabla = $_POST["tabla"];
        $id = $_POST["ID"];

        // Crear una instancia de conexión a la base de datos
        $mysqli = new mysqli("localhost", "root", "Ribendiaz232", "autozone");

        // Checar conexión a la base de datos.
        if ($mysqli->connect_errno) {
            echo "Falló en conectar a MySQL: " . $mysqli->connect_error;
            exit();
        }

        // Construir la consulta de actualización
        $query = "UPDATE $tabla SET ";
        $params = [];
        foreach ($_POST as $key => $value) {
            if ($key !== "tabla" && $key !== "ID") {
                $query .= "$key = ?, ";
                $params[] = $value;
            }
        }
        $query = rtrim($query, ", ");
        $query .= " WHERE $tabla.ID$tabla = ?";
        $params[] = $id;

        // Preparar y ejecutar la consulta de actualización
        $stmt = $mysqli->prepare($query);
        $types = str_repeat("s", count($params));
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        // Verificar si la actualización se realizó con éxito
        if ($stmt->affected_rows > 0) {
            echo "<h1 class='card-title text-success'>Actualización Exitosa</h1>";
            echo "<p class='text-center'>Los datos se han actualizado exitosamente.</p>";
        } else {
            echo "<h1 class='card-title text-danger'>Error al Actualizar</h1>";
            echo "<p class='text-center'>No se pudieron actualizar los datos.</p>";
        }

        // Cerrar la conexión cuando hayas terminado de trabajar con la base de datos.
        $stmt->close();
        $mysqli->close();
    } else {
        echo "<h1 class='card-title text-danger'>Parámetros inválidos.</h1>";
    }
    ?>
    
    <div class="text-center">
        <a href="conexion.php" class="btn btn-primary btn-return">Regresar</a>
    </div>

    <div id="countdown"></div>
    
    <!-- Barra de progreso -->
    <div id="progress-container">
        <div class="progress">
            <div class="progress-bar" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
    </div>
</div>

<!-- Agrega el enlace al archivo JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script>
    // Redirigir a conexión.php después de 5 segundos
    setTimeout(function () {
        window.location.href = "conexion.php";
    }, 5000);

    // Iniciar una cuenta regresiva
    let seconds = 5;
    const countdown = document.getElementById("countdown");

    function updateCountdown() {
        countdown.innerText = seconds;
        seconds--;
        if (seconds < 0) {
            clearInterval(countdownInterval);
            countdown.style.display = "none";
        }
    }

    const countdownInterval = setInterval(updateCountdown, 1000);

    // Actualizar la barra de progreso
    let progress = 0;
    const progressBar = document.getElementById("progress-bar");
    const progressInterval = setInterval(updateProgress, 500); // Actualizar cada medio segundo

    function updateProgress() {
        if (progress <= 100) {
            progressBar.style.width = progress + "%";
            progressBar.innerText = progress + "%";
            progress += 10; // Aumenta el progreso en un 10% cada medio segundo
        } else {
            clearInterval(progressInterval);
            document.getElementById("progress-container").style.display = "none";
        }
    }
</script>
</body>
</html>
