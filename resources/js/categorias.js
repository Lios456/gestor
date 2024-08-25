function agregarCategoria() {
    var categoria = $('#nombreCategoria').val();
    if (categoria == "") {
        swal("Debes agregar una categoría");
        return false;
    } else {
        $.ajax({
            type: "POST",
            data: "categoria=" + categoria,
            url: "../procesos/categorias/agregarCategoria.php",
            success: function(respuesta) {
                respuesta = respuesta.trim();

                if (respuesta == 1) {
                    $('#tablaCategorias').load("categorias/tablaCategoria.php");
                    $('#nombreCategoria').val("");
                    swal(":D", "Agregado con éxito!", "success");
                } else {
                    swal(":(", "Falló al entrar!", "error");
                }
            }
        });
    }
}

function eliminarCategorias(idCategoria) {
    idCategoria = parseInt(idCategoria);

    if (idCategoria < 1 || isNaN(idCategoria)) {
        swal("No tienes un ID de categoría válido.");
        return false;
    } else {
        swal({
                title: "¿Estás seguro de eliminar esta categoría?",
                text: "Una vez eliminada, no podrá recuperarse.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        data: { idCategoria: idCategoria }, // Usar un objeto para pasar los datos
                        url: "../procesos/categorias/eliminarCategoria.php",
                        success: function(respuesta) {
                            respuesta = respuesta.trim();
                            if (respuesta == 1) {
                                $('#tablaCategorias').load("categorias/tablaCategoria.php");
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

function obtenerDatosCategoria(idCategoria) {
    $.ajax({
        type: "POST",
        data: "idCategoria=" + idCategoria,
        url: "../procesos/categorias/obtenerCategoria.php",
        success: function(respuesta) {
            respuesta = jQuery.parseJSON(respuesta);

            $('#idCategoria').val(respuesta['idCategoria']);
            $('#categoriaU').val(respuesta['nombreCategoria']);
        }
    });
}

function actualizaCategoria() {
    if ($('#categoriaU').val() == "") {
        swal("No hay categoría!!");
        return false;
    } else {
        $.ajax({
            type: "POST",
            data: $('#frmActualizaCategoria').serialize(),
            url: "../procesos/categorias/actualizaCategoria.php",
            success: function(respuesta) {
                respuesta = respuesta.trim();
                if (respuesta == 1) {
                    $('#tablaCategorias').load("categorias/tablaCategoria.php");
                    $('#btnCerrarUpdateCategoria').click();
                    swal(":D", "Actualizado con éxito!", "success");
                } else {
                    swal(":(", "Falló al actualizar!", "error");
                }
            }
        })
    }
}