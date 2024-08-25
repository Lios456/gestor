<?php 
session_start();
include "funciones.php"; // Incluye las funciones necesarias
include "C:/xampp/htdocs/gestor/config.php";

if (verificarSesion()) { // Función que verifica la sesión
    $rolUsuario = obtenerRolUsuario();

    if ($rolUsuario == 'usuario') {
        include "headerUsuario.php";
        // Contenido específico para usuarios normales
?>
    
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <hr>
                    <hr>
                    <h1 style="text-align: center;">Bienvenido al sistema de gestión de archivos del GAD Las Pampas</h1>
                    <p>
                    <?php
                            echo $_SESSION['ruta_archivos'];
                            echo "</br>";
                            $archivos = scandir($_SESSION['ruta_archivos']);
                            foreach($archivos as $archivo){
                                if($archivo != '.' && $archivo != '..'){
                                    echo $archivo . "\n";
                                }
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

<?php
        include "footer.php";
    } else {
        redirigirInicio();
    }
} else {
    redirigirIndex();
}
?>
