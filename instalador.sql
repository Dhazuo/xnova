-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-03-2015 a las 03:25:59
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `xnova`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificios`
--

CREATE TABLE IF NOT EXISTS `edificios` (
  `id_planeta` int(11) NOT NULL,
  `mina_metal` int(11) NOT NULL DEFAULT '0',
  `mina_cristal` int(11) NOT NULL DEFAULT '0',
  `mina_tritio` int(11) NOT NULL DEFAULT '0',
  `planta_energia` int(11) NOT NULL DEFAULT '0',
  `distribuidor` int(1) NOT NULL DEFAULT '1',  
  `fuente_base` int(11) NOT NULL DEFAULT '0',
  `reactor_fusion` int(11) NOT NULL DEFAULT '0',
  `almacen_metal` int(11) NOT NULL DEFAULT '0',
  `almacen_cristal` int(11) NOT NULL DEFAULT '0',
  `almacen_tritio` int(11) NOT NULL DEFAULT '0',
  `almacen_materia` int(11) NOT NULL DEFAULT '1',  
  `satelites` int(255) NOT NULL DEFAULT '0',
  `modulos` int(255) NOT NULL DEFAULT '0',
  `laboratorio` int(20) NOT NULL DEFAULT '0',
  `hangar` int(20) NOT NULL DEFAULT '0',
  `nanobots` int(20) NOT NULL DEFAULT '0',
  `terraforming` int(20) NOT NULL DEFAULT '0',
  `silo` int(20) NOT NULL DEFAULT '0',
  `central` int(20) NOT NULL DEFAULT '0',   
  `centro_rec` int(20) NOT NULL DEFAULT '0', 
  `construccion_tiempo` int(100) NOT NULL DEFAULT '0',
  `cola` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `edificios`
--

INSERT INTO `edificios` (`id_planeta`, `mina_metal`, `mina_cristal`, `mina_tritio`, `planta_energia`, `distribuidor`, `fuente_base`, `reactor_fusion`, `almacen_metal`, `almacen_cristal`, `almacen_tritio`, `almacen_materia`, `satelites`, `modulos`,`laboratorio`,`hangar`,`nanobots`,`terraforming`,`silo`,`central`,`centro_rec`,`construccion_actual`, `construccion_tiempo`, `cola`) VALUES
(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generales`
--

CREATE TABLE IF NOT EXISTS `generales` (
  `ultima_pos` int(11) NOT NULL DEFAULT '1',
  `ultima_act` int(50) NOT NULL,
  `ultimo_sis` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `generales`
--

INSERT INTO `generales` (`ultima_pos`, `ultima_act`, `ultimo_sis`) VALUES
(1, 1426208673, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE IF NOT EXISTS `mensajes` (
`id` int(255) NOT NULL,
  `creador` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `id_recibe` int(11) NOT NULL,
  `tipo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `contenido` longtext COLLATE utf8_unicode_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planetas`
--

CREATE TABLE IF NOT EXISTS `planetas` (
  `id_planeta` int(11) NOT NULL,
  `id_ppal` int(11) NOT NULL,
  `id_dueno` int(11) NOT NULL,
  `ultima_act` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `metal` double(132,8) NOT NULL,
  `cristal` double(132,8) NOT NULL,
  `tritio` double(132,8) NOT NULL,
  `materia` int(20) NOT NULL,
  `campos` int(11) NOT NULL,
  `campos_usados` int(11) NOT NULL,
  `temperatura` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `temp_promd` int(11) NOT NULL,
  `pos` int(2) NOT NULL,
  `sistema` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `planetas`
--

INSERT INTO `planetas` (`id_planeta`, `id_ppal`, `id_dueno`, `ultima_act`, `nombre`, `imagen`, `metal`, `cristal`, `tritio`, `materia`, `campos`, `campos_usados`, `temperatura`, `temp_promd`, `pos`, `sistema`) VALUES
(1, 1, 1, CURRENT_TIMESTAMP, 'Planeta Principal', 'planeta_admin', 1000.00000000, 1000.00000000, 0.00000000, 8000, 180, 0, '15ºC a 26ºC', 21, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `faccion` int(11) NOT NULL DEFAULT '1',
  `alianza` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `puntos` double(132,8) NOT NULL DEFAULT '0',
  `top` int(100) NOT NULL,
  `baneado` int(1) NOT NULL DEFAULT '0',
  `admin` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `email`, `password`, `faccion`, `alianza`, `puntos`, `top`, `baneado`, `admin`) VALUES
(1, 'Admin', 'admin@xnovarev.net', '1646cff54e232c044cc49f060026e6149ad8e0f1', 1, '', 0, 1, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `edificios`
--
ALTER TABLE `edificios`
 ADD PRIMARY KEY (`id_planeta`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planetas`
--
ALTER TABLE `planetas`
 ADD PRIMARY KEY (`id_planeta`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `planetas`
--
ALTER TABLE `planetas`
MODIFY `id_planeta` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
