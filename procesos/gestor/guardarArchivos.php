<?php
require_once "../../clases/Conexion.php";
session_start();
require_once "../../clases/Gestor.php";
include "C:/xampp/htdocs/gestor/config.php";
$Gestor = new Gestor();
$idCategoria = $_POST['categoriasArchivos'];
$idUsuario = $_SESSION['idUsuario'];

if ($_FILES['archivos']['size'] > 0) {
    $nombreArchivo = $_FILES['archivos']['name'];
    $explode = explode('.', $nombreArchivo);
    $tipoArchivo = array_pop($explode);

    $rutaAlmacenamiento = $_FILES['archivos']['tmp_name'];
    //obtener el nombre de usuario directo de la bdd

    $conexion = new Conectar();
    $con = $conexion->conexion();
    $sql = "SELECT  usuario as nombre_usuario FROM usuarios WHERE id_usuario = '$idUsuario'";
    $result = mysqli_query($con, $sql);
    $respuesta = mysqli_fetch_array($result)['nombre_usuario'];
    $nombre_usuario = $respuesta;

    $carpeta = '../../procesos/gestor/archivos/' . $respuesta . "/";
    $rutaFinal = $carpeta . $nombreArchivo;
    $datosRegistroArchivo = array(
                                "idUsuario"=> $idUsuario,
                                "idCategoria"=> $idCategoria,
                                "nombreArchivo"=> $nombreArchivo,
                                "tipo"=> $tipoArchivo,
                                "ruta"=> $rutaFinal
                            );

    if (move_uploaded_file($rutaAlmacenamiento, $rutaFinal)) {
        $respuesta=$Gestor->agregaRegistroArchivo($datosRegistroArchivo);
    }
    echo $respuesta;
    
    
} else {
    echo 0;
}
?>
