<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container text-center">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["tabla"]) && isset($_GET["ID"])) {
        $tabla = $_GET["tabla"];
        $id = $_GET["ID"];
        function conectarBaseDatos($contrasena) {
            $conn = @new mysqli("localhost", "root", $contrasena, "autozone");
            if ($conn->connect_error) {
                return null; // Devuelve null si la conexión falla
            }   
            return $conn;
        }
        $password1 = "Winsome1";
        $password2 = "Ribendiaz232";
        $conn = null;
        
        // Intentar conectar con la contraseña de tu compañero
        $conn = conectarBaseDatos($password1);
        
        // Si la conexión falla, intentar con tu contraseña
        if (!$conn) {
            $conn = conectarBaseDatos($password2);
        }
        
        // Verificar la conexión
        if (!$conn) {
            die("La conexión a la base de datos falló.");
        }
        // Checar conexión a la base de datos.
        if ($conn->connect_errno) {
            echo "Falló en conectar a MySQL: " . $conn->connect_error;
            exit();
        }

        // Consulta para obtener el registro seleccionado
        $query = "SELECT * FROM $tabla WHERE $tabla.ID$tabla = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo "<h1 class='card-title text-danger'>Registro no encontrado</h1>";
        } else {
            $row = $result->fetch_assoc();
            echo "<h1 class='card-title'>Confirmar Eliminación</h1>";
            echo "<p class='text-center'>¿Estás seguro de que deseas eliminar los siguientes datos?</p>";
            echo "<div class='text-center mt-4'>";
            echo "<table class='table table-bordered'>";
            foreach ($row as $key => $value) {
                echo "<tr>";
                echo "<th>$key</th>";
                echo "<td>$value</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";

            // Verificar si hay registros relacionados en otras tablas
            $hasRelatedRecords = false;

            // Aquí debes verificar si hay registros relacionados en otras tablas y configurar $hasRelatedRecords en consecuencia

            if ($hasRelatedRecords) {
                echo "<p class='text-danger'>Este registro tiene datos relacionados en otras tablas. ¿Deseas eliminarlos también?</p>";
                echo "<form action='eliminar.php' method='post'>";
                echo "<input type='hidden' name='confirmar_eliminar' value='true'>";
                echo "<input type='hidden' name='tabla' value='$tabla'>";
                echo "<input type='hidden' name='ID' value='$id'>";
                echo "<button type='submit' class='btn btn-danger btn-confirmar mx-2'>Eliminar</button>";
                echo "<a href='inventario.php' class='btn btn-secondary btn-confirmar mx-2'>Cancelar</a>";
                echo "</form>";
            } else {
                echo "<div class='text-center'>";
                echo "<form action='eliminar.php' method='post'>";
                echo "<input type='hidden' name='confirmar_eliminar' value='true'>";
                echo "<input type='hidden' name='tabla' value='$tabla'>";
                echo "<input type='hidden' name='ID' value='$id'>";
                echo "<button type='submit' class='btn btn-danger btn-confirmar mx-2'>Eliminar</button>";
                echo "<a href='conexion.php' class='btn btn-secondary btn-confirmar mx-2'>Cancelar</a>";
                echo "</form>";
                echo "</div>";
            }
        }

        // Cerrar la conexión cuando hayas terminado de trabajar con la base de datos.
        $stmt->close();
        $conn->close();
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar_eliminar"]) && isset($_POST["tabla"]) && isset($_POST["ID"])) {
        $tabla = $_POST["tabla"];
        $id = $_POST["ID"];

        function conectarBaseDatos($contrasena) {
            $conn = @new mysqli("localhost", "root", $contrasena, "autozone");
            if ($conn->connect_error) {
                return null; // Devuelve null si la conexión falla
            }   
            return $conn;
        }
        $password1 = "Winsome1";
        $password2 = "Ribendiaz232";
        $conn = null;
        
        // Intentar conectar con la contraseña de tu compañero
        $conn = conectarBaseDatos($password1);
        
        // Si la conexión falla, intentar con tu contraseña
        if (!$conn) {
            $conn = conectarBaseDatos($password2);
        }
        
        // Verificar la conexión
        if (!$conn) {
            die("La conexión a la base de datos falló.");
        }
        
        // Checar conexión a la base de datos.
        if ($conn->connect_errno) {
            echo "Falló en conectar a MySQL: " . $conn->connect_error;
            exit();
        }

        // Construir la consulta de eliminación
        $query = "DELETE FROM $tabla WHERE $tabla.ID$tabla = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Verificar si la eliminación se realizó con éxito
        if ($stmt->affected_rows > 0) {
            echo "<h1 class='text-center'>Eliminación Exitosa</h1>";
            echo "<p class='text-center'>Los datos se han eliminado exitosamente.</p>";
        } else {
            echo "<h1 class='text-center'>Error al Eliminar</h1>";
            echo "<p class='text-center'>No se pudieron eliminar los datos.</p>";
        }

        // Cerrar la conexión cuando hayas terminado de trabajar con la base de datos.
        $stmt->close();
        $conn->close();

        // Redirigir a conexión.php después de 5 segundos
        echo "<div class='text-center mt-4'>";
        echo "<p>Redirigiendo a <a href='conexion.php'>conexion.php</a> en <span id='countdown'>5</span> segundos...</p>";
        echo "<div class='progress'>";
        echo "<div class='progress-bar' role='progressbar' style='width: 0%;' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' id='progress-bar'></div>";
        echo "</div>";
        echo "</div>";
        echo "<script>
                let seconds = 5;
                const countdown = document.getElementById('countdown');
                const progressBar = document.getElementById('progress-bar');
                let width = 0;
                let interval = 1000;
                
                function updateCountdown() {
                    countdown.innerText = seconds;
                    seconds--;
                    if (seconds < 0) {
                        clearInterval(countdownInterval);
                        window.location.href = 'conexion.php';
                    }
                }
                
                function updateProgressBar() {
                    width += (100 / 5);
                    progressBar.style.width = width + '%';
                }
                
                const countdownInterval = setInterval(updateCountdown, interval);
                setInterval(updateProgressBar, interval);
              </script>";
    } else {
        echo "<h1 class='card-title text-danger'>Parámetros inválidos</h1>";
    }
    ?>
</div>

<!-- Agrega el enlace al archivo JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
