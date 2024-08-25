<?php
require_once "../../Modelos/GestorUsuarios.php";

try {
    $GestorUsuarios = new GestorUsuarios();
    $usuarios = $GestorUsuarios->obtenerUsuarios($_POST['idUsuario']);

    // Verificar si $usuarios es un array antes de recorrerlo
    if (is_array($usuarios)) {
        // Recorrer el array de usuarios
        foreach ($usuarios as $usuario) {
            // Verificar si la clave 'correo' existe en cada elemento del array
            $correo = isset($usuario['correo']) ? $usuario['correo'] : 'Correo no definido';

            // Puedes usar $correo en tu lógica aquí
        }

        // Codificar el array en JSON
        echo json_encode($usuarios);
    } else {
        throw new Exception('Error al obtener usuarios.');
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
