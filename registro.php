<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registro</title>
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap5/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="librerias/jquery-ui-1.13.2/jquery-ui.theme.css">
        <link rel="stylesheet" type="text/css" href="librerias/jquery-ui-1.13.2/jquery-ui.css">
    </head>
    <body>
        <div class="container">
            <h1 style="text-align: center">Registro de usuario</h1>
            <hr>
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <form id="frmRegistro" method="post" onsubmit="return agregarUsuarioNuevo()" autocomplete="off">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"  placeholder="nombre" required="">
                        <label>Fecha de nacimiento</label>
                        <input type="text" name="fechaNacimiento" id="fechaNacimiento" class="form-control"  placeholder="nacimiento" required="" readonly="">
                        <label>Correo</label>
                        <input type="email" name="correo" id="correo" class="form-control"  placeholder="correo" required="">
                        <label>Nombre de usuario</label>
                        <input type="text" name="usuario" id="usuario" class="form-control"  placeholder="username" required="">
                        <label>Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control"  placeholder="password" required="">
                        <br>
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <button class="btn btn-primary">Registrar</button>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="index.php" class="btn btn-success">Iniciar sesión</a>
                            </div>
                        </div>
                        
                        
                    </form>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
        <script src="librerias/jquery-3.7.1.min.js"></script>
        <script src="librerias/jquery-ui-1.13.2/jquery-ui.js"></script>
        <script src="librerias/sweetalert.min.js"></script>
        <script type="text/javascript">

            $(function(){
                var fechaA = new Date();
                var yyyy = fechaA.getFullYear();
                $("#fechaNacimiento").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1900:' + yyyy,
                    dateFormat: "dd-mm-yy"
                });
            });

            function agregarUsuarioNuevo(){
                var nombre = $('#nombre').val().trim();
                var fechaNacimiento = $('#fechaNacimiento').datepicker('getDate');
                fechaNacimiento = fechaNacimiento.toISOString().split('T')[0];
                var correo = $('#correo').val().trim();
                var usuario = $('#usuario').val().trim();
                var password = $('#password').val().trim();

                // Validar que ningún campo esté en blanco
                if (nombre === "" || fechaNacimiento === "" || correo === "" || usuario === "" || password === "") {
                    swal("Todos los campos son obligatorios");
                    return false;
                }

                // Validar el formato del correo electrónico
                if (!isValidEmail(correo)) {
                    swal("Correo electrónico inválido");
                    return false;
                }

                // Validar la fortaleza de la contraseña
                if (!validarContrasena(password)) {
                    swal("Contraseña inválida", "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un carácter especial.", "warning");
                    return false;
                }

                // Validar que nombre y usuario contengan solo letras
                if (!contieneSoloLetras(nombre) || !contieneSoloLetras(usuario)) {
                    swal("Nombre y usuario deben contener solo letras");
                    return false;
                }

                // Realizar la solicitud AJAX solo si todas las validaciones han pasado
                $.ajax({
                    method: "POST",
                    data: $('#frmRegistro').serialize(),
                    url: "procesos/usuario/registro/agregarUsuario.php",
                    success:function(respuesta){
                        respuesta = respuesta.trim();

                        if(respuesta == 1){
                            $('#frmRegistro')[0].reset();
                            swal(":D","Agregado con éxito!","success");
                        } else if(respuesta == 2){
                            swal("Este usuario ya existe, por favor escribe otro!!!")
                        }else if(respuesta == 3){
                            swal("Este correo ya está en uso, por favor utiliza otro.");
                        } else {
                            swal(":(","Falló al agregar!","Error");
                        }
                    } 
                });
                return false;
            }

            // Función para validar el formato del correo electrónico
            function isValidEmail(email) {
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Función para validar la fortaleza de la contraseña
            function validarContrasena(password) {
                // Requiere al menos 8 caracteres, una mayúscula, una minúscula y un carácter especial
                var contrasenaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                return contrasenaRegex.test(password);
            }

            // Función para validar que la cadena contiene solo letras
            function contieneSoloLetras(cadena) {
                var letrasRegex = /^[A-Za-z\s]+$/;
                return letrasRegex.test(cadena);
            }
        </script>
    </body>
</html>
