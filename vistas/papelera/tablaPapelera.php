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
                        <th>Nombre</th>
                        <th>Extensión de archivo</th>
                        <th>Restaurar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT
                                papelera.id_papelera,
                                papelera.id_archivo AS idArchivo,
                                usuario.nombre AS nombreUsuario,
                                papelera.nombre AS nombreArchivo,
                                papelera.tipo AS tipoArchivo,
                                papelera.ruta AS rutaArchivo,
                                papelera.fecha_eliminacion AS fecha_eliminacion
                            FROM
                                papelera
                                    INNER JOIN
                                usuarios AS usuario ON papelera.id_usuario = usuario.id_usuario
                            WHERE
                                usuario.id_usuario = '$idUsuario';";

                    $result = $conexion->query($sql);
                    /*
                        Arreglo de extensiones validas
                    */
                    $extensionesValidas = array('docx', 'pdf', 'xlsx');

                    if ($result->num_rows > 0) {
                        while ($mostrar = mysqli_fetch_array($result)) {
                            $nombreArchivo = $mostrar['nombreArchivo'];
                            $idArchivo = $mostrar['idArchivo'];
                        }
                        ?>
                        <tr>
                            <td><?php echo $nombreArchivo; ?></td>
                            <td><?php echo $idArchivo; ?></td>
                            <td>
                                <span class="btn btn-success btn-sm"
                                    onclick="restaurarArchivoPapelera(<?php echo $idArchivo; ?>)">
                                    <span class="fas fa-undo"></span>
                                </span>
                            </td>
                            <td>
                                <span class="btn btn-danger btn-sm"
                                    onclick="eliminarArchivoPapelera(<?php echo $idArchivo; ?>)">
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
    $(document).ready(function () {
        $('#tablaPapeleraDatatable').DataTable();
    });
</script>