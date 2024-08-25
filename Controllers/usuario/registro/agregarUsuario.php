<?php
require_once "../../../Modelos/Usuario.php";

$password = sha1($_POST['password']);
$fechaNacimiento = explode("-",$_POST['fechaNacimiento']);
$fechaNacimiento = $fechaNacimiento[2] . "-" . $fechaNacimiento[1] . "-" . $fechaNacimiento[0];

$datos = array(
    "nombre" => $_POST['nombre'],
    "fechaNacimiento" => $fechaNacimiento,
    "correo" => $_POST['correo'],
    "usuario" => $_POST['usuario'],
    "password" => $password,
    "rol" => "usuario"  // Agrega el tipo de usuario aquí
);

$usuario = new Usuario();
echo $usuario->agregarUsuario($datos);
?>
