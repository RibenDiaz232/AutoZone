<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tabla"]) && isset($_POST["ID"])) {
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
    $query .= " WHERE id$tabla = ?";
    $params[] = $id;

    // Preparar y ejecutar la consulta de actualización
    $stmt = $conn->prepare($query);
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
    $conn->close();
} else {
    echo "<h1 class='card-title text-danger'>Parámetros inválidos.</h1>";
}
?>
