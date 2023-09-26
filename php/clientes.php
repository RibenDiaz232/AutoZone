<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
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
        /* Centrar texto en el centro de la tabla */
        .table td, .table th {
            text-align: center;
        }
        /* Añadir espacio entre los botones */
        .btn-group .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5 animate__animated animate__enter">
        <h1 class="text-center">Clientes</h1>
        <div class="text-center mb-3">
            <a href="/Autozone/conexion/agregar.php?tabla=clientes" class="btn btn-success">Agregar datos</a>
        </div>
        <div class="rounded p-3 bg-light">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                </thead>
                <tbody>
                    <?php
                    include "conexionpwd.php";
                    // Verificar la conexión
                    if (!$conn) {
                        die("La conexión a la base de datos falló.");
                    }

                    // Paso 2: Obtener datos del inventario desde la base de datos
                    $tabla = "clientes";
                    $sql = "SELECT * FROM $tabla";
                    $result = $conn->query($sql);
            
                    if (!$result) {
                        echo "Error en la consulta: " . $conn->error;
                        exit();
                    }
            
                    $columnInfoQuery = "SHOW COLUMNS FROM $tabla";
                    $columnInfoResult = $conn->query($columnInfoQuery);
            
                    if (!$columnInfoResult) {
                        echo "Error al obtener información de columnas: " . $conn->error;
                        exit();
                    }
            
                    $primaryKeyColumn = null;
                    while ($column = $columnInfoResult->fetch_assoc()) {
                        if ($column["Key"] === "PRI") {
                            $primaryKeyColumn = $column["Field"];
                            break;
                        }
                    }
            
                    if ($primaryKeyColumn === null) {
                        echo "No se encontró una columna de identificación principal en la tabla.";
                        exit();
                    }
            
                    echo "<h2 class='text-center mb-4'>Datos registrados en la tabla:</h2>";
                    echo "<div class='table-responsive text-center animate__animated animate__fadeIn'>";
                    echo "<table class='table table-bordered table-striped'>";
                    echo "<thead class='table-dark'>";
                    echo "<tr>";
                    while ($fieldinfo = $result->fetch_field()) {
                        echo "<th>{$fieldinfo->name}</th>";
                    }
                    echo "<th>Acciones</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
            
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $key => $value) {
                            echo "<td>$value</td>";
                        }
                        echo "<td>";
                        echo "<div class='btn-group' role='group'>"; // Utiliza un grupo de botones
                        echo "<a href='/Autozone/conexion/editar.php?tabla=$tabla&ID={$row[$primaryKeyColumn]}' class='btn btn-warning btn-sm'>Editar</a>";
                        echo "<a href='/Autozone/conexion/eliminar.php?tabla=$tabla&ID={$row[$primaryKeyColumn]}' class='btn btn-danger btn-sm'>Eliminar</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
            
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
            
                    $conn->close();
                ?>
            
                </tbody>
            </table>
    
        <!-- Botón de regreso -->
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-primary">Regresar</a>
        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
