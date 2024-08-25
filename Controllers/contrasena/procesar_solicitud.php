<?php
session_start();
ini_set('max_execution_time', 360); // Establece el límite a 300 segundos (5 minutos)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../PHPMailer/Exception.php';
require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];

    // Verifica si el correo existe en la base de datos
    if (verificarCorreo($correo)) {
        // Genera una nueva contraseña segura
        $nueva_contrasena = generarContrasenaSegura();

        // Guarda la nueva contraseña en la base de datos encriptada
        $hash_contrasena = sha1($nueva_contrasena);
        guardarContrasenaEncriptada($correo, $hash_contrasena);

        // Configuración de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mail.yahoo.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'vovin_therion@yahoo.com'; // Reemplaza con tu dirección de correo
            $mail->Password = 'vhgcitriijdktint'; // Reemplaza con tu contraseña
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Configuración del correo
            $mail->setFrom('vovin_therion@yahoo.com', 'GAD las Pampas'); // Reemplaza con tu dirección de correo y nombre
            $mail->addAddress($correo); // Dirección del destinatario
            $mail->Subject = 'Recuperación de Contraseña';
            $mail->Body = "Tu nueva contraseña es: $nueva_contrasena";

            // Envía el correo
            $mail->send();
?>
            <script src="../../librerias/sweetalert.min.js"></script>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(function () {
                        swal("Solicitud enviada", "Por favor, revisa tu correo para obtener la nueva contraseña.", "success");
                    }, 500);
                    setTimeout(function () {
                        window.location.href = "../../index.php";
                    }, 3000);
                });
            </script>
<?php
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
?>
        <script src="../../librerias/sweetalert.min.js"></script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                swal("Error", "El correo ingresado no está registrado en nuestro sistema.", "error")
                .then(function() {
                    window.location.href = "../../index.php";
                });
            });
        </script>
<?php
    }
} else {
    header("Location: ../../solicitud_cambio.php");
    exit();
}

// Función para verificar si el correo existe en la base de datos
function verificarCorreo($correo) {
    $conn = new mysqli("localhost", "gad", "gad12345", "gestor");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    $resultado = $stmt->num_rows > 0;
    $stmt->close();
    $conn->close();

    return $resultado;
}

// Función para guardar la nueva contraseña en la base de datos encriptada
function guardarContrasenaEncriptada($correo, $hash_contrasena) {
    $conn = new mysqli("localhost", "gad", "gad12345", "gestor");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hash_contrasena, $correo);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Función para generar una contraseña segura
function generarContrasenaSegura() {
    $caracteres = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+";
    $longitud = 12;
    return substr(str_shuffle($caracteres), 0, $longitud);
}
?>
