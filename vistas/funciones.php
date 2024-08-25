<?php
function verificarSesion() {
    return isset($_SESSION['usuario']);
}

function obtenerRolUsuario() {
    return isset($_SESSION['rolUsuario']) ? $_SESSION['rolUsuario'] : null;
}

function redirigirIndex() {
    header("location:../index.php");
    exit();
}

function redirigirInicio() {
    $rolUsuario = obtenerRolUsuario();

    if ($rolUsuario == 'administrador') {
        header("location:inicioAdmin.php");
    } elseif ($rolUsuario == 'usuario') {
        header("location:inicioUsuario.php");
    } else {
        header("location:../index.php");
    }
    exit();
}
?>
