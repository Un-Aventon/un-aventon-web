-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-08-2018 a las 02:58:44
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `idCalificacion` int(6) NOT NULL,
  `idCalificador` int(6) NOT NULL,
  `idCalificado` int(6) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `fecha` datetime NOT NULL,
  `calificacion` varchar(6) DEFAULT NULL,
  `comentario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`idCalificacion`, `idCalificador`, `idCalificado`, `tipo`, `idViaje`, `fecha`, `calificacion`, `comentario`) VALUES
(18, 0, 2, '3', 0, '2018-06-27 17:11:45', '-1', 'penalizacion por rechazo de postulacion'),
(19, 0, 2, '3', 0, '2018-06-27 17:16:39', '-1', 'penalizacion por rechazo de postulacion'),
(20, 5, 1, '1', 0, '2018-06-27 00:00:00', NULL, ''),
(21, 0, 7, '3', 0, '2018-06-27 22:34:39', '-1', 'penalizacion por rechazo de postulacion'),
(22, 0, 7, '3', 0, '2018-06-27 22:42:37', '-1', 'penalizacion por rechazo de postulacion'),
(23, 0, 7, '3', 0, '2018-06-27 22:42:37', '0', 'harcodeada'),
(25, 0, 7, '3', 0, '2018-06-27 22:42:37', '0', 'harcodeada'),
(26, 0, 7, '3', 0, '2018-06-27 22:42:37', '0', 'harcodeada'),
(27, 0, 7, '3', 0, '2018-06-27 22:42:37', '1', 'harcodeada'),
(28, 0, 7, '3', 0, '2018-06-27 22:42:37', '1', 'harcodeada'),
(29, 0, 7, '3', 0, '2018-06-27 22:42:37', '1', 'harcodeada'),
(30, 0, 7, '3', 0, '2018-06-27 22:42:37', '1', 'harcodeada'),
(31, 0, 7, '3', 0, '2018-06-27 22:42:37', '1', 'harcodeada'),
(32, 0, 6, '3', 0, '2018-06-27 22:42:37', '1', 'harcodeada'),
(33, 0, 6, '3', 0, '2018-06-27 22:42:37', '1', 'harcodeada'),
(34, 0, 6, '3', 0, '2018-06-27 22:42:37', '1', 'harcodeada'),
(35, 0, 6, '3', 0, '2018-06-27 22:42:37', '0', 'harcodeada'),
(36, 0, 4, '3', 0, '2018-06-27 22:42:37', '-1', 'harcodeada'),
(37, 0, 4, '3', 0, '2018-06-27 22:42:37', '-1', 'harcodeada'),
(38, 0, 7, '3', 0, '2018-06-28 11:02:12', '-1', 'penalizacion por rechazo de postulacion'),
(39, 0, 7, '3', 0, '2018-06-28 11:05:22', '1', 'hola mundo'),
(40, 7, 5, '2', 47, '2018-07-11 07:20:00', NULL, 'sss'),
(41, 7, 5, '2', 48, '2018-07-11 07:20:00', '1', 'asdasdas'),
(42, 7, 4, '2', 53, '2018-07-05 14:00:00', NULL, 'buena onda los chabones'),
(43, 7, 5, '2', 53, '2018-07-05 14:00:00', NULL, 'buena onda los chabones'),
(44, 7, 6, '2', 53, '2018-07-05 14:00:00', NULL, 'buena onda los chabones'),
(45, 7, 4, '2', 54, '2018-06-27 17:29:18', NULL, ''),
(46, 7, 5, '2', 54, '2018-06-27 17:29:18', NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_participacion`
--

CREATE TABLE `estado_participacion` (
  `idEstado` int(1) NOT NULL,
  `color` varchar(14) NOT NULL,
  `estado` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_participacion`
--

INSERT INTO `estado_participacion` (`idEstado`, `color`, `estado`) VALUES
(1, 'primary', 'pendiente'),
(2, 'success', 'aprobada'),
(3, 'warning', 'cancelada por mi'),
(4, 'danger', 'cancelada por el piloto'),
(5, 'secondary', 'terminada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_viaje`
--

CREATE TABLE `estado_viaje` (
  `idEstado` int(1) NOT NULL,
  `color` varchar(14) NOT NULL,
  `estado` varchar(14) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_viaje`
--

INSERT INTO `estado_viaje` (`idEstado`, `color`, `estado`) VALUES
(1, 'success', 'activo'),
(2, 'danger', 'cancelado'),
(3, 'primary', 'terminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `idPago` int(6) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`idPago`, `idViaje`, `fecha`, `hora`, `estado`) VALUES
(1, 1, '2018-06-20', '00:20:06', NULL),
(2, 52, '2018-06-28', '00:00:04', NULL),
(3, 54, '2018-06-27', '00:00:04', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participacion`
--

CREATE TABLE `participacion` (
  `idParticipacion` int(6) NOT NULL,
  `idUsuario` int(6) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `fecha_solicitud` datetime NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `participacion`
--

INSERT INTO `participacion` (`idParticipacion`, `idUsuario`, `idViaje`, `fecha_solicitud`, `estado`) VALUES
(43, 1, 46, '2018-06-27 17:11:29', 1),
(44, 1, 45, '2018-06-27 17:15:31', 1),
(45, 6, 50, '2018-06-27 22:24:52', 1),
(47, 6, 51, '2018-06-28 11:00:03', 1),
(48, 6, 52, '2018-06-28 11:04:07', 2),
(49, 4, 53, '2018-06-28 11:03:03', 5),
(50, 5, 53, '2018-06-28 11:03:03', 5),
(51, 6, 54, '2018-06-28 11:03:03', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `idPregunta` int(6) NOT NULL,
  `idPreguntante` int(6) NOT NULL,
  `idViaje` int(6) NOT NULL,
  `pregunta` varchar(255) NOT NULL,
  `respuesta` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`idPregunta`, `idPreguntante`, `idViaje`, `pregunta`, `respuesta`, `fecha`) VALUES
(1, 5, 50, 'podremos parar a comprar facturas por el camino?', 'no.', '2018-06-27 10:10:04'),
(2, 6, 50, 'Bart, podemos levantar a ese vago?', 'No veo por que no', '2018-06-27 17:07:00'),
(3, 5, 50, 'Podriamos salir 2 horas antes?, es de urgencia', '', '2018-06-27 07:18:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

CREATE TABLE `tipo_vehiculo` (
  `idTipo` int(1) NOT NULL,
  `icono` varchar(140) DEFAULT NULL,
  `tipo` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_vehiculo`
--

INSERT INTO `tipo_vehiculo` (`idTipo`, `icono`, `tipo`) VALUES
(1, '/img/vehiculos/coche.png', 'auto'),
(2, '/img/vehiculos/camioneta.png', 'camioneta'),
(3, '/img/vehiculos/moto.png', 'moto'),
(4, '/img/vehiculos/camion.png', 'camion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUser` int(6) NOT NULL,
  `email` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `estadoUsuario` int(11) NOT NULL DEFAULT '1',
  `recuperarPassword` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUser`, `email`, `clave`, `nombre`, `apellido`, `admin`, `estadoUsuario`, `recuperarPassword`) VALUES
(4, 'user1@mail.com', '12345', 'Valentin', 'Damia', 0, 1, 0),
(5, 'user2@mail.com', '12345', 'jose', 'perez', 0, 1, 0),
(6, 'user3@mail.com', '12345', 'Juana', 'Valle', 0, 1, 0),
(7, 'koumsky@gmail.com', '12345', 'Mariano', 'Martinelli', 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `idVehiculo` int(6) NOT NULL,
  `idPropietario` int(6) NOT NULL,
  `cant_asientos` int(2) NOT NULL,
  `modelo` varchar(30) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `color` varchar(20) NOT NULL,
  `patente` varchar(10) NOT NULL COMMENT 'puede ser patente extrangera',
  `tipo` int(1) DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`idVehiculo`, `idPropietario`, `cant_asientos`, `modelo`, `marca`, `color`, `patente`, `tipo`, `eliminado`) VALUES
(13, 5, 4, '2010', 'ford', 'azul', 'jey001', 1, 0),
(14, 6, 5, '2008', 'Chevrolet', 'negro', 'jio003', 1, 0),
(15, 7, 4, '2018', 'Peugeot', 'negro', 'hjh212', 1, 0),
(16, 4, 3, 'kangoo', 'renault', 'rojo', 'aaa222', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje`
--

CREATE TABLE `viaje` (
  `idViaje` int(6) NOT NULL,
  `idPiloto` int(6) NOT NULL,
  `idVehiculo` int(6) NOT NULL,
  `fecha_publicacion` datetime NOT NULL,
  `fecha_partida` datetime NOT NULL,
  `tiempo_estimado` int(11) NOT NULL DEFAULT '30',
  `origen` varchar(60) CHARACTER SET utf8 NOT NULL,
  `destino` varchar(60) CHARACTER SET utf8 NOT NULL,
  `asientos_disponibles` int(2) NOT NULL,
  `costo` int(7) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  `tipo` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT 'unico'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`idViaje`, `idPiloto`, `idVehiculo`, `fecha_publicacion`, `fecha_partida`, `tiempo_estimado`, `origen`, `destino`, `asientos_disponibles`, `costo`, `estado`, `tipo`) VALUES
(47, 5, 13, '2018-06-27 17:29:18', '2018-06-27 17:31:00', 1, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 3, 100, 3, 'unico'),
(48, 5, 13, '2018-06-27 17:33:49', '2018-12-31 23:59:00', 1, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 1, 100, 3, 'unico'),
(49, 7, 15, '2018-06-27 21:27:40', '2018-06-27 23:30:00', 1, 'la plata,Buenos Aires', 'buenos aires,Buenos Aires', 3, 200, 2, 'unico'),
(50, 7, 15, '2018-06-27 22:05:04', '2018-06-30 13:00:00', 2, 'chascomus,Buenos Aires', 'la plata,Buenos Aires', 1, 500, 1, 'unico'),
(51, 7, 15, '2018-06-27 22:05:04', '2018-07-07 13:00:00', 2, 'chascomus,Buenos Aires', 'la plata,Buenos Aires', 3, 500, 1, 'recurrente'),
(52, 7, 15, '2018-06-28 11:03:03', '2018-07-05 14:00:00', 7, 'nequen,NeuquÃ©n', 'el bolson,RÃ­o Negro', 1, 1200, 1, 'unico'),
(53, 7, 15, '2018-06-28 11:03:03', '2018-07-05 14:00:00', 1, 'Buenos aires, la Plata', 'Buenos aires, Palermo', 3, 3000, 3, 'unico'),
(54, 7, 15, '2018-06-27 17:29:18', '2018-06-27 17:31:00', 1, 'Palermo', 'Tandil', 3, 3000, 3, 'unico');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`idCalificacion`);

--
-- Indices de la tabla `estado_participacion`
--
ALTER TABLE `estado_participacion`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indices de la tabla `estado_viaje`
--
ALTER TABLE `estado_viaje`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idPago`);

--
-- Indices de la tabla `participacion`
--
ALTER TABLE `participacion`
  ADD PRIMARY KEY (`idParticipacion`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`idPregunta`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUser`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`idVehiculo`);

--
-- Indices de la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD PRIMARY KEY (`idViaje`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `idCalificacion` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `estado_participacion`
--
ALTER TABLE `estado_participacion`
  MODIFY `idEstado` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estado_viaje`
--
ALTER TABLE `estado_viaje`
  MODIFY `idEstado` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idPago` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `participacion`
--
ALTER TABLE `participacion`
  MODIFY `idParticipacion` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `idPregunta` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  MODIFY `idTipo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUser` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `idVehiculo` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `viaje`
--
ALTER TABLE `viaje`
  MODIFY `idViaje` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
