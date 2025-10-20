-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-09-2025 a las 13:28:09
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
-- Base de datos: `workflot_ug`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_L_MENU_03` (IN `p_usu_id` INT, IN `p_menu_ident` VARCHAR(100))   BEGIN
    /*
      Retorna 1 si el usuario tiene acceso al menú,
      de lo contrario retorna 0.
    */

    SELECT 
        CASE 
            WHEN COUNT(*) > 0 THEN 1 
            ELSE 0 
        END AS acceso
    FROM usuario u
    INNER JOIN rol r ON u.id_rol = r.id_rol
    INNER JOIN menu_roles mr ON r.id_rol = mr.id_rol
    INNER JOIN menu m ON mr.id_menu = m.id_menu
    WHERE u.id_usuario = p_usu_id
      AND m.menu_ident = p_menu_ident
      AND u.estado = 1
      AND m.estado = 1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `icono` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `badge` varchar(100) NOT NULL,
  `menu_ident` varchar(150) NOT NULL,
  `estado` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `nombre`, `icono`, `link`, `badge`, `menu_ident`, `estado`) VALUES
(1, 'Mis Tareas', 'M19 3H5c-1.1 0-2 .9-2 2v14l4-4h12c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z', '', '0', 'tareas', 1),
(2, 'Subir Asignaciones', 'M5 20h14v-2H5v2zM5 4v12h14V4H5zm12 10H7V6h10v8z', '../MntAsignaciones/', '0', 'asignaciones', 1),
(3, 'Chat', 'M20 2H4c-1.1 0-2 .9-2 2v16l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z', '', '0', 'chat', 1),
(4, 'Copilot IA', 'M12 4a8 8 0 00-8 8c0 3.31 2.69 6 6 6h2v2h2v-2h2a8 8 0 00-8-14zm-1 9H9V9h2v4zm4 0h-2V9h2v4z', '', '0', 'ia', 1),
(5, 'Soporte', 'M4 4h16v12H5.17L4 17.17V4zm2 4v2h12V8H6zm0 4v2h8v-2H6z', '', '0', 'soporte', 1),
(6, 'Dashboard ', 'M3 13h8V3H3v10zm0 8h8v-6H3v6zM13 21h8V11h-8v10zM13 3v6h8V3h-8z', '../home/', '0', 'dashboard', 1),
(7, 'Validación Académica', 'M9 16.2l-3.5-3.5L4 14.2 9 19l12-12-1.5-1.5z', '', '0', 'validacion_academica', 1),
(8, 'Seguimiento', 'M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z', '../MntSegimiento/', '0', 'seguimiento', 1),
(9, 'Tickets', 'M4 4h16v4h-2c-1.1 0-2 .9-2 2s.9 2 2 2h2v4h-2c-1.1 0-2 .9-2 2s.9 2 2 2h2v4H4v-4h2c1.1 0 2-.9 2-2s-.9-2-2-2H4v-4h2c1.1 0 2-.9 2-2s-.9-2-2-2H4V4z', '../MntTickets/', '0', 'tickets', 1),
(10, 'Grupos', 'M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6', '', '0', 'grupos', 1),
(11, 'Evaluaciones', 'M19 3H5c-1.1 0-2 .9-2 2v14l4-4h12c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM6 14l-2-2 1.41-1.41L6 11.17l6.59-6.59L14 6l-8 8z', '', '0', 'evaluaciones', 1),
(12, 'Asistencia / Reportes', 'M19 3H5c-1.1 0-2 .9-2 2v14h2v-4h14v4h2V5c0-1.1-.9-2-2-2zM7 11h2v2H7v-2zm0 4h2v2H7v-2zm4-4h2v2h-2v-2zm0 4h2v2h-2v-2zm4-4h2v2h-2v-2zm0 4h2v2h-2v-2z', '', '0', 'asistencia', 1),
(13, 'Roles', 'M12 2a5 5 0 015 5c0 1.9-1.1 3.6-2.7 4.4.5.6.7 1.3.7 2.1 0 2.2-1.8 4-4 4s-4-1.8-4-4c0-.8.3-1.5.7-2.1C8.1 10.6 7 8.9 7 7a5 5 0 015-5zM4 20c0-2.7 5.3-4 8-4s8 1.3 8 4v2H4v-2z', '', '0', 'roles', 1),
(14, 'Proyectos', 'M10 4l2 2h8c1.1 0 2 .9 2 2v10c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2L2 6c0-1.1.9-2 2-2h6z', '', '0', 'proyectos', 1),
(15, 'Archivos', 'M4 4h16v16H4V4zm4 4v2h8V8H8zm0 4v2h5v-2H8z', '', '0', 'archivos', 1),
(16, 'Imágenes', 'M21 19V5c0-1.1-.9-2-2-2H5C3.9 3 3 3.9 3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z', '', '0', 'imagenes', 1),
(17, 'Descargas', 'M5 20h14v-2H5v2zm7-18l-5 5h3v4h4V7h3l-5-5z', '', '0', 'descargas', 1),
(18, 'Usuarios', 'M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z', '', '0', 'usuarios', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_roles`
--

CREATE TABLE `menu_roles` (
  `id_menu` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu_roles`
--

INSERT INTO `menu_roles` (`id_menu`, `id_rol`) VALUES
(1, 2),
(2, 2),
(3, 2),
(3, 3),
(4, 2),
(4, 3),
(5, 2),
(5, 3),
(5, 4),
(6, 1),
(6, 3),
(6, 4),
(7, 4),
(8, 4),
(9, 1),
(10, 3),
(11, 3),
(12, 3),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `usuario_creacion` varchar(100) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_modificacion` varchar(100) DEFAULT NULL,
  `fecha_modificacion` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_eliminacion` varchar(100) DEFAULT NULL,
  `fecha_eliminacion` timestamp NULL DEFAULT NULL,
  `host_creacion` varchar(100) DEFAULT NULL,
  `host_modificacion` varchar(100) DEFAULT NULL,
  `host_eliminacion` varchar(100) DEFAULT NULL,
  `estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`, `descripcion`, `usuario_creacion`, `fecha_creacion`, `usuario_modificacion`, `fecha_modificacion`, `usuario_eliminacion`, `fecha_eliminacion`, `host_creacion`, `host_modificacion`, `host_eliminacion`, `estado`) VALUES
(1, 'Administrador', 'Administrador de Sistema', '1', '2025-09-08 02:02:05', NULL, '2025-09-08 02:51:04', NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Estudiante', 'Estudiante', '1', '2025-09-08 02:50:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, 'Profesor', 'Profesor', '1', '2025-09-08 02:50:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(4, 'Director', 'Director de Carrera', '1', '2025-09-08 02:50:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `imagen` varchar(500) NOT NULL,
  `cedula` varchar(250) NOT NULL,
  `usuario_creacion` varchar(100) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_modificacion` varchar(100) DEFAULT NULL,
  `fecha_modificacion` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_eliminacion` varchar(100) DEFAULT NULL,
  `fecha_eliminacion` timestamp NULL DEFAULT NULL,
  `host_creacion` varchar(100) DEFAULT NULL,
  `host_modificacion` varchar(100) DEFAULT NULL,
  `host_eliminacion` varchar(100) DEFAULT NULL,
  `estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_rol`, `nombres`, `apellidos`, `correo`, `usuario`, `clave`, `telefono`, `imagen`, `cedula`, `usuario_creacion`, `fecha_creacion`, `usuario_modificacion`, `fecha_modificacion`, `usuario_eliminacion`, `fecha_eliminacion`, `host_creacion`, `host_modificacion`, `host_eliminacion`, `estado`) VALUES
(1, 1, 'Super', 'Admin', 'admin@ug.edu.ec', 'admin', '$2y$10$dWYjYvKpGkXaHcZ1kDPz3ew6kT7sMsl8JzXtci9ch0FUdP6a9pE0m', '0993096567', 'usuario.png', '0604537183', '1', '2025-09-08 02:05:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 1, 'Dennys Marlon', 'Tierra Alvarado', 'dennys.tierraa@ug.edu.ec', '', '$2y$10$PyWE9B1VAmdKxM0zo3lKh.bnlOBcRZ8tuJjeT2pYlelkvcVapKB9e', NULL, 'user-dummy-img.jpg', '0604537183', '', '2025-09-09 02:15:50', NULL, '2025-09-09 02:58:37', NULL, NULL, NULL, NULL, NULL, 1),
(4, 1, 'Veintimilla', 'Veintimilla', 'dereck.veintimilla@ug.edu.ec', 'dveintimilla', '$2y$10$Gep8mDKWg5kA4FNWo7DX7uckgoIFsoKG90wJ4XWk2nJFhzYCS/o4.', NULL, 'user-dummy-img.jpg', '0604537183', '', '2025-09-09 02:24:34', NULL, '2025-09-09 03:04:12', NULL, NULL, NULL, NULL, NULL, 1),
(5, 1, 'Milena Paola', 'Toala Loor', 'milena.toala@ug.edu.ec', 'milena20003106', '$2y$10$jRRUTLSzTzvMiDpkodPtiu2bId676zvxB6HVuLAbTZhqm9QVq9kk6', NULL, 'user-dummy-img.jpg', '0604537183', '', '2025-09-09 03:05:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(6, 2, 'Manuel Reyes', 'Reyes', 'manuel.reyes@ug.ed.ec', 'manuel', '$2y$10$vhhixpoQrAtcTfOEsDhmGuBOCYyFHDZWYnmimzS9ayXDB5MSV3VMK', NULL, 'user-dummy-img.jpg', '0604537183', '', '2025-09-09 04:18:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(7, 3, 'Luis Valente', 'Valente Luis', 'luis@ug.eu.ec', 'luis20', '$2y$10$dN30lE.r1ca1IwN0wnO9WOyID.ueeWCzRdLflsuwaGJRFvvgA11nu', NULL, 'user-dummy-img.jpg', '0604537183', '', '2025-09-09 04:46:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(8, 4, 'maria basueri', 'basruto', 'maria@ug.edu,ec', 'mafer', '$2y$10$09NELVKgcwFf9zuHMOi75.ZI8QxggOn8Xx0cFXVlZN0/G5bC9QPbW', NULL, 'user-dummy-img.jpg', '0604537183', '', '2025-09-09 04:55:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `menu_roles`
--
ALTER TABLE `menu_roles`
  ADD PRIMARY KEY (`id_menu`,`id_rol`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `fk_usuario_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `menu_roles`
--
ALTER TABLE `menu_roles`
  ADD CONSTRAINT `menu_roles_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  ADD CONSTRAINT `menu_roles_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
