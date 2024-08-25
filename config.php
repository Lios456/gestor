<?php 
global $nombre_usuario;
$nombre_usuario = '';
if(PHP_OS == "WINNT"){
    $GLOBALS['ruta_raiz'] = "C:xampp/htdocs/gestor/procesos/gestor/archivos/";
    $GLOBALS['ruta_archivos'] = "C:xampp/htdocs/gestor/procesos/gestor/archivos/";
}else{
    if(PHP_OS == "Linux"){
        $GLOBALS['ruta_raiz'] = "/var/www/html/gestor/procesos/gestor/archivos/";
        $GLOBALS['ruta_archivos'] = $GLOBALS['ruta_raiz'];
    }
}


?>