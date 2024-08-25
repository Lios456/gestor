<?php 
include "../config.php";
session_start();
include "funciones.php"; // Incluye las funciones necesarias

if (verificarSesion()) { // Función que verifica la sesión
    $rolUsuario = obtenerRolUsuario();

    if ($rolUsuario == 'administrador') {
        include "header.php";
        // Contenido específico para administradores
?>
    
    <div class="container">
    <div class="row">
        <div class="col-sm-12">
            <hr>
            <hr>
            <h1 style="text-align: center;">Bienvenido al sistema de gestión de archivos del GAD Las Pampas</h1> 
        </div>

    </div>
</div>

<script>
function cambiarDirectorio(archivo) {
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '';

    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'directorio';
    input.value = archivo;

    form.appendChild(input);
    document.body.appendChild(form);

    form.submit();
}
</script>

<?php
        include "footer.php";
    } else {
        redirigirInicio();
    }
} else {
    redirigirIndex();
}
?>
