<?php 
    session_start();
    include "funciones.php"; 
    if(isset($_SESSION['usuario'])){
    include "headerUsuario.php"; 
    // Verificar el rol del usuario
    $rolUsuario = obtenerRolUsuario();

    if ($rolUsuario != 'usuario') {
        // Si el usuario no tiene el rol correcto, redirigir a una página por defecto o mostrar un mensaje de error
        redirigirInicio();
    }
?>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Gestor de archivos</h1>
            <?php if ($rolUsuario != 'usuario'): ?>
            <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarArchivos">
                <span class="fas fa-plus-circle"></span> Agregar archivos
            </span>
            <?php endif; ?>
            <hr>
            <div id="tablaGestorArchivos"></div>
        </div>
    </div>

    <!-- Modal para agregar archivos -->
    <?php if ($rolUsuario != 'usuario'): ?>
    <div class="modal fade" id="modalAgregarArchivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmArchivos" enctype="multipart/form-data" method="post">
                    <label>Categoría</label>
                    <div id="categoriasLoad"></div>
                    <label>Selecciona Archivo</label>
                    <input type="file" name="archivos" id="archivos" class="form-control">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarArchivos">Guardar</button>
            </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Modal para modificar archivos -->
    <?php if ($rolUsuario != 'usuario'): ?>
    <div class="modal fade" id="modalModificarArchivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modificar Archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmArchivosModificar" enctype="multipart/form-data" method="post">
                    <input type="hidden" id="idArchivoModificar" name="idArchivoModificar">
                    <label>Selecciona Archivo</label>
                    <input type="file" name="archivosModificar" id="archivosModificar" class="form-control">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnModificarArchivos" onclick="modificarArchivosGestor()">Guardar</button>
            </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Modal para Visualizar archivos-->
    <div class="modal fade" id="visualizarArchivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Archivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="archivoObtenido"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<?php include "footer.php"; ?>
<script src="../js/gestor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tablaGestorArchivos').load("gestor/tablaGestor.php");
        $('#categoriasLoad').load("categorias/selectCategorias.php");
        $('#btnGuardarArchivos').click(function(){
            agregarArchivosGestor();
        });
    });
</script>
<?php
    }else{
        header("location:../index.php");
    }
?>
