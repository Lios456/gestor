<?php
class Conectar
{
    public function conexion()
    {
        $servidor = "localhost";
        $usuario = "root"; //"gad";
        $password = "" ;//"gad12345";
        $base = "gestor";

        $conexion = mysqli_connect($servidor, $usuario, $password, $base);

        if (!$conexion) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        return $conexion;
    }

 
}
?>
