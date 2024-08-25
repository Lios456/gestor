function eliminarAuditoria(idAuditoria) {
    idAuditoria = parseInt(idAuditoria);

    if (idAuditoria < 1 || isNaN(idAuditoria)) {
        swal("No tienes un ID de auditoría válido.");
        return false;
    } else {
        swal({
                title: "¿Estás seguro de eliminar esta auditoría?",
                text: "Una vez eliminada, no podrá recuperarse.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        data: { idAuditoria: idAuditoria },
                        url: "../procesos/auditoria/eliminarAuditoria.php",
                        success: function(respuesta) {
                            respuesta = respuesta.trim();
                            if (respuesta == 1) {
                                $('#tablaAuditoria').load("auditoria/tablaAuditoria.php");
                                swal("Eliminado con éxito!", {
                                    icon: "success",
                                });
                            } else {
                                swal(":(", "Falló al eliminar!", "error");
                            }
                        }
                    });
                }
            });
    }
}