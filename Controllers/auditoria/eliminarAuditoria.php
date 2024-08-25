<?php
    session_start();
    require_once "../Modelos/Gestor.php";
    $Auditoria = new Auditoria();
    echo $Auditoria->eliminarAuditoria($_POST['idAuditoria']);
?>