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

        // Restablecer índices si las tablas están vacías
        $this->restablecerIndices($conexion);

        return $conexion;
    }

    private function restablecerIndices($conexion)
    {
        // Agrega aquí las tablas que quieres verificar y restablecer
        $tablas = array("archivos", "papelera", "auditoria", "categorias", "usuarios");

        foreach ($tablas as $tabla) {
            $sql = "SELECT COUNT(*) FROM $tabla";
            $result = mysqli_query($conexion, $sql);

            if ($result) {
                $rowCount = mysqli_fetch_row($result)[0];

                if ($rowCount == 0) {
                    // La tabla está vacía, restablecer índices
                    $sqlRestablecer = "ALTER TABLE $tabla AUTO_INCREMENT = 1";
                    mysqli_query($conexion, $sqlRestablecer);
                }
            }
        }
    }
}
?>
