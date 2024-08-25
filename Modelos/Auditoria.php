<?php 
    require_once "Conexion.php";
    class Auditoria extends Conectar {

        public function eliminarAuditoria($idAuditoria){
            $conexion = Conectar::conexion();
            $sql = "DELETE FROM auditoria WHERE id_auditoria = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('i', $idAuditoria);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }

    }
?>