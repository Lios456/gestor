<?php
require_once "Conexion.php";
include 'C:/xampp/htdocs/gestor/config.php';
class Usuario extends Conectar{
    public string $ruta_archivos;
    public function __construct() {
        $this->ruta_archivos = $GLOBALS['ruta_archivos'];
    }
    public function agregarUsuario($datos){
        $conexion = Conectar::conexion();

         // Validar correo repetido
         if ($this->buscarCorreoRepetido($datos['correo'])) {
            return 3; // Correo repetido
        } 
        
        if($this->buscarUsuarioRepetido($datos['usuario'])){
            return 2; // Usuario repetido
        } else {
            $sql = "INSERT INTO usuarios (nombre, fechaNacimiento, email, usuario, password, rol) VALUES (?, ?, ?, ?, ?, ?)";
            $query = $conexion->prepare($sql);

            // Verifica si la preparación de la consulta fue exitosa
            if ($query === false) {
                die('Error en la preparación de la consulta: ' . $conexion->error);
            }

            // Enlazar los parámetros
            $query->bind_param('ssssss', $datos['nombre'], $datos['fechaNacimiento'], $datos['correo'], $datos['usuario'], $datos['password'], $datos['rol']);

            // Ejecutar la consulta
            $exito = $query->execute();

            // Cerrar la conexión y la declaración preparada
            $query->close();
            $conexion->close();

            return $exito;
        }

        
    }

    public function buscarCorreoRepetido($correo) {
        $conexion = Conectar::conexion();
        $sql = "SELECT * FROM usuarios WHERE email ='$correo'";
        $result = mysqli_query($conexion, $sql);

        if(mysqli_num_rows($result) > 0){
            return true; // Correo repetido
        } else {
            return false; // Correo no repetido
        }
    }

    public function buscarUsuarioRepetido($usuario){
        $conexion = Conectar::conexion();
        $sql = "SELECT * FROM usuarios WHERE usuario ='$usuario'";
        $result = mysqli_query($conexion, $sql);

        if(mysqli_num_rows($result) > 0){
            return 1; // Usuario repetido
        } else {
            return 0; // Usuario no repetido
        }
    }

    public function login($usuario, $password){
        $conexion = Conectar::conexion();

        $sql = "SELECT  count(*) as existeUsuario FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
        $result = mysqli_query($conexion, $sql);
        $respuesta = mysqli_fetch_array($result)['existeUsuario'];

        if($respuesta > 0){
            $_SESSION['usuario'] = $usuario;
            $sql = "SELECT id_usuario FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
            $result = mysqli_query($conexion, $sql);
            $idUsuario = mysqli_fetch_row($result)[0];
            $_SESSION['idUsuario'] = $idUsuario;

            //Ruta de acceso según usuario
            
            $_SESSION['ruta_archivos'] = $this->ruta_archivos . $usuario;
            $_SESSION['nombre_usuario'] = $usuario;
            $GLOBALS['nombre_usuario'] = $usuario;
            return 1;
        }else{
            return 0;
        }
    }

    public function obtenerRol($usuario) {
        $conexion = Conectar::conexion();
    
        // Evitar la inyección SQL utilizando una consulta preparada
        $sql = "SELECT rol FROM usuarios WHERE usuario = ?";
        $query = $conexion->prepare($sql);
        
        // Verificar si la preparación de la consulta fue exitosa
        if ($query === false) {
            error_log("Error en la preparación de la consulta: " . $conexion->error);
            return null; // O puedes devolver un valor predeterminado para indicar el error
        }
    
        $query->bind_param("s", $usuario);
        
        // Ejecutar la consulta
        $query->execute();
        
        // Verificar si hubo un error en la ejecución de la consulta
        if ($query->error) {
            error_log("Error en la ejecución de la consulta: " . $query->error);
            return null; // O puedes devolver un valor predeterminado para indicar el error
        }
    
        $result = $query->get_result();
    
        // Verificar si se encontró el usuario
        if ($result->num_rows > 0) {
            $usuarioData = $result->fetch_assoc();
            $rol = $usuarioData['rol'];
    
            // Agregar mensaje de depuración al registro de errores
            error_log("Usuario: $usuario, Rol: $rol");
    
            return $rol;
        } else {
            // Agregar mensaje de depuración al registro de errores
            error_log("No se encontró el usuario: $usuario");
    
            return null; // O puedes devolver un valor predeterminado para indicar que no se encontró el rol
        }
    }
}
?>
