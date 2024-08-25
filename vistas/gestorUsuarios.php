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
        <h1 class="display-4">Usuarios</h1>
        <div class="row">
            <div class="col-sm-4">
                <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">
                    <span class="fas fa-plus-circle"></span> Agregar nuevo Usuario
                </span>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <div id="tablaUsuarios"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmUsuarios">
                    <label>Nombre</label>
                    <input type="text" name="agregarNombreUsuario" id="agregarNombreUsuario" class="form-control"  placeholder="nombre" required="">
                    <label>Fecha de nacimiento</label>
                    <input type="text" name="agregarFechaNacimiento" id="agregarFechaNacimiento" class="form-control datepicker"  placeholder="nacimiento" required="" readonly="">
                    <label>Correo</label>
                    <input type="email" name="agregarCorreoUsuario" id="agregarCorreoUsuario" class="form-control"  placeholder="correo" required="">
                    <label>Nombre de usuario</label>
                    <input type="text" name="agregarUsuarioUsuario" id="agregarUsuarioUsuario" class="form-control"  placeholder="username" required="">
                    <label>Contraseña</label>
                    <div class="password-container">
                        <input type="password" name="agregarPasswordUsuario" id="agregarPasswordUsuario" class="form-control" placeholder="password" required="">
                        <i class="fas fa-eye" id="toggleAgregarPassword"></i>
                    </div>
                    <label>Rol</label>
                    <select id="agregarRolUsuario" name="agregarRolUsuario" class="form-control">
                        <option value="usuario" selected>usuario</option>
                        <option value="administrador">administrador</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarUsuario">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalActualizarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmActualizaUsuario">
                    <input type="text" id="idUsuario" name="idUsuario" hidden="">
                    <label>Nombre</label>
                    <input type="text" id="nombreUsuarioU" name="nombreUsuarioU" class="form-control">
                    <label>Fecha de Nacimiento</label>
                    <input type="text" id="fechaNacimientoUsuarioU" name="fechaNacimientoUsuarioU" class="form-control datepicker" required="" readonly="">
                    <label>Correo del Usuario</label>
                    <input type="email" id="correoUsuarioU" name="correoUsuarioU" class="form-control">
                    <label>Nombre de Usuario</label>
                    <input type="text" id="nombreUsuario" name="nombreUsuario" class="form-control">
                    <label>Contraseña</label>
                    <div class="password-container">
                        <input type="password" id="passwordUsuarioU" name="passwordUsuarioU" class="form-control">
                        <i class="fas fa-eye" id="toggleActualizarPassword"></i>
                    </div>
                    <label>Rol</label>
                    <select id="rolUsuarioU" name="rolUsuarioU" class="form-control">
                        <option value="usuario" selected>usuario</option>
                        <option value="administrador">administrador</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCerrarUpdateUsuario">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btnActualizaUsuario">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>

<script>
    if (typeof jQuery == 'undefined') {
        console.log('jQuery no está definido. ¡Hay un problema!');
    } else {
        console.log('jQuery cargado correctamente.');
    }
</script>

<script>
    if (typeof jQuery.ui !== 'undefined') {
        console.log('jQuery UI cargado correctamente.');
    } else {
        console.log('Error: jQuery UI no está definido.');
    }
</script>

<script type="text/javascript">
    $(function(){
        var fechaA = new Date();
        var yyyy = fechaA.getFullYear();
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1900:' + yyyy,
            maxDate: new Date(),
            dateFormat: "dd-mm-yy"
        });
    });
</script>

<!--Dependencia de usuarios, todas las funciones js de usuarios-->
<script src="../js/usuarios.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tablaUsuarios').load("usuarios/tablaGestorUsuarios.php");
        $('#btnGuardarUsuario').click(function(){
            agregarUsuario();
        });
        $('#btnActualizaUsuario').click(function(){
            actualizaUsuario();
        });
        
        $('#toggleAgregarPassword').click(function() {
            togglePasswordVisibility('agregarPasswordUsuario', 'toggleAgregarPassword');
        });
        
        $('#toggleActualizarPassword').click(function() {
            togglePasswordVisibility('passwordUsuarioU', 'toggleActualizarPassword');
        });
    });

    function togglePasswordVisibility(inputId, toggleId) {
        var passwordField = document.getElementById(inputId);
        var toggleIcon = document.getElementById(toggleId);
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>

<style>
    .password-container {
        position: relative;
        width: 100%;
    }

    .password-container input {
        width: calc(100% - 30px); /* Espacio para el ícono */
        padding-right: 30px;
    }

    .password-container .fa-eye,
    .password-container .fa-eye-slash {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>

<?php 
} else {
    header("location:../index.php");
}
?>
