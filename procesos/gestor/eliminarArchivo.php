<?php
session_start();
require_once "../../clases/Gestor.php";

$Gestor = new Gestor();
$idArchivo = $_POST['idArchivo'];
$idUsuario = $_SESSION['idUsuario'];

if ($Gestor->eliminarRegistroArchivo($idArchivo)) {
    echo 1; // Éxito al mover a la papelera
} else {
    echo 0; // Error al mover a la papelera
}
?>
