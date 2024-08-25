<?php
session_start();
require_once "../../../clases/Usuario.php";
error_reporting(E_ALL);
ini_set('display_errors', '1');

$usuario = $_POST['login'];
$password = sha1($_POST['password']);

$usuarioObj = new Usuario();

$resultadoLogin = $usuarioObj->login($usuario, $password);

// Verificar si el inicio de sesión fue exitoso
if ($resultadoLogin == 1) {
    // Obtener el rol del usuario
    $rolUsuario = $usuarioObj->obtenerRol($usuario);

    // Almacenar el rol en la sesión
    $_SESSION['rolUsuario'] = $rolUsuario;

    // Devolver un mensaje de éxito
    echo "1";
} else {
    // Devolver un mensaje de error
    echo "Falló al entrar. Por favor, verifica tus credenciales.";
}
?>
