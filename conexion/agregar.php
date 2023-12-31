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

    // Genera un código de barras único
    $CodigoBarras = generateBarcode(); // Debes implementar esta función

    // Inserta los datos en la base de datos
    $sql = "INSERT INTO productos (Nombre, Descripcion, Precio, CodigoBarras) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $Nombre, $Descripcion, $Precio, $CodigoBarras);
    
    if ($stmt->execute()) {
        echo "Producto agregado con éxito.";
        
        // Redirigir a inventario.php después de agregar el producto
        echo '<script>
            setTimeout(function () {
                window.location.href = "inventario.php";
            }, 5000);
        </script>';
    } else {
        echo "Error al agregar el producto: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

// Función para generar un código de barras único
function generateBarcode() {
    // Utiliza la biblioteca Zend\Barcode para generar un código de barras único
    // Asegúrate de ajustar los parámetros según tus necesidades
    require 'vendor/autoload.php'; // Ajusta la ruta según tu proyecto
    $renderer = new Zend\Barcode\Renderer\Image();
    $options = [
        'text' => uniqid(), // Genera un código único (puedes personalizarlo más)
        'imageType' => 'png',
    ];
    $barcode = new Zend\Barcode\Barcode($options);
    $barcode->setRenderer($renderer);
    $barcodeImage = $barcode->generate();

    // Puedes guardar o almacenar $barcodeImage en tu base de datos si es necesario

    return $barcodeImage;
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
