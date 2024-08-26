<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="resources/css/login.css">
    <link rel="stylesheet" type="text/css" href="resources/librerias/sweetalert.min.js">
    <link rel="stylesheet" type="text/css" href="resources/librerias/bootstrap5/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 30px; /* Espacio para el ícono */
        }

        .password-container .fa-eye,
        .password-container .fa-eye-slash {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px; /* Tamaño del ícono ajustado */
        }

        input[type="text"],
        input[type="password"] {
            margin-bottom: 10px;
            padding: 10px;
            box-sizing: border-box; /* Asegura que el padding no afecte el width */
            width: calc(100% - 20px); /* Ajusta el tamaño del input */
        }
    </style>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <img src="resources/img/logo.jpg" id="icon" alt="User Icon" />
                <h1>Gestión de Archivos GAD las Pampas</h1>
            </div>

            <!-- Login Form -->
            <form method="post" id="frmLogin" onsubmit="return loguear()">
                <input type="text" id="login" class="fadeIn second" name="login" placeholder="username" required="">
                <div class="password-container fadeIn third">
                    <input type="password" id="password" name="password" placeholder="password" required="">
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>
                <input type="submit" class="fadeIn fourth" value="Iniciar Sesión">
            </form>

            <!-- Remind Password -->
            <div id="formFooter">
                <a class="forgot-password-link" href="solicitud_cambio.php" id="alertLink">¿Olvidaste tu contraseña?</a>
                <!--<button class="btn btn-success" onclick="redirectToRegistro()">Registrar</button>-->
            </div>
        </div>
    </div>
    <script src="resources/librerias/jquery-3.7.1.min.js"></script>
    <script src="resources/librerias/sweetalert.min.js"></script>


    <!-- Alerta de contraseña olvidada -->
    <script>
        document.getElementById("alertLink").addEventListener("click", function(event){
            event.preventDefault();
            
            swal({
            title: "¿Problemas con su contraseña?",
            text: "Contactese con el personal de soporte.",
            icon: "info",
            button: "Entendido"
            });
        });
    </script>

    <script type="text/javascript">
        document.getElementById("togglePassword").addEventListener("click", function () {
            var passwordField = document.getElementById("password");
            var icon = document.getElementById("togglePassword");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });

        function loguear() {
            $.ajax({
                method: "POST",
                data: $('#frmLogin').serialize(),
                url: "Controllers/usuario/login/login.php",
                success: function (respuesta) {
                    respuesta = respuesta.trim();

                    if (respuesta == "1") {
                        // Inicio de sesión exitoso
                        swal(":D", "Inicio de sesión exitoso", "success").then(function () {
                            // Redirigir según el rol del usuario
                            window.location = "Controllers/usuario/login/redireccion.php";
                        });
                    } else {
                        // Mostrar mensaje de error
                        swal(":(", respuesta, "error");
                    }
                }
            });
            return false;
        }

        function redirectToRegistro() {
            // Aquí estableces la URL a la que deseas redirigir al usuario
            window.location.href = "registro.php";
        }
    </script>
</body>
</html>


