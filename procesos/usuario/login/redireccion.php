<?php
session_start();

if (isset($_SESSION['rolUsuario'])) {
    $rolUsuario = $_SESSION['rolUsuario'];

    if ($rolUsuario == 'administrador') {
        header("Location: ../../../vistas/inicioAdmin.php");
        exit();
    } elseif ($rolUsuario == 'usuario') {
        header("Location: ../../../vistas/inicioUsuario.php");
        exit();
    } else {
        // Manejar el caso en que el rol no es ni administrador ni usuario
        echo "Error inesperado. Por favor, contacta al administrador.";
        exit();
    }
} else {
    // Si no hay información de rol en la sesión, redirigir al index.php
    header("Location: ../../../index.php");
    exit();
}
?>
