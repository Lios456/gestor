<?php
    session_start();
    require_once "../../clases/Auditoria.php"; 
    $Auditoria = new Auditoria();
    echo $Auditoria->eliminarAuditoria($_POST['idAuditoria']);
?>