<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestión de Archivos GAD Las Pampas</title>
        <link rel="stylesheet" type="text/css" href="../librerias/bootstrap5/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../librerias/fontawesome/css/all.css">
        <link rel="stylesheet" type="text/css" href="../librerias/datatable/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" type="text/css" href="../librerias/jquery-ui-1.13.2/jquery-ui.theme.css">
        <link rel="stylesheet" type="text/css" href="../librerias/jquery-ui-1.13.2/jquery-ui.css">
        <script src="../librerias/mammoth.browser.min.js"></script>
        <script src="../librerias/showdown.min.js"></script>
    </head>
    <body style="background-color: aliceblue">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container">
            <a class="navbar-brand" href="inicioAdmin.php">
            <img src="../img/logo.jpg" alt="" width="70px">
            </a>
            <h1 style="color: aliceblue !important;">Panel de Administrador</h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="inicioAdmin.php"><span class="fa-solid fa-house"></span>Inicio
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categorias.php"><span class="fa-solid fa-layer-group"></span>Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gestor.php"><span class="fa-solid fa-folder"></span>Gestión de Archivos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gestorUsuarios.php"><span class="fa-solid fa-users"></span>Gestión de Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="papelera.php"><span class="fa-solid fa-trash-alt"></span>Papelera</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="auditoria.php"><span class="fa-solid fa-file"></span>Auditoría</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../procesos/usuario/salir.php" style="color: red"><span class="fa-solid fa-power-off"></span>Salir</a>
                </li>
            </ul>
            </div>
        </div>
        </nav>
