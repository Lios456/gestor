<?php
error_log(print_r($_POST, true));

session_start();
require_once "../../Modelos/GestorUsuarios.php";

$GestorUsuarios = new GestorUsuarios();

$nombreUsuario = $_POST['agregarNombreUsuario'] ?? '';
$fechaNacimientoUsuario = $_POST['agregarFechaNacimiento'] ?? '';
$correoUsuario = $_POST['agregarCorreoUsuario'] ?? '';
$usuarioUsuario = $_POST['agregarUsuarioUsuario'] ?? '';
$passwordUsuario = $_POST['agregarPasswordUsuario'] ?? '';
$rolUsuario = $_POST['agregarRolUsuario'] ?? '';

// Validar fecha de nacimiento
$fechaNacimiento = DateTime::createFromFormat('Y-m-d', $fechaNacimientoUsuario);
if (!$fechaNacimiento || $fechaNacimiento->format('Y-m-d') !== $fechaNacimientoUsuario) {
    echo "Fecha de nacimiento inválida";
    exit;
}

// Validar correo electrónico
if (!filter_var($correoUsuario, FILTER_VALIDATE_EMAIL)) {
    echo "Correo electrónico inválido";
    exit;
}

// Validar contraseña
if (!validarContrasena($passwordUsuario)) {
    echo "Contraseña no cumple con los criterios de seguridad";
    exit;
}

$password = sha1($passwordUsuario);

$datos = array(
    "nombre" => $nombreUsuario,
    "fechaNacimiento" => $fechaNacimiento->format('Y-m-d'),
    "correo" => $correoUsuario,
    "usuario" => $usuarioUsuario,
    "password" => $password,
    "rol" => $rolUsuario
);

$resultado = $GestorUsuarios->agregarUsuario($datos);

if ($resultado === true) {
    echo "1"; // Éxito
} else {
    echo "0"; // Falló
}

function validarContrasena($contrasena) {
    // Requisitos: al menos 8 caracteres, una mayúscula, una minúscula y un carácter especial
    $patron = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/';
    return preg_match($patron, $contrasena);
}
?>
