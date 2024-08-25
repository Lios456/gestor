<?php
    session_start();
    require_once "../../Modelos/Conexion.php";
    $idUsuario = $_SESSION['idUsuario'];
    $conexion = new Conectar();
    $conexion = $conexion->conexion();
?>

<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-hover table-primary table-striped" id="tablaPapeleraDatatable">
                <thead>
                    <tr>    
                        <th>Categoría</th>
                        <th>Nombre</th>
                        <th>Extensión de archivo</th>
                        <th>Restaurar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT papelera.id_papelera, papelera.id_archivo AS idArchivo, usuario.nombre AS nombreUsuario, 
                        categorias.nombre AS categoria, papelera.nombre AS nombreArchivo, papelera.tipo AS tipoArchivo, 
                        papelera.ruta AS rutaArchivo, papelera.fecha_eliminacion AS fecha_eliminacion 
                        FROM papelera
                        INNER JOIN usuarios AS usuario ON papelera.id_usuario = usuario.id_usuario 
                        INNER JOIN categorias AS categorias ON papelera.id_categoria = categorias.id_categoria";
                
                        $result = $conexion->query($sql);
                        /*
                            Arreglo de extensiones validas
                        */
                        $extensionesValidas = array('docx','pdf','xlsx');

                        if($result){
                            while ($mostrar = mysqli_fetch_array($result)) {
                                $nombreArchivo = $mostrar['nombreArchivo'];
                                $idArchivo = $mostrar['idArchivo'];
                        }
                    ?>
                    <tr>
                        <td><?php echo $mostrar['categoria'];?></td>
                        <td><?php echo $mostrar['nombreArchivo'];?></td>
                        <td><?php echo $mostrar['tipoArchivo'];?></td>
                        <td>
                            <span class="btn btn-success btn-sm" onclick="restaurarArchivoPapelera(<?php echo $idArchivo;?>)">
                                <span class="fas fa-undo"></span>
                            </span>
                        </td>
                        <td>
                            <span class="btn btn-danger btn-sm" onclick="eliminarArchivoPapelera(<?php echo $idArchivo;?>)">
                                <span class="fas fa-trash-alt"></span>
                            </span>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tablaPapeleraDatatable').DataTable();
    });
</script>