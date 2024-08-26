<?php
error_log(print_r($_POST, true));
require_once "../../Modelos/GestorUsuarios.php";
$GestorUsuarios = new GestorUsuarios();

$fechaNacimiento = date('Y-m-d', strtotime($_POST['fechaNacimientoUsuarioU']));

// Validar la fecha de nacimiento y calcular la edad
$fechaNacimientoObj = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
if (!$fechaNacimientoObj) {
    echo "Fecha de nacimiento inválida";
    exit;
}

$hoy = new DateTime();
$diferencia = $hoy->diff($fechaNacimientoObj);
$edad = $diferencia->y;

// Validar que la edad esté entre 18 y 80 años
if ($edad < 18 || $edad > 80) {
    echo "La edad no es correcta";
    exit;
}

// Validar el correo electrónico
$email = $_POST['correoUsuarioU'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Error: Correo electrónico no válido";
    exit();
}

// Generar el hash de la contraseña solo si se proporciona una nueva contraseña
$passwordHash = isset($_POST['passwordUsuarioU']) && !empty($_POST['passwordUsuarioU'])
    ? sha1($_POST['passwordUsuarioU'])
    : null;

$datos = array(
    "idUsuario" => $_POST['idUsuario'],
    "nombre" => $_POST['nombreUsuarioU'],
    "fechaNacimiento" => $fechaNacimiento,
    "email" => $email,
    "usuario" => $_POST['nombreUsuario'],
    "password" => $passwordHash,
    "rol" => $_POST['rolUsuarioU']
);

$resultado = $GestorUsuarios->actualizarUsuario($datos);

if ($resultado === false) {
    echo "Error al actualizar el usuario";
    error_log("Error al actualizar el usuario en la base de datos");
} else {
    echo $resultado;
}
?>
