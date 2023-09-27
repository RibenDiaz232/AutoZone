<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Captura los datos del formulario
    $CodigoBarras = $_POST["CodigoBarras"];
    $Cantidad = $_POST["Cantidad"];
    $PrecioUnitario = $_POST["PrecioUnitario"];

    // Calcula el total sin IVA
    $TotalSinIVA = $Cantidad * $PrecioUnitario;

    // Calcula el IVA (porcentaje del 16%)
    $IVA = $TotalSinIVA * 0.16;

    // Calcula el total con IVA
    $TotalConIVA = $TotalSinIVA + $IVA;

    // Aquí puedes guardar los datos en tu base de datos si es necesario

    // Muestra el resultado
    echo "Producto con Código de Barras $CodigoBarras<br>";
    echo "Cantidad: $Cantidad<br>";
    echo "Precio Unitario: $PrecioUnitario<br>";
    echo "Total sin IVA: $TotalSinIVA<br>";
    echo "IVA (16%): $IVA<br>";
    echo "Total con IVA: $TotalConIVA<br>";
} else {
    echo "No se recibieron datos.";
}
?>
