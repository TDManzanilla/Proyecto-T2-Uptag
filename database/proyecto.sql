-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-04-2025 a las 18:24:22
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion`
--

CREATE TABLE `asignacion` (
  `id_asignacion` int(11) NOT NULL,
  `grado_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `asignacion`
--

INSERT INTO `asignacion` (`id_asignacion`, `grado_id`, `materia_id`, `docente_id`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 13, 3, 2, '2025-04-26 14:13:58', NULL, '1'),
(2, 13, 4, 2, '2025-04-26 14:13:58', NULL, '1'),
(3, 13, 10, 1, '2025-04-26 15:06:42', NULL, '1'),
(4, 13, 11, 2, '2025-04-26 15:06:42', NULL, '1');

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
(1, 'Complejo Escolar Pestalozzi', 'logo.jpg', 'Calle 23 de Enero con Calle Zamora Sector Pantano Abajo', '04141691434', '04262685370', 'uenpestalozzii@gmail.com', '2025-04-12 19:21:17', '2025-04-20 18:29:01', '1');

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
(1, 2, '2025-04-20 18:19:49', NULL, '0'),
(2, 3, '2025-04-22 08:34:46', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id_estudiante` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `grado_id` int(11) NOT NULL,
  `extra_catedra` varchar(55) DEFAULT NULL,
  `plantel_procedencia` varchar(255) DEFAULT NULL,
  `estatura` varchar(15) DEFAULT NULL,
  `peso` varchar(15) DEFAULT NULL,
  `sexo` varchar(50) DEFAULT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id_estudiante`, `persona_id`, `grado_id`, `extra_catedra`, `plantel_procedencia`, `estatura`, `peso`, `sexo`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 11, 13, NULL, '', '173', '74', NULL, '2025-04-26 16:35:38', NULL, '1');

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
(1, '2024-2025', '2025-04-12 19:21:18', NULL, '1'),
(2, '2026-2027', '2025-04-20 18:42:27', '2025-04-20 18:44:54', '0'),
(4, '2025-2026', '2025-04-20 18:44:35', '2025-04-20 18:44:50', '0');

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
(1, 1, 'PRIMER AÑO', 'A', '2025-04-12 19:21:19', NULL, '1'),
(2, 1, 'PRIMER AÑO', 'B', '2025-04-12 19:21:19', NULL, '1'),
(3, 1, 'PRIMER AÑO', 'C', '2025-04-12 19:21:19', NULL, '1'),
(4, 1, 'SEGUNDO AÑO', 'A', '2025-04-12 19:21:19', NULL, '1'),
(5, 1, 'SEGUNDO AÑO', 'B', '2025-04-12 19:21:20', NULL, '1'),
(6, 1, 'SEGUNDO AÑO', 'C', '2025-04-12 19:21:20', NULL, '1'),
(7, 1, 'SEGUNDO AÑO', 'D', '2025-04-12 19:21:20', NULL, '1'),
(8, 1, 'TERCER AÑO', 'A', '2025-04-12 19:21:20', NULL, '1'),
(9, 1, 'TERCER AÑO', 'B', '2025-04-12 19:21:20', NULL, '1'),
(10, 1, 'TERCER AÑO', 'C', '2025-04-12 19:21:20', NULL, '1'),
(11, 1, 'CUARTO AÑO', 'A', '2025-04-12 19:21:20', NULL, '1'),
(12, 1, 'CUARTO AÑO', 'B', '2025-04-12 19:21:20', NULL, '1'),
(13, 1, 'CUARTO AÑO', 'C', '2025-04-12 19:21:20', NULL, '1'),
(14, 1, 'QUINTO AÑO', 'A', '2025-04-12 19:21:20', NULL, '1'),
(15, 1, 'QUINTO AÑO', 'B', '2025-04-12 19:21:20', NULL, '1'),
(16, 1, 'QUINTO AÑO', 'C', '2025-04-12 19:21:20', NULL, '1');

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
(1, 'ORIENTACION Y CONVIVENCIA', '2025-04-12 19:21:21', NULL, '1'),
(2, 'CASTELLANO', '2025-04-12 19:21:21', NULL, '1'),
(3, 'INGLES', '2025-04-12 19:21:22', NULL, '1'),
(4, 'MATEMÁTICA', '2025-04-12 19:21:22', NULL, '1'),
(5, 'EDUCACION FISICA', '2025-04-12 19:21:22', NULL, '1'),
(6, 'GEOGRAFIA, HISTORIA Y CIUDADANIA', '2025-04-12 19:21:22', NULL, '1'),
(7, 'ARTE Y PATRIMONIO', '2025-04-12 19:21:22', NULL, '1'),
(8, 'CIENCIAS NATURALES', '2025-04-12 19:21:22', NULL, '1'),
(9, 'BIOLOGÍA', '2025-04-12 19:21:23', NULL, '1'),
(10, 'QUÍMICA', '2025-04-12 19:21:23', NULL, '1'),
(11, 'FISICA', '2025-04-12 19:21:23', NULL, '1'),
(12, 'FORMACION PARA LA SOBERANIA', '2025-04-12 19:21:23', NULL, '1'),
(13, 'CIENCIAS DE LA TIERRA', '2025-04-12 19:21:23', NULL, '1'),
(14, 'GRUPO DE CREACIÓN, RECREACION Y PARTICIPACION', '2025-04-12 19:21:23', NULL, '1'),
(15, 'BIOQUÍMICA', '2025-04-12 19:21:23', NULL, '1'),
(16, 'PRACTICA SOCIOLABORAL', '2025-04-12 19:21:23', NULL, '1'),
(17, 'PROYECTO DE ECONOMÍA', '2025-04-12 19:21:23', NULL, '1'),
(18, 'TECNOLOGÍA DE LA SALUD', '2025-04-12 19:21:23', NULL, '1');

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
(1, 1, 'MEDIA GENERAL', 'MAÑANA', '2025-04-12 19:21:19', NULL, '1'),
(2, 2, 'MEDIA GENERAL', 'MAÑANA', '2025-04-20 18:42:27', NULL, '1'),
(4, 4, 'MEDIA GENERAL', 'MAÑANA', '2025-04-20 18:44:36', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id_nota` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `asignacion_id` int(11) NOT NULL,
  `nota_1` int(3) DEFAULT NULL,
  `nota_2` int(3) DEFAULT NULL,
  `nota_3` int(3) DEFAULT NULL,
  `nota_final` int(3) DEFAULT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id_nota`, `estudiante_id`, `asignacion_id`, `nota_1`, `nota_2`, `nota_3`, `nota_final`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(7, 1, 3, 2, 11, 0, 4, NULL, NULL, '111'),
(12, 1, 4, 0, 12, 0, 4, NULL, NULL, '111'),
(13, 1, 1, 0, 0, 1, 1, NULL, NULL, '000'),
(14, 1, 2, 0, 2, 0, 1, NULL, NULL, '100');

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
  `patologia` varchar(50) DEFAULT NULL,
  `alergia` varchar(50) DEFAULT NULL,
  `condicion` varchar(50) DEFAULT NULL,
  `tipo_sangre` varchar(50) DEFAULT NULL,
  `discapacidad` varchar(50) DEFAULT NULL,
  `descripcion_disc` varchar(255) DEFAULT NULL,
  `talla_zapatos` varchar(15) DEFAULT NULL,
  `talla_camisa` varchar(15) DEFAULT NULL,
  `talla_pantalon` varchar(15) DEFAULT NULL,
  `fecha_ingreso_ins` datetime NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `usuario_id`, `nombres`, `apellidos`, `ci`, `fecha_nacimiento`, `profesion`, `direccion`, `celular`, `patologia`, `alergia`, `condicion`, `tipo_sangre`, `discapacidad`, `descripcion_disc`, `talla_zapatos`, `talla_camisa`, `talla_pantalon`, `fecha_ingreso_ins`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 1, 'DALIOBERT ENRIQUE', 'TOYO AULAR', '27811140', '22/11/2000', 'ESTUDIANTE UPTAG', 'Urb Monseñor Iturriza III Etapa Calle 06 Casa #202', '04120868498', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '2025-04-12 19:21:16', NULL, '1'),
(2, 2, 'DOCENTE NO', 'ASIGNADO', '0', '0', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '2025-04-20 18:19:48', NULL, '0'),
(3, 4, 'PEDRO ', 'PEREZ', '1', '1111-11-11', '1', '1', '1', '', 'Polvo', '', '', '', '', '42', 'L', '36', '1111-12-11 00:00:00', '2025-04-22 08:34:46', NULL, '1'),
(11, 15, 'JESUS', 'GRATEROL', '22', '2025-04-02', 'ESTUDIANTE', 'SUCASA', '12', '', '', '', 'A-', '', NULL, '39', 'L', '36', '2025-04-26 00:00:00', '2025-04-26 16:35:38', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ppffs`
--

CREATE TABLE `ppffs` (
  `id_ppff` int(11) NOT NULL,
  `estudiantes_id` int(11) NOT NULL,
  `parentesco_nucleo` int(1) NOT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

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
(1, 'ADMINISTRADOR', '2025-04-12 19:21:14', NULL, '1'),
(2, 'DIRECTIVO', '2025-04-12 19:21:14', NULL, '1'),
(3, 'PERSONAL CDE', '2025-04-12 19:21:14', NULL, '1'),
(4, 'DOCENTE', '2025-04-12 19:21:15', NULL, '1'),
(5, 'ESTUDIANTE', '2025-04-12 19:21:15', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `pregunta_1` varchar(255) DEFAULT NULL,
  `respuesta_1` varchar(255) DEFAULT NULL,
  `pregunta_2` varchar(255) DEFAULT NULL,
  `respuesta_2` varchar(255) DEFAULT NULL,
  `pregunta_3` varchar(255) DEFAULT NULL,
  `respuesta_3` varchar(255) DEFAULT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `rol_id`, `email`, `password`, `pregunta_1`, `respuesta_1`, `pregunta_2`, `respuesta_2`, `pregunta_3`, `respuesta_3`, `fyh_creacion`, `fyh_actualizacion`, `estado`) VALUES
(1, 1, 'admin@admin.com', '$2y$10$0tYmdHU9uGCIxY1f90W1EuIm54NQ8axowkxL1WzLbqO2LdNa8m3l2', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-12 19:21:16', NULL, '1'),
(2, 4, '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-20 18:19:48', NULL, '0'),
(4, 4, '1@1.com', '$2y$10$ply5pczb08QanJLCL1x9yeYok5Wz6H6l1lrmvsefiIWUp7Zy22Ypq', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-22 08:34:46', NULL, '1'),
(15, 5, 'mail@gmail.com', '$2y$10$tGP4qxZd5tkNj80gkToxqe..mMB6Ov93Uw41FHkhBDLc7xzfixtH2', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-26 16:35:38', NULL, '1');

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
-- Indices de la tabla `asignacion`
--
ALTER TABLE `asignacion`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `grado_id` (`grado_id`),
  ADD KEY `materia_id` (`materia_id`),
  ADD KEY `docente_id` (`docente_id`);

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
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `asignacion_id` (`asignacion_id`);

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
  MODIFY `id_administrativo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignacion`
--
ALTER TABLE `asignacion`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `configuracion_instituciones`
--
ALTER TABLE `configuracion_instituciones`
  MODIFY `id_config_institucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `gestiones`
--
ALTER TABLE `gestiones`
  MODIFY `id_gestion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `grados`
--
ALTER TABLE `grados`
  MODIFY `id_grado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ppffs`
--
ALTER TABLE `ppffs`
  MODIFY `id_ppff` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrativos`
--
ALTER TABLE `administrativos`
  ADD CONSTRAINT `administrativos_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id_persona`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignacion`
--
ALTER TABLE `asignacion`
  ADD CONSTRAINT `asignacion_ibfk_1` FOREIGN KEY (`grado_id`) REFERENCES `grados` (`id_grado`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacion_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id_materia`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacion_ibfk_3` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id_docente`) ON DELETE NO ACTION ON UPDATE CASCADE;

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
  ADD CONSTRAINT `estudiantes_ibfk_2` FOREIGN KEY (`grado_id`) REFERENCES `grados` (`id_grado`) ON DELETE NO ACTION ON UPDATE CASCADE;

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
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id_estudiante`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`asignacion_id`) REFERENCES `asignacion` (`id_asignacion`) ON DELETE NO ACTION ON UPDATE CASCADE;

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
