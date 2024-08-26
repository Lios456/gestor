<?php

if (isset($_POST['nombreArchivo'])) {
    $archivo = basename($_POST['nombreArchivo']);
    $rutaArchivo = 'archivos/' . $_POST['nombreUsuario'] . "/" . $archivo;

    // Verificar si el archivo existe
    if (file_exists($rutaArchivo)) {
        // Establecer las cabeceras para forzar la descarga
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $archivo . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($rutaArchivo));

        // Limpiar el buffer de salida antes de enviar el archivo
        ob_clean();
        flush();

        // Leer el archivo y enviarlo al usuario
        readfile($rutaArchivo);
        exit;
    } else {
        die('El archivo no existe en la ruta especificada.');
    }
} else {
    die('No se ha especificado ningún archivo para descargar.');
}

?>