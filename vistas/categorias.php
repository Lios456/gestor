<?php 
    session_start();
    include "funciones.php";
    if (isset($_SESSION['usuario'])){
        include "header.php";
        // Verificar el rol del usuario
        $rolUsuario = obtenerRolUsuario();

        if ($rolUsuario != 'administrador') {
            // Si el usuario no tiene el rol correcto, redirigir a una página por defecto o mostrar un mensaje de error
            redirigirInicio();
        }
?>
    
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Categorías</h1>
            <div class="row">
                <div class="col-sm-4">
                    <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregaCategoria">
                        <span class="fas fa-plus-circle"></span> Agregar nueva categoría
                    </span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <div id="tablaCategorias"></div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="modalAgregaCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar nueva categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmCategorias">
                        <label>Nombre de la categoría</label>
                        <input type="text" name="nombreCategoria" id="nombreCategoria" class="form-control">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarCategoria">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalActualizarCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmActualizaCategoria">
                    <input type="text" id="idCategoria" name="idCategoria" hidden="">
                    <label>Categoria</label>
                    <input type="text" id="categoriaU" name="categoriaU" class="form-control">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCerrarUpdateCategoria">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btnActualizaCategoria">Actualizar</button>
            </div>
            </div>
        </div>
    </div>
    
<?php
        include "footer.php";
?>
    <!--Dependencia de categorías, todas las funciones js de categorías-->
    <script src="../js/categorias.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablaCategorias').load("categorias/tablaCategoria.php");
            $('#btnGuardarCategoria').click(function(){
                agregarCategoria();
            });
            $('#btnActualizaCategoria').click(function(){
                actualizaCategoria();
            });      
        });
    </script>
<?php 
    }else{
        header("location:../index.php");
    }
?>
    