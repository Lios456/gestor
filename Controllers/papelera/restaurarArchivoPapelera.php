<?php
session_start();
require_once "../../Modelos/Gestor.php";

$Gestor = new Gestor();
$idArchivo = $_POST['idArchivo'];
$idUsuario = $_SESSION['idUsuario'];

if ($idArchivoRestaurado = $Gestor->restaurarArchivoPapelera($idArchivo)) {
    echo $idArchivoRestaurado; // Devuelve la nueva ID del archivo restaurado
} else {
    echo 0; // Error en la restauración
}
?>
