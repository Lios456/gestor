<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nueva_contrasena = $_POST["contrasena"];

    // Aquí debes obtener el correo del usuario desde la sesión o de tu base de datos

    // Cambiar la contraseña del usuario en la base de datos

    echo "Contraseña cambiada exitosamente.";
?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cambiar Contraseña</title>
            <link rel="stylesheet" type="text/css" href="resources/librerias/bootstrap5/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="resources/librerias/jquery-ui-1.13.2/jquery-ui.theme.css">
            <link rel="stylesheet" type="text/css" href="resources/librerias/jquery-ui-1.13.2/jquery-ui.css">
        </head>
        <body>
            <div class="container">
                <h2 style="text-align: center">Cambiar Contraseña</h2>
                <form action="procesos/contrasena/procesar_cambio.php" method="post" class="col-sm-4 offset-sm-4">
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Nueva Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                </form>
            </div>
            <script src="resources/librerias/jquery-3.7.1.min.js"></script>
            <script src="resources/librerias/jquery-ui-1.13.2/jquery-ui.js"></script>
            <script src="resources/librerias/sweetalert.min.js"></script>
            <script type="text/javascript">
                // Puedes agregar aquí cualquier script adicional que necesites para la página
            </script>
        </body>
    </html>
    <?php
} else {
    header("Location: solicitud_cambio.php");
    exit();
}
?>
