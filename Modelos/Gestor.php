<?php
require_once "Conexion.php";

class Gestor extends Conectar {             
    public function agregaRegistroArchivo($datos) {
        $extensionesPermitidas = array('pdf', 'docx', 'xlsx');

        $nombreArchivo = $datos['nombreArchivo'];
        $extensionArchivo = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

        // Validar la extensión del archivo
        if (!in_array($extensionArchivo, $extensionesPermitidas)) {
            return 'extension-no-permitida'; // Código para indicar que la extensión no está permitida
        }
        $conexion = Conectar::conexion();
        $sql = "INSERT INTO archivos (id_usuario, id_categoria, nombre, tipo, ruta) VALUES (?, ?, ?, ?, ?)";
        $query = $conexion->prepare($sql);
        $query->bind_param("iisss", $datos['idUsuario'], $datos['idCategoria'], $datos['nombreArchivo'], $datos['tipo'], $datos['ruta']);
        $respuesta = $query->execute();
        $query->close();

        if ($respuesta) {
            $idArchivo = $conexion->insert_id;
            $detalle = "Se agregó un nuevo archivo con nombre: " . $datos['nombreArchivo'];
            $this->registrarAuditoriaCreacion("Agregar", $detalle, $_SESSION['idUsuario'], $idArchivo, $datos['nombreArchivo']); // Ajuste aquí
        }
        // Devolver un código adicional para indicar que se ha subido correctamente
        return $respuesta ? 'subida-correcta' : 'error-subida';
    }

    public function obtenNombreArchivoAnterior($idArchivo) {
        $conexion = Conectar::conexion();
        $sql = "SELECT nombre FROM archivos WHERE id_archivo = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idArchivo);
        $query->execute();
        $query->bind_result($nombreArchivo);
        $query->fetch();
        $query->close();

        return $nombreArchivo;
    }

    public function obtenNombreArchivo($idArchivo) {
        $conexion = Conectar::conexion();
        $sql = "SELECT nombre FROM archivos WHERE id_archivo = '$idArchivo'";
        $result = mysqli_query($conexion, $sql);

        return mysqli_fetch_array($result)['nombre'];
    }

    public function obtenerNombreArchivoAnterior($idArchivo) {
        $conexion = Conectar::conexion();
        $sql = "SELECT nombre FROM archivos WHERE id_archivo = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idArchivo);
        $query->execute();
        $query->bind_result($nombreArchivo);
        $query->fetch();
        $query->close();

        return $nombreArchivo;
    }

    public function obtenNombreArchivoAnteriorPapelera($idArchivo) {
        $conexion = Conectar::conexion();
        $sql = "SELECT nombre FROM papelera WHERE id_archivo = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idArchivo);
        $query->execute();
        $query->bind_result($nombreArchivo);
        $query->fetch();
        $query->close();

        return $nombreArchivo;
    }

    public function eliminarRegistroArchivo($idArchivo) {
        $conexion = Conectar::conexion();

        
        $idArchivoAnterior = $idArchivo;
        $nombreArchivoAnterior = $this->obtenNombreArchivoAnterior($idArchivo);

        $idUsuario = $_SESSION['idUsuario'];
        $idCategoria = $this->obtenerIdCategoria($idArchivo);
        $tipoArchivo = $this->obtenerTipoArchivo($idArchivo);

        // Obtener la ruta real del archivo antes de copiarlo
        $rutaArchivo = $this->obtenerRutaArchivo($idArchivo);

        // Definir la ruta de la carpeta de la papelera
        $carpetaPapelera = "../Controllers/gestor/archivos/papelera/"; //Direccionamiento correcto para la ruta de la papelera
        $nuevaRuta = $carpetaPapelera . $nombreArchivoAnterior;

        // Crear la carpeta "papelera" si no existe
        if (!file_exists($carpetaPapelera)) {
            mkdir($carpetaPapelera, 0777, true);
        }

        // Agregar un registro en la tabla de papelera
        try{
            $sql = "UPDATE gestor.archivos SET estado = 'Borrado' WHERE id_archivo = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('i', $idArchivo);
            $respuesta = $query->execute();
            $query->close();
            if ($respuesta) {
                // Registro de auditoría después de mover a la papelera
                $detalle = "Se eliminó el archivo con ID $idArchivoAnterior y nombre: $nombreArchivoAnterior a la papelera";
                $this->registrarAuditoriaEliminacion("Enviar a Papelera", $detalle, $_SESSION['idUsuario'], $idArchivoAnterior, $nombreArchivoAnterior);
            }
            $this->agregarRegistroPapelera($idArchivo, $idUsuario, $idCategoria, $nombreArchivoAnterior, $tipoArchivo, $nuevaRuta);
        }catch(Exception $ex){
            echo $ex->getMessage();
            $respuesta = false;
        }
        

        return $respuesta;
    }

    public function obtenerIdCategoria($idArchivo) {
        $conexion = Conectar::conexion();
        $sql = "SELECT id_categoria FROM archivos WHERE id_archivo = ?";

        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idArchivo);
        $query->execute();
        $query->bind_result($idCategoria);
        $query->fetch();
        $query->close();

        return $idCategoria;
    }

    public function obtenerTipoArchivo($idArchivo) {
        $conexion = Conectar::conexion();
        $sql = "SELECT tipo FROM archivos WHERE id_archivo = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idArchivo);
        $query->execute();
        $query->bind_result($tipoArchivo);
        $query->fetch();
        $query->close();

        return $tipoArchivo;
    }

    private function agregarRegistroPapelera($idArchivo, $idUsuario, $idCategoria, $nombreArchivo, $tipoArchivo, $rutaArchivo) {
        $conexion = Conectar::conexion();
        $sql = "INSERT INTO papelera (id_archivo, id_usuario, nombre, tipo, ruta, fecha_eliminacion) VALUES (?,?,?,?,?,NOW())";
        $query = $conexion->prepare($sql);
        $query->bind_param("iisss", $idArchivo, $idUsuario, $nombreArchivo, $tipoArchivo, $rutaArchivo);
        $query->execute();
        $query->close();
    }

    public function obtenerRutaArchivo($idArchivo) {
        $conexion = Conectar::conexion();
        $sql = "SELECT ruta FROM archivos WHERE id_archivo = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idArchivo);
        $query->execute();
        $query->bind_result($ruta);
        $query->fetch();
        $query->close();

        return $ruta;
    }

    public function obtenerRutaArchivoPapelera($idArchivo) {
        $conexion = Conectar::conexion();
        $sql = "SELECT nombre, tipo FROM archivos WHERE id_archivo = '$idArchivo'";
        $result = mysqli_query($conexion, $sql);
        $datos = mysqli_fetch_array($result);
        $nombreArchivo = $datos['nombre'];
        $extension = $datos['tipo'];
        return self::tipoArchivo($nombreArchivo, $extension);
    }

    public function obtenerRutaArchivoPapeleraRestaurar($idArchivo) {
        $conexion = Conectar::conexion();
        $sql = "SELECT ruta FROM papelera WHERE id_archivo = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idArchivo);
        $query->execute();
        $query->bind_result($ruta);
        $query->fetch();
        $query->close();

        return $ruta;
    }

    public function tipoArchivo($nombre, $extension) {
        include 'C:/xampp/htdocs/gestor/config.php';
        $rutaAbsoluta = "/gestor/Controllers/gestor/archivos/" . $_SESSION['nombre_usuario']. "/" . $nombre;
        // Depuración: Imprimir la ruta del archivo
        error_log("Ruta del archivo: " . $rutaAbsoluta);
       
        /* ERROR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
        if (!file_exists($rutaAbsoluta)) {
            return "El archivo no existe en la ruta especificada " . $rutaAbsoluta;
        }
        */

        // Codificar espacios y caracteres especiales en la ruta para URL
        $rutaEncoded = rawurlencode($nombre);
        $rutaEncoded = str_replace("%2F", "/", $rutaEncoded);

        switch ($extension) {
            case 'docx':
                return $this->visualizarDOCX($rutaEncoded);
            case 'pdf':
                return '<embed src="' . $rutaAbsoluta . '" type="application/pdf" width="100%" height="600px" />';
            case 'xlsx':
                return $this->visualizarXLSX($rutaEncoded);
            default:
                return 'Tipo de archivo no compatible';
        }
    }

    public function modificarRegistroArchivo($idArchivo, $datosArchivo) {
        $conexion = Conectar::conexion();

        // Obtener el nombre del archivo antes de la modificación
        $nombreArchivoAnterior = $this->obtenNombreArchivoAnterior($idArchivo);

        // Modificar la sentencia SQL para incluir la actualización de la fecha y ambos nombres
        $sql = "UPDATE archivos SET nombre = ?, tipo = ?, ruta = ?, fecha = NOW() WHERE id_archivo = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param("sssi", $datosArchivo['nombreArchivo'], $datosArchivo['tipo'], $datosArchivo['ruta'], $idArchivo);

        $respuesta = $query->execute();

        // Después de la actualización exitosa, agregar un registro en la tabla de auditoría
        if ($respuesta) {
            $detalle = "Se modificó el archivo con ID $idArchivo. Nombre anterior: $nombreArchivoAnterior";
            $this->registrarAuditoriaActualizacion("Modificar", $detalle, $_SESSION['idUsuario'], $idArchivo, $nombreArchivoAnterior, $datosArchivo['nombreArchivo']);
        }

        $query->close();

        return $respuesta ? 'modificacion-correcta' : 'error-modificación';
    }

    public function restaurarArchivoPapelera($idArchivo) {
        $conexion = Conectar::conexion();
        /*
        // Obtener datos del archivo antes de restaurar
        $sql = "SELECT * FROM papelera WHERE id_archivo = ?";
        $query = $conexion->prepare($sql);
        $query->bind_param('i', $idArchivo);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();

            $idUsuario = $fila['id_usuario'];
            $idCategoria = $fila['id_categoria'];
            $nombreArchivo = $fila['nombre'];
            $tipoArchivo = $fila['tipo'];
            $rutaArchivo = $fila['ruta'];
            
            

            // Mover físicamente el archivo al directorio correspondiente
            $directorioDestino = "../Controllers/gestor/archivos/papelera" . $_SESSION['nombre_usuario'];  // Ajusta la ruta según tu estructura de carpetas
            $rutaArchivoRestaurado = $directorioDestino . '/' . $nombreArchivo;
            

            // Restaurar el archivo a la tabla de archivos
            $sqlRestaurar = "INSERT INTO archivos (id_usuario, id_categoria, nombre, tipo, ruta, fecha) VALUES (?, ?, ?, ?, ?, NOW())";
            $queryRestaurar = $conexion->prepare($sqlRestaurar);
            $queryRestaurar->bind_param("iisss", $idUsuario, $idCategoria, $nombreArchivo, $tipoArchivo, $rutaArchivoRestaurado);
            $restaurar = $queryRestaurar->execute();
            $queryRestaurar->close();

            // Obtener la nueva ID del archivo restaurado
            $idArchivoRestaurado = $conexion->insert_id;

            // Mover físicamente el archivo al directorio correspondiente
            if (rename($rutaArchivo, $rutaArchivoRestaurado)) {
                // Eliminar el registro de la papelera
                $sqlEliminarPapelera = "DELETE FROM papelera WHERE id_archivo = ?";
                $queryEliminarPapelera = $conexion->prepare($sqlEliminarPapelera);
                $queryEliminarPapelera->bind_param('i', $idArchivo);
                $eliminarPapelera = $queryEliminarPapelera->execute();
                $queryEliminarPapelera->close();

                if ($eliminarPapelera) {
                    return $idArchivoRestaurado; // Devuelve la nueva ID del archivo restaurado
                }
            }
        }
        */

        try{
            // RESTAURAMOS EL ESTADO DEL ARCHIVO
            $sql = "UPDATE gestor.archivos SET estado = 'Activo' WHERE id_archivo = ?";
            $cmd = $conexion->prepare($sql);
            $cmd->bind_param("i", $idArchivo);
            $cmd->execute();

            //  ELIMINAMOS EL REGISTRO DE LA PAPELERA
            $sql2 = "DELETE FROM gestor.papelera WHERE id_archivo = ?";
            $cmd2 = $conexion->prepare($sql2);
            $cmd2->bind_param("i",$idArchivo);
            $cmd2->execute();
            return true;
        }catch(Exception $ex){
            $msg = $ex->getMessage();
            echo "swa('$msg', 'error')";
            return false;
        }
        
    }

    private function registrarAuditoriaCreacion($accion, $detalle, $idUsuario, $idArchivo = null, $nombreArchivo = null) {
        $conexion = Conectar::conexion();
        $nombreArchivoAnterior = $this->obtenerNombreArchivoAnterior($idArchivo);

        $sql = "INSERT INTO auditoria (id_usuario, accion, detalle, id_archivo, nombre_archivo_anterior, nombre_archivo, fecha) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $query = $conexion->prepare($sql);
        $query->bind_param("isssss", $idUsuario, $accion, $detalle, $idArchivo, $nombreArchivoAnterior, $nombreArchivo);
        $query->execute();
        $query->close();
    }

    // Función para registrar auditoría de actualización con ambos nombres
    private function registrarAuditoriaActualizacion($accion, $detalle, $idUsuario, $idArchivo, $nombreArchivoAnterior, $nombreArchivoActual) {
        $conexion = Conectar::conexion();

        $sql = "INSERT INTO auditoria (id_usuario, accion, detalle, id_archivo, nombre_archivo_anterior, nombre_archivo, fecha) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $query = $conexion->prepare($sql);
        $query->bind_param("ississ", $idUsuario, $accion, $detalle, $idArchivo, $nombreArchivoAnterior, $nombreArchivoActual);
        $query->execute();
        $query->close();
    }

    // Nueva función para registrar auditoría de eliminación
    private function registrarAuditoriaEliminacion($accion, $detalle, $idUsuario, $idArchivo, $nombreArchivo) {
        $conexion = Conectar::conexion();

        $sql = "INSERT INTO auditoria (id_usuario, accion, detalle, id_archivo, nombre_archivo_anterior, nombre_archivo, fecha) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $query = $conexion->prepare($sql);
        $query->bind_param("ississ", $idUsuario, $accion, $detalle, $idArchivo, $nombreArchivo, $nombreArchivo);
        $query->execute();
        $query->close();
    }

    public function registrarAuditoria($idusu, $accion, $idarch, $detalle, $nombreant, $nombrearch) {
        try{
            $conexion = Conectar::conexion();

            $sql = "CALL sp_registrar_auditoria(?,?,?,?,?,?)";
            $query = $conexion->prepare($sql);
            $query->bind_param("isisss", $idusu, $accion, $idarch, $detalle, $nombreant, $nombrearch);
            $query->execute();
            $query->close();
            return true;
        }catch(Exception $ex){
            echo "Error al insertar auditoría" . $ex->getMessage();
            return false;
        }
    }

    public function eliminarRegistroArchivoPapelera($idArchivo) {
        $conexion = Conectar::conexion();

        // Obtener datos del archivo antes de eliminar
        $idArchivoAnterior = $idArchivo;  // Guarda el ID antes de eliminar
        $nombreArchivoAnterior = $this->obtenNombreArchivoAnteriorPapelera($idArchivo);

        // Obtener la ruta del archivo físico
        $rutaArchivo = "../../archivos/papelera/" . $nombreArchivoAnterior;

        // Eliminar el archivo físico
        if (unlink($rutaArchivo)) {
            // Eliminar el registro de la papelera
            $sql = "DELETE FROM papelera WHERE id_archivo = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('i', $idArchivo);
            $respuesta = $query->execute();
            $query->close();

            if ($respuesta) {
                // Registro de auditoría después de la eliminación del archivo
                $detalle = "Se eliminó el archivo con ID $idArchivoAnterior y nombre: $nombreArchivoAnterior";
                $this->registrarAuditoriaEliminacionPapelera("Eliminar", $detalle, $_SESSION['idUsuario'], $idArchivoAnterior, $nombreArchivoAnterior);
            }
        } else {
            // No se pudo eliminar el archivo físico
            $respuesta = false;
        }

        return $respuesta;
    }

    private function registrarAuditoriaEliminacionPapelera($accion, $detalle, $idUsuario, $idArchivo, $nombreArchivo) {
        $conexion = Conectar::conexion();

        $sql = "INSERT INTO auditoria (id_usuario, accion, detalle, id_archivo, nombre_archivo_anterior, nombre_archivo, fecha) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $query = $conexion->prepare($sql);
        $query->bind_param("ississ", $idUsuario, $accion, $detalle, $idArchivo, $nombreArchivo, $nombreArchivo);
        $query->execute();
        $query->close();
    }

    private function visualizarDOCX($rutaEncoded) {
        $htmlContent = '<div id="docxViewer" style="padding: 20px; border: 1px solid #ddd; background-color: #f9f9f9; margin-top: 20px;"></div>';
        $htmlContent .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.2/mammoth.browser.min.js"></script>';
        $htmlContent .= '<script>';
        $htmlContent .= 'fetch("/gestor/Controllers/gestor/archivos/' . $_SESSION['nombre_usuario'] . "/" . $rutaEncoded . '")';
        $htmlContent .= '.then(function(response) { return response.arrayBuffer(); })';
        $htmlContent .= '.then(function(buffer) { return mammoth.convertToHtml({ arrayBuffer: buffer }); })';
        $htmlContent .= '.then(function(result) {';
        $htmlContent .= '  document.getElementById("docxViewer").innerHTML = result.value;';
        $htmlContent .= '  styleDocxContent();';
        $htmlContent .= '})';
        $htmlContent .= '.catch(function(error) { console.error("Error:", error); });';
        $htmlContent .= '</script>';
        $htmlContent .= '<style>';
        $htmlContent .= '#docxViewer h1, #docxViewer h2, #docxViewer h3 {';
        $htmlContent .= '  font-family: Arial, sans-serif;';
        $htmlContent .= '  color: #333;';
        $htmlContent .= '  margin-bottom: 15px;';
        $htmlContent .= '}';
        $htmlContent .= '#docxViewer p {';
        $htmlContent .= '  font-family: Arial, sans-serif;';
        $htmlContent .= '  color: #666;';
        $htmlContent .= '  line-height: 1.6;';
        $htmlContent .= '}';
        $htmlContent .= '#docxViewer img {';
        $htmlContent .= '  max-width: 100%;';
        $htmlContent .= '  height: auto;';
        $htmlContent .= '}';
        $htmlContent .= '</style>';

        $htmlContent .= '<script>';
        $htmlContent .= 'function styleDocxContent() {';
        $htmlContent .= '  var docxViewer = document.getElementById("docxViewer");';
        $htmlContent .= '  var images = docxViewer.getElementsByTagName("img");';
        $htmlContent .= '  for (var i = 0; i < images.length; i++) {';
        $htmlContent .= '    images[i].style.maxWidth = "100%";';
        $htmlContent .= '    images[i].style.height = "auto";';
        $htmlContent .= '  }';
        $htmlContent .= '}';
        $htmlContent .= '</script>';

        return $htmlContent;
    }

    private function visualizarXLSX($rutaEncoded) {
        $sheetJSScriptPath = "../resources/librerias/xlsx.full.min.js";

        $htmlContent = '<div id="xlsxViewer" style="padding: 20px; border: 1px solid #ddd; background-color: #f9f9f9; margin-top: 20px;"></div>';
        $htmlContent .= '<script src="' . $sheetJSScriptPath . '"></script>';
        $htmlContent .= '<script>';
        $htmlContent .= 'var xhr = new XMLHttpRequest();';
        $htmlContent .= 'xhr.open("GET", "/gestor/Controllers/gestor/archivos/' . $_SESSION['nombre_usuario'] . "/" . $rutaEncoded . '", true);';
        $htmlContent .= 'xhr.responseType = "arraybuffer";';
        $htmlContent .= 'xhr.onload = function() {';
        $htmlContent .= '  var arraybuffer = xhr.response;';
        $htmlContent .= '  var data = new Uint8Array(arraybuffer);';
        $htmlContent .= '  var arr = new Array();';
        $htmlContent .= '  for(var i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);';
        $htmlContent .= '  var bstr = arr.join("");';
        $htmlContent .= '  var workbook = XLSX.read(bstr, {type:"binary"});';
        $htmlContent .= '  var sheet = workbook.Sheets[workbook.SheetNames[0]];';
        $htmlContent .= '  var htmlstr = XLSX.utils.sheet_to_html(sheet, {id: "data-table", editable: true});';
        $htmlContent .= '  document.getElementById("xlsxViewer").innerHTML = htmlstr;';
        $htmlContent .= '  styleTable();';
        $htmlContent .= '};';
        $htmlContent .= 'xhr.send();';

        $htmlContent .= 'function styleTable() {';
        $htmlContent .= '  var table = document.getElementById("data-table");';
        $htmlContent .= '  table.style.width = "100%";';
        $htmlContent .= '  table.style.borderCollapse = "collapse";';
        $htmlContent .= '  var ths = table.getElementsByTagName("th");';
        $htmlContent .= '  for (var i = 0; i < ths.length; i++) {';
        $htmlContent .= '    ths[i].style.backgroundColor = "#f2f2f2";';
        $htmlContent .= '    ths[i].style.border = "1px solid #ddd";';
        $htmlContent .= '    ths[i].style.padding = "8px";';
        $htmlContent .= '  }';
        $htmlContent .= '  var tds = table.getElementsByTagName("td");';
        $htmlContent .= '  for (var i = 0; i < tds.length; i++) {';
        $htmlContent .= '    tds[i].style.border = "1px solid #ddd";';
        $htmlContent .= '    tds[i].style.padding = "8px";';
        $htmlContent .= '  }';
        $htmlContent .= '}';
        $htmlContent .= '</script>';

        return $htmlContent;
    }
}
?>
