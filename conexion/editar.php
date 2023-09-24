<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <!-- Agrega los enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .form-group {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card animate__animated animate__fadeIn">
                <div class="card-header bg-primary text-white text-center">
                    <h1 class="card-title">Editar Registro</h1>
                </div>
                <div class="card-body" id="editForm">
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["tabla"]) && isset($_GET["ID"])) {
                            $tabla = $_GET["tabla"];
                            $id = $_GET["ID"];

                            // Crear una instancia de conexión a la base de datos
                            $mysqli = new mysqli("localhost", "root", "Ribendiaz232", "autozone");

                            // Checar conexión a la base de datos.
                            if ($mysqli->connect_errno) {
                                echo "Falló en conectar a MySQL: " . $mysqli->connect_error;
                                exit();
                            }

                            // Consulta para obtener el registro seleccionado
                            $query = "SELECT * FROM $tabla WHERE $tabla.ID$tabla = ?";
                            $stmt = $mysqli->prepare($query);
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows === 0) {
                                echo "<p class='text-center'>Registro no encontrado.</p>";
                            } else {
                                $row = $result->fetch_assoc();
                                echo "<form action='actualizar.php' method='post'>";
                                echo "<input type='hidden' name='tabla' value='$tabla'>";
                                echo "<input type='hidden' name='ID' value='$id'>";

                                $columnInfoQuery = "SHOW COLUMNS FROM $tabla";
                                $columnInfoResult = $mysqli->query($columnInfoQuery);

                                if ($columnInfoResult) {
                                    while ($column = $columnInfoResult->fetch_assoc()) {
                                        $columnName = $column['Field'];
                                        $columnType = $column['Type'];
                                        
                                        // Adaptar el tipo de entrada según el tipo de columna
                                        if (strpos($columnType, 'int') !== false) {
                                            echo "<div class='form-group'>";
                                            echo "<label for='$columnName' class='form-label'>$columnName:</label>";
                                            echo "<input type='number' class='form-control' name='$columnName' id='$columnName' value='{$row[$columnName]}'>";
                                            echo "</div>";
                                        } elseif (strpos($columnType, 'varchar') !== false) {
                                            echo "<div class='form-group'>";
                                            echo "<label for='$columnName' class='form-label'>$columnName:</label>";
                                            echo "<input type='text' class='form-control' name='$columnName' id='$columnName' value='{$row[$columnName]}'>";
                                            echo "</div>";
                                        } elseif (strpos($columnType, 'date') !== false) {
                                            echo "<div class='form-group'>";
                                            echo "<label for='$columnName' class='form-label'>$columnName:</label>";
                                            echo "<input type='date' class='form-control' name='$columnName' id='$columnName' value='{$row[$columnName]}'>";
                                            echo "</div>";
                                        } elseif (strpos($columnType, 'decimal') !== false) {
                                            echo "<div class='form-group'>";
                                            echo "<label for='$columnName' class='form-label'>$columnName:</label>";
                                            echo "<input type='number' step='0.01' class='form-control' name='$columnName' id='$columnName' value='{$row[$columnName]}'>";
                                            echo "</div>";
                                        }
                                    }
                                }

                                echo "<div class='text-center'>";
                                echo "<button type='submit' class='btn btn-primary btn-sm mx-2'>Guardar Cambios</button>";
                                echo "<a href='conexion.php' class='btn btn-secondary btn-sm mx-2'>Cancelar</a>";
                                echo "<a href='eliminar.php?tabla=$tabla&ID=$id' class='btn btn-danger btn-sm mx-2'>Eliminar</a>";
                                echo "</div>";
                                echo "</form>";
                            }

                        // Cerrar la conexión cuando hayas terminado de trabajar con la base de datos.
                        $stmt->close();
                        $mysqli->close();
                    } else {
                        echo "<p class='text-center'>Parámetros inválidos.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agrega el enlace al archivo JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script>
    // Añadir una animación de desvanecimiento al cargar la página
    window.addEventListener('load', function () {
        document.getElementById('editForm').classList.add('show');
    });
</script>
</body>
</html>
