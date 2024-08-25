<?php
session_start();
require_once "../../Modelos/Gestor.php";

$Gestor = new Gestor();
$idArchivo = $_POST['idArchivoModificar'];

// Verificar si se ha enviado un archivo en la solicitud
if (isset($_FILES['archivosModificar']) && $_FILES['archivosModificar']['size'] > 0) {
    // Obtener información del archivo
    $nombreArchivo = $_FILES['archivosModificar']['name'];
    $explode = explode('.', $nombreArchivo);
    $tipoArchivo = array_pop($explode);

    // Lista de extensiones permitidas
    $extensionesPermitidas = array('pdf', 'docx', 'xlsx');

    // Verificar si la extensión del archivo está permitida
    if (!in_array(strtolower($tipoArchivo), $extensionesPermitidas)) {
        echo 'archivo-no-permitido';
        exit();
    }

    // Rutas y datos de archivo
    $rutaAlmacenamiento = $_FILES['archivosModificar']['tmp_name'];
    $carpeta = '../../archivos/';
    $rutaFinal = $carpeta . $nombreArchivo;
    // Obtén la fecha actual
    $fechaActual = date('Y-m-d H:i:s');

    // Datos para actualizar en la base de datos
    $datosArchivo = array(
        "nombreArchivo" => $nombreArchivo,
        "tipo" => $tipoArchivo,
        "ruta" => $rutaFinal
    );

    // Lógica para obtener el nombre del archivo original y su ruta
    $nombreOriginal = $Gestor->obtenNombreArchivo($idArchivo);
    $rutaOriginal = "../../archivos/" . $nombreOriginal;

    // Verificar si el archivo original existe
    if (file_exists($rutaOriginal)) {
        // Eliminar el archivo original
        if (unlink($rutaOriginal)) {
            // Mover el nuevo archivo a la carpeta de almacenamiento
            if (move_uploaded_file($rutaAlmacenamiento, $rutaFinal)) {
                // Actualizar la información en la base de datos
                $respuesta = $Gestor->modificarRegistroArchivo($idArchivo, $datosArchivo);

                echo $respuesta;
            } else {
                echo 'error-mover-archivo';
            }
        } else {
            echo 'error-eliminar-archivo-original';
        }
    } else {
        echo 'archivo-original-no-encontrado';
    }
} else {
    echo 'sin-archivo-modificado';
}
?>
