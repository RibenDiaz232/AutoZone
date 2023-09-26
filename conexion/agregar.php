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
// Checar conexión a la base de datos.
if ($conn->connect_errno) {
    echo "Falló en conectar a MySQL: " . $conn->connect_error;
    exit();
}

// Obtener la lista de tablas disponibles
$tablesQuery = "SHOW TABLES";
$tablesResult = $conn->query($tablesQuery);
$tables = array();

if ($tablesResult) {
    while ($row = $tablesResult->fetch_row()) {
        $tables[] = $row[0];
    }
} else {
    echo "Error al obtener la lista de tablas: " . $conn->error;
}

// Inicializar variables
$tablaSeleccionada = "";
$columnas = array();

// Comprobar si se ha enviado un formulario (para mostrar el collapse)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tablaSeleccionada = $_POST['tabla'];

    // Obtener información de columnas de la tabla seleccionada
    $columnInfoQuery = "SHOW COLUMNS FROM $tablaSeleccionada";
    $columnInfoResult = $conn->query($columnInfoQuery);

    if ($columnInfoResult) {
        while ($column = $columnInfoResult->fetch_assoc()) {
            $columnas[] = $column['Field'];
        }
    } else {
        echo "Error al obtener información de columnas: " . $conn->error;
    }
}

// Comprobar si se ha pasado el parámetro 'tabla' en la URL
if (isset($_GET['tabla'])) {
    $tablaSeleccionada = $_GET['tabla'];

    // Obtener información de columnas de la tabla seleccionada
    $columnInfoQuery = "SHOW COLUMNS FROM $tablaSeleccionada";
    $columnInfoResult = $conn->query($columnInfoQuery);

    if ($columnInfoResult) {
        while ($column = $columnInfoResult->fetch_assoc()) {
            $columnas[] = $column['Field'];
        }
    } else {
        echo "Error al obtener información de columnas: " . $conn->error;
    }
}

// Comprobar si se ha enviado el formulario de inserción de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $tabla = $_POST['tabla'];
    $valores = array();

    foreach ($columnas as $columna) {
        if (isset($_POST[$columna])) {
            $valores[$columna] = $_POST[$columna];
        }
    }

    // Construir la consulta de inserción
    $columnasInsert = implode(", ", array_keys($valores));
    $valoresInsert = "'" . implode("', '", $valores) . "'";
    $query = "INSERT INTO $tabla ($columnasInsert) VALUES ($valoresInsert)";

    // Ejecutar la consulta SQL de inserción
    if ($conn->query($query) === true) {
        header("refresh:5;url=conexion.php");
        echo "Datos agregados con éxito. Redireccionando a la página principal en 5 segundos...";
        exit();
    } else {
        echo "Error al insertar datos: " . $conn->error;
    }
}

// Obtener la columna de ID principal y habilitar el autoincremento
$idColumn = null;

foreach ($columnas as $columna) {
    if (stripos($columna, 'id') !== false) {
        $idColumn = $columna;
        break;
    }
}

if ($idColumn) {
    // Obtener el próximo valor autoincrementado
    $autoIncrementQuery = "SHOW TABLE STATUS LIKE '$tablaSeleccionada'";
    $autoIncrementResult = $conn->query($autoIncrementQuery);
    $autoIncrementData = $autoIncrementResult->fetch_assoc();
    $nextAutoIncrementValue = $autoIncrementData['Auto_increment'];

    // Deshabilitar la primera columna
    echo "<script>
        document.getElementById('$idColumn').disabled = true;
        document.getElementById('$idColumn').value = 'Próximo valor: $nextAutoIncrementValue';
    </script>";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Datos</title>
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
        <h1 class="text-center mb-4">Agregar Datos</h1>

        <form method="POST" action="agregar.php">
            <div class="mb-3">
                <label for="tabla" class="form-label">Selecciona una tabla:</label>
                <select id="tabla" name="tabla" class="form-select">
                    <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mostrar Columnas</button>
        </form>

        <?php if (!empty($tablaSeleccionada) && !empty($columnas)): ?>
        <hr>
        <h2 class="text-center mb-4">Agregar Datos a la tabla '<?php echo $tablaSeleccionada; ?>'</h2>
        <form method="POST" action="agregar.php">
            <input type="hidden" name="tabla" value="<?php echo $tablaSeleccionada; ?>">
            <?php foreach ($columnas as $columna): ?>
            <div class="mb-3">
                <label for="<?php echo $columna; ?>" class="form-label"><?php echo $columna; ?>:</label>
                <?php if ($columna === $idColumn): ?>
                <input type="text" id="<?php echo $columna; ?>" name="<?php echo $columna; ?>" class="form-control" disabled>
                <?php else: ?>
                <input type="text" id="<?php echo $columna; ?>" name="<?php echo $columna; ?>" class="form-control">
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <button type="submit" name="agregar" class="btn btn-success">Agregar</button>
            <button type="button" class="btn btn-danger" onclick="window.location.href='conexion.php'">Cancelar</button>
        </form>
        <hr>
        <h2 class="text-center mb-4">Vista Previa</h2>
        <div class="table-responsive text-center animate__animated animate__fadeIn">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Campo</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($columnas as $columna): ?>
                    <tr>
                        <td><?php echo $columna; ?></td>
                        <td id="preview-<?php echo $columna; ?>"></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <script>
            <?php foreach ($columnas as $columna): ?>
            document.getElementById("<?php echo $columna; ?>").addEventListener("input", function() {
                document.getElementById("preview-<?php echo $columna; ?>").textContent = this.value;
            });
            <?php endforeach; ?>
        </script>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
