<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];
    $nombreArchivo = $_POST['nombreArchivo'];
    $idUsuario = $_POST['idUsuario'];
    $idArchivo = $_POST['idArchivo'];
    $nombreant = $_POST['nombreArchivoAnterior'];
    require_once "../../Modelos/Gestor.php"; // Ajusta la ruta según tu estructura de carpetas

    $gestor = new Gestor();
    if($gestor->registrarAuditoria($idUsuario, $accion, $idArchivo, "Se $accion el archivo: $nombreArchivo", $nombreant, $nombreArchivo)){
        echo json_encode(['success' => true]);
    }else{
        echo 'Error al Insertar Auditoría';
    }

    
}
?>
