-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-08-2024 a las 20:34:42
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

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
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id_archivo`, `id_usuario`, `id_categoria`, `nombre`, `tipo`, `ruta`, `fecha`) VALUES
(1, 1, 2, 'Guía instalación Odoo 17  - Gratuito.pdf', 'pdf', '../../archivos/Guía instalación Odoo 17  - Gratuito.pdf', '2024-06-04 19:34:19'),
(2, 1, 2, 'Vigilia de Pentecostés (cantos).pdf', 'pdf', '../../archivos/Vigilia de Pentecostés (cantos).pdf', '2024-06-04 19:34:48'),
(3, 1, 1, 'Herramientas usadas.docx', 'docx', '../../archivos/Herramientas usadas.docx', '2024-06-06 23:06:31'),
(4, 1, 3, 'Libro1.xlsx', 'xlsx', '../../archivos/Libro1.xlsx', '2024-06-06 23:07:00'),
(5, 1, 1, 'ahorros.xlsx', 'xlsx', '../../archivos/ahorros.xlsx', '2024-06-06 23:07:37'),
(6, 1, 1, 'Plan de titulación - Freddy Bazante - versión 2.docx', 'docx', '../../archivos/Plan de titulación - Freddy Bazante - versión 2.docx', '2024-06-06 23:08:19'),
(7, 1, 1, 'Proyecto Integrador - Freddy Bazante - version4.docx', 'docx', '../../archivos/Proyecto Integrador - Freddy Bazante - version4.docx', '2024-06-06 23:08:51'),
(15, 1, 2, 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'pdf', 'C:/xampp/htdocs/gestor/procesos/gestor/archivos/Administrador/Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', '2024-08-24 10:42:18'),
(16, 52, 2, 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'pdf', '../../procesos/gestor/archivos/Juanito/Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', '2024-08-24 11:04:29'),
(17, 52, 2, '09GIC Bohr.pdf', 'pdf', '../../Controllers/gestor/archivos/Juanito/09GIC Bohr.pdf', '2024-08-25 00:01:10'),
(18, 83, 2, '02GIC Newton.pdf', 'pdf', '../../Controllers/gestor/archivos/nelsonsito/02GIC Newton.pdf', '2024-08-25 01:28:08'),
(19, 1, 2, '41GIC Riemann.pdf', 'pdf', '../../Controllers/gestor/archivos/Administrador/41GIC Riemann.pdf', '2024-08-25 13:08:46');

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
(1, 1, 'Agregar', 1, '2024-06-04 19:33:24', 'Se agregó un nuevo archivo con nombre: Guía instalación Odoo 17  - Gratuito.pdf', 'Guía instalación Odoo 17  - Gratuito.pdf', 'Guía instalación Odoo 17  - Gratuito.pdf'),
(2, 1, 'Visualizar', NULL, '2024-06-04 19:33:31', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(3, 1, 'Visualizar', NULL, '2024-06-04 19:33:43', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(4, 1, 'Enviar a Papelera', 1, '2024-06-04 19:33:55', 'Se eliminó el archivo con ID 1 y nombre: Guía instalación Odoo 17  - Gratuito.pdf a la papelera', 'Guía instalación Odoo 17  - Gratuito.pdf', 'Guía instalación Odoo 17  - Gratuito.pdf'),
(5, 1, 'Visualizar', NULL, '2024-06-04 19:34:23', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(6, 1, 'Agregar', 2, '2024-06-04 19:34:48', 'Se agregó un nuevo archivo con nombre: Vigilia de Pentecostés (cantos).pdf', 'Vigilia de Pentecostés (cantos).pdf', 'Vigilia de Pentecostés (cantos).pdf'),
(7, 1, 'Visualizar', NULL, '2024-06-04 19:34:53', NULL, 'Vigilia de Pentecostés (cantos).pdf', 'Se Visualizar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(8, 1, 'Visualizar', NULL, '2024-06-06 20:58:15', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(9, 1, 'Visualizar', NULL, '2024-06-06 21:30:34', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(10, 1, 'Visualizar', NULL, '2024-06-06 21:31:57', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(11, 1, 'Visualizar', NULL, '2024-06-06 21:32:10', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(12, 1, 'Visualizar', NULL, '2024-06-06 21:32:32', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(13, 1, 'Visualizar', NULL, '2024-06-06 21:33:30', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(14, 1, 'Visualizar', NULL, '2024-06-06 21:34:43', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(15, 1, 'Visualizar', NULL, '2024-06-06 21:35:24', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(16, 1, 'Visualizar', NULL, '2024-06-06 21:37:38', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(17, 1, 'Visualizar', NULL, '2024-06-06 21:37:42', NULL, 'Vigilia de Pentecostés (cantos).pdf', 'Se Visualizar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(18, 1, 'Visualizar', NULL, '2024-06-06 21:38:16', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(19, 1, 'Visualizar', NULL, '2024-06-06 21:39:34', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(20, 1, 'Visualizar', NULL, '2024-06-06 21:41:35', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(21, 1, 'Visualizar', NULL, '2024-06-06 21:41:43', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(22, 1, 'Descargar', NULL, '2024-06-06 21:41:45', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Descargar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(23, 1, 'Visualizar', NULL, '2024-06-06 21:42:22', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(24, 1, 'Visualizar', NULL, '2024-06-06 21:42:29', NULL, 'Vigilia de Pentecostés (cantos).pdf', 'Se Visualizar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(25, 1, 'Descargar', NULL, '2024-06-06 21:45:58', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Descargar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(26, 1, 'Visualizar', NULL, '2024-06-06 21:46:24', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(27, 1, 'Visualizar', NULL, '2024-06-06 22:39:07', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(28, 1, 'Visualizar', NULL, '2024-06-06 22:39:33', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(29, 1, 'Visualizar', NULL, '2024-06-06 22:39:52', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(30, 1, 'Visualizar', NULL, '2024-06-06 22:41:26', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(31, 1, 'Visualizar', NULL, '2024-06-06 22:42:49', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(32, 1, 'Visualizar', NULL, '2024-06-06 22:43:25', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(33, 1, 'Visualizar', NULL, '2024-06-06 22:46:15', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(34, 1, 'Visualizar', NULL, '2024-06-06 22:46:33', NULL, 'Vigilia de Pentecostés (cantos).pdf', 'Se Visualizar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(35, 1, 'Visualizar', NULL, '2024-06-06 22:48:32', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(36, 1, 'Visualizar', NULL, '2024-06-06 23:05:58', NULL, 'Guía instalación Odoo 17  - Gratuito.pdf', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(37, 1, 'Agregar', 3, '2024-06-06 23:06:31', 'Se agregó un nuevo archivo con nombre: Herramientas usadas.docx', 'Herramientas usadas.docx', 'Herramientas usadas.docx'),
(38, 1, 'Visualizar', NULL, '2024-06-06 23:06:35', NULL, 'Herramientas usadas.docx', 'Se Visualizar el archivo: Herramientas usadas.docx'),
(39, 1, 'Agregar', 4, '2024-06-06 23:07:00', 'Se agregó un nuevo archivo con nombre: Libro1.xlsx', 'Libro1.xlsx', 'Libro1.xlsx'),
(40, 1, 'Visualizar', NULL, '2024-06-06 23:07:04', NULL, 'Libro1.xlsx', 'Se Visualizar el archivo: Libro1.xlsx'),
(41, 1, 'Agregar', 5, '2024-06-06 23:07:37', 'Se agregó un nuevo archivo con nombre: ahorros.xlsx', 'ahorros.xlsx', 'ahorros.xlsx'),
(42, 1, 'Visualizar', NULL, '2024-06-06 23:07:43', NULL, 'ahorros.xlsx', 'Se Visualizar el archivo: ahorros.xlsx'),
(43, 1, 'Agregar', 6, '2024-06-06 23:08:19', 'Se agregó un nuevo archivo con nombre: Plan de titulación - Freddy Bazante - versión 2.docx', 'Plan de titulación - Freddy Bazante - versión 2.docx', 'Plan de titulación - Freddy Bazante - versión 2.docx'),
(44, 1, 'Visualizar', NULL, '2024-06-06 23:08:25', NULL, 'Plan de titulación - Freddy Bazante - versión 2.docx', 'Se Visualizar el archivo: Plan de titulación - Freddy Bazante - versión 2.docx'),
(45, 1, 'Agregar', 7, '2024-06-06 23:08:51', 'Se agregó un nuevo archivo con nombre: Proyecto Integrador - Freddy Bazante - version4.docx', 'Proyecto Integrador - Freddy Bazante - version4.docx', 'Proyecto Integrador - Freddy Bazante - version4.docx'),
(46, 1, 'Visualizar', NULL, '2024-06-06 23:08:56', NULL, 'Proyecto Integrador - Freddy Bazante - version4.docx', 'Se Visualizar el archivo: Proyecto Integrador - Freddy Bazante - version4.docx'),
(47, 1, 'Visualizar', NULL, '2024-06-06 23:12:02', NULL, 'Herramientas usadas.docx', 'Se Visualizar el archivo: Herramientas usadas.docx'),
(48, 1, 'Visualizar', NULL, '2024-06-06 23:12:20', NULL, 'Herramientas usadas.docx', 'Se Visualizar el archivo: Herramientas usadas.docx'),
(49, 1, 'Visualizar', NULL, '2024-06-06 23:12:42', NULL, 'ahorros.xlsx', 'Se Visualizar el archivo: ahorros.xlsx'),
(50, 1, 'Visualizar', NULL, '2024-06-06 23:12:51', NULL, 'Proyecto Integrador - Freddy Bazante - version4.docx', 'Se Visualizar el archivo: Proyecto Integrador - Freddy Bazante - version4.docx'),
(51, 1, 'Visualizar', NULL, '2024-06-06 23:13:23', NULL, 'Vigilia de Pentecostés (cantos).pdf', 'Se Visualizar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(52, 1, 'Visualizar', NULL, '2024-06-06 23:35:56', NULL, 'Herramientas usadas.docx', 'Se Visualizar el archivo: Herramientas usadas.docx'),
(53, 1, 'Visualizar', NULL, '2024-06-06 23:36:12', NULL, 'Proyecto Integrador - Freddy Bazante - version4.docx', 'Se Visualizar el archivo: Proyecto Integrador - Freddy Bazante - version4.docx'),
(54, 1, 'Visualizar', NULL, '2024-06-07 01:42:11', NULL, 'Herramientas usadas.docx', 'Se Visualizar el archivo: Herramientas usadas.docx'),
(55, 2, 'Visualizar', NULL, '2024-06-10 21:51:58', NULL, 'Herramientas usadas.docx', 'Se Visualizar el archivo: Herramientas usadas.docx'),
(64, 1, 'Visualizar', NULL, '2024-08-22 19:40:02', NULL, '1', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(65, 1, 'Agregar', 8, '2024-08-24 09:26:32', 'Se agregó un nuevo archivo con nombre: admin,+Gestor_a+de+la+revista,+relais-v1-n4-p-125-134.pdf', 'admin,+Gestor_a+de+la+revista,+relais-v1-n4-p-125-134.pdf', 'admin,+Gestor_a+de+la+revista,+relais-v1-n4-p-125-134.pdf'),
(66, 1, 'Agregar', 9, '2024-08-24 09:32:42', 'Se agregó un nuevo archivo con nombre: admin,+Gestor_a+de+la+revista,+relais-v1-n4-p-125-134.pdf', 'admin,+Gestor_a+de+la+revista,+relais-v1-n4-p-125-134.pdf', 'admin,+Gestor_a+de+la+revista,+relais-v1-n4-p-125-134.pdf'),
(68, 1, 'Agregar', 10, '2024-08-24 09:34:23', 'Se agregó un nuevo archivo con nombre: admin,+Gestor_a+de+la+revista,+relais-v1-n4-p-125-134.pdf', 'admin,+Gestor_a+de+la+revista,+relais-v1-n4-p-125-134.pdf', 'admin,+Gestor_a+de+la+revista,+relais-v1-n4-p-125-134.pdf'),
(69, 1, 'Agregar', 11, '2024-08-24 10:21:45', 'Se agregó un nuevo archivo con nombre: Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf'),
(70, 1, 'Agregar', 12, '2024-08-24 10:23:25', 'Se agregó un nuevo archivo con nombre: Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf'),
(71, 1, 'Agregar', 13, '2024-08-24 10:25:46', 'Se agregó un nuevo archivo con nombre: Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf'),
(72, 1, 'Agregar', 14, '2024-08-24 10:29:14', 'Se agregó un nuevo archivo con nombre: Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf'),
(73, 1, 'Agregar', 15, '2024-08-24 10:42:18', 'Se agregó un nuevo archivo con nombre: Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf'),
(74, 52, 'Agregar', 16, '2024-08-24 11:04:29', 'Se agregó un nuevo archivo con nombre: Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf', 'Dialnet-UsabilidadEnAplicacionesMoviles-5123524.pdf'),
(79, 2, 'Visualizar', NULL, '2024-08-24 11:09:48', NULL, '1', 'Se Visualizar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(111, 2, 'Visualizar', NULL, '2024-08-24 19:03:35', NULL, '1', 'Se Visualizar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(112, 1, 'Visualizar', NULL, '2024-08-24 19:03:39', NULL, '1', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(124, 2, 'Visualizar', NULL, '2024-08-24 20:04:53', NULL, '1', 'Se Visualizar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(137, 2, 'Visualizar', NULL, '2024-08-24 20:21:14', NULL, '1', 'Se Visualizar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(162, 52, 'Agregar', 17, '2024-08-25 00:01:10', 'Se agregó un nuevo archivo con nombre: 09GIC Bohr.pdf', '09GIC Bohr.pdf', '09GIC Bohr.pdf'),
(163, 83, 'Agregar', 18, '2024-08-25 01:28:08', 'Se agregó un nuevo archivo con nombre: 02GIC Newton.pdf', '02GIC Newton.pdf', '02GIC Newton.pdf'),
(170, 2, 'Descargar', NULL, '2024-08-25 12:57:45', NULL, '1', 'Se Descargar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(173, 1, 'Descargar', NULL, '2024-08-25 12:58:43', NULL, '1', 'Se Descargar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(174, 2, 'Descargar', NULL, '2024-08-25 12:58:50', NULL, '1', 'Se Descargar el archivo: Vigilia de Pentecostés (cantos).pdf'),
(176, 1, 'Descargar', NULL, '2024-08-25 13:01:13', NULL, '1', 'Se Descargar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(177, 1, 'Visualizar', NULL, '2024-08-25 13:01:19', NULL, '1', 'Se Visualizar el archivo: Guía instalación Odoo 17  - Gratuito.pdf'),
(186, 1, 'Agregar', 19, '2024-08-25 13:08:46', 'Se agregó un nuevo archivo con nombre: 41GIC Riemann.pdf', '41GIC Riemann.pdf', '41GIC Riemann.pdf');

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
  `fecha_insert` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `fechaNacimiento`, `email`, `usuario`, `password`, `rol`, `fecha_insert`) VALUES
(1, 'Administrador', '2023-12-09', 'admin@admin.com', 'Administrador', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'administrador', '2023-12-26 09:21:06'),
(2, 'Freddy', '2024-01-27', 'freddybazante@gmail.com', 'FreddyBazante', '73fa6ac852284791bc8fde3b7fb33c36a21ff180', 'usuario', '2024-01-04 00:24:29'),
(42, 'Diana', '2024-06-07', 'n@p.com', 'Diana', '25b5d2709e20d26b989c89deb5ef80af3a716d20', 'usuario', '2024-06-07 01:00:08'),
(43, 'EL', '2024-06-08', 'n@p2.com', 'DianaY', 'c164f1e3751efc7256529f145469e2d8e9487d23', 'usuario', '2024-06-07 01:21:08'),
(44, 'MIA', '2024-06-07', 'n@r7tp.com', 'asadsads', '123456789', 'usuario', '2024-06-07 01:24:23'),
(45, 'dsfsd', '2024-06-08', 'n@8p2.com', 'DianaYT', '5f8422af8c8af9abe0a1d088283cead27a08755b', 'usuario', '2024-06-07 01:30:43'),
(46, 'Daniel', '2024-06-07', 'daniel@d.com', 'Daniel', '0d3d2621c3bfdb73b2b0b3b71886085302db1c8c', 'usuario', '2024-06-07 01:40:15'),
(52, 'Juan', '2024-08-07', 'juan@mail.com', 'Juanito', '60bc5f12113173298ddf295e7f7ee1107e083ff2', 'usuario', '2024-08-22 20:04:06'),
(83, 'Nelson', '2024-08-01', 'nelson@gmail.com', 'nelsonsito', '60bc5f12113173298ddf295e7f7ee1107e083ff2', 'usuario', '2024-08-25 01:23:26');

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `tg_comprobar_contrasenia_despues_actualizar` BEFORE UPDATE ON `usuarios` FOR EACH ROW BEGIN
	IF (New.password = null OR New.password = '')THEN
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
  MODIFY `id_archivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id_auditoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

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
