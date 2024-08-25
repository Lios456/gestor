<?php
session_start();
require_once "../../clases/Gestor.php";

$Gestor = new Gestor();
$idArchivo = $_POST['idArchivo'];
$idUsuario = $_SESSION['idUsuario'];

if ($Gestor->eliminarRegistroArchivoPapelera($idArchivo)) {
    echo 1; 
} else {
    echo 0; 
}
?>