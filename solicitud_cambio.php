<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Cambio de Contraseña</title>
    <link rel="stylesheet" type="text/css" href="resources/librerias/bootstrap5/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="resources/librerias/jquery-ui-1.13.2/jquery-ui.theme.css">
    <link rel="stylesheet" type="text/css" href="resources/librerias/jquery-ui-1.13.2/jquery-ui.css">
</head>
<body>
    <div class="container">
        <h1 style="text-align: center">Solicitud de Cambio de Contraseña</h1>
        <hr>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <form action="cambiar_contrasena.php" method="post">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Regresar al Inicio</button>
                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
    <script src="resources/librerias/jquery-3.7.1.min.js"></script>
    <script src="resources/librerias/jquery-ui-1.13.2/jquery-ui.js"></script>
    <script src="resources/librerias/sweetalert.min.js"></script>
    <script type="text/javascript">
        // Puedes agregar aquí cualquier script adicional que necesites para la página
    </script>
</body>
</html>
