<?php
// Inicializa la sesión (puedes ajustar esto según tus necesidades)
session_start();

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

    // Inicializa o recupera el carrito de compras de la sesión
    if (!isset($_SESSION["carrito"])) {
        $_SESSION["carrito"] = array();
    }

    // Busca si el producto ya está en el carrito
    $productoEnCarrito = null;
    foreach ($_SESSION["carrito"] as &$producto) {
        if ($producto["CodigoBarras"] === $CodigoBarras) {
            $productoEnCarrito = $producto;
            break;
        }
    }

    // Si el producto ya está en el carrito, actualiza la cantidad, de lo contrario, agrégalo
    if ($productoEnCarrito !== null) {
        $productoEnCarrito["Cantidad"] += $Cantidad;
    } else {
        $_SESSION["carrito"][] = array(
            "CodigoBarras" => $CodigoBarras,
            "Cantidad" => $Cantidad,
            "PrecioUnitario" => $PrecioUnitario,
            "TotalSinIVA" => $TotalSinIVA,
            "IVA" => $IVA,
            "TotalConIVA" => $TotalConIVA
        );
    }

    // Redirecciona de vuelta al formulario de compra
    header("Location: formulario_compra.php");
    exit();
} elseif ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["terminarCompra"])) {
    // Verifica si se ha solicitado terminar la compra
    if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"]) > 0) {
        // Registra la venta en la base de datos y realiza el procesamiento final aquí
        // Puedes usar la lógica de tu archivo original "procesar_compra.php" para hacerlo

        // Luego de procesar la compra, limpia el carrito
        $_SESSION["carrito"] = array();

        // Redirecciona a una página de confirmación o a donde desees
        header("Location: confirmacion_compra.php");
        exit();
    } else {
        // Si el carrito está vacío, redirecciona de vuelta al formulario de compra
        header("Location: formulario_compra.php");
        exit();
    }
} else {
    echo "Acceso no válido.";
}
?>
