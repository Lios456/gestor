<?php
session_start();
require_once "../../clases/Conexion.php";
$idUsuario = $_SESSION['idUsuario'];
$conexion = new Conectar();
$conexion = $conexion->conexion();
?>

<div class="table-responsive">
    <table class="table table-hover table-success table-striped" id="tablaUsuariosDatatable">
        <thead>
            <tr>
                <td style="text-align: center;">Nombre</td>
                <td style="text-align: center;">Fecha de Nacimiento</td>
                <td style="text-align: center;">Correo</td>
                <td style="text-align: center;">Usuario</td>
                <td style="text-align: center;">Rol</td>
                <td style="text-align: center;">Editar</td>
                <td style="text-align: center;">Eliminar</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT id_usuario, nombre, fechaNacimiento, email, usuario, rol  FROM usuarios";
                $result = mysqli_query($conexion, $sql);
                while($mostrar = mysqli_fetch_array($result)){
                    $idUsuario = $mostrar['id_usuario'];
            ?>
            <tr style="text-align: center;">
                <td><?php echo $mostrar['nombre'];?></td>
                <td><?php echo $mostrar['fechaNacimiento'];?></td>
                <td><?php echo $mostrar['email'];?></td>
                <td><?php echo $mostrar['usuario'];?></td>
                <td><?php echo $mostrar['rol'];?></td>
                <td>
                    <span class="btn btn-warning btn-sm" onclick="obtenerUsuario('<?php echo $idUsuario?>')" data-bs-toggle="modal" data-bs-target="#modalActualizarUsuario">
                        <span class="fas fa-edit"></span>
                    </span>
                </td>
                <td>
                    <span class="btn btn-danger btn-sm" onclick="eliminarUsuario('<?php echo $idUsuario?>')">
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#tablaUsuariosDatatable').DataTable();
    });
</script>
