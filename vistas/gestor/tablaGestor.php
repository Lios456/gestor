<?php
session_start();
require_once "../../Modelos/Conexion.php";
require_once "../funciones.php"; // Asegúrate de que esta línea esté incluida para obtener el rol del usuario
require_once "../../config.php";

$c = new Conectar();
$conexion = $c->conexion();
$idUsuario = $_SESSION["idUsuario"];
$rolUsuario = obtenerRolUsuario();
$sql = "CALL sp_listar_archivos('$idUsuario')";
$result = mysqli_query($conexion, $sql);
?>

<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-hover table-primary table-striped" id="tablaGestorDatatable">
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Nombre</th>
                        <th>Extensión de archivo</th>
                        <th>Descargar</th>
                        <th>Visualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $extensionesValidas = array('docx', 'pdf', 'xlsx');

                    while ($mostrar = mysqli_fetch_array($result)) {
                        $rutaDescarga = "../Controllers/gestor/archivos/" . $_SESSION['nombre_usuario'] . "/" . $mostrar['nombreArchivo'];
                        $nombreArchivo = $mostrar['nombreArchivo'];
                        $idArchivo = $mostrar['idArchivo'];
                        ?>
                        <tr>
                            <td><?php echo $mostrar['categoria']; ?></td>
                            <td><?php echo $mostrar['nombreArchivo']; ?></td>
                            <td><?php echo $mostrar['tipoArchivo']; ?></td>
                            <td>
                                <a href="#" onclick="descargarArchivo('<?php echo $rutaDescarga; ?>', 
                                    '<?php echo $nombreArchivo; ?>', 
                                    <?php echo $idUsuario; ?>, <?php echo $idArchivo; ?>,
                                    '<?php echo $_SESSION['nombre_usuario'] ?>')"
                                    class="btn btn-success btn-sm">
                                    <span class="fas fa-download"></span>
                                </a>
                            </td>
                            <td>
                            <!--
                                Visualizar archivos
                                
                            -->

                            <?php
                                $visualizarButton = false;
                                for ($i = 0; $i < count($extensionesValidas); $i++) {
                                    if ($extensionesValidas[$i] == $mostrar['tipoArchivo']) {
                                        $visualizarButton = true;
                                        ?>
                                        <span class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#visualizarArchivo" onclick="visualizarYRegistrarAuditoria('<?php echo $idArchivo; ?>', 
                                            '<?php echo $nombreArchivo; ?>')">
                                            <span class="fas fa-eye"></span>
                                        </span>
                                        <?php
                                    }
                                }
                                if (!$visualizarButton) {
                                    echo '<span class="btn btn-primary btn-sm disabled"><span class="fas fa-eye"></span></span>';
                                }
                                ?>
                                
                            </td>
                            <td>
                                    <span class="btn btn-danger btn-sm" onclick="eliminarArchivo(<?php echo $idArchivo; ?>)">
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
<script>
    function obtenerNombreArchivoAnterior(idArchivo) {
        var nombreArchivoAnterior;
        $.ajax({
            type: "POST",
            url: "../Controllers/auditoria/obtenerNombreArchivo.php",
            data: { idArchivo: idArchivo },
            async: false,
            success: function (response) {
                nombreArchivoAnterior = response;
            },
            error: function (error) {
                console.error("Error al obtener el nombre del archivo anterior", error);
            }
        });
        return nombreArchivoAnterior;
    }

    function visualizarYRegistrarAuditoria(idArchivo, nombreArchivo) {
        obtenerArchivoPorId(idArchivo);
        var nombreArchivoAnterior = obtenerNombreArchivoAnterior(idArchivo);
        registrarAuditoria('Visualizar', nombreArchivo, nombreArchivoAnterior, '<?php echo $idUsuario; ?>', idArchivo);
    }

    function descargarArchivo(ruta, nombreArchivo, idUsuario, idArchivo, nombreUsuario) {
    var nombreArchivoAnterior = obtenerNombreArchivoAnterior(idArchivo);
    console.log("Este es el nombre del archivo anterior = ", nombreArchivoAnterior);
    registrarAuditoria('Descargar', nombreArchivo, nombreArchivoAnterior, idUsuario, idArchivo);

    // Redirige a la URL de descarga
    window.location.href = "../Controllers/gestor/descargarArchivo.php?nombreArchivo="
    + encodeURIComponent(nombreArchivo) + 
    "&nombreUsuario=" + 
    encodeURIComponent(nombreUsuario);
}


    function registrarAuditoria(accion, nombreArchivo, nombreArchivoAnterior, idUsuario, idArchivo) {
        var url = '../Controllers/auditoria/registrarAuditoria.php';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                accion: accion,
                nombreArchivo: nombreArchivo,
                nombreArchivoAnterior: nombreArchivoAnterior,
                idUsuario: idUsuario,
                idArchivo: idArchivo
            },
            success: function (data) {
                console.log("Auditoría registrada con éxito");
            },
            error: function (error) {
                console.error("Error al registrar auditoría", error);
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tablaGestorDatatable').DataTable();
    });
</script>