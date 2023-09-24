<?php
// Incluir código de conexión a la base de datos aquí

$mysqli = new mysqli("localhost", "root", "Ribendiaz232", "autozone");

if ($mysqli->connect_errno) {
    echo "Falló en conectar a MySQL: " . $mysqli->connect_error;
    exit();
}

$message = "";
$tabla_seleccionada = "";

// Verificar si se ha enviado el valor de "tabla_seleccionada" desde la página anterior
if (isset($_POST["tabla_seleccionada"])) {
    $tabla_seleccionada = $_POST["tabla_seleccionada"];
    $tabla_seleccionada_display = "'$tabla_seleccionada'"; // Encerrar el nombre de la tabla entre comillas

    // Obtener información de restricciones de la tabla
    $restrictionsQuery = "SHOW CREATE TABLE $tabla_seleccionada";
    $result = $mysqli->query($restrictionsQuery);

    if ($result) {
        $row = $result->fetch_assoc();
        $createTableStatement = $row["Create Table"];

        // Verificar si hay restricciones habilitadas en la definición de la tabla
        if (stripos($createTableStatement, "FOREIGN KEY") !== false) {
            $message = "La tabla $tabla_seleccionada_display tiene restricciones habilitadas.";
        } else {
            $message = "La tabla $tabla_seleccionada_display no tiene restricciones habilitadas.";
        }

        // Obtener el valor actual del autoincremento
        $autoIncrementQuery = "SHOW TABLE STATUS LIKE '$tabla_seleccionada'";
        $result = $mysqli->query($autoIncrementQuery);

        if ($result) {
            $row = $result->fetch_assoc();
            $currentAutoIncrement = $row["Auto_increment"];
            $message .= "<br>El valor actual del autoincremento en la tabla $tabla_seleccionada_display es: $currentAutoIncrement";

            // Verificar cuántos datos hay ingresados en la tabla
            $countQuery = "SELECT COUNT(*) AS total FROM $tabla_seleccionada";
            $countResult = $mysqli->query($countQuery);

            if ($countResult) {
                $countRow = $countResult->fetch_assoc();
                $totalData = $countRow["total"];
                $unusedAutoIncrement = $currentAutoIncrement - $totalData;
                $message .= "<br>Hay un total de $totalData datos en la tabla y $unusedAutoIncrement valores sin usar (comúnmente siempre habrá un valor, porque es el la identificación que se estaría agregando).";
            } else {
                $message .= "<br>Error al contar los datos de la tabla: " . $mysqli->error;
            }
        } else {
            $message = "Error al obtener información de la tabla $tabla_seleccionada_display: " . $mysqli->error;
        }
    } else {
        $message = "Error al obtener la definición de la tabla $tabla_seleccionada_display: " . $mysqli->error;
    }
}

// Función para restablecer el autoincremento
function resetAutoIncrement($mysqli, $tabla_seleccionada)
{
    $resetQuery = "ALTER TABLE $tabla_seleccionada AUTO_INCREMENT = 1";
    $analyzeQuery = "ANALYZE TABLE $tabla_seleccionada";

    // Restablecer el autoincremento
    if ($mysqli->query($resetQuery) === TRUE) {
        // Realizar el análisis de la tabla
        if ($mysqli->query($analyzeQuery) === TRUE) {
            return true;
        }
    }

    return false;
}

// Verificar si se ha enviado un formulario para restablecer el autoincremento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset_autoincrement"])) {
    $tabla_seleccionada = $_POST["tabla_seleccionada"];
    $result = resetAutoIncrement($mysqli, $tabla_seleccionada);

    if ($result) {
        // Agregar un mensaje de éxito
        $message .= "<div class='alert alert-success'>Se ha restablecido el autoincremento con éxito en la tabla $tabla_seleccionada_display. La página se actualizará en breve.</div>";

        // Agregar un script para recargar la página después de 2 segundos
        echo '<script>
            setTimeout(function() {
                location.reload();
            }, 2000);
        </script>';
    }
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones de Tabla <?php echo $tabla_seleccionada_display; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background-color: #f4f4f4;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .animate-enter {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5 animate__animated animate__enter">
        <h1 class="text-center mb-4">Opciones de Tabla <?php echo $tabla_seleccionada_display; ?></h1>

        <?php if (!empty($message)): ?>
        <hr>
        <div class="alert alert-info">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <?php
        // Mostrar botón para restablecer el autoincremento si se selecciona una tabla
        if (isset($_POST["tabla_seleccionada"])) {
            echo "<form method='POST' action='opciones.php'>";
            echo "<input type='hidden' name='tabla_seleccionada' value='$tabla_seleccionada'>";
            echo "<button type='submit' name='reset_autoincrement' class='btn btn-danger'>Restablecer Autoincremento</button>";
            echo "</form>";
        }
        ?>

        <?php
        // Mostrar botones para regresar y realizar otras acciones aquí
        if (isset($_POST["tabla_seleccionada"])) {
            echo "<div class='text-center mt-3'>";
            echo "<a href='conexion.php' class='btn btn-secondary'>Regresar</a>";
            echo "</div>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
