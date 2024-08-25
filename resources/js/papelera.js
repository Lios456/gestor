function eliminarArchivoPapelera(idArchivo) {
    swal({
        title: "Estás seguro de eliminar este archivo?",
        text: "Una vez eliminado, no podrá recuperarse!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                data: "idArchivo=" + idArchivo,
                url: "../Controllers/papelera/eliminarArchivoPapelera.php",
                success: function(respuesta) {
                    console.log(respuesta);
                    respuesta = respuesta.trim();
                    if (respuesta == 1) {
                        $('#tablaPapelera').load("papelera/tablaPapelera.php");
                        swal("Eliminado con éxito!", { icon: "success" });
                    } else {
                        swal("Error al eliminar!", { icon: "error" });
                    }
                }
            });
        }
    });
}

function restaurarArchivoPapelera(idArchivo) {
    swal({
        title: "Estás seguro de restaurar este archivo?",
        text: "El archivo se restaurará a su ubicación original!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willRestore) => {
        if (willRestore) {
            $.ajax({
                type: "POST",
                data: "idArchivo=" + idArchivo,
                url: "../Controllers/papelera/restaurarArchivoPapelera.php",
                success: function(respuesta) {
                    console.log(respuesta);
                    respuesta = respuesta.trim();
                    if (respuesta > 0) {
                        // La restauración fue exitosa
                        $('#tablaPapelera').load("papelera/tablaPapelera.php");
                        swal("Restaurado con éxito!", { icon: "success" });
                    } else {
                        // La restauración no fue exitosa
                        swal("Error al restaurar!", { icon: "error" });
                    }
                },
                error: function() {
                    // Ocurrió un error en la solicitud AJAX
                    swal("Error en la solicitud AJAX!", { icon: "error" });
                }
            });
        }
    });
}