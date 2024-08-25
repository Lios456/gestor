function agregarArchivosGestor() {
    var formData = new FormData(document.getElementById('frmArchivos'));
    $.ajax({
        url: "../Controllers/gestor/guardarArchivos.php",
        type: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            console.log(respuesta);
            respuesta = respuesta.trim();

            if (respuesta === 'subida-correcta') {
                $('#frmArchivos')[0].reset();
                $('#tablaGestorArchivos').load("gestor/tablaGestor.php");
                swal(":D", "Archivo agregado con éxito!", "success");
            } else if (respuesta === 'extension-no-permitida') {
                swal(":(", "El archivo no está permitido. Solo se permiten archivos PDF, DOCX y XLSX.", "error");
            } else {
                swal(":(", "Falló al agregar el archivo.", "error");
            }
        },
        error: function(error){
            console.log(error);
        }
    });
}

function eliminarArchivo(idArchivo) {
    swal({
            title: "Estás seguro de eliminar este archivo?",
            text: "Una vez eliminado, debe comunicarse con el Administrador para restaurarlo!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    data: "idArchivo=" + idArchivo,
                    url: "../Controllers/gestor/eliminarArchivo.php",
                    success: function(respuesta) {
                        console.log(respuesta);
                        respuesta = respuesta.trim();
                        if (respuesta == 1) {
                            $('#tablaGestorArchivos').load("gestor/tablaGestor.php");
                            swal("Eliminado con éxito!", {
                                icon: "success",
                            });
                        } else {
                            swal("Error al eliminar!", {
                                icon: "error",
                            });
                        }


                    }
                });
            }
        });
}

function obtenerArchivoPorId(idArchivo) {
    $.ajax({
        type: "POST",
        data: { idArchivo: idArchivo },
        url: "../Controllers/gestor/obtenerArchivo.php",
        success: function(respuesta) {
            console.log("La Respuesta AJAX: ", respuesta, " ID del archivo = ", idArchivo);
            $('#archivoObtenido').html(respuesta);
            $('#visualizarArchivo').modal('show');  // Mostrar el modal después de cargar el archivo
        },
        error: function(xhr, status, error) {
            console.error("Error en AJAX: ", error);
        }
    });

}


function prepararModalModificar(idArchivo) {
    // Lógica para preparar el modal con los datos del archivo a modificar
    $('#modalModificarArchivos').modal('show');
    $('#idArchivoModificar').val(idArchivo);
}

function modificarArchivosGestor() {
    var formDataModificar = new FormData(document.getElementById('frmArchivosModificar'));
    $.ajax({
        url: "../Controllers/gestor/modificarArchivos.php",
        type: "POST",
        dataType: "html",
        data: formDataModificar,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            console.log(respuesta);
            respuesta = respuesta.trim();

            if (respuesta === 'modificacion-correcta') {
                $('#frmArchivosModificar')[0].reset();
                $('#modalModificarArchivos').modal('hide');
                $('#tablaGestorArchivos').load("gestor/tablaGestor.php");
                swal(":D", "Archivo modificado con éxito!", "success");
            } else if (respuesta === 'extension-no-permitida') {
                swal(":(", "El archivo no está permitido. Solo se permiten archivos PDF, DOCX y XLSX.", "error");
            } else {
                swal(":(", "El archivo no está permitido. Solo se permiten archivos PDF, DOCX y XLSX.", "error");
            }



        }
    });
}