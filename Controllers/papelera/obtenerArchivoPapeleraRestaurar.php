<?php
    session_start();
    require_once "../../Modelos/Gestor.php";

    $Gestor = new Gestor();
    $idArchivo = $_POST['idArchivo'];

    echo $Gestor->obtenerRutaArchivoPapeleraRestaurar($idArchivo);

?>