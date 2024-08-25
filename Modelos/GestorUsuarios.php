<?php
require_once "Conexion.php";

class GestorUsuarios extends Conectar
{
    public function agregarUsuario($datos)
    {
        $conexion = Conectar::conexion();
        $sql = "INSERT INTO usuarios (nombre, fechaNacimiento, email, usuario, password, rol) VALUES (?, ?, ?, ?, ?, ?)";
        $query = $conexion->prepare($sql);
        $query->bind_param("ssssss", $datos['nombre'], $datos['fechaNacimiento'], $datos['correo'], $datos['usuario'], $datos['password'], $datos['rol']);
        $respuesta = $query->execute();
        $query->close();

        // Crear un subdirectorio para los usuarios registrados
        $nombre = $datos['usuario'];
        $ruta = '../gestor/archivos/' . $nombre;

        // Verifica si el directorio ya existe
        if (!is_dir($ruta)) {
            if (mkdir($ruta, 0777, true)) {
                //echo "El directorio '$nombre' se creó correctamente.";
            } else {
                //echo "Hubo un error al crear el directorio '$nombre'.";
            }
        } else {
            //echo "El directorio '$nombre' ya existe.";
        }

        return $respuesta;
    }

    public function obtenerUsuarios($idUsuario)
    {
        $conexion = Conectar::conexion();
        $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idUsuario);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            return $usuario;
        } else {
            return null;
        }
    }

    public function eliminarUsuario($idUsuario)
    {
        $conexion = Conectar::conexion();
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idUsuario);
        $respuesta = $query->execute();
        $query->close();
        return $respuesta;
    }

    public function actualizarUsuario($datos)
    {
        $conexion = Conectar::conexion();
        $sql = "UPDATE usuarios SET nombre = ?, fechaNacimiento = ?, email = ?, usuario = ?,password = ?, rol = ? WHERE id_usuario = ?";
        error_log("Consulta SQL: " . $sql); // Agregar este log
        $query = $conexion->prepare($sql);
        $query->bind_param("ssssssi", $datos['nombre'], $datos['fechaNacimiento'], $datos['email'], $datos['usuario'], $datos['password'], $datos['rol'], $datos['idUsuario']);
        $respuesta = $query->execute();
        $query->close();
        return $respuesta;
    }
}
?>
