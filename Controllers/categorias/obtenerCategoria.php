<?php
    require_once "../../Modelos/Categorias.php";
    $Categorias = new Categorias();
    echo json_encode( $Categorias->obtenerCategoria($_POST['idCategoria']));
?>