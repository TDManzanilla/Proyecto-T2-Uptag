-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-03-2025 a las 03:35:22
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
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrativos`
--

CREATE TABLE `administrativos` (
  `id_administrativo` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `administrativos`
--

INSERT INTO `administrativos` (`id_administrativo`, `persona_id`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 2, '2025-03-19 23:53:01', NULL, '1'),
(3, 3, '2025-03-19 23:57:11', NULL, '1'),
(4, 4, '2025-03-25 13:27:54', NULL, '1'),
(5, 5, '2025-03-25 14:42:47', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_instituciones`
--

CREATE TABLE `configuracion_instituciones` (
  `id_config_institucion` int(11) NOT NULL,
  `nombre_institucion` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `celular` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion_instituciones`
--

INSERT INTO `configuracion_instituciones` (`id_config_institucion`, `nombre_institucion`, `logo`, `direccion`, `telefono`, `celular`, `correo`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 'Complejo Escolar Pestalozzi', 'logo.jpg', 'Calle 23 de Enero con Calle Zamora Sector Pantano Abajo', '04141691434', '04262685370', 'uenpestalozzii@gmail.com', '2025-03-19 15:02:10', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id_docente` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id_docente`, `persona_id`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 6, '2025-03-25 14:53:54', '2025-03-25 15:04:06', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id_estudiante` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `nivel_id` int(11) NOT NULL,
  `grado_id` int(11) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id_estudiante`, `persona_id`, `nivel_id`, `grado_id`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 7, 1, 1, '2025-03-26 15:32:16', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestiones`
--

CREATE TABLE `gestiones` (
  `id_gestion` int(11) NOT NULL,
  `gestion` varchar(255) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `gestiones`
--

INSERT INTO `gestiones` (`id_gestion`, `gestion`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, '2024-2025', '2025-03-19 15:02:11', NULL, '1'),
(2, '2021-2022', '2025-03-20 00:41:51', NULL, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grados`
--

CREATE TABLE `grados` (
  `id_grado` int(11) NOT NULL,
  `nivel_id` int(11) NOT NULL,
  `curso` varchar(255) NOT NULL,
  `paralelo` varchar(255) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `grados`
--

INSERT INTO `grados` (`id_grado`, `nivel_id`, `curso`, `paralelo`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 1, 'PRIMER AÑO', 'A', '2025-03-19 15:02:12', NULL, '1'),
(2, 1, 'PRIMER AÑO', 'B', '2025-03-19 21:37:26', NULL, '1'),
(3, 1, 'PRIMER AÑO', 'C', '2025-03-19 21:37:32', NULL, '1'),
(5, 1, 'PRIMER AÑO', 'A', '2025-03-19 21:38:06', NULL, '1'),
(6, 1, 'SEGUNDO AÑO', 'B', '2025-03-19 22:37:01', NULL, '1'),
(7, 1, 'SEGUNDO AÑO', 'C', '2025-03-19 22:37:01', NULL, '1'),
(8, 1, 'SEGUNDO AÑO', 'D', '2025-03-19 22:37:01', NULL, '1'),
(9, 1, 'TERCER AÑO', 'A', '2025-03-19 22:37:01', NULL, '1'),
(10, 1, 'TERCER AÑO', 'B', '2025-03-19 22:37:02', NULL, '1'),
(11, 1, 'TERCER AÑO', 'C', '2025-03-19 22:37:02', NULL, '1'),
(12, 1, 'CUARTO AÑO', 'A', '2025-03-19 22:37:02', NULL, '1'),
(13, 1, 'CUARTO AÑO', 'B', '2025-03-19 22:37:02', NULL, '1'),
(14, 1, 'CUARTO AÑO', 'C', '2025-03-19 22:37:02', NULL, '1'),
(15, 1, 'QUINTO AÑO', 'A', '2025-03-19 22:37:02', NULL, '1'),
(16, 1, 'QUINTO AÑO', 'B', '2025-03-19 22:37:02', NULL, '1'),
(17, 1, 'QUINTO AÑO', 'C', '2025-03-19 22:37:02', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_materia` int(11) NOT NULL,
  `nombre_materia` varchar(255) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materia`, `nombre_materia`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(2, 'ORIENTACION Y CONVIVENCIA', '2025-03-19 22:37:00', NULL, '1'),
(3, 'CASTELLANO', '2025-03-19 22:37:00', NULL, '1'),
(5, 'MATEMÁTICA', '2025-03-19 22:37:00', NULL, '1'),
(6, 'EDUCACION FISICA', '2025-03-19 22:37:00', NULL, '1'),
(7, 'GEOGRAFIA, HISTORIA Y CIUDADANIA', '2025-03-19 22:37:01', NULL, '1'),
(8, 'ARTE Y PATRIMONIO', '2025-03-19 22:37:01', NULL, '1'),
(9, 'CIENCIAS NATURALES', '2025-03-19 22:37:01', NULL, '1'),
(10, 'BIOLOGÍA', '2025-03-19 22:37:01', NULL, '1'),
(11, 'QUÍMICA', '2025-03-19 22:37:01', NULL, '1'),
(12, 'FISICA', '2025-03-19 22:37:01', NULL, '1'),
(13, 'FORMACION PARA LA SOBERANIA', '2025-03-19 22:37:01', NULL, '1'),
(14, 'CIENCIAS DE LA TIERRA', '2025-03-19 22:37:01', NULL, '1'),
(15, 'GRUPO DECREACIÓN, RECREACION Y PARTICIPACION', '2025-03-19 22:37:01', NULL, '1'),
(16, 'BIOQUÍMICA', '2025-03-19 22:37:01', NULL, '1'),
(17, 'PRACTICA SOCIOLABORAL', '2025-03-19 22:37:01', NULL, '1'),
(18, 'PROYECTO DE ECONOMÍA', '2025-03-19 22:37:01', NULL, '1'),
(19, 'TECNOLOGÍA DE LA SALUD', '2025-03-19 22:37:01', NULL, '1'),
(20, 'INGLES', '2025-03-24 17:41:09', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id_nivel` int(11) NOT NULL,
  `gestion_id` int(11) NOT NULL,
  `nivel` varchar(255) NOT NULL,
  `turno` varchar(255) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id_nivel`, `gestion_id`, `nivel`, `turno`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 1, 'SECUNDARIA', 'MAÑANA', '2025-03-19 15:02:12', NULL, '1'),
(2, 1, 'PRIMARIA', 'MAÑANA', '2025-03-25 15:59:35', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `ci` varchar(20) NOT NULL,
  `fecha_nacimiento` varchar(20) NOT NULL,
  `profesion` varchar(50) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `usuario_id`, `nombres`, `apellidos`, `ci`, `fecha_nacimiento`, `profesion`, `direccion`, `celular`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 1, 'Administrador', '', '27811140', '22/11/2000', 'ESTUDIANTE UPTAG', 'Urb Monseñor Iturriza III Etapa Calle 06 Casa #202', '04120868498', '2025-03-19 15:02:06', NULL, '1'),
(2, 2, 'Zuss', 'Medina', '132135589', '2003-11-18', 'Minovia', 'Micasa', '456', '2025-03-19 23:53:01', NULL, '1'),
(3, 3, 'adasda', '1ewdqd', '1213', '1111-11-11', 'dasaf', 'Calle 23 de enero, Sector Pantano Abajo, parroquia Santa Ana, Municipio Miranda, Santa Ana de Coro, Estado Falcón.', '1241', '2025-03-19 23:57:11', NULL, '1'),
(4, 4, 'DALIA M', 'AULAR C', '1176776655', '2025-03-01', 'DIRECTORA', 'AYER', '1188888', '2025-03-25 13:27:54', '2025-03-25 14:01:01', '1'),
(5, 7, 'PEDRO', 'PONCHO', '88888', '1111-11-22', 'ASDSAD', '112ASDFKAPÑFJK', '1155789', '2025-03-25 14:42:47', NULL, '1'),
(6, 10, 'PEDRO POO', 'PONCHO', '121312212', '2333-02-11', '12DASD', 'CALLE 23 DE ENERO CON CALLE ZAMORA, SECTOR PANTANO ABAJO, PARROQUIA SANTA ANA, MUNICIPIO MIRANDA, SANTA ANA DE CORO, ESTADO FALCÓN.', '13313', '2025-03-25 14:53:54', '2025-03-25 15:04:06', '1'),
(7, 11, 'PEDRO', 'TOYO', '1213111', '2025-03-03', 'ESTUDIANTE', '112ASDFKAPÑFJK', '0215546', '2025-03-26 15:32:16', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ppffs`
--

CREATE TABLE `ppffs` (
  `id_ppff` int(11) NOT NULL,
  `estudiantes_id` int(11) NOT NULL,
  `nombres_apellidos_ppff` varchar(255) NOT NULL,
  `ci_ppff` varchar(20) NOT NULL,
  `celular_ppff` varchar(20) NOT NULL,
  `direccion_ppff` varchar(255) NOT NULL,
  `parentesco_ppff` varchar(255) NOT NULL,
  `ref_nombre_apellido_ppff` varchar(255) NOT NULL,
  `ref_celular_ppff` varchar(20) NOT NULL,
  `ref_parentesco_ppff` varchar(255) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ppffs`
--

INSERT INTO `ppffs` (`id_ppff`, `estudiantes_id`, `nombres_apellidos_ppff`, `ci_ppff`, `celular_ppff`, `direccion_ppff`, `parentesco_ppff`, `ref_nombre_apellido_ppff`, `ref_celular_ppff`, `ref_parentesco_ppff`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 1, 'YOBE TOYO', '12314214', '12313456', 'AYER YT HOYAKJFAF', 'ESPOSO', 'YO', '4124124', 'TU', '2025-03-26 15:32:16', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(255) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 'ADMINISTRADOR', '2025-03-19 15:02:03', NULL, '1'),
(2, 'DIRECTIVO', '2025-03-19 15:02:04', NULL, '1'),
(3, 'PERSONAL CDE', '2025-03-19 15:02:04', NULL, '1'),
(4, 'DOCENTE', '2025-03-19 15:02:04', NULL, '1'),
(5, 'JEFE DE CDE', '2025-03-24 17:47:01', NULL, '1'),
(6, 'ESTUDIANTE', '2025-03-25 15:49:33', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `rol_id`, `email`, `password`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 1, 'admin@admin.com', '$2y$10$0tYmdHU9uGCIxY1f90W1EuIm54NQ8axowkxL1WzLbqO2LdNa8m3l2', '2025-03-19 15:02:05', NULL, '1'),
(2, 1, '555a@zuss.es', '$2y$10$PCVsf86lFC8G0/OjBXzPAeRL0cBRZ0oBWYYCywBw1WfOSi9iH0NWO', '2025-03-19 23:53:01', NULL, '1'),
(3, 1, 'aular33dalia@gmail.com', '$2y$10$3RJBMlpXXIJ/rL1tdpvnHOlwORzQt5TVy7Z.gW0SmGszW8KfuMJ7C', '2025-03-19 23:57:11', NULL, '1'),
(4, 3, '55@gmail.com', '$2y$10$FSBjs94tG4jgrAiBtr1/PeZhg47klRufgqnTdcWMVnev0bgQQQPt2', '2025-03-25 13:27:54', '2025-03-25 14:01:01', '1'),
(7, 4, 'adasdas@gmail.com', '$2y$10$eS3ArjBli3fN9lOJfPPGPebI2TQKwWPnbCTPJFcOG2XFJJVnmHmdS', '2025-03-25 14:42:47', NULL, '1'),
(10, 1, 'admin111@admin.com', '$2y$10$jgBWjl2ePZaFqxmFK56pwuZhMaJaqN0F1.GHzhaIFUGCIZRBXEN5S', '2025-03-25 14:53:54', '2025-03-25 15:04:06', '1'),
(11, 6, 'adasdas11@gmail.com', '$2y$10$jer8.QgjFtodWjw.nT.lu.3jxVhq.K.O9sa5.FUP2.Jplsx/7w4F.', '2025-03-26 15:32:16', NULL, '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrativos`
--
ALTER TABLE `administrativos`
  ADD PRIMARY KEY (`id_administrativo`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `configuracion_instituciones`
--
ALTER TABLE `configuracion_instituciones`
  ADD PRIMARY KEY (`id_config_institucion`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id_docente`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD KEY `persona_id` (`persona_id`),
  ADD KEY `nivel_id` (`nivel_id`),
  ADD KEY `grado_id` (`grado_id`);

--
-- Indices de la tabla `gestiones`
--
ALTER TABLE `gestiones`
  ADD PRIMARY KEY (`id_gestion`);

--
-- Indices de la tabla `grados`
--
ALTER TABLE `grados`
  ADD PRIMARY KEY (`id_grado`),
  ADD KEY `nivel_id` (`nivel_id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_materia`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id_nivel`),
  ADD KEY `gestion_id` (`gestion_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `ppffs`
--
ALTER TABLE `ppffs`
  ADD PRIMARY KEY (`id_ppff`),
  ADD KEY `estudiantes_id` (`estudiantes_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrativos`
--
ALTER TABLE `administrativos`
  MODIFY `id_administrativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `configuracion_instituciones`
--
ALTER TABLE `configuracion_instituciones`
  MODIFY `id_config_institucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `gestiones`
--
ALTER TABLE `gestiones`
  MODIFY `id_gestion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `grados`
--
ALTER TABLE `grados`
  MODIFY `id_grado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ppffs`
--
ALTER TABLE `ppffs`
  MODIFY `id_ppff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrativos`
--
ALTER TABLE `administrativos`
  ADD CONSTRAINT `administrativos_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id_persona`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docentes_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id_persona`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id_persona`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `estudiantes_ibfk_2` FOREIGN KEY (`nivel_id`) REFERENCES `niveles` (`id_nivel`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `estudiantes_ibfk_3` FOREIGN KEY (`grado_id`) REFERENCES `grados` (`id_grado`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `grados`
--
ALTER TABLE `grados`
  ADD CONSTRAINT `grados_ibfk_1` FOREIGN KEY (`nivel_id`) REFERENCES `niveles` (`id_nivel`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD CONSTRAINT `niveles_ibfk_1` FOREIGN KEY (`gestion_id`) REFERENCES `gestiones` (`id_gestion`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `ppffs`
--
ALTER TABLE `ppffs`
  ADD CONSTRAINT `ppffs_ibfk_1` FOREIGN KEY (`estudiantes_id`) REFERENCES `estudiantes` (`id_estudiante`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id_rol`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
