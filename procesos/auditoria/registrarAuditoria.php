<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];
    $nombreArchivo = $_POST['nombreArchivo'];
    $idUsuario = $_POST['idUsuario'];
    $idArchivo = $_POST['idArchivo'];

    require_once "../../clases/Gestor.php"; // Ajusta la ruta según tu estructura de carpetas

    $gestor = new Gestor();
    $gestor->registrarAuditoria($accion, "Se $accion el archivo: $nombreArchivo", $idUsuario, $idArchivo);

    echo json_encode(['success' => true]);
}
?>
