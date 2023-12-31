<?php
include "conexionpwd.php";
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
    <title>Login</title>
    <!-- Agrega las referencias a Bootstrap CSS y Font Awesome (para los iconos) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4">
            <h1 class="text-center">Iniciar Sesión</h1>
            <form action="validacion.php" method="post">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Correo Electrónico</label>
                    <input type="usuario" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </form>
        </div>
    </div>

    <!-- Agrega las referencias a Bootstrap JS y jQuery (asegúrate de que estén incluidas en tu proyecto) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
