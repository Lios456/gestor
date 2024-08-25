<?php
    session_start();
    require_once "../../clases/Categorias.php"; // Agregar punto y coma aquí
    $Categorias = new Categorias();
    echo $Categorias->eliminarCategoria($_POST['idCategoria']);
?>