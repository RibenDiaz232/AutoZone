<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Conecta a la base de datos (ajusta las credenciales)
    $conn = new mysqli("localhost", "root", "Winsome1", "Autozone");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Captura los datos del formulario
    $Nombre = $_POST["Nombre"];
    $Descripcion = $_POST["Descripcion"];
    $Precio = $_POST["Precio"];

    // Genera un código de barras aleatorio (números del 0 al 9)
    $codigo_barras = generateBarcode(); // Debes implementar esta función

    // Inserta los datos en la base de datos
    $sql = "INSERT INTO productos (Nombre, Descripcion, Precio, CodigoBarras) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $Nombre, $Descripcion, $Precio, $codigo_barras);
    
    if ($stmt->execute()) {
        // Redirigir a inventario.php
        header("Location: /AutoZone/php/inventario.php");
        exit; // Asegurarse de que el script se detenga aquí
    } else {
        echo "Error al agregar el producto: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

// Función para generar un código de barras aleatorio
function generateBarcode() {
    // Genera un código de barras de longitud 10 con números aleatorios del 0 al 9
    $codigo_barras = "";
    for ($i = 0; $i < 10; $i++) {
        $codigo_barras .= rand(0, 9);
    }
    return $codigo_barras;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
</head>
<body>
    <h1>Agregar Producto</h1>
    <form method="post" action="agregar_producto.php">
        <label for="Nombre">Nombre:</label>
        <input type="text" id="Nombre" name="Nombre" required><br>
        
        <label for="Descripcion">Descripción:</label>
        <textarea id="Descripcion" name="Descripcion" required></textarea><br>
        
        <label for="Precio">Precio:</label>
        <input type="number" id="Precio" name="Precio" step="0.01" required><br>
        
        <button type="submit">Agregar Producto</button>
    </form>
</body>
</html>
