function agregarUsuario() {
    var nombre = $('#agregarNombreUsuario').val().trim();
    var fechaNacimiento = $('#agregarFechaNacimiento').datepicker('getDate');
    fechaNacimiento = fechaNacimiento.toISOString().split('T')[0];
    var correo = $('#agregarCorreoUsuario').val().trim();
    var usuario = $('#agregarUsuarioUsuario').val().trim();
    var password = $('#agregarPasswordUsuario').val().trim();
    var rol = $('#agregarRolUsuario').val();

    // Validar que ningún campo esté en blanco
    if (nombre === "" || fechaNacimiento === "" || correo === "" || usuario === "" || password === "") {
        swal("Todos los campos son obligatorios");
        return false;
    }

    // Validar que la fecha de nacimiento no sea futura
    if (new Date(fechaNacimiento) > new Date()) {
        swal("Fecha inválida", "La fecha de nacimiento no puede ser futura.", "warning");
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

    // Validar que el nombre solo contenga letras y espacios
    if (!validarLetrasYEspacios(nombre)) {
        swal("Nombre inválido", "El nombre debe contener solo letras y espacios.", "warning");
        return false;
    }

    // Validar que el usuario solo contenga letras y espacios
    if (!validarLetrasYEspacios(usuario)) {
        swal("Nombre de usuario inválido", "El nombre de usuario debe contener solo letras y espacios.", "warning");
        return false;
    }

    // Validar que el usuario no exista
    if (existeUsuario(usuario)) {
        swal("Usuario existente", "El nombre de usuario ya está en uso, por favor elige otro.", "warning");
        return false;
    }

    // Validar que el correo no exista
    if (existeCorreo(correo)) {
        swal("Correo existente", "El correo ya está en uso, por favor elige otro.", "warning");
        return false;
    }

    // Si todo está bien, enviar la solicitud AJAX
    $.ajax({
        type: "POST",
        data: {
            agregarNombreUsuario: nombre,
            agregarFechaNacimiento: fechaNacimiento,
            agregarCorreoUsuario: correo,
            agregarUsuarioUsuario: usuario,
            agregarPasswordUsuario: password,
            agregarRolUsuario: rol
        },
        url: "../Controllers/usuario/agregarUsuario.php",
        success: function(respuesta) {
            respuesta = respuesta.trim();
            console.log("La respuesta es: ", respuesta);
            if (respuesta == 1 ) {
                $('#tablaUsuarios').load("../vistas/usuarios/tablaGestorUsuarios.php");
                $('#agregarNombreUsuario').val("");
                $('#agregarFechaNacimiento').val("");
                $('#agregarCorreoUsuario').val("");
                $('#agregarUsuarioUsuario').val("");
                $('#agregarPasswordUsuario').val("");
                $('#agregarRolUsuario').val("usuario");
                $('#modalAgregarUsuario').modal('hide');
                swal(":D", "Usuario agregado con éxito!", "success");
            } else {
                console.log(respuesta);
                swal(":(", "Falló al agregar usuario!", "error");
            }
        }
    });
}

// Función para verificar si el usuario ya existe
function existeUsuario(usuario) {
    var existe = false;
    $.ajax({
        async: false, // Hacer la solicitud de forma síncrona
        type: "POST",
        data: { agregarUsuarioUsuario: usuario },
        url: "../Controllers/usuario/verificarUsuario.php",
        success: function(respuesta) {
            existe = respuesta.trim() === '1';
        }
    });
    return existe;
}

// Función para verificar si el correo ya existe
function existeCorreo(correo) {
    var existe = false;
    $.ajax({
        async: false, // Hacer la solicitud de forma síncrona
        type: "POST",
        data: { agregarCorreoUsuario: correo },
        url: "../Controllers/usuario/verificarCorreo.php",
        success: function(respuesta) {
            existe = respuesta.trim() === '1';
        }
    });
    return existe;
}

function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function validarContrasena(contrasena) {
    var patron = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/;
    return patron.test(contrasena);
}

function eliminarUsuario(idUsuario) {
    idUsuario = parseInt(idUsuario);

    if (idUsuario < 1 || isNaN(idUsuario)) {
        swal("No tienes un ID de usuario válido.");
        return false;
    } else {
        swal({
                title: "¿Estás seguro de eliminar este usuario?",
                text: "Una vez eliminado, no podrá recuperarse.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        data: {
                            idUsuario: idUsuario
                        },
                        url: "../Controllers/usuario/eliminarUsuario.php",
                        success: function(respuesta) {
                            respuesta = respuesta.trim();
                            if (respuesta == 1) {
                                $('#tablaUsuarios').load("usuarios/tablaGestorUsuarios.php");
                                swal("Usuario eliminado con éxito!", {
                                    icon: "success",
                                });
                            } else {
                                swal(":(", "Falló al eliminar usuario!", "error");
                            }
                        }
                    });
                }
            });
    }
}

function obtenerUsuario(idUsuario) {
    console.log("Obteniendo usuario con ID:", idUsuario);
    $.ajax({
        type: "POST",
        data: { idUsuario: idUsuario },
        url: "../Controllers/usuario/obtenerUsuario.php",
        success: function(respuesta) {
            console.log(respuesta);

            try {
                respuesta = JSON.parse(respuesta);

                if (respuesta && Object.keys(respuesta).length > 0) {
                    $('#idUsuario').val(respuesta['id_usuario']);
                    $('#nombreUsuarioU').val(respuesta['nombre']);
                    $('#fechaNacimientoUsuarioU').val(respuesta['fechaNacimiento']);
                    $('#correoUsuarioU').val(respuesta['email']);
                    $('#nombreUsuario').val(respuesta['usuario']);
                    $('#passwordUsuarioU').val("");
                    $('#rolUsuarioU').val(respuesta['rol']);
                } else {
                    console.error("La respuesta del servidor no es un objeto válido o está vacía.");
                }
            } catch (error) {
                console.error("Error al parsear JSON:", error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        }
    });
}

function actualizaUsuario() {
    console.log("Función actualizaUsuario llamada");
    var idUsuario = $('#idUsuario').val();
    var nombre = $('#nombreUsuarioU').val().trim();
    var fechaNacimiento = $('#fechaNacimientoUsuarioU').datepicker('getDate');
    fechaNacimiento = fechaNacimiento.toISOString().split('T')[0];
    console.log("Fecha de Nacimiento:", fechaNacimiento);
    var correo = $('#correoUsuarioU').val().trim();
    var usuario = $('#nombreUsuario').val().trim();
    console.log("Nombre de Usuario:", usuario);
    var password = $('#passwordUsuarioU').val().trim();
    console.log("Contraseña:", password);
    var rol = $('#rolUsuarioU').val();
    console.log("Datos a enviar:", idUsuario, nombre, fechaNacimiento, correo, usuario, password, rol);

    if (nombre === "" || fechaNacimiento === "" || correo === "" || usuario === "" || rol === "") {
        swal("Todos los campos son obligatorios");
        return false;
    }

    if (!isValidEmail(correo)) {
        swal("Correo electrónico inválido");
        return false;
    }

    if (password !== "" && !validarContrasena(password)) {
        swal("Contraseña inválida", "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un carácter especial.", "warning");
        return false;
    }

    if (!validarLetrasYEspacios(nombre)) {
        swal("Nombre inválido", "El nombre debe contener solo letras y espacios.", "warning");
        return false;
    }

    if (!validarLetrasYEspacios(usuario)) {
        swal("Nombre de usuario inválido", "El nombre de usuario debe contener solo letras y espacios.", "warning");
        return false;
    }

    $.ajax({
        type: "POST",
        data: $("#frmActualizaUsuario").serialize(),
        url: "../Controllers/usuario/actualizaUsuario.php",
        success: function(respuesta) {
            console.log("Respuesta del servidor:", respuesta);

            if (respuesta.startsWith("Error:")) {
                swal(":(", respuesta, "error");
            } else if (respuesta.trim() === '1') {
                $('#tablaUsuarios').load("../vistas/usuarios/tablaGestorUsuarios.php");
                $('#btnCerrarUpdateUsuario').click();
                swal(":D", "Usuario actualizado con éxito!", "success");
            } else {
                swal(":(", "Falló al actualizar usuario!", "error");
            }
        }
    });
}

function validarLetrasYEspacios(cadena) {
    var patron = /^[A-Za-z\s]+$/;
    return patron.test(cadena);
}
