<?php
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Búsqueda</title>
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
    <h1 class="text-center mb-4">Tabla de Búsqueda: Conexión a la Base de datos</h1>

    <div class="text-center mb-3">
        <a href="agregar.php" class="btn btn-success">Agregar Datos</a>
    </div>

    <form action="" method="post" class="mb-4 text-center">
        <div class="mb-3">
            <label for="tabla" class="form-label">Selecciona una tabla:</label>
            <select name="tabla" id="tabla" class="form-select">
                <option value="clientes">Clientes</option>
                <option value="compras">Compras</option>
                <option value="detalles_compra">Detalles de Compra</option>
                <option value="detalles_pedido">Detalles de Pedido</option>
                <option value="pedidos">Pedidos</option>
                <option value="productos">Productos</option>
                <option value="proveedores">Proveedores</option>
                <option value="usuarios">Usuarios</option>
                <option value="ventas">Ventas</option>
            </select>
        </div>
        <div class="text-center mb-3">
            <button type="submit" class="btn btn-primary">Mostrar Datos</button>
        </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tabla = $_POST["tabla"];

        $mysqli = $conn;

        $query = "SELECT * FROM $tabla";
        $result = $mysqli->query($query);

        if (!$result) {
            echo "Error en la consulta: " . $mysqli->error;
            exit();
        }

        $columnInfoQuery = "SHOW COLUMNS FROM $tabla";
        $columnInfoResult = $mysqli->query($columnInfoQuery);

        if (!$columnInfoResult) {
            echo "Error al obtener información de columnas: " . $mysqli->error;
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

        echo "<h2 class='text-center mb-4'>Datos en la tabla '$tabla':</h2>";
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
            echo "<a href='editar.php?tabla=$tabla&ID={$row[$primaryKeyColumn]}' class='btn btn-warning btn-sm'>Editar</a>";
            echo " ";
            echo "<a href='eliminar.php?tabla=$tabla&ID={$row[$primaryKeyColumn]}' class='btn btn-danger btn-sm'>Eliminar</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        // Agregar el botón "Opciones de la tabla" con enlace a la página de opciones
        echo "<div class='text-center mt-3'>";
        echo "<form action='opciones.php' method='post'>";
        echo "<input type='hidden' name='tabla_seleccionada' value='$tabla'>"; // Agregamos el campo oculto
        echo "<button type='submit' name='show_table_options' class='btn btn-primary'>Opciones de la tabla</button>";
        echo "</form>";
        echo "</div>";

        $mysqli->close();
    }
    ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
