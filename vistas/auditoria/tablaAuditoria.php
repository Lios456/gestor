<?php
    session_start();
    require_once "../../Modelos/Conexion.php";
    $idUsuario = $_SESSION['idUsuario'];
    $conexion = new Conectar();
    $conexion = $conexion->conexion();
?>

    <div class="table-responsive">
        <table class="table table-hover table-warning table-striped" id="tablaAuditoriaDatatable">
            <thead>
                <tr>
                    <td style="text-align: center;">ID Auditoría</td>
                    <td style="text-align: center;">Usuario</td>
                    <td style="text-align: center;">Acción</td>
                    <td style="text-align: center;">Archivo</td>
                    <td style="text-align: center;">Fecha</td>
                    <!--<td style="text-align: center;">Eliminar</td>-->
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT a.id_auditoria, u.nombre AS nombre_usuario, a.accion, a.nombre_archivo_anterior, a.fecha 
                    FROM auditoria a 
                    LEFT JOIN usuarios u ON a.id_usuario = u.id_usuario";
            
                    $result = mysqli_query($conexion, $sql);
                    while($mostrar = mysqli_fetch_array($result)){
                        $idAuditoria = $mostrar['id_auditoria'];
                ?>
                <tr style="text-align: center;">
                    <td><?php echo $mostrar['id_auditoria'];?></td>
                    <td><?php echo $mostrar['nombre_usuario']; ?></td>
                    <td><?php echo $mostrar['accion']; ?></td>
                    <td><?php echo $mostrar['nombre_archivo_anterior']; ?></td>
                    <td><?php echo $mostrar['fecha']; ?></td>
                    <!--<td>
                        <span class="btn btn-danger btn-sm" onclick="eliminarAuditoria('<?php echo $idAuditoria?>')">
                            <span class="fas fa-trash-alt"></span>
                        </span>
                    </td>-->
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablaAuditoriaDatatable').DataTable();
        });
    </script>