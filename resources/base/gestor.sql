-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-08-2024 a las 04:38:52
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestor`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertar_usuario` (IN `p_nombre` VARCHAR(255), IN `p_fechaNacimiento` DATE, IN `p_email` VARCHAR(255), IN `p_usuario` VARCHAR(255), IN `p_password` VARCHAR(255), IN `p_rol` VARCHAR(50))   BEGIN
    DECLARE idusu INT;

    -- Verificar si el usuario ya existe
    SELECT id_usuario INTO idusu FROM gestor.usuarios 
    WHERE nombre = p_nombre 
    AND fechaNacimiento = p_fechaNacimiento 
    AND email = p_email 
    AND usuario = p_usuario 
    AND password = p_password 
    AND rol = p_rol;

    -- Si el usuario existe, actualizar el estado
    IF idusu IS NOT NULL THEN
        UPDATE gestor.usuarios 
        SET estado = 'Activo' 
        WHERE id_usuario = idusu;
    ELSE
        -- Si no existe, insertar el nuevo usuario
        INSERT INTO gestor.usuarios (
            nombre, fechaNacimiento, email, usuario, password, rol, fecha_insert
        ) VALUES (
            p_nombre, p_fechaNacimiento, p_email, p_usuario, p_password, p_rol, NOW()
        );
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_archivos` (IN `IdUsuario` INT)   BEGIN
	SELECT archivos.id_archivo AS idArchivo,
    usuario.nombre AS nombreUsuario,
    categorias.nombre AS categoria,
    archivos.nombre AS nombreArchivo,
    archivos.tipo AS tipoArchivo,
    archivos.ruta AS rutaArchivo,
    archivos.fecha AS fecha
    FROM archivos AS archivos
    INNER JOIN usuarios AS usuario
    ON archivos.id_usuario = usuario.id_usuario
    INNER JOIN categorias AS categorias
    ON archivos.id_categoria = categorias.id_categoria
    WHERE usuario.id_usuario = IdUsuario AND archivos.estado = 'Activo';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_usuarios` ()   BEGIN
	SELECT id_usuario, nombre, fechaNacimiento, email, usuario, rol  FROM usuarios WHERE estado = 'Activo';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_auditoria` (IN `idUsuario` INT, IN `accion` VARCHAR(100), IN `idArchivo` INT, IN `detalle` TEXT, IN `nombrearch` TEXT, IN `nomarch` TEXT)   BEGIN
	INSERT INTO gestor.auditoria(
		id_usuario,
        accion,
        id_archivo,
        fecha,
        detalle,
        nombre_archivo_anterior,
        nombre_archivo
    )
    VALUES
    (idUsuario, accion, idArchivo, NOW(), detalle, nombrearch, nomarch);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id_archivo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `ruta` text NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(45) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id_archivo`, `id_usuario`, `id_categoria`, `nombre`, `tipo`, `ruta`, `fecha`, `estado`) VALUES
(1, 1, 2, 'Guía instalación Odoo 17  - Gratuito.pdf', 'pdf', '../../Controllers/gestor/archivos/Administrador/Guía instalación Odoo 17  - Gratuito.pdf', '2024-06-04 19:34:19', 'Activo'),
(2, 1, 2, 'Vigilia de Pentecostés (cantos).pdf', 'pdf', '../../Controllers/gestor/archivos/Administrador/Vigilia de Pentecostés (cantos).pdf', '2024-06-04 19:34:48', 'Activo'),
(3, 1, 1, 'Herramientas usadas.docx', 'docx', '../../Controllers/gestor/archivos/Administrador/Herramientas usadas.docx', '2024-06-06 23:06:31', 'Activo'),
(4, 1, 3, 'Libro1.xlsx', 'xlsx', '../../Controllers/gestor/archivos/Administrador/Libro1.xlsx', '2024-06-06 23:07:00', 'Borrado'),
(5, 1, 1, 'ahorros.xlsx', 'xlsx', '../../Controllers/gestor/archivos/Administrador/ahorros.xlsx', '2024-06-06 23:07:37', 'Activo'),
(6, 1, 1, 'Plan de titulación - Freddy Bazante - versión 2.docx', 'docx', '../../Controllers/gestor/archivos/Administrador/Plan de titulación - Freddy Bazante - versión 2.docx', '2024-06-06 23:08:19', 'Activo'),
(7, 1, 1, 'Proyecto Integrador - Freddy Bazante - version4.docx', 'docx', '../../Controllers/gestor/archivos/Administrador/Proyecto Integrador - Freddy Bazante - version4.docx', '2024-06-06 23:08:51', 'Activo'),
(15, 1, 2, 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'pdf', '../../Controllers/gestor/archivos/Administrador/Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', '2024-08-24 10:42:18', 'Activo'),
(16, 52, 2, 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'pdf', '../../Controllers/gestor/archivos/Juanito/Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', '2024-08-24 11:04:29', 'Activo'),
(17, 52, 2, '09GIC Bohr.pdf', 'pdf', '../../Controllers/gestor/archivos/Juanito/09GIC Bohr.pdf', '2024-08-25 00:01:10', 'Activo'),
(18, 83, 2, '02GIC Newton.pdf', 'pdf', '../../Controllers/gestor/archivos/nelsonsito/02GIC Newton.pdf', '2024-08-25 01:28:08', 'Activo'),
(19, 1, 2, '41GIC Riemann.pdf', 'pdf', '../../Controllers/gestor/archivos/Administrador/41GIC Riemann.pdf', '2024-08-25 13:08:46', 'Activo'),
(20, 86, 2, 'El origen de los dioses - Christian Jacq.pdf', 'pdf', '../../Controllers/gestor/archivos/Lios/El origen de los dioses - Christian Jacq.pdf', '2024-08-25 14:39:23', 'Activo'),
(21, 86, 1, 'listas para viajar en el bus (1).docx', 'docx', '../../Controllers/gestor/archivos/Lios/listas para viajar en el bus (1).docx', '2024-08-25 14:40:55', 'Activo'),
(22, 86, 3, 'Ec_calculo.xlsx', 'xlsx', '../../Controllers/gestor/archivos/Lios/Ec_calculo.xlsx', '2024-08-25 16:07:36', 'Activo'),
(23, 86, 2, 'EDUCACIÓN AMBIENTAL.pdf', 'pdf', '../../Controllers/gestor/archivos/Lios/EDUCACIÓN AMBIENTAL.pdf', '2024-08-25 17:33:19', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `id_auditoria` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `id_archivo` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `detalle` text DEFAULT NULL,
  `nombre_archivo_anterior` varchar(255) DEFAULT NULL,
  `nombre_archivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`id_auditoria`, `id_usuario`, `accion`, `id_archivo`, `fecha`, `detalle`, `nombre_archivo_anterior`, `nombre_archivo`) VALUES
(1, 1, 'Visualizar', 3, '2024-08-26 21:35:05', 'Se Visualizar el archivo: Herramientas usadas.docx', 'Herramientas usadas.docx', 'Herramientas usadas.docx'),
(2, 1, 'Visualizar', 5, '2024-08-26 21:35:14', 'Se Visualizar el archivo: ahorros.xlsx', 'ahorros.xlsx', 'ahorros.xlsx'),
(3, 1, 'Visualizar', 7, '2024-08-26 21:35:17', 'Se Visualizar el archivo: Proyecto Integrador - Freddy Bazante - version4.docx', 'Proyecto Integrador - Freddy Bazante - version4.docx', 'Proyecto Integrador - Freddy Bazante - version4.docx'),
(4, 1, 'Visualizar', 1, '2024-08-26 21:35:23', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf', 'Guía instalación Odoo 17  - Gratuito.pdf', 'Guía instalación Odoo 17  - Gratuito.pdf'),
(5, 1, 'Visualizar', 15, '2024-08-26 21:35:26', 'Se Visualizar el archivo: Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf'),
(6, 1, 'Visualizar', 19, '2024-08-26 21:35:28', 'Se Visualizar el archivo: 41GIC Riemann.pdf', '41GIC Riemann.pdf', '41GIC Riemann.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fechaInsert` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `id_usuario`, `nombre`, `fechaInsert`) VALUES
(1, 1, 'docx', '2023-12-27 00:16:36'),
(2, 1, 'pdf', '2023-12-27 00:16:43'),
(3, 1, 'xlsx', '2023-12-27 00:16:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `papelera`
--

CREATE TABLE `papelera` (
  `id_papelera` int(11) NOT NULL,
  `id_archivo` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `ruta` varchar(255) DEFAULT NULL,
  `fecha_eliminacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `email` varchar(245) NOT NULL,
  `usuario` varchar(245) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('administrador','usuario') NOT NULL DEFAULT 'usuario',
  `fecha_insert` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(45) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `fechaNacimiento`, `email`, `usuario`, `password`, `rol`, `fecha_insert`, `estado`) VALUES
(1, 'Administrador', '2023-12-09', 'admin@admin.com', 'Administrador', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'administrador', '2023-12-26 09:21:06', 'Activo'),
(2, 'Freddy', '2024-01-27', 'freddybazante@gmail.com', 'FreddyBazante', '60bc5f12113173298ddf295e7f7ee1107e083ff2', 'usuario', '2024-01-04 00:24:29', 'No Activo'),
(52, 'Juan', '2005-01-01', 'juan@mail.com', 'Juanito', '60bc5f12113173298ddf295e7f7ee1107e083ff2', 'usuario', '2024-08-22 20:04:06', 'Activo'),
(83, 'Nelson', '2024-08-01', 'nelson@gmail.com', 'nelsonsito', '60bc5f12113173298ddf295e7f7ee1107e083ff2', 'usuario', '2024-08-25 01:23:26', 'Activo'),
(86, 'LiosJ', '2023-08-01', 'lios@mail.com', 'Lios', '72eb94bef4fa9bf3c6317b52607eba8d4fae2523', 'administrador', '2024-08-25 14:37:50', 'Activo');

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `tg_comprobar_contrasenia_despues_actualizar` BEFORE UPDATE ON `usuarios` FOR EACH ROW BEGIN
	IF (New.password is null OR New.password = '')THEN
		SET New.password = OLD.password;
	END IF ;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id_archivo`),
  ADD KEY `fkArchivosCategorias_idx` (`id_categoria`),
  ADD KEY `fkUsuariosArchivos_idx` (`id_usuario`);

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`id_auditoria`),
  ADD KEY `fkUsuariosAuditoria_idx` (`id_usuario`),
  ADD KEY `fkArchivosAuditoria_idx` (`id_archivo`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `fkCategoria_idx` (`id_usuario`);

--
-- Indices de la tabla `papelera`
--
ALTER TABLE `papelera`
  ADD PRIMARY KEY (`id_papelera`),
  ADD KEY `id_archivo` (`id_archivo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id_archivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id_auditoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `papelera`
--
ALTER TABLE `papelera`
  MODIFY `id_papelera` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD CONSTRAINT `fkArchivosCategorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkUsuariosArchivos` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `fkUsuariosAuditoria` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `papelera`
--
ALTER TABLE `papelera`
  ADD CONSTRAINT `papelera_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
