<?php
    session_start();
    require_once "../../clases/GestorUsuarios.php";
    $GestorUsuarios = new GestorUsuarios();
    echo $GestorUsuarios->eliminarUsuario($_POST['idUsuario']);
?>
