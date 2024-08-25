<?php
// verificarUsuario.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir el nombre de usuario desde la solicitud AJAX
    $usuario = $_POST['agregarUsuarioUsuario'] ?? '';

    // Realizar la verificación de existencia de usuario
    $usuarioExiste = verificarUsuarioExistente($usuario);

    // Enviar la respuesta al cliente
    echo $usuarioExiste ? '1' : '0';
} else {
    // Si la solicitud no es de tipo POST, devolver un mensaje de error
    echo 'Método de solicitud no permitido';
}

function verificarUsuarioExistente($usuario) {
    // Configuración de la conexión a la base de datos (ajusta estos valores)
    $host = 'localhost';
    $usuarioBD = 'gad';
    $contrasenaBD = 'gad12345';
    $nombreBD = 'gestor';

    // Crear una conexión a la base de datos
    $conexion = new mysqli($host, $usuarioBD, $contrasenaBD, $nombreBD);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die('Error de conexión a la base de datos: ' . $conexion->connect_error);
    }

    // Preparar la consulta SQL
    $consulta = $conexion->prepare("SELECT COUNT(*) as existe FROM usuarios WHERE usuario = ?");

    // Vincular parámetros
    $consulta->bind_param('s', $usuario);

    // Ejecutar la consulta
    $consulta->execute();

    // Vincular el resultado
    $consulta->bind_result($existe);

    // Obtener el resultado
    $consulta->fetch();

    // Cerrar la conexión y la consulta preparada
    $consulta->close();
    $conexion->close();

    // Retornar true si el usuario existe, false en caso contrario
    return $existe > 0;
}
?>
