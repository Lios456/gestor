<?php

if (isset($_GET['nombreArchivo']) && isset($_GET['nombreUsuario'])) {
    $archivo = basename($_GET['nombreArchivo']);
    $nombreUsuario = basename($_GET['nombreUsuario']);
    $rutaArchivo = '../../Controllers/gestor/archivos/' . $nombreUsuario . "/" . $archivo;


    if (file_exists($rutaArchivo)) {
        try {

            $tiposMime = [
                'pdf' => 'application/pdf',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'zip' => 'application/zip',
                'txt' => 'text/plain',
            ];

            $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

            $tipoMime = isset($tiposMime[$extension]) ? $tiposMime[$extension] : 'application/octet-stream';

            header('Content-Description: File Transfer');
            header('Content-Type: ' . $tipoMime);
            header('Content-Disposition: attachment; filename="' . $archivo . '"');
            header('Content-Length: ' . filesize($rutaArchivo));

            readfile($rutaArchivo);
            echo 'Location: gestor.php';
            exit;
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    } else {
        die('El archivo no existe en la ruta especificada.');
    }
} else {
    die('No se ha especificado ningún archivo para descargar.');
}

?>
