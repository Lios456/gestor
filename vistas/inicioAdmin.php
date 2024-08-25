<?php 
include "C://xampp//htdocs//gestor//config.php";
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
        <div class="list-group">
        <?php
            $archivos = scandir($GLOBALS['ruta_raiz']);
            foreach($archivos as $archivo){
                if($archivo != '.' && $archivo != '..'){
                    echo "<a href='#' class='list-group-item list-group-item-action' onclick='cambiarDirectorio(\"$archivo\")'>".$archivo."</a>";
                }
            }
        ?>
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
            if (isset($_POST['directorio'])) {
                // Verifica si la selección es un directorio válido
                $nuevoDirectorio = $GLOBALS['ruta_raiz'] . '/' . $_POST['directorio'];
                if (is_dir($nuevoDirectorio)) {
                    $GLOBALS['ruta_archivos'] = $nuevoDirectorio;
                }
            }

            // Continúa listando archivos en la nueva ruta
            $archivos = scandir($GLOBALS['ruta_archivos']);
            foreach($archivos as $archivo){
                if($archivo != '.' && $archivo != '..'){
                    echo "<a href='#' class='list-group-item list-group-item-action' onclick='cambiarDirectorio(\"$archivo\")'>".$archivo."</a>";
                }
            }
?>


<?php
        include "footer.php";
    } else {
        redirigirInicio();
    }
} else {
    redirigirIndex();
}
?>
