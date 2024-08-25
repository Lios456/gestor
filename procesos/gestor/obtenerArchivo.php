<?php
session_start();
require_once "../../clases/Gestor.php";

$Gestor = new Gestor();
$idArchivo = $_POST['idArchivo'];

$nombreArchivo = $Gestor->obtenNombreArchivo($idArchivo);
$extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

// Depuración: Imprimir el nombre y extensión del archivo
error_log("Nombre del archivo: " . $nombreArchivo);
error_log("Extensión del archivo: " . $extension);

echo $Gestor->tipoArchivo($nombreArchivo, $extension);
?>
