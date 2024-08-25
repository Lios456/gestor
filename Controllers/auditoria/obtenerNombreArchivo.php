<?php
require_once "..\\..\\Modelos\\Gestor.php";  // Ajusta la ruta según tu estructura de archivos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idArchivo"])) {
    $idArchivo = $_POST["idArchivo"];

    // Crea una instancia del gestor (asegúrate de que la clase Gestor esté incluida)
    $gestor = new Gestor();

    // Llama a la función obtenNombreArchivoAnterior y devuelve el resultado como respuesta
    $nombreArchivoAnterior = $gestor->obtenNombreArchivoAnterior($idArchivo);

    echo $nombreArchivoAnterior;
} else {
    // Si no es una solicitud POST o falta el parámetro idArchivo, devuelve un mensaje de error
    echo "Error: Parámetros incorrectos.";
}
?>
