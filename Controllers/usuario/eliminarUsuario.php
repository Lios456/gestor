<?php
    session_start();
    require_once "../../Modelos/GestorUsuarios.php";
    $GestorUsuarios = new GestorUsuarios();
    echo $GestorUsuarios->eliminarUsuario($_POST['idUsuario']);
?>
